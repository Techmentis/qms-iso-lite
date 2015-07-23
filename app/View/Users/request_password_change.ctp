<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>
<script>

    $().ready(function() {
        $('#UserResetPasswordForm').validate({
           
        });

    });
</script>
<div  id="users_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">
        <div class="nav panel">
            <div class="col-md-12">
               
                    <h2><?php echo __('Forgot your password?'); ?></h2>
                    <p><?php echo __('Please enter the username you used for registration and you\'ll get an email with further instructions.'); ?>
             
                <?php
                    echo $this->Form->create('User', array('controller' => 'user', 'action' => 'reset_password', 'role' => 'form', 'class' => 'form-signin pull-left', 'type' => 'post'));
                    echo $this->Form->input('username', array('label' => __('User Name'), 'div' => false, 'placeholder' => 'Please Enter Username'));
                  ?>
                <div style="clear:both"> <br/> </div> 
                  <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success','id'=>'submit_id'));
                    echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator'));
                    echo $this->Form->end();
                ?>
                <?php echo $this->Js->writeBuffer(); ?>
                </p>
                  </div>
            </div>
        </div>
    </div>

<script>
    $("#submit-indicator").hide();
    $("#submit_id").click(function(){
         if($('#UserResetPasswordForm').valid()){
             $("#submit_id").prop("disabled",true);
             $("#submit-indicator").show();
             $("#UserResetPasswordForm").submit();
         }
    });
</script>