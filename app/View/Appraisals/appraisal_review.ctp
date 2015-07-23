<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults();
    $().ready(function() {
        $('#AppraisalAppraisalReviewForm').validate();
        $("#submit-indicator").hide();
        $("#submit_id").click(function(){
            if($('#AppraisalAppraisalReviewForm').valid()){
                $("#submit_id").prop("disabled",true);
                $("#submit-indicator").show();
                $("#AppraisalAppraisalReviewForm").submit();
            }
        });
    });
</script>

<div id="add_appraisal_review">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="branches form col-md-8">
            <h4>
                <?php echo __("Add Appraisal Review"); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>

            <?php echo $this->Form->create('Appraisal', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $appraisals['Appraisal']['id'])); ?>
            <hr>
            <div class="row">
                <h5 class="text-center"><strong><?php echo __('Employee information'); ?></strong></h5>&nbsp;
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label><?php echo __('Employee Name'); ?></label><br />
                    <?php echo h($appraisals['Employee']['name']); ?>
                </div>
                <div class="col-md-6">
                    <label><?php echo __('Date of Joining'); ?></label><br />
                    <?php echo h($appraisals['Employee']['joining_date']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label><?php echo __('Designation'); ?></label><br />
                    <?php echo h($PublishedDesignationList[$appraisals['Employee']['designation_id']]); ?>
                </div>
                <div class="col-md-6">
                    <label><?php echo __('Date of Appraisal'); ?></label><br />
                    <?php echo h($appraisals['Appraisal']['appraisal_date']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label><?php echo __('Department'); ?></label><br />
                    <?php echo h($PublishedDepartmentList[$appraisals['Employee']['departmentid']]); ?>
                </div>
                <div class="col-md-6">
                    <label><?php echo __('Appraiser'); ?></label><br />
                    <?php echo h($appraisals['AppraiserBy']['name']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label><?php echo __('Employee Number'); ?></label><br />
                    <?php echo h($appraisals['Employee']['employee_number']); ?>
                </div>
                <div class="col-md-6">
                    <label><?php echo __('Location'); ?></label><br />
                    <?php echo '&#8212;'; ?>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-center"><strong><?php echo __('Reason for Appraisal'); ?></strong></h5>&nbsp;
                    <br/>
                    <?php echo h($appraisals['Appraisal']['reason']); ?>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-center"><strong><?php echo __('Employee Appraisal Questions'); ?></strong></h5>&nbsp;
                    <br />
                    <?php if (count($appraisals['EmployeeAppraisalQuestion']) > 0) {
                        foreach ($appraisals['EmployeeAppraisalQuestion'] as $quest):
                            ?>
                            <strong><?php echo 'Question: ' . h($appraisalQuestions[$quest['appraisal_question_id']]); ?></strong>
                            <br/>
                    <?php echo '<strong>Answer: </strong>' . h($quest['answer']); ?>
                            <br/>&nbsp;
                            <br/>
                    <?php endforeach;
                        } else echo '<p class="text-warning">' . __('Self Appraisal Not Required') . '</p>'; ?>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-12 "><h5 class="text-center"><strong><?php echo __('Final Result and Recommendation'); ?></strong></h5></div>&nbsp;
                <br/>
                <div class="col-md-6"><?php echo $this->Form->input('rating', array('value' => $appraisals['Appraisal']['rating'])); ?></div>
                <div class="col-md-12">
                    <label><?php echo __('Comments by Employee'); ?></label>
                    <br />
                    <em><?php echo __('(apart from comments on the assessment, this column could also cover reasons for the current level of performance constraints or grievances, suggestions for improvements, etc.)'); ?></em>
                        <?php echo $this->Form->input('employee_comments', array('label' => false, 'type' => 'textarea', 'value' => $appraisals['Appraisal']['employee_comments'])) ?>
                </div>

                <div class="col-md-12">&nbsp;</div>

                <div class="col-md-12">
                    <label><?php echo __('Comments by Appraiser'); ?></label>
                    <br />
                    <em><?php echo __('( This will summarise the contents of the post appraisal discussion besides other comments on developmental needs, potential for other jobs, etc.)'); ?></em>
                <?php echo $this->Form->input('appraiser_comments', array('label' => false, 'type' => 'textarea', 'value' => $appraisals['Appraisal']['appraiser_comments'])); ?>
                </div>
                <div class="col-md-6">
                <?php $checked = $appraisals['Appraisal']['promotion'] ? 'checked' : '';
                echo $this->Form->input('promotion', array('type' => 'checkbox', 'checked' => $checked));
                ?>
                </div>
                <div class="col-md-6">
                    <?php $checked = $appraisals['Appraisal']['warning'] ? 'checked' : '';
                    echo $this->Form->input('warning', array('type' => 'checkbox', 'checked' => $checked));
                    ?>
                </div>
                <div class="col-md-6">
                    <?php $checked = $appraisals['Appraisal']['status_remained_unchanged'] ? 'checked' : '';
                    echo $this->Form->input('status_remained_unchanged', array('type' => 'checkbox', 'checked' => $checked));
                    ?>
                </div>
                <div class="col-md-6">
                    <?php $checked = $appraisals['Appraisal']['successful_probation_completion'] ? 'checked' : '';
                    echo $this->Form->input('successful_probation_completion', array('type' => 'checkbox', 'checked' => $checked));
                    ?>
                </div>
                <div class="col-md-6">
                    <?php $checked = $appraisals['Appraisal']['salary_increment'] ? 'checked' : '';
                    echo $this->Form->input('salary_increment', array('type' => 'checkbox', 'checked' => $checked));
                    ?>
                </div>
                <div class="col-md-6">
                    <?php $checked = $appraisals['Appraisal']['termination'] ? 'checked' : '';
                    echo $this->Form->input('termination', array('type' => 'checkbox', 'checked' => $checked));
                    ?>
                </div>
                <div class="col-md-6">
                    <?php $checked = $appraisals['Appraisal']['training_requirements'] ? 'checked' : '';
                    echo $this->Form->input('training_requirements', array('type' => 'checkbox', 'checked' => $checked));
                    ?>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('specific_requirement', array('value' => $appraisals['Appraisal']['specific_requirement'])); ?></div>
            </div>

            <div class="col-md-12">&nbsp;</div>

            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('increament', array('value' => $appraisals['Appraisal']['increament'])); ?></div>
            </div>
            <?php if (count($kras)) echo $this->element('kra'); ?>
            <br />&nbsp;
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success','id'=>'submit_id')); ?>
            <?php echo $this->Html->link('Cancel', array('action' => 'index'), array('type' => 'button', 'class' => 'btn btn-danger')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
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