<div id="masterListOfFormats_ajax">
<?php echo $this->Session->flash();?>
<div class="nav panel panel-default">
<div class="masterListOfFormats form col-md-8">
<h4><?php echo __('View Master List Of Format'); ?>
		<?php
			if($this->request->params['pass'][1] == 1){
				echo $this->Html->link(__('List'), array('controller'=>'dashboard','action' => 'readiness'),array('id'=>'list','class'=>'label btn-info'));
			}else{
				echo $this->Html->link(__('List'), array('controller'=>'dashboard','action' => 'mr#tabs'),array('id'=>'list','class'=>'label btn-info'));
			}
		?>
		<?php if($masterListOfFormat['ChangeAdditionDeletionRequest'])echo $this->Html->link(__('Edit'), '#edit',array('id'=>'edit','class'=>'label btn-info','data-toggle'=>'modal')); ?>
		<?php // echo $this->Html->link(__('Add'), '#add',array('id'=>'add','class'=>'label btn-info','data-toggle'=>'modal')); ?>
		<?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
		</h4><?php if($masterListOfFormat['ChangeAdditionDeletionRequest']){ ?><small class="text-danger">This document is under revision</small><?php } ?>

<table class="table table-responsive">
		<tr><td><?php echo __('Sr. No'); ?></td>
		<td>
			<?php echo h($masterListOfFormat['MasterListOfFormat']['sr_no']); ?>
			&nbsp;
		</td></tr>
		<tr><td><?php echo __('Title'); ?></td>
		<td>
			<?php echo h($masterListOfFormat['MasterListOfFormat']['title']); ?>
			&nbsp;
		</td></tr>
		<tr><td><?php echo __('Document Number'); ?></td>
		<td>
			<?php echo h($masterListOfFormat['MasterListOfFormat']['document_number']); ?>
			&nbsp;
		</td></tr>
		<tr><td><?php echo __('Issue Number'); ?></td>
		<td>
			<?php echo h($masterListOfFormat['MasterListOfFormat']['issue_number']); ?>
			&nbsp;
		</td></tr>
		<tr><td><?php echo __('Revision Number'); ?></td>
		<td>
			<?php echo h($masterListOfFormat['MasterListOfFormat']['revision_number']); ?>
			&nbsp;
		</td></tr>
		<tr><td><?php echo __('Revision Date'); ?></td>
		<td>
			<?php echo h($masterListOfFormat['MasterListOfFormat']['revision_date']); ?>
			&nbsp;
		</td></tr>
		<tr><td colspan="2"><h3><?php echo __('Document Details'); ?></h3>
			<?php echo $masterListOfFormat['MasterListOfFormat']['document_details']; ?>
			&nbsp;
		</td></tr>
		<tr><td colspan="2"><h3><?php echo __('Work Instructions'); ?></h3>
			<?php echo $masterListOfFormat['MasterListOfFormat']['work_instructions']; ?>
			&nbsp;
		</td></tr>

		<tr><td><?php echo __('Prepared By'); ?></td>
		<td>
			<?php echo h($masterListOfFormat['PreparedBy']['name']); ?>
			&nbsp;
		</td></tr>
		<tr><td><?php echo __('Approved By'); ?></td>
		<td>
			<?php echo h($masterListOfFormat['ApprovedBy']['name']); ?>
			&nbsp;
		</td></tr>
		<tr><td><?php echo __('Archived'); ?></td>
		<td>
			<?php echo h($masterListOfFormat['MasterListOfFormat']['archived']) ? __('Yes') : __('No'); ?>
			&nbsp;
		</td></tr>
		<tr><td><?php echo __('Publish'); ?></td>

		<td>
			<?php if($masterListOfFormat['MasterListOfFormat']['publish'] == 1) { ?>
			<span class="glyphicon glyphicon-ok-sign"></span>
			<?php } else { ?>
			<span class="glyphicon glyphicon-remove-circle"></span>
			<?php } ?>&nbsp;</td>
&nbsp;</td></tr>
		<tr><td><?php echo __('Branch'); ?></td>
		<td>
			<?php echo $this->Html->link($masterListOfFormat['BranchIds']['name'], array('controller' => 'branches', 'action' => 'view', $masterListOfFormat['BranchIds']['id'])); ?>
			&nbsp;
		</td></tr>
		<tr><td><?php echo __('Department'); ?></td>
		<td>
			<?php echo $this->Html->link($masterListOfFormat['Department']['name'], array('controller' => 'departments', 'action' => 'view', $masterListOfFormat['Department']['id'])); ?>
			&nbsp;
		</td></tr>
        <?php if($masterListOfFormat['ChangeAdditionDeletionRequest']){
		?>
		<tr class="text-danger"><td><?php echo __('Proposed Changes'); ?></td>
		<td>
			<?php echo $masterListOfFormat['ChangeAdditionDeletionRequest'][0]['proposed_changes'] ?>
			&nbsp;
		</td></tr>
		<tr class="text-danger"><td><?php echo __('Reason For Change'); ?></td>
		<td>
			<?php echo $masterListOfFormat['ChangeAdditionDeletionRequest'][0]['reason_for_change'] ?>
			&nbsp;
		</td></tr>

		<?php } ?>

</table>
<?php echo $this->element('upload-edit',array('usersId'=>$masterListOfFormat['MasterListOfFormat']['created_by'],'recordId'=>$masterListOfFormat['MasterListOfFormat']['id'])); ?>
</div>
<div class="col-md-4">
	<p><?php echo $this->element('helps'); ?></p>
<?php $revision_count = 1 ?>
<?php foreach($revisions as $revision): ?>
        <div class="panel-group" id="revision"  style="margin-bottom:5px">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                    <?php echo $this->Html->link('Revision '.$revision_count,'#collapse'.$revision_count,array('data-toggle'=>'collapse', 'data-parent'=>'#revision','escape'=>false,'classe'=>'collapsed')); ?>
                    <small class="pull-right"><?php echo $this->Html->link('<span class="glyphicon glyphicon-new-window"></span>',array('controller'=>'document_amendment_record_sheets','action'=>'view',$revision['DocumentAmendmentRecordSheet']['id']),array('escape'=>false)); ?></small>
                </h4>
              </div>
              <div id="collapse<?php echo $revision_count ?>" class="panel-collapse collapse">
                <div class="panel-body">
                  <dl class="revision">
                    <dt><?php echo __('Document Title'); ?></dt><dd><?php echo $revision['MasterListOfFormatID']['title'] ?>&nbsp;</dd>
                    <dt><?php echo __('Document Number'); ?></dt><dd><?php echo $revision['DocumentAmendmentRecordSheet']['document_number'] ?>&nbsp;</dd>
                    <dt><?php echo __('Issue'); ?></dt><dd><?php echo $revision['DocumentAmendmentRecordSheet']['issue_number'] ?>&nbsp;</dd>
                    <dt><?php echo __('Revision'); ?></dt><dd><?php echo $revision['DocumentAmendmentRecordSheet']['revision_number'] ?>&nbsp;</dd>
                    <dt><?php echo __('Revision Date'); ?></dt><dd><?php echo $revision['DocumentAmendmentRecordSheet']['revision_date'] ?>&nbsp;</dd>
                    <dt><?php echo __('Amendment Details'); ?></dt><dd><?php echo $revision['DocumentAmendmentRecordSheet']['amendment_details'] ?>&nbsp;</dd>
                    <dt><?php echo __('Reason For Change'); ?></dt><dd><?php echo $revision['DocumentAmendmentRecordSheet']['reason_for_change'] ?>&nbsp;</dd>
                    <dt><?php echo __('Prepared By'); ?></dt><dd><?php echo $revision['PreparedBy']['name'] ?>&nbsp;</dd>
                    <dt><?php echo __('Approved By'); ?></dt><dd><?php echo $revision['ApprovedBy']['name'] ?>&nbsp;</dd>
                 </dl>
                </div>
              </div>
            </div>
        </div>
<?php $revision_count++; ?>
<?php endforeach; ?>
</div>
</div>

<?php echo $this->Js->get('#list');?>
<?php if($this->request->params['pass'][1] == 1){
	echo $this->Js->event('click',$this->Js->request(array('controller'=>'dashboards','action' => 'readiness'),array('async' => true, 'update' => '#masterListOfFormats_ajax')));
}else{
	echo $this->Js->event('click',$this->Js->request(array('controller'=>'dashboards','action' => 'mr#tabs'),array('async' => true, 'update' => '#masterListOfFormats_ajax')));
}
?>

<?php echo $this->Js->get('#edit');?>
<?php echo $this->Js->event('click',$this->Js->request(array('action' => 'edit',$masterListOfFormat['MasterListOfFormat']['id'] ,'ajax'),array('async' => true, 'update' => '#masterListOfFormats_ajax')));?>

<?php echo $this->Js->get('#add');?>
<?php echo $this->Js->event('click',$this->Js->request(array('action' => 'lists', null ,'ajax'),array('async' => true, 'update' => '#masterListOfFormats_ajax')));?>

<?php echo $this->Js->writeBuffer();?>

</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>
