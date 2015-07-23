<div id="changeAdditionDeletionRequests_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="changeAdditionDeletionRequests form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Change Addition Deletion Request'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php if($changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['document_change_accepted'] == 0 )echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['sr_no']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Request From'); ?></td>
                    <td>
                        <?php if (isset($changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['branch_id']) && $changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['branch_id'] != -1) { echo "<strong>Branch : </strong>" . h($changeAdditionDeletionRequest['Branch']['name']); ?>
                        <?php } elseif (isset($changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['department_id']) && $changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['department_id'] != -1) { echo "<strong>Department : </strong>" . h($changeAdditionDeletionRequest['Department']['name']); ?>
                        <?php } elseif (isset($changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['employee_id']) && $changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['employee_id'] != -1) { echo "<strong>Employee : </strong>" . h($changeAdditionDeletionRequest['Employee']['name']); ?>
                        <?php } elseif (isset($changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['customer_id']) && $changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['customer_id'] != -1) { echo "<strong>Customer : </strong>" . h($changeAdditionDeletionRequest['Customer']['name']); ?>
                        <?php } elseif (isset($changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['suggestion_form_id']) && $changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['suggestion_form_id'] != -1) { echo "<strong>Suggestion : </strong>" . h($changeAdditionDeletionRequest['SuggestionForm']['title']); ?>
                        <?php
			    } elseif (isset($changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['others']) && $changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['others'] != ""){
				$needle = "CAPA Number: ";
				$capaCheck = strpos($changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['others'], $needle);
				if($capaCheck !== false){
				    $capaNumber = str_replace($needle, '', $changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['others']);
				    echo "<strong>CAPA Number: </strong>" . $capaNumber;
				} else {
				    echo "<strong>Other : </strong>" . h($changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['others']);
				}
			    }
			?>
                    </td>
                </tr>
                <tr><td><?php echo __('Request Details'); ?></td>
                    <td>
                        <?php echo h($changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['request_details']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Master List Of Format'); ?></td>
                    <td>
                        <?php echo h($changeAdditionDeletionRequest['MasterListOfFormat']['title']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($changeAdditionDeletionRequest['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($changeAdditionDeletionRequest['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Current Document Details'); ?></td>
                    <td>
                        <?php echo h($changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['current_document_details']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Proposed Changes'); ?></td>
                    <td>
                        <?php echo h($changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['proposed_changes']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Reason For Change'); ?></td>
                    <td>
                        <?php echo h($changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['reason_for_change']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($changeAdditionDeletionRequest['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($changeAdditionDeletionRequest['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['created_by'], 'recordId' => $changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#changeAdditionDeletionRequests_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['id'], 'ajax'), array('async' => true, 'update' => '#changeAdditionDeletionRequests_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#changeAdditionDeletionRequests_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>
