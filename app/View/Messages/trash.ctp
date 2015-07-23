<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>
<?php echo $this->element('actions_message'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('table th a, .pag_list li span a').on('click', function() {
            var url = $(this).attr("href");
            $('#main_messages_trash').load(url);
            return false;
        });
    });
</script>
<div id ="main_messages_trash">
<div class="messages_trash" id="messages_trash_ajax">
    <?php echo $this->Form->create('messages', array('class' => 'no-padding no-margin no-background')); ?>
    <table class="table table-bordered table table-striped table-hover">
        <tr>
            <td>
                <input type="checkbox" id="selectAll" onclick='messages_trash_action(this);'>
            </td>
            <td>
                <div class="btn-group">
                    <button type="button" data-toggle="dropdown" class="dropdown-toggle btn  btn-sm btn-default "><span class=" glyphicon glyphicon-wrench"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li> <?php echo $this->Html->link(__('Delete All'), '#deleteAllTrash', array('data-toggle' => 'modal', 'onClick' => 'getVals()')); ?></li>
                    </ul>
                </div>
            </td>
            <th><?php echo $this->Paginator->sort('Folder'); ?></th>
            <th><?php echo $this->Paginator->sort('Subject'); ?></th>
            <th><?php echo $this->Paginator->sort('From'); ?></th>
            <th><?php echo $this->Paginator->sort('To'); ?></th>
            <th><?php echo $this->Paginator->sort('Trashed'); ?></th>
        </tr>

        <?php
            $x =0;
            foreach ($messageUserTrashes as $TrashedMsg):
        ?>

            <tr>
                <td width="15"><?php echo $this->Form->checkbox('rec_ids_' . $x, array('label' => false, 'value' => $TrashedMsg['MessageUserThrash']['id'], 'multiple' => 'checkbox', 'class' => 'rec_ids', 'onClick' => 'getVals()')); ?></td>
                <td class=" actions">
                    <div class="btn-group">
                        <button type="button" data-toggle="dropdown" class="dropdown-toggle btn  btn-sm btn-default "><span class=" glyphicon glyphicon-wrench"></span></button>

                        <ul class="dropdown-menu" role="menu">
                            <li><?php echo $this->Js->link(__('View'), array('controller' => 'MessageUserThrashes', 'action' => 'view', $TrashedMsg['MessageUserThrash']['message_id']), array('update' => '#messages_trash_ajax', 'escape' => false)); ?></li>
                            <li class="divider"></li>
                             <li><?php echo $this->Form->postLink(__('Delete'), array('controller' => 'MessageUserThrashes', 'action' => 'delete', $TrashedMsg['MessageUserThrash']['Message']['trackingid']), array('style' => 'display:none'), __('Are you sure you want to delete this record ?', $postVal)); ?></li>

                            <li><?php echo $this->Form->postLink(__('Delete'), array('controller' => 'MessageUserThrashes', 'action' => 'delete', $TrashedMsg['MessageUserThrash']['id']), array('escape' => false)); ?></li>
                        </ul>
                    </div>
                </td>
                <td><?php
                    if ($TrashedMsg['SystemTable']['system_name'] == 'messages') {
                        $folder = "Inbox";
                        echo $folder;
                    } else {
                        $folder = "Sent";
                        echo $folder;
                    }
                    ?></td>

                <td><?php echo $this->Html->link($TrashedMsg['Message']['subject'], array('controller' => 'MessageUserThrashes', 'action' => 'view', $TrashedMsg['MessageUserThrash']['message_id'])); ?></td>

                <td><?php
                if ($folder == "Sent") {
                    echo '<centre>'."--".'</centre>';
                } else {
                    echo h($TrashedMsg['User']['name']);
                }
                    ?>
                </td>

                <td><?php
                if ($folder == "Inbox") {
                    echo '<centre>'."--".'</centre>';
                } else {
                    echo h($TrashedMsg['User']['name']);
                }
                    ?>
                </td>

                <td><?php echo date('D-d M Y / h:i A', strtotime(h($TrashedMsg['MessageUserThrash']['created']))); ?></td>

            </tr>

    <?php
        $x++;
        endforeach;
    ?>

    </table>
    <?php echo $this->Form->end(); ?>
    <p>
    <?php
        echo $this->Paginator->options(array(
            'update' => '#main_messages_trash',
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
<div class="modal fade" id="deleteAllTrash" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <?php echo $this->Form->create('MessageUserThrashes', array('controller' => 'MessageUserThrashes', 'action' => 'delete_all', 'role' => 'form', 'class' => 'form', 'style' => 'clear:both;overflow:auto')); ?>
            <?php echo $this->Form->hidden('recs_selected_trash', array('id' => 'recs_selected_trash_for_delete')); ?>
            <?php echo $this->Form->hidden('deleteAllTrash.model_name', array('value' => 'MessageUserThrash')); ?>
            <?php echo $this->Form->hidden('deleteAllTrash.controller_name', array('value' => 'MessageUserThrashes')); ?>
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