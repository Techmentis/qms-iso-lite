<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="helps ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Helps', 'modelClass' => 'Help', 'options' => array("sr_no" => "Sr No", "title" => "Title", "table_name" => "Table Name", "action_name" => "Action Name", "help_text" => "Help Text", "sequence" => "Sequence"), 'pluralVar' => 'helps'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Help'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="helps_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "table_name" => "Table Name", "action_name" => "Action Name", "help_text" => "Help Text", "sequence" => "Sequence"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "table_name" => "Table Name", "action_name" => "Action Name", "help_text" => "Help Text", "sequence" => "Sequence"))); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>