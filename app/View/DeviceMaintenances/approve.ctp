<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {
            if (
                $(element).attr('name') == 'data[DeviceMaintenance][device_id]' ||
                $(element).attr('name') == 'data[DeviceMaintenance][employee_id]') {
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
        $("#DeviceMaintenanceIntimationSentToDepartmentId").change(function() {
            $.ajax({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_department_employee/" + $('#DeviceMaintenanceIntimationSentToDepartmentId').val(),
                success: function(data, result) {
                    $('#DeviceMaintenanceIntimationSentToEmployeeId').find('option').remove().end().append(data).trigger('chosen:updated');
                }
            });
        });
        $('#DeviceMaintenanceApproveForm').validate({
            rules: {
                "data[DeviceMaintenance][device_id]": {
                    greaterThanZero: true,
                },
                "data[DeviceMaintenance][employee_id]": {
                    greaterThanZero: true,
                },
                "data[DeviceMaintenance][maintenance_performed_date]": {
                    required: true,
                },
                "data[DeviceMaintenance][next_maintanence_date]": {
                    required: true,
                },
            }
        });
            $("#submit-indicator").hide();
            $("#submit_id").click(function(){
             if($('#DeviceMaintenanceApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#DeviceMaintenanceApproveForm").submit();
             }

        });
        $('#DeviceMaintenanceEmployeeId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#DeviceMaintenanceDevicehId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<div id="deviceMaintenances_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="deviceMaintenances form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Approve Device Maintenance'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
            <?php echo $this->Form->create('DeviceMaintenance', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>
            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('device_id'); ?></div>
            </div>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('employee_id', array('label' => __('Person Responsible for Maintenance'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('maintenance_performed_date'); ?></div>
            </div>
            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('findings'); ?></div>
            </div>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('status', array('type' => 'radio', 'options' => array('0' => 'Not in use', '1' => 'In use'), 'default' => $this->request->data['DeviceMaintenance']['status'])); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('next_maintanence_date'); ?></div>
            </div>
            <div id="deviceStatus" class="row">
                <div class="col-md-6"><?php echo $this->Form->input('intimation_sent_to_department_id'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('intimation_sent_to_employee_id'); ?></div>
                <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
                <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
                <?php echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id'])); ?>
            </div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish');
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
<script>
    $("[name*='date']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
    $("[name*='maintenance_performed_date']").datetimepicker('option', 'maxDate', 0);
    $("[name*='next_maintanence_date']").datetimepicker('option', 'minDate', 0);

    $(document).ready(function() {
        if (<?php echo $this->request->data['DeviceMaintenance']['status']; ?> != 0) {
            $("#deviceStatus").hide();
            $("#DeviceMaintenanceIntimationSentToEmployeeId").val(0).trigger('chosen:updated');
            $("#DeviceMaintenanceIntimationSentToDepartmentId").val(0).trigger('chosen:updated');
        }
        $("[name='data[DeviceMaintenance][status]']").change(function() {
            $("#deviceStatus").toggle();
            $("#DeviceMaintenanceIntimationSentToEmployeeId_chosen").width('100%');
            $("#DeviceMaintenanceIntimationSentToDepartmentId_chosen").width('100%');
            $("#DeviceMaintenanceIntimationSentToEmployeeId").val(0).trigger('chosen:updated');
            $("#DeviceMaintenanceIntimationSentToDepartmentId").val(0).trigger('chosen:updated');
        });

    })
</script>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#deviceMaintenances_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>