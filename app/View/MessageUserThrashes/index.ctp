<script>
    function openDialog(url) {
        $("#somediv").load(url).dialog({
            width: "80%",
            modal: true
        },
        {position: "top"},
        {buttons: [
                {
                    text: "Close",
                    click: function() {
                        $(this).dialog("close");
                    }
                }]}

        );
    }

</script>

<div class="messageUserThrashes index">

    <table class="table">
        <tr>
            <th><?php echo $this->Paginator->sort('Folder'); ?></th>
            <th><?php echo $this->Paginator->sort('Subject'); ?></th>
            <th><?php echo $this->Paginator->sort('From'); ?></th>
            <th><?php echo $this->Paginator->sort('Trashed'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>

        <?php foreach ($messageUserTrashes as $TrashedMsg): ?>

        <tr>
            <td><?php
                    if ($TrashedMsg['MessageUserThrash']['user_id'] == $TrashedMsg['MessageUserThrash']['created_by']) {
                        echo "Sent";
                    } else {
                        echo "Inbox";
                    }
                ?>
            </td>

            <td><?php echo $this->Html->link($TrashedMsg['Message']['subject'], array('controller' => 'MessageUserThrashes', 'action' => 'view', $TrashedMsg['MessageUserThrash']['message_id'])); ?></td>

            <td>
                <?php
                    if ($TrashedMsg['MessageUserThrash']['user_id'] == $TrashedMsg['MessageUserThrash']['created_by']) {
                        echo "--";
                    } else {
                        echo h($TrashedMsg['User']['name']);
                    }
                ?>
            </td>
            <td><?php echo h($TrashedMsg['MessageUserThrash']['created']); ?></td>
            <td class="actions">
                <?php echo $this->Html->link('View', array('controller' => 'MessageUserThrashes', 'action' => 'view', $TrashedMsg['MessageUserThrash']['message_id'])); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $MessageUserTrash['MessageUserThrash']['message_id']), null); ?>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

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
<div id='somediv'></div>