<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function (error, element) {
            if ($(element).attr('name') == 'data[Trainer][trainer_type_id]')
                $(element).next().after(error);
            else {
                $(element).after(error);
            }
        },
    });
    $().ready(function () {
        jQuery.validator.addMethod("greaterThanZero", function (value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");
        $('#TrainerApproveForm').validate(
            {
                rules: {
                    "data[Trainer][personal_email]": {
                        email: true
                    },
                    "data[Trainer][office_email]": {
                        email: true
                    },
                    "data[Trainer][trainer_type_id]": {
                        greaterThanZero: true,
                    },
                    "data[Trainer][personal_telephone]": {
                        number: true
                    },
                    "data[Trainer][office_telephone]": {
                        number: true

                    },
                    "data[Trainer][mobile]": {
                        number: true
                    }
                }
            });
            $("#submit-indicator").hide();
    $("#submit_id").click(function(){
             if($('#TrainerApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#TrainerApproveForm").submit();
             }

        });
        $('#TrainerTrainerTypeId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>


<div id="trainers_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="trainers form col-md-8 panel">
            <h4><?php echo $this->element('breadcrumbs') . __('Approve Trainer'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>

            </h4>
            <?php echo $this->Form->create('Trainer', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>

            <div class="row">
                <fieldset>
                    <div class="col-md-6"><?php echo $this->Form->input('trainer_type_id', __('Trainer Type')); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('name', __('Name')); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('company', __('Company')); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('designation', __('Designation')); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('qualification', __('Qualification')); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('personal_telephone', __('Personal Telephone')); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('office_telephone', __('Office Telephone')); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('mobile', __('Mobile')); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('personal_email', array('label' => __('Personal Email'), 'maxlength' => 50)); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('office_email', array('label' => __('Office Email'), 'maxlength' => 50)); ?></div>
                </fieldset>
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
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#trainers_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>