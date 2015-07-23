<?php echo $this->Session->flash(); ?>
<div class="row">
    <div class="panel panel-danger">
        <div class="panel-heading"><h3 class="panel-title"><?php echo __("Pending Meeting Actions"); ?>
                <span class="badge btn-danger pull-right"><?php echo count($meeting_actions); ?></span></h3>
        </div>
        <div class="panel-body">
            <table class="table table-condensed">
                <tr>
                    <th><?php echo __("Meeting Topic"); ?></th>
                    <th><?php echo __("Topic Type"); ?></th>
                    <th><?php echo __("Act"); ?></th>
                </tr>
                <?php foreach ($meeting_actions as $meetingTopic): ?>
                    <tr>
                        <td><?php echo $meetingTopic['title']; ?></td>
                        <td><?php echo $meetingTopic['type']; ?></td>
                        <td><?php echo $this->Html->link(__('Act'), array('controller' => $meetingTopic['controller'], 'action' => 'edit', $meetingTopic['action_id']), array('class' => 'badge btn-warning', 'target' => '_blank')) ?></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
</div>