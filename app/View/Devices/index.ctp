
<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="devices ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Devices', 'modelClass' => 'Device', 'options' => array("sr_no" => "Sr No", "name" => "Name", "number" => "Number", "serial" => "Serial", "manual" => "Manual", "sparelist" => "Sparelist", "description" => "Description", "make_type" => "Make Type", "purchase_date" => "Purchase Date", "least_count" => "Least Count", "range" => "Range", "calibration_frequency" => "Calibration Frequency", "required_accuracy" => "Required Accuracy", "default_calibration" => "Default Calibration", "calibration_required" => "Calibration Required", "calibration_inhouse" => "Calibration Inhouse", "calibration_outside" => "Calibration Outside"), 'pluralVar' => 'devices'))); ?>

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
                    <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
                    <th><?php echo $this->Paginator->sort('number', __('Number')); ?></th>
                    <th><?php echo $this->Paginator->sort('serial', __('Serial')); ?></th>
                    <th><?php echo $this->Paginator->sort('manual', __('Manual')); ?></th>
                    <th><?php echo $this->Paginator->sort('sparelist', __('Sparelist')); ?></th>
                    <th><?php echo $this->Paginator->sort('make_type', __('Make Type')); ?></th>
                    <th><?php echo $this->Paginator->sort('supplier_registration_id', __('Supplier Name')); ?></th>
                    <th><?php echo $this->Paginator->sort('purchase_date', __('Purchase Date')); ?></th>
                    <th><?php echo $this->Paginator->sort('maintenance_required', __('Preventive Maintenance Required ?')); ?></th>
                    <th><?php echo $this->Paginator->sort('calibration_required', __('Calibration Required ?')); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php
                    if ($devices) {
                        $x = 0;
                        foreach ($devices as $device):
                ?>
                <tr>
                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $device['Device']['created_by'], 'postVal' => $device['Device']['id'], 'softDelete' => $device['Device']['soft_delete'])); ?>
                    </td>
                    <td><?php echo $device['Device']['name']; ?>&nbsp;</td>
                    <td><?php echo $device['Device']['number']; ?>&nbsp;</td>
                    <td><?php echo $device['Device']['serial']; ?>&nbsp;</td>
                    <td><?php
                            if ($device['Device']['manual'] == 0) {
                                echo "Available";
                            } elseif ($device['Device']['manual'] == 1) {
                                echo "Not Available";
                            } else {
                                ;
                                echo "Not Required";
                            }
                        ?>&nbsp;
                    </td>
                    <td><?php
                            if ($device['Device']['sparelist'] == 0) {
                                echo "Available";
                            } elseif ($device['Device']['sparelist'] == 1) {
                                echo "Not Available";
                            } else {
                                ;
                                echo "Not Required";
                            }
                        ?>&nbsp;
                    </td>
                    <td><?php echo $device['Device']['make_type']; ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($device['SupplierRegistration']['title'], array('controller' => 'supplier_registrations', 'action' => 'view', $device['SupplierRegistration']['id'])); ?>
                    </td>
                    <td><?php echo $device['Device']['purchase_date']; ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($device['Device']['maintenance_required'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign text-success"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($device['Device']['calibration_required'] == 0) { ?>
                            <span class="glyphicon glyphicon-ok-sign text-success"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$device['Device']['prepared_by']]); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$device['Device']['approved_by']]); ?>&nbsp;</td>

                    <td width="60">
                        <?php if ($device['Device']['publish'] == 1) { ?>
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
                <tr><td colspan=32><?php echo __('No results found'); ?></td></tr>
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
<?php echo $this->element('advanced-search', array('postData' => array("name" => "Name", "number" => "Number", "serial" => "Serial", "manual" => "Manual", "sparelist" => "Sparelist", "description" => "Description", "make_type" => "Make Type", "purchase_date" => "Purchase Date", "least_count" => "Least Count", "range" => "Range", "calibration_frequency" => "Calibration Frequency", "required_accuracy" => "Required Accuracy", "default_calibration" => "Default Calibration", "calibration_required" => "Calibration Required", "calibration_inhouse" => "Calibration Inhouse", "calibration_outside" => "Calibration Outside"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "name" => "Name", "number" => "Number", "serial" => "Serial", "manual" => "Manual", "sparelist" => "Sparelist", "description" => "Description", "make_type" => "Make Type", "purchase_date" => "Purchase Date", "least_count" => "Least Count", "range" => "Range", "calibration_frequency" => "Calibration Frequency", "required_accuracy" => "Required Accuracy", "default_calibration" => "Default Calibration", "calibration_required" => "Calibration Required", "calibration_inhouse" => "Calibration Inhouse", "calibration_outside" => "Calibration Outside"))); ?>
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