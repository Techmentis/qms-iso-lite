<?php echo $this->element('checkbox-script'); ?>
<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="deviceMaintenances ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Device Maintenances', 'modelClass' => 'DeviceMaintenance', 'options' => array("sr_no" => "Sr No", "maintenance__performed_date" => "Maintenance  Performed Date", "findings" => "Findings", "status" => "Status"), 'pluralVar' => 'deviceMaintenances'))); ?>

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
                    <th><?php echo $this->Paginator->sort('device_id', __('Device')); ?></th>
                    <th><?php echo $this->Paginator->sort('employee_id', __('Person Responsible for Maintenance')); ?></th>
                    <th><?php echo $this->Paginator->sort('maintenance_performed_date', __('Maintenance Performed Date')); ?></th>
                    <th><?php echo $this->Paginator->sort('status', __('Status')); ?></th>
                    <th><?php echo $this->Paginator->sort('intimation_sent_to_employee_id', __('Intimation Sent To Employee')); ?></th>
                    <th><?php echo $this->Paginator->sort('intimation_sent_to_department_id', __('Intimation Sent To Department')); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php
                    if ($deviceMaintenances) {
                        $x = 0;
                        foreach ($deviceMaintenances as $deviceMaintenance):
                ?>
                <tr>
                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $deviceMaintenance['DeviceMaintenance']['created_by'], 'postVal' => $deviceMaintenance['DeviceMaintenance']['id'], 'softDelete' => $deviceMaintenance['DeviceMaintenance']['soft_delete'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($deviceMaintenance['Device']['name'], array('controller' => 'devices', 'action' => 'view', $deviceMaintenance['Device']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($deviceMaintenance['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $deviceMaintenance['Employee']['id'])); ?>
                    </td>
                    <td><?php echo h($deviceMaintenance['DeviceMaintenance']['maintenance_performed_date']); ?>&nbsp;</td>
                    <td><?php echo h($deviceMaintenance['DeviceMaintenance']['status'] ? 'In Use' : 'Not in use'); ?>&nbsp;</td>
                    <td><?php echo h($deviceMaintenance['IntimationSentToEmployee']['name']); ?>&nbsp;</td>
                    <td><?php echo h($deviceMaintenance['IntimationSentToDepartment']['name']); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$deviceMaintenance['DeviceMaintenance']['prepared_by']]); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$deviceMaintenance['DeviceMaintenance']['approved_by']]); ?>&nbsp;</td>

                    <td width="60">
                        <?php if ($deviceMaintenance['DeviceMaintenance']['publish'] == 1) { ?>
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
                    <tr><td colspan='8'><?php echo __('No results found'); ?></td></tr>
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
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "maintenance__performed_date" => "Maintenance  Performed Date", "findings" => "Findings", "status" => "Status"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "maintenance__performed_date" => "Maintenance  Performed Date", "findings" => "Findings", "status" => "Status"))); ?>
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

    $("[name*='date']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
</script>