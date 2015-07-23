<div class="panel panel-default">
    <div class="panel-heading"><div class="panel-title">Initial Plan</div></div>
    <div class="panel-body">
        <p style="clear: both; margin: 0 0 10px 0; width: 100%">
        <dl>
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

    </div>
    <div class="panel-body">
        <?php
            foreach ($plan as $key => $value):
                if ($value) {
        ?>
                <hr />
                <h4><?php echo $value[0]['Branch']['name']; ?></h4>

                <div class="tab-pane" id="<?php echo $key ?>">
                    <table class="table">
                        <tr><th width="15%">Department</th><th width="15%">Clauses</th><th width="30%">Audidee</th><th width="20%">Auditor</th><th width="20%">Time</th>
                            <?php if ($this->request->params['pass'][1] == 1) echo "<th>Add Details</th>"; ?>
                        </tr>
                        <?php foreach ($value as $department): ?>
                            <tr>
                                <td><?php echo $department['Department']['name'] ?></td>
                                <td><?php echo $department['InternalAuditPlanDepartment']['clauses'] ?></td>
                                <td><?php echo $department['Employee']['name'] ?></td>
                                <td><?php echo $department['InternalAuditPlanDepartment']['list_of_trained_internal_auditor_id'] ?></td>
                                <td>From : <?php echo $department['InternalAuditPlanDepartment']['start_time'] ?> <br /> to : <?php echo $department['InternalAuditPlanDepartment']['end_time'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php } endforeach; ?>
    </div>

</div>
<?php echo $this->Js->writeBuffer(); ?>