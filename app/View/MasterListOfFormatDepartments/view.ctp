<div id="masterListOfFormatDepartments_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="masterListOfFormatDepartments form col-md-8">
            <h4><?php echo __('View Master List Of Format Department'); ?>		<?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($masterListOfFormatDepartment['MasterListOfFormatDepartment']['sr_no']); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Department'); ?></td>
                    <td>
                        <?php echo $this->Html->link($masterListOfFormatDepartment['Department']['name'], array('controller' => 'departments', 'action' => 'view', $masterListOfFormatDepartment['Department']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($masterListOfFormatDepartment['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($masterListOfFormatDepartment['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($masterListOfFormatDepartment['MasterListOfFormatDepartment']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;</td></tr>
                <tr><td><?php echo __('Branch'); ?></td>
                    <td>
                        <?php echo $this->Html->link($masterListOfFormatDepartment['BranchIds']['name'], array('controller' => 'branches', 'action' => 'view', $masterListOfFormatDepartment['BranchIds']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Department'); ?></td>
                    <td>
                        <?php echo $this->Html->link($masterListOfFormatDepartment['DepartmentIds']['name'], array('controller' => 'departments', 'action' => 'view', $masterListOfFormatDepartment['DepartmentIds']['id'])); ?>
                        &nbsp;
                    </td></tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $masterListOfFormatDepartment['MasterListOfFormatDepartment']['created_by'], 'recordId' => $masterListOfFormatDepartment['MasterListOfFormatDepartment']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php echo $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#masterListOfFormatDepartments_ajax'))); ?>

    <?php echo $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $masterListOfFormatDepartment['MasterListOfFormatDepartment']['id'], 'ajax'), array('async' => true, 'update' => '#masterListOfFormatDepartments_ajax'))); ?>

    <?php echo $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#masterListOfFormatDepartments_ajax'))); ?>

<?php echo $this->Js->writeBuffer(); ?>

</div>
<script>$.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});</script>
