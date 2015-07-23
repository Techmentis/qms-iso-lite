<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="appraisals ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Appraisals', 'modelClass' => 'Appraisal', 'options' => array("sr_no" => "Sr No", "Date" => "Date", "appraiser_by" => "Appraiser By", "reason" => "Reason", "self_appraisal_needed" => "Self Appraisal Needed", "self_appraisal_status" => "Self Appraisal Status", "rating" => "Rating", "employee_comments" => "Employee Comments", "appraiser_comments" => "Appraiser Comments", "final_result" => "Final Result", "specific_requirement" => "Specific Requirement", "increament" => "Increament"), 'pluralVar' => 'appraisals'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Appraisal'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="appraisals_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "Date" => "Date", "appraiser_by" => "Appraiser By", "reason" => "Reason", "self_appraisal_needed" => "Self Appraisal Needed", "self_appraisal_status" => "Self Appraisal Status", "rating" => "Rating", "employee_comments" => "Employee Comments", "appraiser_comments" => "Appraiser Comments", "final_result" => "Final Result", "specific_requirement" => "Specific Requirement", "increament" => "Increament"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "Date" => "Date", "appraiser_by" => "Appraiser By", "reason" => "Reason", "self_appraisal_needed" => "Self Appraisal Needed", "self_appraisal_status" => "Self Appraisal Status", "rating" => "Rating", "employee_comments" => "Employee Comments", "appraiser_comments" => "Appraiser Comments", "final_result" => "Final Result", "specific_requirement" => "Specific Requirement", "increament" => "Increament"))); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>