<div id="deliveryChallans_ajax">
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
    <?php echo $this->fetch('script'); ?>

    <script>
        $("#customer").hide();
        $("#supplier").hide();

        function shhd(chk) {
            if (chk == 0) {
                $("#supplier").hide();
                $("#customer").show();
                $("#DeliveryChallanCustomerId_chosen").width('100%');
            } else {
                $("#customer").hide();
                $("#supplier").show();
                $("#DeliveryChallanSupplierRegistrationId_chosen").width('100%');
            }
        }

        $.validator.setDefaults({
            ignore: null,
            errorPlacement: function(error, element) {
                if ($(element).attr('name') == 'data[DeliveryChallan][branch_id]' ||
                        $(element).attr('name') == 'data[DeliveryChallan][department_id]' ||
                        $(element).attr('name') == 'data[DeliveryChallan][customer_id]' ||
                        $(element).attr('name') == 'data[DeliveryChallan][purchase_order_id]') {
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

            $('#DeliveryChallanApproveForm').validate({
                rules: {
                    "data[DeliveryChallan][branch_id]": {
                        greaterThanZero: true,
                    },
                    "data[DeliveryChallan][department_id]": {
                        greaterThanZero: true,
                    },
                    "data[DeliveryChallan][purchase_order_id]": {
                        greaterThanZero: true,
                    },
                    "data[DeliveryChallan][prices]": {
                        number: true,
                    },
                }
            });
              $("#submit-indicator").hide();
            $("#submit_id").click(function(){
             if($('#DeliveryChallanApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#DeliveryChallanApproveForm").submit();
             }

        });
            $('#DeliveryChallanBranchId').change(function() {
                if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                    $(this).next().next('label').remove();
                }
            });
            $('#DeliveryChallanDepartmentId').change(function() {
                if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                    $(this).next().next('label').remove();
                }
            });
            $('#DeliveryChallanPurchaseOrderId').change(function() {
                if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                    $(this).next().next('label').remove();
                }
            });
            $('#DeliveryChallanPurchaseOrderId').change(function() {
                $('#gaVals').load('<?php echo Router::url('/', true); ?>delivery_challans/get_purchase_order/' + this.value).change(function() {
                    $("[name*=rate]").each(function() {
                        $(this).rules("add", {
                            required: true,
                            number: true,
                            messages: {
                                required: "This field is required"
                            }
                        });
                    });
                    $("[name*=quantity_received]").each(function() {
                        $(this).rules("add", {
                            required: true,
                            number: true,
                            messages: {
                                required: "This field is required"
                            }
                        });
                    });
                });
            });



            $('#DeliveryChallanChallanNumber').blur(function() {


                $("#getChallan").load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_challan_number/' + encodeURIComponent(this.value), function(response, status, xhr) {
                    if (response != "") {
                        $('#DeliveryChallanChallanNumber').val('');
                        $('#DeliveryChallanChallanNumber').addClass('error');
                    } else {
                        $('#DeliveryChallanChallanNumber').removeClass('error');
                    }

                });
            });



        });
    </script>

    <div class="nav panel panel-default">
        <div class="deliveryChallans form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Approve Delivery Challan'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
            <?php echo $this->Form->create('DeliveryChallan', array('role' => 'form', 'class' => 'form')); ?>

            <?php echo $this->Form->input('id'); ?>


            <div class="row">
                <div class="col-md-6"><br /><h4><?php echo ('Select Purchase Order for this challan : '); ?></h4></div>
                <div class="col-md-6"><?php echo $this->Form->input('purchase_order_id', array('style' => 'width:100%', 'label' => __('Select Purchase Order'))); ?></div>
<script>
    $().ready(function() {
        $('#gaVals').load('<?php echo Router::url('/', true); ?>delivery_challans/get_challan_details/<?php echo $this->data['DeliveryChallan']['id'] ?>').change(function() {
                    $("[name*=rate]").each(function() {
                        $(this).rules("add", {
                            required: true,
                            number: true,
                            messages: {
                                required: "This field is required"
                            }
                        });
                    });
                    $("[name*=quantity_received]").each(function() {
                        $(this).rules("add", {
                            required: true,
                            number: true,
                            messages: {
                                required: "This field is required"
                            }
                        });
                    });
                });
            });
</script>
            </div>
            <div class="row">
                <div class="col-md-12"><div id="gaVals" style="clear:both"></div></div>
            </div>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('challan_number'); ?>
                    <label id="getChallan" style="clear:both" class="error"></label>
                </div>
                <div class="col-md-6"><?php echo $this->Form->input('challan_date'); ?></div>
            </div>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('prices'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('ship_by'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('shipping_details'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('insurance'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('shipping_date'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('ship_to'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('payment_details'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('invoice_to'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('acknowledgement_details'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('acknowledgement_date'); ?></div>
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
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#deliveryChallans_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>