<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {
            if ($(element).attr('name') == 'data[DocumentAmendmentRecordSheet][branch_id]' ||
                    $(element).attr('name') == 'data[DocumentAmendmentRecordSheet][department_id]' ||
                    $(element).attr('name') == 'data[DocumentAmendmentRecordSheet][employee_id]' ||
                    $(element).attr('name') == 'data[DocumentAmendmentRecordSheet][customer_id]' ||
                    $(element).attr('name') == 'data[DocumentAmendmentRecordSheet][suggestion_form_id]' ||
                    $(element).attr('name') == 'data[DocumentAmendmentRecordSheet][master_list_of_format]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/add_ajax",
                type: 'POST',
                target: '#main',
                beforeSend: function(){
                   $("#submit_id").prop("disabled",true);
                    $("#submit-indicator").show();
                },
                complete: function() {
                   $("#submit_id").removeAttr("disabled");
                   $("#submit-indicator").hide();
                },
                error: function(request, status, error) {
                    //alert(request.responseText);
                    alert('Action failed!');
                }
            });
        }
    });

    $().ready(function() {
        $("#submit-indicator").hide();
        jQuery.validator.addMethod("greaterThanZero", function(value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        $('#DocumentAmendmentRecordSheetAddAjaxForm').validate({
            rules: {
                "data[DocumentAmendmentRecordSheet][master_list_of_format]": {
                    greaterThanZero: true,
                },
                "data[DocumentAmendmentRecordSheet][branch_id]": {
                    greaterThanZero: true,
                },
            }
        });

        $('#DocumentAmendmentRecordSheetBranchId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#DocumentAmendmentRecordSheetDepartmentId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#DocumentAmendmentRecordSheetEmployeeId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#DocumentAmendmentRecordSheetCustomerId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#DocumentAmendmentRecordSheetSuggestionFormId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#DocumentAmendmentRecordSheetOthers').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#DocumentAmendmentRecordSheetMasterListOfFormat').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });

        $('.hidediv').hide();
        $('#Branch').show();
        $("[name='data[DocumentAmendmentRecordSheet][request_from]']").click(function() {
            $val = this.value;
            $('.hidediv').hide();

            $('#DocumentAmendmentRecordSheetBranchId').val(0).trigger('chosen:updated');
            $('#DocumentAmendmentRecordSheetDepartmentId').val(0).trigger('chosen:updated');
            $('#DocumentAmendmentRecordSheetEmployeeId').val(0).trigger('chosen:updated');
            $('#DocumentAmendmentRecordSheetCustomerId').val(0).trigger('chosen:updated');
            $('#DocumentAmendmentRecordSheetSuggestionFormId').val(0).trigger('chosen:updated');
            $('#DocumentAmendmentRecordSheetOthers').val('');

            $('.hidediv').find('select').prop('value', -1);
            $('#' + $val).toggle();
            $('#DocumentAmendmentRecordSheet' + $val + 'Id_chosen').width('100%');

            $('#DocumentAmendmentRecordSheetBranchId').rules('remove');
            $('#DocumentAmendmentRecordSheetDepartmentId').rules('remove');
            $('#DocumentAmendmentRecordSheetEmployeeId').rules('remove');
            $('#DocumentAmendmentRecordSheetCustomerId').rules('remove');
            $('#DocumentAmendmentRecordSheetSuggestionFormId').rules('remove');
            $('#DocumentAmendmentRecordSheetOthers').rules('remove');

            $('#DocumentAmendmentRecordSheetBranchId').next().next('label').remove();
            $('#DocumentAmendmentRecordSheetBranchId').val(0).trigger('chosen:updated');

            if ($val != 'Other') {
                $('#DocumentAmendmentRecordSheet' + $val + 'Id').rules('add', {
                    greaterThanZero: true,
                });
            } else {
                $('#DocumentAmendmentRecordSheetOthers').rules('add', {
                    required: true
                });
            }
        });
    });
</script>

<div id="documentAmendmentRecordSheets_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">
        <div class="documentAmendmentRecordSheets form col-md-8">
            <h4><?php echo __('Add Document Amendment Record Sheet'); ?></h4>
            <?php echo $this->Form->create('DocumentAmendmentRecordSheet', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>

            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('request_from', array('default' => 'Branch', 'options' => array('Branch' => __('Branch'), 'Department' => __('Department'), 'Employee' => __('Employee'), 'Customer' => __('Customer'), 'SuggestionForm' => __('Suggestion'), 'Other' => __('Other')), 'type' => 'radio')); ?></div>
                <div class="col-md-6 hidediv" id="Branch"><?php echo $this->Form->input('branch_id', array('style' => 'width:100%', 'label' => __('Branch'))); ?></div>
                <div class="col-md-6 hidediv" id="Department"><?php echo $this->Form->input('department_id', array('style' => 'width:100%', 'label' => __('Department'))); ?></div>
                <div class="col-md-6 hidediv" id="Employee"><?php echo $this->Form->input('employee_id', array('style' => 'width:100%')); ?></div>
                <div class="col-md-6 hidediv" id="Customer"><?php echo $this->Form->input('customer_id', array('style' => 'width:100%')); ?></div>
                <div class="col-md-6 hidediv" id="SuggestionForm"><?php echo $this->Form->input('suggestion_form_id', array('style' => 'width:100%', 'label' => __('Suggestion Form'))); ?></div>
                <div class="col-md-6 hidediv" id="Other"><?php echo $this->Form->input('others', array('label' => __('Other'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('master_list_of_format'); ?></div>

                <div class="col-md-12"><?php echo $this->Form->input('amendment_details'); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('reason_for_change'); ?></div>
                <div class="col-md-6 hidediv"><?php echo $this->Form->input('meeting_id', array('style' => 'width:100%')); ?></div>
                <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
                <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
                <?php echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id'])); ?>
            </div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#documentAmendmentRecordSheets_ajax', 'async' => 'false','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>