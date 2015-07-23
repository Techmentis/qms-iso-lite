<div class="modal fade" id="editModel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo __('Edit Internal Audit Plan Department'); ?>		</h4>
            </div>
            <div class="modal-body">
                <div class="internalAuditPlanDepartments form col-md-12">
                    <?php echo $this->Form->create('InternalAuditPlanDepartment', array('role' => 'form', 'class' => 'form')); ?>
                    <?php echo $this->Form->input('id'); ?>

                    <div class="row">
                        <?php echo $this->Form->hidden('internal_audit_plan_id', array('style' => 'width:100%')); ?>
                        <div class="col-md-6"><?php echo $this->Form->input('branch_id', array('style' => 'width:100%', 'label' => __('Branch'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('department_id', array('style' => 'width:100%', 'label' => __('Department'))); ?></div>
                        <div class="col-md-12"><?php echo $this->Form->input('clauses'); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('employee_id', array('style' => 'width:100%')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('list_of_trained_internal_auditor_id', array('style' => 'width:100%')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('start_time', array('style' => 'width:100%', 'class' => 'disabled')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('end_time', array('style' => 'width:100%', 'class' => 'disabled')); ?></div>
                        <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
                        <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
                    </div>

                    <?php
                        if ($showApprovals && $showApprovals['show_panel'] == true) {
                            echo $this->element('approval_form');
                        } else {
                            echo $this->Form->input('publish', array('label' => __('Publish')));
                        }
                    ?>
                    <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success')); ?>
                    <?php echo $this->Form->end(); ?>
                    <?php echo $this->Js->writeBuffer(); ?>
                </div>
<script>
    var startDateTextBox = $('#InternalAuditPlanDepartmentStartTime');
    varendDateTextBox = $('#InternalAuditPlanDepartmentEndTime');

    startDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm:ss',
        onClose: function(dateText, inst) {
            if (endDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker('getDate');
                if (testStartDate > testEndDate)
                    endDateTextBox.datetimepicker('setDate', testSt artDate);
            }
            else {
                endDateTextBox.val(dateText);
            }
        },
        onSelect: function(selectedDateTime) {
            endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate'));
        }
    }).attr('readonly', 'readonly');
    endDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm:ss',
        onClose: function(dateText, inst) {
            if (startDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker('getDate');
                if (testStartDate > testEndDate)
                    startDateTextBox.datetimepicker('setDate', testEndDate);
            }
            else {
                startDateTextBox.val(dateText);
            }
        },
        onSelect: function(selectedDateTime) {
            startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate'));
        }
    }).attr('readonly', 'readonly');

</script>

                <?php echo $this->Js->writeBuffer(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#editModel').modal();
</script>