<div class="messages view">
<h2><?php  echo __('Message'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($message['Message']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trackingid'); ?></dt>
		<dd>
			<?php echo h($message['Message']['trackingid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Subject'); ?></dt>
		<dd>
			<?php echo h($message['Message']['subject']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Message'); ?></dt>
		<dd>
			<?php echo h($message['Message']['message']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($message['User']['name'], array('controller' => 'users', 'action' => 'view', $message['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Flag'); ?></dt>
		<dd>
			<?php echo h($message['Message']['flag']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($message['Message']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Priority'); ?></dt>
		<dd>
			<?php echo h($message['Message']['priority']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Message'), array('action' => 'edit', $message['Message']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Message'), array('action' => 'delete', $message['Message']['id']), null, __('Are you sure you want to delete # %s?', $message['Message']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Messages'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Message'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Message User Inboxes'), array('controller' => 'message_user_inboxes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Message User Inbox'), array('controller' => 'message_user_inboxes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Message User Sents'), array('controller' => 'message_user_sents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Message User Sent'), array('controller' => 'message_user_sents', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Message User Thrashes'), array('controller' => 'message_user_thrashes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Message User Thrash'), array('controller' => 'message_user_thrashes', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Message User Inboxes'); ?></h3>
	<?php if (!empty($message['MessageUserInbox'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Message Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($message['MessageUserInbox'] as $messageUserInbox): ?>
		<tr>
			<td><?php echo $messageUserInbox['id']; ?></td>
			<td><?php echo $messageUserInbox['message_id']; ?></td>
			<td><?php echo $messageUserInbox['user_id']; ?></td>
			<td><?php echo $messageUserInbox['status']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'message_user_inboxes', 'action' => 'view', $messageUserInbox['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'message_user_inboxes', 'action' => 'edit', $messageUserInbox['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'message_user_inboxes', 'action' => 'delete', $messageUserInbox['id']), null, __('Are you sure you want to delete # %s?', $messageUserInbox['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Message User Inbox'), array('controller' => 'message_user_inboxes', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Message User Sents'); ?></h3>
	<?php if (!empty($message['MessageUserSent'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Message Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($message['MessageUserSent'] as $messageUserSent): ?>
		<tr>
			<td><?php echo $messageUserSent['id']; ?></td>
			<td><?php echo $messageUserSent['message_id']; ?></td>
			<td><?php echo $messageUserSent['user_id']; ?></td>
			<td><?php echo $messageUserSent['status']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'message_user_sents', 'action' => 'view', $messageUserSent['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'message_user_sents', 'action' => 'edit', $messageUserSent['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'message_user_sents', 'action' => 'delete', $messageUserSent['id']), null, __('Are you sure you want move "%s" to Trash?', $messageUserSent['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Message User Sent'), array('controller' => 'message_user_sents', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Message User Thrashes'); ?></h3>
	<?php if (!empty($message['MessageUserThrash'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Message Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($message['MessageUserThrash'] as $messageUserThrash): ?>
		<tr>
			<td><?php echo $messageUserThrash['id']; ?></td>
			<td><?php echo $messageUserThrash['message_id']; ?></td>
			<td><?php echo $messageUserThrash['user_id']; ?></td>
			<td><?php echo $messageUserThrash['status']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'message_user_thrashes', 'action' => 'view', $messageUserThrash['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'message_user_thrashes', 'action' => 'edit', $messageUserThrash['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'message_user_thrashes', 'action' => 'delete', $messageUserThrash['id']), null, __('Are you sure you want to delete # %s?', $messageUserThrash['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Message User Thrash'), array('controller' => 'message_user_thrashes', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
