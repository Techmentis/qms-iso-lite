<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="listOfMeasuringDevicesForCalibrations ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'List Of Measuring Devices For Calibrations', 'modelClass' => 'ListOfMeasuringDevicesForCalibration', 'options' => array("sr_no" => "Sr No", "calibration_inhouse" => "Calibration Inhouse", "calibration_outside" => "Calibration Outside"), 'pluralVar' => 'listOfMeasuringDevicesForCalibrations'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Measuring Devices For Calibration'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="listOfMeasuringDevicesForCalibrations_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "calibration_inhouse" => "Calibration Inhouse", "calibration_outside" => "Calibration Outside"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "calibration_inhouse" => "Calibration Inhouse", "calibration_outside" => "Calibration Outside"))); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>