<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
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
                    alert(
                        request.responseText);
                }
            });
        }
    });

    $().ready(function () {
        $("#submit-indicator").hide();
        $('#NotificationAddAjaxForm').validate();
    });
</script>

<div id="notifications_ajax">
    <?php echo $this->Session->flash(); ?><div class="nav">
        <div class="notifications form col-md-8">
            <h4>Add Notification</h4>
            <?php echo $this->Form->create('Notification', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>

            <div class="row">
				<div class="col-md-6"><?php echo $this->Form->input('title'); ?></div>            
				<div class="col-md-6"><?php echo $this->Form->input('notification_type_id', array('style' => 'width:100%')); ?></div>
				<div class="col-md-12"><?php echo $this->Form->input('message'); ?></div>
				<div class="col-md-6"><?php echo $this->Form->input('start_date'); ?></div>
				<div class="col-md-6"><?php echo $this->Form->input('end_date'); ?></div>
				<div class="col-md-12"><?php echo $this->Form->input('NotificationUser.employee_id', array('name' => 'NotificationUser.employee_id[]', 'label' => __('Notify User'), 'type' => 'select', 'multiple', 'style' => 'width:100%', 'options' => $PublishedEmployeeList)); ?></div>
            </div>
            <div class="row">
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
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#notifications_ajax', 'async' => 'false','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>

<script>
    var startDateTextBox = $('#NotificationStartDate');
    var endDateTextBox = $('#NotificationEndDate');
    startDateTextBox.datepicker({
        dateFormat: 'yy-mm-dd',
        onClose: function (dateText, inst) {
            if (endDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datepicker('getDate');
                var testEndDate = endDateTextBox.datepicker('getDate');
                if (testStartDate > testEndDate)
                    endDateTextBox.val(startDateTextBox.val());
            } else {
                endDateTextBox.val(dateText);
            }
        },
        onSelect: function (selectedDateTime) {
            endDateTextBox.datepicker('option', 'minDate', startDateTextBox.datepicker('getDate'));
        }
    }).attr('readonly', 'readonly');
    endDateTextBox.datepicker({
        dateFormat: 'yy-mm-dd',
        onClose: function (dateText, inst) {
            if (startDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datepicker('getDate');
                var testEndDate = endDateTextBox.datepicker('getDate');
                if (testStartDate > testEndDate)
                    startDateTextBox.val(endDateTextBox.val());
            } else {
                startDateTextBox.val(dateText);
            }
        },
        onSelect: function (selectedDateTime) {
            startDateTextBox.datepicker('option', 'maxDate', endDateTextBox.datepicker('getDate'));
        }
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