<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="customerMeetings ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Customer Meetings', 'modelClass' => 'CustomerMeeting', 'options' => array("sr_no" => "Sr No", "action_point" => "Action Point", "details" => "Details", "next_meeting_date" => "Next Meeting Date", "status" => "Status"), 'pluralVar' => 'customerMeetings'))); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('table th a, .pag_list li span a').on('click', function() {
            var url = $(this).attr("href");
            $('#main').load(url);
            return false;
        });
    });
</script>
        <div class="table-responsive">
            <?php echo $this->Form->create(array('class' => 'no-padding no-margin no-background')); ?>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th><?php echo $this->Paginator->sort('customer_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('meeting_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('employee_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('action_point'); ?></th>
                    <th><?php echo $this->Paginator->sort('next_meeting_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('status'); ?></th>
                    <th style="min-width: 150px"><?php echo __('Follow Ups'); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish'); ?></th>
                </tr>
                <?php
                    if ($customerMeetings) {
                        $x = 0;
                        foreach ($customerMeetings as $customerMeeting):
                            $c = $this->requestAction('CustomerMeetings/followup_count/' . $customerMeeting['CustomerMeeting']['followup_id']);
                ?>
                <tr>
                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $customerMeeting['CustomerMeeting']['created_by'], 'postVal' => $customerMeeting['CustomerMeeting']['followup_id'], 'softDelete' => $customerMeeting['CustomerMeeting']['soft_delete'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($customerMeeting['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $customerMeeting['Customer']['id'])); ?>
                    </td>

                    <td>
                        <?php echo $customerMeeting['CustomerMeeting']['meeting_date']; ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($customerMeeting['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $customerMeeting['Employee']['id'])); ?>
                    </td>
                    <td><?php echo h($customerMeeting['CustomerMeeting']['action_point']); ?>&nbsp;</td>
                    <td><?php echo h($customerMeeting['CustomerMeeting']['next_meeting_date']); ?>&nbsp;</td>
                    <td><?php echo h($customerMeeting['CustomerMeeting']['status']); ?></td>
                    <?php
                        if ($customerMeeting['CustomerMeeting']['active_lock'] == 1) {
                            if (($customerMeeting['CustomerMeeting']['created_by'] == $this->Session->read('User.id') || ($this->Session->read('User.is_mr') == true))) {                             ?>
                            <td>
                                <div class="btn-group">
                                    <?php echo $this->Html->link('Add Followup', array('controller' => 'customer_meetings', 'action' => 'add_followups', $customerMeeting['CustomerMeeting']['followup_id']), array('class' => 'btn btn-group btn-sm btn-info', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Total')); ?>
                                    <?php echo $this->Html->link($c, '#', array('id' => 'count', 'class' => 'btn btn-group btn-sm btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Total')); ?><script>$('#count').tooltip();</script>
                                </div>&nbsp;

                            </td>
                    <?php } else { ?>
                            <td>
                                <div class="btn-group">
                                    <?php echo $this->Html->link('Not Allowed', '#', array('class' => 'btn btn-group btn-sm btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Total')); ?>
                                </div>&nbsp;<?php } ?>
                    <?php } else { ?>
                        <td>
                            <div class="btn-group">
                                <?php echo $this->Html->link('Add Followup', array('controller' => 'customer_meetings', 'action' => 'add_followups', $customerMeeting['CustomerMeeting']['id']), array('class' => 'btn btn-group btn-sm btn-info', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Total')); ?>
                                <?php echo $this->Html->link($c, '#', array('id' => 'count', 'class' => 'btn btn-group btn-sm btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'data-original-title' => 'Total')); ?><script>$('#count').tooltip();</script>
                            </div>&nbsp;

                    <?php } ?>
                    </td>
                     <td><?php echo h($PublishedEmployeeList[$customerMeeting['CustomerMeeting']['prepared_by']]); ?>&nbsp;</td>
                     <td><?php echo h($PublishedEmployeeList[$customerMeeting['CustomerMeeting']['approved_by']]); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($customerMeeting['CustomerMeeting']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;
                    </td>
                </tr>
                <?php
                    $x++;
                    endforeach;
                    } else {
                ?>
                <tr><td colspan=19><?php echo __('No results found'); ?></td></tr>
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
<?php echo $this->element('common'); ?>
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "action_point" => "Action Point", "details" => "Details", "next_meeting_date" => "Next Meeting Date", "status" => "Status"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "action_point" => "Action Point", "details" => "Details", "next_meeting_date" => "Next Meeting Date", "status" => "Status"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->Js->writeBuffer(); ?>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>