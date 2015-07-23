<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="customerFeedbackQuestions ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Customer Feedback Questions', 'modelClass' => 'CustomerFeedbackQuestion', 'options' => array("sr_no" => "Sr No", "title" => "Title"), 'pluralVar' => 'customerFeedbackQuestions'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Customer Feedback Question'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->link(__('Add Customer Feedback'), array('controller' => 'customer_feedbacks', 'action' => 'add_ajax')); ?> </li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="customerFeedbackQuestions_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("title" => "Title"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title"))); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>