<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="competencyMappings ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Competency Mappings', 'modelClass' => 'CompetencyMapping', 'options' => array("sr_no" => "Sr No", "experience_required" => "Experience Required", "skills_required" => "Skills Required", "actual_education" => "Actual Education", "actual_experience" => "Actual Experience", "skills_possesed" => "Skills Possessed", "remarks" => "Remarks"), 'pluralVar' => 'competencyMappings'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Competency Mapping'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->link(__('Add Employee'), array('controller' => 'employees', 'action' => 'add_ajax')); ?> </li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="competencyMappings_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("experience_required" => "Experience Required", "skills_required" => "Skills Required", "actual_education" => "Actual Education", "actual_experience" => "Actual Experience", "skills_possesed" => "Skills Possessed", "remarks" => "Remarks"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "experience_required" => "Experience Required", "skills_required" => "Skills Required", "actual_education" => "Actual Education", "actual_experience" => "Actual Experience", "skills_possesed" => "Skills Possessed", "remarks" => "Remarks"))); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>