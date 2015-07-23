<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults();
    $().ready(function() {
        $('#NotificationApproveForm').validate();
        $("#submit-indicator").hide();
        $("#submit_id").click(function(){
             if($('#NotificationApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#NotificationApproveForm").submit();
             }

        });
    });
</script>
<div id="notifications_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="notifications form col-md-8">
            <h4><?php echo __('Approve Notification'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>

            </h4>
            <?php echo $this->Form->create('Notification', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>

            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('title'); ?></div>            
				<div class="col-md-6"><?php echo $this->Form->input('notification_type_id', array('style' => 'width:100%')); ?></div>
				<div class="col-md-12"><?php echo $this->Form->input('message'); ?></div>
				<div class="col-md-6"><?php echo $this->Form->input('start_date'); ?></div>
				<div class="col-md-6"><?php echo $this->Form->input('end_date'); ?></div>
				<div class="col-md-12"><?php echo $this->Form->input('NotificationUser.employee_id', array('name' => 'NotificationUser.employee_id[]', 'label' => __('Notify User'), 'type' => 'select', 'multiple', 'style' => 'width:100%', 'options' => $PublishedEmployeeList)); ?></div>
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
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#notifications_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

