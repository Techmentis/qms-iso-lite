<?php
    if (count($houseKeepings)) {
        $i = 0;
        echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min'));
        echo $this->fetch('script');
?>
<script>
    $.validator.setDefaults({submitHandler: function(form) {
            $(form).ajaxSubmit({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/personal_admin",
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

    <div id="housekeepings_ajax">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <?php echo $this->Html->link(__('Responsibilities Assigned To You'), array('controller' => 'housekeepings', 'action' => 'index')); ?>
                </h5>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Housekeeping', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>
                <table class="table table-responsive checklists">
                    <tr>
                        <th><?php echo __('Housekeeping Checklist'); ?></th>
                        <th><?php echo __('Task Performed? '); ?></th>
                        <th><?php echo __('Comments'); ?></th>
                        <th><?php echo __('Action'); ?>
                            <?php echo $this->Html->link(__('View All'), array('controller' => 'housekeepings'), array('class' => 'pull-right btn btn-xs btn-info')); ?>
                        </th>
                    </tr>
                    <?php foreach ($houseKeepings as $key => $houseKeeping) {
                        $houseKeeping['Housekeeping']['task_performed'] = isset($houseKeeping['Housekeeping']['task_performed']) ? $houseKeeping['Housekeeping']['task_performed'] : '';
                            if ($houseKeeping['Housekeeping']['task_performed'] == 1) {
                    ?>
                    <tr class="alert-success">
                    <?php } else { ?>
                    <tr class="alert-danger">
                    <?php } ?>
                        <td><span class="label label-info"><?php echo $houseKeeping['Schedule']['name']; ?></span> &nbsp;
                            <?php echo $this->Html->link($houseKeeping['HousekeepingChecklist']['title'], array('controller' => 'housekeeping_responsibilities', 'action' => 'view', $houseKeeping['HousekeepingResponsibility']['id'])); ?>
                        </td>
                        <td><?php
                            if (isset($houseKeeping['Housekeeping']['task_performed']) && $houseKeeping['Housekeeping']['task_performed'] > 0 && ($houseKeeping['Housekeeping']['id'] != $editId)) {
                                echo $houseKeeping['Housekeeping']['task_performed'] == 1 ? '<span class="glyphicon glyphicon-ok success"></span>' : '<span class="glyphicon glyphicon-remove danger"></span>';
                            } else {
                                $i = 1;
                                echo $this->Form->input('Housekeeping.' . $key . '.task_performed', array('label' => '', 'legend' => false, 'div' => false, 'options' => array('1' => 'Yes', '2' => 'No'), 'type' => 'radio', 'style' => 'float:none', 'value' => $houseKeeping['Housekeeping']['task_performed']));
                            }
                            ?>
                        </td>
                        <td><?php
                            $editId = isset($editId) ? $editId : '';
                            $houseKeeping['Housekeeping']['comments'] = isset($houseKeeping['Housekeeping']['comments']) ? $houseKeeping['Housekeeping']['comments'] : '';
                            $houseKeeping['Housekeeping']['id'] = isset($houseKeeping['Housekeeping']['id']) ? $houseKeeping['Housekeeping']['id'] : '';

                            echo $this->Form->input('Housekeeping.' . $key . '.id', array('type' => 'hidden', 'value' => $houseKeeping['Housekeeping']['id']));
                            if ($houseKeeping['Housekeeping']['comments'] && ($houseKeeping['Housekeeping']['id'] != $editId)) {
                                echo $houseKeeping['Housekeeping']['comments'];
                            } else {
                                echo $this->Form->input('Housekeeping.' . $key . '.comments', array('label' => false, 'style' => 'height: 30px', 'value' => $houseKeeping['Housekeeping']['comments']));
                            }
                            echo $this->Form->input('Housekeeping.' . $key . '.housekeeping_responsibility_id', array('style' => 'width:100%', 'type' => 'hidden', 'value' => $houseKeeping['HousekeepingResponsibility']['id']));
                            echo $this->Form->input('Housekeeping.' . $key . '.employee_id', array('style' => 'width:100%', 'type' => 'hidden', 'value' => $houseKeeping['HousekeepingResponsibility']['employee_id']));
                            echo $this->Form->input('Housekeeping.' . $key . '.branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id')));
                            echo $this->Form->input('Housekeeping.' . $key . '.departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id')));
                            echo $this->Form->input('Housekeeping.' . $key . '.created_by', array('type' => 'hidden', 'value' => $this->Session->read('User.id')));
                            echo $this->Form->input('Housekeeping.' . $key . '.modified_by', array('type' => 'hidden', 'value' => $this->Session->read('User.id')));
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($houseKeeping['Housekeeping']['task_performed'] > 0)
                                echo $this->Js->link('<span class="text-warning glyphicon glyphicon-cog"></span>', array('action' => 'personal_admin', $houseKeeping['Housekeeping']['id']), array('escape' => false, 'update' => '#main', 'async' => 'false'))
                                ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan='5'>
                            <?php if ($i == 1)
                                    echo $this->Js->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#main', 'async' => 'false'));
                            ?>
                        </td>
                    </tr>
                </table>
                <?php echo $this->Form->end(); ?>
                <?php echo $this->Js->writeBuffer(); ?>
            </div>
        </div>
    </div>
<?php } ?>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>