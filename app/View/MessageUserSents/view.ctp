<div id="messages_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="index reply">
            <div class="messageUserSents view">
                <div class="msg-box">
                    <div class="msg-details">
                        <h2 class="msg-hdr"><?php echo h($messageUserSent['Message']['subject']); ?></h2>
                        <?php
                            echo "<dl>";
                            echo "<dt>To</dt><dd>" . h($messageUserSent['User']['name']) . "</dd>";
                            echo "<dt>Subject</dt><dd>" . h($messageUserSent['Message']['subject']) . "</dd>";
                            echo "<dt>Date</dt><dd>" . h($messageUserSent['MessageUserSent']['created']) . "</dd>";
                            echo "</dl>";
                            echo "<div class=\"msg-body\">" . h($messageUserSent['Message']['message']) . "</div>";
                        ?>
                    </div>
                    <?php echo $this->Form->postLink(__('Trash'), array('controller' => 'MessageUserSents', 'action' => 'delete', $messageUserSent['MessageUserSent']['message_id']), array('class' => 'btn btn-primary btn-danger', 'style' => 'margin-left:10px;'), __('Are you sure you want to move "%s" to trash?', $messageUserSent['Message']['subject'])); ?>
                </div>
            </div>
        </div>
    </div>
</div>