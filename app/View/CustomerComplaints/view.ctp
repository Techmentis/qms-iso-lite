<div id="customerComplaints_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="customerComplaints form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Customer Complaint'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Type'); ?></td>
                    <td>
                        <?php echo h($customerComplaint['CustomerComplaint']['type'] ? __('Customer Feedback') : __('Customer Complaint')); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Customer'); ?></td>
                    <td>
                        <?php echo $this->Html->link($customerComplaint['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $customerComplaint['Customer']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Complaint Number'); ?></td>
                    <td>
                        <?php echo h($customerComplaint['CustomerComplaint']['complaint_number']); ?>
                        &nbsp;
                    </td></tr>

                <tr><td><?php echo __('Source'); ?></td>
                    <td>
                        <?php
                            if ($customerComplaint['CustomerComplaint']['complaint_source'] == 0) {
                                echo h($customerComplaint['Product']['name']);
                            } elseif ($customerComplaint['CustomerComplaint']['complaint_source'] == 1) {
                                echo "Service";
                            } elseif ($customerComplaint['CustomerComplaint']['complaint_source'] == 2) {
                                echo "Delivery Challan No: " . h($customerComplaint['DeliveryChallan']['challan_number']);
                            } else {
                                echo "Customer Care";
                            }
                        ?>&nbsp;
                    </td>
                </tr>

                <tr><td><?php echo __('Complaint Date'); ?></td>
                    <td>
                        <?php echo h($customerComplaint['CustomerComplaint']['complaint_date']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Details'); ?></td>
                    <td>
                        <?php echo h($customerComplaint['CustomerComplaint']['details']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Assigned to'); ?></td>
                    <td>
                        <?php echo $this->Html->link($customerComplaint['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $customerComplaint['Employee']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Action Taken'); ?></td>
                    <td>
                        <?php echo h($customerComplaint['CustomerComplaint']['action_taken']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Action Taken Date'); ?></td>
                    <td>
                        <?php echo h($customerComplaint['CustomerComplaint']['action_taken_date']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Current Status'); ?></td>
                    <td>
                        <?php echo $customerComplaint['CustomerComplaint']['current_status'] ? __('Close') : __('Open'); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Settled Date'); ?></td>
                    <td>
                        <?php echo h($customerComplaint['CustomerComplaint']['settled_date']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Authorized By'); ?></td>
                    <td>
                        <?php echo h($PublishedEmployeeList[$customerComplaint['CustomerComplaint']['authorized_by']]); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($customerComplaint['PreparedBy']['name']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($customerComplaint['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($customerComplaint['CustomerComplaint']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;</td></tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $customerComplaint['CustomerComplaint']['created_by'], 'recordId' => $customerComplaint['CustomerComplaint']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#customerComplaints_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $customerComplaint['CustomerComplaint']['id'], 'ajax'), array('async' => true, 'update' => '#customerComplaints_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#customerComplaints_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>
