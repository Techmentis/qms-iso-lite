<div id="housekeepingResponsibilities_ajax">
    <?php echo $this->Session->flash(); ?>
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
        });

        $().ready(function() {
            jQuery.validator.addMethod("greaterThanZero", function(value, element) {
                return this.optional(element) || (parseFloat(value) > 0);
            }, "Please select the value");

            $('#HousekeepingResponsibilityEditForm').validate({
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
            $("#submit-indicator").hide();
            $("#submit_id").click(function(){
             if($('#HousekeepingResponsibilityEditForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
                 $("#HousekeepingResponsibilityEditForm").submit();
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

    <div class="nav panel panel-default">
        <div class="housekeepingResponsibilities form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Edit Housekeeping Responsibility'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
            <?php echo $this->Form->create('HousekeepingResponsibility', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>

            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('housekeeping_checklist_id', array('style' => 'width:100%', 'label' => __('Housekeeping Checklist'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('employee_id', array('style' => 'width:100%', 'label' => __('Employee'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('schedule_id', array('style' => 'width:100%', 'label' => __('Schedule'))); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('description', array('label' => __('Description'))); ?></div>
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
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#housekeepingResponsibilities_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

