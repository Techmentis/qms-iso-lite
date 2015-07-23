<script>
    $("document").ready(function () {
        $("#audit_plan").load("<?php echo Router::url('/', true);?>internal_audit_plans/plan_report/<?php echo $this->request->params['pass'][0] ?>")
    })
</script>

<h3><?php echo __('Internal Audit Report'); ?></h3>
<div id="audit_plan">
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Initial Plan</h2></div>
        <div class="panel-body">
            Loading Plan ...
        </div>
    </div>
</div>
<?php
    foreach ($internalAudits as $key => $value):
        foreach ($value as $internalAudit) :
            if ($internalAudit['InternalAudit']['non_conformity_found'] == 1) {
?>
            <div class="panel panel-danger">
<?php } else { ?>
                <div class="panel panel-default">
<?php } ?>
                <div class="panel-heading">
                    <div class="panel-title">
                        <h2>Audit Details for <?php echo $key ?>  Branch.
                            <span class="pull-right">Department Audited  : <?php echo $this->Html->link($internalAudit['Department']['name'], '#' . $internalAudit['InternalAudit']['id'], array('data-toggle' => 'collapse', 'data-parent' => '#audit_accordion-' . $key)); ?></span>
                        </h2>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-recursive">
                        <tr>
                            <td><b>Auditee</b></td><td><?php echo $internalAudit['Employee']['name'] ?>&nbsp; </td>
                            <td><b>Auditor</b></td><td><?php echo $internalAudit['ListOfTrainedInternalAuditor']['id'] ?>&nbsp; </td>
                        </tr>
                        <tr>
                            <td><b>Start Time</b></td><td><?php echo $internalAudit['InternalAudit']['start_time'] ?>&nbsp; </td>
                            <td><b>End Time</b></td><td><?php echo $internalAudit['InternalAudit']['end_time'] ?>&nbsp; </td>
                        </tr>
                        <tr>
                            <td><b>Section</b></td><td><?php echo $internalAudit['InternalAudit']['section'] ?>&nbsp; </td>
                            <td><b>Clauses</b></td><td><?php echo $internalAudit['InternalAudit']['clauses'] ?>&nbsp; </td>
                        </tr>

                        <tr>
                            <td><b>Question asked</b></td><td colspan="3"><?php echo $internalAudit['InternalAudit']['question_asked'] ?>&nbsp; </td>
                        </tr>
                        <tr>
                            <td><b>Findings</b></td><td colspan="3"><?php echo $internalAudit['InternalAudit']['finding'] ?>&nbsp; </td>
                        </tr>
                        <tr>
                            <td><b>Current Status</b></td><td colspan="3"><?php echo $internalAudit['InternalAudit']['current_status'] ?>&nbsp; </td>
                        </tr>
                        <tr>
                            <td><b>Responsibility</b></td><td><?php echo $internalAudit['EmployeeId']['name'] ?>&nbsp; </td>
                            <td><b>Target Date</b></td><td><?php echo $internalAudit['InternalAudit']['target_date'] ?>&nbsp; </td>
                        </tr>
                        <tr>
                            <td><b>Notes</b></td><td colspan="3"><?php echo $internalAudit['InternalAudit']['notes'] ?>&nbsp; </td>
                        </tr>

                    </table>
                </div>
                <div class="panel-footer">
                    <h5>Related Files</h5>
                    <?php
                        if ($internalAudit['Files']) {
                            foreach ($internalAudit['Files'] as $file):
                                $file_name = $file['FileUpload']['file_details'] . "." . $file['FileUpload']['file_type'];
                                echo $this->Html->link($file_name, '../files/upload/' . $file['FileUpload']['user_id'] . '/' . $file['SystemTable']['system_name'] . '/' . $file['FileUpload']['record'] . '/' . $file_name, array('class' => 'link')) . " , ";
                            endforeach;
                        }
                    ?>
                </div>
            </div>
            <br />
        <?php endforeach; ?>
    <?php endforeach ?>

