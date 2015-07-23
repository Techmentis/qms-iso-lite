<div id="proposalFollowups_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="proposalFollowups form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Proposal Followup'); ?>&nbsp;
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php if($proposalFollowup['ProposalFollowup']['created_by'] == $this->Session->read('User.id')|| ($this->Session->read('User.is_mr') == true)): ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); endif;?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">

                <tr><td><?php echo __('Proposal'); ?></td>
                    <td>
                        <?php echo $this->Html->link($proposalFollowup['Proposal']['title'], array('controller' => 'proposals', 'action' => 'view', $proposalFollowup['Proposal']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Employee'); ?></td>
                    <td>
                        <?php echo $this->Html->link($proposalFollowup['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $proposalFollowup['Employee']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Followup Date'); ?></td>
                    <td>
                        <?php echo h($proposalFollowup['ProposalFollowup']['followup_date']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Followup Heading'); ?></td>
                    <td>
                        <?php echo h($proposalFollowup['ProposalFollowup']['followup_heading']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Followup Details'); ?></td>
                    <td>
                        <?php echo h($proposalFollowup['ProposalFollowup']['followup_details']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Next Follow Up Date'); ?></td>
                    <td>
                        <?php echo h($proposalFollowup['ProposalFollowup']['next_follow_up_date']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Status'); ?></td>
                    <td>
                        <?php echo h($proposalFollowup['ProposalFollowup']['status']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($proposalFollowup['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($proposalFollowup['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($proposalFollowup['ProposalFollowup']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>

            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $proposalFollowup['ProposalFollowup']['created_by'], 'recordId' => $proposalFollowup['ProposalFollowup']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#proposalFollowups_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $proposalFollowup['ProposalFollowup']['id'], 'ajax'), array('async' => true, 'update' => '#proposalFollowups_ajax'))); ?>
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
