<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function (error, element) {
            if ($(element).attr('name') == 'data[Appraisal][employee_id]')
                $(element).next().after(error);
            else if ($(element).attr('name') == 'data[Appraisal][appraiser_by]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        },
        submitHandler: function (form) {
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

                error: function (request, status, error) {
                    //alert(request.responseText);
                    alert('Action failed!');
                }
            });
        }
    });

    $().ready(function () {
    $("#submit-indicator").hide();
        jQuery.validator.addMethod("greaterThanZero", function (value, element) {
            return this.optional(element) || (value != -1);
        }, "Please select the value");
        $('#AppraisalAddAjaxForm').validate({
            rules: {
                "data[Appraisal][employee_id]": {
                    greaterThanZero: true,
                },
                "data[Appraisal][appraiser_by]": {
                    greaterThanZero: true,
                },
            }
        });
        $('#AppraisalEmployeeId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#AppraisalAppraiserBy').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });

    function addAgendaDiv() {
        var i = parseInt($('#AppraisalQuestionNumber').val());
        $.get("<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/add_questions/" + i, function (data) {
            $('#appraisal_question_ajax').append(data);
        });
        i = i + 1;
        $('#AppraisalQuestionNumber').val(i);
    }

    function removeAgendaDiv(i) {
        var r = confirm("Are you sure to remove this?");
        if (r == true) {
            $('#questions_ajax' + i).remove();
        }

    }
</script>

<div id="appraisals_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">
        <div class="appraisals form col-md-8">
            <h4><?php echo __('Add Appraisal'); ?></h4>
            <?php echo $this->Form->create('Appraisal', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>

            <div class="row">
                <legend><?php echo __('Step - 1 (Pre-Appraisal)'); ?></legend>
                <div class="col-md-6"><?php echo $this->Form->input('employee_id', array('label' => __('Employee'), 'options' => $PublishedEmployeeList)); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('appraiser_by', array('label' => __('Appraiser'), 'options' => $PublishedEmployeeList)); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('appraisal_date'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('self_appraisal_needed', array('type' => 'checkbox', 'div' => array('style' => 'padding-left:40px;'))); ?></div>
            </div>
            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('reason', array('rows' => '3')); ?></div>
            </div>

            <div id="questions">
                <br />&nbsp;
                <div class="alert alert-warning">
                    <?php echo __('Employee selected above will receive a link to appraisal questions via email.'); ?>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h4><?php echo __('Select Appraisal Questions'); ?></h4>
                        <hr>
                        <?php echo $this->Form->input('appraisal_question_id', array('label' => false, 'type' => 'select', 'multiple' => 'checkbox', 'options' => $appraisalQuestions, 'class' => 'selfApprNeeded checkbox')); ?>
                        <br />&nbsp;
                    </div>
                </div>
                <?php $i = 0; ?>
                <div id="appraisal_question_ajax"></div>
                <?php $i++; ?>
                <div class="col-md-6"><?php echo $this->Form->input('questionNumber', array('type' => 'hidden', 'value' => $i)); ?></div>
                <div class="row">
                    <?php echo $this->Form->button('Add New Question', array('label' => false, 'type' => 'button', 'div' => false, 'class' => 'btn btn-md btn-info pull-right', 'onclick' => 'addAgendaDiv()', 'style' => 'margin-bottom:25px;')); ?>
                </div>
            </div>

           <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>

            <?php echo $this->Form->submit('Submit', array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#appraisals_ajax', 'async' => 'false','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>

<script>
    $("[name*='date']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');

    $(document).ready(function () {
        $("#questions").hide();
        $("#AppraisalSelfAppraisalNeeded").click(function () {
	   // alert(3243);
         
            if (!$("#AppraisalSelfAppraisalNeeded").is(":checked")) {
                $('#questions').find(':checkbox').prop('checked', this.checked);
              //  $('#AppraisalPublish').prop('checked', this.checked);
              //  $('#AppraisalPublish').attr('disabled', false);
               $('#questions').find('input').val('');
            }
            if ($("#AppraisalSelfAppraisalNeeded").is(":checked")) {
              //  $('#AppraisalPublish').prop('checked', 'checked');
              //  $('#AppraisalPublish').attr('disabled', true);
            }
	       $("#questions").toggle(this.checked);
        });
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