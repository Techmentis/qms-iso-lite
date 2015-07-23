<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function (error, element) {
            if ($(element).attr('name') == 'data[Production][branch_id]' ||
                $(element).attr('name') == 'data[Production][employee_id]' ||
                $(element).attr('name') == 'data[Production][product_id]') {
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

    $().ready(function () {
        $("#submit-indicator").hide();
        jQuery.validator.addMethod("greaterThanZero", function (value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");
        $('#ProductionAddAjaxForm').validate({
            rules: {
                "data[Production][branch_id]": {
                    greaterThanZero: true,
                },
                "data[Production][employee_id]": {
                    greaterThanZero: true,
                },
                "data[Production][product_id]": {
                    greaterThanZero: true,
                },
            }
        });
        $('#ProductionBranchId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#ProductionEmployeeId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#ProductionProductId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
         $('#ProductionBatchNumber').blur(function() {
            $("#getBatch").load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_batch/' + encodeURIComponent(this.value), function(response, status, xhr) {
                if (response != '') {
                    $('#ProductionBatchNumber').val('');
                    $('#ProductionBatchNumber').addClass('error');
                    $("#getBatch").val(response);
                } else {
                    $('#ProductionBatchNumber').removeClass('error');
                }
            });
        });
    });
</script>

<div id="productions_ajax">
    <?php echo $this->Session->flash(); ?><div class="nav">
        <div class="productions form col-md-8">
            <h4><?php echo __('Add Production'); ?></h4>
            <?php echo $this->Form->create('Production', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('product_id'); ?></div>
                <div class="col-md-6">
                    <?php echo $this->Form->input('batch_number'); ?>
                    <label id="getBatch" class="error" style="clear:both" ></label>
                </div>
                <div class="col-md-12"><?php echo $this->Form->input('details'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('branch_id',array('type'=>'select','options'=>$PublishedBranchList)); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('employee_id', array('label' => 'Supervisor','type'=>'select','options'=>$PublishedEmployeeList)); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('start_date'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('end_date'); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('remarks', array('label' => 'Any other Remarks')); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?></div>
            </div>
            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish');
                }
            ?>
            <?php echo $this->Form->submit('Submit', array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#productions_ajax', 'async' => 'false','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>

<script>
    var startDateTextBox = $('#ProductionStartDate');
    var endDateTextBox = $('#ProductionEndDate');

    startDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        'showTimepicker': false,
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
        changeMonth: true,
        changeYear: true,
        'showTimepicker': false,
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
</div>

<script>
    $.ajaxSetup({
        beforeSend: function () {
            $("#busy-indicator").show();
        },
        complete: function () {
            $("#busy-indicator").hide();
        }
    });
</script>