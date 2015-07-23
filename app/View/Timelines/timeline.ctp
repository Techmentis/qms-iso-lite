<?php if ($counter && $isAny) { ?>
    <?php echo $this->Html->script(array('jquery.min', 'TimelineJS-master/compiled/js/storyjs-embed')); ?>

    <div id="timeline-embed"></div>
    <script>
        $(document).ready(function() {
            createStoryJS({
                type: 'timeline',
                height: '450',
                source: '../timelines/data_json',
                embed_id: 'timeline-embed',
                debug: true,
                start_at_slide: <?php echo $counter; ?>
            });
        });
    </script>
<?php } else { ?>
    <div class="panel">
        <div class="panel-body">
            <h3 class="text-danger"> No timeline events.</h3>
            <p>Data added on Meetings & Internal Audits will be displayed here after it is published.</p>
            <p>To add internal audit plan <?php echo $this->Html->link('Click Here', array('controller' => 'internal_audit_plans', 'action' => 'lists'), array('class' => 'btn btn-xs btn-info')); ?></p>
            <p>To add MR meeting <?php echo $this->Html->link('Click Here', array('controller' => 'meetings', 'action' => 'lists'), array('class' => 'btn btn-xs btn-info')); ?></p>
        </div>
    </div>
<?php } ?>