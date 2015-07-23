<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="capaSources ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Capa Sources', 'modelClass' => 'CapaSource', 'options' => array("sr_no" => "Sr No", "name" => "Name"), 'pluralVar' => 'capaSources'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Capa Source'), array('action' => 'add_ajax')); ?></li>
                </ul>
            </div>
        </div>
        <div id="capaSources_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "name" => "Name"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "name" => "Name"))); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>