<?php $i = 0; $j = 1; ?>
<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function (error, element) {
            if ($(element).attr('name') == 'MeetingEmployee.employee_id[]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        },
        submitHandler: function (form) {

            $(form).ajaxSubmit({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/after_meeting",
                type: 'POST',
                target: '#main',
                error: function (request, status, error) {
                    //alert(request.responseText);
                    alert('Action failed!');
                }
            });
        }
    });

    $().ready(function () {
        jQuery.validator.addMethod("greaterThanZero", function (value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        $('#AfterMeetingBeforeMeetingViewForm').validate({
            rules: {
                "data[AfterMeeting][title]": {
                    required: true,
                },
                "data[AfterMeeting][actual_meeting_from]": {
                    required: true,
                },
                "data[AfterMeeting][actual_meeting_to]": {
                    required: true,
                },
                "MeetingEmployee.employee_id[]": {
                    required: true,
                    greaterThanZero: true,
                }
            }
        });
        $('#MeetingEmployeeEmployeeId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });

	$("#submit-indicator").hide();
	$("#submit_id").click(function(){
	    $("#submit_id").prop("disabled",true);
	    $("#submit-indicator").show();
	    $("#AfterMeetingBeforeMeetingViewForm").submit();
	});
    });

    function addAgendaDiv(args) {
        var i = parseInt($('#AfterMeetingAgendaNumber').val());
        var starttime = $('#AfterMeetingActualMeetingFrom').val();

        $.post("<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/add_after_meeting_topics/", {
            i: i,
            time: starttime
        }, function (data) {
            $('#meetingTopics_ajax').append(data);
        });
        i = i + 1;
        $('#AfterMeetingAgendaNumber').val(i);
    }

    function removeAgendaDiv(i) {
        var r = confirm("Are you sure to remove this agenda?");
        if (r == true) {
            $('#meetingTopics_ajax' + i).remove();
        }

    }
</script>

<table class="table table-responsive" style="margin-top:0px;">

    <tr><td><?php echo __('Title'); ?></td>
        <td>
            <?php echo h($meeting['Meeting']['title']); ?>
            &nbsp;
        </td>
    </tr>
    <tr><td><?php echo __('Previous Meeting'); ?></td>
        <td>
            <?php echo h($meeting['Meeting']['previous_meeting_date']); ?>
            &nbsp;
        </td>
    </tr>
    <tr><td><?php echo __('Meeting Scheduled From'); ?></td>
        <td>
            <?php echo h($meeting['Meeting']['scheduled_meeting_from']); ?>
            &nbsp;
        </td>
    </tr>
    <tr><td><?php echo __('Meeting Scheduled To'); ?></td>
        <td>
            <?php echo h($meeting['Meeting']['scheduled_meeting_to']); ?>
            &nbsp;
        </td>
    </tr>
    <tr><td><?php echo __('Meeting Details'); ?></td>
        <td>
            <?php echo h($meeting['Meeting']['meeting_details']); ?>
            &nbsp;
        </td>
    </tr>
    <tr><td><?php echo __('Chairperson'); ?></td>
        <td>
            <?php echo h($meeting['Meeting']['employee_by']); ?>
            &nbsp;
        </td>
    </tr>
    <tr><td><?php echo __('Invitees'); ?></td>
        <td>
            <?php echo h($meeting['Meeting']['Attendees']); ?>
            &nbsp;
        </td>
    </tr>
    <tr><td><?php echo __('Branch'); ?></td>
        <td>
            <?php echo h($meeting['Meeting']['Branches']); ?>
            &nbsp;
        </td>
    </tr>
    <tr><td><?php echo __('Department'); ?></td>
        <td>
            <?php echo h($meeting['Meeting']['Departments']); ?>
            &nbsp;
        </td>
    </tr>
    <tr><td><?php echo __('Publish'); ?></td>
        <td>
            <?php if ($meeting['Meeting']['publish'] == 1) { ?>
                <span class="glyphicon glyphicon-ok-sign"></span>
            <?php } else { ?>
                <span class="glyphicon glyphicon-remove-circle"></span>
            <?php } ?>&nbsp;</td>
        &nbsp;
    </tr>
</table>

<?php
    if ($meeting['Meeting']['actual_meeting_from']) {
        $meeting_from = $meeting['Meeting']['actual_meeting_from'];
    } else {
        $meeting_from = $meeting['Meeting']['scheduled_meeting_from'];
    }

    if ($meeting['Meeting']['actual_meeting_to']) {
        $meeting_to = $meeting['Meeting']['actual_meeting_to'];
    } else {
        $meeting_to = $meeting['Meeting']['scheduled_meeting_to'];
    }
?>
<?php echo $this->Form->create('AfterMeeting', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>

<div class="row">
    <div class="col-md-12"><?php echo $this->Form->input('title', array('label' => __('Title'), 'value' => $meeting['Meeting']['title'])); ?></div>
    <div class="col-md-12"><?php echo $this->Form->input('MeetingEmployee.employee_id', array('name' => 'MeetingEmployee.employee_id[]', 'type' => 'select', 'multiple', 'options' => $PublishedEmployeeList, 'label' => __('Attendees'), 'default' => $selectedEmp)); ?></div>
</div>  <div class="row">
    <div class="col-md-6"><?php echo $this->Form->input('actual_meeting_from', array('label' => __('Actual Meeting From'), 'value' => $meeting_from)); ?></div>
    <div class="col-md-6"><?php echo $this->Form->input('actual_meeting_to', array('label' => __('Actual Meeting To'), 'value' => $meeting_to)); ?></div>
    <?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $meeting['Meeting']['id'])); ?>
</div>
<br/><br/>
<div id="meetingTopics_ajax">
    <?php foreach ($meetingTopics as $meetingTopic) { ?>
        <div id="meetingTopics_ajax<?php echo $i; ?>">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">Agenda <span class="alert-danger glyphicon glyphicon-remove danger pull-right" style="font-size:20px;background:none"type="button" onclick='removeAgendaDiv(<?php echo $i; ?>)'></span></div>
                    <div class="panel-body">
                        <fieldset>

                            <div class="col-md-12"><?php echo $this->Form->input('MeetingTopic.' . $i . '.topic', array('label' => __('Topic'), 'value' => $meetingTopic['MeetingTopic']['title'])); ?></div>
                            <div class="col-md-6"><?php echo $this->Form->input('MeetingTopic.' . $i . '.current_status', array('label' => __('Current Status'), 'value' => $meetingTopic['MeetingTopic']['current_status'])); ?></div>
                            <div class="col-md-6"><?php echo $this->Form->input('MeetingTopic.' . $i . '.action_plan', array('label' => __('Action Plan'), 'value' => $meetingTopic['MeetingTopic']['action_plan'])); ?></div>
                            <div class="col-md-6"><?php echo $this->Form->input('MeetingTopic.' . $i . '.employee_id', array('label' => __('Responsibility'), 'options' => $PublishedEmployeeList, 'value' => $meetingTopic['MeetingTopic']['employee_id'])); ?></div>
                            <div class="col-md-6"><?php echo $this->Form->input('MeetingTopic.' . $i . '.t_date', array('label' => __('Target Date'), 'value' => $meetingTopic['MeetingTopic']['target_date'])); ?></div>
                            <div class="col-md-6"><?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?></div>
                            <div class="col-md-6"><?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?></div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <?php $i++; $j++; } ?>
    <?php
        $linked_agendas = array('Customer Feedbank', 'Customer Complaint', 'Corrective Action / Preventive Actions', 'Document Change Amendment Sheet', 'Document Change Addition Deletion Request');
        $meetingTopic = null;
    ?>
    <div id="meetingTopics_ajax<?php echo $i; ?>">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Agenda <span class="alert-danger glyphicon glyphicon-remove danger pull-right" style="font-size:20px;background:none"type="button" onclick='removeAgendaDiv(<?php echo $i; ?>)'></span></div>
                <div class="panel-body">
                    <fieldset>

                        <div class="col-md-12"><?php echo $this->Form->input('MeetingTopic.' . $i . '.topic', array('label' => __('Topic'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('MeetingTopic.' . $i . '.current_status', array('label' => __('Current Status'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('MeetingTopic.' . $i . '.action_plan', array('label' => __('Action Plan'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('MeetingTopic.' . $i . '.employee_id', array('options' => $PublishedEmployeeList, 'label' => __('Responsibility'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('MeetingTopic.' . $i . '.t_date', array('label' => __('Target Date'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?></div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>

    <?php $i++; $j++; ?>
</div>

<?php echo $this->Form->input('agendaNumber', array('type' => 'hidden', 'value' => $i)); ?>
<?php echo $this->Form->button('Add New Agenda', array('label' => false, 'type' => 'button', 'div' => false, 'class' => 'btn btn-md btn-info pull-right', 'onclick' => 'addAgendaDiv()')); ?>

<script>
    $("[name*='t_date']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
</script>
<?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#meetings_ajax', 'async' => 'false', 'id'=>'submit_id')); ?>
<?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
<?php echo $this->Form->end(); ?>
<?php echo $this->Js->writeBuffer(); ?>

<script>
    $(".chosen-select").chosen();
    var startDateTextBox = $('#AfterMeetingActualMeetingFrom');
    var endDateTextBox = $('#AfterMeetingActualMeetingTo');

    startDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm:ss',
        onClose: function (dateText, inst) {
            if (endDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker('getDate');
                if (testStartDate > testEndDate)
                    endDateTextBox.val(startDateTextBox.val());
                $("[name*=t_date]").datepicker("option", "minDate", testStartDate);
            } else {

                $("[name*=t_date]").datepicker("option", "minDate", dateText);
                endDateTextBox.val(dateText);
            }
        },
        onSelect: function (selectedDateTime) {
            endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate'));
        }
    }).attr('readonly', 'readonly');
    endDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm:ss',
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

    $("[name*=t_date]").datepicker("option", "minDate", startDateTextBox.datetimepicker('getDate'));
</script>

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