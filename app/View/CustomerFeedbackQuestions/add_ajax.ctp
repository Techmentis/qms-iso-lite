<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                url: '<?php echo Router::url('/', true); ?><?php echo $this->params['controller'] ?>/add_ajax',
                type: 'POST',
                beforeSend: function(){
                   $("#submit_id").prop("disabled",true);
                    $("#submit-indicator").show();
                },
                complete: function() {
                   $("#submit_id").removeAttr("disabled");
                   $("#submit-indicator").hide();
                },
                target: '#main'});
        }
    });

    $().ready(function() {
    $("#submit-indicator").hide();
        $('#CustomerFeedbackQuestionAddAjaxForm').validate();
    });
</script>

<div id="customerFeedbackQuestions_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">
        <div class="customerFeedbackQuestions form col-md-8">
            <h4><?php echo __('Add Customer Feedback Question'); ?></h4>
            <?php echo $this->Form->create('CustomerFeedbackQuestion', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>
            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('title', array('label' => 'Question', 'placeholder' => 'How do you find our service / product')); ?></div>
                <div class="col-md-12">
                    <?php echo $this->Form->input('question_type', array('label' => 'Question type : Optional / Comment', 'type' => 'radio', 'options' => array(0 => 'Optional', 1 => 'Comment'), 'default' => 0)); ?>
                    <span class="help-text"><strong>Note : </strong><?php echo __('If question type is Optional, fill out options below, else leave blank.') ?></span>
                    <br />
                </div>
                <div class="col-md-4"><?php echo $this->Form->input('option_one', array('label' => 'Option One', 'placeholder' => 'Excellent')); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('option_two', array('label' => 'Option Two', 'placeholder' => 'Very Good')); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('option_three', array('label' => 'Option Three', 'placeholder' => 'Good')); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('option_four', array('label' => 'Option Four', 'placeholder' => 'Bad')); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('option_five', array('label' => 'Option Five', 'placeholder' => 'Poor')); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('option_six', array('label' => 'Option Six', 'placeholder' => 'Very Poor')); ?></div>
                <?php
                    echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id')));
                    echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id')));
                    echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id']));
                ?>
            </div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish');
                }
            ?>
            <?php echo $this->Form->submit('Submit', array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#customerFeedbackQuestions_ajax', 'async' => 'false','id'=>'submit_id')); ?>
             <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>
<script>
    $("[name*='date']").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
    });
</script>
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