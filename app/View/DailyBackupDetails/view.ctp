<div id="dailyBackupDetails_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="dailyBackupDetails form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Daily Backup Detail'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Employee'); ?></td>
                    <td>
                        <?php echo $this->Html->link($dailyBackupDetail['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $dailyBackupDetail['Employee']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Backup Date'); ?></td>
                    <td>
                        <?php echo h($dailyBackupDetail['DailyBackupDetail']['backup_date']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Device Name'); ?></td>
                    <td>
                        <?php echo $this->Html->link($dailyBackupDetail['Device']['name'], array('controller' => 'devices', 'action' => 'view', $dailyBackupDetail['Device']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Computer Name'); ?></td>
                    <td>
                        <?php echo $this->Html->link($dailyBackupDetail['ListOfComputer']['id'], array('controller' => 'list_of_computers', 'action' => 'view', $dailyBackupDetail['ListOfComputer']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($dailyBackupDetail['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($dailyBackupDetail['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($dailyBackupDetail['DailyBackupDetail']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;</td>
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $dailyBackupDetail['DailyBackupDetail']['created_by'], 'recordId' => $dailyBackupDetail['DailyBackupDetail']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#dailyBackupDetails_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $dailyBackupDetail['DailyBackupDetail']['id'], 'ajax'), array('async' => true, 'update' => '#dailyBackupDetails_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#dailyBackupDetails_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>
