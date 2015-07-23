<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {

            if ($(element).attr('name') == 'data[Product][branch_id]')
                $(element).next().after(error);
            else if ($(element).attr('name') == 'data[Product][department_id]') {

                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        }
    });
    $().ready(function() {

        $.validator.addMethod("greaterThanZero", function(value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");
        var $validator = $('#ProductApproveForm').validate({
            ignore: null,
            rules: {
                "data[Product][branch_id]": {
                    greaterThanZero: true,
                    required: true

                },
                "data[Product][department_id]": {
                    greaterThanZero: true,
                    required: true

                },
            }
        });
        $("#submit-indicator").hide();
        $("#submit_id").click(function(){
             if($('#ProductApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#ProductApproveForm").submit();
             }

        });
        $('#ProductDepartmentId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#ProductBranchId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<div id="products_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="products form col-md-8 panel">
            <h4><?php echo $this->element('breadcrumbs') . __('Approve Product'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>

            </h4>
            <?php echo $this->Form->create('Product', array('role' => 'form', 'class' => 'form')); ?>

            <fieldset>
                <?php
                    echo $this->Form->input('id');
                    echo $this->Form->input('name');
                    echo $this->Form->input('description');
                ?>
                <div class="row">
                    <div class="col-md-12"><?php echo $this->Form->input('ProductMaterial.material_id', array('name' => 'ProductMaterial.material_id[]', 'type' => 'select', 'multiple', 'options' => $PublishedMaterialList, 'label' => __('Add Required Material'), 'style' => 'width:100%', 'default' => $materials)); ?></div>
                </div>

                <div class="row">
                    <div class="col-md-6"><?php echo $this->Form->input('branch_id', array('style' => 'width:100%', 'label' => __('Branch'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('department_id', array('style' => 'width:100%', 'label' => __('Department'))); ?></div>
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
            </fieldset>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#products_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

