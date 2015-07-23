<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="courses ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Courses', 'modelClass' => 'Course', 'options' => array("sr_no" => "Sr No", "title" => "Title", "description" => "Description"), 'pluralVar' => 'courses'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Course'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->link(__('New Course Types'), array('controller' => 'course_types', 'action' => 'add_ajax',$this->request->params['controller'])); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="courses_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("title" => "Title", "description" => "Description"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "description" => "Description"))); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>