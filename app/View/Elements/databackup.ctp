<?php
        $i = 0;
        echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min'));
        echo $this->fetch('script');
?>
    <script>
        $.validator.setDefaults({
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/edp",
                    type: 'POST',
                    target: '#main',
                    error: function(request, status, error) {
                        //alert(request.responseText);
			alert('Action failed!');
                    }
                });
            }
        });
    </script>

        <div id="dataBackUps_ajax" class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3><?php echo __('Data Backups'); ?><?php echo $this->Html->link('View All', array('controller' => 'databackup_logbooks'), array('class' => 'pull-right btn btn-sm btn-info')); ?></h3></div>
                <?php echo $this->Form->create('DatabackupLogbook', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>
                <?php echo $this->Session->flash(); ?>
                <table class="table table-responsive checklists">
                    <tr>
                        <th><?php echo __('Data Backup'); ?></th>
                        <th><?php echo __('Assign To'); ?></th>
                        <th><?php echo __('Performed By'); ?></th>
                        <th><?php echo __('Backup Date'); ?></th>
                        <th><?php echo __('Device'); ?></th>
                        <th><?php echo __('List Of Computer'); ?></th>
                        <th><?php echo __('Task Performed?'); ?> </th>
                        <th><?php echo __('Comments'); ?></th>
                        <th><?php echo __('Action'); ?></th>
                    </tr>
                    <?php
			$dailyBackupDetails = isset($dailyBackupDetails) ? $dailyBackupDetails : '';
			if (count($dailyBackupDetails)) {
                            foreach ($dailyBackupDetails as $key => $dailyBackupDetail) {
                            if (isset($dailyBackupDetail['DatabackupLogbook']['task_performed']) && $dailyBackupDetail['DatabackupLogbook']['task_performed'] == 1) {
                    ?>
                    <tr class="alert-success">
                    <?php } else { ?>
                    <tr class="alert-danger">
                    <?php } ?>
                        <td><span class="label label-info"><?php echo $dailyBackupDetail['DataBackUp']['ScheduleName']; ?></span> &nbsp; <?php echo $dailyBackupDetail['DataBackUp']['name']; ?></td>
                        <td><?php echo $dailyBackupDetail['Employee']['name']; ?></td>
                        <td><?php
                                if (isset($dailyBackupDetail['DatabackupLogbook']['employee_id']))
                                    echo $PublishedEmployeeList[$dailyBackupDetail['DatabackupLogbook']['employee_id']];
                            ?>
                        </td>
                        <td><?php
                                if (isset($dailyBackupDetail['DatabackupLogbook']['backup_date'])) {
                                    echo $dailyBackupDetail['DatabackupLogbook']['backup_date'];
                                }
                            ?></td>
                        <td><?php echo $dailyBackupDetail['Device']['name'] ?></td>
                        <td><?php echo $dailyBackupDetail['DatabackupLogbook']['make'] ?></td>
                        <td><?php
                                $dailyBackupDetail['DatabackupLogbook']['task_performed'] = isset($dailyBackupDetail['DatabackupLogbook']['task_performed']) ? $dailyBackupDetail['DatabackupLogbook']['task_performed'] : '';
                                if (isset($dailyBackupDetail['DatabackupLogbook']['task_performed']) && $dailyBackupDetail['DatabackupLogbook']['task_performed'] > 0 && ($dailyBackupDetail['DatabackupLogbook']['id'] != $editId)) {
                                    echo $dailyBackupDetail['DatabackupLogbook']['task_performed'] == 1 ? '<span class="glyphicon glyphicon-ok success"></span>' : '<span class="glyphicon glyphicon-remove danger"></span>';
                                } else {
                                    $i = 1;
                                    echo $this->Form->input('DatabackupLogbook.' . $key . '.task_performed', array('label' => '', 'legend' => false, 'div' => false, 'options' => array('1' => 'Yes', '2' => 'No'), 'type' => 'radio', 'style' => 'float:none', 'value' => $dailyBackupDetail['DatabackupLogbook']['task_performed']));
                                }
                            ?>
                        </td>
                        <td><?php
                                $dailyBackupDetail['DatabackupLogbook']['comments'] = isset($dailyBackupDetail['DatabackupLogbook']['comments']) ? $dailyBackupDetail['DatabackupLogbook']['comments'] : '';
                                $dailyBackupDetail['DatabackupLogbook']['id'] = isset($dailyBackupDetail['DatabackupLogbook']['id']) ? $dailyBackupDetail['DatabackupLogbook']['id'] : '';
                                if ($dailyBackupDetail['DatabackupLogbook']['comments'] && ($dailyBackupDetail['DatabackupLogbook']['id'] != $editId)) {
                                    echo $dailyBackupDetail['DatabackupLogbook']['comments'];
                                } else {
                                    $i = 1;
                                    echo $this->Form->input('DatabackupLogbook.' . $key . '.comments', array('label' => false, 'style' => 'width: 300px; height: 40px', 'value' => $dailyBackupDetail['DatabackupLogbook']['comments']));
                                }
                                echo $this->Form->input('DatabackupLogbook.' . $key . '.id', array('type' => 'hidden', 'value' => $dailyBackupDetail['DatabackupLogbook']['id']));
                                echo $this->Form->input('DatabackupLogbook.' . $key . '.daily_backup_detail_id', array('type' => 'hidden', 'value' => $dailyBackupDetail['DailyBackupDetail']['id']));
                            ?>
                        </td>
                        <td><?php
                                if ($dailyBackupDetail['DatabackupLogbook']['task_performed'] > 0)
                                    echo $this->Js->link('<span class="text-warning glyphicon glyphicon-cog"></span>', array('action' => 'edp', $dailyBackupDetail['DatabackupLogbook']['id']), array('escape' => false, 'update' => '#main', 'async' => 'false'))
                            ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan='9'>
                            <?php
                                if ($i == 1)
                                   echo $this->Js->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#main', 'async' => 'false'));
                            ?>
                        </td>
                    </tr>
		    <?php } else { ?>
			    <tr>
				<td colspan='9'>
				    <h4><span class="glyphicon glyphicon-warning-sign">&nbsp;</span><?php echo __('There are no Data Backups assigned or performed.'); ?></h4>
				</td>
			    </tr>
		    <?php } ?>
                </table>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
            </div>
        </div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>