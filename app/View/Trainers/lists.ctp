<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="trainers ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Trainers', 'modelClass' => 'Trainer', 'options' => array("sr_no" => "Sr No", "trainer_type" => "Trainer Type", "name" => "Name", "company" => "Company", "designation" => "Designation", "qualification" => "Qualification", "personal_telephone" => "Personal Telephone", "office_telephone" => "Office Telephone", "mobile" => "Mobile", "personal_email" => "Personal Email", "office_email" => "Office Email"), 'pluralVar' => 'trainers'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Trainer'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->link(__('New Trainer Type'), array('controller' => 'trainer_types', 'action' => 'add_ajax',$this->request->params['controller'])); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="trainers_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("trainer_type_id" => "Trainer Type", "name" => "Name", "company" => "Company", "designation" => "Designation", "qualification" => "Qualification", "personal_telephone" => "Personal Telephone", "office_telephone" => "Office Telephone", "mobile" => "Mobile", "personal_email" => "Personal Email", "office_email" => "Office Email"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "trainer_type" => "Trainer Type", "name" => "Name", "company" => "Company", "designation" => "Designation", "qualification" => "Qualification", "personal_telephone" => "Personal Telephone", "office_telephone" => "Office Telephone", "mobile" => "Mobile", "personal_email" => "Personal Email", "office_email" => "Office Email"))); ?>
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