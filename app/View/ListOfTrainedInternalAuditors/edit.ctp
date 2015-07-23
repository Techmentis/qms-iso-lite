<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {
            if ($(element).attr('name') == 'data[ListOfTrainedInternalAuditor][employee_id]' ||
                    $(element).attr('name') == 'data[ListOfTrainedInternalAuditor][training_id]') {
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

        $('#ListOfTrainedInternalAuditorEditForm').validate({
            rules: {
                "data[ListOfTrainedInternalAuditor][employee_id]": {
                    greaterThanZero: true,
                },
                "data[ListOfTrainedInternalAuditor][training_id]": {
                    greaterThanZero: true,
                },
            }
        });
        $("#submit-indicator").hide();
        $("#submit_id").click(function(){
             if($('#ListOfTrainedInternalAuditorEditForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
                 $("#ListOfTrainedInternalAuditorEditForm").submit();
             }
        });
        $('#ListOfTrainedInternalAuditorEmployeeId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#ListOfTrainedInternalAuditorTrainingId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });

    });
</script>

<div id="listOfTrainedInternalAuditors_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="listOfTrainedInternalAuditors form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Edit List Of Trained Internal Auditor'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
            <?php echo $this->Form->create('ListOfTrainedInternalAuditor', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>

            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('employee_id', array('style' => 'width:100%', 'options' => $PublishedEmployeeList)); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('training_id', array('style' => 'width:100%')); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('note'); ?></div>
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

<script>
    $("[name*='date']").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
    });
</script>

        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#listOfTrainedInternalAuditors_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

