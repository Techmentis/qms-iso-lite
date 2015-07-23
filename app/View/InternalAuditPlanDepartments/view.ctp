<div id="internalAuditPlanDepartments_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="internalAuditPlanDepartments form col-md-8">
            <h4><?php echo __('View Internal Audit Plan Department'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($internalAuditPlanDepartment['InternalAuditPlanDepartment']['sr_no']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Internal Audit Plan'); ?></td>
                    <td>
                        <?php echo $this->Html->link($internalAuditPlanDepartment['InternalAuditPlan']['title'], array('controller' => 'internal_audit_plans', 'action' => 'view', $internalAuditPlanDepartment['InternalAuditPlan']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Department'); ?></td>
                    <td>
                        <?php echo $this->Html->link($internalAuditPlanDepartment['Department']['name'], array('controller' => 'departments', 'action' => 'view', $internalAuditPlanDepartment['Department']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Employee'); ?></td>
                    <td>
                        <?php echo $this->Html->link($internalAuditPlanDepartment['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $internalAuditPlanDepartment['Employee']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('List Of Trained Internal Auditor'); ?></td>
                    <td>
                        <?php echo $this->Html->link($internalAuditPlanDepartment['ListOfTrainedInternalAuditor']['id'], array('controller' => 'list_of_trained_internal_auditors', 'action' => 'view', $internalAuditPlanDepartment['ListOfTrainedInternalAuditor']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($internalAuditPlanDepartment['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($internalAuditPlanDepartment['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($internalAuditPlanDepartment['InternalAuditPlanDepartment']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
                <tr><td><?php echo __('Branch'); ?></td>
                    <td>
                        <?php echo $this->Html->link($internalAuditPlanDepartment['BranchIds']['name'], array('controller' => 'branches', 'action' => 'view', $internalAuditPlanDepartment['BranchIds']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Department'); ?></td>
                    <td>
                        <?php echo $this->Html->link($internalAuditPlanDepartment['DepartmentIds']['name'], array('controller' => 'departments', 'action' => 'view', $internalAuditPlanDepartment['DepartmentIds']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $internalAuditPlanDepartment['InternalAuditPlanDepartment']['created_by'], 'recordId' => $internalAuditPlanDepartment['InternalAuditPlanDepartment']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#internalAuditPlanDepartments_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $internalAuditPlanDepartment['InternalAuditPlanDepartment']['id'], 'ajax'), array('async' => true, 'update' => '#internalAuditPlanDepartments_ajax'))); ?>

    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#internalAuditPlanDepartments_ajax'))); ?>
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
