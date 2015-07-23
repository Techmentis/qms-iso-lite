<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="SuggestionForms ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Suggestion Forms', 'modelClass' => 'SuggestionForm', 'options' => array("sr_no" => "Sr No", "activity" => "Activity", "suggestion" => "Suggestion", "remark" => "Remark"), 'pluralVar' => 'SuggestionForms'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Suggestion Form'), array('action' => 'add_ajax')); ?></li>
                </ul>
            </div>
        </div>
        <div id="SuggestionForms_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("activity" => "Activity", "suggestion" => "Suggestion", "remark" => "Remark"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "activity" => "Activity", "suggestion" => "Suggestion", "remark" => "Remark"))); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>