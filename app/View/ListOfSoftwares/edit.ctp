<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {
            if ($(element).attr('name') == 'data[ListOfSoftware][software_type_id]' ||
                    $(element).attr('name') == 'data[ListOfSoftware][employee_id]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        },
    });

    $().ready(function() {
        jQuery.validator.addMethod("greaterThanZero", function(value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        $('#ListOfSoftwareEditForm').validate({
            rules: {
                "data[ListOfSoftware][software_type_id]": {
                    greaterThanZero: true,
                },
                "data[ListOfSoftware][employee_id]": {
                    greaterThanZero: true,
                },
            }
        });
         $("#submit-indicator").hide();
        $("#submit_id").click(function(){
             if($('#ListOfSoftwareEditForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
                 $("#ListOfSoftwareEditForm").submit();
             }
        });
        $('#ListOfSoftwareSoftwareTypeId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#ListOfSoftwareEmployeeId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });

        $("input[name='data[ListOfSoftware][backup_required]']").click(function() {
            checkIfBackupRequired();
        });

        function checkIfBackupRequired () {
            var curValue = $("input[name='data[ListOfSoftware][backup_required]']:checked").val() ? true : false;
            if (curValue == false) {
                $("#ListOfSoftwareScheduleId").prop("disabled", true);
                $("#ListOfSoftwareScheduleId").val('').trigger('chosen:updated');
            } else {
                $("#ListOfSoftwareScheduleId").prop("disabled", false);
                var schedule = $("#ListOfSoftwareScheduleId").val();
                $("#ListOfSoftwareScheduleId").val(schedule).trigger('chosen:updated');
            }
        }
        checkIfBackupRequired();
    });
</script>

<div id="listOfSoftwares_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="listOfSoftwares form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Edit List Of Software'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
            <?php echo $this->Form->create('ListOfSoftware', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>

            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('name', array('label' => __('Software Name'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('software_type_id', array('style' => 'width:100%', 'label' => __('Software Type'))); ?></div>
            </div>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('license_key', array('label' => __('License Key'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('storage_device_number', array('label' => __('Storage Device Number'))); ?></div>
            </div>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('software_usage', array('label' => __('Software Usage'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('software_details', array('label' => __('Software Details'))); ?></div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->input('backup_required', array('label' => __('Backup Required'))); ?>
                    <span class="help-text"><?php echo __('Select back up Schedule'); ?></span>
                </div>
                <div class="col-md-6"><?php echo $this->Form->input('schedule_id', array('label' => __('Backup Schedule'))); ?></div>
            </div>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('employee_id', array('type'=>'select','options'=>$PublishedEmployeeList,'style' => 'width:100%', 'label' => __('Employee'))); ?></div>
            </div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>

        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#listOfSoftwares_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

