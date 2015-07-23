<?php echo $this->Form->create('MakerChecker'); ?>
<fieldset>
    <?php
        echo $this->Form->input('modal_name', array('value' => $this->name));
        echo $this->Form->input('record', array('value' => $postData));
        echo $this->Form->input(__('checker'), array('options' => $employeesList));
        echo $this->Form->input(__('comments'));
        echo $this->Form->input(__('send_to_maker'), array('options' => $employeesList));
    ?>
    <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success')); ?>
    <?php echo $this->Form->end(); ?>
</fieldset>
<script>
    $("[name*='date']").datepicker({
        changeMonth: true,
        changeYear: true
    });
</script>
