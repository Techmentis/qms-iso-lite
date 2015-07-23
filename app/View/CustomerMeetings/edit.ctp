<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {
            if ($(element).attr('name') == 'data[CustomerMeeting][customer_id]' ||
                    $(element).attr('name') == 'data[CustomerMeeting][employee_id]' ||
                    $(element).attr('name') == 'data[CustomerMeeting][status]')
                $(element).next().after(error);
            else {
                $(element).after(error);
            }
        }
    });

    $().ready(function() {

        jQuery.validator.addMethod("notEqual", function(value, element, param) {
            return this.optional(element) || value != param;
        }, "Please select the value");

        $('#CustomerMeetingEditForm').validate({
            rules: {
                "data[CustomerMeeting][customer_id]": {
                    notEqual: -1,
                },
                "data[CustomerMeeting][employee_id]": {
                    notEqual: -1,
                },
                "data[CustomerMeeting][status]": {
                    notEqual: -1,
                },
            }
        });
        $("#submit-indicator").hide();
        $("#submit_id").click(function(){
             if($('#CustomerMeetingEditForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
                 $("#CustomerMeetingEditForm").submit();
             }

        });
        $('#CustomerMeetingCustomerId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#CustomerMeetingClientId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#CustomerMeetingEmployeeId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#CustomerMeetingStatus').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<div id="customerMeetings_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="customerMeetings form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Edit Customer Meeting'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>
            <?php echo $this->Form->create('CustomerMeeting', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>
            <?php $disabled = ($followupCount > 1) ? array('disabled' => 'disabled') : ''; ?>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('customer_id', $disabled); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('employee_id', array('label' => __('Employee'),'options' => $PublishedEmployeeList)); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('meeting_date'); ?></div>
                <?php
                    if ($this->request->data['CustomerMeeting']['active_lock'] == 1) {
                        $checked = true;
                    } else {
                        $checked = false;
                    }
                ?>
                <div class="col-md-6"><?php echo $this->Form->input('require', array('type' => 'checkbox', 'label' => __('Restrict access?'), 'checked' => $checked)); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('action_point'); ?></div>
                <div class="col-md-12">
                    <?php echo $this->Form->input('details'); ?>
                    <span class="help-text"><?php echo __('You can copy and paste your meeting details here. You can also upload it after saving this record'); ?></span>
                </div>
                <div class="col-md-6">
                    <?php echo $this->Form->input('status', array('options' => array('Open' => 'Open', 'Closed' => 'Closed', 'Pipeline' => 'Pipeline', 'Other' => 'Other'))); ?>
                </div>

                <div class="col-md-6"><?php echo $this->Form->input('next_meeting_date'); ?></div>
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
            <?php echo $this->Form->submit('Submit', array('div' => false, 'class' => 'btn btn-primary btn-success','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>

<script>
    var startDateTextBox = $('#CustomerMeetingMeetingDate');
    var endDateTextBox = $('#CustomerMeetingNextMeetingDate');

    startDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm:ss',
        changeMonth: true,
        changeYear: true,
        'showTimepicker': false,
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
        timeFormat: 'HH:mm:ss',
        changeMonth: true,
        changeYear: true,
        'showTimepicker': false,
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
</div>

<?php $this->Js->get('#list'); ?>
<?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#customerMeetings_ajax'))); ?>
<?php echo $this->Js->writeBuffer(); ?>
