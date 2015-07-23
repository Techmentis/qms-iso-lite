<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function (error, element) {
            if ($(element).attr('name') == 'data[InternalAudit][department_id]') {
                $(element).next().after(error);
            } else if ($(element).attr('name') == 'data[InternalAudit][list_of_trained_internal_auditor_id]') {
                $(element).next().after(error);
            } else if ($(element).attr('name') == 'data[InternalAudit][employee_id]') {
                $(element).next().after(error);
            } else if ($(element).attr('name') == 'data[InternalAudit][capa_source_id]') {
                $(element).next().after(error);
            } else if ($(element).attr('name') == 'data[InternalAudit][assignedTo]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        }
    });
     $().ready(function () {
	$("#submit-indicator").hide();

        jQuery.validator.addMethod("greaterThanZero", function (value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

	$("#submit_id").click(function(){
            if ($('#InternalAuditEditPopupForm').valid()) {
	    $("#submit_id").prop("disabled",true);
	    $("#submit-indicator").show();
	    $("#InternalAuditEditPopupForm").submit();
            }
	});
      $("#InternalAuditDepartmentId").change(function () {
             $.ajax({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_dept_clauses/" + $('#InternalAuditDepartmentId').val(),
                get: $('#InternalAuditDepartmentId').val(),
                success: function (data, result) {
                    $('#InternalAuditClauses').val(data);
                }
            });
            var selected = $('#InternalAuditDepartmentId').val();
            $.ajax({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_department_employee/" + selected,
                success: function (data, result) {
                    $('#InternalAuditEmployeeId').find('option').remove().end().append(data).trigger('chosen:updated');
                }
            });
        });
        $('#InternalAuditEditPopupForm').validate({
            rules: {
                "data[InternalAudit][department_id]": {
                    greaterThanZero: true,
                },
                "data[InternalAudit][list_of_trained_internal_auditor_id]": {
                    greaterThanZero: true,
                },
                "data[InternalAudit][employee_id]": {
                    greaterThanZero: true,
                }
            }
        });
        $('#InternalAuditDepartmentId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#InternalAuditListOfTrainedInternalAuditorId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#InternalAuditEmployeeId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#InternalAuditCapaSourceId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#InternalAuditAssignedTo').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>
<div id="internalAudits_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel">
        <div class="internalAudits form col-md-8">
            <h4><?php echo __('Edit Internal Audit'); ?>
                <?php echo $this->Html->link(__('List'), array('controller' => 'internal_audits', 'action' => 'lists', $this->data['InternalAuditPlan']['id']), array('class' => 'label btn-info')); ?>
            </h4>
            <?php echo $this->Form->create('InternalAudit', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>
            <div class="panel panel-default" id="add_details">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo __('Edit Details');?></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4"><?php echo $this->Form->input('department_id', array('style' => array('width' => '100%'), 'options' => $PublishedDepartmentList, 'label' => __('Department'))); ?></div>
                        <div class="col-md-4"><?php echo $this->Form->input('list_of_trained_internal_auditor_id', array('label' => 'Auditor'), array('options' => $listOfTrainedInternalAuditors)); ?></div>
                        <div class="col-md-4"><?php echo $this->Form->input('employee_id', array('style' => 'width:100%', 'options' => $PublishedEmployeeList, 'label' => 'Auditee')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('start_time'); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('end_time'); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('clauses'); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('section'); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('question_asked'); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('finding'); ?></div>
                        <div class="col-md-12 text-danger">
                            <?php echo $this->Form->input('non_conformity_found', array('label' => __('Any Non Conformity Found?'), 'div' => array('style' => 'padding:0;margin:0 0 0 20px;position:relative;'), 'onclick' => 'SelectCapa();')); ?>
                        </div>
                        <div class="col-md-12">
                            <p class="text-small text-danger">
                                <?php echo __('In case of non-conformities, select the CAPA source, Assigned To  & Target Date from below. This record will be automatically get added to CAPA table for future actions & assigned user will get related alerts.'); ?>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <?php echo $this->Form->input('capa_source_id'); ?>
                        </div>
                        <div class="col-md-6"><?php echo $this->Form->input('assignedTo', array('options' => $PublishedEmployeeList, 'default'=> $this->data['CorrectivePreventiveAction']['assigned_to'],'label' => __('Assigned To'))); ?></div>
                        <div class="col-md-2"><?php echo $this->Form->input('target_date'); ?></div>
                        <div class="col-md-6">
                            <?php
                                $priority = isset($this->data['CorrectivePreventiveAction']['priority']) ? $this->data['CorrectivePreventiveAction']['priority'] : '0';
                                $curStatus = isset($this->data['InternalAudit']['current_status']) ? $this->data['InternalAudit']['current_status'] : '0';

                                echo "<label>" . __('Capa Priority') . "</label>";
                                $options = array('0' => 'Low', '1' => 'Medium', '2' => 'High');
                                echo $this->Form->input('priority', array('label' => false, 'legend' => false, 'div' => false, 'options' => $options, 'default' => $priority,'disabled' => true, 'type' => 'radio', 'style' => 'float:none'));
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo "<label>" . __('Current Capa Status') . "</label>";
                            $options = array('0' => __('Open'), '1' => __('Close'));
                            echo $this->Form->input('current_status', array('label' => false, 'legend' => false, 'div' => false, 'options' => $options, 'default' => $curStatus, 'disabled' => true, 'type' => 'radio', 'style' => 'float:none')); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">  <label for="InternalAuditNote">Note</label></div>
                        <div class="col-md-12" style='clear:both'>
                            <textarea name="data[InternalAudit][notes]" id="InternalAuditNotes"  style="">
                                <?php echo $this->data['InternalAudit']['notes']; ?>
                            </textarea>
                        </div>

                        <?php echo $this->Form->input('internal_audit_plan_department_id', array('type' => 'hidden', 'id' => 'dept_id')); ?>
                        <?php echo $this->Form->input('branch_id', array('type' => 'hidden')); ?>
                        <?php echo $this->Form->input('internal_audit_plan_id', array('type' => 'hidden', 'value' => $this->data['InternalAuditPlan']['id'])); ?>
                        <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
                        <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
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
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'id'=>'submit_id')); ?>
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
    var startDateTextBox = $('#InternalAuditStartTime');
    var endDateTextBox = $('#InternalAuditEndTime');

    startDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm:ss',
        onClose: function (dateText, inst) {
            if (endDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker('getDate');
                if (testStartDate > testEndDate)
                    endDateTextBox.val(startDateTextBox.val());
            } else {
                endDateTextBox.val(dateText);
            }
        },
        onSelect: function (selectedDateTime) {
            endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate'));
        }
    }).attr('readonly', 'readonly');


    endDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm:ss',
        onClose: function (dateText, inst) {
            if (startDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker('getDate');
                if (testStartDate > testEndDate)
                    startDateTextBox.val(endDateTextBox.val());
            } else {
                startDateTextBox.val(dateText);
            }
        },
        onSelect: function (selectedDateTime) {
            startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate'));
        }
    }).attr('readonly', 'readonly');
</script>

        <?php echo $this->Html->script(array('ckeditor/ckeditor')); ?>
        <?php echo $this->fetch('script'); ?>

<script type="text/javascript">
    CKEDITOR.replace('InternalAuditNotes', {toolbar: [
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
    function SelectCapa() {

        if ($('#InternalAuditNonConformityFound').is(':checked') == true) {
            $('#InternalAuditCapaSourceId').attr('disabled', false).trigger('chosen:updated');
            $('#InternalAuditAssignedTo').attr('disabled', false).trigger('chosen:updated');
            $('#InternalAuditTargetDate').attr('disabled', false);
            $("[name='data[InternalAudit][priority]']").attr('disabled', false);
            $("[name='data[InternalAudit][current_status]']").attr('disabled', false);

            $('#InternalAuditCapaSourceId').rules('add', {
                    greaterThanZero: true
            });
            $('#InternalAuditAssignedTo').rules('add', {
                    greaterThanZero: true
            });
            $('#InternalAuditTargetDate').attr('required', true);
        } else {
            $('#InternalAuditCapaSourceId').val(0).attr('disabled', true).trigger('chosen:updated');
            $('#InternalAuditAssignedTo').val(0).attr('disabled', true).trigger('chosen:updated');
            $('#InternalAuditTargetDate').attr('disabled', true);
            $("[name='data[InternalAudit][priority]']").attr('disabled', true);
            $("[name='data[InternalAudit][current_status]']").attr('disabled', true);
            $('#InternalAuditTargetDate').val('');
            $("[name='data[InternalAudit][priority]']").val('');
            $("[name='data[InternalAudit][current_status]']").val('');

            $('#InternalAuditCapaSourceId').rules('remove');
            $('#InternalAuditCapaSourceId').next().next('label').remove();
            $('#InternalAuditAssignedTo').rules('remove');
            $('#InternalAuditAssignedTo').next().next('label').remove();
            $('#InternalAuditTargetDate').attr('required', false);
            $('#InternalAuditTargetDate').removeClass('error');
            $('#InternalAuditTargetDate').rules('remove');
            $('#InternalAuditTargetDate').next('label').remove();
        }

    }
    SelectCapa();
</script>

        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>

        <?php $this->Js->get('#list'); ?>
        <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#internalAudits_ajax'))); ?>
        <?php echo $this->Js->writeBuffer(); ?>
    </div>
</div>

