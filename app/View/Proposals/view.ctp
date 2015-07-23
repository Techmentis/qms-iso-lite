<div id="proposals_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="proposals form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Proposal'); ?>&nbsp;
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php if($proposal['Proposal']['created_by'] == $this->Session->read('User.id')|| ($this->Session->read('User.is_mr') == true)): ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); endif;?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($proposal['Proposal']['sr_no']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Title'); ?></td>
                    <td>
                        <?php echo h($proposal['Proposal']['title']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Customer'); ?></td>
                    <td>
                        <?php echo $this->Html->link($proposal['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $proposal['Customer']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Employee'); ?></td>
                    <td>
                        <?php echo $this->Html->link($proposal['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $proposal['Employee']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Proposal Heading'); ?></td>
                    <td>
                        <?php echo h($proposal['Proposal']['proposal_heading']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Proposal Details'); ?></td>
                    <td>
                        <?php echo h($proposal['Proposal']['proposal_details']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($proposal['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($proposal['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($proposal['Proposal']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <br><hr>
            <?php foreach ($followups as $followup) : ?>
                <h4><?php echo __('View Proposal Followups'); ?>&nbsp;</h4>
                <table class="table table-responsive">
                    <tr>
                        <td><b><?php echo __('Sr. No'); ?></td>
                        <td><b><?php echo __('Followup Date'); ?></td>

                    </tr>
                    <tr>
                        <td>
                            <?php echo h($followup['ProposalFollowup']['sr_no']); ?>
                            &nbsp;
                        </td>
                        <td>
                            <?php echo h($followup['ProposalFollowup']['followup_date']); ?>
                            &nbsp;
                        </td>

                    </tr>
                    <tr>
                        <td><b><?php echo __('Customer'); ?></td>
                        <td><b><?php echo __('Employee'); ?></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->Html->link($followup['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $followup['Customer']['id'])); ?>
                            &nbsp;
                        </td>
                        <td>
                            <?php echo $this->Html->link($followup['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $followup['Employee']['id'])); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><b><?php echo __('Proposal Heading'); ?></td>
                        <td><b><?php echo __('Proposal Details'); ?></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo h($followup['ProposalFollowup']['followup_heading']); ?>
                            &nbsp;
                        </td>
                        <td>
                            <?php echo h($followup['ProposalFollowup']['followup_details']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><b><?php echo __('Next Followup Date'); ?></td>
                        <td><b><?php echo __('Status'); ?></td>

                    </tr>
                    <tr>
                        <td>
                            <?php echo h($followup['ProposalFollowup']['next_follow_up_date']); ?>
                            &nbsp;
                        </td>
                        <td>
                            <?php echo h($followup['ProposalFollowup']['status']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><b><?php echo __('Publish'); ?></td>
                        <td>
                            <?php if ($followup['ProposalFollowup']['publish'] == 1) { ?>
                                <span class="glyphicon glyphicon-ok-sign"></span>
                            <?php } else { ?>
                                <span class="glyphicon glyphicon-remove-circle"></span>
                            <?php } ?>&nbsp;</td>

                    </tr>
                    <tr>
                        <td><b><?php echo __('Branch'); ?></td>
                        <td><b><?php echo __('Department'); ?></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->Html->link($followup['BranchIds']['name'], array('controller' => 'branches', 'action' => 'view', $followup['BranchIds']['id'])); ?>
                            &nbsp;
                        </td>
                        <td>
                            <?php echo $this->Html->link($followup['DepartmentIds']['name'], array('controller' => 'departments', 'action' => 'view', $followup['DepartmentIds']['id'])); ?>
                            &nbsp;
                        </td>
                    </tr>
                </table>
            <?php endforeach; ?>
            <?php echo $this->element('upload-edit', array('usersId' => $proposal['Proposal']['created_by'], 'recordId' => $proposal['Proposal']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#proposals_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $proposal['Proposal']['id'], 'ajax'), array('async' => true, 'update' => '#proposals_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>

</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>
