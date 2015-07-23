

</script><div class="messageUserSents index">
	<h2><?php echo __('Message User Sents'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>			
		<th><?php echo $this->Paginator->sort('id'); ?></th>			
		<th><?php echo $this->Paginator->sort('message_id'); ?></th>	
		<th><?php echo $this->Paginator->sort('trackingid'); ?></th>	
		<th><?php echo $this->Paginator->sort('user_id'); ?></th>			
		<th><?php echo $this->Paginator->sort('status'); ?></th>			
		<th><?php echo $this->Paginator->sort('created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($messageUserSents as $messageUserSent): ?>
	<tr>

		<td><?php echo h($messageUserSent['MessageUserSent']['id']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($messageUserSent['Message']['id'], array()); ?></td>
		<td><?php echo h($messageUserSent['MessageUserSent']['trackingid']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($messageUserSent['User']['name'], array()); ?></td>
		<td><?php echo h($messageUserSent['MessageUserSent']['status']); ?>&nbsp;</td>
		<td><?php echo h($messageUserSent['MessageUserSent']['created']); ?>&nbsp;</td>
		<td class="actions" style="width:120px">
			<?php if($showView) echo $this->Html->link($this->Html->image('../img/icons/view.png',array('onclick'=>'openDialog(\''.$ScriptUrl.'/view/'.$messageUserSent['MessageUserSent']['id'].'\');','class'=>'showtooltip','alt' => __('View'.$messageUserSent['MessageUserSent']['name']),'title'=>__('View '.$messageUserSent['MessageUserSent']['name'])), array('alt' => __('View'),'title'=>__('View'))), '#',array('escape' => false)); ?>
			<?php if($showEdit) echo $this->Html->link($this->Html->image('../img/icons/edit.png', array('class'=>'showtooltip','alt' => __('Edit'),'title'=>__('Edit '.$messageUserSent['MessageUserSent']['name']))), array('action' => 'edit', $messageUserSent['MessageUserSent']['id']),array('escape' => false)); ?>
			<?php if($showDelete) echo $this->Form->postLink($this->Html->image('../img/icons/delete.png', array('class'=>'showtooltip','alt' => __('Delete '.$messageUserSent['MessageUserSent']['name']),'title'=>__('Delete '.$messageUserSent['MessageUserSent']['name']))), array('action' => 'delete', $messageUserSent['MessageUserSent']['id']), array('escape' => false,'confirm'=> __('Are you sure you want to delete # %s?', $messageUserSent['MessageUserSent']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div id='somediv'></div>