<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<?php if (isset($this->request->params['pass']) && isset($this->request->params['pass'][0])) { ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function (error, element) {
            if ($(element).attr('name') == 'data[InternalAuditPlanDepartment][employee_id]') {
                $(element).next().after(error);
            } else if ($(element).attr('name') == 'data[InternalAuditPlanDepartment][list_of_trained_internal_auditor_id]') {
                $(element).next().after(error);
            } else if ($(element).attr('name') == 'data[InternalAuditPlanDepartment][branch_id]') {
                $(element).next().after(error);
            } else if ($(element).attr('name') == 'data[InternalAuditPlanDepartment][department_id]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        },
        submitHandler: function (form) {
            $('#InternalAuditPlanDepartmentNote').val(CKEDITOR.instances.InternalAuditPlanDepartmentNote.getData());
            $('#InternalAuditPlanDepartmentAddAjaxForm').ajaxSubmit({
                url: "<?php echo Router::url('/', true); ?><?php echo "
                internal_audit_plan_departments " ?>/add_ajax/<?php echo $this->request->params['pass'][0]; ?>",
                type: 'POST',
                target: '[id*="ui-tabs"]',
                beforeSend: function(){
                   $("#submit_id").prop("disabled",true);
                    $("#submit-indicator").show();
                },
                complete: function() {
                   $("#submit_id").removeAttr("disabled");
                   $("#submit-indicator").hide();
                },
                error: function (request, status, error) {
                    //alert(request.responseText);
                    alert('Action failed!');
                }
            });
        }
    });

    $().ready(function () {
        $("#submit-indicator").hide();
        jQuery.validator.addMethod("greaterThanZero", function (value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        $("#InternalAuditPlanDepartmentDepartmentId").change(function () {
            $.ajax({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_dept_clauses/" + $('#InternalAuditPlanDepartmentDepartmentId').val(),
                get: $('#InternalAuditPlanDepartmentDepartmentId').val(),
                success: function (data, result) {
                    $('#InternalAuditPlanDepartmentClauses').val(data);
                }
            });
            $.ajax({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_department_employee/" + $('#InternalAuditPlanDepartmentDepartmentId').val(),
                success: function (data, result) {
                    $('#InternalAuditPlanDepartmentEmployeeId').find('option').remove().end().append(data).trigger('chosen:updated');
                }
            });
        });
        $('#InternalAuditPlanDepartmentAddAjaxForm').validate({
            rules: {
                "data[InternalAuditPlanDepartment][employee_id]": {
                    greaterThanZero: true,
                },
                "data[InternalAuditPlanDepartment][list_of_trained_internal_auditor_id]": {
                    greaterThanZero: true,
                },
                "data[InternalAuditPlanDepartment][branch_id]": {
                    greaterThanZero: true,
                },
                "data[InternalAuditPlanDepartment][department_id]": {
                    greaterThanZero: true,
                }
            }
        });
        $('#InternalAuditPlanDepartmentBranchId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#InternalAuditPlanDepartmentDepartmentId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#InternalAuditPlanDepartmentEmployeeId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#InternalAuditPlanDepartmentListOfTrainedInternalAuditorId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<?php } else { ?>

<script>
    $.validator.setDefaults({
        submitHandler: function (form) {
            $('#InternalAuditPlanNote').val(CKEDITOR.instances.InternalAuditPlanNote.getData());
            $(form).ajaxSubmit({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/add_ajax",
                type: 'POST',
                target: '[id*="ui-tabs"]',
                error: function (request, status, error) {
                    //alert(request.responseText);
                    alert('Action failed!');
                }
            });
        }
    });

    $().ready(function () {
        $('#InternalAuditPlanAddAjaxForm').validate();
    });
</script>

<?php } ?>

<div id="internalAuditPlans_ajax">
    <?php $i = 0; ?>
    <div class="nav">
        <div class="internalAuditPlans form col-md-8">
            <?php if ($this->request->params['pass'][0]) { ?>
                <div class="row">
                    <div class="col-md-12" id="audit_plans">
                        <div class="panel panel-default">
                            <div class="panel-heading"><div class="panel-title"><?php echo __('Schedule Details'); ?></div></div>
                            <div class="panel-body">
                                <p>
                                <dl style="clear: both; margin: 0 0 10px 0">
                                    <dt><?php echo __('Schedule title'); ?></dt>
                                    <dd><?php echo $internalAuditPlan['InternalAuditPlan']['title']; ?>&nbsp;</dd>
                                    <dt><?php echo __('From'); ?></dt>
                                    <dd><?php echo $internalAuditPlan['InternalAuditPlan']['schedule_date_from']; ?>&nbsp;</dd>
                                    <dt><?php echo __('To'); ?></dt>
                                    <dd><?php echo $internalAuditPlan['InternalAuditPlan']['schedule_date_to']; ?>&nbsp;</dd>
                                    <dt><?php echo __('Notes'); ?></dt>
                                    <dd><?php echo html_entity_decode($internalAuditPlan['InternalAuditPlan']['note']); ?>&nbsp;</dd>
                                </dl>
                                </p>
                                <br />
                                <ul class="nav nav-tabs">
                                    <?php foreach ($PublishedBranchList as $key => $value): ?>
                                        <li><?php echo $this->Html->link($value . " <span class='badge btn-info'>" . count($plan[$key]) . "</span>", '#' . $key, array('data-toggle' => 'tab', 'escape' => false)); ?> </li>
                                    <?php endforeach ?>
                                </ul>
                                <div class="tab-content">
                                    <?php foreach ($plan as $key => $value): ?>
                                        <div class="tab-pane" id="<?php echo $key ?>">
                                            <table class="table">
                                                <tr><?php echo ('<th>' . __('Department') . '</th><th>' . __('Clauses') . '</th><th>' . __('Auditee') . '</th><th>' . __('Auditor') . '</th><th>' . __('Time') . '</th><th>' . __('Note') . '</th><th>' . __('Action') . '</th>'); ?>
                                                    <?php if ($this->request->params['pass'][1] == 1) echo '<th>' . __('Add Details') . '</th>'; ?>
                                                </tr>

                                                <?php foreach ($value as $department): ?>
                                                    <tr>
                                                        <td><?php echo $department['Department']['name'] ?></td>
                                                        <td><?php echo $department['InternalAuditPlanDepartment']['clauses'] ?></td>
                                                        <td><?php echo $department['Employee']['name'] ?></td>
                                                        <td><?php echo $department['TrainedInternalAuditor'] ?></td>
                                                        <td><?php echo (__('From : ') . $department['InternalAuditPlanDepartment']['start_time'] . '<br />' . __('to : ') . $department['InternalAuditPlanDepartment']['end_time']); ?></td>
                                                        <td><?php echo html_entity_decode($department['InternalAuditPlanDepartment']['note']); ?></td>
                                                        <?php if ($this->request->params['pass'][1] == 1) echo "<td>" . $this->Html->link(__('Add Details'), '#add_details', array('onClick' => 'getVals("' . $department['InternalAuditPlanDepartment']['id'] . '","' . $department['InternalAuditPlanDepartment']['list_of_trained_internal_auditor_id'] . '","' . $department['InternalAuditPlanDepartment']['clauses'] . '","' . $department['InternalAuditPlanDepartment']['start_time'] . '","' . $department['InternalAuditPlanDepartment']['end_time'] . '")')) . "</td>"; ?>
                                                        <td><?php echo $this->Html->link(__('Edit'), array('controller' => 'internal_audit_plan_departments', 'action' => 'edit', $department['InternalAuditPlanDepartment']['id']), array('class' => 'btn btn-xs btn-info')); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>

                                            </table>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <?php echo $this->Form->create('InternalAuditPlan', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>
                <fieldset>
                    <div class="row">
                        <div class="col-md-12"><?php echo $this->Form->input('title'); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('schedule_date_from'); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('schedule_date_to'); ?></div>
                        <div class="col-md-12">  <label for="InternalAuditPlanNote">Note</label></div>
                        <div class="col-md-12" style='clear:both'>
                            <textarea name="data[InternalAuditPlan][note]" id="InternalAuditPlanNote"  style=""></textarea>
                        </div>
                        <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
                        <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
                        <?php echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id'])); ?>
                    </div>
                </fieldset>

<script>
    var startDateTextBox = $('#InternalAuditPlanScheduleDateFrom');
    var endDateTextBox = $('#InternalAuditPlanScheduleDateTo');

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
    CKEDITOR.replace('InternalAuditPlanNote', {toolbar: [
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
</script>

                <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#internalAuditPlans_ajax', 'async' => 'false')); ?>
                <?php echo $this->Form->end(); ?>
                <?php echo $this->Js->writeBuffer(); ?>

            <?php } ?>

            <?php if ($this->request->params['pass'][0]) { ?>
                <?php echo $this->Session->flash(); ?>
                <?php echo $this->Form->create('InternalAuditPlanDepartment', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title"><?php echo __('Create Plan'); ?></div>
                        </div>
                        <div class="panel-body">
                            <?php echo $this->Form->hidden('internal_audit_plan_id', array('style' => 'width:100%', 'value' => $this->request->params['pass'][0])); ?>
                            <div class="col-md-6"><?php echo $this->Form->input('branch_id', array('style' => 'width:100%', 'label' => __('Branch'), 'options' => $PublishedBranchList)); ?></div>
                            <div class="col-md-6"><?php echo $this->Form->input('department_id', array('style' => 'width:100%', 'label' => __('Department'), 'options' => $PublishedDepartmentList)); ?></div>
                            <div class="col-md-12"><?php echo $this->Form->input('clauses', array('style' => 'width:100%', 'label' => __('Clauses'))); ?></div>
                            <div class="col-md-6"><?php echo $this->Form->input('employee_id', array('style' => 'width:100%', 'options' => $PublishedEmployeeList)); ?></div>
                            <div class="col-md-6"><?php echo $this->Form->input('list_of_trained_internal_auditor_id', array('style' => 'width:100%')); ?></div>
                            <div class="col-md-6"><?php echo $this->Form->input('startTime', array('default' => $internalAuditPlan['InternalAuditPlan']['schedule_date_from'])); ?></div>
                            <div class="col-md-6"><?php echo $this->Form->input('endTime', array('style' => 'width:100%', 'default' => $internalAuditPlan['InternalAuditPlan']['schedule_date_to'])); ?></div>
                            <div class="col-md-6"> <label><?php echo __('Note'); ?></label></div>
                            <div class="col-md-12" style='clear:both'>
                                <textarea name="data[InternalAuditPlanDepartment][note]" id="InternalAuditPlanDepartmentNote"  style=""></textarea>
                            </div>
                            <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
                            <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
                            <?php echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id'])); ?>
                        </div>
                    </div>
                    <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#internalAuditPlanDepartments_ajax', 'async' => 'false','id'=>'submit_id')); ?>
                    <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
                    <?php echo $this->Form->end(); ?>
                    <?php echo $this->Js->writeBuffer(); ?>
                </div>

<script>
    var startDateTextBox = $('#InternalAuditPlanDepartmentStartTime');
    var endDateTextBox = $('#InternalAuditPlanDepartmentEndTime');

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
    CKEDITOR.replace('InternalAuditPlanDepartmentNote', {toolbar: [
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
</script>

            <?php } ?>
            <?php echo $this->Session->flash(); ?>
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