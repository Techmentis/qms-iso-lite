<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="customerComplaints ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Customer Complaints', 'modelClass' => 'CustomerComplaint', 'options' => array("sr_no" => "Sr No", "type" => "Type", "complaint_number" => "Complaint Number", "complaint_date" => "Complaint Date", "details" => "Details", "action_taken" => "Action Taken", "action_taken_date" => "Action Taken Date", "current_status" => "Current Status", "settled_date" => "Settled Date", "authorized_by" => "Authorized By"), 'pluralVar' => 'customerComplaints'))); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('table th a, .pag_list li span a').on('click', function() {
            var url = $(this).attr("href");
            $('#main').load(url);
            return false;
        });
    });
</script>
        <div class="table-responsive">
            <?php echo $this->Form->create(array('class' => 'no-padding no-margin no-background')); ?>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th><?php echo $this->Paginator->sort('customer_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('complaint_number'); ?></th>
                    <th><?php echo __('Source') ?></th>
                    <th><?php echo $this->Paginator->sort('complaint_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('employee_id', __('Assigned To')); ?></th>
                    <th><?php echo $this->Paginator->sort('target_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('current_status'); ?></th>
                    <th><?php echo $this->Paginator->sort('settled_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php
                    if ($customerComplaints) {
                        $x = 0;
                        foreach ($customerComplaints as $customerComplaint):

                        if ($customerComplaint['CustomerComplaint']['target_date'] < date('Y-m-d') && $customerComplaint['CustomerComplaint']['current_status'] == 0)
                            echo "<tr class='danger'>";
                        else
                            echo "<tr>";
                ?>
                    <td class=" actions">

                        <?php echo $this->element('actions', array('created' => $customerComplaint['CustomerComplaint']['created_by'], 'postVal' => $customerComplaint['CustomerComplaint']['id'], 'softDelete' => $customerComplaint['CustomerComplaint']['soft_delete'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($customerComplaint['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $customerComplaint['Customer']['id'])); ?>
                    </td>
                    <td><?php echo h($customerComplaint['CustomerComplaint']['complaint_number']); ?>&nbsp;</td>
                    <td><?php
                        if ($customerComplaint['CustomerComplaint']['complaint_source'] == 0) {
                            echo h($customerComplaint['Product']['name']);
                        } elseif ($customerComplaint['CustomerComplaint']['complaint_source'] == 1) {
                            echo "Service";
                        } elseif ($customerComplaint['CustomerComplaint']['complaint_source'] == 2) {
                            echo h($customerComplaint['DeliveryChallan']['challan_number']);
                        } else {
                            echo "Customer Care";
                        }
                        ?>&nbsp;</td>
                    <td><?php echo h($customerComplaint['CustomerComplaint']['complaint_date']); ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($customerComplaint['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $customerComplaint['Employee']['id'])); ?>
                    </td>
                    <td><?php echo h($customerComplaint['CustomerComplaint']['target_date']); ?>&nbsp;</td>
                    <td><?php echo $customerComplaint['CustomerComplaint']['current_status'] ? __('Close') : __('Open'); ?>&nbsp;</td>
                    <td><?php echo h($customerComplaint['CustomerComplaint']['settled_date']); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$customerComplaint['CustomerComplaint']['prepared_by']]); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$customerComplaint['CustomerComplaint']['approved_by']]); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($customerComplaint['CustomerComplaint']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                </tr>
                <?php
                    $x++;
                    endforeach;
                    } else {
                ?>
                <tr><td colspan=23>No results found</td></tr>
                <?php } ?>
            </table>
            <?php echo $this->Form->end(); ?>
        </div>
        <p>
            <?php
                echo $this->Paginator->options(array(
                    'update' => '#main',
                    'evalScripts' => true,
                    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
                    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
                ));

                echo $this->Paginator->counter(array(
                    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                ));
            ?>
        </p>
        <ul class="pagination">
            <?php
                echo "<li class='previous'>" . $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')) . "</li>";
                echo "<li>" . $this->Paginator->numbers(array('separator' => '')) . "</li>";
                echo "<li class='next'>" . $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')) . "</li>";
            ?>
        </ul>
    </div>
</div>

<?php echo $this->element('export'); ?>
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "type" => "Type", "complaint_number" => "Complaint Number", "complaint_date" => "Complaint Date", "details" => "Details", "action_taken" => "Action Taken", "action_taken_date" => "Action Taken Date", "current_status" => "Current Status", "settled_date" => "Settled Date", "authorized_by" => "Authorized By"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "type" => "Type", "complaint_number" => "Complaint Number", "complaint_date" => "Complaint Date", "details" => "Details", "action_taken" => "Action Taken", "action_taken_date" => "Action Taken Date", "current_status" => "Current Status", "settled_date" => "Settled Date", "authorized_by" => "Authorized By"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->element('common'); ?>
<?php echo $this->Js->writeBuffer(); ?>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>