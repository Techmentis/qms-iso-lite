<div id="helps_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="helps form col-md-8">
            <h4><?php echo __('View Help'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($help['Help']['sr_no']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Language'); ?></td>
                    <td>
                        <?php echo $this->Html->link($help['Language']['name'], array('controller' => 'languages', 'action' => 'view', $help['Language']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Title'); ?></td>
                    <td>
                        <?php echo h($help['Help']['title']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Table Name'); ?></td>
                    <td>
                        <?php echo h($help['Help']['table_name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Action Name'); ?></td>
                    <td>
                        <?php echo h($help['Help']['action_name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Help Text'); ?></td>
                    <td>
                        <?php echo h($help['Help']['help_text']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Sequence'); ?></td>
                    <td>
                        <?php echo h($help['Help']['sequence']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($help['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($help['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($help['Help']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
                <tr><td><?php echo __('Branch'); ?></td>
                    <td>
                        <?php echo $this->Html->link($help['BranchIds']['name'], array('controller' => 'branches', 'action' => 'view', $help['BranchIds']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Department'); ?></td>
                    <td>
                        <?php echo $this->Html->link($help['DepartmentIds']['name'], array('controller' => 'departments', 'action' => 'view', $help['DepartmentIds']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $help['Help']['created_by'], 'recordId' => $help['Help']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#helps_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $help['Help']['id'], 'ajax'), array('async' => true, 'update' => '#helps_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#helps_ajax'))); ?>
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
