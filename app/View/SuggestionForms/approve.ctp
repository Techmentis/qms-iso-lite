<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function (error, element) {
            if ($(element).attr('name') == 'data[SuggestionForm][employee_id]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        },
    });

    $().ready(function () {
        jQuery.validator.addMethod("greaterThanZero", function (value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        $('#SuggestionFormApproveForm').validate({
            rules: {
                "data[SuggestionForm][employee_id]": {
                    greaterThanZero: true,
                },
            }
        });
        $("#submit-indicator").hide();
        $("#submit_id").click(function(){
             if($('#SuggestionFormApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#SuggestionFormApproveForm").submit();
             }

        });
        $('#SuggestionFormEmployeeId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<div id="SuggestionForms_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="SuggestionForms form col-md-8">
            <h4><?php echo __('Approve Suggestion Form'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>

            </h4>
            <?php echo $this->Form->create('SuggestionForm', array('role' => 'form', 'class' => 'form')); ?>

            <?php echo $this->Form->input('id'); ?>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('employee_id'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('title'); ?></div>
            </div>
            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('activity'); ?></div>
            </div>
            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('suggestion'); ?></div>
            </div>
            <div class="row">
                <?php if ($this->Session->read('User.is_mr' == true)) { ?>
                    <div class="col-md-12"><?php echo $this->Form->input('remark'); ?></div>
                </div>
                <div class="row">
                    <div class="col-md-12"><h6>Add To CAPA ?</h6><?php echo $this->Form->input('add_to_capa', array('type' => 'radio', 'legend' => false, 'options' => array('Yes', 'No'))); ?></div>
                <?php } ?>
            </div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success','id'=>'submit_id')); ?>
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
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#SuggestionForms_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

