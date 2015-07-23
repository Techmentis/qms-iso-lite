<script>
    $(document).ready(function() {
        $('.chosen-select').chosen();
    });
</script>
<div id="meetingTopics_ajax<?php echo $i; ?>">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo __('Agenda'); ?><span class="alert-danger glyphicon glyphicon-remove danger pull-right" style="font-size:20px;background:none"type="button" onclick='removeAgendaDiv(<?php echo $i; ?>)'></span></div>
            <div class="panel-body">
                <fieldset>
                    <div class="col-md-12"><?php echo $this->Form->input('MeetingTopic.' . $i . '.topic', array('label' => __('Topic'), 'value' => $meetingTopic)); ?></div>
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

<script>
    $("[name*='t_date']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
</script>

<script>
 $("#MeetingTopic<?php echo $i; ?>TDate").datepicker('option', 'minDate', new Date('<?php echo $starttime;?>'));
</script>

<?php $i++;  ?>
<?php echo $this->Js->writeBuffer(); ?>