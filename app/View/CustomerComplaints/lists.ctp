<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="customerComplaints ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Customer Complaints', 'modelClass' => 'CustomerComplaint', 'options' => array("sr_no" => "Sr No", "type" => "Type", "complaint_number" => "Complaint Number", "complaint_date" => "Complaint Date", "details" => "Details", "action_taken" => "Action Taken", "action_taken_date" => "Action Taken Date", "current_status" => "Current Status", "settled_date" => "Settled Date", "authorized_by" => "Authorized By"), 'pluralVar' => 'customerComplaints'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Customer Complaint'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->link(__('New Customer'), array('controller' => 'customers', 'action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="customerComplaints_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "type" => "Type", "complaint_number" => "Complaint Number", "complaint_date" => "Complaint Date", "details" => "Details", "action_taken" => "Action Taken", "action_taken_date" => "Action Taken Date", "current_status" => "Current Status", "settled_date" => "Settled Date", "authorized_by" => "Authorized By"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "type" => "Type", "complaint_number" => "Complaint Number", "complaint_date" => "Complaint Date", "details" => "Details", "action_taken" => "Action Taken", "action_taken_date" => "Action Taken Date", "current_status" => "Current Status", "settled_date" => "Settled Date", "authorized_by" => "Authorized By"))); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>