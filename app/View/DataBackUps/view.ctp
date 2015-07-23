<div id="dataBackUps_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="dataBackUps form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Data Back Up'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Name'); ?></td>
                    <td>
                        <?php echo h($dataBackUp['DataBackUp']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Data Type'); ?></td>
                    <td>
                        <?php echo $this->Html->link($dataBackUp['DataType']['name'], array('controller' => 'data_types', 'action' => 'view', $dataBackUp['DataType']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Branch'); ?></td>
                    <td>
                        <?php echo $this->Html->link($dataBackUp['Branch']['name'], array('controller' => 'branches', 'action' => 'view', $dataBackUp['Branch']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Backup Schedule'); ?></td>
                    <td>
                        <?php echo $this->Html->link($dataBackUp['Schedule']['name'], array('controller' => 'schedules', 'action' => 'view', $dataBackUp['Schedule']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Employee'); ?></td>
                    <td>
                        <?php echo $this->Html->link($dataBackUp['User']['name'], array('controller' => 'users', 'action' => 'view', $dataBackUp['User']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($dataBackUp['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($dataBackUp['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($dataBackUp['DataBackUp']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                    </td>
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $dataBackUp['DataBackUp']['created_by'], 'recordId' => $dataBackUp['DataBackUp']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#dataBackUps_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $dataBackUp['DataBackUp']['id'], 'ajax'), array('async' => true, 'update' => '#dataBackUps_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#dataBackUps_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>

</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>
