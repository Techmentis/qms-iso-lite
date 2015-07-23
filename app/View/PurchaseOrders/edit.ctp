<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>
<?php $i = 0; $j = 1; ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {
            if ( $(element).attr('name') == 'data[PurchaseOrder][customer_id]' ||
                  $(element).attr('name') == 'data[PurchaseOrder][supplier_registration_id]' ||
		  $(element).attr('name').match(/product_id/g) ||
                  $(element).attr('name').match(/device_id/g) ||
       		  $(element).attr('name').match(/material_id/g) ||
                  $(element).attr('name') == 'data[PurchaseOrder][type]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        },
    });

    $().ready(function() {

        jQuery.validator.addMethod("greaterThanZero", function(value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");
        $('#PurchaseOrderEditForm').validate();
        $("#submit-indicator").hide();
        $("#submit_id").click(function(){
             if($('#PurchaseOrderEditForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
                 $("#PurchaseOrderEditForm").submit();
             }
        });

        $('#PurchaseOrderSupplierRegistrationId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#PurchaseOrderCustomerId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $("[name*='product_id']").change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $("[name*='device_id']").change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $("[name*='material_id']").change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });

        $('#PurchaseOrderPurchaseOrderNumber').blur(function() {

            $("#getPurchaseOrderNumber").load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_purchase_order_number/' + encodeURIComponent(this.value), function(response, status, xhr) {
                if (response != "") {
                    $('#PurchaseOrderPurchaseOrderNumber').val('');
                    $('#PurchaseOrderPurchaseOrderNumber').addClass('error');
                } else {
                    $('#PurchaseOrderPurchaseOrderNumber').removeClass('error');
                }
            });
        });
    });
    function shhd(chk) {
        if (chk == 0) {
            $("#supplier").hide();
            $("#other").hide();
            $("#customer").show();
            $("#PurchaseOrderCustomerId_chosen").width('100%');
            $('#PurchaseOrderSupplierRegistrationId').rules('remove');
            $('#PurchaseOrderSupplierRegistrationId').val(-1).trigger('chosen:updated');
            if ($('#PurchaseOrderSupplierRegistrationId').next().next('label').hasClass("error")) {
                $('#PurchaseOrderSupplierRegistrationId').next().next('label').remove();
            }
            $('#PurchaseOrderOther').rules('remove');
            $('#PurchaseOrderOther').val("");
            if ($('#PurchaseOrderOther').next('label').hasClass("error")) {
                $('#PurchaseOrderOther').next('label').remove();
            }
            $('#PurchaseOrderCustomerId').rules('add', {
                greaterThanZero: true
            });
        } else if (chk == 1) {
            $("#customer").hide();
            $("#other").hide();
            $("#supplier").show();
            $("#PurchaseOrderSupplierRegistrationId_chosen").width('100%');
            $('#PurchaseOrderCustomerId').rules('remove');
            $('#PurchaseOrderCustomerId').val(-1).trigger('chosen:updated');
            if ($('#PurchaseOrderCustomerId').next().next('label').hasClass("error")) {
                $('#PurchaseOrderCustomerId').next().next('label').remove();
            }
            $('#PurchaseOrderOther').rules('remove');
            $('#PurchaseOrderOther').val("");
            if ($('#PurchaseOrderOther').next('label').hasClass("error")) {
                $('#PurchaseOrderOther').next('label').remove();
            }
            $('#PurchaseOrderSupplierRegistrationId').rules('add', {
                greaterThanZero: true
            });
        } else {
            $("#customer").hide();
            $("#supplier").hide();
            $("#other").show();
            $('#PurchaseOrderSupplierRegistrationId').rules('remove');
            $('#PurchaseOrderSupplierRegistrationId').val(-1).trigger('chosen:updated');
            if ($('#PurchaseOrderSupplierRegistrationId').next().next('label').hasClass("error")) {
                $('#PurchaseOrderSupplierRegistrationId').next().next('label').remove();
            }
            $('#PurchaseOrderCustomerId').rules('remove');
            $('#PurchaseOrderCustomerId').val(-1).trigger('chosen:updated');
            if ($('#PurchaseOrderCustomerId').next().next('label').hasClass("error")) {
                $('#PurchaseOrderCustomerId').next().next('label').remove();
            }
            $('#PurchaseOrderOther').rules('add', {
                required: true
            });
        }
    }
    function addAgendaDiv(args) {
        var i = parseInt($('#PurchaseOrderAgendaNumber').val());
        $('#PurchaseOrderAgendaNumber').val();
        $.get("<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/add_purchase_order_details/" + i, function(data) {
            $('#purchaseOrderDetails_ajax').append(data);
        });
        i = i + 1;
        $('#PurchaseOrderAgendaNumber').val(i);
    }
    function removeAgendaDiv(i) {
        var r = confirm("Are you sure to remove this order details?");
        if (r == true)
        {
            $('#purchaseOrderDetails_ajax' + i).remove();
        }
    }

</script>

<div id="purchaseOrders_ajax">
<?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="purchaseOrders form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Edit Purchase Order'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>

            </h4>
            <?php echo $this->Form->create('PurchaseOrder', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('title', array('label' => __('Title'))); ?></div>
                <div class="col-md-3"><?php echo $this->Form->input('purchase_order_number'); ?>
                    <label id="getPurchaseOrderNumber" class="error" style="clear:both" ></label>
                </div>
                <div class="col-md-3"><?php echo $this->Form->input('order_date', array('label' => __('Order Date'))); ?></div>
            </div>
            <div class="row">
                <div class="col-md-6"><?php
                    echo $this->Form->input('type', array(
                        'options' => array('Inbound', 'Outbound', 'Other'),
                        'type' => 'radio',
                        'onClick' => 'shhd(this.value)', 'class' => 'checkbox-2',
                        'legend' => __('Select Type'), 'default' => 0));
                    ?>
                </div>
                <div class="col-md-6">
                    <?php if ($this->data['PurchaseOrder']['type'] == 0) { ?>
                        <div id="customer"><?php echo $this->Form->input('customer_id', array('style' => 'width:100%;')); ?></div>
                        <div id="supplier"><?php echo $this->Form->input('supplier_registration_id', array('style' => 'width:100%')); ?></div>
                        <div id="other"><?php echo $this->Form->input('other'); ?></div>
                        <script>shhd(0);</script>
                    <?php } elseif ($this->data['PurchaseOrder']['type'] == 1) { ?>
                        <div id="customer"><?php echo $this->Form->input('customer_id', array('style' => 'width:100%;')); ?></div>
                        <div id="supplier"><?php echo $this->Form->input('supplier_registration_id', array('style' => 'width:100%')); ?></div>
                        <div id="other"><?php echo $this->Form->input('other'); ?></div>
                        <script>shhd(1);</script>
                    <?php } else { ?>
                        <div id="customer"><?php echo $this->Form->input('customer_id', array('style' => 'width:100%')); ?></div>
                        <div id="supplier"><?php echo $this->Form->input('supplier_registration_id', array('style' => 'width:100%;')); ?></div>
                        <div id="other"><?php echo $this->Form->input('other'); ?></div>
                        <script>shhd(2);</script>
                    <?php } ?>
                </div>
                <div class="col-md-12"><?php echo $this->Form->input('details'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('intimation'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('expected_delivery_date'); ?></div>
            </div>
            <br/><br/>

            <?php $i = 0; $j = 1; ?>
            <div id="purchaseOrderDetails_ajax">
            <?php foreach ($purchaseOrderDetail as $val) { ?>
                <div id="purchaseOrderDetails_ajax<?php echo $i; ?>">
                        <div>
                            <div class="panel panel-default">
                                <div class="panel-heading"><?php echo __('Order Detail'); ?><span class="alert-danger glyphicon glyphicon-remove danger pull-right" style="font-size:20px;background:none"type="button" onclick='removeAgendaDiv(<?php echo $i; ?>)'></span></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-2"><?php echo $this->Form->input('PurchaseOrderDetail.' . $i . '.item_number', array('label' => __('Item Number'))); ?></div>
                                        <div class="col-md-6">
                                            <?php
                                                if ($this->data['PurchaseOrderDetail'][$i]['product_id'] != -1) {
                                                    $prod_type = 'product';
                                                } elseif ($this->data['PurchaseOrderDetail'][$i]['device_id'] != -1) {
                                                    $prod_type = 'device';
                                                } elseif ($this->data['PurchaseOrderDetail'][$i]['material_id'] != -1) {
                                                    $prod_type = 'material';
                                                } else {
                                                    $prod_type = 'other';
                                                }
                                            ?>
                                            <?php
                                                echo $this->Form->input('PurchaseOrderDetail.' . $i . '.product_type', array(
                                                    'options' => array('product' => 'Product', 'device' => 'Device', 'material' => 'Material', 'other' => 'Other'),
                                                    'type' => 'radio',
                                                    'onClick' => 'choose_product_' . $i . '(this.value)',
                                                    'class' => 'checkbox-2',
                                                    'legend' => __('Select Type'),
                                                    'default' => $prod_type));
                                            ?>
                                        </div>
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
                                        <div class="col-md-3">
                                            <?php echo $this->Form->input('PurchaseOrderDetail.' . $i . '.discount', array('placeholder' => '%', 'label' => __('Discount (% only)'))); ?>
                                            <div id="error<?php echo $i; ?>" style="color:red;"></div>
                                        </div>
                                        <div class="col-md-3"><?php echo $this->Form->input('PurchaseOrderDetail.' . $i . '.total', array('label' => __('Total'), 'readonly' => 'readonly')); ?></div>
                                        <div class="col-md-12"><?php echo $this->Form->input('PurchaseOrderDetail.' . $i . '.description', array('label' => __('Description'), 'type' => 'textarea')); ?></div>
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
    $('#PurchaseOrderDetail<?php echo $i; ?>Discount').blur(function () {
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
        $("#product_dd<?php echo $i; ?>").hide();
        $("#device_dd<?php echo $i; ?>").hide();
        $("#material_dd<?php echo $i; ?>").hide();
        $("#other_dd<?php echo $i; ?>").hide();
        if (chk == 'product') {
            $("#product_dd<?php echo $i; ?>").show();
            $("#device_dd<?php echo $i; ?>").hide();
            $("#material_dd<?php echo $i; ?>").hide();
            $("#other_dd<?php echo $i; ?>").hide();
            $("#PurchaseOrderDetail<?php echo $i; ?>ProductId_chosen").width('100%');
            $('#PurchaseOrderDetail<?php echo $i; ?>DeviceId').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>MaterialId').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>Other').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>Other').val("");
            $('#PurchaseOrderDetail<?php echo $i; ?>ProductId').rules('add', {
                greaterThanZero: true
            });
            $('#PurchaseOrderDetail<?php echo $i; ?>DeviceId').next().next('label').remove();
            $('#PurchaseOrderDetail<?php echo $i; ?>DeviceId').val(-1).trigger('chosen:updated');
            $('#PurchaseOrderDetail<?php echo $i; ?>MaterialId').next().next('label').remove();
            $('#PurchaseOrderDetail<?php echo $i; ?>MaterialId').val(-1).trigger('chosen:updated');
        } else if (chk == 'device') {
            $("#device_dd<?php echo $i; ?>").show();
            $("#product_dd<?php echo $i; ?>").hide();
            $("#material_dd<?php echo $i; ?>").hide();
            $("#other_dd<?php echo $i; ?>").hide();
            $("#PurchaseOrderDetail<?php echo $i; ?>DeviceId_chosen").width('100%');
            $('#PurchaseOrderDetail<?php echo $i; ?>ProductId').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>Other').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>Other').val("");
            $('#PurchaseOrderDetail<?php echo $i; ?>DeviceId').rules('add', {
                greaterThanZero: true
            });
            $('#PurchaseOrderDetail<?php echo $i; ?>ProductId').next().next('label').remove();
            $('#PurchaseOrderDetail<?php echo $i; ?>ProductId').val(-1).trigger('chosen:updated');
            $('#PurchaseOrderDetail<?php echo $i; ?>MaterialId').next().next('label').remove();
            $('#PurchaseOrderDetail<?php echo $i; ?>MaterialId').val(-1).trigger('chosen:updated');
        } else if (chk == 'material') {
            $("#material_dd<?php echo $i; ?>").show();
            $("#product_dd<?php echo $i; ?>").hide();
            $("#device_dd<?php echo $i; ?>").hide();
            $("#other_dd<?php echo $i; ?>").hide();
            $("#PurchaseOrderDetail<?php echo $i; ?>MaterialId_chosen").width('100%');
            $('#PurchaseOrderDetail<?php echo $i; ?>ProductId').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>DeviceId').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>Other').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>Other').val("");
            $('#PurchaseOrderDetail<?php echo $i; ?>MaterialId').rules('add', {
                greaterThanZero: true
            });
            $('#PurchaseOrderDetail<?php echo $i; ?>ProductId').next().next('label').remove();
            $('#PurchaseOrderDetail<?php echo $i; ?>ProductId').val(-1).trigger('chosen:updated');
            $('#PurchaseOrderDetail<?php echo $i; ?>DeviceId').next().next('label').remove();
            $('#PurchaseOrderDetail<?php echo $i; ?>DeviceId').val(-1).trigger('chosen:updated');
        } else if (chk == 'other') {
            $("#other_dd<?php echo $i; ?>").show();
            $("#product_dd<?php echo $i; ?>").hide();
            $("#device_dd<?php echo $i; ?>").hide();
            $("#material_dd<?php echo $i; ?>").hide();
            $('#PurchaseOrderDetail<?php echo $i; ?>ProductId').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>ProductId').val(-1).trigger('chosen:updated');
            $('#PurchaseOrderDetail<?php echo $i; ?>DeviceId').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>DeviceId').val(-1).trigger('chosen:updated');
            $('#PurchaseOrderDetail<?php echo $i; ?>MaterialId').rules('remove');
            $('#PurchaseOrderDetail<?php echo $i; ?>MaterialId').val(-1).trigger('chosen:updated');
            $('#PurchaseOrderDetail<?php echo $i; ?>Other').rules('add', {
                required: true
            });

        }
    }
    choose_product_<?php echo $i; ?> ('<?php echo $prod_type; ?>');
</script>

                    </div>
            <?php $i++; $j++; } ?>
            </div>

            <div class="col-md-6"><?php echo $this->Form->input('agendaNumber', array('type' => 'hidden', 'value' => $i)); ?></div>
            <?php echo $this->Form->button('Add New Order Detail', array('label' => false, 'type' => 'button', 'div' => false, 'class' => 'btn btn-md btn-info pull-right', 'onclick' => 'addAgendaDiv()')); ?>
            <div class="clearfix">&nbsp;</div>

        <?php
            if ($showApprovals && $showApprovals['show_panel'] == true) {
                echo $this->element('approval_form');
            } else {
                echo $this->Form->input('publish', array('label' => __('Publish')));
            }
        ?>
        <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#purchaseOrders_ajax', 'async' => 'false','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
        <?php echo $this->Form->end(); ?>
        <?php echo $this->Js->writeBuffer(); ?>
        </div>

<script>
    var startDateTextBox = $('#PurchaseOrderOrderDate');
    var endDateTextBox = $('#PurchaseOrderExpectedDeliveryDate');

    startDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
        changeMonth: true,
        changeYear: true,
        onClose: function(dateText, inst) {
            if (endDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker('getDate');
                if (testStartDate > testEndDate) {
                    endDateTextBox.val(startDateTextBox.val());
                }
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
        'showTimepicker': false,
        changeMonth: true,
        changeYear: true,
        onClose: function(dateText, inst) {
            if (startDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker('getDate');
                if (testStartDate > testEndDate)
                    startDateTextBox.val(endDateTextBox.val());
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

        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
<?php $this->Js->get('#list'); ?>
<?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#purchaseOrders_ajax'))); ?>
<?php echo $this->Js->writeBuffer(); ?>
</div>
