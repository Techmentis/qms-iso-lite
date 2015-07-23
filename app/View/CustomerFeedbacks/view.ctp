<div id="customerFeedbacks_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="customerFeedbacks form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Customer Feedback'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($customerFeedback['CustomerFeedback']['sr_no']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Customer'); ?></td>
                    <td>
                        <?php echo $this->Html->link($customerFeedback['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $customerFeedback['Customer']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($customerFeedback['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($customerFeedback['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($customerFeedback['CustomerFeedback']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
                <tr><td colspan="2"><h3><?php echo __('Questions') ?></td></h3></tr>

                <?php foreach ($customerFeedbackDetails as $customerFeedbackDetail) { ?>

                    <tr>
                        <td colspan="2">
                            <h5><?php echo $this->Html->link($customerFeedbackDetail['CustomerFeedbackQuestion']['title'], array('controller' => 'customer_feedback_questions', 'action' => 'view', $customerFeedback['CustomerFeedbackQuestion']['id'])); ?></h5>
                            &nbsp;
                        </td>
                    </tr>
                    <?php if ($customerFeedbackDetail['CustomerFeedbackQuestion']['question_type'] == 0) { ?>
                        <tr><td><?php echo __('Answer'); ?></td>
                            <td>
                                <?php echo $customerFeedbackDetail['CustomerFeedback']['answer']; ?>
                                &nbsp;
                            </td>
                        </tr>
                    <?php } ?>
                    <tr><td><?php echo __('Comments'); ?></td>
                        <td>
                            <?php echo h($customerFeedbackDetail['CustomerFeedback']['comments']); ?>
                            &nbsp;
                        </td>
                    </tr>
                <?php } ?>

            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $customerFeedback['CustomerFeedback']['created_by'], 'recordId' => $customerFeedback['CustomerFeedback']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#customerFeedbacks_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $customerFeedback['CustomerFeedback']['id'], 'ajax'), array('async' => true, 'update' => '#customerFeedbacks_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#customerFeedbacks_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>
