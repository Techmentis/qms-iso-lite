<div id="listOfMeasuringDevicesForCalibrations_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="listOfMeasuringDevicesForCalibrations form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Measuring Devices For Calibration'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo $listOfMeasuringDevicesForCalibration['ListOfMeasuringDevicesForCalibration']['sr_no']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Device'); ?></td>
                    <td>
                        <?php echo $this->Html->link($listOfMeasuringDevicesForCalibration['Device']['name'], array('controller' => 'devices', 'action' => 'view', $listOfMeasuringDevicesForCalibration['Device']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($listOfMeasuringDevicesForCalibration['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($listOfMeasuringDevicesForCalibration['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td><?php if ($listOfMeasuringDevicesForCalibration['ListOfMeasuringDevicesForCalibration']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $listOfMeasuringDevicesForCalibration['ListOfMeasuringDevicesForCalibration']['created_by'], 'recordId' => $listOfMeasuringDevicesForCalibration['ListOfMeasuringDevicesForCalibration']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#listOfMeasuringDevicesForCalibrations_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $listOfMeasuringDevicesForCalibration['ListOfMeasuringDevicesForCalibration']['id'], 'ajax'), array('async' => true, 'update' => '#listOfMeasuringDevicesForCalibrations_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#listOfMeasuringDevicesForCalibrations_ajax'))); ?>
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
