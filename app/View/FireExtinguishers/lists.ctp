<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="fireExtinguishers ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Fire Extinguishers', 'modelClass' => 'FireExtinguisher', 'options' => array("sr_no" => "Sr No", "name" => "Name", "company_name" => "Company Name", "description" => "Description", "purchase_date" => "Purchase Date", "expeiry_date" => "Expeiry Date", "warrenty_expiry_date" => "Warranty Expiry Date", "model_type" => "Model Type", "other_remarks" => "Other Remarks"), 'pluralVar' => 'fireExtinguishers'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Fire Extinguisher'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="fireExtinguishers_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "name" => "Name", "company_name" => "Company Name", "description" => "Description", "purchase_date" => "Purchase Date", "expeiry_date" => "Expeiry Date", "warrenty_expiry_date" => "Warranty Expiry Date", "model_type" => "Model Type", "other_remarks" => "Other Remarks"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "name" => "Name", "company_name" => "Company Name", "description" => "Description", "purchase_date" => "Purchase Date", "expeiry_date" => "Expeiry Date", "warrenty_expiry_date" => "Warranty Expiry Date", "model_type" => "Model Type", "other_remarks" => "Other Remarks"))); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>