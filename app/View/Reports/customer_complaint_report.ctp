<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>

    <?php
        echo $this->Form->create('Report', array('action' => 'cc_report_excel', 'class' => 'no-padding no-margin pull-right'));
        echo $this->Form->hidden('from', array('value' => $this->request->data['reports']['from']));
        echo $this->Form->hidden('to', array('value' => $this->request->data['reports']['to']));
        echo $this->Form->submit('Export', array('class' => 'btn btn-info pull-right', 'style' => 'margin-top:25px;margin-bottom:25px;margin-right:10px;padding-left:20px;padding-right:20px;'));
	echo $this->Form->end();
    ?>
    <div class="CustomerComplaints ">
        <?php echo $this->element('nav-header-lists-reports', array('postData' => array('pluralHumanName' => 'Customer Complaints', 'modelClass' => 'CustomerComplaint', 'options' => array("sr_no" => "Sr No", "type" => "Type", "complaint_number" => "Complaint Number", "complaint_date" => "Complaint Date", "details" => "Details", "action_taken" => "Action Taken", "action_taken_date" => "Action Taken Date", "current_status" => "Current Status", "settled_date" => "Settled Date", "authorized_by" => "Authorized By"), 'pluralVar' => 'customerComplaints'))); ?>

        <script type="text/javascript">
            $(document).ready(function() {
                $('table th a, .pag_list li span a').on('click', function() {
                    var url = $(this).attr("href");
                    $('#main').load(url);
                    return false;
                });
            });
        </script>
        <div class="row">
            <div class="col-md-3">
                <div class="alert alert-danger report_dashboard_alert">
                    <h3 class="text-danger"><?php echo __(' OPEN: '); ?><span class="pull-right"><?php echo $open ?></span></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="alert alert-info report_dashboard_alert">
                    <h3 class="text-info"><?php echo __(' CLOSED : '); ?><span class="pull-right"><?php echo $closed ?></span></h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert alert-success report_dashboard_alert">
                    <h3 class="text-success"><?php echo __(' CLOSED IN TIME : '); ?><span class="pull-right"><?php echo $setteled ?></span></h3>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
                <tr>
                    <th><?php echo __(Inflector::humanize('customer')); ?></th>
                    <th><?php echo __(Inflector::humanize('complaint_number')); ?></th>
                    <th><?php echo __(Inflector::humanize('Source')); ?></th>
                    <th><?php echo __(Inflector::humanize('complaint_date')); ?></th>
                    <th><?php echo __(Inflector::humanize('employee')); ?></th>
                    <th><?php echo __(Inflector::humanize('action_taken')); ?></th>
                    <th><?php echo __(Inflector::humanize('action_taken_date')); ?></th>
                    <th><?php echo __(Inflector::humanize('current_status')); ?></th>
                    <th><?php echo __(Inflector::humanize('settled_date')); ?></th>
                    <th><?php echo __(Inflector::humanize('authorized_by')); ?></th>
                </tr>
                <?php if ($customerComplaints) {
                        $x = 0;
                        foreach ($customerComplaints as $customerComplaint):
                ?>
                <tr <?php if ($customerComplaint['CustomerComplaint']['current_status'] <> 0) echo "class='text-success'"; ?> >
                    <td><?php echo $customerComplaint['Customer']['name']; ?>&nbsp;</td>
                    <td><?php echo h($customerComplaint['CustomerComplaint']['complaint_number']); ?>&nbsp;</td>
                    <td><?php echo h($customerComplaint['Product']['name']); ?>
<?php echo h($customerComplaint['DeliveryChallan']['challan_number']); ?>&nbsp;</td>
                    <td><?php echo h($customerComplaint['CustomerComplaint']['complaint_date']); ?>&nbsp;</td>
                    <td><?php echo $customerComplaint['Employee']['name']; ?>&nbsp;</td>
                    <td><?php echo h($customerComplaint['CustomerComplaint']['action_taken']); ?>&nbsp;</td>
                    <td><?php echo h($customerComplaint['CustomerComplaint']['action_taken_date']); ?>&nbsp;</td>
                    <td><?php echo $customerComplaint['CustomerComplaint']['current_status'] ? __('Close') : __('Open'); ?>&nbsp;</td>
                    <td><?php echo h($customerComplaint['CustomerComplaint']['settled_date']); ?>&nbsp;</td>
                    <td><?php echo h($customerComplaint['CustomerComplaint']['authorized_by']); ?>&nbsp;</td>

                </tr>
                <?php
                    $x++;
                    endforeach;
                    } else {
                ?>
                <tr><td colspan=23><?php echo __('No results found'); ?></td></tr>
                <?php } ?>
            </table>
        </div>
    </div>

<script>
    $("document").ready(function() {
	$("#loadGraph").load('customer_complaint_history');
    });
</script>

    <div class="panel panel-info">
        <div class="panel-heading"><h2><?php echo __('Customer Complaints History'); ?></h2></div>
        <div class="panel-body">
            <div id="loadGraph">
                <span class="text-danger"><?php echo __('Loading Graph Please Wait...'); ?></span>
            </div>
        </div>
    </div>
</div>

<?php echo $this->element('export'); ?>
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "number" => "Number", "raised_by" => "Raised By", "assigned_to" => "Assigned To", "target_date" => "Target Date", "initial_remarks" => "Initial Remarks", "proposed_immidiate_action" => "Proposed Immediate Action", "completed_by" => "Completed By", "completed_on_date" => "Completed On Date", "completion_remarks" => "Completion Remarks", "root_cause_analysis_required" => "Root Cause Analysis Required", "root_cause" => "Root Cause", "determined_by" => "Determined By", "determined_on_date" => "Determined On Date", "root_cause_remarks" => "Root Cause Remarks", "proposed_longterm_action" => "Proposed Longterm Action", "action_assigned_to" => "Action Assigned To", "action_completed_on_date" => "Action Completed On Date", "action_completion_remarks" => "Action Completion Remarks", "effectiveness" => "Effectiveness", "closed_by" => "Closed By", "closed_on_date" => "Closed On Date", "closure_remarks" => "Closure Remarks", "document_changes_required" => "Document Changes Required"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "number" => "Number", "raised_by" => "Raised By", "assigned_to" => "Assigned To", "target_date" => "Target Date", "initial_remarks" => "Initial Remarks", "proposed_immidiate_action" => "Proposed Immediate Action", "completed_by" => "Completed By", "completed_on_date" => "Completed On Date", "completion_remarks" => "Completion Remarks", "root_cause_analysis_required" => "Root Cause Analysis Required", "root_cause" => "Root Cause", "determined_by" => "Determined By", "determined_on_date" => "Determined On Date", "root_cause_remarks" => "Root Cause Remarks", "proposed_longterm_action" => "Proposed Longterm Action", "action_assigned_to" => "Action Assigned To", "action_completed_on_date" => "Action Completed On Date", "action_completion_remarks" => "Action Completion Remarks", "effectiveness" => "Effectiveness", "closed_by" => "Closed By", "closed_on_date" => "Closed On Date", "closure_remarks" => "Closure Remarks", "document_changes_required" => "Document Changes Required"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->element('common'); ?>
<?php echo $this->Js->writeBuffer(); ?>

<!--<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>-->