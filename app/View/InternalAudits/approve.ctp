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
            } else {
                $(element).after(error);
            }
        },

    });

    $().ready(function () {
        jQuery.validator.addMethod("greaterThanZero", function (value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");
        $("#InternalAuditDepartmentId").change(function () {
            var selected = $('#InternalAuditDepartmentId').val()
            $.ajax({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_department_employee/" + selected,
                success: function (data, result) {
                    $('#InternalAuditEmployeeId').find('option').remove().end().append(data).trigger('chosen:updated');
                }
            });
        });
        $('#InternalAuditApproveForm').validate({
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
    });

</script>

<div id="internalAudits_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel">
        <div class="internalAudits form col-md-8">
            <h4><?php echo __('Approve Internal Audit'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>

            </h4>
            <?php echo $this->Form->create('InternalAudit', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>

            <div class="row">
                <div class="col-md-4"><?php echo $this->Form->input('department_id', array('style' => array('width' => '100%'), 'options' => $PublishedDepartmentList, 'label' => __('Department'))); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('list_of_trained_internal_auditor_id', array('label' => 'Auditor'), array('options' => $listOfTrainedInternalAuditors)); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('employee_id', array('style' => 'width:100%', 'options' => $PublishedEmployeeList, 'label' => 'Auditee')); ?></div>

                <div class="col-md-6"><?php echo $this->Form->input('start_time', array('class' => 'disabled')); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('end_time', array('class' => 'disabled')); ?></div>

                <div class="col-md-6"><?php echo $this->Form->input('clauses'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('section'); ?></div>

                <div class="col-md-6"><?php echo $this->Form->input('question_asked'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('finding'); ?></div>

                <div class="col-md-6"><?php echo $this->Form->input('current_status'); ?></div>

                <div class="col-md-6"><?php echo $this->Form->input('employeeId', array('options' => $PublishedEmployeeList, 'label' => __('Employee'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('target_date'); ?></div>

                <div class="col-md-12"><?php echo $this->Form->input('notes'); ?></div>
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
    $("[name*='date']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
</script>

        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#internalAudits_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>
