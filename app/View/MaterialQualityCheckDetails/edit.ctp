 <div id="materialQualityCheckDetails_ajax">
<?php echo $this->Session->flash();?>	
<div class="nav panel panel-default">
<div class="materialQualityCheckDetails form col-md-8">
<h4><?php echo __('Edit Material Quality Check Detail'); ?>		
		<?php echo $this->Html->link(__('List'), array('action' => 'index'),array('id'=>'list','class'=>'label btn-info')); ?>
		<?php echo $this->Html->link(__('Import'), '#import',array('class'=>'label btn-info','data-toggle'=>'modal')); ?>
		</h4>
<?php echo $this->Form->create('MaterialQualityCheckDetail',array('role'=>'form','class'=>'form')); ?>
	<fieldset>
		
	<div class="col-md-6"><?php echo $this->Form->input('id'); ?></div> 
	<div class="col-md-6"><?php echo $this->Form->input('material_quality_check'); ?></div> 
	<div class="col-md-6"><?php echo $this->Form->input('employee_id'); ?></div> 
	<div class="col-md-6"><?php echo $this->Form->input('check_performed_date'); ?></div> 
	<div class="col-md-6"><?php echo $this->Form->input('quantity_received'); ?></div> 
	<div class="col-md-6"><?php echo $this->Form->input('quantity_accepted'); ?></div> 
	<div class="col-md-6"><?php echo $this->Form->input('branchid',array('type'=>'hidden','value'=>$this->Session->read('User.branch_id'))); ?></div> 
	<div class="col-md-6"><?php echo $this->Form->input('departmentid',array('type'=>'hidden','value'=>$this->Session->read('User.department_id'))); ?></div> 

	<?php if($show_approvals && $show_approvals['show_panel'] == true ) { ?>
		<?php echo $this->element('approval_form'); ?>
	</div> <?php } else {echo $this->Form->input('publish'); }
 ?>


<?php echo $this->Form->submit('Submit',array('div'=>false,'class'=>'btn btn-primary btn-success')); ?>
<?php echo $this->Form->end(); ?>
<?php echo $this->Js->writeBuffer();?>
	</fieldset>
</div>
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
