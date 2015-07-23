<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="proposals ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Proposals', 'modelClass' => 'Proposal', 'options' => array("sr_no" => "Sr No", "title" => "Title", "proposal_heading" => "Proposal Heading", "proposal_details" => "Proposal Details"), 'pluralVar' => 'proposals'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Proposal'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="proposals_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "proposal_heading" => "Proposal Heading", "proposal_details" => "Proposal Details"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "proposal_heading" => "Proposal Heading", "proposal_details" => "Proposal Details"))); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>