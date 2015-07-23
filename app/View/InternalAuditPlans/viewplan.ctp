<div class="panel panel-default">
    <div class="panel-heading"><div class="panel-title">Schedule Details</div></div>
    <div class="panel-body">
        <p>
        <dl style="clear: both; margin: 0 0 10px 0">
            <dt>Schedule title</dt>
            <dd><?php echo $internalAuditPlan['InternalAuditPlan']['title']; ?>&nbsp;</dd>
            <dt>From</dt>
            <dd><?php echo $internalAuditPlan['InternalAuditPlan']['schedule_date_from']; ?>&nbsp;</dd>
            <dt>To</dt>
            <dd><?php echo $internalAuditPlan['InternalAuditPlan']['schedule_date_to']; ?>&nbsp;</dd>
            <dt>Notes</dt>
            <dd><?php echo $internalAuditPlan['InternalAuditPlan']['note']; ?>&nbsp;</dd>
        </dl>
        </p>
        <br />
        <ul class="nav nav-tabs">
            <?php foreach ($PublishedBranchList as $key => $value): ?>
                <li><?php echo $this->Html->link($value . " <span class='badge btn-info'>" . count($plan[$key]) . "</span>", '#' . $key, array('data-toggle' => 'tab', 'escape' => false)); ?> </li>
            <?php endforeach ?>
        </ul>
        <div class="tab-content">
            <?php foreach ($plan as $key => $value): ?>
                <div class="tab-pane" id="<?php echo $key ?>">
                    <table class="table">
                        <tr><th>Department</th><th>Clauses</th><th>Audidee</th><th>Auditor</th><th>Time</th><th>Action</th>
                            <?php if ($this->request->params['pass'][1] == 1) echo "<th>Add Details</th>"; ?>
                        </tr>
                        <?php foreach ($value as $department): ?>
                            <tr>
                                <td><?php echo $department['Department']['name'] ?></td>
                                <td><?php echo $department['InternalAuditPlanDepartment']['clauses'] ?></td>
                                <td><?php echo $department['Employee']['name'] ?></td>
                                <td><?php echo $department['InternalAuditPlanDepartment']['list_of_trained_internal_auditor_id'] ?></td>
                                <td>From : <?php echo $department['InternalAuditPlanDepartment']['start_time'] ?> <br /> to : <?php echo $department['InternalAuditPlanDepartment']['end_time'] ?></td>
                                <?php if ($this->request->params['pass'][1] == 1) echo "<td>" . $this->Html->link('Add Details', '#add_details', array('onClick' => 'getVals("' . $department['InternalAuditPlanDepartment']['id'] . '","' . $department['InternalAuditPlanDepartment']['list_of_trained_internal_auditor_id'] . '","' . $department['InternalAuditPlanDepartment']['clauses'] . '","' . $department['InternalAuditPlanDepartment']['start_time'] . '","' . $department['InternalAuditPlanDepartment']['end_time'] . '")')) . "</td>"; ?>
                                <td><?php echo $this->Html->link('Edit', array('controller' => 'internal_audit_plan_departments', 'action' => 'edit', $department['InternalAuditPlanDepartment']['id']), array('class' => 'btn btn-xs btn-info')); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php echo $this->Js->writeBuffer(); ?>