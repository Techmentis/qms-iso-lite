F<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function (error, element) {
            if ($(element).attr('name') == 'data[SummeryOfSupplierEvaluation][supplier_registration_id]' ||
                $(element).attr('name') == 'data[SummeryOfSupplierEvaluation][supplier_category_id]' ||
                $(element).attr('name') == 'data[SummeryOfSupplierEvaluation][employee_id]') {
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

        $('#SummeryOfSupplierEvaluationApproveForm').validate({
            rules: {
                "data[SummeryOfSupplierEvaluation][supplier_registration_id]": {
                    greaterThanZero: true,
                },
                "data[SummeryOfSupplierEvaluation][supplier_category_id]": {
                    greaterThanZero: true,
                },
                "data[SummeryOfSupplierEvaluation][employee_id]": {
                    greaterThanZero: true,
                },
            }
        });
        $("#submit-indicator").hide();
        $("#submit_id").click(function(){
             if($('#SummeryOfSupplierEvaluationApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#SummeryOfSupplierEvaluationApproveForm").submit();
             }

        });
        $('#SummeryOfSupplierEvaluationSupplierRegistrationId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#SummeryOfSupplierEvaluationSupplierCategoryId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#SummeryOfSupplierEvaluationEmployeeId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<div id="summeryOfSupplierEvaluations_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="summeryOfSupplierEvaluations form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Approve Summary Of Supplier Evaluation'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>

            </h4>
            <?php echo $this->Form->create('SummeryOfSupplierEvaluation', array('role' => 'form', 'class' => 'form')); ?>

            <?php echo $this->Form->input('id'); ?>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('supplier_registration_id', array('style' => 'width:100%', 'label' => __('Supplier'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('supplier_category_id', array('style' => 'width:100%', 'label' => __('Supplier Category'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('remarks', array('label' => __('Remarks'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('evaluation_date', array('label' => __('Date of Evaluation'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('employee_id', array('style' => 'width:100%', 'label' => __('Employee'), 'options' => $PublishedEmployeeList)); ?></div>
            </div>
            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish');
                }
            ?>
            <?php echo $this->Form->submit('Submit', array('div' => false, 'class' => 'btn btn-primary btn-success','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>

<script> $("[name*='date']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimePicker': false,
    }).attr('readonly', 'readonly');
</script>

        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#summeryOfSupplierEvaluations_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

