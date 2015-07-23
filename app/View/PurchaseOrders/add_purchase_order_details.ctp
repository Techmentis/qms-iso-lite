<script>
    $(".chosen-select").chosen();
</script>

<div id="purchaseOrderDetails_ajax">
    <div id="purchaseOrderDetails_ajax<?php echo $i; ?>">
        <div>
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo __('Order Details'); ?><span class="alert-danger glyphicon glyphicon-remove danger pull-right" style="font-size:20px;background:none"type="button" onclick='removeAgendaDiv(<?php echo $i; ?>)'></span></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2"><?php echo $this->Form->input('PurchaseOrderDetail.' . $i . '.item_number', array('label' => __('Item Number'))); ?></div>
                        <div class="col-md-6"><?php
                            echo $this->Form->input('PurchaseOrderDetail.' . $i . '.product_type', array(
                                'options' => array('product' => 'Product', 'device' => 'Device', 'material' => 'Material', 'other' => 'Other'),
                                'type' => 'radio',
                                'onClick' => 'choose_product_' . $i . '(this.value)',
                                'class' => 'checkbox-2',
                                'legend' => __('Select Type'), 'default' => 'product'));
                            ?></div>
                        <div class="col-md-4">
                            <div  id="product_dd<?php echo $i; ?>">
                                <?php echo $this->Form->input('PurchaseOrderDetail.' . $i . '.product_id', array('label' => __('Product'))); ?>
                            </div>
                            <div  id="device_dd<?php echo $i; ?>">
                                <?php echo $this->Form->input('PurchaseOrderDetail.' . $i . '.device_id', array('label' => __('Device'))); ?>
                            </div>
                            <div  id="material_dd<?php echo $i; ?>">
                                <?php echo $this->Form->input('PurchaseOrderDetail.' . $i . '.material_id', array('label' => __('Material'))); ?>
                            </div>
                            <div  id="other_dd<?php echo $i; ?>">
                                <?php echo $this->Form->input('PurchaseOrderDetail.' . $i . '.other', array('label' => __('Other'))); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><?php echo $this->Form->input('PurchaseOrderDetail.' . $i . '.quantity', array('label' => __('Quantity'))); ?></div>
                        <div class="col-md-3"><?php echo $this->Form->input('PurchaseOrderDetail.' . $i . '.rate', array('label' => __('Rate'))); ?></div>
                        <div class="col-md-3"><?php echo $this->Form->input('PurchaseOrderDetail.' . $i . '.discount', array('placeholder' => '%', 'label' => __('Discount (% only)'))); ?>
                            <div id="error<?php echo $i; ?>" style="color:red;"></div>
                        </div>
                        <div class="col-md-3"><?php echo $this->Form->input('PurchaseOrderDetail.' . $i . '.total', array('label' => __('Total'), 'readonly' => 'readonly')); ?></div>
                        <div class="col-md-12"><?php echo $this->Form->input('PurchaseOrderDetail.' . $i . '.description', array('label' => __('Description'), 'type' => 'textarea')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('PurchaseOrderDetail.' . $i . '.branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('PurchaseOrderDetail.' . $i . '.departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?></div>
                    </div>
                </div>
            </div>
        </div>

<script>
    $('#PurchaseOrderDetail<?php echo $i; ?>Rate').blur(function () {
        var total = $('#PurchaseOrderDetail<?php echo $i; ?>Rate').val() * $('#PurchaseOrderDetail<?php echo $i; ?>Quantity').val();
        if ($('#PurchaseOrderDetail<?php echo $i; ?>Discount').val() != null) {
            var discounted = total - (total * $('#PurchaseOrderDetail<?php echo $i; ?>Discount').val() / 100);
        } else {
            var discounted = total;
        }
        $('#PurchaseOrderDetail<?php echo $i; ?>Total').val(discounted);
    });
    $('#PurchaseOrderDetail<?php echo $i; ?>Quantity').blur(function () {
        var total = $('#PurchaseOrderDetail<?php echo $i; ?>Rate').val() * $('#PurchaseOrderDetail<?php echo $i; ?>Quantity').val();
        if ($('#PurchaseOrderDetail<?php echo $i; ?>Discount').val() != null) {
            var discounted = total - (total * $('#PurchaseOrderDetail<?php echo $i; ?>Discount').val() / 100);
        } else {
            var discounted = total;
        }
        $('#PurchaseOrderDetail<?php echo $i; ?>Total').val(discounted);
    });
    $('#PurchaseOrderDetail<?php echo $i; ?>Discount').blur(function() {
        if ($('#PurchaseOrderDetail<?php echo $i; ?>Discount').val() <= 100) {
                $('#error<?php echo $i; ?>').html('').hide();
            var total = $('#PurchaseOrderDetail<?php echo $i; ?>Rate').val() * $('#PurchaseOrderDetail<?php echo $i; ?>Quantity').val();
            if ($('#PurchaseOrderDetail<?php echo $i; ?>Discount').val()) {
                var discounted = total - (total * $('#PurchaseOrderDetail<?php echo $i; ?>Discount').val() / 100);
            } else {
                var discounted = total;
            }
            $('#PurchaseOrderDetail<?php echo $i; ?>Total').val(discounted);
        }else{
                $('#error<?php echo $i; ?>').addClass('error');
                $('#error<?php echo $i; ?>').html('Please enter value less than or equal to 100').show();
            $('#PurchaseOrderDetail<?php echo $i; ?>Discount').addClass("error");
            $('#PurchaseOrderDetail<?php echo $i; ?>Discount').val('');
            
        }
    });


    function choose_product_<?php echo $i; ?> (chk) {
        if (chk == 'product') {
            $("#device_dd<?php echo $i; ?>").hide();
            $("#other_dd<?php echo $i; ?>").hide();
            $("#material_dd<?php echo $i; ?>").hide();
            $("#product_dd<?php echo $i; ?>").show();
            $("#PurchaseOrderDetail<?php echo $i; ?>ProductId_chosen").width('100%');
            $('#PurchaseOrderDetail<?php echo $i; ?>DeviceId').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>Other').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>Other').val("");
            $('#PurchaseOrderDetail<?php echo $i; ?>MaterialId').rules('remove');

            $('#PurchaseOrderDetail<?php echo $i; ?>ProductId').rules('add', {
                greaterThanZero: true
            });
            $('#PurchaseOrderDetail<?php echo $i; ?>DeviceId').next().next('label').remove();
            $('#PurchaseOrderDetail<?php echo $i; ?>DeviceId').val(-1).trigger('chosen:updated');
            $('#PurchaseOrderDetail<?php echo $i; ?>MaterialId').next().next('label').remove();
            $('#PurchaseOrderDetail<?php echo $i; ?>MaterialId').val(-1).trigger('chosen:updated');
        } else if (chk == 'device') {
            $("#product_dd<?php echo $i; ?>").hide();
            $("#other_dd<?php echo $i; ?>").hide();
            $("#material_dd<?php echo $i; ?>").hide();
            $("#device_dd<?php echo $i; ?>").show();
            $("#PurchaseOrderDetail<?php echo $i; ?>DeviceId_chosen").width('100%');
            $('#PurchaseOrderDetail<?php echo $i; ?>ProductId').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>Other').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>Other').val("");
            $('#PurchaseOrderDetail<?php echo $i; ?>MaterialId').rules('remove');

            $('#PurchaseOrderDetail<?php echo $i; ?>DeviceId').rules('add', {
                greaterThanZero: true
            });
            $('#PurchaseOrderDetail<?php echo $i; ?>ProductId').next().next('label').remove();
            $('#PurchaseOrderDetail<?php echo $i; ?>ProductId').val(-1).trigger('chosen:updated');
            $('#PurchaseOrderDetail<?php echo $i; ?>MaterialId').next().next('label').remove();
            $('#PurchaseOrderDetail<?php echo $i; ?>MaterialId').val(-1).trigger('chosen:updated');
        } else if (chk == 'material') {
            $("#product_dd<?php echo $i; ?>").hide();
            $("#other_dd<?php echo $i; ?>").hide();
            $("#device_dd<?php echo $i; ?>").hide();
            $("#material_dd<?php echo $i; ?>").show();
            $('#PurchaseOrderDetail<?php echo $i; ?>DeviceId').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>ProductId').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>Other').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>Other').val("");
            $('#PurchaseOrderDetail<?php echo $i; ?>MaterialId').rules('add', {
                greaterThanZero: true
            });
            $('#PurchaseOrderDetail<?php echo $i; ?>DeviceId').next().next('label').remove();
            $('#PurchaseOrderDetail<?php echo $i; ?>DeviceId').val(-1).trigger('chosen:updated');
            $('#PurchaseOrderDetail<?php echo $i; ?>ProductId').next().next('label').remove();
            $('#PurchaseOrderDetail<?php echo $i; ?>ProductId').val(-1).trigger('chosen:updated');
        } else if (chk == 'other') {
            $("#product_dd<?php echo $i; ?>").hide();
            $("#device_dd<?php echo $i; ?>").hide();
            $("#material_dd<?php echo $i; ?>").hide();
            $("#other_dd<?php echo $i; ?>").show();
            $('#PurchaseOrderDetail<?php echo $i; ?>ProductId').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>DeviceId').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>MaterialId').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>MaterialId').val(-1).trigger('chosen:updated');
            $('#PurchaseOrderDetail<?php echo $i; ?>ProductId').val(-1).trigger('chosen:updated');
            $('#PurchaseOrderDetail<?php echo $i; ?>DeviceId').val(-1).trigger('chosen:updated');
            $('#PurchaseOrderDetail<?php echo $i; ?>Other').rules('add', {
                required: true
            });
        }
    }
    choose_product_<?php echo $i; ?> ('product');
</script>

    </div>
    <?php $i++; $j++; ?>
</div>