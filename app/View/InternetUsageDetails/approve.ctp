 <div id="internetUsageDetails_ajax">
<?php echo $this->Session->flash();?>	
<div class="nav">
<div class="internetUsageDetails form col-md-8">
<h4><?php echo __('Approve Internet Usage Detail'); ?>		
		<?php echo $this->Html->link(__('List'), array('action' => 'index'),array('id'=>'list','class'=>'label btn-info')); ?>
		<?php echo $this->Html->link(__('Import'), '#import',array('class'=>'label btn-info','data-toggle'=>'modal')); ?>
		</h4>
<?php echo $this->Form->create('InternetUsageDetail',array('role'=>'form','class'=>'form')); ?>
	<fieldset>
		
	<?php
		echo $this->Form->input('id'); 
		echo $this->Form->input('internet_provider_name'); 
		echo $this->Form->input('plan_details'); 
		echo $this->Form->input('from_date'); 
		echo $this->Form->input('to_date'); 
		echo $this->Form->input('download'); 
		 
		 
	?>
	<?php if($showApprovals && $showApprovals['show_panel'] == true ) { ?>
		<div class="clearfix">&nbsp;</div><div class="panel panel-default"> <div class="panel-heading"><h3 class="panel-title"><?php echo __("Send for approval") ?></h3></div><div class="panel-body"><?php echo __("Records added to this table will be send to the person you choose from the list below.")?>
			<?php echo $this->Form->input('Approval.user_id',array('options'=>$userids));?>
			<?php echo $this->Form->input('Approval.comments',array('type'=>'textarea'));?>
		<?php if($same == $this->Session->read('User.id'))echo $this->Form->input('publish',array('label'=>'Do not send forward. Publish Now')) ?>
	</div>
		<?php echo $this->element("approval_history");?>
		</div><?php } else { ?>
				<?php echo $this->Form->input('publish', array('label'=> __('Publish')));?>
	<?php } ?>
<?php echo $this->Form->submit(__('Submit'),array('div'=>false,'class'=>'btn btn-primary btn-success')); ?>
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
<?php echo $this->Js->event('click',$this->Js->request(array('action' => 'index', 'ajax'),array('async' => true, 'update' => '#internetUsageDetails_ajax')));?>

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
		</div></div></div></div>
