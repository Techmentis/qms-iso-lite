<div class="messages">
    <table class="table">
        <tr>
            <th><?php echo $this->Paginator->sort('user_id','From'); ?></th>
            <th><?php echo $this->Paginator->sort('subject'); ?></th>
            <th><?php echo $this->Paginator->sort('created','Date'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php foreach ($messages as $message):
                if($message['unread'] > 0) echo "<tr class='unread'>";
                else echo "<tr class='read'>";
        ?>
            <td><?php echo $message['from'][0]['User']['name'] .'-('.$message['from'][0]['Branch']['name'] .' Branch)'; ?></td>
            <td><?php echo $this->Form->postLink(h($message['Message']['subject']), array('action' => 'reply', $message['Message']['id']), null); ?></td>
            <td><?php echo h($message['Message']['created']); ?>&nbsp;</td>
            <td class="actions">&nbsp;
            <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-eye-open"></span>', array('action' => 'reply', $message['Message']['id']), array('escape'=>false)); ?>&nbsp;
            <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span>',array('action' => 'delete', $message['Message']['id']), array('escape'=>false, __('Are you sure you want to move "%s" to trash?', $message['Message']['subject']))); ?>

            <?php
                echo $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span>',
                array('controller'=>'messages', 'action' => 'delete', $message['Message']['id']),
                __('Are you sure you want to move "%s" to trash?', $message['Message']['subject']));
            ?>
            </td>
        <?php endforeach; ?>
    </table>
     <?php
            $this->Paginator->options(array(
             'update' => '#ui-tabs-1',
             'evalScripts' => true,
             'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
             'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
         ));
     ?>
    <p>
        <?php
            echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
            ));
        ?>
    </p>

    <div class="paging">
    <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
    </div>
</div>
 <?php echo $this->Js->writeBuffer(); ?>