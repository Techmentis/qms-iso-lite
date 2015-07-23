<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="usernamePasswordDetails ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Username Password Details', 'modelClass' => 'UsernamePasswordDetail', 'options' => array("sr_no" => "Sr No", "username" => "Username", "date_of_change" => "Date Of Change"), 'pluralVar' => 'usernamePasswordDetails'))); ?>

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
                    <th><?php echo $this->Paginator->sort('list_of_computer_id', __('Computer Name')); ?></th>
                    <th><?php echo $this->Paginator->sort('username', __('Username')); ?></th>
                    <th><?php echo $this->Paginator->sort('date_of_change', __('Date Of Change')); ?></th>
                    <th><?php echo $this->Paginator->sort('employee_id', __('Employee')); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php if ($usernamePasswordDetails) {
                        $x = 0;
                        foreach ($usernamePasswordDetails as $usernamePasswordDetail):
                ?>
                <tr>

                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $usernamePasswordDetail['UsernamePasswordDetail']['created_by'], 'postVal' => $usernamePasswordDetail['UsernamePasswordDetail']['id'], 'softDelete' => $usernamePasswordDetail['UsernamePasswordDetail']['soft_delete'])); ?></td>
                    <td>
                        <?php echo $this->Html->link($usernamePasswordDetail['ListOfComputer']['name'], array('controller' => 'list_of_computers', 'action' => 'view', $usernamePasswordDetail['ListOfComputer']['id'])); ?>
                    </td>
                    <td><?php echo $usernamePasswordDetail['UsernamePasswordDetail']['username']; ?>&nbsp;</td>
                    <td><?php echo $usernamePasswordDetail['UsernamePasswordDetail']['date_of_change']; ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($usernamePasswordDetail['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $usernamePasswordDetail['Employee']['id'])); ?>
                    </td>
                    <td><?php echo h($usernamePasswordDetail['PreparedBy']['name']); ?>&nbsp;</td>
                    <td><?php echo h($usernamePasswordDetail['ApprovedBy']['name']); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($usernamePasswordDetail['UsernamePasswordDetail']['publish'] == 1) { ?>
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
                <tr><td colspan=17><?php echo __('No results found'); ?></td></tr>
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
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "username" => "Username", "date_of_change" => "Date Of Change"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "username" => "Username", "date_of_change" => "Date Of Change"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->element('common'); ?>
<?php echo $this->Js->writeBuffer(); ?>

<script>
    $.ajaxSetup({
        beforeSend: function () {
            $("#busy-indicator").show();
        },
        complete: function () {
            $("#busy-indicator").hide();
        }
    });
</script>