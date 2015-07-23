<div id="timelines_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="timelines form col-md-8">
            <h4><?php echo __('Edit Timeline'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                
            </h4>
            <?php echo $this->Form->create('Timeline', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>

            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('title'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('message'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('start_date'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('end_date'); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('prepared_by', array('options' => $prepared_by, 'style' => 'width:100%')); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('approved_by', array('options' => $prepared_by, 'style' => 'width:100%')); ?></div>
            </div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success')); ?>
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
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#timelines_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>
