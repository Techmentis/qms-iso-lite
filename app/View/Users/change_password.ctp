<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>

    $().ready(function() {
        $('#UserChangePasswordForm').validate({
            rules: {
                'data[User][current_password]': {
                    required: true,
                },
                'data[User][new_password]': {
                    required: true,
                },
                'data[User][confirm_password]': {
                    required: true,
                    equalTo: "#UserNewPassword",
                },
            }
        });

    });
</script>

<div class="nav panel panel-default">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">
        <div class="change_password form col-md-8">
            <h4><?php echo __("Reset your Password"); ?></h4>
            <?php echo $this->Form->create(array('role' => 'form', 'class' => 'form')); ?>
            <div class="row">
                <div class="col-md-4"><?php echo $this->Form->input('current_password', array('label' => __('Current Password'), 'type' => 'password', 'div' => false)); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('new_password', array('label' => __('New Password'), 'type' => 'password', 'div' => false)); ?></div>
                <div class="col-md-4"><?php echo $this->Form->input('confirm_password', array('label' => __('Confirm Password'), 'type' => 'password', 'div' => false)); ?></div>

                <?php
                    echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id')));
                    echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id')));
                ?>
            </div>

            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success','id'=>'submit_id')); ?>
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
        }
    });
    $("#submit-indicator").hide();
    $("#submit_id").click(function(){
        if($('#UserChangePasswordForm').valid()){
             $("#submit_id").prop("disabled",true);
             $("#submit-indicator").show();
             $("#UserChangePasswordForm").submit();
         }
    });
</script>