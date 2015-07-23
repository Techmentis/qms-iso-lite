<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="documentAmendmentRecordSheets ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Document Amendment Record Sheets', 'modelClass' => 'DocumentAmendmentRecordSheet', 'options' => array("sr_no" => "Sr No", "request_from" => "Request From", "others" => "Others", "master_list_of_format" => "Master List Of Format", "amendment_details" => "Amendment Details", "reason_for_change" => "Reason For Change"), 'pluralVar' => 'documentAmendmentRecordSheets'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Document Amendment Record Sheet'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="documentAmendmentRecordSheets_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "request_from" => "Request From", "others" => "Others", "master_list_of_format" => "Master List Of Format", "amendment_details" => "Amendment Details", "reason_for_change" => "Reason For Change"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "request_from" => "Request From", "others" => "Others", "master_list_of_format" => "Master List Of Format", "amendment_details" => "Amendment Details", "reason_for_change" => "Reason For Change"))); ?>
</div>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>