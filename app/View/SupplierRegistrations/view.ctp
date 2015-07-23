<div id="supplierRegistrations_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="supplierRegistrations form col-md-8">
            <h4>
                <h4><?php echo $this->element('breadcrumbs') . __('View Supplier Registration'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>

            <div class="row">
                <div class="col-md-12">&nbsp;</div>
                <div class="col-md-6">
                    <label><?php echo __('Title'); ?></label>
                    <?php
                        if (empty($supplierRegistration['SupplierRegistration']['title']))
                            echo '&#8212;';
                        echo $supplierRegistration['SupplierRegistration']['title'];
                    ?>&nbsp;
                </div>
                <div class="col-md-6">
                    <label><?php echo __('Number'); ?></label>
                    <?php echo $supplierRegistration['SupplierRegistration']['number']; ?>&nbsp;
                </div>
                <div class="col-md-6">
                    <label><?php echo __('Type Of Company'); ?></label>
                    <?php echo $supplierRegistration['SupplierRegistration']['type_of_company']; ?>&nbsp;
                </div>

                <div class="col-md-12"><hr /></div>
                <div class="col-md-6 pull-left">
                    <div class="col-md-12"><h4><?php echo __('Office Details'); ?></h4></div>
                    <div class="col-md-12">
                        <label><?php echo __('Contact Person Office'); ?></label>
                        <?php echo $supplierRegistration['SupplierRegistration']['contact_person_office']; ?>&nbsp;
                    </div>
                    <div class="col-md-12">
                        <label><?php echo __('Designition at Office'); ?></label>
                        <?php echo $supplierRegistration['SupplierRegistration']['designition_in_office']; ?>&nbsp;
                    </div>
                    <div class="col-md-12">
                        <label><?php echo __('Office Address'); ?></label>
                        <?php echo $supplierRegistration['SupplierRegistration']['office_address']; ?>&nbsp;
                    </div>
                    <div class="col-md-12">
                        <label><?php echo __('Office Telephone'); ?></label>
                        <?php echo $supplierRegistration['SupplierRegistration']['office_telephone']; ?>&nbsp;
                    </div>
                    <div class="col-md-12">
                        <label><?php echo __('Office Fax'); ?></label>
                        <?php echo $supplierRegistration['SupplierRegistration']['office_fax']; ?>&nbsp;
                    </div>
                    <div class="col-md-12">
                        <label><?php echo __('Office Weekly Off'); ?></label>
                        <?php echo $supplierRegistration['SupplierRegistration']['office_weekly_off']; ?>&nbsp;
                    </div>
                </div>
                <div class="col-md-6 pull-left">
                    <div class="col-md-12"><h4><?php echo __('Factory / Workshop details'); ?></h4></div>
                    <div class="col-md-12">
                        <label><?php echo __('Contact Person Workshop/Factory'); ?></label>
                        <?php echo $supplierRegistration['SupplierRegistration']['contact_person_work']; ?>&nbsp;
                    </div>
                    <div class="col-md-12">
                        <label><?php echo __('Designation at Workshop/Factory'); ?></label>
                        <?php echo $supplierRegistration['SupplierRegistration']['designation_in_work']; ?>&nbsp;
                    </div>
                    <div class="col-md-12">
                        <label><?php echo __('Workshop/Factory Address'); ?></label>
                        <?php echo $supplierRegistration['SupplierRegistration']['work_address']; ?>&nbsp;
                    </div>
                    <div class="col-md-12">
                        <label><?php echo __('Workshop/Factory Telephone'); ?> </label>
                        <?php echo $supplierRegistration['SupplierRegistration']['work_telephone']; ?>&nbsp;
                    </div>
                    <div class="col-md-12">
                        <label><?php echo __('Workshop/Factory Fax'); ?></label>
                        <?php echo $supplierRegistration['SupplierRegistration']['work_fax']; ?>&nbsp;
                    </div>
                    <div class="col-md-12">
                        <label><?php echo __('Workshop/Factory Weekly Off'); ?> </label>
                        <?php echo $supplierRegistration['SupplierRegistration']['work_weekly_off']; ?>&nbsp;
                    </div>
                </div>

                <div class="col-md-12"><hr /></div>

                <div class="col-md-3">
                    <label><?php echo __('Is supplier ISO certified?'); ?></label>
                    <?php echo $supplierRegistration['SupplierRegistration']['iso_certified'] ? __('Yes') : __('No'); ?>&nbsp;
                </div>
                <div class="col-md-12"><hr /></div>
                <div class="col-md-3">
                    <label><?php echo __('CST Registration Number'); ?></label>
                    <?php
                        if (empty($supplierRegistration['SupplierRegistration']['cst_registration_number']))
                            echo '<span style="margin-left:60px;
    margin-right:60px;">&#8212;</span>';
                        echo $supplierRegistration['SupplierRegistration']['cst_registration_number'];
                    ?>&nbsp;
                </div>

                <div class="col-md-3">
                    <label><?php echo __('ST Registration Number'); ?></label>
                    <?php
                        if (empty($supplierRegistration['SupplierRegistration']['st_registration_number']))
                            echo '<span style="margin-left:60px;
    margin-right:60px;">&#8212;</span>';
                        echo $supplierRegistration['SupplierRegistration']['st_registration_number'];
                    ?>&nbsp;
                </div>

                <div class="col-md-3">
                    <label><?php echo __('Incometax Number'); ?></label>
                    <?php
                        if (empty($supplierRegistration['SupplierRegistration']['incometax_number']))
                            echo '<span style="margin-left:60px;
    margin-right:60px;">&#8212;</span>';
                        echo $supplierRegistration['SupplierRegistration']['incometax_number'];
                    ?>&nbsp;
                </div>

                <div class="col-md-3">
                    <label><?php echo __('SSI Registration Number'); ?></label>
                        <?php
                        if (empty($supplierRegistration['SupplierRegistration']['ssi_registration_number']))
                            echo '<span style="margin-left:60px;
    margin-right:60px;">&#8212;</span>';
                        echo $supplierRegistration['SupplierRegistration']['ssi_registration_number'];
                    ?>&nbsp;
                </div>
                <div class="col-md-12"><hr /></div>
                <div class="col-md-6">
                    <label><?php echo __('Range Of Products'); ?></label>
                    <?php echo $supplierRegistration['SupplierRegistration']['range_of_products']; ?>&nbsp;
                </div>
                <div class="col-md-6">
                    <label><?php echo __('Services Offered'); ?></label>
                    <?php echo $supplierRegistration['SupplierRegistration']['services_offered']; ?>&nbsp;
                </div>
                <div class="col-md-6">
                    <label><?php echo __('Existing Facilities'); ?></label>
                    <?php echo $supplierRegistration['SupplierRegistration']['existing_facilities']; ?>&nbsp;
                </div>
                <div class="col-md-6">
                    <label><?php echo __('Prominent Customers'); ?></label>
                    <?php echo $supplierRegistration['SupplierRegistration']['prominent_customers']; ?>&nbsp;
                </div>
                <div class="col-md-12"><hr /></div>
                <div class="col-md-12">
                    <label><?php echo __('Quality Assurance'); ?></label>
                    <?php echo $supplierRegistration['SupplierRegistration']['quality_assurence']; ?>&nbsp;
                </div>
                <div class="col-md-12"><hr /></div>
                <div class="col-md-6">
                    <label><?php echo __('Facility Comments'); ?></label>
                    <?php echo $supplierRegistration['SupplierRegistration']['facility_comments']; ?>&nbsp;
                </div>
                <div class="col-md-6">
                    <label><?php echo __('Supplier Representative'); ?></label>
                    <?php echo $supplierRegistration['SupplierRegistration']['supplier_representative']; ?>&nbsp;
                </div>
                <div class="col-md-6">
                    <label><?php echo __('Trial Order'); ?></label>
                    <?php echo $supplierRegistration['SupplierRegistration']['trial_order']; ?>&nbsp;
                </div>
                <div class="col-md-6">
                    <label><?php echo __('Order Date'); ?> </label>
                    <?php echo $supplierRegistration['SupplierRegistration']['order_date']; ?>&nbsp;
                </div>
                <div class="col-md-12"><hr /></div>
                <div class="col-md-6">
                    <label><?php echo __('Branch'); ?></label>
                    <?php echo $this->Html->link($supplierRegistration['BranchIds']['name'], array('controller' => 'branches', 'action' => 'view', $supplierRegistration['BranchIds']['id'])); ?>&nbsp;
                </div>
                <div class="col-md-6">
                    <label><?php echo __('Department'); ?></label>
                    <?php echo $this->Html->link($supplierRegistration['DepartmentIds']['name'], array('controller' => 'departments', 'action' => 'view', $supplierRegistration['DepartmentIds']['id'])); ?>&nbsp;
                </div>
                <div class="col-md-12"><hr /></div>
                <div class="col-md-6">
                    <label><?php echo __('Prepared By'); ?></label>
                        <?php echo h($supplierRegistration['PreparedBy']['name']); ?>
                </div>
                <div class="col-md-6">
                    <label><?php echo __('Approved By'); ?></label>
                        <?php echo h($supplierRegistration['ApprovedBy']['name']); ?>
                </div>
                <div class="col-md-12"><hr /></div>
                <div class="col-md-6">
                    <label><?php echo __('Publish'); ?></label>
                    <td colspan="4">
                        <?php if ($supplierRegistration['SupplierRegistration']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;
                    </td>
                </div>
                <div class="col-md-12"><hr /></div>
            </div>

            <?php echo $this->element('upload-edit', array('usersId' => $supplierRegistration['SupplierRegistration']['created_by'], 'recordId' => $supplierRegistration['SupplierRegistration']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#supplierRegistrations_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $supplierRegistration['SupplierRegistration']['id'], 'ajax'), array('async' => true, 'update' => '#supplierRegistrations_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#supplierRegistrations_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>
