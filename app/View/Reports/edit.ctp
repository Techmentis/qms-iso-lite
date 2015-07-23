 <div id="reports_ajax">
<?php echo $this->Session->flash();?>
<div class="nav panel panel-default">
<div class="reports form col-md-8">
<h4><?php echo __('Edit Report'); ?>
		<?php echo $this->Html->link(__('List'), array('action' => 'index'),array('id'=>'list','class'=>'label btn-info')); ?>
		<?php echo $this->Html->link(__('Import'), '#import',array('class'=>'label btn-info','data-toggle'=>'modal')); ?>
		</h4>
<?php echo $this->Form->create('Report',array('role'=>'form','class'=>'form')); ?>

	<?php echo $this->Form->input('id'); ?>

	    <div class="row">
		<div class="col-md-6"><?php echo $this->Form->input('title'); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('branch_id',array('style'=>'width:100%', 'label'=> __('Branch'))); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('department_id', array('style'=>'width:100%', 'label'=> __('Department'))); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('description'); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('details'); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('report_date'); ?></div>
		<?php
		echo $this->Form->input('branchid',array('type'=>'hidden','value'=>$this->Session->read('User.branch_id')));
		echo $this->Form->input('departmentid',array('type'=>'hidden','value'=>$this->Session->read('User.department_id')));
		?>
	    </div>

<?php if($showApprovals && $showApprovals['show_panel'] == true ) { ?>
<?php echo $this->element('approval_form'); ?>
<?php } else {echo $this->Form->input('publish', array('label'=> __('Publish'))); } ?>
<?php echo $this->Form->submit(__('Submit'),array('div'=>false,'class'=>'btn btn-primary btn-success')); ?>
<?php echo $this->Form->end(); ?>
<?php echo $this->Js->writeBuffer();?>

</div>
<script> $("[name*='date']").datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat:'yy-mm-dd',
    }); </script>
<div class="col-md-4">
	<p><?php echo $this->element('helps'); ?></p>
</div>
</div>
<?php echo $this->Js->get('#list');?>
<?php echo $this->Js->event('click',$this->Js->request(array('action' => 'index', 'ajax'),array('async' => true, 'update' => '#reports_ajax')));?>

<?php echo $this->Js->writeBuffer();?>
</div>
		<div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title"><?php echo __('Import from file (excel & csv formats only)'); ?></h4>
		</div>
<div class="modal-body"><?php echo $this->element('import'); ?></div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close');?></button>
		</div></div></div></div></div>