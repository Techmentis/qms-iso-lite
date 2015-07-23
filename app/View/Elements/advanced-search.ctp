<style>
    .modal-dialog {width:50%;}
    .modal-dialog {width:50%;}
    .chosen-container, .chosen-container-single, .chosen-select
    {min-width: 200px; width:100%;}
</style>
<?php
if ($this->request->controller == 'devices') {
    $postData = null;
    $postData = array('name' => 'Name', 'number' => 'Number', 'serial' => 'Serial', 'make_type' => 'Make Type');
}
?>
<?php
if ($this->request->controller == 'customers') {
    $postData = null;
    $postData = array('name' => 'Name', 'customer_code' => 'Customer Code');
}
?>
<?php
if ($this->request->controller == 'delivery_challans') {
    $postData = null;
    $postData = array('challan_number' => 'challan Number', 'challan_date' => 'Challan Date','challan_details'=>'Challan Details','other_reference_number'=>'Other Reference Number','details'=>'Details','remarks'=>'remarks');
}
?>
<?php
if ($this->request->controller == 'corrective_preventive_actions') {
    $postData = null;
    $postData = array('number' => 'Number', 'name' => 'Name');
}
?>
<?php
if ($this->request->controller == 'corrective_preventive_actions') {
    $postData = null;
    $postData = array('name' => 'Title', 'description' => 'Description');
}
?>
<?php
if ($this->request->controller == 'trainers') {
    $postData = null;
    $postData = array('name' => 'Name', 'company' => 'Company', 'designation' => 'Designation', 'qualification' => 'Qualification', 'personal_telephone' => 'Personal Telephone', 'office_telephone' => 'Office Telephone', 'office_email' => 'Office Email', 'personal_email' => 'Personal Email', 'mobile' => 'Mobile');
}
?>
<?php
if ($this->request->controller == 'customer_complaints') {
    $postData = null;
    $postData = array('complaint_number' => 'Complaint Number', 'details' => 'Details');
    ?>
<script>
    $(document).ready(function() {
        customerComplaint();
    })
</script>
<?php } ?>
<?php
if ($this->request->controller == 'competency_mappings') {
    $postData = null;
    $postData = array('experience_required' => 'Experience Required', 'actual_experience' => 'Actual Experience', 'skills_required' => 'Skills Required', 'skills_possesed' => 'Skills Possesed', 'remarks' => 'Remarks');
}
?>
<?php
if ($this->request->controller == 'supplier_registrations') {
    $postData = null;
    $postData = array('sr_no' => 'Sr No', 'title' => 'Title', 'number' => 'Number', 'contact_person_office' => 'Contact Person Office', 'contact_person_work' => 'Contact Person Work', 'office_address' => 'Office Address', 'work_address' => 'Work Address', 'cst_registration_number' => 'Cst Registration Number', 'st_registration_number' => 'ST Registration Number', 'incometax_number' => 'Incometax Number', 'ssi_registration_number' => 'SSI Registration Number', 'range_of_products' => 'Range Of Products', 'services_offered' => 'Services Offered',);
    $companyTypes = array('Sole Proprietorship' => 'Sole Proprietorship', 'HUF' => 'HUF', 'Chartered Company' => 'Chartered Company', 'Statutory Company' => 'Statutory Company', 'Registered Company' => 'Registered Company', 'Limited Liability Company' => 'Limited Liability Company', 'Unlimited Liability Company' => 'Unlimited Liability Company', 'Private Limited Company' => 'Private Limited Company', 'Private Limited Company' => 'Private Limited Company', 'Public Limited Company' => 'Public Limited Company', 'Holding Company' => 'Holding Company', 'Subsidiary Company' => 'Subsidiary Company', 'Government Company' => 'Government Company', 'Non-Government Company' => 'Non-Government Company', 'Foreign Company' => 'Foreign Company');
}
?>
<?php
if ($this->request->controller == 'users') {
    $postData = null;
    $postData = array('username' => 'Username');
}
?>
<?php
if ($this->request->controller == 'meetings') {
    $postData = null;
    $postData = array('title' => 'Title', 'previous_meeting_date' => 'Previous Meeting Date', 'meeting_details' => 'Meeting Details');
}
?>
<?php
if ($this->request->controller == 'suggestion_forms') {
    $postData = null;
    $postData = array('title' => 'Title', 'activity' => 'Activity', 'suggestion' => 'Suggestion', 'remark' => 'Remark');
}
?>
<?php
if ($this->request->controller == 'purchase_orders') {
    $postData = null;
    $postData = array('title' => 'Title', 'purchase_order_number' => 'Purchase Order Number', 'order_date' => 'Order Date', 'details' => 'Details', 'intimation' => 'Intimation', 'expected_delivery_date' => 'Expected Delivery Date');
    ?>
<script>
    $(document).ready(function() {
        purchaseOrders();
    })
</script>
<?php } ?>
<?php
if ($this->request->controller == 'master_list_of_formats') {
    $postData = null;
    $postData = array('title' => 'Title', 'document_number' => 'Document Number', 'issue_number' => 'Issue Number', 'revision_number' => 'Revision Number', 'revision_date' => 'Revision Date', 'work_instructions' => 'Work Instructions');
}
?>
<?php
if ($this->request->controller == 'system_tables') {
    $postData = null;
    $postData = array('name' => 'Name', 'system_name' => 'System Name');
}
?>
<?php
if ($this->request->controller == 'list_of_softwares') {
    $postData = null;
    $postData = array('name' => 'Name', 'license_key' => 'License Key', 'storage_device_number' => 'Storage Device Number', 'software_usage' => 'Software Usage', 'software_details' => 'Software Details');
}
?>
<?php
if ($this->request->controller == 'username_password_details') {
    $postData = null;
    $postData = array('username' => 'Username', 'date_of_change' => 'Date Of Change');
}
?>
<?php
if ($this->request->controller == 'training_types') {
    $postData = null;
    $postData = array('title' => 'Title', 'training_description' => 'Training Description');
}
?>
<?php
if ($this->request->controller == 'change_addition_deletion_requests') {
    $postData = null;
    $postData = array('current_document_details' => 'Current Document Details', 'request_details' => 'Request Details', 'proposed_changes' => 'Proposed Changes', 'reason_for_change' => 'Reason For Change');
    ?>
<script>
    $(document).ready(function() {
        changeAddition_DocAmendment();
    })
</script>
<?php } ?>
<?php
if ($this->request->controller == 'document_amendment_record_sheets') {
    $postData = null;
    $postData = array('amendment_details' => 'Amendment Details', 'reason_for_change' => 'Reason For Change');
    ?>
<script>
    $(document).ready(function() {
        changeAddition_DocAmendment();
    })
</script>
<?php } ?>
<?php
if ($this->request->controller == 'timelines') {
    $postData = null;
    $postData = array('title' => 'Title', 'message' => 'Message');
}
?>
<?php
if ($this->request->controller == 'customer_meetings') {
    $postData = null;
    $postData = array('action_point' => 'Action Point', 'details' => 'Details');
?>
<script>
    $(document).ready(function() {
        datePicker();
    });
</script>
<?php } ?>
<?php
if ($this->request->controller == 'proposal_followups') {
    $postData = null;
    $postData = array('followup_heading' => 'Followup Heading', 'followup_details' => 'Followup Details');
?>
<script>
    $(document).ready(function() {
        datePicker();
    });
</script>
<?php } ?>
<?php
if ($this->request->controller == 'employees') {
    $postData = null;
    $postData = array('name' => 'Name', 'employee_number' => 'Employee Number', 'pancard_number' => 'Pancard Number', 'personal_telephone' => 'Personal Telephone', 'office_telephone' => 'Office Telephone', 'mobile' => 'Mobile', 'personal_email' => 'Personal Email', 'office_email' => 'Office Email', 'residence_address' => 'Residence Address', 'permenant_address' => 'Permanent Address', 'driving_license' => 'Driving License');
}
?>
<?php
if ($this->request->controller == 'file_uploads') {
    $postData = null;
}
?>
<?php
if ($this->request->controller == 'appraisals') {
    $postData = null;
}
?>
<?php
if ($this->request->controller == 'device_maintenances') {
    $postData = null;
    $postData = array('findings' => 'Findings');
}
?>
<?php unset($postData['sr_no']); ?>
<div class="modal fade " id="advanced_search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-wide">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo __('Advanced Search'); ?></h4>
            </div>
            <div class="modal-body">
                <?php echo $this->Form->create($this->name, array('action' => 'advanced_search', 'role' => 'form', 'class' => 'advanced-search-form', 'id' => 'advanced-search-form', 'type' => 'get')); ?>
                <?php if ($this->request->controller != 'appraisals') { ?>
                    <div class="row">
                        <div class="col-md-12"><?php echo $this->Form->input('Search.keywords', array('label' => __('Type Keyword & select the field which you want to search from below'))); ?></div>
                        <?php if ($this->request->controller == 'devices') { ?>
                            <div class="col-md-12"><?php echo $this->Form->input('Search.search_fields', array('label' => false, 'options' => array($postData), 'multiple' => 'checkbox', 'class' => 'checkbox-inline col-md-3')); ?></div>
                        <?php } else if ($this->request->controller == 'file_uploads') { ?>
                        <?php } else { ?>
                            <div class="col-md-12"><?php echo $this->Form->input('Search.search_fields', array('label' => false, 'options' => array($postData), 'multiple' => 'checkbox', 'class' => 'checkbox-inline col-md-4')); ?></div>
                        <?php } ?>
                        <div class="col-md-12"><hr /></div>
                    </div>
                <?php } ?>
                <?php
                    if ($this->request->controller == 'devices') {
                        $calibrationFrequencies = $this->requestAction('App/get_model_list/Schedule/');
                        $supplierRegistrations = $this->requestAction('App/get_model_list/SupplierRegistration/');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.supplier_registration_id', array('label' => __('Select Supplier'), 'options' => $supplierRegistrations, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.calibration_required', array('label' => __('If calibration is required'), 'type' => 'radio', 'options' => array(0 => 'Yes', 1 => 'No'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.calibration_frequency', array('label' => __('Select Calibration Frequency'), 'options' => $calibrationFrequencies, 'class' => 'form-control')); ?></div>
                        <div class="col-md-12"><?php echo $this->Form->input('Search.manual', array('label' => __('Manual Available'), 'type' => 'radio', 'options' => array(0 => 'Available', 1 => 'Not Available', 2 => 'Not Required'))); ?></div>
                        <div class="col-md-12"><?php echo $this->Form->input('Search.sparelist', array('label' => __('Sparelist Available'), 'type' => 'radio', 'options' => array(0 => 'Available', 1 => 'Not Available', 2 => 'Not Required'))); ?></div>
                    </div>
                <?php } ?>
                <?php
                    if ($this->request->controller == 'calibrations') {
                        $devices = $this->requestAction('App/get_model_list/Device');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.device_id', array('label' => __('Select Device'), 'options' => $devices, 'multiple' => true, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'products') { ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.department_id', array('label' => __('Select Department'), 'options' => $PublishedDepartmentList, 'multiple' => true, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'users') {
                        $languages = $this->requestAction('App/get_model_list/Language');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.language_id', array('label' => __('Select Language'), 'options' => $languages, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.is_mr', array('label' => __('Is MR?'), 'type' => 'radio', 'options' => array(1 => 'Yes', 0 => 'No'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.is_view_all', array('label' => __('Can see other user\'s records?'), 'type' => 'radio', 'options' => array(1 => 'Yes', 0 => 'No'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.is_approvar', array('label' => __('Can approve data added by other users?'), 'type' => 'radio', 'options' => array(1 => 'Yes', 0 => 'No'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.department_id', array('label' => __('Select Department'), 'options' => $PublishedDepartmentList, 'multiple' => true, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'housekeeping_checklists') { ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.department_id', array('label' => __('Select Department'), 'options' => $PublishedDepartmentList, 'multiple' => true, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'devices') { ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.department_id', array('label' => __('Select Department'), 'options' => $PublishedDepartmentList, 'multiple' => true, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'employees') {
                        $maritalStatus = array('Single' => 'Single', 'Married' => 'Married', 'Widowed' => 'Widowed', 'Separated' => 'Separated', 'Divorced' => 'Divorced', 'Other' => 'Other');
                        $employmentStatus = array('1' => 'Active', '0' => 'Resigned');
                ?>

                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.designation_id', array('label' => __('Select Designations'), 'options' => $PublishedDesignationList, 'multiple' => true, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.qualification', array('label' => __('Qualification'), 'options' => $educations, 'class' => 'form-control', 'multiple' => true)); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.joining_date', array('label' => __('Joining Date'), 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.date_of_birth', array('label' => __('Date of Birth'), 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.maritial_status', array('label' => __('Marital Status'), 'options' => $maritalStatus, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employment_status', array('label' => __('Employment Status'), 'options' => $employmentStatus, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'customers') { ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.customer_type', array('label' => __('Select Department'), 'options' => array(1 => 'Individual', 0 => 'Company'), 'type' => 'radio')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'courses') {
                        $courseTypes = $this->requestAction('App/get_model_list/CourseType');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.course_type_id', array('label' => __('Select Course Type'), 'options' => $courseTypes, 'multiple' => true, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'training_need_identifications') {
                    $courses = $this->requestAction('App/get_model_list/Course');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.course_id', array('label' => __('Select Course'), 'options' => $courses, 'multiple' => true, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'trainers') {
                        $trainerTypes = $this->requestAction('App/get_model_list/TrainerType/');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.trainer_type_id', array('label' => __('Select Trainer Type'), 'options' => $trainerTypes, 'multiple' => true, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'trainings') {
                        $trainerTypes = $this->requestAction('App/get_model_list/TrainerType/');
                        $courses = $this->requestAction('App/get_model_list/Course');
                        $trainers = $this->requestAction('App/get_model_list/Trainer');
                ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->input('Search.course_id', array('label' => __('Select Course'), 'options' => $courses, 'multiple' => true, 'class' => 'form-control')); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->input('Search.trainer_type_id', array('label' => __('Select Trainer Type'), 'options' => $trainerTypes, 'multiple' => true, 'class' => 'form-control')); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->input('Search.trainer_id', array('label' => __('Select Trainer'), 'options' => $trainers, 'multiple' => true, 'class' => 'form-control')); ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'corrective_preventive_actions') {
                        $employees = array(
                            'raised_by' => 'Raised By',
                            'assigned_to' => 'Assigned To',
                            'completed_by' => 'Completed By',
                            'determined_by' => 'Determined By',
                            'action_assigned_to' => 'Action Assigned To',
                            'closed_by' => 'Closed By'
                        );
                        $capaCategories = $this->requestAction('App/get_model_list/CapaCategory/');
                        $capaSources = $this->requestAction('App/get_model_list/CapaSource/');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.capa_source_id', array('label' => __('Select Capa Source'), 'options' => $capaSources, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.capa_category_id', array('label' => __('Select Capa Category'), 'options' => $capaCategories, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_type', array('label' => __('Select Employee Type'), 'options' => $employees, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                        <div style="clear:both"></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.document_change_required', array('label' => __('Document Change Required'), 'type' => 'checkbox')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.current_status', array('label' => __('Select Current Status'), 'options' => array(0 => 'Open', 1 => 'Closed'), 'type' => 'radio')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'customer_complaints') {
                        $products = $this->requestAction('App/get_model_list/Product/');
                        $deliveryChallans = $this->requestAction('App/get_model_list/DeliveryChallan/');
                        $customers = $this->requestAction('App/get_model_list/Customer/');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.current_status', array('label' => __('Current Status'), 'options' => array(0 => 'Open', 1 => 'Closed'), 'type' => 'radio')); ?></div>
                        <div class="col-md-5"><?php echo $this->Form->input('Search.customer_id', array('label' => __('Select Customer'), 'options' => $customers, 'multiple' => false, 'class' => 'form-control')); ?></div>
                        <div class="col-md-7"><?php echo $this->Form->input('Search.complaint_source', array('label' => __('Complaint Source'), 'type' => 'radio', 'options' => array('Product' => 'Product', 'Delivery' => 'Delivery', 'Service' => 'Service', 'Customer Care' => 'Customer Care'), 'default' => 'Product')); ?></div>
                        <div class="col-md-6 hidediv" id = "Product"><?php echo $this->Form->input('Search.product_id', array('label' => __('Select Product'), 'options' => $products, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6 hidediv" id = "Delivery"><?php echo $this->Form->input('Search.delivery_challan_id', array('label' => __('Select Delivery Challan'), 'options' => $deliveryChallans, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.assigned_to', array('label' => __('Complaint Assigned To'), 'options' => $PublishedEmployeeList, 'multiple' => false, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.authorised_by', array('label' => __('Authorised By'), 'options' => $PublishedEmployeeList, 'multiple' => false, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'supplier_registrations') {
                        $weekDays = array('Monday' => 'Monday', 'Tuesday' => 'Tuesday', 'Wednesday' => 'Wednesday', 'Thursday' => 'Thursday', 'Friday' => 'Friday', 'Saturday' => 'Saturday', 'Sunday' => 'Sunday');
                ?>
                    <div class="row">
                        <div class="col-md-12"><?php echo $this->Form->input('Search.iso_certified', array('label' => __('Is supplier ISO certified??'), 'type' => 'radio', 'options' => array(1 => 'Yes', 0 => 'No'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.office_weekly_off', array('type' => 'select', 'multiple', 'options' => $weekDays, 'label' => __('Office Weekly Off'), 'multiple' => true, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.work_weekly_off', array('type' => 'select', 'options' => $weekDays, 'label' => __('Workshop/Factory Weekly Off'), 'multiple' => true, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.company_type', array('label' => __('Select Company Type'), 'options' => $companyTypes, 'multiple' => true, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'purchase_orders') {
                        $supplierRegistrations = $this->requestAction('App/get_model_list/SupplierRegistration/');
                        $products = $this->requestAction('App/get_model_list/Product/');
                        $devices = $this->requestAction('App/get_model_list/Device/');
                        $customers = $this->requestAction('App/get_model_list/Customer/');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.type', array('label' => __('Select Supplier'), 'options' => array(0 => 'Inbound', 1 => 'Outbound'), 'default' => 0, 'type' => 'radio')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.purchase_orders', array('label' => __('Complaint Source'), 'type' => 'radio', 'options' => array('Product' => 'Product', 'Device' => 'Device'), 'default' => 'Product')); ?></div>
                        <div class="col-md-6 hidedivType" id="Supplier"><?php echo $this->Form->input('Search.supplier_registration_id', array('label' => __('Select Supplier'), 'options' => $supplierRegistrations, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6 hidedivType" id="Customer"><?php echo $this->Form->input('Search.customer_id', array('label' => __('Select Customer'), 'options' => $customers, 'multiple' => false, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6 hidedivPO" id = "Product"><?php echo $this->Form->input('Search.product_id', array('label' => __('Select Product'), 'options' => $products, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6 hidedivPO" id = "Device"><?php echo $this->Form->input('Search.device_id', array('label' => __('Select Device'), 'options' => $devices, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'change_addition_deletion_requests') {
                        $customers = $this->requestAction('App/get_model_list/Customer/');
                        $masterListOfFormats = $this->requestAction('App/get_model_list/MasterListOfFormat/');
                        $suggestionForms = $this->requestAction('App/get_model_list/SuggestionForm/');
                ?>
                    <div class="row">
                        <div class="col-md-10"><?php echo $this->Form->input('Search.request_from', array('label' => __('Request From'), 'type' => 'radio', 'options' => array('Branch' => 'Branch', 'Department' => 'Department', 'Employee' => 'Employee', 'Customer' => 'Customer', 'SuggestionForm' => 'Suggestion', 'Other' => 'Other'), 'default' => 'Branch')); ?></div>
                        <div class="col-md-6 hidediv" id = "Branch"><?php echo $this->Form->input('Search.branch_id', array('label' => __('Select Branch'), 'options' => $PublishedBranchList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6 hidediv" id = "Department"><?php echo $this->Form->input('Search.department_id', array('label' => __('Select Department'), 'options' => $PublishedDepartmentList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6 hidediv" id = "Employee"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6 hidediv" id = "Customer"><?php echo $this->Form->input('Search.customer_id', array('label' => __('Select Customer'), 'options' => $customers, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6 hidediv" id = "SuggestionForm"><?php echo $this->Form->input('Search.suggestion_form_id', array('label' => __('Select Suggestion Form'), 'options' => $suggestionForms, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6 hidediv" id = "Other"><?php echo $this->Form->input('Search.others', array('label' => __('Other'), 'class' => 'form-control')); ?></div>
                        <div class="col-md-5"><?php echo $this->Form->input('Search.master_list_of_format', array('label' => __('Select Master List of Format'), 'options' => $masterListOfFormats, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'delivery_challans') {
                     $purchaseOrders = $this->requestAction('App/get_model_list/PurchaseOrder/');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.department_id', array('label' => __('Select Department'), 'options' => $PublishedDepartmentList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.purchase_order_id', array('label' => __('Select Purchase Order'), 'options' => $purchaseOrders, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'proposals') {
                        $customers = $this->requestAction('App/get_model_list/Customer/');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.customer_id', array('label' => __('Select Customer'), 'options' => $customers, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'productions') {
                        $products = $this->requestAction('App/get_model_list/Product/');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.product_id', array('label' => __('Select Product'), 'options' => $products, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Supervisor'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'proposal_followups') {
                        $customers = $this->requestAction('App/get_model_list/Customer/');
                        $proposals = $this->requestAction('App/get_model_list/Proposal/');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.proposal_id', array('label' => __('Select Proposal'), 'options' => $proposals, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.customer_id', array('label' => __('Select Customer'), 'options' => $customers, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.status', array('label' => __('Status'), 'options' => array('Open' => 'Open', 'Closed' => 'Closed', 'Pipeline' => 'Pipeline', 'Other' => 'Other'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.followup_date', array('id' => 'curDate', 'label' => __('Followup Date'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.next_followup_date', array('id' => 'nextDate', 'label' => __('Next Followup Date'))); ?></div>
                    </div>
                <?php } ?>

                <?php if ($this->request->controller == 'employee_induction_trainings') {
                        $trainings = $this->requestAction('App/get_model_list/Training');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.training_id', array('label' => __('Select Training'), 'options' => $trainings, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'multiple' => true, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'data_back_ups') {
                        $dataTypes = $this->requestAction('App/get_model_list/DataType/');
                        $schedules = $this->requestAction('App/get_model_list/Schedule/');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.data_type_id', array('label' => __('Select Data Type'), 'options' => $dataTypes, 'multiple' => true, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.schedule_id', array('label' => __('Select Backup Schedule'), 'options' => $schedules, 'multiple' => true, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'daily_backup_details') {
                        $dataBackups = $this->requestAction('App/get_model_list/DataBackUp/');
                        $listOfComputers = $this->requestAction('App/get_model_list/ListOfComputer/');
                        $devices = $this->requestAction('App/get_model_list/Device');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.data_back_up_id', array('label' => __('Select Data Backup Name'), 'options' => $dataBackups, 'multiple' => true, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.device_id', array('label' => __('Select Device Name'), 'options' => $devices, 'multiple' => true, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.list_of_computer_id', array('label' => __('Select Computer Name'), 'options' => $listOfComputers, 'multiple' => true, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'multiple' => true, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'document_amendment_record_sheets') {
                        $customers = $this->requestAction('App/get_model_list/Customer/');
                        $masterListOfFormats = $this->requestAction('App/get_model_list/MasterListOfFormat/');
                        $suggestionForms = $this->requestAction('App/get_model_list/SuggestionForm/');
                ?>
                    <div class="row">
                        <div class="col-md-10"><?php echo $this->Form->input('Search.request_from', array('label' => __('Request From'), 'type' => 'radio', 'options' => array('Branch' => 'Branch', 'Department' => 'Department', 'Employee' => 'Employee', 'Customer' => 'Customer', 'SuggestionForm' => 'Suggestion', 'Other' => 'Other'), 'default' => 'Branch')); ?></div>
                        <div class="col-md-6 hidediv" id = "Branch"><?php echo $this->Form->input('Search.branch_id', array('label' => __('Select Branch'), 'options' => $PublishedBranchList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6 hidediv" id = "Department"><?php echo $this->Form->input('Search.department_id', array('label' => __('Select Department'), 'options' => $PublishedDepartmentList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6 hidediv" id = "Employee"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6 hidediv" id = "Customer"><?php echo $this->Form->input('Search.customer_id', array('label' => __('Select Customer'), 'options' => $customers, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6 hidediv" id = "SuggestionForm"><?php echo $this->Form->input('Search.suggestion_form_id', array('label' => __('Select Suggestion Form'), 'options' => $suggestionForms, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6 hidediv" id = "Other"><?php echo $this->Form->input('Search.others', array('label' => __('Other'), 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.master_list_of_format', array('label' => __('Select Master List Of Format'), 'options' => $masterListOfFormats, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'tasks') {
                        $userNames = $this->requestAction('App/get_usernames/');
                        $schedules = $this->requestAction('App/get_model_list/Schedule');
                        $masterListOfFormats = $this->requestAction('App/get_model_list/MasterListOfFormat/');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.user_name', array('label' => __('Select User'), 'options' => $userNames, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.master_list_id', array('label' => __('Select Master List Of Format'), 'options' => $masterListOfFormats, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.schedule_id', array('label' => __('Select Backup Schedule'), 'options' => $schedules, 'multiple' => true, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'meetings') { ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Chairperson'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'file_uploads') {
                        $masterListOfFormats = $this->requestAction('App/get_model_list/MasterListOfFormat/');
                        $systemTables = $this->requestAction('App/get_model_list/SystemTable/');
                        $Employee = $this->requestAction('App/get_model_list/User/');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.user_id', array('label' => __('Select User'), 'options' => $Employee, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.master_list_id', array('label' => __('Select Master List Of Format'), 'options' => $masterListOfFormats, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.system_id', array('label' => __('Select System'), 'options' => $systemTables, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'list_of_trained_internal_auditors') {
                        $trainings = $this->requestAction('App/get_model_list/Training');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.training_type_id', array('label' => __('Select Training Type'), 'options' => $trainings, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'list_of_computers') {
                        $supplierRegistrations = $this->requestAction('App/get_model_list/SupplierRegistration');
                        $purchaseOrders = $this->requestAction('App/get_model_list/PurchaseOrder');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.supplier_registration_id', array('label' => __('Select Supplier'), 'options' => $supplierRegistrations, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.purchase_order_id', array('label' => __('Select Purchase Order'), 'options' => $purchaseOrders, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'list_of_acceptable_suppliers') {
                        $supplierCategories = $this->requestAction('App/get_model_list/SupplierCategory');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.suppCategory', array('label' => __('Select Supplier Category'), 'options' => $supplierCategories, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'competency_mappings') { ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.education_id', array('label' => __('Select Education'), 'options' => $educations, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.actual_education', array('label' => __('Select Actual Education'), 'options' => $educations, 'class' => 'form-control')); ?></div>

                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'housekeeping_responsibilities') {
                        $housekeepingChecklists = $this->requestAction('App/get_model_list/HousekeepingCheckList');
                        $schedules = $this->requestAction('App/get_model_list/Schedule');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.housekeeping_checklist', array('label' => __('Select Housekeeping CheckList'), 'options' => $housekeepingChecklists, 'multiple' => true, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'multiple' => true, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.schedule_id', array('label' => __('Select Backup Schedule'), 'options' => $schedules, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'summery_of_supplier_evaluations') {
                        $supplierCategories = $this->requestAction('App/get_model_list/SupplierCategory');
                        $supplierRegistrations = $this->requestAction('App/get_model_list/SupplierRegistration');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.supplier_registration_id', array('label' => __('Select Supplier'), 'options' => $supplierRegistrations, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.suppCategory', array('label' => __('Select Supplier Category'), 'options' => $supplierCategories, 'multiple' => true, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'multiple' => true, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'list_of_computer_list_of_softwares') {
                        $listOfComputers = $this->requestAction('App/get_model_list/ListOfComputer');
                        $listOfSoftwares = $this->requestAction('App/get_model_list/ListOfSoftware');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.list_of_computer', array('label' => __('Select Computer'), 'options' => $listOfComputers, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.list_of_software', array('label' => __('Select Softwares'), 'options' => $listOfSoftwares, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'username_password_details') {
                        $listOfComputers = $this->requestAction('App/get_model_list/ListOfComputer');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.computer_id', array('label' => __('Select Computer Name'), 'options' => $listOfComputers, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'customer_feedbacks') {
                        $customers = $this->requestAction('App/get_model_list/Customer');
                        $feedbackQuestions = $this->requestAction('App/get_model_list/CustomerFeedbackQuestion');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.customer_id', array('label' => __('Select Customer Name'), 'options' => $customers, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.customer_feedback_question_id', array('label' => __('Select Question'), 'options' => $feedbackQuestions, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'list_of_measuring_devices_for_calibrations') {
                        $deviceCalibrationList = $this->requestAction('App/get_device_calibration_list/');
                        $schedules = $this->requestAction('App/get_model_list/Schedules');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.device_id', array('label' => __('Select Device'), 'options' => $deviceCalibrationList, 'multiple' => true, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.calibration_frequency', array('label' => __('Select Calibration Frequency'), 'options' => $schedules, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'training_evaluations') {
                        $trainings = $this->requestAction('App/get_model_list/Training');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.training_id', array('label' => __('Select Training'), 'options' => $trainings, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'notifications') {
                        $notificationTypes = $this->requestAction('App/get_model_list/NotificationType');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.notification_type_id', array('label' => __('Select Notification Type'), 'options' => $notificationTypes, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.prepared_by', array('label' => __('Select Prepared By'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.approved_by', array('label' => __('Select Approved By'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'list_of_softwares') {
                        $softwareTypes = $this->requestAction('App/get_model_list/SoftwareType');
                        $schedules = $this->requestAction('App/get_model_list/Schedules');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.software_type_id', array('label' => __('Select Software Type'), 'options' => $softwareTypes, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.schedule_id', array('label' => __('Select Schedules'), 'options' => $schedules, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.backup_required', array('label' => __('Backup Required?'), 'type' => 'radio', 'options' => array(1 => 'Yes', 0 => 'No'))); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'suggestion_forms') { ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'reports') {
                        $masterListOfFormats = $this->requestAction('App/get_model_list/MasterListOfFormat/');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.department_id', array('label' => __('Select Department'), 'options' => $PublishedDepartmentList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.master_list_id', array('label' => __('Select Master List Format'), 'options' => $masterListOfFormats, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'master_list_of_formats') {
                        $systemTables = $this->requestAction('App/get_model_list/SystemTable/');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.archived', array('label' => __('archived?'), 'type' => 'radio', 'options' => array(1 => 'Yes', 0 => 'No'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.department_id', array('label' => __('Select Department'), 'options' => $PublishedDepartmentList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.system_id', array('label' => __('Select System'), 'options' => $systemTables, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.prepared_by', array('label' => __('Prepared By'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.approved_by', array('label' => __('Approved By'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'system_tables') { ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.evidence_required', array('label' => __('Evidence required?'), 'type' => 'radio', 'options' => array(1 => 'Yes', 0 => 'No'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.approvals_required', array('label' => __('Approvals required?'), 'type' => 'radio', 'options' => array(1 => 'Yes', 0 => 'No'))); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'training_types') { ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.mandetory', array('label' => __('Mandatory?'), 'type' => 'radio', 'options' => array(1 => 'Yes', 0 => 'No'))); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'approvals') {
                        $employeeUserNames = $this->requestAction('App/get_usernames');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.users', array('label' => __('Select Users'), 'options' => $employeeUserNames, 'multiple' => true, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'timelines') { ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.prepared_by', array('label' => __('Prepared By'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.approved_by', array('label' => __('Approved By'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>


                <?php if ($this->request->controller == 'customer_meetings') {
                        $customers = $this->requestAction('App/get_model_list/Customer/');
                ?>
                    <div class="row">
                        <div class="col-md-4"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-4"><?php echo $this->Form->input('Search.customer_id', array('label' => __('Select Customer'), 'options' => $customers, 'multiple' => false, 'class' => 'form-control')); ?></div>
                        <div class="col-md-4"><?php echo $this->Form->input('Search.status', array('label' => __('Status'), 'options' => array('Open' => 'Open', 'Closed' => 'Closed', 'Pipeline' => 'Pipeline', 'Other' => 'Other'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.meeting_date', array('id' => 'curDate', 'label' => __('Meeting Date'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.next_meeting_date', array('id' => 'nextDate', 'label' => __('Next Meeting Date'))); ?></div>
                    </div>
                <?php } ?>

                <?php if ($this->request->controller == 'employee_kras') {
                        $kras = $this->requestAction('App/get_model_list/Kra/');
                ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.kra_id', array('label' => __('Select Kra'), 'options' => $kras, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'appraisals') { ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Select Employee'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'non_conforming_products_materials') {
                        $products = $this->requestAction('App/get_model_list/Product/');
                        $material = $this->requestAction('App/get_model_list/Material/');
                        $capaSources = $this->requestAction('App/get_model_list/CapaSource/');
                        $capa = $this->requestAction('App/get_model_list/CorrectivePreventiveAction/');
                ?>
                    <div class="row">
                        <div class="col-md-10"><?php echo $this->Form->input('Select Product / Material', array('label' => __('Select Following'), 'type' => 'radio', 'options' => array('Product' => 'Product', 'Material' => 'Material'), 'onClick' => 'shhd(this.value)', 'default' => 'Product')); ?></div>
                        <div class="col-md-6 hidediv"  id="Product"><?php echo $this->Form->input('Search.product_id', array('label' => __('Select Product'), 'options' => $products, 'class' => 'form-control')); ?></div>
                        < <div class="col-md-6 hidediv"  id="Material"><?php echo $this->Form->input('Search.material_id', array('label' => __('Select Material'), 'options' => $material, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.capa_source_id', array('label' => __('Select Capa Source'), 'options' => $capaSources, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.corrective_preventive_action_id', array('label' => __('Select Capa'), 'options' => $capa, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'device_maintenances') {
                        $devices = $this->requestAction('App/get_model_list/Device/');
                ?>
                    <div class="row">
                        <div class="col-md-4"><?php echo $this->Form->input('Search.device_id', array('label' => __('Select device'), 'options' => $devices, 'class' => 'form-control')); ?></div>
                        <div class="col-md-4"><?php echo $this->Form->input('Search.employee_id', array('label' => __('Person Responsible for Maintenance'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-4"><?php echo $this->Form->input('Search.status', array('type' => 'radio', 'options' => array('0' => 'Not in use', '1' => 'In use'))); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.intimation_sent_to_employee_id', array('label' => __('Intimation sent to Employee'), 'options' => $PublishedEmployeeList, 'class' => 'form-control')); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.intimation_sent_to_department_id', array('label' => __('Intimation sent to Department'), 'options' => $PublishedDepartmentList, 'class' => 'form-control')); ?></div>

                        <div class="col-md-6"><?php echo $this->Form->input('Search.maintenance_performed_date'); ?></div>
                        <div class="col-md-6"><?php echo $this->Form->input('Search.next_maintanence_date'); ?></div>
                    </div>
                <?php } ?>
                <?php if ($this->request->controller == 'file_uploads') { ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.branch_list', array('label' => __('Select branches you want to search'), 'options' => $PublishedBranchList, 'multiple' => true, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } else { ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $this->Form->input('Search.branch_list', array('label' => __('Select branches you want to search'), 'options' => $PublishedBranchList, 'multiple' => true, 'class' => 'form-control')); ?></div>
                    </div>
                <?php } ?>
		<div class ="row">
    <div class = "col-md-6"><?php echo $this->Form->input('prepared_by', array('options' => $PublishedEmployeeList, 'style'=>array('width'=>'100%'))); ?></div>
        <div class = "col-md-6"><?php echo $this->Form->input('approved_by', array('options' => $PublishedEmployeeList)); ?></div>
</div>
                <div class="row">
                    <div class="col-md-12"><hr /></div>
                    <div class="col-md-4"><?php echo $this->Form->input('Search.from-date', array('id' => 'ddfrom', 'label' => __('Select start date'))); ?></div>
                    <div class="col-md-4"><?php echo $this->Form->input('Search.to-date', array('id' => 'ddto', 'label' => __('Select end date'))); ?></div>
                    <div class="col-md-4"><?php echo $this->Form->input('Search.strict_search', array('label' => __('Strict Search'), 'options' => array('Yes', 'No'), 'checked' => 1, 'type' => 'radio')); ?></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'id'=>'submit_id')); ?>
                        <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
            </div>
        </div>
    </div>
</div>
<script>
    function datePicker() {
        $("[name*='date']").datetimepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            'showTimepicker': false,
        }).attr('readonly', 'readonly');
    }
</script>
<script>
    var startDateTextBox = $('#ddfrom');
    var endDateTextBox = $('#ddto');

    startDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
        changeMonth: true,
        changeYear: true,
        beforeShow: function(input, inst) {
            var offset = $(input).offset();
            var height = $(input).height();
            window.setTimeout(function() {
                inst.dpDiv.css({top: (offset.top + height - 260) + 'px'})
            })
        },
        onClose: function(dateText, inst) {
            if (endDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker('getDate');
                if (testStartDate > testEndDate) {
                    endDateTextBox.val(startDateTextBox.val());
                }
            }
            else {
                endDateTextBox.val(dateText);
            }
        },
        onSelect: function(selectedDateTime) {
            endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate'));
        }
    }).attr('readonly', 'readonly');
    endDateTextBox.datetimepicker({
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
        changeMonth: true,
        changeYear: true,
        beforeShow: function(input, inst) {
            var offset = $(input).offset();
            var height = $(input).height();
            window.setTimeout(function() {
                inst.dpDiv.css({top: (offset.top + height - 260) + 'px'});
            })
        },
        onClose: function(dateText, inst) {
            if (startDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker('getDate');
                if (testStartDate > testEndDate)
                    startDateTextBox.val(endDateTextBox.val());
            }
            else {
                startDateTextBox.val(dateText);
            }
        },
        onSelect: function(selectedDateTime) {
            startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate'));
        }
    }).attr('readonly', 'readonly');
</script>
<script>
    $("#Material").hide();

    function customerComplaint() {
        $('.hidediv').hide();
        $('#Product').show();
        $("[name='complaint_source']").click(function() {
            $val = this.value;
            $('.hidediv').hide();
            $('#SearchProductId').val(-1).trigger('chosen:updated');
            $('#SearchDeliveryChallanId').val(-1).trigger('chosen:updated');
            $('.hidediv').find('select').prop('value', -1);
            $('#' + $val).toggle();
        });
    }

    function purchaseOrders() {
        $('.hidedivPO').hide();
        $('.hidedivType').hide();
        $('#Product').show();
        $('#Supplier').show();
        $("[name='purchase_orders']").click(function() {
            $val = this.value;
            $('.hidedivPO').hide();
            $('#SearchProductId').val(-1).trigger('chosen:updated');
            $('#SearchDeviceId').val(-1).trigger('chosen:updated');
            $('.hidedivPO').find('select').prop('value', -1);
            $('#' + $val).toggle();
        });
        $("[name='type']").click(function() {
            $val = this.value;
            if ($val == 0)
                $val = 'Supplier';
            else
                $val = 'Customer';
            $('.hidedivType').hide();
            $('#SearchSupplierRegistrationId').val(-1).trigger('chosen:updated');
            $('#SearchSearchCustomerId').val(-1).trigger('chosen:updated');
            $('.hidedivType').find('select').prop('value', -1);
            $('#' + $val).toggle();
        });
    }

    function changeAddition_DocAmendment() {
        $('.hidediv').hide();
        $('#Branch').show();
        $("[name='request_from']").click(function() {
            $val = this.value;
            $('.hidediv').hide();
            $('#SearchBranchId').val(-1).trigger('chosen:updated');
            $('#SearchDepartmentId').val(-1).trigger('chosen:updated');
            $('.hidediv').find('select').prop('value', -1);
            $('#' + $val).toggle();
        });
    }

    function shhd(chk) {
        if (chk == 'Product') {
            $("#Material").hide();
            $("#Product").show();
        } else if (chk == 'Material') {
            $("#Material").show();
            $("#Product").hide();

        }
    }
    $().ready(function() {
        $("#submit-indicator").hide();
        $("#submit_id").click(function(){
            $("#submit_id").prop("disabled",true);
            $("#submit-indicator").show();
            $("#advanced-search-form").submit();
        });
    });
</script>
