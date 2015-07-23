<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="listOfSoftwares ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'List Of Softwares', 'modelClass' => 'ListOfSoftware', 'options' => array("sr_no" => "Sr No", "name" => "Name", "software_usage" => "Software Usage", "software_details" => "Software Details", "license_key" => "License Key", "storage_device_number" => "Storage Device Number", "backup_required" => "Backup Required"), 'pluralVar' => 'listOfSoftwares'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Software'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->link(__('New Software Type'), array('controller' => 'software_types', 'action' => 'add_ajax',$this->request->params['controller'])); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="listOfSoftwares_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("name" => "Name", "software_usage" => "Software Usage", "software_details" => "Software Details", "license_key" => "License Key", "storage_device_number" => "Storage Device Number", "backup_required" => "Backup Required"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "name" => "Name", "software_usage" => "Software Usage", "software_details" => "Software Details", "license_key" => "License Key", "storage_device_number" => "Storage Device Number", "backup_required" => "Backup Required"))); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>