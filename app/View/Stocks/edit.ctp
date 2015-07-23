<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<?php if ($this->request->data['Stock']['type'] == 0) { ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function (error, element) {
            if (
                $(element).attr('name') == 'data[Stock][production_id]' ||
                $(element).attr('name') == 'data[Stock][material_id]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        }
    });

    $().ready(function () {
        jQuery.validator.addMethod("greaterThanZero", function (value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        jQuery.validator.addMethod("greaterQtyConsumed", function (value, element) {
            var qtyConsumed = $('[name="data[Stock][quantity_consumed]"]').val();
            var qtyInHand = $('[name="data[quantity_in_hand]"]').val();
            return Number(qtyConsumed) > Number(qtyInHand) ? false : true;
        }, "Quantity consumed is higher than \'Quantity in hand\'");

        $('#StockEditForm').validate({
            rules: {
                "data[Stock][production_id]": {
                    greaterThanZero: true,
                },
                "data[Stock][material_id]": {
                    greaterThanZero: true,
                },
                "data[Stock][production_date]": {
                    required: true,
                },
                "data[Stock][quantity_consumed]": {
                    required: true,
                    greaterQtyConsumed: true
                }
            }
        });
        $('#StockProductionId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#StockMaterialId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        getMaterialDetails();
        $('#StockMaterialId').change(function() {
            getMaterialDetails();
        });

        function getMaterialDetails(){
            var matID = $('#StockMaterialId').val();
            var stockID = $('[name="data[Stock][id]"]').val();
            $('#materialDetails').load('<?php echo Router::url('/', true) . $this->request->params['controller'] ?>/get_material_details/' + matID + '/'+ stockID);
        }
    });
</script>

<?php } else if ($this->request->data['Stock']['type'] == 1) { ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function (error, element) {
            if (
                $(element).attr('name') == 'data[Stock][delivery_challan_id]' ||
                $(element).attr('name') == 'data[Stock][material_id]' ||
                $(element).attr('name') == 'data[Stock][branch_id]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        }
    });

    $().ready(function () {
        jQuery.validator.addMethod("greaterThanZero", function (value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        $('#StockEditForm').validate({
            rules: {
                "data[Stock][delivery_challan_id]": {
                    greaterThanZero: true,
                },
                "data[Stock][material_id]": {
                    greaterThanZero: true,
                },
                "data[Stock][branch_id]": {
                    greaterThanZero: true,
                },
                "data[Stock][received_date]": {
                    required: true,
                }
            }
        });
        $('#StockDeliveryChallanId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#StockMaterialId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#StockBranchId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<?php } ?>

<div id="stocks_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel">
        <div class="stocks form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Edit Stock'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>

            </h4>
            <?php echo $this->Form->create('Stock', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>
            <?php if ($this->request->data['Stock']['type'] == 0) { ?>

                <div class="row">
                    <div class="col-md-6"><?php echo $this->Form->input('production_id', array('label' => __('Select Batch'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('material_id'); ?></div>
                    <div id="materialDetails" class="col-md-12"></div>
                    <div class="col-md-4"><?php echo $this->Form->input('production_date'); ?></div>
                    <div class="col-md-4"><?php echo $this->Form->input('quantity_consumed'); ?></div>
                    <div class="col-md-12"><?php echo $this->Form->input('remarks'); ?></div>
                    <?php echo $this->Form->hidden('quantity'); ?>
                </div>

            <?php } else if ($this->request->data['Stock']['type'] == 1) { ?>

                <div class="row">
                    <div class="col-md-6"><?php echo $this->Form->input('material_id'); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('delivery_challan_id'); ?></div>
                    <div class="col-md-4"><?php echo $this->Form->input('received_date'); ?></div>
                    <div class="col-md-4"><?php echo $this->Form->input('quantity'); ?></div>
                    <div class="col-md-4"><?php echo $this->Form->input('branch_id', array('options' => $PublishedBranchList)); ?></div>
                    <div class="col-md-12"><?php echo $this->Form->input('remarks'); ?></div>
                </div>

            <?php } else { ?>
                <div class="row"><div class="col-md-12"><?php echo __('Invalid Selection'); ?></div></div>
            <?php } ?>

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
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#stocks_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>
<div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Import from file (excel & csv formats only)</h4>
            </div>
            <div class="modal-body"><?php echo $this->element('import'); ?></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
