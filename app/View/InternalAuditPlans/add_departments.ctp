<div style="border:1px solid #DDDDDD!important; padding-left:20px;padding-bottom:10px;">
    <div id="internalAuditPlanBranches_ajax">
        <?php echo $this->Session->flash(); ?>
        <div class="nav">
            <fieldset>
                <?php
                    echo $this->Form->input('InternalAuditPlanDepartment.' . $i . '.branch_id', array('options' => $branches, 'style' => 'width:90%'));
                    echo $this->Form->input('InternalAuditPlanDepartment.' . $i . '.department_id', array('options' => $departments, 'style' => 'width:90%'));
                    echo $this->Form->input('InternalAuditPlanDepartment.' . $i . '.employee_id', array('options' => $employees, 'style' => 'width:90%'));
                    echo $this->Form->input('InternalAuditPlanDepartment.' . $i . '.list_of_trained_internal_auditor_id', array('options' => $listOfTrainedInternalAuditors, 'style' => 'width:90%'));
                ?>
            </fieldset>
        </div>
    </div>
</div>
<?php $i++; ?>
<div id="internalAuditPlanBranches_ajax<?php echo $i ?>" style="padding-top:10px;">
    <?php echo $this->Js->link(__('Add New'), array('controller' => 'internal_audit_plans', 'action' => 'add_departments', $i), array('class' => 'label btn-info', 'update' => '#internalAuditPlanBranches_ajax' . $i)); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>

<?php echo $this->Js->writeBuffer(); ?>