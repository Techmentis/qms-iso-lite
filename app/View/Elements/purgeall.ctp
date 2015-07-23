<div class="modal fade" id="purgeAll" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <?php echo $this->Form->create($this->name, array('action' => 'purge_all', 'role' => 'form', 'class' => 'form', 'style' => 'clear:both;overflow:auto')); ?>
            <?php echo $this->Form->hidden('recs_selected', array('id' => 'recs_selected_for_purge')); ?>
            <?php echo $this->Form->hidden('purgeAll.model_name', array('value' => Inflector::camelize(Inflector::singularize($this->request->params['controller'])))); ?>
            <?php echo $this->Form->hidden('purgeAll.controller_name', array('value' => $this->request->params['controller'])); ?>
            <h4 class="modal-title"><?php echo __('Are you sure to purge all selected ') . $this->name; ?> ?</h4>
            <?php echo $this->Form->submit('Yes', array('class' => 'btn btn-success', 'style' => 'margin-top:10px;margin-left:5px;')); ?>
            <?php echo $this->Form->button('No', array('class' => 'btn btn-warning', 'data-dismiss' => "modal", 'style' => 'margin-top:10px;margin-left:5px;')); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
