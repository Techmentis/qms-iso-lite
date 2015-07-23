<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="meetings ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Meetings', 'modelClass' => 'Meeting', 'options' => array("sr_no" => "Sr No", "title" => "Title", "previous_meeting_date" => "Previous Meeting", "meeting_details" => "Meeting Details", "header" => "Header", "footer" => "Footer", "employee_by" => "Employee By"), 'pluralVar' => 'meetings'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Meeting'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="meetings_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "previous_meeting_date" => "Previous Meeting", "meeting_details" => "Meeting Details", "header" => "Header", "footer" => "Footer", "employee_by" => "Employee By"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "previous_meeting_date" => "Previous Meeting", "meeting_details" => "Meeting Details", "header" => "Header", "footer" => "Footer", "employee_by" => "Employee By"))); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>