<div class="modal fade" id="restoreAll" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <?php echo $this->Form->create($this->name, array('action' => 'restore_all', 'role' => 'form', 'class' => 'form', 'style' => 'clear:both;overflow:auto')); ?>
                    <?php echo $this->Form->hidden('recs_selected', array('id' => 'recs_selected_for_restore')); ?>
                    <?php echo $this->Form->hidden('restoreAll.model_name', array('value' => Inflector::camelize(Inflector::singularize($this->request->params['controller'])))); ?>
                    <?php echo $this->Form->hidden('restoreAll.controller_name', array('value' => $this->request->params['controller'])); ?>
                    <h4 class="modal-title"><?php echo __('Are you sure to restore all selected ') . $this->name; ?> ?</h4>
                    <?php echo $this->Form->submit('Yes', array('class' => 'btn btn-success', 'style' => 'margin-top:10px;margin-left:5px;')); ?>
                    <?php echo $this->Form->button('No', array('class' => 'btn btn-warning', 'data-dismiss' => "modal", 'style' => 'margin-top:10px;margin-left:5px;')); ?>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
