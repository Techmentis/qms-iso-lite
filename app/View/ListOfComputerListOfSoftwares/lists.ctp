<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="listOfComputerListOfSoftwares ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'List Of Computer Softwares', 'modelClass' => 'ListOfComputerListOfSoftware', 'options' => array("sr_no" => "Sr No", "installation_date" => "Installation Date", "other_details" => "Other Details"), 'pluralVar' => 'listOfComputerListOfSoftwares'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Computer Software'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="listOfComputerListOfSoftwares_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "installation_date" => "Installation Date", "other_details" => "Other Details"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "installation_date" => "Installation Date", "other_details" => "Other Details"))); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>