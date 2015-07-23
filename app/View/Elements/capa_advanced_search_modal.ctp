<style>
    .modal-dialog {width:50%;}
    .modal-dialog {width:50%;}
    .chosen-container, .chosen-container-single, .chosen-select
    {min-width: 200px; width:100%;}
</style>
<script>
    $().ready(function() {
        $("#submit-indicator").hide();
	$("#submit_id").click(function(){
	    $("#submit_id").prop("disabled",true);
	    $("#submit-indicator").show();
	    $("#capa_advanced-search-form").submit();
        });
    });
</script>
<?php
    $postData = null;
    $postData = array('number' => 'Number', 'name' => 'Name');
?>
<div class="modal fade " id="capa_advanced_search_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-wide">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo __('Advanced Search'); ?></h4>
            </div>
            <div class="modal-body">
                <?php echo $this->Form->create($this->name, array('action' => 'capa_advanced_search', 'role' => 'form', 'class' => 'advanced-search-form', 'id' => 'capa_advanced-search-form', 'type' => 'get')); ?>
                <div class="row">
                    <div class="col-md-12"><?php echo $this->Form->input('Search.keywords', array('label' => __('Type Keyword & select the field which you want to search from below'))); ?></div>
                    <div class="col-md-12"><?php echo $this->Form->input('Search.search_fields', array('label' => false, 'options' => array($postData), 'multiple' => 'checkbox', 'class' => 'checkbox-inline col-md-3')); ?></div>

                </div>
                <div class="col-md-12"><hr /></div>

                <?php
                    $employee = array('raised_by' => 'Raised By', 'assigned_to' => 'Assigned To', 'completed_by' => 'Completed By', 'determined_by' => 'Determined By', 'action_assigned_to' => 'Action Assigned To', 'closed_by' => 'Closed By');
                    $capaCategory = $this->requestAction('App/get_model_list/CapaCategory/');
                    $capaSource = $this->requestAction('App/get_model_list/CapaSource/');
                ?>
                <div class="row">
                    <div class="col-md-6"><?php echo $this->Form->input('Search.capa_source_id', array('label' => __('Select Capa Source'), 'options' => $capaSource, 'class' => 'form-control')); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('Search.capa_category_id', array('label' => __('Select Capa Category'), 'options' => $capaCategory, 'class' => 'form-control')); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('Search.employee_type', array('label' => __('Select Employee Type'), 'options' => $employee, 'class' => 'form-control')); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                    <div style="clear:both"></div>
                    <div class="col-md-6"><?php echo $this->Form->input('Search.document_change_required', array('label' => __('Document Change Required'), 'type' => 'checkbox')); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('Search.current_status', array('label' => __('Select Current Status'), 'options' => array(0 => 'Open', 1 => 'Closed'), 'type' => 'radio')); ?></div>
                </div>
                <div class="row">
                    <div class="col-md-6"><?php echo $this->Form->input('Search.branch_list', array('label' => __('Select branches you want to search'), 'options' => $PublishedBranchList, 'multiple' => true, 'class' => 'form-control')); ?></div>
                </div>

               <div class="row">
                    <div class="col-md-12"><hr /></div>
                    <div class="col-md-4"><?php echo $this->Form->input('Search.from-date', array('id' => 'ddfrom', 'label' => __('Select start date'))); ?></div>
                    <div class="col-md-4"><?php echo $this->Form->input('Search.to-date', array('id' => 'ddto', 'label' => __('Select end date'))); ?></div>
                    <div class="col-md-4"><?php echo $this->Form->input('Search.strict_search', array('label' => __('Strict Search'), 'options' => array('Yes', 'No'), 'checked' => 1, 'type' => 'radio')); ?></div>
                    <?php echo $this->Form->input('Search.capa_type', array('type' => 'hidden')); ?>
                </div>
                <div class ="row">
                    <div class = "col-md-6"><?php echo $this->Form->input('prepared_by', array('options' => $PublishedEmployeeList, 'style'=>array('width'=>'100%'))); ?></div>
                    <div class = "col-md-6"><?php echo $this->Form->input('approved_by', array('options' => $PublishedEmployeeList)); ?></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
			<?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#capa_main_inner', 'async' => 'false', 'id'=>'submit_id')); ?>
			<?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
            </div>
        </div>
    </div>
</div>
<script>
    function datePicker() {
        $("[name*='date']").datetimepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            'showTimepicker': false,
        }).attr('readonly', 'readonly');
    }
</script>
<script>
    var startDateTextBox = $('#ddfrom');
    var endDateTextBox = $('#ddto');

    startDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
        changeMonth: true,
        changeYear: true,
        beforeShow: function(input, inst) {
            var offset = $(input).offset();
            var height = $(input).height();
            window.setTimeout(function() {
                inst.dpDiv.css({top: (offset.top + height - 260) + 'px'})
            })
        },
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
        beforeShow: function(input, inst) {
            var offset = $(input).offset();
            var height = $(input).height();
            window.setTimeout(function() {
                inst.dpDiv.css({top: (offset.top + height - 260) + 'px'});
            })
        },
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
<script>
    $("#Material").hide();

    function customerComplaint() {
        $('.hidediv').hide();
        $('#Product').show();
        $("[name='complaint_source']").click(function() {
            $val = this.value;
            $('.hidediv').hide();
            $('#SearchProductId').val(-1).trigger('chosen:updated');
            $('#SearchDeliveryChallanId').val(-1).trigger('chosen:updated');
            $('.hidediv').find('select').prop('value', -1);
            $('#' + $val).toggle();
        });
    }

    function purchaseOrders() {
        $('.hidedivPO').hide();
        $('.hidedivType').hide();
        $('#Product').show();
        $('#Supplier').show();
        $("[name='purchase_orders']").click(function() {
            $val = this.value;
            $('.hidedivPO').hide();
            $('#SearchProductId').val(-1).trigger('chosen:updated');
            $('#SearchDeviceId').val(-1).trigger('chosen:updated');
            $('.hidedivPO').find('select').prop('value', -1);
            $('#' + $val).toggle();
        });
        $("[name='type']").click(function() {
            $val = this.value;
            if ($val == 0)
                $val = 'Supplier';
            else
                $val = 'Customer';
            $('.hidedivType').hide();
            $('#SearchSupplierRegistrationId').val(-1).trigger('chosen:updated');
            $('#SearchSearchCustomerId').val(-1).trigger('chosen:updated');
            $('.hidedivType').find('select').prop('value', -1);
            $('#' + $val).toggle();
        });
    }

    function changeAddition_DocAmendment() {
        $('.hidediv').hide();
        $('#Branch').show();
        $("[name='request_from']").click(function() {
            $val = this.value;
            $('.hidediv').hide();
            $('#SearchBranchId').val(-1).trigger('chosen:updated');
            $('#SearchDepartmentId').val(-1).trigger('chosen:updated');
            $('.hidediv').find('select').prop('value', -1);
            $('#' + $val).toggle();
        });
    }

    function shhd(chk) {
        if (chk == 'Product') {
            $("#Material").hide();
            $("#Product").show();
        } else if (chk == 'Material') {
            $("#Material").show();
            $("#Product").hide();

        }
    }
</script>