<div class="nav panel panel-default">
    <div class="index reply">
        <div class="messageUserSents view">
            <div class="msg-box">
                <div class="msg-details">
                    <h2 class="msg-hdr"><?php echo h($MessageUserTrash['Message']['subject']); ?></h2>
                    <?php
                        echo "<dl>";
                        echo "<dt>From</dt><dd>" . h($MessageUserTrash['User']['name']) . "</dd>";
                        echo "<dt>Subject</dt><dd>" . h($MessageUserTrash['Message']['subject']) . "</dd>";
                        echo "<dt>Date</dt><dd>" . h($MessageUserTrash['Message']['created']) . "</dd>";
                        echo "</dl>";
                        echo "<div class=\"msg-body\">" . h($MessageUserTrash['Message']['message']) . "</div>";
                    ?>
                </div>
                <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'MessageUserThrashes', 'action' => 'delete', $MessageUserTrash['MessageUserThrash']['id']), array('class' => 'btn btn-primary btn-danger', 'style' => 'margin-left:10px;'), __('Are you sure you want to delete : %s?', $MessageUserTrash['Message']['subject'])); ?>
            </div>
        </div>
    </div>
</div>