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
            submitHandler: function(form) {
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
                    error: function(request, status, error) {
                        //alert(request.responseText);
			alert('Action failed!');
                    }
                });
            }
        });

        $().ready(function() {
            $("#submit-indicator").hide();
            jQuery.validator.addMethod("greaterThanZero", function(value, element) {
                return this.optional(element) || (parseFloat(value) > 0);
            }, "Please select the value");

            $('#DeliveryChallanAddAjaxForm').validate({
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
                $('#gaVals').load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_purchase_order/' + this.value).change(function() {
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
    <div class="nav">
        <div class="deliveryChallans form col-md-8">
            <h4><?php echo __('Add Delivery Challan'); ?></h4>
            <?php echo $this->Form->create('DeliveryChallan', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>

            <div class="row">
                <div class="col-md-6"><br /><h4><?php echo ('Select Purchase Order for this challan : '); ?></h4></div>
                <div class="col-md-6"><?php echo $this->Form->input('purchase_order_id', array('style' => 'width:100%', 'label' => __('Select Purchase Order'))); ?></div>
            </div>
            <div class="row">
                <div class="col-md-12"><div id="gaVals" style="clear:both"></div></div>
            </div>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('challan_number'); ?>
                    <label id="getChallan" class="error" style="clear:both" ></label>
                </div>
                <div class="col-md-6"><?php echo $this->Form->input('challan_date'); ?></div>
            </div>

            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('prices', array('value' => 0)); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('ship_by', array('value' => 'Hand Delivery')); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('shipping_details', array('value' => 'NIL')); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('insurance', array('value' => 'NIL')); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('shipping_date'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('ship_to', array('value' => $companyDetails['Company']['name'])); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('payment_details'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('invoice_to', array('value' => $companyDetails['Company']['name'])); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('acknowledgement_details', array('value' => 'Received')); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('acknowledgement_date'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('branch_id', array('style' => 'width:100%', 'label' => __('Branch'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('department_id', array('style' => 'width:100%', 'label' => __('Department'))); ?></div>
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
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#deliveryChallans_ajax', 'async' => 'false','id'=>'submit_id')); ?>
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
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>