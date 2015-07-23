<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="dailyBackupDetails ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Daily Backup Details', 'modelClass' => 'DailyBackupDetail', 'options' => array("sr_no" => "Sr No", "backup_date" => "Backup Date"), 'pluralVar' => 'dailyBackupDetails'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Daily Backup Detail'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->link(__('New Data Type'), array('controller' => 'data_types', 'action' => 'add_ajax',$this->request->params['controller'])); ?></li>
                    <li><?php echo $this->Html->link(__('New Data Backup'), array('controller' => 'data_back_ups', 'action' => 'add_ajax',$this->request->params['controller'])); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="dailyBackupDetails_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "backup_date" => "Backup Date"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "backup_date" => "Backup Date"))); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>