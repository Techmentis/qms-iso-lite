<div id="histories_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="histories form col-md-8">
            <h4><?php echo __('View History'); ?>		<?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($history['History']['sr_no']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Model Name'); ?></td>
                    <td>
                        <?php echo h($history['History']['model_name']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Controller Name'); ?></td>
                    <td>
                        <?php echo h($history['History']['controller_name']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Action'); ?></td>
                    <td>
                        <?php echo h($history['History']['action']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Get Values'); ?></td>
                    <td>
                        <?php echo h($history['History']['get_values']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Post Values'); ?></td>
                    <td>
                        <?php echo h($history['History']['post_values']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('User Session'); ?></td>
                    <td>
                        <?php echo $this->Html->link($history['UserSession']['id'], array('controller' => 'user_sessions', 'action' => 'view', $history['UserSession']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Branch Id'); ?></td>
                    <td>
                        <?php echo h($history['History']['branch_id']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Department Id'); ?></td>
                    <td>
                        <?php echo h($history['History']['department_id']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($history['History']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;</td></tr>
                <tr><td><?php echo __('Branch'); ?></td>
                    <td>
                        <?php echo $this->Html->link($history['BranchIds']['name'], array('controller' => 'branches', 'action' => 'view', $history['BranchIds']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Department'); ?></td>
                    <td>
                        <?php echo $this->Html->link($history['DepartmentIds']['name'], array('controller' => 'departments', 'action' => 'view', $history['DepartmentIds']['id'])); ?>
                        &nbsp;
                    </td></tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $history['History']['created_by'], 'recordId' => $history['History']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php echo $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#histories_ajax'))); ?>

    <?php echo $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $history['History']['id'], 'ajax'), array('async' => true, 'update' => '#histories_ajax'))); ?>

    <?php echo $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#histories_ajax'))); ?>

<?php echo $this->Js->writeBuffer(); ?>

</div>
<script>$.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});</script>
