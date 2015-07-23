<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="devices ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Devices', 'modelClass' => 'Device', 'options' => array("sr_no" => "Sr No", "name" => "Name", "number" => "Number", "serial" => "Serial", "manual" => "Manual", "sparelist" => "Sparelist", "description" => "Description", "make_type" => "Make Type", "purchase_date" => "Purchase Date", "least_count" => "Least Count", "range" => "Range", "calibration_frequency" => "Calibration Frequency", "required_accuracy" => "Required Accuracy", "default_calibration" => "Default Calibration", "calibration_required" => "Calibration Required", "calibration_inhouse" => "Calibration Inhouse", "calibration_outside" => "Calibration Outside"), 'pluralVar' => 'devices'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Device'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="devices_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("name" => "Name", "number" => "Number", "serial" => "Serial", "manual" => "Manual", "sparelist" => "Sparelist", "description" => "Description", "make_type" => "Make Type", "purchase_date" => "Purchase Date", "least_count" => "Least Count", "range" => "Range", "calibration_frequency" => "Calibration Frequency", "required_accuracy" => "Required Accuracy", "default_calibration" => "Default Calibration", "calibration_required" => "Calibration Required", "calibration_inhouse" => "Calibration Inhouse", "calibration_outside" => "Calibration Outside"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "name" => "Name", "number" => "Number", "serial" => "Serial", "manual" => "Manual", "sparelist" => "Sparelist", "description" => "Description", "make_type" => "Make Type", "purchase_date" => "Purchase Date", "least_count" => "Least Count", "range" => "Range", "calibration_frequency" => "Calibration Frequency", "required_accuracy" => "Required Accuracy", "default_calibration" => "Default Calibration", "calibration_required" => "Calibration Required", "calibration_inhouse" => "Calibration Inhouse", "calibration_outside" => "Calibration Outside"))); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>