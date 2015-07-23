<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {

            if ($(element).attr('name') == 'data[CustomerFeedback][customer_id]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/add_ajax",
                type: 'POST',
                target: '#main',
                 beforeSend: function(){
                   $("#submit_id").prop("disabled",true);
                    $("#submit-indicator").show();
                },
                complete: function() {
                   $("#submit_id").removeAttr("disabled");
                   $("#submit-indicator").hide();
                },
                error: function(request, status, error) {
                    //alert(request.responseText);
                    alert('Action failed!');
                }
	    });
        }
    });

    $().ready(function() {
     $("#submit-indicator").hide();
        jQuery.validator.addMethod("greaterThanZero", function(value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");
        $('#CustomerFeedbackAddAjaxForm').validate({
            rules: {
                "data[CustomerFeedback][customer_id]": {
                    greaterThanZero: true,
                }

            }

        });
        $('#CustomerFeedbackCustomerId').change(function() {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<div id="customerFeedbacks_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">
        <div class="customerFeedbacks form col-md-8">
            <h4><?php echo __('Add Customer Feedback'); ?></h4>
            <?php echo $this->Form->create('CustomerFeedback', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>
            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('customer_id'); ?></div>
            </div>

            <?php
                $i = 0;
                foreach ($customerFeedbackQuestions as $questions):
            ?>
            <div class="row">
                    <div class="col-md-12">
                        <?php
                            echo "<br/><hr><h4>" . $questions['CustomerFeedbackQuestion']['title'] . "</h4>";
                            echo $this->Form->hidden('CustomerFeedback.Questions.' . $i . '.customer_feedback_question_id', array('value' => $questions['CustomerFeedbackQuestion']['id']));
                        ?>
                    </div>
                </div>
                <?php
                    $options = null;
                    if (isset($questions['CustomerFeedbackQuestion']['option_one']) && $questions['CustomerFeedbackQuestion']['option_one'] != '')
                        $options[$questions['CustomerFeedbackQuestion']['option_one']] = $questions['CustomerFeedbackQuestion']['option_one'];
                    if (isset($questions['CustomerFeedbackQuestion']['option_two']) && $questions['CustomerFeedbackQuestion']['option_two'] != '')
                        $options[$questions['CustomerFeedbackQuestion']['option_two']] = $questions['CustomerFeedbackQuestion']['option_two'];
                    if (isset($questions['CustomerFeedbackQuestion']['option_three']) && $questions['CustomerFeedbackQuestion']['option_three'] != '')
                        $options[$questions['CustomerFeedbackQuestion']['option_three']] = $questions['CustomerFeedbackQuestion']['option_three'];
                    if (isset($questions['CustomerFeedbackQuestion']['option_four']) && $questions['CustomerFeedbackQuestion']['option_four'] != '')
                        $options[$questions['CustomerFeedbackQuestion']['option_four']] = $questions['CustomerFeedbackQuestion']['option_four'];
                    if (isset($questions['CustomerFeedbackQuestion']['option_five']) && $questions['CustomerFeedbackQuestion']['option_five'] != '')
                        $options[$questions['CustomerFeedbackQuestion']['option_five']] = $questions['CustomerFeedbackQuestion']['option_five'];
                    if (isset($questions['CustomerFeedbackQuestion']['option_six']) && $questions['CustomerFeedbackQuestion']['option_six'] != '')
                        $options[$questions['CustomerFeedbackQuestion']['option_six']] = $questions['CustomerFeedbackQuestion']['option_six'];
                ?>
                <div class="row">
                    <?php if ($questions['CustomerFeedbackQuestion']['question_type'] == 0):?>
                        <?php if(!empty($options) && $options != ''):?>
                        <div class="col-md-12"><?php echo $this->Form->input('CustomerFeedback.Questions.' . $i . '.answer', array('type' => 'radio', 'legend' => false, 'div' => array('style' => 'padding-left:0px'), 'options' => $options));?>
                        </div>
                    <?php endif;
                    endif; ?>
                    <div class="col-md-12"><?php echo $this->Form->input('CustomerFeedback.Questions.' . $i . '.comments', array('rows' => 3)); ?></div>
                </div>

                <?php
                    echo $this->Form->input('CustomerFeedback.Questions.' . $i . '.branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id')));
                    echo $this->Form->input('CustomerFeedback.Questions.' . $i . '.departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id')));
                    echo $this->Form->input('CustomerFeedback.Questions.' . $i . '.master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id']));
                ?>
            <?php
                $i++;
                endforeach
            ?>
            <?php echo $this->Form->input('master_list_of_format_id', array('type' => 'hidden', 'value' => $documentDetails['MasterListOfFormat']['id'])); ?>
            
            <div class =row>
                <div class = "col-md-6"><?php echo $this->Form->input('prepared_by', array('options' => $PublishedEmployeeList,'default'=>$this->Session->read('User.employee_id'))); ?></div>
                <div class = "col-md-6"><?php echo $this->Form->input('approved_by', array('options' => $PublishedEmployeeList)); ?></div>
            </div>
                <?php
                if (isset($showApprovals) && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish');
                }
            ?>
            <br/>
            <?php echo $this->Form->submit('Submit', array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#customerFeedbacks_ajax', 'async' => 'false','id'=>'submit_id')); ?>
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