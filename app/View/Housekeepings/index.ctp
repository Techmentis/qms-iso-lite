<script>
    $().ready(function(){
        $("#submit-indicator").hide();
          $("#submit_id").click(function(){
                  $("#submit_id").prop("disabled",true);
                  $("#submit-indicator").show();
                  $("#HousekeepingIndexForm").submit();
          });
    });
</script>

<div  id="main">
    <?php echo $this->Session->flash(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#HousekeepingEmployeeId").chosen();
    });
</script>

    <div class="housekeepings ">
        <div class="row">
            <?php echo $this->Form->create('Housekeeping', array('action' => 'index'), array('class' => array('form no-padding no-mrgin'), 'role' => 'form')); ?>
             <div class="col-md-3"> <h4><?php echo $this->element('breadcrumbs'); ?>Housekeeping</h4></div>
            <div class="col-md-1">
                <?php if (isset($result) && $result != null) { ?>
                    <?php if ($result <= 80) { ?>
                        <span class="badge btn-danger"><h1 class="no-margin"><?php echo $result ?>%</h1></span>
                    <?php } elseif ($result <= 90 && ($result > 80)) { ?>
                        <span class="badge btn-warning"><h1 class="no-margin"><?php echo $result ?>%</h1></span>
                    <?php } elseif ($result > 90) { ?>
                        <span class="badge btn-success"><h1 class="no-margin"><?php echo $result ?>%</h1></span>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="col-md-2"><?php echo $this->Form->input('from_date', array('label' => false, 'placeholder' => 'From')); ?></div>
            <div class="col-md-2"><?php echo $this->Form->input('to_date', array('label' => false, 'placeholder' => 'To')); ?></div>
            <div class="col-md-3"><?php echo $this->Form->input('employee_id', array('label' => false, 'options' => $PublishedEmployeeList)); ?></div>
            <div class="col-md-1">
                <?php echo $this->Form->submit('Submit', array('class' => 'btn btn-success no-margin', 'id'=>'submit_id')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
        <div class="panel panel-default panel-body">
            <?php if (isset($responsibilities) && $responsibilities) {
                    foreach ($responsibilities as $key => $scheduleDays):
            ?>
                    <h3><?php echo $key ?></h3>
                    <div class="row"><div class="col-md-12"><hr /></div></div>
                    <?php foreach ($scheduleDays as $taskKey => $tasks): ?>
                        <?php if ($tasks) { ?>
                            <h4 class="text-success"><?php echo $taskKey ?></h4>
                            <div class="row"><div class="col-md-12"><hr /></div></div>
                            <div class="row">
                                <div class="col-md-3"><strong><?php echo __('Task') ?></strong></div>
                                <div class="col-md-2"><strong><?php echo __('Housekeeping Description') ?></strong></div>
                                <div class="col-md-2"><strong><?php echo __('Assigned To') ?></strong></div>
                                <div class="col-md-1"><strong><?php echo __('Status') ?></strong></div>
                                <div class="col-md-4"><strong><?php echo __('Comments') ?></strong></div>
                            </div>
                            <div class="row"><div class="col-md-12"><hr /></div></div>
                            <?php foreach ($tasks as $task): ?>
                                <div class="row">
                                    <div class="col-md-3"><?php echo $task['HousekeepingChecklist']['title']; ?></div>
                                    <div class="col-md-2"><?php echo $task['HousekeepingResponsibility']['description']; ?></div>
                                    <div class="col-md-2"><?php echo $task['Employee']['name']; ?></div>
                                    <div class="col-md-1"><?php
                                        if ($task['Housekeeping']['task_performed'] == 1)
                                            echo "<span class='glyphicon glyphicon-ok text-success'></span>"; elseif ($task['Housekeeping']['task_performed'] == 2)
                                            echo "<span class='glyphicon glyphicon-remove text-danger'></span>"; else {
                                            echo "<span class='glyphicon glyphicon-hand-right text-danger'></span>";
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-4"><?php
                                        if ($task['Housekeeping']['task_performed'] == 1)
                                            echo "<span class='text-success'>" . $task['Housekeeping']['comments'] . "</span>"; elseif ($task['Housekeeping']['task_performed'] == 2)
                                            echo "<span class='text-danger'>" . $task['Housekeeping']['comments'] . "</span>"; else {
                                            echo "<span class='text-danger'>No tasks were performed/ attempted!</span>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row"><div class="col-md-12"><hr /></div></div>
                        <?php   endforeach;
                            } else {
                        ?>
                            <div class="row">
                                <div class="col-md-12">There were no tasks on <strong><?php echo $taskKey ?></strong></div>
                            </div>

                            <div class="row"><div class="col-md-12"><hr /></div></div>
                                <?php } ?>
                            <?php endforeach ?>
                        <?php endforeach ?>

            <?php } else { ?>
                <h5>Please select From-To & User (selecting user is optional)</h5>
            <?php } ?>
        </div>

<script>
    var startDateTextBox = $('#HousekeepingFromDate');
    var endDateTextBox = $('#HousekeepingToDate');

    startDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
        changeMonth: true,
        changeYear: true,
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
    startDateTextBox.datetimepicker('option', 'maxDate', 0);
    endDateTextBox.datetimepicker('option', 'maxDate', 0);
</script>

    </div>
</div>

<?php echo $this->element('export'); ?>
<?php //echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "activity_description" => "Activity Description", "remarks" => "Remarks"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "activity_description" => "Activity Description", "remarks" => "Remarks"))); ?>
<?php echo $this->element('common'); ?>
<?php echo $this->Js->writeBuffer(); ?>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>