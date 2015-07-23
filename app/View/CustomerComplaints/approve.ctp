    <?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
    <?php echo $this->fetch('script'); ?>
<div id="customerComplaints_ajax">
    <?php echo $this->Session->flash(); ?>
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
            }
        });

        $().ready(function() {
        hideCapa();
        $(".chosen-select").chosen();
              $("#submit-indicator").hide();
              $("#submit_id").click(function(){
             if($('#CustomerComplaintApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#CustomerComplaintApproveForm").submit();
             }
        });

            jQuery.validator.addMethod("greaterThanZero", function(value, element) {
                return this.optional(element) || (parseFloat(value) > 0);
            }, "Please select the value");

            $('#CustomerComplaintApproveForm').validate({
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
                    }
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

            dispSelected();
            capaChk();
            $("#CustomerComplaintComplaintSource").change(function() {
                dispSelected();
            });

            $("[name='data[CustomerComplaint][add_to_capa]']").change(function() {
                capaChk();
            });

        function capaChk() {
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
        }
        function dispSelected() {
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
        }

        $('#CustomerComplaintComplaintNumber').blur(function (){
            if(this.value != ''){
                $('#customer_complaint_number').load("<?php echo Router::url('/', true) . $this->request->params['controller'] ?>/check_complaint_number/" + encodeURIComponent(this.value) + "/<?php echo $this->data['CustomerComplaint']['id']?>", function(data){
                    if (data != '') {
                        $('#CustomerComplaintComplaintNumber').val('');
                        $('#customer_complaint_number').show();
                        $('#CustomerComplaintComplaintNumber').addClass('error');
                    } else {
                        $('#CustomerComplaintComplaintNumber').removeClass('error');
                    }
    });
            }
        });
    });
    
    function hideCapa(){
        if($('#CustomerComplaintAddToCapa0').is(':checked')){
            $('#capaDetail').addClass('alert-danger');
            $('#CustomerComplaintAddToCapa0').prop('disabled','disabled');
            $('#CustomerComplaintAddToCapa1').prop('disabled','disabled');
            $('#CustomerComplaintCapaSourceId').prop('disabled','disabled');
            $('#capaMsg').show();
        }else{
            $('#capaMsg').hide();
            $('#capaDetail').removeClass('alert-danger');
        }
    }
    </script>

    <div class="nav panel panel-default">
        <div class="customerComplaints form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Approve Customer Complaint'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
            <?php echo $this->Form->create('CustomerComplaint', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>

            <div class="row">
                <?php $options = array(0 => 'Customer Complaint'); ?>
                <div class="col-md-6"><div class="alert"><strong>Type: </strong>Customer Complaint</div></div>
                <div class="col-md-6"><?php echo $this->Form->input('customer_id', array('style' => 'width:100%')); ?></div>
            </div>
            <div class="row">
                <?php $options = array('0' => 'Product', '1' => 'Service', '2' => 'Delivery', '3' => 'Customer Care'); ?>
                <div class="col-md-6"><?php echo $this->Form->input('complaint_source', array('options' => $options, 'default' => $this->data['CustomerComplaint']['complaint_source'], 'style' => 'width:100%')); ?></div>
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
                                echo $this->Form->input('employee_id', array('label' => __('Assigned To'), 'style' => 'width:100%', 'disabled'));
                                echo "<span class='help-text'>There are no employees / users in QC department <br /> click " . $this->Html->link('here', array('controller' => 'user', 'action' => 'lists')) . " to add new user </span>";
                            }
                        ?>
                    </div>
                    <div class="col-md-6"><?php echo $this->Form->input('target_date'); ?></div>
                    <div class="col-md-4">
                        <?php
                            echo "<label>" . __('Current Status') . "</label>";
                            echo $this->Form->input('current_status', array('label' => '', 'legend' => false, 'value' => false, 'div' => false, 'options' => array('0' => 'Open', '1' => 'Close'), 'checked' => $this->data['CustomerComplaint']['current_status'], 'type' => 'radio', 'style' => 'float:none'));
                        ?>
                    </div>
                    <?php
                        $options = array('0' => 'Yes', '1' => 'No');
                        if (isset($capa) && count($capa) > 0) {
                            $selectedValue = 0;
                        } else {
                            $selectedValue = 1;
                        }
                    ?>
                    <div id="capaMsg" class="col-md-12 pull-right alert alert-danger ">Already added to Capa please edit from CAPA</div>
                    <div id ='capaDetail'>
                        
                    <div class="col-md-4">
                        <?php
                            echo "<label>" . __('Add To CAPA ?') . "</label>";
                            echo $this->Form->input('add_to_capa', array('label' => '', 'legend' => false, 'div' => false, 'options' => $options, 'value' => $selectedValue, 'type' => 'radio', 'style' => 'float:none'));
                        ?>
                    </div>

                        <div id="capaSrc" class="col-md-4"><?php echo $this->Form->input('capa_source_id',array('type'=>'select','selected'=>$capa['CorrectivePreventiveAction']['capa_source_id'])); ?></div>
                        
                    </div>

                <?php } ?>
                <?php if ($this->Session->read('User.employee_id') == $this->data['CustomerComplaint']['employee_id'] or $this->Session->read('User.is_mr') == 1 or $this->Session->read('User.is_mr') == true) { ?>
                    <div class="col-md-12"><?php echo $this->Form->input('action_taken'); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('action_taken_date'); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('settled_date'); ?></div>
                <?php } ?>
                <?php if (!($this->Session->read('User.is_mr') == 0 or $this->Session->read('User.is_mr') == false )) { ?>
                    <div class="col-md-6"><?php echo $this->Form->input('authorized_by',array('type'=>'select','options'=>$PublishedEmployeeList,'selected'=>$this->request->data['CustomerComplaint']['authorized_by'])); ?></div>
                <?php } ?>

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
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#customerComplaints_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>