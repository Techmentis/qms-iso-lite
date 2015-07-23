<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function (error, element) {
            if ($(element).attr('name') == 'data[Calibration][device_id]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        },
    });
    $().ready(function () {
        $("#submit-indicator").hide();
         $("#submit_id").click(function(){
             if($('#CalibrationEditForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
                 $("#CalibrationEditForm").submit();
             }
        });
        jQuery.validator.addMethod("greaterThanZero", function (value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        $('#CalibrationEditForm').validate({
            rules: {
                "data[Calibration][device_id]": {
                    greaterThanZero: true,
                }
            }
        });

        $('#CalibrationDeviceId').change(function () {
            $("#get_details").load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_details/' + $("#CalibrationDeviceId").val())
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<div id="calibrations_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="calibrations form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Edit Calibration'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
            <?php echo $this->Form->create('Calibration', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('device_id', array('style' => 'width:100%', 'label' => __('Device'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('calibration_date', array('label' => __('Calibration Date'))); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('measurement_for', array('label' => __('Measurement For'))); ?></div>
            </div>
            <div class="row">
                <div class="col-md-12" id="get_details"></div>
            </div>
            <div class="row">
                <div class="col-md-4"><?php echo $this->Form->input('least_count', array('label' => __('Least Count'))); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('required_accuracy', array('label' => __('Required Accuracy'))); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('range', array('label' => __('Range'))); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('default_calibration', array('label' => __('Default Calibration'))); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('required_calibration', array('label' => __('Calibration Required'))); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('actual_calibration', array('label' => __('Actual Calibration'))); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('errors', array('label' => __('Errors'))); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('comments', array('label' => __('Comments'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('next_calibration_date', array('label' => __('Next Calibration Date'))); ?></div>
            </div>
            <?php
                echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id')));
                echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id')));
                echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id']));
            ?>
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
    $('#CalibrationCalibrationDate').datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
    $('#CalibrationCalibrationDate').datetimepicker('option', 'maxDate', 0);

    $('#CalibrationNextCalibrationDate').datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
    $('#CalibrationNextCalibrationDate').datetimepicker('option', 'minDate', 0);
</script>

        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#calibrations_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>
