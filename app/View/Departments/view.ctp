<div id="departments_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="departments form col-md-8">
            <h4><?php echo __('View Department'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit'), array('id' => 'edit', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Name'); ?></td>
                    <td>
                        <?php echo h($department['Department']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Clauses'); ?></td>
                    <td>
                        <?php echo htmlspecialchars_decode($department['Department']['clauses']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Details'); ?></td>
                    <td>
                        <?php echo htmlspecialchars_decode($department['Department']['details']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($department['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($department['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($department['Department']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <h4><?php echo __('List of users in this Department'); ?></h4>
            <div class="table-responsive">
                <table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
                    <tr>
                        <th><?php echo __('Employee'); ?></th>
                        <th><?php echo __('Username'); ?></th>
                        <th><?php echo __('is MR'); ?></th>
                        <th><?php echo __('is View All'); ?></th>
                        <th><?php echo __('is Approver'); ?></th>
                        <th><?php echo __('Benchmark'); ?></th>
                        <th><?php echo __('Last Login'); ?></th>
                        <th><?php echo __('Last Activity'); ?></th>
                        <th><?php echo __('Publish'); ?></th>
                    </tr>
                    <?php
                        if ($department['User']) {
                            $x = 0;
                            foreach ($department['User'] as $user):
                    ?>
                    <tr>
                        <td><?php
                                if ($this->Session->read('User.is_mr' == true))
                                    echo $this->Html->link($user['name'], array('controller' => 'users', 'action' => 'edit', $user['id']));
                                else
                                    echo $user['name'];
                            ?>&nbsp;</td>
                        <td><?php
                                if ($this->Session->read('User.is_mr' == true))
                                    echo $this->Html->link($user['username'], array('controller' => 'users', 'action' => 'edit', $user['id']));
                                else
                                    echo $user['username'];
                            ?>&nbsp;</td>
                        <td><?php echo $user['is_mr'] ? __('Yes') : __('No'); ?>&nbsp;</td>
                        <td><?php echo $user['is_view_all'] ? __('Yes') : __('No'); ?>&nbsp;</td>
                        <td><?php echo $user['is_approvar'] ? __('Yes') : __('No'); ?>&nbsp;</td>
                        <td><?php echo $user['benchmark']; ?>&nbsp;</td>
                        <td><?php echo $user['last_login']; ?>&nbsp;</td>
                        <td><?php echo $user['last_activity']; ?>&nbsp;</td>
                        <td width="60">
                            <?php if ($user['publish'] == 1) { ?>
                                <span class="glyphicon glyphicon-ok-sign"></span>
                            <?php } else { ?>
                                <span class="glyphicon glyphicon-remove-circle"></span>
                            <?php } ?>&nbsp;</td>

                    </tr>
                    <?php
                        $x++;
                        endforeach;
                        } else {
                    ?>
                        <tr><td colspan=29><?php echo __('No results found'); ?></td></tr>
                    <?php } ?>
                </table>
                <?php echo $this->element('upload-edit', array('usersId' => $department['Department']['created_by'], 'recordId' => $department['Department']['id'])); ?>
            </div>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#departments_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $department['Department']['id'], 'ajax'), array('async' => true, 'update' => '#departments_ajax'))); ?>
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
