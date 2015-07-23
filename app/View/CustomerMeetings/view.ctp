<div id="customerMeetings_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="customerMeetings form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Customer Meeting'); ?>&nbsp;
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>

            <table class="table table-responsive">
<!--
                    <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($customerMeeting['CustomerMeeting']['sr_no']); ?>
                        &nbsp;
                    </td>
                </tr>
-->
                <tr><td><h5><strong><?php echo __('Customer'); ?></h5></strong></td>
                    <td>
                        <h5><strong><?php echo $this->Html->link($customerMeeting['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $customerMeeting['Customer']['id'])); ?></strong></h5>
                        &nbsp;
                    </td>
                </tr>

                <tr>
                    <td><?php echo __('Employee'); ?></td>
                    <td>
                        <?php echo $this->Html->link($customerMeeting['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $customerMeeting['Employee']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td><?php echo __('Meeting Date'); ?></td>
                    <td>
                        <?php echo h($customerMeeting['CustomerMeeting']['meeting_date']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Action Point'); ?></td>
                    <td>
                        <?php echo h($customerMeeting['CustomerMeeting']['action_point']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Details'); ?></td>
                    <td>
                        <?php echo h($customerMeeting['CustomerMeeting']['details']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Next Meeting Date'); ?></td>
                    <td>
                        <?php echo h($customerMeeting['CustomerMeeting']['next_meeting_date']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Status'); ?></td>
                    <td>
                        <?php echo h($customerMeeting['CustomerMeeting']['status']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('PreparedBy'); ?></td>
                    <td>
                        <?php echo h($customerMeeting['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($customerMeeting['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($customerMeeting['CustomerMeeting']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <br>
            <?php
                $x = 0;
                if (isset($followups)) {
                    foreach ($followups as $followup):
                    ++$x;
            ?>
                    <h4><?php echo __('View Followup') . ' - ' . $x; ?>&nbsp;</h4>
                    <table class="table table-responsive">
<!--
                            <tr>
                            <td><b> <?php echo __('Sr. No'); ?></td>
                            <td><?php echo h($followup['CustomerMeeting']['sr_no']); ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><b> <?php echo __('Customer'); ?></td>
                            <td><?php echo $this->Html->link($followup['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $followup['Customer']['id'])); ?>&nbsp;</td>
                        </tr>
-->
                        <tr>
                            <td><b> <?php echo __('Employee'); ?></td>
                            <td><?php echo $this->Html->link($followup['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $followup['Employee']['id'])); ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><b> <?php echo __('Action Point'); ?></td>
                            <td><?php echo h($followup['CustomerMeeting']['action_point']); ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><b><?php echo __('Meeting Date'); ?></td>
                            <td><?php echo h($followup['CustomerMeeting']['meeting_date']); ?></td>
                        </tr>
                        <tr>
                            <td><b> <?php echo __('Next Meeting Date'); ?></td>
                            <td><?php echo h($followup['CustomerMeeting']['next_meeting_date']); ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><b><?php echo __('Details'); ?></td>
                            <td><?php echo h($followup['CustomerMeeting']['details']); ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><b> <?php echo __('Status'); ?></td>
                            <td><?php echo h($followup['CustomerMeeting']['status']); ?>&nbsp;</td>
                        </tr>
<!--
                            <tr>
                            <td><b> <?php echo __('Publish'); ?></td>
                            <td><?php if ($followup['CustomerMeeting']['publish'] == 1) { ?>
                                    <span class="glyphicon glyphicon-ok-sign"></span>
                                <?php } else { ?>
                                    <span class="glyphicon glyphicon-remove-circle"></span>
                                <?php } ?>&nbsp;</td>
                        </tr>
-->
                        <tr>
                            <td><b> <?php echo __('Branch'); ?></td>
                            <td><?php echo $this->Html->link($followup['BranchIds']['name'], array('controller' => 'branches', 'action' => 'view', $followup['BranchIds']['id'])); ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><b> <?php echo __('Department'); ?></td>
                            <td><?php echo $this->Html->link($followup['DepartmentIds']['name'], array('controller' => 'departments', 'action' => 'view', $followup['DepartmentIds']['id'])); ?>&nbsp;</td>
                        </tr>
                    </table>
                    <hr><br>

            <?php
                endforeach;
            }
            ?>
            <?php echo $this->element('upload-edit', array('usersId' => $customerMeeting['CustomerMeeting']['created_by'], 'recordId' => $customerMeeting['CustomerMeeting']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#customerMeetings_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $customerMeeting['CustomerMeeting']['id'], 'ajax'), array('async' => true, 'update' => '#customerMeetings_ajax'))); ?>

    <?php echo $this->Js->writeBuffer(); ?>

</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>
