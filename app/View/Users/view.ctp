<div id="users_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="users form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View User'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Manage Access Control'), '#user_access', array('id' => 'user_access', 'class' => 'label btn-danger disabled')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
	    </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo $user['User']['sr_no']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Employee'); ?></td>
                    <td>
                        <?php echo $this->Html->link($user['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $user['Employee']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Username'); ?></td>
                    <td>
                        <?php echo $user['User']['username']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Password'); ?></td>
                    <td>
                        <?php echo "************"; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Is MR?'); ?></td>
                    <td>
                        <?php echo $user['User']['is_mr'] ? 'Yes' : 'No'; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Is View All?'); ?></td>
                    <td>
                        <?php echo $user['User']['is_view_all'] ? 'Yes' : 'No'; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Is Approver?'); ?></td>
                    <td>
                        <?php echo $user['User']['is_approvar'] ? 'Yes' : 'No'; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Status'); ?></td>
                    <td>
                        <?php
			    $status = $user['User']['status'];
			    switch ($status){
				case 0: echo 'Inactive'; break;
				case 1: echo 'Active'; break;
				case 2: echo 'Blocked';break;
			    }
			?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Department'); ?></td>
                    <td>
                        <?php echo $this->Html->link($user['Department']['name'], array('controller' => 'departments', 'action' => 'view', $user['Department']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Branch'); ?></td>
                    <td>
                        <?php echo $this->Html->link($user['Branch']['name'], array('controller' => 'branches', 'action' => 'view', $user['Branch']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Language'); ?></td>
                    <td>
                        <?php echo $this->Html->link($user['Language']['name'], array('controller' => 'languages', 'action' => 'view', $user['Language']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Login Status'); ?></td>
                    <td>
                        <?php echo $user['User']['login_status'] ? 'Online' : 'Offline'; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Last Login'); ?></td>
                    <td>
                        <?php echo $user['User']['last_login']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Last Activity'); ?></td>
                    <td>
                        <?php echo $user['User']['last_activity']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($user['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($user['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($user['User']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $user['User']['created_by'], 'recordId' => $user['User']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#users_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $user['User']['id'], 'ajax'), array('async' => true, 'update' => '#users_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#users_ajax'))); ?>
    <?php echo $this->Js->get('#user_access'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'user_access', $user['User']['id'], 'ajax'), array('async' => true, 'update' => '#users_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>