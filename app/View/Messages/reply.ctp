<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>
<script>
    $.validator.setDefaults({
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                url: "<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/reply",
                type: 'POST',
                target: '#messages_ajax',
                beforeSend: function(){
                    $("#submit_id").prop("disabled",true);
                    $("#submit-indicator").show();
                },
                complete: function() {
                   $("#submit_id").removeAttr("disabled");
                   $("#submit-indicator").hide();
                },
                error: function(request, status, error) {
                    //alert(request.responseText);
                    alert('Action failed!');
                }
            });
        }
    });
    $(".chosen-select").chosen();
    $().ready(function() {
        $('#MessageReplyForm').validate();
    });
</script>
<div class="messages_reply">
    <div class="index reply">
        <div class="msg-box">
            <div class="msg-details">
                <h2 class="msg-hdr"><?php echo $messageThread[0]['Message']['subject']; ?></h2>

                <?php
                    foreach ($messageThread as $message)
                        ;
                    echo "<dl>";
                    echo "<dt>From</dt><dd>" . $message['User']['name'] . "</dd>";
                    echo "<dt>Subject</dt><dd>" . $message['Message']['subject'] . "</dd>";
                    echo "<dt>Date</dt><dd>" . $message['Message']['created'] . "</dd>";
                    echo "</dl>";
                ?>

                <?php
                    echo "<div class=\"msg-body\">" . $message['Message']['message'] . "</div>";
                ?>
            </div>

            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $message['Message']['id']), array('class' => 'btn btn-primary btn-danger', 'style' => 'margin-left:10px;'), __('Are you sure you want to move "%s" to trash?', $message['Message']['subject'])); ?>
            <?php
                echo $this->HTML->link(__('Cancel'), array('controller' => 'Messages', 'action' => 'index'), array('class' => 'btn', 'style' => 'margin-top:12px;'));
            ?>
        </div>

    </div>
    <?php
        foreach ($message['MessageUserInbox'] as $moreuser) {
            if ($this->Session->read('User.id') == $moreuser['user_id']) {
                $selected[] = $message['User']['id'];
            } else {
                $selected[] = $moreuser['user_id'];
            }
        }
    ?>
    <div style="border-bottom:1px solid #CCCCCC;margin-top:10px;"></div>
    <?php echo $this->Form->create(__('Message'), array('class' => 'form', 'width' => '100%', 'role' => 'form', 'default' => false)); ?>
    <table class="message_reply_table" width="99%">
        <tr><td>
                <h2><?php echo __('Send Reply'); ?></h2>
                <?php
                    echo $this->Form->input('Message.to', array('name' => 'Message.to[]', 'type' => 'select', 'class' => 'chzn-select', 'multiple', 'options' => $users, 'label' => __('Recepient'), 'style' => 'width:100%', 'default' => $selected));
                    echo $this->Form->input('subject', array('value' => 'Re.' . $message['Message']['subject'], 'class' => __('subject'), 'div' => false, 'label' => 'Subject'));
                    echo $this->Form->input('message', array('type' => 'textarea', 'escape' => false, 'class' => 'textEdit', 'div' => false, 'label' => __('Message'), 'id' => 'message', 'style' => ''));
                    echo $this->Form->hidden('user_id', array('value' => $this->Session->read('User.id')));
                    echo $this->Form->hidden('trackingid', array('value' => $message['Message']['trackingid']));
                    echo $this->Form->hidden('flag', array('value' => '0'));
                    echo $this->Form->hidden('priority', array('Label' => 'Priority'), array('options' => array('High', 'Low')));
                ?>
                <?php echo $this->Form->submit(__('Send'), array('div' => false, 'class' => 'btn btn-primary btn-success','style'=>'margin-top:12px', 'update' => '#messages_ajax', 'async' => 'false','id'=>'submit_id')); ?>&nbsp
                <?php
                    echo $this->HTML->link(__('Cancel'), array('controller' => 'Messages', 'action' => 'index'), array('class' => 'btn','style'=>'margin-top:12px'));
                ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            </td>
        </tr>
    </table>

    <?php
        echo $this->Form->end();
        echo $this->Js->writeBuffer();
    ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>