<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {
            if ($(element).attr('name') == 'data[HousekeepingResponsibility][housekeeping_checklist_id]' ||
                    $(element).attr('name') == 'data[HousekeepingResponsibility][employee_id]' ||
                    $(element).attr('name') == 'data[HousekeepingResponsibility][schedule_id]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/add_ajax",
                type: 'POST',
                target: '#main',
                beforeSend: function(){
                   $("#submit_id").prop("disabled",true);
                    $("#submit-indicator").show();
                },
                complete: function() {
                   $("#submit_id").removeAttr("disabled");
                   $("#submit-indicator").hide();
                },
                error: function(request, status, error) {
                    //alert(request.responseText);
                    alert('Action failed!');
                }
            });
        }
    });

    $().ready(function() {
        $("#submit-indicator").hide();
        jQuery.validator.addMethod("greaterThanZero", function(value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        $('#HousekeepingResponsibilityAddAjaxForm').validate({
            rules: {
                "data[HousekeepingResponsibility][housekeeping_checklist_id]": {
                    greaterThanZero: true,
                },
                "data[HousekeepingResponsibility][employee_id]": {
                    greaterThanZero: true,
                },
                "data[HousekeepingResponsibility][schedule_id]": {
                    greaterThanZero: true,
                },
            }
        });
        $('#HousekeepingResponsibilityHousekeepingChecklistId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#HousekeepingResponsibilityEmployeeId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#HousekeepingResponsibilityScheduleId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<div id="housekeepingResponsibilities_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">
        <div class="housekeepingResponsibilities form col-md-8">
            <h4><?php echo __('Add Housekeeping Responsibility'); ?></h4>
            <?php echo $this->Form->create('HousekeepingResponsibility', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>

            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('housekeeping_checklist_id', array('style' => 'width:100%', 'label' => __('Housekeeping Checklist'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('employee_id', array('options'=>$PublishedEmployeeList,'style' => 'width:100%', 'label' => __('Employee'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('schedule_id', array('style' => 'width:100%', 'label' => __('Schedule'))); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('description', array('label' => __('Description'))); ?></div>
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
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#housekeepingResponsibilities_ajax', 'async' => 'false','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
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