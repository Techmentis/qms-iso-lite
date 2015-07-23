<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function (error, element) {
            if ($(element).attr('name') == 'data[TrainingNeedIdentification][employee_id]' ||
                $(element).attr('name') == 'data[TrainingNeedIdentification][course_id]' ||
                $(element).attr('name') == 'data[TrainingNeedIdentification][schedule_id]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        },
    });

    $().ready(function () {
        jQuery.validator.addMethod("greaterThanZero", function (value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        $('#TrainingNeedIdentificationApproveForm').validate({
            rules: {
                "data[TrainingNeedIdentification][employee_id]": {
                    greaterThanZero: true,
                },
                "data[TrainingNeedIdentification][course_id]": {
                    greaterThanZero: true,
                },
                "data[TrainingNeedIdentification][schedule_id]": {
                    greaterThanZero: true,
                },
                "": {
                    greaterThanZero: true,
                },
            }
        });
         $("#submit-indicator").hide();
            $("#submit_id").click(function(){
             if($('#TrainingNeedIdentificationApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#TrainingNeedIdentificationApproveForm").submit();
             }

        });
        $('#TrainingNeedIdentificationEmployeeId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#TrainingNeedIdentificationCourseId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#TrainingNeedIdentificationScheduleId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<div id="trainingNeedIdentifications_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="trainingNeedIdentifications form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Approve Training Need Identification'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>

            </h4>
            <?php echo $this->Form->create('TrainingNeedIdentification', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>

            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('employee_id', array('style' => 'width:100%', 'label' => __('Employee'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('course_id', array('style' => 'width:100%', 'label' => __('Course'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('schedule_id', array('style' => 'width:100%', 'label' => __('Schedule'))); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('remarks', array('label' => __('Remarks'))); ?></div>
            </div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#trainingNeedIdentifications_ajax', 'async' => 'false','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#trainingNeedIdentifications_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>