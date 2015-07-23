<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="supplierEvaluationReevaluations ">
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Supplier Evaluation Reevaluation'), array('action' => 'add_ajax')); ?></li>
                </ul>
            </div>
        </div>
        <div id="supplierEvaluationReevaluations_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "delivery_challan_id" => "Delivery Challan No", "challan_date" => "Challan Date", "quantity_supplied" => "Quantity Supplied", "quantity_accepted" => "Quantity Accepted", "required_delivery_date" => "Required Delivery Date", "actual_delivery_datedate" => "Actual Delivery Date", "remarks" => "Remarks"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "delivery_challan_id" => "Delivery Challan No", "challan_date" => "Challan Date", "quantity_supplied" => "Quantity Supplied", "quantity_accepted" => "Quantity Accepted", "required_delivery_date" => "Required Delivery Date", "actual_delivery_datedate" => "Actual Delivery Date", "remarks" => "Remarks"))); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>