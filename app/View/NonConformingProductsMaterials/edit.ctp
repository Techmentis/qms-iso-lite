<?php echo $this->Html->script(array('jquery.validate.min','jquery-form.min'));?>
<?php echo $this->fetch('script');?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function (error, element) {
            if ($(element).attr('name') == 'data[NonConformingProductsMaterial][product_id]' ||
                $(element).attr('name') == 'data[NonConformingProductsMaterial][material_id]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        },
    });

    function shhd(chk) {
        if (chk == 0) {
            $("#material").hide();
            $("#product").show();
            $("#NonConformingProductsMaterialProductId_chosen").width('100%');
            $('#NonConformingProductsMaterialMaterialId').rules('remove');
            if ($('#NonConformingProductsMaterialMaterialId').next().next('label').hasClass("error")) {
                $('#NonConformingProductsMaterialMaterialId').next().next('label').remove();
            }

            $('#NonConformingProductsMaterialProductId').rules('add', {
                greaterThanZero: true
            });
        } else if (chk == 1) {
            $("#material").show();
            $("#product").hide();
            $("#NonConformingProductsMaterialMaterialId_chosen").width('100%');
            $('#NonConformingProductsMaterialProductId').rules('remove');
            if ($('#NonConformingProductsMaterialProductId').next().next('label').hasClass("error")) {
                $('#NonConformingProductsMaterialProductId').next().next('label').remove();
            }
            $('#NonConformingProductsMaterialMaterialId').rules('add', {
                greaterThanZero: true
            });
        }
    }
    $().ready(function () {
        jQuery.validator.addMethod("greaterThanZero", function (value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        $('#NonConformingProductsMaterialEditForm').validate();
        $("#submit-indicator").hide();
        $("#submit_id").click(function(){
             if($('#NonConformingProductsMaterialEditForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
                 $("#NonConformingProductsMaterialEditForm").submit();
             }
        });
        if ($('#NonConformingProductsMaterialMaterialId').val() == '-1') {
            $("#material").hide();
        }
        if ($('#NonConformingProductsMaterialProductId').val() == '-1') {
            $("#product").hide();
        }
    });
    $("#material").hide();
    $("#product").hide();
</script>

<div id="nonConformingProductsMaterials_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="nonConformingProductsMaterials form col-md-8">
            <h4><?php echo __('Edit Non Conforming Products Material'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
            <?php echo $this->Form->create('NonConformingProductsMaterial', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>

            <fieldset>
                <div class="col-md-12"><?php echo $this->Form->input('title'); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('description'); ?></div>
                <?php
                    if ($this->request->data['NonConformingProductsMaterial']['material_id'] != '-1') {
                        $chk = 1;
                    }
                    if ($this->request->data['NonConformingProductsMaterial']['product_id'] != '-1') {
                        $chk = 0;
                    }
                ?>
                <div class="row">
                    <div class="col-md-6"><?php echo $this->Form->input('type', array('options' => array('Product', 'Material'), 'type' => 'radio', 'default' => $chk, 'onClick' => 'shhd(this.value)', 'class' => 'checkbox-2', 'legend' => __('Select Material/Product'))); ?></div>
                    <div class="col-md-6 hidediv"  id="material"><?php echo $this->Form->input('material_id', array('style' => 'width:100%')); ?></div>
                    <div class="col-md-6 hidediv" id="product"><?php echo $this->Form->input('product_id', array('style' => 'width:100%')); ?></div>
                </div>
                <div class="col-md-6"><?php echo $this->Form->input('capa_source_id'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('corrective_preventive_action_id'); ?></div>

                <?php
                    if ($showApprovals && $showApprovals['show_panel'] == true) {
                        echo $this->element('approval_form');
                    } else {
                        echo $this->Form->input('publish');
                    }
                ?>
                <?php echo $this->Form->submit('Submit', array('div' => false, 'class' => 'btn btn-primary btn-success' ,'id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
                <?php echo $this->Form->end(); ?>
                <?php echo $this->Js->writeBuffer(); ?>
            </fieldset>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
</div>

<?php $this->Js->get('#list'); ?>
<?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#nonConformingProductsMaterials_ajax'))); ?>
<?php echo $this->Js->writeBuffer(); ?>