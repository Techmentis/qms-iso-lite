<div id="messages_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav">
        <div class="users form col-md-12">

<script>
    $(function() {
        $("#message_tabs").tabs({spinner: "Retrieving data..."}, {fx: {opacity: 'toggle'}}, {
            ajaxOptions: {
                error: function(xhr, status, index, anchor) {
                    $(anchor.hash).html(
                            "loading .. ");
                }
            }
        });
    });
</script>

            <div id="message_tabs">
                <ul>
                    <li><?php echo $this->Html->Link('Inbox (' . $unread . ' Unread Messages)', array('controller' => 'messages', 'action' => 'inbox'), array('span' => 'Retriving Data')); ?></li>
                    <li><?php echo $this->Html->Link('Sent', array('controller' => 'messages', 'action' => 'sent'), array('span' => 'Retriving Data')); ?></li>
                    <li><?php echo $this->Html->Link('Compose', array('controller' => 'messages', 'action' => 'add'), array('span' => 'Retriving Data')); ?></li>
                    <li><?php echo $this->Html->Link('Trash', array('controller' => 'messages', 'action' => 'trash'), array('span' => 'Retriving Data')); ?></li>
                </ul>
            </div>

        </div>
    </div>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>