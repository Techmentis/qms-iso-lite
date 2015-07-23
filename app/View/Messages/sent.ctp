<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>
<?php echo $this->element('actions_message'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('table th a, .pag_list li span a').on('click', function() {
            var url = $(this).attr("href");
            $('#main_messages_sent').load(url);
            return false;
        });
    });
</script>
<div id ="main_messages_sent">
<div class="messages_sent" id="messages_sent_ajax">
    <?php echo $this->Form->create('messages', array('class' => 'no-padding no-margin no-background')); ?>
    <table class="table table-bordered table table-striped table-hover">
        <tr>
            <td><input type="checkbox" id="selectAll" onclick='messages_sent_action(this);'></td>
            <td>
                <div class="btn-group">
                    <button type="button" data-toggle="dropdown" class="dropdown-toggle btn  btn-sm btn-default "><span class=" glyphicon glyphicon-wrench"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li>  <?php echo $this->Html->link(__('Move To Trash'), '#deleteAllSent', array('data-toggle' => 'modal', 'onClick' => 'getVals()')); ?>
                        </li>
                    </ul>
                </div>
            </td>
        <th><?php echo $this->Paginator->sort('to', 'To'); ?></th>
        <th><?php echo $this->Paginator->sort('subject'); ?></th>
        <th><?php echo $this->Paginator->sort('created', 'Date'); ?></th>

        </tr>
        <?php
            $x = 0;
            foreach ($messages as $message):
        ?>

            <tr>
                <td width="15"><?php echo $this->Form->checkbox('rec_ids_' . $x, array('label' => false, 'value' => $message['messageData']['Message']['id'], 'multiple' => 'checkbox', 'class' => 'rec_ids', 'onClick' => 'getVals()')); ?></td>
                <td class=" actions">
                    <div class="btn-group">
                        <button type="button" data-toggle="dropdown" class="dropdown-toggle btn  btn-sm btn-default "><span class=" glyphicon glyphicon-wrench"></span></button>

                        <ul class="dropdown-menu" role="menu">
                            <li><?php echo $this->Js->link(__('View'), array('controller' => 'MessageUserSents', 'action' => 'view', $message['messageData']['Message']['id']), array('update' => '#messages_sent_ajax', 'escape' => false)); ?></li>
                            <li><?php echo $this->Form->postLink(__('Delete'), array('controller' => 'MessageUserSents', 'action' => 'delete', $message['messageData']['Message']['trackingid']), array('style' => 'display:none'), __('Are you sure you want to delete this record ?')); ?></li>

                            <li class="divider"></li>
                            <li><?php echo $this->Form->postLink(__('Move To Trash'), array('controller' => 'MessageUserSents', 'action' => 'delete', $message['messageData']['Message']['trackingid']), array('class' => ''), __('Are you sure ?')); ?></li>
                        </ul>
                    </div>
                </td>
                <td><?php echo __(implode(", ", $message['username'])); ?></td>

                <td><?php echo $this->Js->link(h($message['messageData']['Message']['subject']), array('controller' => 'MessageUserSents', 'action' => 'view', $message['messageData']['Message']['id'])); ?></td>

                <td><?php echo date('D-d M Y / h:i A', strtotime($message['messageData']['MessageUserSent']['created'])); ?></td>
            </tr>
        <?php
            $x++;
            endforeach;
        ?>
    </table>
    <?php echo $this->Form->end(); ?>
    <?php
        $this->Paginator->options(array(
            'update' => '#ui-tabs-2',
            'evalScripts' => true,
            'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
            'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
        ));
    ?>
    <p>
        <?php
            echo $this->Paginator->options(array(
                'update' => '#main_messages_sent',
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
<div class="modal fade" id="deleteAllSent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <?php echo $this->Form->create('MessageUserSents', array('controller' => 'MessageUserSents', 'action' => 'delete_all', 'role' => 'form', 'class' => 'form', 'style' => 'clear:both;overflow:auto')); ?>
            <?php echo $this->Form->hidden('recs_selected_sent', array('id' => 'recs_selected_sent_for_delete')); ?>
            <?php echo $this->Form->hidden('deleteAll.model_name', array('value' => 'MessageUserSent')); ?>
            <?php echo $this->Form->hidden('deleteAll.controller_name', array('value' => 'MessageUserSents')); ?>
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