<div class="modal fade" id="approvals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo __("Send these records for approval"); ?></h4>
            </div>
            <div class="modal-body">
                <?php echo $this->Form->create('approvals', array('action' => 'approve_many', 'role' => 'form', 'class' => 'form', 'style' => 'clear:both;overflow:auto')); ?>
                <?php echo $this->Form->hidden('recs_selected', array('id' => 'approval_recs_selected')); ?>
                <?php echo $this->Form->hidden('Approval.model_name', array('value' => Inflector::camelize(Inflector::singularize($this->request->params['controller'])))); ?>
                <?php echo $this->Form->hidden('Approval.controller_name', array('value' => $this->request->params['controller'])); ?>
                <?php echo $this->Form->input('Approval.user_id', array('options' => $approversList)); ?>
                <?php echo $this->Form->input('Approval.comments', array('type' => 'textarea')); ?>
                <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-success')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
            </div>
        </div>
    </div>
</div>
