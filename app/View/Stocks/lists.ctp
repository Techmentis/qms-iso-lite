<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="stocks ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Stocks', 'modelClass' => 'Stock', 'options' => array("sr_no" => "Sr No", "type" => "Type", "received_date" => "Received Date", "production_date" => "Production Date", "quantity" => "Quantity", "quantity_consumed" => "Quantity Consumed", "remarks" => "Remarks"), 'pluralVar' => 'stocks'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Stock'), array('action' => 'add_ajax', $this->request->params['pass'][0])); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="stocks_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "type" => "Type", "received_date" => "Received Date", "production_date" => "Production Date", "quantity" => "Quantity", "quantity_consumed" => "Quantity Consumed", "remarks" => "Remarks"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "type" => "Type", "received_date" => "Received Date", "production_date" => "Production Date", "quantity" => "Quantity", "quantity_consumed" => "Quantity Consumed", "remarks" => "Remarks"))); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>