<div id="trainingEvaluations_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="trainingEvaluations form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Training Evaluation'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo $trainingEvaluation['TrainingEvaluation']['sr_no']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Training'); ?></td>
                    <td>
                        <?php echo $this->Html->link($trainingEvaluation['Training']['title'], array('controller' => 'trainings', 'action' => 'view', $trainingEvaluation['Training']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Purpose Of Training'); ?></td>
                    <td>
                        <?php echo $trainingEvaluation['TrainingEvaluation']['purpose_of_training']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Is It Fulfilled'); ?></td>
                    <td>
                        <?php echo $trainingEvaluation['TrainingEvaluation']['is_it_fulfilled']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Informative'); ?></td>
                    <td>
                        <?php echo $trainingEvaluation['TrainingEvaluation']['informative']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Improvement'); ?></td>
                    <td>
                        <?php echo $trainingEvaluation['TrainingEvaluation']['improvement']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Content'); ?></td>
                    <td>
                        <?php echo $trainingEvaluation['TrainingEvaluation']['content']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Elaboration'); ?></td>
                    <td>
                        <?php echo $trainingEvaluation['TrainingEvaluation']['elaboration']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Comments'); ?></td>
                    <td>
                        <?php echo $trainingEvaluation['TrainingEvaluation']['comments']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($trainingEvaluation['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($trainingEvaluation['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($trainingEvaluation['TrainingEvaluation']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $trainingEvaluation['TrainingEvaluation']['created_by'], 'recordId' => $trainingEvaluation['TrainingEvaluation']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#trainingEvaluations_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $trainingEvaluation['TrainingEvaluation']['id'], 'ajax'), array('async' => true, 'update' => '#trainingEvaluations_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#trainingEvaluations_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

<script>
    $.ajaxSetup({
        beforeSend: function () {
            $("#busy-indicator").show();
        },
        complete: function () {
            $("#busy-indicator").hide();
        }
    });
</script>
