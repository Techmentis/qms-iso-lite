<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {
            if ($(element).attr('name') == 'data[ListOfMeasuringDevicesForCalibration][device_id]') {
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

        $('#ListOfMeasuringDevicesForCalibrationEditForm').validate({
            rules: {
                "data[ListOfMeasuringDevicesForCalibration][device_id]": {
                    greaterThanZero: true,
                },
            }
        });
	$("#submit-indicator").hide();
        $("#submit_id").click(function(){
             if($('#ListOfMeasuringDevicesForCalibrationEditForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
                 $("#ListOfMeasuringDevicesForCalibrationEditForm").submit();
             }
        });
        $('#ListOfMeasuringDevicesForCalibrationDeviceId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<div id="listOfMeasuringDevicesForCalibrations_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="listOfMeasuringDevicesForCalibrations form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Edit Measuring Devices For Calibration'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>

            </h4>
            <?php echo $this->Form->create('ListOfMeasuringDevicesForCalibration', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('device_id', array('style' => 'width:100%', 'label' => __('Device'))); ?></div>
                <div class="col-md-3"><?php echo $this->Form->input('calibration_inhouse', array('label' => __('Calibration In-House'))); ?></div>
                <div class="col-md-3"><?php echo $this->Form->input('calibration_outside', array('label' => __('Calibration Outside'))); ?></div>
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
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#listOfMeasuringDevicesForCalibrations_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

