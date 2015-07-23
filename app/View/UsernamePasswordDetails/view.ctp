<div id="usernamePasswordDetails_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="usernamePasswordDetails form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Username Password Detail'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo $usernamePasswordDetail['UsernamePasswordDetail']['sr_no']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Computer Name'); ?></td>
                    <td>
                        <?php echo $this->Html->link($usernamePasswordDetail['ListOfComputer']['name'], array('controller' => 'list_of_computers', 'action' => 'view', $usernamePasswordDetail['ListOfComputer']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Username'); ?></td>
                    <td>
                        <?php echo $usernamePasswordDetail['UsernamePasswordDetail']['username']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Password'); ?></td>
                    <td>
                        <?php echo "************"; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Date Of Change'); ?></td>
                    <td>
                        <?php echo $usernamePasswordDetail['UsernamePasswordDetail']['date_of_change']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Employee'); ?></td>
                    <td>
                        <?php echo $this->Html->link($usernamePasswordDetail['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $usernamePasswordDetail['Employee']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($usernamePasswordDetail['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($usernamePasswordDetail['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($usernamePasswordDetail['UsernamePasswordDetail']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
                <tr><td><?php echo __('Branch'); ?></td>
                    <td>
                        <?php echo $this->Html->link($usernamePasswordDetail['BranchIds']['name'], array('controller' => 'branches', 'action' => 'view', $usernamePasswordDetail['BranchIds']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Department'); ?></td>
                    <td>
                        <?php echo $this->Html->link($usernamePasswordDetail['DepartmentIds']['name'], array('controller' => 'departments', 'action' => 'view', $usernamePasswordDetail['DepartmentIds']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $usernamePasswordDetail['UsernamePasswordDetail']['created_by'], 'recordId' => $usernamePasswordDetail['UsernamePasswordDetail']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#usernamePasswordDetails_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $usernamePasswordDetail['UsernamePasswordDetail']['id'], 'ajax'), array('async' => true, 'update' => '#usernamePasswordDetails_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#usernamePasswordDetails_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

<script>
    $.ajaxSetup({
        beforeSend: function () {
            $("#busy-indicator").show();
        },
        complete: function () {
            $("#busy-indicator").hide();
        }
    });
</script>
