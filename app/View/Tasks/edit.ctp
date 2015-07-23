<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function (error, element) {
            if ($(element).attr('name') == 'data[Task][user_id]' ||
                $(element).attr('name') == 'data[Task][schedule_id]') {
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

        $('#TaskEditForm').validate({
            rules: {
                "data[Task][user_id]": {
                    greaterThanZero: true,
                },
                "data[Task][schedule_id]": {
                    greaterThanZero: true,
                },
            }
        });
        
        $('#TaskName').blur(function() {
            $("#getTaskName").load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_task_name/' + encodeURIComponent(this.value) + '/<?php echo $this->data['Task']['id']; ?>', function(response, status, xhr) {
                if (response != "") {
                    $('#TaskName').val('');
                    $('#TaskName').addClass('error');
                } else {
                    $('#TaskName').removeClass('error');
                }
            });
        });
        
        $("#submit-indicator").hide();
        $("#submit_id").click(function(){
             if($('#TaskEditForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
                 $("#TaskEditForm").submit();
             }
        });
        $('#TaskUserId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#TaskScheduleId').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<div id="tasks_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="tasks form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Edit Task'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>

            </h4>
            <?php echo $this->Form->create('Task', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>
            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->input('name'); ?>
                    <label id="getTaskName" class="error" style="clear:both" ></label>
                </div>
                <div class="col-md-6"><?php echo $this->Form->input('user_id', array('style' => 'width:100%')); ?></div>
            </div>
            <div class="row">
                <div class="col-md-6"><?php
                echo $this->Form->input('master_list_of_format_id', array('style' => 'width:100%')); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('schedule_id', array('style' => 'width:100%')); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('description', array('type' => 'textarea')); ?></div>
            </div>
            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish');
                }
            ?>
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
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#tasks_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

