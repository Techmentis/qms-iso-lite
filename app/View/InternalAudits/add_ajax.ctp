<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

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
        },
        submitHandler: function (form) {

            $('#InternalAuditNotes').val(CKEDITOR.instances.InternalAuditNotes.getData());
            $(form).ajaxSubmit({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/audit_details_add_ajax/<?php echo $this->request->params['pass'][0] ?>",
                type: 'POST',
                target: '#ui-tabs-1',
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
        $("#InternalAuditDepartmentId").change(function () {
             $.ajax({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_dept_clauses/" + $('#InternalAuditDepartmentId').val(),
                get: $('#InternalAuditDepartmentId').val(),
                success: function (data, result) {
                    $('#InternalAuditClauses').val(data);
                }
            });
            var selected = $('#InternalAuditDepartmentId').val()
            $.ajax({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_department_employee/" + selected,
                success: function (data, result) {
                    $('#InternalAuditEmployeeId').find('option').remove().end().append(data).trigger('chosen:updated');
                }
            });
        });
        $('#InternalAuditAddAjaxForm').validate({
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
         $('#InternalAuditTargetDate').attr('disabled', true);
    });

    function deleteAudit(id, keyid) {
        var counter = parseInt($('#counter_' + keyid).text());
        counter = counter - 1;
        $.get("<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/delete/" + id, function (data) {
            $('#' + id).parent().parent().remove();
            $('#counter_' + keyid).text(counter);
        });
    }
</script>

<div class="nav">
    <div class="internalAudits form col-md-8" id="internalAudits_ajax">
        <?php if ($this->request->params['pass'][0]) { ?>
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
                    <p>&nbsp;
                        <br /><br /><br /><br /><br />
                    </p>
                    <ul class="nav nav-tabs">
                        <?php foreach ($PublishedBranchList as $key => $value): ?>
                            <li><?php echo $this->Html->link($value . ' <span class="badge btn-info">' . count($plan[$key]) . '</span>', '#' . $key, array('data-toggle' => 'tab', 'escape' => false), array()); ?>

                            </li>
                        <?php endforeach ?>
                    </ul>
                    <div class="tab-content">

                        <?php foreach ($plan as $key => $value): ?>
                            <div class="tab-pane" id="<?php echo $key ?>">
                                <table class="table">
                                    <tr><?php echo ('<th>' . __('Department') . '</th><th>' . __('Clauses') . '</th><th>' . __('Auditee') . '</th><th>' . __('Auditor') . '</th><th>' . __('Time') . '</th>'); ?>
                                        <?php if (isset($this->request->params['pass'][1]) && $this->request->params['pass'][1] == 1) echo '<th>' . __('Add Details') . '</th>'; ?>
                                    </tr>
                                    <?php foreach ($value as $department): ?>
                                    <tr>
                                        <td><?php echo $department['Department']['name']; ?></td>
                                        <td><?php echo $department['InternalAuditPlanDepartment']['clauses'] ?></td>
                                        <td><?php echo $department['Employee']['name'] ?></td>
                                        <td><?php echo $department['TrainedInternalAuditor'] ?></td>
                                        <td><?php echo ( __('From : ') . $department['InternalAuditPlanDepartment']['start_time'] . '<br /> to : ' . $department['InternalAuditPlanDepartment']['end_time']); ?></td>
                                        <?php
                                            if (isset($this->request->params['pass'][1]) && $this->request->params['pass'][1] == 1)
                                                echo "<td><div class='btn-group-vertical'>" . $this->Html->link(__('Add Details'), '#add_details', array('class' => 'btn btn-xs btn-info', 'onClick' => 'getVals("' . $department['InternalAuditPlanDepartment']['branch_id'] . '","' . $department['InternalAuditPlanDepartment']['department_id'] . '","' . $department['InternalAuditPlanDepartment']['list_of_trained_internal_auditor_id'] . '","' . $department['Employee']['id'] . '","' . $department['InternalAuditPlanDepartment']['clauses'] . '","' . $department['InternalAuditPlanDepartment']['start_time'] . '","' . $department['InternalAuditPlanDepartment']['end_time'] . '")'));
                                            echo "</div></td>";
                                        ?>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if (isset($internalAudits)) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo __('Actual Audit'); ?></div>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <?php foreach ($PublishedBranchList as $keys => $values):
                            $count = isset($internalAudits[$keys]) ? count($internalAudits[$keys]) : 0;
                        ?>

                            <li><?php echo $this->Html->link($values . ' <span class="badge btn-info" id="counter_' . $keys . '">' . $count . '</span>', '#details-' . $keys, array('data-toggle' => 'tab', 'escape' => false), array()); ?></li>
                        <?php endforeach ?>
                    </ul>

                    <div class="tab-content">
                        <?php foreach ($PublishedBranchList as $key => $value): ?>

                            <div class="tab-pane" id="details-<?php echo $key ?>">
                                <?php foreach ($internalAudits[$key] as $internalAudit): ?>

                                    <div class="panel-group" id="audit_accordion-<?php echo $key ?>">

                                        <?php if ($internalAudit['InternalAudit']['non_conformity_found'] == 1) { ?>
                                            <div class="panel panel-danger">
                                            <?php } else { ?>
                                                <div class="panel panel-default">
                                                <?php } ?>
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <?php echo $this->Html->link($internalAudit['Department']['name'], '#' . $internalAudit['InternalAudit']['id'], array('data-toggle' => 'collapse', 'data-parent' => '#audit_accordion-' . $key)); ?>
                                                        <div class="pull-right">
                                                            &nbsp;<?php echo $this->Html->link('<span class="text-warning glyphicon glyphicon-send"></span>', array('controller' => 'internal_audits', 'action' => 'send_email', $internalAudit['InternalAudit']['id']), array('escape' => false)); ?> &nbsp;
                                                            <?php echo $this->Html->link('<span class="text-warning glyphicon glyphicon-cog"></span>', array('controller' => 'internal_audits', 'action' => 'edit_popup', $internalAudit['InternalAudit']['id']), array('escape' => false)) ?>
                                                            &nbsp; <span class="text-warning glyphicon glyphicon-remove" onclick="deleteAudit('<?php echo $internalAudit['InternalAudit']['id']; ?>', '<?php echo $key; ?>')"></span>
                                                        </div>
                                                        <div class="btn-group pull-right">
                                                            <?php if ($internalAudit['InternalAudit']['non_conformity_found'] == 1) {
                                                                    echo $this->Html->link('Upload Evidences', '#', array('id' => 'btn' . $internalAudit['InternalAudit']['id'], 'class' => 'btn btn-xs btn-danger text-primary'));
                                                                } else {
                                                                    echo $this->Html->link('Upload Evidences', '#', array('id' => 'btn' . $internalAudit['InternalAudit']['id'], 'class' => 'btn btn-xs btn-default text-primary'));
                                                                } ?>

                                                            <?php if ($internalAudit['FileCount'] > 0) {
                                                                    echo $this->Html->link($internalAudit['FileCount'], '#', array('id' => 'count' . $internalAudit['InternalAudit']['id'], 'class' => 'btn btn-xs btn-success text-primary'));
                                                                } else {
                                                                    echo $this->Html->link($internalAudit['FileCount'], '#', array('id' => 'count' . $internalAudit['InternalAudit']['id'], 'class' => 'btn btn-xs btn-default text-primary'));
                                                                } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <script>
                                                    $('#btn<?php echo $internalAudit['InternalAudit']['id']; ?>').click(function () {
                                                        $('#internal_audit_uploads<?php echo $internalAudit['InternalAudit']['id']; ?>').load(
                                                                '<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/internal_audit_uploads/<?php echo $internalAudit['InternalAudit']['id'] . "/" . $internalAudit['InternalAudit']['created_by']; ?>', function (response, status, xhr) {
                                                        });
                                                    });
                                                    $('#count<?php echo $internalAudit['InternalAudit']['id']; ?>').click(function () {
                                                        $('#internal_audit_uploads<?php echo $internalAudit['InternalAudit']['id']; ?>').load(
                                                                '<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/internal_audit_uploads/<?php echo $internalAudit['InternalAudit']['id'] . "/" . $internalAudit['InternalAudit']['created_by']; ?>', function (response, status, xhr) {
                                                        });
                                                    });
                                                </script>

                                                <div id="internal_audit_uploads<?php echo $internalAudit['InternalAudit']['id']; ?>"></div>

                                                <div class="panel-collapse collapse" id="<?php echo $internalAudit['InternalAudit']['id'] ?>">
                                                    <div class="panel-body">
                                                        <dl>
                                                            <dt><?php echo __('Department : '); ?></dt><dd><?php echo $internalAudit['Department']['name'] ?>&nbsp; </dd>
                                                            <dt><?php echo __('Auditee'); ?></dt><dd><?php echo $internalAudit['Employee']['name'] ?>&nbsp; </dd>
                                                            <dt><?php echo __('Auditor'); ?></dt><dd><?php echo $internalAudit['ListOfTrainedInternalAuditor']['id'] ?>&nbsp; </dd>
                                                            <dt><?php echo __('Section'); ?></dt><dd><?php echo $internalAudit['InternalAudit']['section'] ?>&nbsp; </dd>
                                                            <dt><?php echo __('Clauses'); ?></dt><dd><?php echo $internalAudit['InternalAudit']['clauses'] ?>&nbsp; </dd>
                                                            <dt><?php echo __('Question asked'); ?></dt><dd><?php echo $internalAudit['InternalAudit']['question_asked'] ?>&nbsp; </dd>
                                                            <dt><?php echo __('Findings'); ?></dt><dd><?php echo $internalAudit['InternalAudit']['finding'] ?>&nbsp; </dd>
                                                            <dt><?php echo __('Current Status'); ?></dt><dd><?php echo $internalAudit['InternalAudit']['current_status'] ?>&nbsp; </dd>
                                                            <?php if($internalAudit['InternalAudit']['non_conformity_found'] == 1) { ?>
                                                            <dt><?php echo __('CAPA Source'); ?></dt><dd><?php echo $capaSources[$internalAudit['CorrectivePreventiveAction']['capa_source_id']]; ?>&nbsp; </dd>
                                                            <dt><?php echo __('Responsibility'); ?></dt><dd><?php echo $PublishedEmployeeList[$internalAudit['CorrectivePreventiveAction']['assigned_to']] ?>&nbsp; </dd>
                                                            <dt><?php echo __('Target Date'); ?></dt><dd><?php echo $internalAudit['CorrectivePreventiveAction']['target_date'] ?>&nbsp; </dd>
                                                            <?php } ?>

                                                            <dt><?php echo __('Notes'); ?></dt><dd><?php echo $internalAudit['InternalAudit']['notes'] ?>&nbsp; </dd>
                                                        </dl>
                                                        <p style="margin-top: 20px; clear: both">
                                                            <?php
                                                                if ($internalAudit['Files']) {

                                                                    echo "<br /><br /><h3>Evidences Uploaded.</h3>";
                                                                    foreach ($internalAudit['Files'] as $file):
                                                                        $file_name = $file['FileUpload']['file_details'] . "." . $file['FileUpload']['file_type'];
                                                                        echo $this->Html->link($file_name, '../files/upload/' . $file['FileUpload']['user_id'] . '/' . $file['SystemTable']['system_name'] . '/' . $file['FileUpload']['record'] . '/' . $file_name, array('class' => 'link')) . " , ";
                                                                    endforeach;
                                                                }
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <br />
            <?php } ?>
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->Form->create('InternalAudit', array('role' => 'form', 'class' => 'form no-margin no-padding', 'default' => false)); ?>
            <div class="panel panel-default" id="add_details">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo __('Add Details'); ?></h3>

                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4"><?php echo $this->Form->input('department_id', array('style' => array('width' => '100%'),'options' => $PublishedDepartmentList, 'label' => __('Department'))); ?></div>
                        <div class="col-md-4"><?php echo $this->Form->input('list_of_trained_internal_auditor_id', array('label' => __('Auditor')), array('options' => $listOfTrainedInternalAuditors)); ?></div>
                        <div class="col-md-4"><?php echo $this->Form->input('employee_id', array('style' => 'width:100%', 'options' => $PublishedEmployeeList, 'label' => __('Auditee'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('start_time'); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('end_time'); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('clauses'); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('section'); ?></div>
                        <div class="col-md-12">
                            <div id="questions"></div>
                        </div>
                        <div class="col-md-12"><?php echo $this->Form->input('question_asked'); ?></div>
                        <div class="col-md-12"><?php echo $this->Form->input('finding'); ?></div>
                        <div class="col-md-12 text-danger">
                            <?php echo $this->Form->input('non_conformity_found', array('label' => __('Any Non Conformity Found?'), 'div' => array('style' => 'padding:0;margin:0 0 0 20px;position:relative;'), 'onclick' => 'SelectCapa();')); ?>

                        </div>
                        <div class="col-md-12">
                            <p class="text-small text-danger">
                                <?php echo __('In case of non-conformities, select the CAPA source, Assigned To  & Target Date from below. This record will be automatically get added to CAPA table for future actions & assigned user will get related alerts.'); ?>
                            </p>
                        </div>
                        <div class="col-md-4"><?php echo $this->Form->input('capa_source_id', array('disabled' => true)); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('assignedTo', array('options' => $PublishedEmployeeList, 'label' => __('Assigned To'),'disabled' => true)); ?>
                        </div>
                        <div class="col-md-2"><?php echo $this->Form->input('target_date',array('disabled' => true)); ?></div>
                        <div class="col-md-6">
                            <?php
                            echo "<label>" . __('Capa Priority') . "</label>";
                            $options = array('0' => __('Low'), '1' => __('Medium'), '2' => __('High'));
                            echo $this->Form->input('priority', array('label' => false, 'legend' => false, 'value' => false, 'div' => false, 'options' => $options, 'disabled' => true, 'type' => 'radio', 'style' => 'float:none'));
                            ?>
                        </div>
                        <div class="col-md-6">
                             <?php echo "<label>" . __('Current Capa Status') . "</label>";
                            $options = array('0' => __('Open'), '1' => __('Close'));
                            echo $this->Form->input('current_status', array('label' => false, 'legend' => false, 'value' => false, 'div' => false, 'options' => $options, 'disabled' => true, 'type' => 'radio', 'style' => 'float:none')); ?>
                        </div>
                        <div class="col-md-12">  <label for="InternalAuditNote"><?php echo __('Note'); ?></label></div>
                        <div class="col-md-12" style='clear:both'>
                            <textarea name="data[InternalAudit][notes]" id="InternalAuditNotes"  style=""></textarea>
                        </div>

                        <?php echo $this->Form->input('internal_audit_plan_department_id', array('type' => 'hidden', 'id' => 'dept_id')); ?>
                        <?php echo $this->Form->input('branch_id', array('type' => 'hidden')); ?>
                        <?php echo $this->Form->input('internal_audit_plan_id', array('type' => 'hidden', 'value' => $this->request->params['pass'][0])); ?>
                        <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
                        <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
                        <?php echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id'])); ?>
                    </div>
                    <?php echo $this->element('internal_audit_plan_approval');?>
                </div>
            </div>

            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#internalAudits_ajax', 'async' => 'false','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>

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
<script>
    function getVals(branchid, departmentid, auditor, auditee, claues, start_time, end_time) {
        $('#InternalAuditDepartmentId').val(departmentid).trigger('chosen:updated');
        $('#InternalAuditListOfTrainedInternalAuditorId').val(auditor).trigger('chosen:updated');
        $('#InternalAuditEmployeeId').val(auditee).trigger('chosen:updated');
        $('#InternalAuditBranchId').val(branchid);
        $('#InternalAuditClauses').val(claues);
        $('#InternalAuditStartTime').val(start_time);
        $('#InternalAuditEndTime').val(end_time);
        $('#dept_id').val(departmentid);

        $("#questions").load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_questions/' + departmentid);
    }

    function SelectCapa() {

        var lfckv = $('#InternalAuditNonConformityFound').is(':checked');
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
            $('#InternalAuditCapaSourceId').attr('disabled', true).trigger('chosen:updated');
            $('#InternalAuditAssignedTo').attr('disabled', true).trigger('chosen:updated');
            $('#InternalAuditTargetDate').attr('disabled', true);
            $("[name='data[InternalAudit][priority]']").attr('disabled', true);
            $("[name='data[InternalAudit][current_status]']").attr('disabled', true);

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

    $("#InternalAuditDepartmentId").change(function () {
        $("#questions").load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_questions/' + $("#InternalAuditDepartmentId").val())
        var selected = $('#InternalAuditDepartmentIdDepartmentId').val()
        $.ajax({
            url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_department_employee/" + selected,
            success: function (data, result) {
                $('#InternalAuditDepartmentIdEmployeeId').find('option').remove().end().append(data).trigger('chosen:updated');
            }
        });
    });
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
</script>
<script>
    $(".edit").click(function() {
        $('#open_edit').load($(this).attr('data'))
    });
</script>
<div id="open_edit"></div>