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
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        $('#TaskAddAjaxForm').validate({
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
            $("#getTaskName").load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/get_task_name/' + encodeURIComponent(this.value), function(response, status, xhr) {
                if (response != "") {
                    $('#TaskName').val('');
                    $('#TaskName').addClass('error');
                } else {
                    $('#TaskName').removeClass('error');
                }
            });
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
    <div class="nav">
        <div class="tasks form col-md-8">
            <h4><?php echo __('Add Task'); ?></h4>
            <?php echo $this->Form->create('Task', array('role' => 'form', 'class' => 'form', 'default' => false)); ?>

            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->Form->input('name'); ?>
                    <label id="getTaskName" class="error" style="clear:both" ></label>
                </div>
                <div class="col-md-6"><?php echo $this->Form->input('user_id', array('style' => 'width:100%')); ?></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger">
                        <?php echo ('<strong>' . __('Note : ') . '</strong><p>' . __('If you are assigning a new task to a user, make sure that the user has a permission to access the tasks.') . '</p><p>' . __('You can change the user permissions from Users -> View -> Manage Access Control, then click on MR and check the tasks section to provide required permission') . '</p>'); ?>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('master_list_of_format_id'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('schedule_id', array('style' => 'width:100%')); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('description', array('type' => 'textarea')); ?></div>
                <?php
		    echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id')));
		    echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id')));
                ?>
            </div>
            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish');
                }
            ?>
            <?php echo $this->Form->submit('Submit', array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#tasks_ajax', 'async' => 'false','id'=>'submit_id')); ?>
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
    $.ajaxSetup({
        beforeSend: function () {
            $("#busy-indicator").show();
        },
        complete: function () {
            $("#busy-indicator").hide();
        }
    });
</script>