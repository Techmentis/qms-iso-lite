<div id="devices_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="devices form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Device'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo $device['Device']['sr_no']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Name'); ?></td>
                    <td>
                        <?php echo $device['Device']['name']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Number'); ?></td>
                    <td>
                        <?php echo $device['Device']['number']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Serial'); ?></td>
                    <td>
                        <?php echo $device['Device']['serial']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Manual'); ?></td>
                    <td>
                        <?php
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
                </tr>
                <tr><td><?php echo __('Sparelist'); ?></td>
                    <td>
                        <?php
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
                </tr>
                <tr><td><?php echo __('Description'); ?></td>
                    <td>
                        <?php echo $device['Device']['description']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Make Type'); ?></td>
                    <td>
                        <?php echo $device['Device']['make_type']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Supplier'); ?></td>
                    <td>
                        <?php echo $this->Html->link($device['SupplierRegistration']['title'], array('controller' => 'supplier_registrations', 'action' => 'view', $device['SupplierRegistration']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Purchase Date'); ?></td>
                    <td>
                        <?php echo $device['Device']['purchase_date']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Person Responsible for Maintenance'); ?></td>
                    <td>
                        <?php echo $this->Html->link($device['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $device['Employee']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Branch'); ?></td>
                    <td>
                        <?php echo $this->Html->link($device['Branch']['name'], array('controller' => 'branches', 'action' => 'view', $device['Branch']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Department'); ?></td>
                    <td>
                        <?php echo $this->Html->link($device['Department']['name'], array('controller' => 'departments', 'action' => 'view', $device['Department']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Calibration Required'); ?></td>
                    <td>
                        <?php echo ($device['Device']['calibration_required'] == 0) ? 'Yes' : 'No'; ?>
                        &nbsp;
                    </td></tr>

                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($device['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($device['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($device['Device']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>

            <?php if ($device['Device']['calibration_required'] == 0) { ?>
                <table class="table table-responsive">
                    <tr><td colspan="7"><h4><?php echo h($device['Device']['name'] . ' Calibration Details'); ?></h4></td></tr>
                    <tr>
                        <th><?php echo __('Calibration Frequency'); ?></th>
                        <th><?php echo __('Least Count'); ?></th>
                        <th><?php echo __('Required Accuracy'); ?></th>
                        <th><?php echo __('Range'); ?></th>
                        <th><?php echo __('Default Calibration'); ?></th>
                        <th><?php echo __('Required Calibration'); ?></th>
                        <th><?php echo __('Actual Calibration'); ?></th>
                    </tr>

                    <tr>
                        <td><?php
                            $calibrationFrequencies = $this->requestAction('App/get_model_list/Schedule');
                            echo $calibrationFrequencies[$device['Device']['calibration_frequency']];
                            ?>&nbsp;</td>
                        <td><?php echo $device['Device']['least_count']; ?>&nbsp;</td>
                        <td><?php echo $device['Device']['required_accuracy']; ?>&nbsp;</td>
                        <td><?php echo $device['Device']['range']; ?>&nbsp;</td>
                        <td><?php echo $device['Device']['default_calibration']; ?>&nbsp;</td>
                        <td><?php echo $device['Device']['required_calibration']; ?>&nbsp;</td>
                        <td><?php echo $device['Device']['actual_calibration']; ?>&nbsp;</td>
                    </tr>
                    <tr><td colspan="7"></td></tr>
                </table>

            <?php } ?>

            <?php echo $this->element('upload-edit', array('usersId' => $device['Device']['created_by'], 'recordId' => $device['Device']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#devices_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $device['Device']['id'], 'ajax'), array('async' => true, 'update' => '#devices_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#devices_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>
