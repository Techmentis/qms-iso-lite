<div id="deviceMaintenances_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="deviceMaintenances form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Device Maintenance'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Device'); ?></td>
                    <td>
                        <?php echo $this->Html->link($deviceMaintenance['Device']['name'], array('controller' => 'devices', 'action' => 'view', $deviceMaintenance['Device']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Person Responsible for Maintenance'); ?></td>
                    <td>
                        <?php echo $this->Html->link($deviceMaintenance['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $deviceMaintenance['Employee']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Maintenance Performed Date'); ?></td>
                    <td>
                        <?php echo h($deviceMaintenance['DeviceMaintenance']['maintenance_performed_date']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Findings'); ?></td>
                    <td>
                        <?php echo h($deviceMaintenance['DeviceMaintenance']['findings']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Status'); ?></td>
                    <td>
                        <?php echo h($deviceMaintenance['DeviceMaintenance']['status'] ? 'In use' : 'Not in use'); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Intimation Sent To Employee'); ?></td>
                    <td>
                        <?php echo h($deviceMaintenance['IntimationSentToEmployee']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Intimation Sent To Department'); ?></td>
                    <td>
                        <?php echo h($deviceMaintenance['IntimationSentToDepartment']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($deviceMaintenance['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($deviceMaintenance['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($deviceMaintenance['DeviceMaintenance']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $deviceMaintenance['DeviceMaintenance']['created_by'], 'recordId' => $deviceMaintenance['DeviceMaintenance']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#deviceMaintenances_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $deviceMaintenance['DeviceMaintenance']['id'], 'ajax'), array('async' => true, 'update' => '#deviceMaintenances_ajax'))); ?>
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
