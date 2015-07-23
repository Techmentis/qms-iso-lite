<div id="customTemplates_ajax">
<?php echo $this->Session->flash();?>
<div class="nav panel panel-default">
<div class="customTemplates form col-md-8">
<h4><?php echo __('View Custom Template'); ?>
		<?php echo $this->Html->link(__('List'), array('action' => 'index'),array('id'=>'list','class'=>'label btn-info')); ?>
		<?php echo $this->Html->link(__('Edit'), '#edit',array('id'=>'edit','class'=>'label btn-info','data-toggle'=>'modal')); ?>
		<?php echo $this->Html->link(__('Add'), '#add',array('id'=>'add','class'=>'label btn-info','data-toggle'=>'modal')); ?>
		<?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
		</h4>
<table class="table table-responsive">
		<tr><td><?php echo __('Sr. No'); ?></td>
		<td>
			<?php echo h($customTemplate['CustomTemplate']['sr_no']); ?>
			&nbsp;
		</td></tr>
		<tr><td><?php echo __('Name'); ?></td>
		<td>
			<?php echo h($customTemplate['CustomTemplate']['name']); ?>
			&nbsp;
		</td></tr>
		<tr><td><?php echo __('Description'); ?></td>
		<td>
			<?php echo h($customTemplate['CustomTemplate']['description']); ?>
			&nbsp;
		</td></tr>
		<tr><td><?php echo __('Details'); ?></td>
		<td>
			<?php echo html_entity_decode($customTemplate['CustomTemplate']['details']); ?>
			&nbsp;
		</td></tr>
		<tr><td><?php echo __('Publish'); ?></td>

		<td>
			<?php if($customTemplate['CustomTemplate']['publish'] == 1) { ?>
			<span class="glyphicon glyphicon-ok-sign"></span>
			<?php } else { ?>
			<span class="glyphicon glyphicon-remove-circle"></span>
			<?php } ?>&nbsp;</td>
&nbsp;</td></tr>
		<tr><td><?php echo __('Branch'); ?></td>
		<td>
			<?php echo $this->Html->link($customTemplate['BranchIds']['name'], array('controller' => 'branches', 'action' => 'view', $customTemplate['BranchIds']['id'])); ?>
			&nbsp;
		</td></tr>
		<tr><td><?php echo __('Department'); ?></td>
		<td>
			<?php echo $this->Html->link($customTemplate['DepartmentIds']['name'], array('controller' => 'departments', 'action' => 'view', $customTemplate['DepartmentIds']['id'])); ?>
			&nbsp;
		</td></tr>
</table>
<?php echo $this->element('upload-edit',array('usersid'=>$customTemplate['CustomTemplate']['created_by'],'record_id'=>$customTemplate['CustomTemplate']['id'])); ?>
</div>
<div class="col-md-4">
	<p><?php echo $this->element('helps'); ?></p>
</div>
</div>
<?php echo $this->Js->get('#list');?>
<?php echo $this->Js->event('click',$this->Js->request(array('action' => 'index', 'ajax'),array('async' => true, 'update' => '#customTemplates_ajax')));?>

<?php echo $this->Js->get('#edit');?>
<?php echo $this->Js->event('click',$this->Js->request(array('action' => 'edit',$customTemplate['CustomTemplate']['id'] ,'ajax'),array('async' => true, 'update' => '#customTemplates_ajax')));?>

<?php echo $this->Js->get('#add');?>
<?php echo $this->Js->event('click',$this->Js->request(array('action' => 'lists', null ,'ajax'),array('async' => true, 'update' => '#customTemplates_ajax')));?>

<?php echo $this->Js->writeBuffer();?>

</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>
