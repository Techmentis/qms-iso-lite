<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {
            if (
                    $(element).attr('name') == 'data[Device][employee_id]' ||
                    $(element).attr('name') == 'data[Device][branch_id]' ||
                    $(element).attr('name') == 'data[Device][department_id]') {
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

        $('#DeviceEditForm').validate({
            rules: {
                "data[Device][employee_id]": {
                    greaterThanZero: true,
                },
                "data[Device][branch_id]": {
                    greaterThanZero: true,
                },
                "data[Device][department_id]": {
                    greaterThanZero: true,
                },
            }
        });
        $("#submit-indicator").hide();
	$("#submit_id").click(function(){
             if($('#DeviceEditForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
                 $("#DeviceEditForm").submit();
             }
        });
        $('#DeviceEmployeeId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#DeviceBranchId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#DeviceDepartmentId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });

        if ($('#DeviceMaintenanceRequired').val() === 0)
	    chkMaintenanceReq ();
	$('#DeviceMaintenanceRequired').change(function() {
	    chkMaintenanceReq ();
	});
	if ($('#DeviceCalibrationRequired').val() === 1)
	    chkCalibrationReq ();
	$('#DeviceCalibrationRequired').change(function() {
	    chkCalibrationReq ();
	});
    });

    function chkMaintenanceReq () {
	    if ($('#DeviceMaintenanceRequired').val() == 0) {
		$("#maintenanceDetails").find("input,textarea,button,select").prop("disabled", true);
		$("#maintenanceDetails").find("input,textarea,button,select").val('');
		$("#DeviceMaintenanceFrequency").val('').trigger('chosen:updated');
		$("#DeviceEmployeeId").val('').trigger('chosen:updated');
	    } else{
		$("#maintenanceDetails").find("input,textarea,button,select").prop("disabled", false);
		$("#DeviceMaintenanceFrequency").val('').trigger('chosen:updated');
		$("#DeviceEmployeeId").val('').trigger('chosen:updated');
	    };
	}
    function chkCalibrationReq () {
	    if ($('#DeviceCalibrationRequired').val() == 1) {
		$("#calibrationsDetails").find("input,textarea,button,select").prop("disabled", true);
		$("#calibrationsDetails").find("input,textarea,button,select").val('');
		$("#DeviceCalibrationFrequency").val('').trigger('chosen:updated');
	    } else{
		$("#calibrationsDetails").find("input,textarea,button,select").prop("disabled", false);
		$("#DeviceCalibrationFrequency").val('').trigger('chosen:updated');
	    };
	}
</script>
<?php
    $selectedManual = $this->request->data['Device']['manual'];
    $selectedSparelist = $this->request->data['Device']['sparelist'];
?>
<div id="devices_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="devices form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Edit Device'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
            <?php echo $this->Form->create('Device', array('role' => 'form', 'class' => 'form')); ?>

            <?php echo $this->Form->input('id'); ?>

            <fieldset><legend><h4><?php echo __('Device Details') ?></h4></legend>
                <div class="row">
                    <div class="col-md-6"><?php echo $this->Form->input('name', array('label' => __('Name'))); ?></div>
                    <div class="col-md-3"><?php echo $this->Form->input('number', array('label' => __('Number'))); ?></div>
                    <div class="col-md-3"><?php echo $this->Form->input('serial', array('label' => __('Serial'))); ?></div>
                    <div class="col-md-12"><?php echo $this->Form->input('description', array('label' => __('Description'))); ?></div>
                </div>
            </fieldset>
            <br /><br />
            <fieldset><legend><h4><?php echo __('Preventive Maintenance') ?></h4></legend>
                <div class="row">
                        <div class="col-md-12"><span class="help-text text-small">These details are required only if preventive maintenance is required for this device.</span>                </div>
                        <div class="col-md-3"><?php echo $this->Form->input('maintenance_required', array('options' => array('1' => 'Yes', '0' => 'No'), 'label' => __('Maintenance Required'))); ?></div>
			<div id="maintenanceDetails">
			    <div class="col-md-3"><?php echo $this->Form->input('maintenance_frequency', array('options' => $maintenanceFrequencies, 'label' => __('Maintenance Frequency'))); ?></div>
			    <div class="col-md-6"><?php echo $this->Form->input('employee_id', array('style' => 'width:100%', 'label' => __('Person Responsible for Maintenance'))); ?></div>
			    <div class="col-md-12"><?php echo $this->Form->input('maintenance_details', array('label' => __('Preventive Maintenance Method'))); ?></div>
			</div>
                        <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
                        <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
                        <?php echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id'])); ?>
                </div>
            </fieldset>
            <br /><br />
            <fieldset><legend><h4><?php echo __('Other Details') ?></h4></legend>
                <div class="row">
                        <div class="col-md-3"><?php echo $this->Form->input('make_type', array('label' => __('Make Type'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('supplier_registration_id', array('style' => 'width:100%', 'label' => __('Supplier'))); ?></div>
                        <div class="col-md-3"><?php echo $this->Form->input('purchase_date', array('label' => __('Purchase Date'))); ?></div>

                        <div class="col-md-6"><?php echo $this->Form->input('branch_id', array('style' => 'width:100%', 'label' => __('Branch'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('department_id', array('style' => 'width:100%', 'label' => __('Department'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('manual', array('type' => 'radio', 'default' => $selectedManual, 'options' => array('Available', 'Not Available', 'Not Required'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('sparelist', array('type' => 'radio', 'default' => $selectedSparelist, 'options' => array('Available', 'Not Available', 'Not Required'))); ?></div>
                </div>
            </fieldset>
            <br /><br />
            <fieldset><legend><h4><?php echo __('Device Calibration Details') ?></h4>
                </legend>
                <span class="help-text">These details are required only if calibration is required for this device.</span>
                <div class="row">
                    <div class="col-md-3"><?php echo $this->Form->input('calibration_required', array('options' => array('Yes', 'No'), 'label' => __('Calibration Required'))); ?></div>
		    <div id="calibrationsDetails">
			<div class="col-md-3"><?php echo $this->Form->input('calibration_frequency', array('options' => $calibrationFrequencies, 'label' => __('Calibration Frequency'))); ?></div>
			<div class="col-md-3"><?php echo $this->Form->input('least_count', array('label' => __('Least Count'))); ?></div>
			<div class="col-md-3"><?php echo $this->Form->input('required_accuracy', array('label' => __('Required Accuracy'))); ?></div>
			<div class="col-md-3"><?php echo $this->Form->input('range', array('label' => __('Range'))); ?></div>
			<div class="col-md-3"><?php echo $this->Form->input('default_calibration', array('label' => __('Default Calibration'))); ?></div>
			<div class="col-md-3"><?php echo $this->Form->input('required_calibration', array('label' => __('Required Calibration'))); ?></div>
			<div class="col-md-3"><?php echo $this->Form->input('actual_calibration', array('label' => __('Actual Calibration'))); ?></div>
		    </div>
                    <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
                    <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
                    <?php echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id'])); ?>
                </div>
            </fieldset>

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
    $("[name*='purchase_date']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
    $("[name*='purchase_date']").datetimepicker('option', 'maxDate', 0);
</script>

        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#devices_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>