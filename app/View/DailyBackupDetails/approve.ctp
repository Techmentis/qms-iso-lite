<div id="dailyBackupDetails_ajax">
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
    <?php echo $this->fetch('script'); ?>

    <script>
        $.validator.setDefaults({
            ignore: null,
            errorPlacement: function(error, element) {
                if ($(element).attr('name') == 'data[DailyBackupDetail][data_back_up_id]' ||
                        $(element).attr('name') == 'data[DailyBackupDetail][employee_id]' ||
                        $(element).attr('name') == 'data[DailyBackupDetail][device_id]' ||
                        $(element).attr('name') == 'data[DailyBackupDetail][list_of_computer_id]') {
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

            $('#DailyBackupDetailApproveForm').validate({
                rules: {
                    "data[DailyBackupDetail][data_back_up_id]": {
                        greaterThanZero: true,
                    },
                    "data[DailyBackupDetail][employee_id]": {
                        greaterThanZero: true,
                    },
                    "data[DailyBackupDetail][device_id]": {
                        greaterThanZero: true,
                    },
                    "data[DailyBackupDetail][list_of_computer_id]": {
                        greaterThanZero: true,
                    },
                }
            });
            $("#submit-indicator").hide();
            $("#submit_id").click(function(){
             if($('#DailyBackupDetailApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#DailyBackupDetailApproveForm").submit();
             }

        });
            $('#DailyBackupDetailDataBackUpId').change(function() {
                if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                    $(this).next().next('label').remove();
                }
            });
            $('#DailyBackupDetailEmployeeId').change(function() {
                if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                    $(this).next().next('label').remove();
                }
            });
            $('#DailyBackupDetailDeviceId').change(function() {
                if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                    $(this).next().next('label').remove();
                }
            });
            $('#DailyBackupDetailListOfComputerId').change(function() {
                if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                    $(this).next().next('label').remove();
                }
            });
            $('#').change(function() {
                if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                    $(this).next().next('label').remove();
                }
            });
        });
    </script>

    <div class="nav panel panel-default">
        <div class="dailyBackupDetails form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Edit Daily Backup Detail'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
            <?php echo $this->Form->create('DailyBackupDetail', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('data_back_up_id', array('style' => 'width:100%', 'label' => __('Data Backup Name'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('employee_id', array('style' => 'width:100%', 'label' => __('Employee'))); ?></div>
                <!--<div class="col-md-6"><?php //echo $this->Form->input('backup_date', array('label' => __('Backup Date'))); ?></div>-->
                <div class="col-md-6"><?php echo $this->Form->input('device_id', array('style' => 'width:100%', 'label' => __('Device Name'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('list_of_computer_id', array('style' => 'width:100%', 'label' => __('Computer Name'))); ?></div>
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
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#dailyBackupDetails_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>