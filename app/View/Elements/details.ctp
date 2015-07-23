<div class="modal fade" id="export" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo __('Export Data'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <?php echo $this->Form->create('export', array('action' => 'report', 'target' => '_blank', 'class' => 'no-padding no-margin no-background zero-height')); ?>
                    <?php echo $this->Form->hidden('rec_selected', array('id' => 'approve_recs_selected')); ?>
                    <?php echo $this->Form->submit('View as Report', array('div' => false, 'class' => 'btn btn-link')); ?>
                    <?php echo $this->Form->end(); ?>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
            </div>
        </div>
    </div>
</div>
