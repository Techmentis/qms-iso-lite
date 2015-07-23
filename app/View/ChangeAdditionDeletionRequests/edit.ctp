<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {
            if ($(element).attr('name') == 'data[ChangeAdditionDeletionRequest][prepared_by]' ||
                    $(element).attr('name') == 'data[ChangeAdditionDeletionRequest][approved_by]' ||
                    $(element).attr('name') == 'data[ChangeAdditionDeletionRequest][master_list_of_format]' ||
                    $(element).attr('name') == 'data[ChangeAdditionDeletionRequest][branch_id]' ||
                    $(element).attr('name') == 'data[ChangeAdditionDeletionRequest][department_id]' ||
                    $(element).attr('name') == 'data[ChangeAdditionDeletionRequest][employee_id]' ||
                    $(element).attr('name') == 'data[ChangeAdditionDeletionRequest][suggestion_form_id]' ||
                    $(element).attr('name') == 'data[ChangeAdditionDeletionRequest][customer_id]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        }
    });
    $().ready(function() {
         $("#submit-indicator").hide();
        $("#submit_id").click(function(){
             if($('#ChangeAdditionDeletionRequestEditForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
                 $("#ChangeAdditionDeletionRequestEditForm").submit();
             }

        });
        jQuery.validator.addMethod("greaterThanZero", function(value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        $('#ChangeAdditionDeletionRequestEditForm').validate({
            rules: {
                "data[ChangeAdditionDeletionRequest][master_list_of_format]": {
                    greaterThanZero: true,
                },
                "data[ChangeAdditionDeletionRequest][prepared_by]": {
                    greaterThanZero: true,
                }
            }
        });

        $('#ChangeAdditionDeletionRequestMasterListOfFormat').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#ChangeAdditionDeletionRequestPreparedBy').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });


	functionalityChangeReq ();
	$('#ChangeAdditionDeletionRequestFlinkisoFunctionalityChangeRequired').change(function() {
	    functionalityChangeReq ();
	});
    });

    function functionalityChangeReq () {
	if ($('#ChangeAdditionDeletionRequestFlinkisoFunctionalityChangeRequired').prop('checked') == false) {
	    $("#ChangeAdditionDeletionRequestFlinkisoFunctionalityChangeDetails").prop("disabled", true);
	    $("#ChangeAdditionDeletionRequestFlinkisoFunctionalityChangeDetails").val('');
	} else {
	    $("#ChangeAdditionDeletionRequestFlinkisoFunctionalityChangeDetails").prop("disabled", false);
	}
    }
</script>

<?php
    if (isset($this->data['ChangeAdditionDeletionRequest']['branch_id']) && $this->data['ChangeAdditionDeletionRequest']['branch_id'] != -1) {
        $requestFrom = 'Branch';
    } elseif (isset($this->data['ChangeAdditionDeletionRequest']['department_id']) && $this->data['ChangeAdditionDeletionRequest']['department_id'] != -1) {
        $requestFrom = 'Department';
    } elseif (isset($this->data['ChangeAdditionDeletionRequest']['employee_id']) && $this->data['ChangeAdditionDeletionRequest']['employee_id'] != -1) {
        $requestFrom = 'Employee';
    } elseif (isset($this->data['ChangeAdditionDeletionRequest']['customer_id']) && $this->data['ChangeAdditionDeletionRequest']['customer_id'] != -1) {
        $requestFrom = 'Customer';
    } elseif (isset($this->data['ChangeAdditionDeletionRequest']['suggestion_form_id']) && $this->data['ChangeAdditionDeletionRequest']['suggestion_form_id'] != -1) {
        $requestFrom = 'SuggestionForm';
    } else {
        $requestFrom = 'Other';
    }
?>

<div id="changeAdditionDeletionRequests_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="changeAdditionDeletionRequests form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Edit Change Addition Deletion Request'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>

            </h4>
            <?php echo $this->Form->create('ChangeAdditionDeletionRequest', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>

            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('request_from', array('default' => $requestFrom, 'options' => array('Branch' => __('Branch'), 'Department' => __('Department'), 'Employee' => __('Employee'), 'Customer' => __('Customer'), 'SuggestionForm' => __('Suggestion'), 'Other' => __('Other')), 'type' => 'radio')); ?></div>
                <div class="col-md-6 hidediv" id="Branch"><?php echo $this->Form->input('branch_id', array('style' => 'width:100%', 'label' => __('Branch'))); ?></div>
                <div class="col-md-6 hidediv" id="Department"><?php echo $this->Form->input('department_id', array('style' => 'width:100%', 'label' => __('Department'))); ?></div>
                <div class="col-md-6 hidediv" id="Employee"><?php echo $this->Form->input('employee_id', array('style' => 'width:100%')); ?></div>
                <div class="col-md-6 hidediv" id="Customer"><?php echo $this->Form->input('customer_id', array('style' => 'width:100%')); ?></div>
                <div class="col-md-6 hidediv" id="SuggestionForm"><?php echo $this->Form->input('suggestion_form_id', array('style' => 'width:100%', 'label' => __('Suggestion Form'))); ?></div>
                <div class="col-md-6 hidediv" id="Other">
		    <?php
			$capaCheck = strpos($this->data['ChangeAdditionDeletionRequest']['others'], "CAPA Number: ");
			if($capaCheck == 0){
			    $capaNumber = str_replace("CAPA Number: ", '', $this->data['ChangeAdditionDeletionRequest']['others']);
		    ?>
			<label id="ChangeAdditionDeletionRequestOthers">CAPA Number: </label><?php echo $capaNumber; ?>
		    <?php } else {
			    echo $this->Form->input('others', array('label' => __('Other')));
			}
		     ?>
		</div>
                <div class="col-md-6"><?php echo $this->Form->input('master_list_of_format'); ?></div>


                <div class="col-md-12"><?php echo $this->Form->input('current_document_details'); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('request_details'); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('proposed_changes'); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('reason_for_change'); ?></div>
                <div class="col-md-6"><br /><h5 class="text-info"><?php echo __('Include this in following MR meeting : '); ?></h5></div>
                <div class="col-md-6"><?php echo $this->Form->input('meeting_topic_id', array('label' => __('Select Meeting'),'options'=>$meetings,'selected'=>$this->request->data['ChangeAdditionDeletionRequest']['meeting_id'])); ?></div>
                <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
                <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
            </div>

            <div class="row"><br /></div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><h4><?php echo __('After changes were accepted'); ?></h4></div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('document_change_accepted', array('label' => __('Document Change Accepted'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('meeting_id', array('label' => __('Approved in meeting'))); ?></div>
                        <div class="col-md-12"><hr /></div>
                        <div class="col-md-12">
                            <dl>
                                <dt><?php echo __('Title'); ?></dt><dd><?php echo $this->data['MasterListOfFormat']['title']; ?></dd>
                                <dt><?php echo __('Document Number'); ?></dt><dd><?php echo $this->data['MasterListOfFormat']['document_number']; ?></dd>
                                <dt><?php echo __('Issue Number'); ?></dt><dd><?php echo $this->data['MasterListOfFormat']['issue_number']; ?></dd>
                                <dt><?php echo __('Revision Number'); ?></dt><dd><?php echo $this->data['MasterListOfFormat']['revision_number']; ?></dd>
                                <dt><?php echo __('Revision Date'); ?></dt><dd><?php echo $this->data['MasterListOfFormat']['revision_date']; ?></dd>
                            </dl>
                        </div>
                        <div class="col-md-12"><hr /></div>
                        <?php echo $this->Form->hidden('MasterListOfFormat.id'); ?>
                        <?php echo $this->Form->hidden('MasterListOfFormat.title',array('value'=>$this->data['MasterListOfFormat']['title'])); ?>
                        <?php echo $this->Form->hidden('MasterListOfFormat.document_number'); ?>
                        <?php echo $this->Form->hidden('MasterListOfFormat.issue_number'); ?>
                        <?php echo $this->Form->hidden('MasterListOfFormat.revision_number'); ?>
                        <?php echo $this->Form->hidden('MasterListOfFormat.revision_date'); ?>
                        <?php //echo $this->Form->hidden('MasterListOfFormat.document_details'); ?>
                        <?php //echo $this->Form->hidden('MasterListOfFormat.work_instructions'); ?>
                        <?php echo $this->Form->hidden('MasterListOfFormat.prepared_by'); ?>
                        <?php echo $this->Form->hidden('MasterListOfFormat.approved_by'); ?>
                        <?php echo $this->Form->hidden('MasterListOfFormat.system_table_id', array('value' => $this->data['MasterListOfFormat']['system_table_id'])); ?>
                        <div class="col-md-8"><?php echo $this->Form->input('NewMasterListOfFormat.title', array('value' => $this->data['MasterListOfFormat']['title'])); ?></div>
                        <div class="col-md-4"><?php echo $this->Form->input('NewMasterListOfFormat.document_number', array('value' => $this->data['MasterListOfFormat']['document_number'])); ?></div>
                        <div class="col-md-4"><?php echo $this->Form->input('NewMasterListOfFormat.issue_number', array('value' => $this->data['MasterListOfFormat']['issue_number'])); ?></div>
                        <div class="col-md-4"><?php echo $this->Form->input('NewMasterListOfFormat.revision_number', array('value' => $this->data['MasterListOfFormat']['revision_number']+1)); ?></div>
                        <div class="col-md-4"><?php echo $this->Form->input('NewMasterListOfFormat.revision_date', array('value' => date('Y-m-d'))); ?></div>
                        <div class="col-md-12">
                        <h5>Document Details</h5>
                    		<textarea id="MasterListOfFormatDocumentDetails" name="data[NewMasterListOfFormat][document_details]"><?php echo $this->data['MasterListOfFormat']['document_details'] ?></textarea>
                        </div>
                        <div class="col-md-12">
                    <h5>Work Instructions</h5>
							<textarea id="MasterListOfFormatWorkInstructions" name="data[NewMasterListOfFormat][work_instructions]"><?php echo $this->data['MasterListOfFormat']['work_instructions'] ?></textarea>
						<?php // echo $this->Form->input('work_instructions'); ?></div>


                        <div class="col-md-12"><hr /></div>

                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <?php echo '<strong>' . __('Note : ') . '</strong>' . __('If Document changes required additional database fields or change in functionality, send us the new requirements by adding details below.'); ?>
                            </div>
                        </div>
                        <div class="col-md-12"><?php echo $this->Form->input('flinkiso_functionality_change_required', array('label' => 'FlinkISO functionality change required', 'type' => 'checkbox')); ?></div>
                        <div class="col-md-12">
                            <?php echo $this->Form->input('flinkiso_functionality_change_details', array('label' => false)); ?>
                            <span class="help-text"><?php echo __('Add your new requirement here. If you check "flinkiso functionality change required", then these changes will be sent to FlinkISO customisation team for future review.'); ?></span>
                        </div>
                    </div>
                </div>
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
    $("[name*='date']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');

    $(document).ready(function() {
        $('.hidediv').hide();
        $('#<?php echo $requestFrom; ?>').show();

        var $requestFrom = $('input:radio[name="data[ChangeAdditionDeletionRequest][request_from]"]:checked').val();

        if ($requestFrom != 'Other') {
            $('#ChangeAdditionDeletionRequest' + $requestFrom + 'Id').rules('add', {
                greaterThanZero: true
            });
            $('#ChangeAdditionDeletionRequest' + $requestFrom + 'Id').change(function() {
                if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                    $(this).next().next('label').remove();
                }
            });
        } else {
            $('#ChangeAdditionDeletionRequestOthers').rules('add', {
                required: true
            });
        }

        $("[name='data[ChangeAdditionDeletionRequest][request_from]']").click(function() {
            $val = this.value;
            $('.hidediv').hide();
            $('#ChangeAdditionDeletionRequestBranchId').val(0).trigger('chosen:updated');
            $('#ChangeAdditionDeletionRequestDepartmentId').val(0).trigger('chosen:updated');
            $('#ChangeAdditionDeletionRequestEmployeeId').val(0).trigger('chosen:updated');
            $('#ChangeAdditionDeletionRequestCustomerId').val(0).trigger('chosen:updated');
            $('#ChangeAdditionDeletionRequestSuggestionFormId').val(0).trigger('chosen:updated');
            $('#ChangeAdditionDeletionRequestOthers').val('');

            $('.hidediv').find('select').prop('value', -1);
            $('#' + $val).toggle();
            $('#ChangeAdditionDeletionRequest' + $val + 'Id_chosen').width('100%');

            $('#ChangeAdditionDeletionRequestBranchId').rules('remove');
            $('#ChangeAdditionDeletionRequestDepartmentId').rules('remove');
            $('#ChangeAdditionDeletionRequestEmployeeId').rules('remove');
            $('#ChangeAdditionDeletionRequestCustomerId').rules('remove');
            $('#ChangeAdditionDeletionRequestSuggestionFormId').rules('remove');
            $('#ChangeAdditionDeletionRequestOthers').rules('remove');

            if ($val != 'Other') {
                $('#ChangeAdditionDeletionRequest' + $val + 'Id').rules('add', {
                    greaterThanZero: true
                });
                $('#ChangeAdditionDeletionRequest' + $val + 'Id').change(function() {
                    if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                        $(this).next().next('label').remove();
                    }
                });
            } else {
                $('#ChangeAdditionDeletionRequestOthers').rules('add', {
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
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#changeAdditionDeletionRequests_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>
<?php echo $this->Html->script(array('ckeditor/ckeditor')); ?>
<script type="text/javascript">
    CKEDITOR.replace('MasterListOfFormatDocumentDetails', {toolbar: [
            ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'],
            {name: 'insert', items: ['Table', 'HorizontalRule', 'SpecialChar', 'PageBreak']},
            {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
            {name: 'document', items: ['Preview', '-', 'Templates']},
            '/',
            {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']},
            {name: 'basicstyles', items: ['Bold', 'Italic']},
            {name: 'styles', items: ['Format', 'FontSize']},
            {name: 'colors', items: ['TextColor', 'BGColor']},
        ]
    });

    CKEDITOR.replace('MasterListOfFormatWorkInstructions', {toolbar: [
            ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'],
            {name: 'insert', items: ['Table', 'HorizontalRule', 'SpecialChar', 'PageBreak']},
            {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
            {name: 'document', items: ['Preview', '-', 'Templates']},
            '/',
            {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']},
            {name: 'basicstyles', items: ['Bold', 'Italic']},
            {name: 'styles', items: ['Format', 'FontSize']},
            {name: 'colors', items: ['TextColor', 'BGColor']},
        ]});


</script>
