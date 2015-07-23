<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="supplierRegistrations ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Supplier Registrations', 'modelClass' => 'SupplierRegistration', 'options' => array("sr_no" => "Sr No", "title" => "Title", "number" => "Number", "type_of_company" => "Type Of Company", "contact_person_office" => "Contact Person Office", "contact_person_work" => "Contact Person Work", "designition_in_office" => "Designition In Office", "designation_in_work" => "Designation In Work", "office_address" => "Office Address", "work_address" => "Work Address", "office_telephone" => "Office Telephone", "work_telephone" => "Work Telephone", "office_fax" => "Office Fax", "work_fax" => "Work Fax", "office_weekly_off" => "Office Weekly Off", "work_weekly_off" => "Work Weekly Off", "cst_registration_number" => "Cst Registration Number", "st_registration_number" => "St Registration Number", "incometax_number" => "Incometax Number", "ssi_registration_number" => "Ssi Registration Number", "range_of_products" => "Range Of Products", "services_offered" => "Services Offered", "existing_facilities" => "Existing Facilities", "prominent_customers" => "Prominent Customers", "quality_assurence" => "Quality Assurence", "name" => "Name", "designation" => "Designation", "date" => "Date", "facilites" => "Facilites", "facility_comments" => "Facility Comments", "supplier_representative" => "Supplier Representative", "supplier_selected" => "Supplier Selected", "details" => "Details", "order_date" => "Order Date", "trial_order" => "Trial Order", "name2" => "Name2", "designation2" => "Designation2", "date2" => "Date2"), 'pluralVar' => 'supplierRegistrations'))); ?>
        <div class="nav">
            <div id="tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('New Supplier Registration'), array('action' => 'add_ajax')); ?></li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></li>
                </ul>
            </div>
        </div>
        <div id="supplierRegistrations_tab_ajax"></div>
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
    <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "number" => "Number", "type_of_company" => "Type Of Company", "contact_person_office" => "Contact Person Office", "contact_person_work" => "Contact Person Work", "designition_in_office" => "Designition In Office", "designation_in_work" => "Designation In Work", "office_address" => "Office Address", "work_address" => "Work Address", "office_telephone" => "Office Telephone", "work_telephone" => "Work Telephone", "office_fax" => "Office Fax", "work_fax" => "Work Fax", "office_weekly_off" => "Office Weekly Off", "work_weekly_off" => "Work Weekly Off", "cst_registration_number" => "Cst Registration Number", "st_registration_number" => "St Registration Number", "incometax_number" => "Incometax Number", "ssi_registration_number" => "Ssi Registration Number", "range_of_products" => "Range Of Products", "services_offered" => "Services Offered", "existing_facilities" => "Existing Facilities", "prominent_customers" => "Prominent Customers", "quality_assurence" => "Quality Assurence", "name" => "Name", "designation" => "Designation", "date" => "Date", "facilites" => "Facilites", "facility_comments" => "Facility Comments", "supplier_representative" => "Supplier Representative", "supplier_selected" => "Supplier Selected", "details" => "Details", "order_date" => "Order Date", "trial_order" => "Trial Order", "name2" => "Name2", "designation2" => "Designation2", "date2" => "Date2"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
    <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "number" => "Number", "type_of_company" => "Type Of Company", "contact_person_office" => "Contact Person Office", "contact_person_work" => "Contact Person Work", "designition_in_office" => "Designition In Office", "designation_in_work" => "Designation In Work", "office_address" => "Office Address", "work_address" => "Work Address", "office_telephone" => "Office Telephone", "work_telephone" => "Work Telephone", "office_fax" => "Office Fax", "work_fax" => "Work Fax", "office_weekly_off" => "Office Weekly Off", "work_weekly_off" => "Work Weekly Off", "cst_registration_number" => "Cst Registration Number", "st_registration_number" => "St Registration Number", "incometax_number" => "Incometax Number", "ssi_registration_number" => "Ssi Registration Number", "range_of_products" => "Range Of Products", "services_offered" => "Services Offered", "existing_facilities" => "Existing Facilities", "prominent_customers" => "Prominent Customers", "quality_assurence" => "Quality Assurence", "name" => "Name", "designation" => "Designation", "date" => "Date", "facilites" => "Facilites", "facility_comments" => "Facility Comments", "supplier_representative" => "Supplier Representative", "supplier_selected" => "Supplier Selected", "details" => "Details", "order_date" => "Order Date", "trial_order" => "Trial Order", "name2" => "Name2", "designation2" => "Designation2", "date2" => "Date2"))); ?>
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