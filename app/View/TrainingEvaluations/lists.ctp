<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="trainingEvaluations ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Training Evaluations', 'modelClass' => 'TrainingEvaluation', 'options' => array("sr_no" => "Sr No", "purpose_of_training" => "Purpose Of Training", "is_it_fulfilled" => "Is It Fulfilled", "informative" => "Informative", "improvement" => "Improvement", "content" => "Content", "elaboration" => "Elaboration", "comments" => "Comments"), 'pluralVar' => 'trainingEvaluations'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Training Evaluation'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="trainingEvaluations_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "purpose_of_training" => "Purpose Of Training", "is_it_fulfilled" => "Is It Fulfilled", "informative" => "Informative", "improvement" => "Improvement", "content" => "Content", "elaboration" => "Elaboration", "comments" => "Comments"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "purpose_of_training" => "Purpose Of Training", "is_it_fulfilled" => "Is It Fulfilled", "informative" => "Informative", "improvement" => "Improvement", "content" => "Content", "elaboration" => "Elaboration", "comments" => "Comments"))); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>