<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="proposalFollowups ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Proposal Followups', 'modelClass' => 'ProposalFollowup', 'options' => array("sr_no" => "Sr No", "followup_heading" => "Followup Heading", "followup_details" => "Followup Details", "next_follow_up_date" => "Next Follow Up Date", "status" => "Status"), 'pluralVar' => 'proposalFollowups'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Proposal Followup'), array('action' => 'add_ajax', $id)); ?></li>

                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="proposalFollowups_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "followup_heading" => "Followup Heading", "followup_details" => "Followup Details", "next_follow_up_date" => "Next Follow Up Date", "status" => "Status"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "followup_heading" => "Followup Heading", "followup_details" => "Followup Details", "next_follow_up_date" => "Next Follow Up Date", "status" => "Status"))); ?>
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