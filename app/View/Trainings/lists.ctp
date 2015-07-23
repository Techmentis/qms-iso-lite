<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="trainings ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Trainings', 'modelClass' => 'Training', 'options' => array("sr_no" => "Sr No", "title" => "Title", "description" => "Description", "start_date_time" => "Start Date Time", "end_date_time" => "End Date Time"), 'pluralVar' => 'trainings'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Training'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->link(__('New Course Types'), array('controller' => 'course_types', 'action' => 'add_ajax',$this->request->params['controller'])); ?></li>
                    <li><?php echo $this->Html->link(__('New Course'), array('controller' => 'courses', 'action' => 'add_ajax',$this->request->params['controller'])); ?></li>
                    <li><?php echo $this->Html->link(__('New Trainer Types'), array('controller' => 'trainer_types', 'action' => 'add_ajax',$this->request->params['controller'])); ?></li>
                    <li><?php echo $this->Html->link(__('New Training Type'), array('controller' => 'training_types', 'action' => 'add_ajax',$this->request->params['controller'])); ?></li>
                    <li><?php echo $this->Html->link(__('New Trainers'), array('controller' => 'trainers', 'action' => 'add_ajax',$this->request->params['controller'])); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="trainings_tab_ajax"></div>
    </div>

<script>
    $(function() {
        $("#tabs").tabs({
            beforeLoad: function(event, ui) {
                ui.jqXHR.error(function() {
                    ui.panel.html(
                            "Error Loading ... " +
                            "Please contact administrator.");
                });
            }
        });
    });
</script>

    <?php echo $this->element('export'); ?>
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "description" => "Description", "start_date_time" => "Start Date Time", "end_date_time" => "End Date Time"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "description" => "Description", "start_date_time" => "Start Date Time", "end_date_time" => "End Date Time"))); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>