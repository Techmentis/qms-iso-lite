<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>
<script>
    $.validator.setDefaults({submitHandler: function(form) {
            $(form).ajaxSubmit({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/employee_kra",
                type: 'POST',
                target: '#main_kra',
                error: function(request, status, error) {
                    //alert(request.responseText);
                    alert('Action failed!');
                }
	    });
        }
    });
    $().ready(function() {
        $('#EmployeeViewForm').validate();
    });
</script>

<div id="kras_ajax">
    <div class="panel panel-default">
        <div class="panel-heading"><h5 class="panel-title">
                <?php echo __('Key Responsibilty Areas'); ?></h5></div>
        <div class="panel-body">
            <?php echo $this->Form->create('Employee', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>
            <table class="table table-responsive">
                <tr>
                    <th>
                        <?php echo __('Title'); ?>
                    </th>
                    <th>
                        <?php echo __('Description', array('type' => 'text')); ?>
                    </th>
                    <th>
                        <?php echo __('Target'); ?>
                    </th>
                    <th style="width: 5%">
                        <?php echo __('Edit'); ?>
                    </th>
                    <th style="width: 5%">
                        <?php echo __('Delete'); ?>
                    </th>
                </tr>
                <?php
                    $key = 0;
                    foreach ($kraLists as $kraList):
                ?>
                <tr>
                    <td>
                        <?php
                            if ($employeeKra != null && ($employeeKra == $kraList['EmployeeKra']['id'])) {
                                echo $this->Form->input('Employee.' . $key . '.title', array('label' => false, 'value' => $kraList['EmployeeKra']['title']));
                            } else {
                                ?>
                                <?php
                                echo $kraList['EmployeeKra']['title'];
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if ($employeeKra != null && ($employeeKra == $kraList['EmployeeKra']['id'])) {
                                echo $this->Form->input('Employee.' . $key . '.description', array('label' => false, 'value' => $kraList['EmployeeKra']['description']));
                            } else {
                                ?>
                                <?php
                                echo $kraList['EmployeeKra']['description'];
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if ($employeeKra != null && ($employeeKra == $kraList['EmployeeKra']['id'])) {
                                echo $this->Form->input('Employee.' . $key . '.target', array('label' => false, 'value' => $kraList['EmployeeKra']['target']));
                                echo $this->Form->input('Employee.' . $key . '.edit', array('type'=>'hidden','label' => false, 'value' => $edit));
                            } else {
                                ?>
                                <?php
                                echo $kraList['EmployeeKra']['target'];
                            }
                        ?>
                    </td>
                    <td style="width: 5%">
                    <?php echo $this->Js->link('', array('controller' => 'Employees', 'action' => 'employee_kra', $kraList['Employee']['id'], $kraList['EmployeeKra']['id'],1), array('class'=>'glyphicon glyphicon-edit','escape' => false, 'update' => '#kras_ajax', 'async' => 'false')); ?>
                    </td>
                    <td style="width: 5%">
                    <?php echo $this->Js->link('', array('controller' => 'Employees', 'action' => 'employee_kra', $kraList['Employee']['id'], $kraList['EmployeeKra']['id'],2), array('class'=>'glyphicon glyphicon-remove text-danger','escape' => false, 'update' => '#kras_ajax', 'async' => 'false')); ?>
                </td>
                </tr>
                    <?php
                        $key++;
                        endforeach;
                    ?>
                <tr>
                    <td style="width: 20%">
                        <?php echo $this->Form->input('Employee.' . $key . '.title', array('label' => false)); ?>
                    </td>
                    <td style="width: 40%">
                        <?php echo $this->Form->input('Employee.' . $key . '.description', array('type' => 'text', 'label' => false)); ?>
                    </td>
                    <td style="width: 10%">
                        <?php echo $this->Form->input('Employee.' . $key . '.target', array('type' => 'text', 'label' => false)); ?>
                    </td>
                    <td style="width: 5%">
                    <?php echo "<span class='glyphicon glyphicon-edit' style=\"opacity: 0.25\"></span>"; ?>
                    </td>
                    <td style="width: 5%">
                    <?php echo "<span class='glyphicon glyphicon-remove' style=\"opacity: 0.25\"></span>"; ?>
		    </td>
		</tr>
            </table>

            <?php echo $this->Form->input('Employee.' . $key . '.employee_id', array('type' => 'hidden', 'value' => $employee['Employee']['id'])); ?>
            <?php echo $this->Form->input('Employee.' . $key . '.target_achieved', array('type' => 'hidden', 'value' => 0)); ?>
            <?php echo $this->Form->input('Employee.' . $key . '.branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
            <?php echo $this->Form->input('Employee.' . $key . '.departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
           
            <?php if(isset($documentDetails)) { 
					echo $this->Form->input('Employee.' . $key . '.master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id'])); 
				}else { 
					echo $this->Form->input('Employee.' . $key . '.master_list_of_format_id', array('type' => 'hidden', 'value' => NULL)); 
				} ?>            
           
            <?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $employee['Employee']['id'])); ?>
            <?php if(isset($edit) && ($edit == 1 || $edit == 2)){echo $this->Form->input('Kraid', array('type' => 'hidden', 'value' => $employeeKra)); }?>
            <?php echo $this->Js->submit(__('Submit'), array('url' => array('controller' => 'Employees', 'action' => 'employee_kra'), 'div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#kras_ajax', 'async' => 'false')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>
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