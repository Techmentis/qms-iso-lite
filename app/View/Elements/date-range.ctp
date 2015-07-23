<?php echo $this->Form->create('range', array('role' => 'form', 'class' => 'form', 'id' => 'advanced-search-form')); ?>
<div class="row">
    <div class="col-md-12"><?php echo $this->Form->input('keywords'); ?></div>
    <div class="col-md-6"><?php echo $this->Form->input('search_fields', array('options' => array($postData), 'multiple' => 'checkbox')); ?></div>
    <div class="col-md-6"><?php echo $this->Form->input('branch_list', array('options' => $PublishedBranchList, 'multiple')); ?></div>
    <div class="col-md-6"><?php echo $this->Form->input('ragne-from-date'); ?></div>
    <div class="col-md-6"><?php echo $this->Form->input('range-to-date'); ?></div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success')); ?>
        <?php echo $this->Form->end(); ?></div>
</div>

