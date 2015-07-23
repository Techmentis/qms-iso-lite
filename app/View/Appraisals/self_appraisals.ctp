<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults();

    $().ready(function() {
        $('#AddSelfAppraisalsForm').validate();
        $("#submit-indicator").hide();
        $("#submit_id").click(function(){
            if($('#AddSelfAppraisalsForm').valid()){
                $("#submit_id").prop("disabled",true);
                $("#submit-indicator").show();
                $("#AddSelfAppraisalsForm").submit();
            }
        });
    });
</script>

<div id="add_appraisal_answers_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="branches form col-md-12">
            <h4><?php echo __("Add Appraisal Answers"); ?></h4>
            <?php echo $this->Form->create('Add', array('role' => 'form', 'class' => 'form')); ?>

            <div class="row">
                <div class="col-md-12">
                    <p>Dear <?php echo $appraisalDetails['Employee']['name'] ?>,<br /><br/>
                        This is you self-appraisal questionnaire. You are requested answer questions below as part of your appraisal process.<br />
                        After answering all the questions, click on submit and your answers will be sent back to your Appraiser '<a href="mailto:<?php echo $appraisalDetails['AppraiserBy']['office_email'] . '?Subject=Performance%20Appraisal%20of%20' . $appraisalDetails['Employee']['name'] . '%20on%20' . $appraisalDetails['Appraisal']['appraisal_date']; ?>"><?php echo $appraisalDetails['AppraiserBy']['name']; ?></a>' for further action.
                        This link will be active till <?php echo $appraisalDetails['Appraisal']['appraisal_date'] ?>.
                        <br /><br />
                        <b>Good luck form FlinkISO!</b>
                        <br />
                        -Warm Regards
                        <br/>
                </div>
                <?php $i = 0;
                    foreach ($employeeAppraisals as $appraisal):
                ?>

                    <?php echo $this->Form->input('EmployeeAppraisalQuestion.' . $i . '.id', array('type' => 'hidden', 'value' => $appraisal['EmployeeAppraisalQuestion']['id'])); ?>
                    <div class="col-md-12"><label><?php echo $appraisalQuestions[$appraisal['EmployeeAppraisalQuestion']['appraisal_question_id']]; ?></label>
                    <?php echo $this->Form->input('EmployeeAppraisalQuestion.' . $i . '.answer', array('value' => $appraisal['EmployeeAppraisalQuestion']['answer'])); ?></div>
                    <?php if ($i % 2 != 0) { ?>
                    </div>&nbsp;<div class="row">
    <?php } ?>
    <?php $i++; endforeach; ?>
                        
            </div>
            <br />&nbsp;
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success','id' => 'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>
    </div>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
        $("#busy-indicator").show();
    }, complete: function() {
        $("#busy-indicator").hide();
    }});
</script>