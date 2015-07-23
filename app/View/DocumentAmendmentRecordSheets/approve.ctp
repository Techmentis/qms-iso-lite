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
                    $(element).attr('name') == 'data[DocumentAmendmentRecordSheet][master_list_of_format]' ||
                    $(element).attr('name') == 'data[DocumentAmendmentRecordSheet][suggestion_form_id]') {
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

        $('#DocumentAmendmentRecordSheetApproveForm').validate({
            rules: {
                "data[DocumentAmendmentRecordSheet][master_list_of_format]": {
                    greaterThanZero: true,
                },
            }
        });
        $("#submit-indicator").hide();
    $("#submit_id").click(function(){
             if($('#DocumentAmendmentRecordSheetApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#DocumentAmendmentRecordSheetApproveForm").submit();
             }

        });
        $('#DocumentAmendmentRecordSheetMasterListOfFormat').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>
<?php
    if ($this->data['DocumentAmendmentRecordSheet']['branch_id'] != -1) {
        $request_from = 'Branch';
    } elseif ($this->data['DocumentAmendmentRecordSheet']['department_id'] != -1) {
        $request_from = 'Department';
    } elseif ($this->data['DocumentAmendmentRecordSheet']['employee_id'] != -1) {
        $request_from = 'Employee';
    } elseif ($this->data['DocumentAmendmentRecordSheet']['customer_id'] != -1) {
        $request_from = 'Customer';
    } elseif ($this->data['DocumentAmendmentRecordSheet']['Suggestion_form_id'] != -1) {
        $request_from = 'SuggestionForm';
    } else {
        $request_from = 'Other';
    }
?>
<div id="documentAmendmentRecordSheets_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="documentAmendmentRecordSheets form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Approve Document Amendment Record Sheet'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
            <?php echo $this->Form->create('DocumentAmendmentRecordSheet', array('role' => 'form', 'class' => 'form')); ?>

            <?php echo $this->Form->input('id'); ?>

            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('request_from', array('value' => $request_from, 'options' => array('Branch' => __('Branch'), 'Department' => __('Department'), 'Employee' => __('Employee'), 'Customer' => __('Customer'), 'SuggestionForm' => __('Suggestion'), 'Other' => __('Other')), 'type' => 'radio')); ?></div>
                <div class="col-md-6 hidediv" id="Branch"><?php echo $this->Form->input('branch_id', array('style' => 'width:100%', 'label' => __('Branch'))); ?></div>
                <div class="col-md-6 hidediv" id="Department"><?php echo $this->Form->input('department_id', array('style' => 'width:100%', 'label' => __('Department'))); ?></div>
                <div class="col-md-6 hidediv" id="Employee"><?php echo $this->Form->input('employee_id', array('style' => 'width:100%')); ?></div>
                <div class="col-md-6 hidediv" id="Customer"><?php echo $this->Form->input('customer_id', array('style' => 'width:100%')); ?></div>
                <div class="col-md-6 hidediv" id="SuggestionForm"><?php echo $this->Form->input('suggestion_form_id', array('style' => 'width:100%', 'label' => __('Suggestion Form'))); ?></div>
                <div class="col-md-6 hidediv" id="Other"><?php echo $this->Form->input('others', array('label' => __('Other'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('master_list_of_format'); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('amendment_details'); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('reason_for_change'); ?></div>
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
    $(document).ready(function() {
        $('.hidediv').hide();
        $('#<?php echo $request_from; ?>').show();

        var $request_from = $('input:radio[name="data[DocumentAmendmentRecordSheet][request_from]"]:checked').val();

        if ($request_from != 'Other') {
            $('#DocumentAmendmentRecordSheet' + $request_from + 'Id').rules('add', {
                greaterThanZero: true
            });
            $('#DocumentAmendmentRecordSheet' + $request_from + 'Id').change(function() {
                if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                    $(this).next().next('label').remove();
                }
            });
            $('#DocumentAmendmentRecordSheet' + $request_from + 'Id_chosen').width('100%');
        } else {
            $('#DocumentAmendmentRecordSheetOthers').rules('add', {
                required: true
            });
        }

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

            if ($val != 'Other') {
                $('#DocumentAmendmentRecordSheet' + $val + 'Id').rules('add', {
                    greaterThanZero: true
                });
                $('#DocumentAmendmentRecordSheet' + $val + 'Id').change(function() {
                    if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                        $(this).next().next('label').remove();
                    }
                });
            } else {
                $('#DocumentAmendmentRecordSheetOthers').rules('add', {
                    required: true
                });
            }
        });
    });
</script>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#documentAmendmentRecordSheets_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>