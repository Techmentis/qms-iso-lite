<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="deviceMaintenances ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Device Maintenances', 'modelClass' => 'DeviceMaintenance', 'options' => array("sr_no" => "Sr No", "maintenance__performed_date" => "Maintenance  Performed Date", "findings" => "Findings", "status" => "Status"), 'pluralVar' => 'deviceMaintenances'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Device Maintenance'), array('action' => 'add_ajax', $previousId)); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="deviceMaintenances_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "maintenance__performed_date" => "Maintenance  Performed Date", "findings" => "Findings", "status" => "Status"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "maintenance__performed_date" => "Maintenance  Performed Date", "findings" => "Findings", "status" => "Status"))); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>