<div id="calibrations_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="calibrations form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Calibration'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($calibration['Calibration']['sr_no']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Device'); ?></td>
                    <td>
                        <?php echo $this->Html->link($calibration['Device']['name'], array('controller' => 'devices', 'action' => 'view', $calibration['Device']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Calibration Date'); ?></td>
                    <td>
                        <?php echo h($calibration['Calibration']['calibration_date']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Measurement For'); ?></td>
                    <td>
                        <?php echo h($calibration['Calibration']['measurement_for']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Least Count'); ?></td>
                    <td>
                        <?php echo h($calibration['Calibration']['least_count']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Required Accuracy'); ?></td>
                    <td>
                        <?php echo h($calibration['Calibration']['required_accuracy']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Range'); ?></td>
                    <td>
                        <?php echo h($calibration['Calibration']['range']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Default Calibration'); ?></td>
                    <td>
                        <?php echo h($calibration['Calibration']['default_calibration']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Calibration Required'); ?></td>
                    <td>
                        <?php echo h($calibration['Calibration']['required_calibration']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Actual Calibration'); ?></td>
                    <td>
                        <?php echo h($calibration['Calibration']['actual_calibration']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Errors'); ?></td>
                    <td>
                        <?php echo h($calibration['Calibration']['errors']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Comments'); ?></td>
                    <td>
                        <?php echo h($calibration['Calibration']['comments']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Next Calibration Date'); ?></td>
                    <td>
                        <?php echo h($calibration['Calibration']['next_calibration_date']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($calibration['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($calibration['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($calibration['Calibration']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;
                    </td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $calibration['Calibration']['created_by'], 'recordId' => $calibration['Calibration']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#calibrations_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $calibration['Calibration']['id'], 'ajax'), array('async' => true, 'update' => '#calibrations_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#calibrations_ajax'))); ?>
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
