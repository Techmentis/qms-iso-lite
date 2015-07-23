<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="materialQualityChecks ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Material Quality Checks', 'modelClass' => 'MaterialQualityCheck', 'options' => array("sr_no" => "Sr No", "name" => "Name", "details" => "Details", "is_last_step" => "Is Last Step"), 'pluralVar' => 'materialQualityChecks'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Material Quality Check'), array('action' => 'add_ajax', $materialId)); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="materialQualityChecks_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "name" => "Name", "details" => "Details", "is_last_step" => "Is Last Step"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "name" => "Name", "details" => "Details", "is_last_step" => "Is Last Step"))); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>