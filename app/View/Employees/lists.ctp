<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="employees ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Employees', 'modelClass' => 'Employee', 'options' => array("sr_no" => "Sr No", "name" => "Name", "employee_number" => "Employee Number", "qualification" => "Qualification", "joining_date" => "Joining Date", "date_of_birth" => "Date Of Birth", "pancard_number" => "Pancard Number", "personal_telephone" => "Personal Telephone", "office_telephone" => "Office Telephone", "mobile" => "Mobile", "personal_email" => "Personal Email", "office_email" => "Office Email", "residence_address" => "Residence Address", "permenant_address" => "Permanent Address", "maritial_status" => "Marital Status", "driving_license" => "Driving License"), 'pluralVar' => 'employees'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Employee'), array('action' => 'add_ajax')); ?></li>
                </ul>
            </div>
        </div>
        <div id="employees_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("name" => "Name", "employee_number" => "Employee Number", "qualification" => "Qualification", "joining_date" => "Joining Date", "date_of_birth" => "Date Of Birth", "pancard_number" => "Pancard Number", "personal_telephone" => "Personal Telephone", "office_telephone" => "Office Telephone", "mobile" => "Mobile", "personal_email" => "Personal Email", "office_email" => "Office Email", "residence_address" => "Residence Address", "permenant_address" => "Permanent Address", "maritial_status" => "Marital Status", "driving_license" => "Driving License"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "name" => "Name", "employee_number" => "Employee Number", "qualification" => "Qualification", "joining_date" => "Joining Date", "date_of_birth" => "Date Of Birth", "pancard_number" => "Pancard Number", "personal_telephone" => "Personal Telephone", "office_telephone" => "Office Telephone", "mobile" => "Mobile", "personal_email" => "Personal Email", "office_email" => "Office Email", "residence_address" => "Residence Address", "permenant_address" => "Permanent Address", "maritial_status" => "Marital Status", "driving_license" => "Driving License"))); ?>
</div>
<script>$.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }});</script>