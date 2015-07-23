<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="notifications ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Notifications', 'modelClass' => 'Notification', 'options' => array("sr_no" => "Sr No", "title" => "Title", "message" => "Message", "start_date" => "Start Date", "end_date" => "End Date", "prepared_by" => "Prepared By", "approved_by" => "Approved By"), 'pluralVar' => 'notifications'))); ?>

        <div class="table-responsive">
            <?php echo $this->Form->create(array('class' => 'no-padding no-margin no-background')); ?>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th><?php echo $this->Paginator->sort('notification_type_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('title'); ?></th>
                    <th><?php echo $this->Paginator->sort('message'); ?></th>
                    <th><?php echo $this->Paginator->sort('start_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('end_date'); ?></th>
                    <th><?php echo $this->Paginator->sort(__('Notified User')); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php if ($notifications) {
                        $x = 0;
                        foreach ($notifications as $notification):
                            if ($notification['Notification']['status'] == 0)
                                echo "<tr class='unread'>";
                            else
                                echo "<tr class='read'>";
                ?>

                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $notification['Notification']['created_by'], 'postVal' => $notification['Notification']['id'], 'softDelete' => $notification['Notification']['soft_delete'])); ?>
                    </td>
                    <td><?php echo $this->Html->link($notification['NotificationType']['name'], array('controller' => 'notification_types', 'action' => 'view', $notification['NotificationType']['id'])); ?>
                    </td>
                    <td><?php echo h($notification['Notification']['title']); ?>&nbsp;</td>
                    <td><?php echo h($notification['Notification']['message']); ?>&nbsp;</td>
                    <td><?php echo h($notification['Notification']['start_date']); ?>&nbsp;</td>
                    <td><?php echo h($notification['Notification']['end_date']); ?>&nbsp;</td>
                    <td><?php echo h($notification['Notification']['NotificationUser']); ?>&nbsp;</td>
                    <td><?php echo h($notification['PreparedBy']['name']); ?>&nbsp;</td>
                    <td><?php echo h($notification['ApprovedBy']['name']); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($notification['Notification']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    </tr>
                    <?php
                        $x++;
                        endforeach;
                        } else {
                    ?>
                    <tr><td colspan=18>No results found</td></tr>
                <?php } ?>
            </table>
            <?php echo $this->Form->end(); ?>
        </div>
        <p>
            <?php
                echo $this->Paginator->options(array(
                    'update' => '#main',
                    'evalScripts' => true,
                    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
                    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
                ));

                echo $this->Paginator->counter(array(
                    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                ));
            ?>
        </p>
        <ul class="pagination">
            <?php
                echo "<li class='previous'>" . $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')) . "</li>";
                echo "<li>" . $this->Paginator->numbers(array('separator' => '')) . "</li>";
                echo "<li class='next'>" . $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')) . "</li>";
            ?>
        </ul>
    </div>
</div>

<?php echo $this->element('export'); ?>
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "message" => "Message", "start_date" => "Start Date", "end_date" => "End Date", "prepared_by" => "Prepared By", "approved_by" => "Approved By"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "message" => "Message", "start_date" => "Start Date", "end_date" => "End Date", "prepared_by" => "Prepared By", "approved_by" => "Approved By"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->element('common'); ?>
<?php echo $this->Js->writeBuffer(); ?>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>