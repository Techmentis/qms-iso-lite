<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/add_ajax",
                type: 'POST',
                target: '#ui-tabs-1',
                error: function(request, status, error) {
                    //alert(request.responseText);
                    alert('Action failed!');
                }
	    });
        }
    });

    $().ready(function() {
        $('#InternalAuditPlanDepartmentAddAjaxForm').validate();
    });
</script>

<div id="internalAuditPlanDepartments_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">

        <h4><?php echo __('Add Internal Audit Plan Department'); ?></h4>
        <?php echo $this->Form->create('InternalAuditPlanDepartment', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>

        <div class="row">
            <div class="col-md-6"><?php echo $this->Form->input('internal_audit_plan_id', array('style' => 'width:100%')); ?></div>
            <div class="col-md-6"><?php echo $this->Form->input('department_id', array('style' => 'width:100%', 'label' => __('Department'))); ?></div>
            <div class="col-md-6"><?php echo $this->Form->input('employee_id', array('options' => $PublishedEmployeeList)); ?></div>
            <div class="col-md-6"><?php echo $this->Form->input('list_of_trained_internal_auditor_id', array('style' => 'width:100%')); ?></div>
            <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
            <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
            <?php echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id'])); ?>
        </div>

        <?php
            if ($showApprovals && $showApprovals['show_panel'] == true) {
                echo $this->element('approval_form');
            } else {
                echo $this->Form->input('publish', array('label' => __('Publish')));
            }
        ?>
        <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#internalAuditPlanDepartments_ajax', 'async' => 'false','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
        <?php echo $this->Form->end(); ?>
        <?php echo $this->Js->writeBuffer(); ?>
    </div>
</div>

<script>
    $("[name*='date']").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
    });
</script>
<script>
    $.ajaxSetup({
        beforeSend: function () {
            $("#busy-indicator").show();
        },
        complete: function () {
            $("#busy-indicator").hide();
        }
    });
</script>