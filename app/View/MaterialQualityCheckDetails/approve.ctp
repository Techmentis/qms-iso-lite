 <div id="materialQualityCheckDetails_ajax">
<?php echo $this->Session->flash();?>	
<div class="nav">
<div class="materialQualityCheckDetails form col-md-8">
<h4><?php echo __('Approve Material Quality Check Detail'); ?>		
		<?php echo $this->Html->link(__('List'), array('action' => 'index'),array('id'=>'list','class'=>'label btn-info')); ?>
		<?php echo $this->Html->link(__('Import'), '#import',array('class'=>'label btn-info','data-toggle'=>'modal')); ?>
		</h4>
<?php echo $this->Form->create('MaterialQualityCheckDetail',array('role'=>'form','class'=>'form')); ?>
	<fieldset>
		
	<?php
		echo $this->Form->input('id'); 
		echo $this->Form->input('material_quality_check'); 
		echo $this->Form->input('employee_id',array('style'=>'width:90%')); 
		echo $this->Js->link('Add New',array('controller'=>'employees','action'=>'add'),array('class'=>'label btn-info','update'=>'#materialQualityCheckDetails_ajax'));
		echo $this->Form->input('check_performed_date'); 
		echo $this->Form->input('quantity_received'); 
		echo $this->Form->input('quantity_accepted'); 
		echo $this->Form->input('branchid'); 
		echo $this->Form->input('departmentid'); 
		echo $this->Form->input('company_id',array('style'=>'width:90%')); 
		echo $this->Js->link('Add New',array('controller'=>'companys','action'=>'add'),array('class'=>'label btn-info','update'=>'#materialQualityCheckDetails_ajax'));
	?>
	<?php if($show_approvals && $show_approvals['show_panel'] == true ) { ?>
		<div class="clearfix">&nbsp;</div><div class="panel panel-default"> <div class="panel-heading"><h3 class="panel-title"><?php echo __("Send for approval") ?></h3></div><div class="panel-body"><?php echo __("Records added to this table will be send to the person you choose from the list below.")?>
			<?php echo $this->Form->input('Approval.user_id',array('options'=>$userids));?>
			<?php echo $this->Form->input('Approval.comments',array('type'=>'textarea'));?>
		<?php if($same == $this->Session->read('User.id'))echo $this->Form->input('publish',array('label'=>'Do not send forward. Publish Now')) ?>
	</div>
		<?php echo $this->element("approval_history");?>
		</div><?php } else { ?>
				<?php echo $this->Form->input('publish');?>
	<?php } ?>
<?php echo $this->Form->submit('Submit',array('div'=>false,'class'=>'btn btn-primary btn-success')); ?>
<?php echo $this->Form->end(); ?>
<?php echo $this->Js->writeBuffer();?>
	</fieldset>
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
<?php echo $this->Js->event('click',$this->Js->request(array('action' => 'index', 'ajax'),array('async' => true, 'update' => '#materialQualityCheckDetails_ajax')));?>

<?php echo $this->Js->writeBuffer();?>
</div>
		<div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">Import from file (excel & csv formats only)</h4>
		</div>
<div class="modal-body"><?php echo $this->element('import'); ?></div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div></div></div></div>
