<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {
            if ($(element).attr('name') == 'data[ListOfComputer][employee_id]' ||
                    $(element).attr('name') == 'data[ListOfComputer][supplier_registration_id]' ||
                    $(element).attr('name') == 'data[ListOfComputer][purchase_order_id]') {
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

        $('#ListOfComputerEditForm').validate({
            rules: {
                "data[ListOfComputer][employee_id]": {
                    greaterThanZero: true,
                },
                "data[ListOfComputer][supplier_registration_id]": {
                    greaterThanZero: true,
                },
                "data[ListOfComputer][purchase_order_id]": {
                    greaterThanZero: true,
                },
            }
        });
        $("#submit-indicator").hide();
        $("#submit_id").click(function(){
             if($('#ListOfComputerEditForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
                 $("#ListOfComputerEditForm").submit();
             }
        });
        $('#ListOfComputerEmployeeId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#ListOfComputerSupplierRegistrationId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#ListOfComputerPurchaseOrderId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
    function addAgendaDiv(args) {
        var i = parseInt($('#ListOfComputerAgendaNumber').val());
        $('#ListOfComputerAgendaNumber').val();
        $.get("<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/add_new_software/" + i, function(data) {
            $('#softwareLists_ajax').append(data);
        });
        i = i + 1;
        $('#ListOfComputerAgendaNumber').val(i);
    }
    function removeAgendaDiv(i) {
        var r = confirm("Are you sure to remove this software list?");
        if (r == true)
        {
            $('#softwareLists_ajax' + i).remove();
        }
    }
</script>

<div id="listOfComputers_ajax">
    <?php
        echo $this->Session->flash();
        $i = 0;
        $j = 1;
    ?>
    <div class="nav panel panel-default">
        <div class="listOfComputers form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Edit Computer'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
            <?php echo $this->Form->create('ListOfComputer', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>

            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('employee_id', array('style' => 'width:100%', 'label' => __('Employee'), 'options' => $PublishedEmployeeList)); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('serial_number', array('label' => __('Serial Number'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('supplier_registration_id', array('style' => 'width:100%', 'label' => __('Supplier'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('purchase_order_id', array('style' => 'width:100%', 'label' => __('Purchase Order'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('make', array('label' => __('Make'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('price', array('label' => __('Price'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('installation_date', array('label' => __('Installation Date'))); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('other_details', array('label' => __('Other Details'))); ?></div>
            </div>
            <div id="softwareLists_ajax" style="margin-top:15px;">
                <?php foreach ($this->request->data['ListOfComputerListOfSoftware'] as $val) { ?>

                    <div id="softwareLists_ajax<?php echo $i; ?>">
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading"><?php echo __('Software'); ?><span class="alert-danger glyphicon glyphicon-remove danger pull-right" style="font-size:20px;background:none"type="button" onclick='removeAgendaDiv(<?php echo $i; ?>)'></span></div>
                                <div class="panel-body">
                                    <fieldset>
                                        <div class="col-md-6"><?php echo $this->Form->input('ListOfComputerListOfSoftware.' . $i . '.list_of_software_id', array('label' => __('Software Name'))); ?></div>
                                        <div class="col-md-6"><?php echo $this->Form->input('ListOfComputerListOfSoftware.' . $i . '.installation_date'); ?></div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                        $i++;
                        $j++;
                    }
                ?>
            </div>
            <div class="col-md-6"><?php echo $this->Form->input('agendaNumber', array('type' => 'hidden', 'value' => $i)); ?></div>
            <?php echo $this->Form->button('Add New Software', array('label' => false, 'type' => 'button', 'div' => false, 'class' => 'btn btn-md btn-info pull-right', 'onclick' => 'addAgendaDiv()')); ?>
	    	<div class="clearfix"></div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>
            <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
            <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
            <?php echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id'])); ?>
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>

<script>
    var startDateTextBox = $('#ListOfComputerInstallationDate');
    var endDateTextBox = $('#ListOfComputerListOfSoftware0InstallationDate');

    startDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
        changeMonth: true,
        changeYear: true,
        onClose: function (dateText, inst) {
            if (endDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker('getDate');
                if (testStartDate > testEndDate) {
                    endDateTextBox.val(startDateTextBox.val());
                }
            } else {
                endDateTextBox.val(dateText);
            }
        },
        onSelect: function (selectedDateTime) {
            endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate'));
        }
    }).attr('readonly', 'readonly');
    endDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
        changeMonth: true,
        changeYear: true,
        onClose: function (dateText, inst) {
            if (startDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker('getDate');
                if (testStartDate > testEndDate)
                    startDateTextBox.val(endDateTextBox.val());
            } else {
                startDateTextBox.val(dateText);
            }
        },
        onSelect: function (selectedDateTime) {
            startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate'));
        }
    }).attr('readonly', 'readonly');
</script>

        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>

    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#listOfComputers_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>

</div>

