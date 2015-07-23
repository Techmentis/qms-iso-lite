<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="masterListOfFormats ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Master List Of Formats', 'modelClass' => 'MasterListOfFormat', 'options' => array("sr_no" => "Sr No", "title" => "Title", "document_number" => "Document Number", "issue_number" => "Issue Number", "revision_number" => "Revision Number", "revision_date" => "Revision Date", "prepared_by" => "Prepared By", "approved_by" => "Approved By", "archived" => "Archived"), 'pluralVar' => 'masterListOfFormats'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Master List Of Format'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="masterListOfFormats_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "document_number" => "Document Number", "issue_number" => "Issue Number", "revision_number" => "Revision Number", "revision_date" => "Revision Date", "prepared_by" => "Prepared By", "approved_by" => "Approved By", "archived" => "Archived"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "document_number" => "Document Number", "issue_number" => "Issue Number", "revision_number" => "Revision Number", "revision_date" => "Revision Date", "prepared_by" => "Prepared By", "approved_by" => "Approved By", "archived" => "Archived"))); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>