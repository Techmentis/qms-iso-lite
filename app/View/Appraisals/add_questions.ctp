<div id="questions_ajax<?php echo $i; ?>">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Add Appraisal Questions <span class="alert-danger glyphicon glyphicon-remove danger pull-right" style="font-size:20px;background:none"type="button" onclick='removeAgendaDiv(<?php echo $i; ?>)'></span></div>
            <div class="panel-body">
                <fieldset>
                    <div class="col-md-12"><?php echo $this->Form->input('AppraisalQuestion.' . $i . '.question', array('type' => 'text', 'label' => __('Question'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?></div>
                    <div class="col-md-6"><?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?></div>
                </fieldset>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.chosen-select').chosen();
    });
</script>

<?php $i++; ?>
<?php echo $this->Js->writeBuffer(); ?>