<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="customerFeedbacks ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Customer Feedbacks', 'modelClass' => 'CustomerFeedback', 'options' => array("sr_no" => "Sr No", "answer" => "Answer", "comments" => "Comments"), 'pluralVar' => 'customerFeedbacks'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Customer Feedback'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->link(__('Add Customer'), array('controller' => 'customers', 'action' => 'add_ajax')); ?> </li>
                    <li><?php echo $this->Html->link(__('Add Customer Feedback Question'), array('controller' => 'customer_feedback_questions', 'action' => 'add_ajax')); ?> </li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="customerFeedbacks_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "answer" => "Answer", "comments" => "Comments"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "answer" => "Answer", "comments" => "Comments"))); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});
</script>