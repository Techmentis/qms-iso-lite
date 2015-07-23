<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="supplierRegistrations ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Supplier Registrations', 'modelClass' => 'SupplierRegistration', 'options' => array("sr_no" => "Sr No", "title" => "Title", "number" => "Number", "type_of_company" => "Type Of Company", "contact_person_office" => "Contact Person Office", "contact_person_work" => "Contact Person Work", "designition_in_office" => "Designition In Office", "designation_in_work" => "Designation In Work", "office_address" => "Office Address", "work_address" => "Work Address", "office_telephone" => "Office Telephone", "work_telephone" => "Work Telephone", "office_fax" => "Office Fax", "work_fax" => "Work Fax", "office_weekly_off" => "Office Weekly Off", "work_weekly_off" => "Work Weekly Off", "cst_registration_number" => "Cst Registration Number", "st_registration_number" => "St Registration Number", "incometax_number" => "Incometax Number", "ssi_registration_number" => "Ssi Registration Number", "range_of_products" => "Range Of Products", "services_offered" => "Services Offered", "existing_facilities" => "Existing Facilities", "prominent_customers" => "Prominent Customers", "quality_assurence" => "Quality Assurence", "name" => "Name", "designation" => "Designation", "date" => "Date", "facilites" => "Facilites", "facility_comments" => "Facility Comments", "supplier_representative" => "Supplier Representative", "supplier_selected" => "Supplier Selected", "details" => "Details", "order_date" => "Order Date", "trial_order" => "Trial Order", "name2" => "Name2", "designation2" => "Designation2", "date2" => "Date2"), 'pluralVar' => 'supplierRegistrations'))); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('table th a, .pag_list li span a').on('click', function() {
            var url = $(this).attr("href");
            $('#main').load(url);
            return false;
        });
    });
</script>

        <div class="table-responsive">
            <?php echo $this->Form->create(array('class' => 'no-padding no-margin no-background')); ?>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th><?php echo $this->Paginator->sort('title', __('Title')); ?></th>
                    <th><?php echo $this->Paginator->sort('number', __('Number')); ?></th>
                    <th><?php echo $this->Paginator->sort('type_of_company', __('Type of Company')); ?></th>
                    <th><?php echo $this->Paginator->sort('contact_person_office', __('Contact Person Office')); ?></th>
                    <th><?php echo $this->Paginator->sort('office_telephone', __('Office Telephone')); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php
                    if ($supplierRegistrations) {
                        $x = 0;
                        foreach ($supplierRegistrations as $supplierRegistration):
                ?>
                <tr>
                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $supplierRegistration['SupplierRegistration']['created_by'], 'postVal' => $supplierRegistration['SupplierRegistration']['id'], 'softDelete' => $supplierRegistration['SupplierRegistration']['soft_delete'])); ?>
                    </td>
                    <td><?php echo $supplierRegistration['SupplierRegistration']['title']; ?>&nbsp;</td>
                    <td><?php echo $supplierRegistration['SupplierRegistration']['number']; ?>&nbsp;</td>
                    <td><?php echo $supplierRegistration['SupplierRegistration']['type_of_company']; ?>&nbsp;</td>
                    <td><?php echo $supplierRegistration['SupplierRegistration']['contact_person_office']; ?>&nbsp;</td>
                    <td><?php echo $supplierRegistration['SupplierRegistration']['office_telephone']; ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$supplierRegistration['SupplierRegistration']['prepared_by']]); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$supplierRegistration['SupplierRegistration']['approved_by']]); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($supplierRegistration['SupplierRegistration']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;
                    </td>
                </tr>
                <?php
                    $x++;
                    endforeach;
                    } else {
                ?>
                <tr><td colspan=49><?php echo __('No results found'); ?></td></tr>
                <?php } ?>
            </table>
            <?php echo $this->Form->end(); ?>
        </div>
        <p>
            <?php
                echo $this->Paginator->options(array(
                    'update' => '#main',
                    'evalScripts' => true,
                    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
                    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
                ));

                echo $this->Paginator->counter(array(
                    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                ));
            ?>
        </p>
        <ul class="pagination">
            <?php
                echo "<li class='previous'>" . $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')) . "</li>";
                echo "<li>" . $this->Paginator->numbers(array('separator' => '')) . "</li>";
                echo "<li class='next'>" . $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')) . "</li>";
            ?>
        </ul>
    </div>
</div>

<?php echo $this->element('export'); ?>
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "number" => "Number", "type_of_company" => "Type Of Company", "contact_person_office" => "Contact Person Office", "contact_person_work" => "Contact Person Work", "designition_in_office" => "Designition In Office", "designation_in_work" => "Designation In Work", "office_address" => "Office Address", "work_address" => "Work Address", "office_telephone" => "Office Telephone", "work_telephone" => "Work Telephone", "office_fax" => "Office Fax", "work_fax" => "Work Fax", "office_weekly_off" => "Office Weekly Off", "work_weekly_off" => "Work Weekly Off", "cst_registration_number" => "Cst Registration Number", "st_registration_number" => "St Registration Number", "incometax_number" => "Incometax Number", "ssi_registration_number" => "Ssi Registration Number", "range_of_products" => "Range Of Products", "services_offered" => "Services Offered", "existing_facilities" => "Existing Facilities", "prominent_customers" => "Prominent Customers", "quality_assurence" => "Quality Assurence", "name" => "Name", "designation" => "Designation", "date" => "Date", "facilites" => "Facilites", "facility_comments" => "Facility Comments", "supplier_representative" => "Supplier Representative", "supplier_selected" => "Supplier Selected", "details" => "Details", "order_date" => "Order Date", "trial_order" => "Trial Order", "name2" => "Name2", "designation2" => "Designation2", "date2" => "Date2"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "number" => "Number", "type_of_company" => "Type Of Company", "contact_person_office" => "Contact Person Office", "contact_person_work" => "Contact Person Work", "designition_in_office" => "Designition In Office", "designation_in_work" => "Designation In Work", "office_address" => "Office Address", "work_address" => "Work Address", "office_telephone" => "Office Telephone", "work_telephone" => "Work Telephone", "office_fax" => "Office Fax", "work_fax" => "Work Fax", "office_weekly_off" => "Office Weekly Off", "work_weekly_off" => "Work Weekly Off", "cst_registration_number" => "Cst Registration Number", "st_registration_number" => "St Registration Number", "incometax_number" => "Incometax Number", "ssi_registration_number" => "Ssi Registration Number", "range_of_products" => "Range Of Products", "services_offered" => "Services Offered", "existing_facilities" => "Existing Facilities", "prominent_customers" => "Prominent Customers", "quality_assurence" => "Quality Assurence", "name" => "Name", "designation" => "Designation", "date" => "Date", "facilites" => "Facilites", "facility_comments" => "Facility Comments", "supplier_representative" => "Supplier Representative", "supplier_selected" => "Supplier Selected", "details" => "Details", "order_date" => "Order Date", "trial_order" => "Trial Order", "name2" => "Name2", "designation2" => "Designation2", "date2" => "Date2"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->element('common'); ?>
<?php echo $this->Js->writeBuffer(); ?>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>