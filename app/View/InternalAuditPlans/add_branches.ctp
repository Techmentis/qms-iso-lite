<div id="internalAuditPlanBranches_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">

        <fieldset>
            <?php
                echo $this->Form->input('InternalAuditPlanBranch.branch_id', array('options' => $branches, 'style' => 'width:90%', 'label' => __('Branch')));

                echo $this->Form->input('InternalAuditPlanBranch.employee_id', array('options' => $employees, 'style' => 'width:90%', 'label' => __('Employee')));

                echo $this->Form->input('InternalAuditPlanBranch.list_of_trained_internal_auditor_id', array('options' => $listOfTrainedInternalAuditors, 'style' => 'width:90%', 'label' => __('Trained Internal Auditor')));
            ?>

            <?php echo $this->Js->writeBuffer(); ?>
        </fieldset>
    </div>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>