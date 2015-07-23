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
    });

    $().ready(function() {
        $("#submit-indicator").hide();
        jQuery.validator.addMethod("greaterThanZero", function(value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");
        $('#CustomerFeedbackEditForm').validate({
            rules: {
                "data[CustomerFeedback][customer_id]": {
                    greaterThanZero: true,
                }

            }

        });
        $("#submit_id").click(function(){
             if($('#CustomerFeedbackEditForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
                 $("#CustomerFeedbackEditForm").submit();
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
    <div class="nav panel panel-default">
        <div class="customerFeedbacks form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Edit Customer Feedback'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>

            <?php echo $this->Form->create('CustomerFeedback', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>

            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('customer_id'); ?></div>
            </div>
            <?php
                $i = 0;
                foreach ($customerFeedbackQuestions as $key => $questions):
            ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            echo "<br/><h4>" . $questions['CustomerFeedbackQuestion']['title'] . "</h4>";
                            echo $this->Form->hidden('CustomerFeedback.Questions.' . $i . '.customer_feedback_question_id', array('value' => $questions['CustomerFeedbackQuestion']['id']));
                        ?>
                    </div>
                </div>

                <div class="row">
                  <?php
                        $options = array();
                        if ($questions['CustomerFeedbackQuestion']['option_one'] && $questions['CustomerFeedbackQuestion']['option_one'] != '')
                            $options[$questions['CustomerFeedbackQuestion']['option_one']] = $questions['CustomerFeedbackQuestion']['option_one'];
                        if ($questions['CustomerFeedbackQuestion']['option_two'] && $questions['CustomerFeedbackQuestion']['option_two'] != '')
                            $options[$questions['CustomerFeedbackQuestion']['option_two']] = $questions['CustomerFeedbackQuestion']['option_two'];
                        if ($questions['CustomerFeedbackQuestion']['option_three'] && $questions['CustomerFeedbackQuestion']['option_three'] != '')
                            $options[$questions['CustomerFeedbackQuestion']['option_three']] = $questions['CustomerFeedbackQuestion']['option_three'];
                        if ($questions['CustomerFeedbackQuestion']['option_four'] && $questions['CustomerFeedbackQuestion']['option_four'] != '')
                            $options[$questions['CustomerFeedbackQuestion']['option_four']] = $questions['CustomerFeedbackQuestion']['option_four'];
                        if ($questions['CustomerFeedbackQuestion']['option_five'] && $questions['CustomerFeedbackQuestion']['option_five'] != '')
                            $options[$questions['CustomerFeedbackQuestion']['option_five']] = $questions['CustomerFeedbackQuestion']['option_five'];
                        if ($questions['CustomerFeedbackQuestion']['option_six'] && $questions['CustomerFeedbackQuestion']['option_six'] != '')
                            $options[$questions['CustomerFeedbackQuestion']['option_six']] = $questions['CustomerFeedbackQuestion']['option_six'];
                    ?>
                    <?php if ($questions['CustomerFeedbackQuestion']['question_type'] == 0):?>
                        <?php if(!empty($options) && $options != ''):?>
                    <div class="col-md-12"><?php echo $this->Form->input('CustomerFeedback.Questions.' . $i . '.answer', array('type' => 'radio', 'legend' => false, 'div' => array('style' => 'padding-left:0px'), 'options' => $options, 'value' => $customerFeedbackDetails[$questions['CustomerFeedbackQuestion']['id']]['answer'])); ?></div>
                    <?php endif; endif; ?>
                    <div class="col-md-12"><?php echo $this->Form->input('CustomerFeedback.Questions.' . $i . '.comments', array('rows' => 3, 'value' => $customerFeedbackDetails[$questions['CustomerFeedbackQuestion']['id']]['comments'])); ?>
                        <?php echo $this->Form->input('CustomerFeedback.Questions.' . $i . '.id', array('type' => 'hidden', 'value' => $customerFeedbackDetails[$questions['CustomerFeedbackQuestion']['id']]['id'])); ?>
                    </div>
                </div>

            <?php
                $i++;
                endforeach
            ?>
            <div class =row>
                <div class = "col-md-6"><?php echo $this->Form->input('prepared_by', array('options' => $PublishedEmployeeList,'default'=>$this->Session->read('User.employee_id'))); ?></div>
                <div class = "col-md-6"><?php echo $this->Form->input('approved_by', array('options' => $PublishedEmployeeList)); ?></div>
            </div>
            <?php
                if(isset($showApprovals) && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish');
                }
            ?>
            <br/>
            <?php echo $this->Form->submit('Submit', array('div' => false, 'class' => 'btn btn-primary btn-success','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#customerFeedbacks_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

