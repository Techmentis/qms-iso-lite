<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="calibrations ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Calibrations', 'modelClass' => 'Calibration', 'options' => array("sr_no" => "Sr No", "calibration_date" => "Calibration Date", "measurement_for" => "Measurement For", "standard_value" => "Standard Value", "actual_value" => "Actual Value", "errors" => "Errors", "comments" => "Comments", "next_calibration_date" => "Next Calibration Date"), 'pluralVar' => 'calibrations'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Calibration'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->link(__('Add Device'), array('controller' => 'devices', 'action' => 'add_ajax')); ?> </li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="calibrations_tab_ajax"></div>
    </div>

<script>
    $(function() {
        $("#tabs").tabs({
            beforeLoad: function(event, ui) {
                ui.jqXHR.error(function() {
                    ui.panel.html(
                            "Error Loading ... " +
                            "Please contact administrator.");
                });
            }
        });
    });
</script>

    <?php echo $this->element('export'); ?>
    <?php echo $this->element('advanced-search', array('devices' => $device_id, 'postData' => array("calibration_date" => "Calibration Date", "errors" => "Errors", "comments" => "Comments", "next_calibration_date" => "Next Calibration Date"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "calibration_date" => "Calibration Date", "measurement_for" => "Measurement For", "standard_value" => "Standard Value", "actual_value" => "Actual Value", "errors" => "Errors", "comments" => "Comments", "next_calibration_date" => "Next Calibration Date"))); ?>
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