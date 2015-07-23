<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

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
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/add_ajax",
                type: 'POST',
                target: '#main',
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
        $("#submit-indicator").hide();
        jQuery.validator.addMethod("greaterThanZero", function (value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        $('#NonConformingProductsMaterialAddAjaxForm').validate();
    });
    $("#material").hide();
</script>

<div id="nonConformingProductsMaterials_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">
        <div class="nonConformingProductsMaterials form col-md-8">
            <h4><?php echo __('Add Non Conforming Products Material'); ?></h4>
            <?php echo $this->Form->create('NonConformingProductsMaterial', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>
            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('title'); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('description'); ?></div>
            </div>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('type', array('options' => array('Product', 'Material'), 'type' => 'radio', 'onClick' => 'shhd(this.value)', 'class' => 'checkbox-2', 'legend' => __('Select Material/Product'), 'default' => '0')); ?></div>
                <div class="col-md-6 hidediv"  id="material"><?php echo $this->Form->input('material_id', array('style' => 'width:100%')); ?></div>
                <div class="col-md-6 hidediv" id="product"><?php echo $this->Form->input('product_id', array('style' => 'width:100%')); ?></div>
            </div>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('capa_source_id'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('corrective_preventive_action_id'); ?></div>
                <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
                <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
                <?php echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id'])); ?>
            </div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>
            <?php echo $this->Form->submit('Submit', array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#nonConformingProductsMaterials_ajax', 'async' => 'false','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>

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