<div class="modal fade" id="export" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo __('Generate Reports') ?></h4>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <?php
                        if ($templates) {
                            echo $this->Form->create(Inflector::Classify($controllerName), array('controller' => $controllerName, 'action' => 'report', 'target' => '_blank', 'class' => 'no-padding no-margin no-background zero-height'));
                            echo $this->Form->hidden('rec_selected', array('id' => 'approve_recs_selected'));
                            echo $this->Form->input('template_id', array('options' => $templates));
                            echo $this->Form->submit('View as Report', array('class' => 'btn btn-success'));
                            echo $this->Form->end();
                        } else {
                    ?>
                        <div class="panel panel-danger">
                            <div class="panel-heading"><strong><?php echo __('Missing Template') ?></strong><span class="glyphicon glyphicon-ban-circle text-danger pull-right" style="font-size:15px"></span>        </div>
                            <div class="panel-body">
                                <p class="pull-left">
                                    We could not find any report template. Please create a template first.
                                    You can create the template by clicking the following link :-
                                </p>
                                <?php echo $this->Html->link(__('Add New Template'), array('controller' => 'custom_templates', 'action' => 'lists'), array('class' => 'btn btn-primary')); ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
            </div>
        </div>
    </div>
</div>
