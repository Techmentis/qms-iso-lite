<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>
<?php echo $this->element('actions_message'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('table th a, .pag_list li span a').on('click', function() {
            var url = $(this).attr("href");
            $('#main_messages_inbox').load(url);
            return false;
        });
    });
</script>
<div id ="main_messages_inbox">
<div class="messages_inbox" id="messages_inbox_ajax">
    <?php echo $this->Form->create('messages', array('class' => 'no-padding no-margin no-background')); ?>
    <table class="table table-bordered table table-striped table-hover">
        <tr>
            <td >
                <input type="checkbox" id="selectAll" onclick='messages_inbox_action(this);'></td>
            <td>
        <div class="btn-group">
            <button type="button" data-toggle="dropdown" class="dropdown-toggle btn  btn-sm btn-default "><span class=" glyphicon glyphicon-wrench"></span></button>
            <ul class="dropdown-menu" role="menu">
                <li><?php echo $this->HTML->link(__('Move To Trash'), '#deleteAllInbox', array('data-toggle' => 'modal', 'onClick' => 'getVals()')); ?></li>
            </ul>
        </div>
        </td>
        <th><?php echo $this->Paginator->sort('created', 'Date'); ?></th>
        <th><?php echo $this->Paginator->sort('subject'); ?></th>
        <th><?php echo $this->Paginator->sort('user_id', 'From'); ?></th>
        </tr>

        <?php
            $x = 0;
            foreach ($messages as $message):
                if ($message['unread'] > 0)
                    echo "<tr class='unread'>";
                else
                    echo "<tr class='read'>";
        ?>
        <td width="15"><?php echo $this->Form->checkbox('rec_ids_' . $x, array('label' => false, 'value' => $message['Message']['id'], 'multiple' => 'checkbox', 'class' => 'rec_ids', 'onClick' => 'getVals()')); ?></td>
            <td class="actions">
                <div class="btn-group">
                    <button type="button" data-toggle="dropdown" class="dropdown-toggle btn  btn-sm btn-default "><span class=" glyphicon glyphicon-wrench"></span></button>

                    <ul class="dropdown-menu" role="menu">
                        <li><?php echo $this->Js->link(__('View'), array('action' => 'reply', $message['Message']['id']), array('update' => '#messages_inbox_ajax', 'escape' => false)); ?></li>
                        <li><?php echo $this->Form->postLink(__('Delete'), array('controller' => 'Messages', 'action' => 'delete', $message['Message']['trackingid']), array('style' => 'display:none'), __('Are you sure you want to delete this record ?', $postVal)); ?></li>

                        <li class="divider"></li>
                        <li><?php echo $this->Form->postLink(__('Move To Trash'), array('controller' => 'Messages', 'action' => 'delete', $message['Message']['trackingid']), array('class' => ''), __('Are you sure ?', $postVal)); ?></li>
                    </ul>
                </div>
            </td>
            <td><?php echo date('D-d M Y / h:i A', strtotime(h($message['MessageUserInbox']['created']))); ?></td>
            <td><?php echo $this->Js->link(h($message['Message']['subject']), array('action' => 'reply', $message['Message']['id']), array('update' => '#messages_inbox_ajax', 'escape' => false)); ?></td>
            <td><?php echo $message['from'][0]['User']['name'] . '-(' . $message['from'][0]['Branch']['name'] . ' Branch)'; ?></td>
        </tr>
        <?php
            $x++;
            endforeach;
        ?>
    </table>
    <?php echo $this->Form->end(); ?>
    <?php
        $this->Paginator->options(array(
            'update' => '#ui-tabs-1',
            'evalScripts' => true,
            'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
            'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
        ));
    ?>

    <p><?php
            echo $this->Paginator->options(array(
                'update' => '#main_messages_inbox',
                'evalScripts' => true,
                'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
                'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
            ));

            echo $this->Paginator->counter(array(
                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
            ));
        ?>
    </p>
    <ul class="pagination">
        <?php
            echo "<li class='previous'>" . $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')) . "</li>";
            echo "<li>" . $this->Paginator->numbers(array('separator' => '')) . "</li>";
            echo "<li class='next'>" . $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')) . "</li>";
        ?>
    </ul>
</div>

<div class="modal fade" id="deleteAllInbox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <?php echo $this->Form->create('Messages', array('controller' => 'Messages', 'action' => 'delete_all', 'role' => 'form', 'class' => 'form', 'style' => 'clear:both;overflow:auto')); ?>
            <?php echo $this->Form->hidden('recs_selected_inbox', array('id' => 'recs_selected_inbox_for_delete')); ?>
            <?php echo $this->Form->hidden('deleteAllInbox.model_name', array('value' => 'Message')); ?>
            <?php echo $this->Form->hidden('deleteAllInbox.controller_name', array('value' => 'Messages')); ?>
            <h4 class="modal-title">Are you sure to delete all selected <?php echo $this->name; ?> ?</h4>
            <?php echo $this->Form->submit('Yes', array('class' => 'btn btn-success', 'style' => 'padding:8px;')); ?>
            <?php echo $this->Form->button('No', array('class' => 'btn btn-warning', 'data-dismiss' => "modal", 'style' => 'margin-top:10px;margin-left:5px;')); ?>
            <?php echo $this->Form->end(); ?>

        </div>
    </div>
</div>
<?php echo $this->element('common'); ?>
<?php echo $this->Js->writeBuffer(); ?>
</div>