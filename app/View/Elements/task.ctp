<?php
    if (count($tasks)) {
        $i = 0;
        echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min'));
        echo $this->fetch('script');
?>
<script>
$().ready(function() {
    setTimeout(fade_out, 10000);
    function fade_out() {
	$("#flashMessageCustom").fadeOut();
    }
});

//    $.validator.setDefaults({submitHandler: function(form) {
//            $(form).ajaxSubmit({
//                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/task",
//                type: 'POST',
//                target: '#task_main',
//                error: function(request, status, error) {
//                    alert(request.responseText);
//                }
//            });
//        }
//    });
</script>
<div id="tasks_ajax">
    <div id="flashMessageCustom">
	<?php echo $this->Session->flash(); ?>
    </div>
     
                <?php echo $this->Form->create('TaskStatus', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>
       <h3 class="panel-title">
                    <?php echo $this->Html->link(__('Tasks Assigned To You'), array('controller' => 'tasks', 'action' => 'index')); ?>
                    <span class='badge btn-danger'><?php if(isset($count)) echo $count; ?></span>
                </h3> <hr/>
                <table class="table table-responsive checklists">
                    <tr>
                        <th><?php echo __('Tasks'); ?></th>
                        <th><?php echo __('Assigned To'); ?></th>
                        <th><?php echo __('Task Performed?'); ?></th>
                        <th><?php echo __('Comments'); ?></th>
                        <th><?php echo __('Action'); ?>
                            <?php echo $this->Html->link('View All', array('controller' => 'task_statuses'), array('class' => 'pull-right btn btn-xs btn-info')); ?>
                        </th>
                    </tr>
                    <?php foreach ($tasks as $key => $task) {
                        if ($task['TaskStatus'] && $task['TaskStatus']['task_performed'] == 1) {
                    ?>
                    <tr class="alert-success">
                    <?php } else { ?>
                    <tr class="alert-danger">
                    <?php } ?>
                        <td><span class="label label-info"><?php echo $task['Schedule']['name']; ?></span> &nbsp;
                            <?php echo $this->Html->link($task['Task']['name'], array('controller' => 'tasks', 'action' => 'view', $task['Task']['id'])); ?>
                        </td>
                        <td><?php echo $task['User']['name']; ?></td>
                        <td>
                            <?php
                                $task['TaskStatus']['task_performed'] = isset($task['TaskStatus']['task_performed'])? $task['TaskStatus']['task_performed'] : '';
                               $editId = isset($editId)? $editId : '';
                                if ($task['TaskStatus']['task_performed'] > 0 && ($task['TaskStatus']['id'] != $editId)) {
                                    echo $task['TaskStatus']['task_performed'] == 1 ? '<span class="glyphicon glyphicon-ok success"></span>' : '<span class="glyphicon glyphicon-remove danger"></span>';
                                } else {
                                    $i = 1;
                                    echo $this->Form->input('TaskStatus.' . $key . '.task_performed', array('label' => '', 'legend' => false, 'div' => false, 'options' => array('1' => 'Yes', '2' => 'No'), 'type' => 'radio', 'style' => 'float:none', 'value' => $task['TaskStatus']['task_performed']));
                                }
                            ?>
                        </td>
                        <td><?php
                                $task['TaskStatus']['id'] = isset($task['TaskStatus']['id'])? $task['TaskStatus']['id'] : '';
                                $task['TaskStatus']['comments'] = isset($task['TaskStatus']['comments'])? $task['TaskStatus']['comments'] : '';

                                echo $this->Form->input('TaskStatus.' . $key . '.id', array('type' => 'hidden', 'value' => $task['TaskStatus']['id']));
                                if ($task['TaskStatus']['comments'] && ($task['TaskStatus']['id'] != $editId)) {
                                    echo $task['TaskStatus']['comments'];
                                } else {
                                    echo $this->Form->input('TaskStatus.' . $key . '.comments', array('label' => false, 'style' => 'height: 30px', 'value' => $task['TaskStatus']['comments']));
                                }
                                echo $this->Form->input('TaskStatus.' . $key . '.task_id', array('style' => 'width:100%', 'type' => 'hidden', 'value' => $task['Task']['id']));
                                echo $this->Form->input('TaskStatus.' . $key . '.branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id')));
                                echo $this->Form->input('TaskStatus.' . $key . '.departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id')));
                                echo $this->Form->input('TaskStatus.' . $key . '.created_by', array('type' => 'hidden', 'value' => $this->Session->read('User.id')));
                                echo $this->Form->input('TaskStatus.' . $key . '.modified_by', array('type' => 'hidden', 'value' => $this->Session->read('User.id')));
                            ?>
                        </td>
                        <td><?php
                                if ($task['TaskStatus']['id'])
                                echo $this->Js->link('<span class="text-warning glyphicon glyphicon-cog"></span>', array('controller' => 'tasks', 'action' => 'get_task', $task['TaskStatus']['id']), array('escape' => false, 'update' => '#tasks_ajax', 'async' => 'false'))
                            ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan='5'>
                            <?php
                                if ($i == 1)
                                    echo $this->Js->submit(__('Submit'), array('url' => array('controller' => 'tasks', 'action' => 'get_task'), 'div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#tasks_ajax', 'async' => 'false'));
                            ?>
                        </td>
                    </tr>
                </table>
                <?php echo $this->Form->end(); ?>
                <?php echo $this->Js->writeBuffer(); ?>
           
    </div>
<?php } else{ ?>
    <div id="tasks_ajax" style="padding:10px">
          
          <h3 class="panel-title"><?php echo  __("Tasks Assigned To You"); ?>
         <span class='badge btn-danger'><?php if(isset($count)) echo $count; ?></span>
          </h3>
                    <hr/>
   No data Found

    </div>
   <?php
} ?>
