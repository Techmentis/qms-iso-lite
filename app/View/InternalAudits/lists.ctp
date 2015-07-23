<div id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="internalAudits ">
        <h4><?php echo $this->element('breadcrumbs') . 'Internal Audits'; ?></h4>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Internal Audit'), array('action' => 'add_ajax', $this->request->params['pass'][0], 1)); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="internalAudits_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "section" => "Section", "title" => "Title", "start_time" => "Start Time", "end_time" => "End Time", "list_of_trained_internal_auditor" => "List Of Trained Internal Auditor"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "section" => "Section", "title" => "Title", "start_time" => "Start Time", "end_time" => "End Time", "list_of_trained_internal_auditor" => "List Of Trained Internal Auditor"))); ?>
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