<div id="appraisalQuestions_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel">
        <div class="appraisalQuestions form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Appraisal Question'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list','class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator'));?>
            </h4>
            <table class="table table-responsive">
                <tr>
                    <td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($appraisalQuestion['AppraisalQuestion']['sr_no']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td><?php echo __('Question'); ?></td>
                    <td>
                        <?php echo h($appraisalQuestion['AppraisalQuestion']['question']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($appraisalQuestion['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($appraisalQuestion['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($appraisalQuestion['AppraisalQuestion']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                            <?php
                        } else {
                            ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php }
                        ?>&nbsp;
                    </td>
                    &nbsp;</td>
                </tr>
            </table>

            <?php echo $this->element('upload-edit', array('usersId' => $appraisalQuestion['AppraisalQuestion']['created_by'], 'recordId' => $appraisalQuestion['AppraisalQuestion']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#appraisalQuestions_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $appraisalQuestion['AppraisalQuestion']['id'], 'ajax'), array('async' => true,'update' => '#appraisalQuestions_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>