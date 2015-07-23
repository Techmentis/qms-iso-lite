<div id="notificationUsers_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="notificationUsers form col-md-8">
            <h4><?php echo __('View Notification User'); ?>		<?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($notificationUser['NotificationUser']['sr_no']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Notification'); ?></td>
                    <td>
                        <?php echo $this->Html->link($notificationUser['Notification']['title'], array('controller' => 'notifications', 'action' => 'view', $notificationUser['Notification']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('User'); ?></td>
                    <td>
                        <?php echo $this->Html->link($notificationUser['User']['name'], array('controller' => 'users', 'action' => 'view', $notificationUser['User']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($notificationUser['NotificationUser']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;</td></tr>
                <tr><td><?php echo __('Branch'); ?></td>
                    <td>
                        <?php echo $this->Html->link($notificationUser['BranchIds']['name'], array('controller' => 'branches', 'action' => 'view', $notificationUser['BranchIds']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Department'); ?></td>
                    <td>
                        <?php echo $this->Html->link($notificationUser['DepartmentIds']['name'], array('controller' => 'departments', 'action' => 'view', $notificationUser['DepartmentIds']['id'])); ?>
                        &nbsp;
                    </td></tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $notificationUser['NotificationUser']['created_by'], 'recordId' => $notificationUser['NotificationUser']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php echo $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#notificationUsers_ajax'))); ?>

    <?php echo $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $notificationUser['NotificationUser']['id'], 'ajax'), array('async' => true, 'update' => '#notificationUsers_ajax'))); ?>

    <?php echo $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#notificationUsers_ajax'))); ?>

<?php echo $this->Js->writeBuffer(); ?>

</div>
<script>$.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});</script>
