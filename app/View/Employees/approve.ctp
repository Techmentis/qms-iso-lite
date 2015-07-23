<div id="employees_ajax">
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
    <?php echo $this->fetch('script'); ?>

    <script>
        $.validator.setDefaults({
            ignore: null,
            errorPlacement: function(error, element) {

                if ($(element).attr('name') == 'data[Employee][branch_id]')
                    $(element).next().after(error);
                else if ($(element).attr('name') == 'data[Employee][designation_id]') {

                    $(element).next().after(error);
                } else {
                    $(element).after(error);
                }
            }
        });
        $().ready(function() {
            jQuery.validator.addMethod("greaterThanZero", function(value, element) {
                return this.optional(element) || (parseFloat(value) > 0);
            }, "Please select the value");
            jQuery.validator.addMethod("customPhoneNumber", function(value, element) {
                return this.optional(element) || /^[0-9-/()+\s]{6,16}$/i.test(value);
            }, "Please enter valid number");

            $('#EmployeeApproveForm').validate({
                rules: {
                    "data[Employee][office_email]": {
                        required: true,
                        email: true
                    },
                    "data[Employee][branch_id]": {
                        greaterThanZero: true,
                    },
                    "data[Employee][designation_id]": {
                        greaterThanZero: true,
                    },
                    "data[Employee][personal_telephone]": {
                        customPhoneNumber: true,
                    },
                    "data[Employee][mobile]": {
                        customPhoneNumber: true,
                    },
                    "data[Employee][office_telephone]": {
                        customPhoneNumber: true,
                    },
                    "data[Employee][personal_email]": {
                        email: true
                    },
                }

            });
             $("#submit-indicator").hide();
             $("#submit_id").click(function(){
             if($('#EmployeeApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#EmployeeApproveForm").submit();
             }

        });
            $('#EmployeeDesignationId').change(function() {
                if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                    $(this).next().next('label').remove();
                }
            });
            $('#EmployeeBranchId').change(function() {
                if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                    $(this).next().next('label').remove();
                }
            });

            $('#EmployeeOfficeEmail').blur(function() {

                $("#getEmployeeEmail").load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_employee_email/' + encodeURIComponent(this.value) + '/<?php echo $this->data['Employee']['id']; ?>', function(response, status, xhr) {
                    if (response != "") {
                        $('#EmployeeOfficeEmail').val('');
                        $('#EmployeeOfficeEmail').addClass('error');
                    } else {
                        $('#EmployeeOfficeEmail').removeClass('error');
                    }
                });
            });
        });
    </script>
    <div class="nav panel panel-default">
        <div class="employees form col-md-8 panel">
            <h4><?php echo $this->element('breadcrumbs') . __('Approve Employee'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
            <?php echo $this->Form->create('Employee', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>

            <div class="row">
                <fieldset><legend><h5><?php echo __('Mandatory Details'); ?></h5></legend>
                    <div class="col-md-6"><?php echo $this->Form->input('name', array('label' => __('Name'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('employee_number', array('label' => __('Employee Number'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('branch_id', array('style' => 'width:100%', 'label' => __('Branch'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('designation_id', array('style' => 'width:100%', 'label' => __('Designation'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('joining_date', array('label' => __('Joining Date'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('date_of_birth', array('label' => __('Date of Birth'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('office_email', array('label' => __('Office Email'))); ?>
                        <label id="getEmployeeEmail" class="error" style="clear:both" ></label>
                    </div>
                </fieldset>
            </div>

            <div class="row">
                <fieldset><legend><h5><?php echo __('Optional Details'); ?></h5></legend>
                    <div class="col-md-6">
                        <?php
                            $qualifications = explode(",", $this->data['Employee']['qualification']);
                            echo $this->Form->input('qualification', array('name' => 'qualification[]', 'type' => 'select', 'options' => $educations, 'value' => $qualifications, 'multiple', 'label' => __('Qualification')));
                        ?>
                    </div>
                    <div class="col-md-6"><?php echo $this->Form->input('pancard_number', array('label' => __('Pancard Number'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('personal_telephone', array('label' => __('Personal Telephone'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('office_telephone', array('label' => __('Office Telephone'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('mobile', array('label' => __('Mobile'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('personal_email', array('label' => __('Personal Email'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('residence_address', array('label' => __('Residence Address'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('permenant_address', array('label' => __('Permanent Address'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('maritial_status', array('type' => 'select', 'options' => $maritalStatus, 'style' => 'width:100%', 'label' => __('Marital Status'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('driving_license', array('label' => __('Driving License'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('employment_status', array('options' => array('1'=>'Active', '0'=>'Resigned'))); ?></div>
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

<script>
    var myDate = new Date();
    var newDate = new Date(myDate.getFullYear() - 18, myDate.getMonth(), myDate.getDate());
    $("[name*='joining_date']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
    $("[name*='joining_date']").datetimepicker('option', 'maxDate', 0);


    $("[name*='date_of_birth']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
    $("[name*='date_of_birth']").datetimepicker('option', 'maxDate', newDate);
</script>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#employees_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>