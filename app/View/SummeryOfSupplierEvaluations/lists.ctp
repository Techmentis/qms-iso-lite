
<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="summeryOfSupplierEvaluations ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Summery Of Supplier Evaluations', 'modelClass' => 'SummeryOfSupplierEvaluation', 'options' => array("sr_no" => "Sr No", "remarks" => "Remarks", "evaluation_date" => "Evaluation Date"), 'pluralVar' => 'summeryOfSupplierEvaluations'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Summary Of Supplier Evaluation'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="summeryOfSupplierEvaluations_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("remarks" => "Remarks", "evaluation_date" => "Evaluation Date"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "remarks" => "Remarks", "evaluation_date" => "Evaluation Date"))); ?>
</div>

<script>
    $.ajaxSetup({
        beforeSend: function () {
            $("#busy-indicator").show();
        },
        complete: function () {
            $("#busy-indicator").hide();
        }
    });
</script>