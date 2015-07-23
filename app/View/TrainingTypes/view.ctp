<div id="trainingTypes_ajax">
<?php echo $this->Session->flash();?>
<div class="nav panel panel-default">
<div class="trainingTypes form col-md-8">
<h4><?php echo __('View Training Type'); ?>
		<?php echo $this->Html->link(__('List'), array('action' => 'index'),array('id'=>'list','class'=>'label btn-info')); ?>
		<?php echo $this->Html->link(__('Edit'), '#edit',array('id'=>'edit','class'=>'label btn-info','data-toggle'=>'modal')); ?>
		<?php echo $this->Html->link(__('Add'), '#add',array('id'=>'add','class'=>'label btn-info','data-toggle'=>'modal')); ?>
		<?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
		</h4>
<table class="table table-responsive">
		<tr><td><?php echo __('Sr. No'); ?></td>
		<td>
			<?php echo h($trainingType['TrainingType']['sr_no']); ?>
			&nbsp;
		</td></tr>
		<tr><td><?php echo __('Title'); ?></td>
		<td>
			<?php echo h($trainingType['TrainingType']['title']); ?>
			&nbsp;
		</td></tr>
		<tr><td><?php echo __('Training Description'); ?></td>
		<td>
			<?php echo h($trainingType['TrainingType']['training_description']); ?>
			&nbsp;
		</td></tr>
		<tr><td><?php echo __('Mandatory'); ?></td>
		<td>
			<?php echo $trainingType['TrainingType']['mandetory']? __('Yes'): __('No'); ?>
			&nbsp;
		</td></tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($trainingType['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($trainingType['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
		<tr><td><?php echo __('Publish'); ?></td>

		<td>
			<?php if($trainingType['TrainingType']['publish'] == 1) { ?>
			<span class="glyphicon glyphicon-ok-sign"></span>
			<?php } else { ?>
			<span class="glyphicon glyphicon-remove-circle"></span>
			<?php } ?>&nbsp;</td>
&nbsp;</td></tr>
		<tr><td><?php echo __('Branch'); ?></td>
		<td>
			<?php echo $this->Html->link($trainingType['BranchIds']['name'], array('controller' => 'branches', 'action' => 'view', $trainingType['BranchIds']['id'])); ?>
			&nbsp;
		</td></tr>
		<tr><td><?php echo __('Department'); ?></td>
		<td>
			<?php echo $this->Html->link($trainingType['DepartmentIds']['name'], array('controller' => 'departments', 'action' => 'view', $trainingType['DepartmentIds']['id'])); ?>
			&nbsp;
		</td></tr>
</table>
<?php echo $this->element('upload-edit',array('usersid'=>$trainingType['TrainingType']['created_by'],'record_id'=>$trainingType['TrainingType']['id'])); ?>
</div>
<div class="col-md-4">
	<p><?php echo $this->element('helps'); ?></p>
</div>
</div>
<?php echo $this->Js->get('#list');?>
<?php echo $this->Js->event('click',$this->Js->request(array('action' => 'index', 'ajax'),array('async' => true, 'update' => '#trainingTypes_ajax')));?>

<?php echo $this->Js->get('#edit');?>
<?php echo $this->Js->event('click',$this->Js->request(array('action' => 'edit',$trainingType['TrainingType']['id'] ,'ajax'),array('async' => true, 'update' => '#trainingTypes_ajax')));?>


<?php echo $this->Js->get('#add');?>
<?php echo $this->Js->event('click',$this->Js->request(array('action' => 'lists', null ,'ajax'),array('async' => true, 'update' => '#trainingTypes_ajax')));?>

<?php echo $this->Js->writeBuffer();?>

</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>
