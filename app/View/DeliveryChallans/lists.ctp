<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="deliveryChallans ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Delivery Challans', 'modelClass' => 'DeliveryChallan', 'options' => array("sr_no" => "Sr No", "challan_number" => "Challan Number", "challan_date" => "Challan Date", "challan_details" => "Challan Details", "customer_details" => "Customer Details", "other_reference_number" => "Other Reference Number", "details" => "Details", "remarks" => "Remarks"), 'pluralVar' => 'deliveryChallans'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Delivery Challan'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->link(__('New Purchase Order'), array('controller' => 'purchase_orders', 'action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="deliveryChallans_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "challan_number" => "Challan Number", "challan_date" => "Challan Date", "challan_details" => "Challan Details", "other_reference_number" => "Other Reference Number", "details" => "Details", "remarks" => "Remarks"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "challan_number" => "Challan Number", "challan_date" => "Challan Date", "challan_details" => "Challan Details", "customer_details" => "Customer Details", "other_reference_number" => "Other Reference Number", "details" => "Details", "remarks" => "Remarks"))); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>