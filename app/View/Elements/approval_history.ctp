<div class="panel panel-warning">
    <div class="panel-heading"><h4 class="panel-title">&nbsp;&nbsp;&nbsp;<?php echo __('Approval History'); ?></h4></div>
    <div class="panel panel-body">
        <table class="table">
            <tr><th><?php echo __('Date'); ?></th><th><?php echo __('From'); ?></th><th><?php echo __('Comments'); ?></th><th><?php echo __('Sent to'); ?></th></tr>
            <?php foreach ($approvalHistory['history'] as $history): ?>
                <tr>
                    <td><?php echo $this->Time->nice($history['Approval']['created']) ?></td>
                    <td><?php echo $history['From']['name'] ?></td>
                    <td><?php echo $history['Approval']['comments'] ?></td>
                    <td><?php echo $history['User']['name'] ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4">
                    <?php
                        if ($this->data[$model_name]['publish'] == 1)
                            echo "Published";
                        else
                            echo "Not published";
                    ?>
                </td>
            </tr>
        </table>
    </div>
</div>
