<div id="customerComplaints_ajax">
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
    <?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {
            if ($(element).attr('name') == 'data[CustomerComplaint][customer_id]' ||
                    $(element).attr('name') == 'data[CustomerComplaint][employee_id]' ||
                    $(element).attr('name') == 'data[CustomerComplaint][product_id]' ||
                    $(element).attr('name') == 'data[CustomerComplaint][delivery_challan_id]' ||
                    $(element).attr('name') == 'data[CustomerComplaint][capa_source_id]') {
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

        $('#CustomerComplaintAddAjaxForm').validate({
            rules: {
                "data[CustomerComplaint][customer_id]": {
                    greaterThanZero: true,
                },
                "data[CustomerComplaint][employee_id]": {
                    greaterThanZero: true,
                },
                "data[CustomerComplaint][product_id]": {
                    greaterThanZero: true,
                },
                "data[CustomerComplaint][delivery_challan_id]": {
                    greaterThanZero: true,
                },
            }
        });
        $('#CustomerComplaintCustomerId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#CustomerComplaintEmployeeId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#CustomerComplaintProductId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#CustomerComplaintDeliveryChallanId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#CustomerComplaintCapaSourceId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });

        $("#capaSrc").hide();

        $("[name='data[CustomerComplaint][add_to_capa]']").change(function() {
            if ($("[name='data[CustomerComplaint][add_to_capa]']:checked").val() == 0) {
                $("#CustomerComplaintCapaSourceId_chosen").width('214px');
                $("#capaSrc").show();
                $('#CustomerComplaintCapaSourceId').rules('add', {
                    greaterThanZero: true
                });
            } else {
                $("#capaSrc").hide();
                $('#CustomerComplaintCapaSourceId').rules('remove');
                if ($('#CustomerComplaintCapaSourceId').next().next('label').hasClass("error")) {
                    ('#CustomerComplaintCapaSourceId').next().next('label').remove();
                }
            }
        });

    });

    $('#CustomerComplaintComplaintNumber').blur(function (){
        if(this.value != ''){
            $('#customer_complaint_number').load("<?php echo Router::url('/', true) . $this->request->params['controller'] ?>/check_complaint_number/" + encodeURIComponent(this.value), function(data){
                if(data != ''){
                    $('#CustomerComplaintComplaintNumber').val('');
                    $('#customer_complaint_number').show();
                    $('#CustomerComplaintComplaintNumber').addClass('error');
                }else{
                    $('#CustomerComplaintComplaintNumber').removeClass('error');
                }
            });
        }
    });

    $("#CustomerComplaintComplaintSource").change(function() {
        $("#src").show();
        if ($("#CustomerComplaintComplaintSource").val() == 0) {
            $('#CustomerComplaintDeliveryChallanId').rules('remove');
            $("#deliveryChallan").hide();
            if ($('#CustomerComplaintDeliveryChallanId').next().next('label').hasClass("error")) {
                $('#CustomerComplaintDeliveryChallanId').next().next('label').remove();
            }
            $("#product").show();
            $("#CustomerComplaintProductId_chosen").width('339px');
            $('#CustomerComplaintProductId').rules('add', {
                greaterThanZero: true
            });
        } else if ($("#CustomerComplaintComplaintSource").val() == 2) {
            $('#CustomerComplaintProductId').rules('remove');
            $("#product").hide();
            if ($('#CustomerComplaintProductId').next().next('label').hasClass("error")) {
                $('#CustomerComplaintProductId').next().next('label').remove();
            }
            $("#deliveryChallan").show();
            $("#CustomerComplaintDeliveryChallanId_chosen").width('339px');
            $('#CustomerComplaintDeliveryChallanId').rules('add', {
                greaterThanZero: true
            });
        } else {
            $("#product").hide();
            $('#CustomerComplaintProductId').rules('remove');
            if ($('#CustomerComplaintProductId').next().next('label').hasClass("error")) {
                $('#CustomerComplaintProductId').next().next('label').remove();
            }
            $("#deliveryChallan").hide();
            $('#CustomerComplaintDeliveryChallanId').rules('remove');
            if ($('#CustomerComplaintDeliveryChallanId').next().next('label').hasClass("error")) {
                $('#CustomerComplaintDeliveryChallanId').next().next('label').remove();
            }
        }
    });
</script>

    <div class="nav">
        <div class="customerComplaints form col-md-8">
            <h4><?php echo __('Add Customer Complaint'); ?></h4>
            <?php echo $this->Form->create('CustomerComplaint', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>

            <div class="row">
                <?php $options = array('0' => 'Customer Complaint', '1' => 'Customer Feedback'); ?>
                <div class="col-md-6"><?php echo $this->Form->input('type', array('options' => $options, 'default' => 0, 'disabled'), array()); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('customer_id', array('style' => 'width:100%')); ?></div>
            </div>
            <div class="row">
                <?php $options = array('0' => 'Product', '1' => 'Service', '2' => 'Delivery', '3' => 'Customer Care'); ?>
                <div class="col-md-6"><?php echo $this->Form->input('complaint_source', array('options' => $options, 'style' => 'width:100%')); ?></div>
                <div class="col-md-6">
                    <div id="src" style="display: none">
                        <div id="product"><?php echo $this->Form->input('product_id', array('style' => 'width:100%')); ?></div>
                        <div id="deliveryChallan"><?php echo $this->Form->input('delivery_challan_id', array('style' => 'width:100%')); ?></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('complaint_number'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('complaint_date'); ?></div>
                <div class="col-md-12"><label id="customer_complaint_number" class="error" style="display: none"></label></div>
                <div class="col-md-12"><?php echo $this->Form->input('details'); ?></div>

                <?php if (!($this->Session->read('User.is_mr') == 0 or $this->Session->read('User.is_mr') == false )) { ?>

                    <div class="col-md-6">
                        <?php
                            if ($employees)
                                echo $this->Form->input('employee_id', array('label' => __('Assigned To'), 'style' => 'width:100%'));
                            else {
                                echo "<p class='alert help-text text-danger '><strong>Note:</strong><br />There are no employees / users in QC department to whom you can assign this complaint. Click " . $this->Html->link('here', array('controller' => 'users', 'action' => 'lists')) . " to add new user </p>";
                            }
                        ?>
                    </div>
                    <div class="col-md-6"><?php echo $this->Form->input('target_date'); ?></div>
                </div>
                <div class="row">
                    <div class="col-md-12"><hr /></div>
                </div>
                <div class="row">
                    <div class="col-md-4"><?php
                        echo "<label>" . __('Current Status') . "</label>";
                        echo $this->Form->input('current_status', array('label' => '', 'legend' => false, 'value' => false, 'div' => false, 'options' => array('0' => 'Open', '1' => 'Close'), 'type' => 'radio', 'style' => 'float:none'));
                        ?></div>
                    <?php $options = array('0' => 'Yes', '1' => 'No'); ?>
                    <div class="col-md-4"><?php
                        echo "<label>" . __('Add To CAPA ?') . "</label>";
                        echo $this->Form->input('add_to_capa', array('label' => '', 'legend' => false, 'default' => 1, 'div' => false, 'options' => $options, 'type' => 'radio', 'style' => 'float:none'));
                        ?></div>
                    <div id="capaSrc" class="col-md-4"><?php echo $this->Form->input('capa_source_id'); ?></div>
                </div>
                <div class="row">
                    <div class="col-md-12"><hr /></div>
                </div>
                <div class="row">
                    <div class="col-md-12"><?php echo $this->Form->input('action_taken'); ?></div>
                    <div class="col-md-4"><?php echo $this->Form->input('action_taken_date'); ?></div>
                    <div class="col-md-4"><?php echo $this->Form->input('settled_date'); ?></div>
                    <div class="col-md-4"><?php echo $this->Form->input('authorized_by',array('type'=>'select','options'=>$PublishedEmployeeList)); ?></div>
                <?php } ?>

                <?php
                    echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id')));
                    echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id')));
                    echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id']));
                ?>
            </div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#customerComplaints_ajax', 'async' => 'false','id'=>'submit_id')); ?>
             <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>

<script>
    $("#CustomerComplaintTargetDate").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
    $("#CustomerComplaintActionTakenDate").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');

    $("#CustomerComplaintSettledDate").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');


      $("#CustomerComplaintComplaintDate").datetimepicker({
         changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
        onSelect: function(selectedDateTime) {
            $("#CustomerComplaintTargetDate").datetimepicker('option', 'minDate', $("#CustomerComplaintComplaintDate").datetimepicker('getDate'));
            $("#CustomerComplaintActionTakenDate").datetimepicker('option', 'minDate', $("#CustomerComplaintComplaintDate").datetimepicker('getDate'));
            $("#CustomerComplaintSettledDate").datetimepicker('option', 'minDate', $("#CustomerComplaintComplaintDate").datetimepicker('getDate'));

        }
    }).attr('readonly', 'readonly');

    $("#CustomerComplaintComplaintDate").datetimepicker('option', 'maxDate', 0);
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