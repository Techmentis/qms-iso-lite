<div id="systemTables_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="systemTables form col-md-8">
            <h4><?php echo __('View System Table'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($systemTable['SystemTable']['sr_no']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Name'); ?></td>
                    <td>
                        <?php echo h($systemTable['SystemTable']['name']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('System Name'); ?></td>
                    <td>
                        <?php echo h($systemTable['SystemTable']['system_name']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Evidence Required'); ?></td>
                    <td>
                        <?php echo h($systemTable['SystemTable']['evidence_required']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Approvals Required'); ?></td>
                    <td>
                        <?php echo h($systemTable['SystemTable']['approvals_required']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($systemTable['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($systemTable['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($systemTable['SystemTable']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;</td></tr>
                <tr><td><?php echo __('Branch'); ?></td>
                    <td>
                        <?php echo $this->Html->link($systemTable['BranchIds']['name'], array('controller' => 'branches', 'action' => 'view', $systemTable['BranchIds']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Department'); ?></td>
                    <td>
                        <?php echo $this->Html->link($systemTable['DepartmentIds']['name'], array('controller' => 'departments', 'action' => 'view', $systemTable['DepartmentIds']['id'])); ?>
                        &nbsp;
                    </td></tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $systemTable['SystemTable']['created_by'], 'recordId' => $systemTable['SystemTable']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php echo $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#systemTables_ajax'))); ?>

    <?php echo $this->Js->get('#edit'); ?>
<?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $systemTable['SystemTable']['id'], 'ajax'), array('async' => true, 'update' => '#systemTables_ajax'))); ?>


    <?php echo $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#systemTables_ajax'))); ?>

<?php echo $this->Js->writeBuffer(); ?>

</div>
<script>$.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});</script>
