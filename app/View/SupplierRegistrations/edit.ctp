<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function (error, element) {
            if ($(element).attr('name') == 'data[SupplierRegistration][type_of_company]')
                $(element).next().after(error);
            else {
                $(element).after(error);
            }
        },
    });

    $().ready(function () {
        $('#SupplierRegistrationFactoryDetails').click(function () {
            if ($('#SupplierRegistrationFactoryDetails').is(':checked', true)) {
                $("#factory_details").find("input,textarea,button,select").prop("disabled", false);

                var cpOff = $("#SupplierRegistrationContactPersonOffice").val();
                var desOff = $("#SupplierRegistrationDesignitionInOffice").val();
                var adrOff = $("#SupplierRegistrationOfficeAddress").val();
                var telOff = $("#SupplierRegistrationOfficeTelephone").val();
                var faxOff = $("#SupplierRegistrationOfficeFax").val();
                var woOff = $("#SupplierRegistrationOfficeWeeklyOff").val();

                $("#SupplierRegistrationContactPersonWork").val(cpOff);
                $("#SupplierRegistrationDesignationInWork").val(desOff);
                $("#SupplierRegistrationWorkAddress").val(adrOff);
                $("#SupplierRegistrationWorkTelephone").val(telOff);
                $("#SupplierRegistrationWorkFax").val(faxOff);
                $("#SupplierRegistrationWorkWeeklyOff").val(woOff).trigger('chosen:updated');

            } else {
                $("#factory_details").find("input,textarea,button,select").prop("disabled", true);
                $("#factory_details").find("input,textarea,button,select").val('');
                $("#SupplierRegistrationWorkWeeklyOff").val('').trigger('chosen:updated');
            }
        });

        jQuery.validator.addMethod("customNumber", function (value, element) {
            return this.optional(element) || /^[A-Za-z0-9-/]{6,16}$/i.test(value);
        }, "Invalid Number");
        jQuery.validator.addMethod("customPhoneNumber", function (value, element) {
            return this.optional(element) || /^[0-9-/()+\s]{6,16}$/i.test(value);
        }, "Please enter correct number");
        jQuery.validator.addMethod("notEqual", function (value, element, param) {
            return this.optional(element) || value != param;
        }, "Please select Company Type");

        $('#SupplierRegistrationEditForm').validate({
            rules: {
                "data[SupplierRegistration][type_of_company]": {
                    notEqual: -1,
                },
                "data[SupplierRegistration][office_telephone]": {
                    customPhoneNumber: true,
                },
            }
        });
        $("#submit-indicator").hide();
        $("#submit_id").click(function(){
             if($('#SupplierRegistrationEditForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
                 $("#SupplierRegistrationEditForm").submit();
             }
        });
        $('#SupplierRegistrationTitle').blur(function () {
            $("#getSupplierRegistration").load('<?php echo Router::url('/', true);?><?php echo $this->request->params['controller']?>/get_supplier_registration_title/title/' + encodeURIComponent(this.value) + '/<?php echo $this->data['SupplierRegistration']['id'];?>', function (response, status, xhr) {
                    if (response != "") {
                        $('#SupplierRegistrationTitle').val('');
                        $('#SupplierRegistrationTitle').addClass('error');
                    } else {
                        $('#SupplierRegistrationTitle').removeClass('error');
                    }
                });
        });


        $('#SupplierRegistrationNumber').blur(function () {
            $("#getSupplierRegistrationNumber").load('<?php echo Router::url('/', true);?><?php echo $this->request->params['controller']?>/get_supplier_registration_title/number/' + encodeURIComponent(this.value), + '/<?php echo $this->data['SupplierRegistration']['id'];?>', function (response, status, xhr) {
                    if (response != "") {
                        $('#SupplierRegistrationNumber').val('');
                        $('#SupplierRegistrationNumber').addClass('error');
                    } else {
                        $('#SupplierRegistrationNumber').removeClass('error');
                    }
                });
        });

        $('#SupplierRegistrationTypeOfCompany').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
    });
     
</script>

<div id="supplierRegistrations_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="supplierRegistrations form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Edit Supplier Registration'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>

            </h4>
            <?php echo $this->Form->create('SupplierRegistration', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>
            <div class="row">
                <div class="col-md-12"><?php echo $this->Form->input('title', array('label' => __('Title'))); ?>
                    <span class="help-block"><?php echo __('Type Name of the Company') ?></span>
                    <label id="getSupplierRegistration" class="error" style="clear:both" ></label>
                </div>
                <div class="col-md-6">
                    <?php echo $this->Form->input('number', array('label' => __('Number'))); ?>
                    <span class="help-block"><?php echo __('Registration Number or any other identidy number') ?></span>
                    <label id="getSupplierRegistrationNumber" class="error" style="clear:both" ></label>
                </div>
                <div class="col-md-6"><?php echo $this->Form->input('type_of_company', array('type' => 'select', 'options' => $companyTypes, 'style' => 'width:100%', 'label' => __('Type of Company'))); ?></div>
            </div>
            <div class="row">
                <div class="col-md-12"><hr /></div>
                <div class="col-md-6 pull-left">
                    <div class="col-md-12"><h4><?php echo __('Office Details'); ?></h4></div>
                    <div class="col-md-12"><?php echo $this->Form->input('contact_person_office', array('label' => __('Contact Person at Office'))); ?></div>
                    <div class="col-md-12"><?php echo $this->Form->input('designition_in_office', array('label' => __('Designation at Office'))); ?></div>
                    <div class="col-md-12"><?php echo $this->Form->input('office_address', array('label' => __('Office Address'))); ?></div>
                    <div class="col-md-12"><?php echo $this->Form->input('office_telephone', array('label' => __('Office Telephone'))); ?></div>
                    <div class="col-md-12"><?php echo $this->Form->input('office_fax', array('label' => __('Office Fax'))); ?></div>
                    <div class="col-md-12"><?php echo $this->Form->input('office_weekly_off', array('name' => 'office_weekly_off[]', 'type' => 'select', 'multiple', 'options' => $weekDays, 'style' => 'width:100%', 'value' => $selectedOfficeWeek, 'label' => __('Office Weekly Off'))); ?></div>
                </div>
                <div class="col-md-6 pull-left">
                    <div class="col-md-12"><h4><?php echo __('Factory / Workshop details'); ?></h4></div>
                    <div id="factory_details">
                        <div class="col-md-12"><?php echo $this->Form->input('contact_person_work', array('label' => __('Contact Person Workshop/Factory'))); ?></div>
                        <div class="col-md-12"><?php echo $this->Form->input('designation_in_work', array('label' => __('Designation at Workshop/Factory'))); ?></div>
                        <div class="col-md-12"><?php echo $this->Form->input('work_address', array('label' => __('Workshop/Factory Address'))); ?></div>
                        <div class="col-md-12"><?php echo $this->Form->input('work_telephone', array('label' => __('Workshop/Factory Telephone'))); ?></div>
                        <div class="col-md-12"><?php echo $this->Form->input('work_fax', array('label' => __('Workshop/Factory Fax'))); ?></div>
                        <div class="col-md-12"><?php echo $this->Form->input('work_weekly_off', array('name' => 'work_weekly_off[]', 'type' => 'select', 'multiple', 'options' => $weekDays, 'style' => 'width:100%', 'value' => $selectedWorkWeek, 'label' => __('Workshop/Factory Weekly Off'))); ?></div>
                    </div>
                </div>
                <div class="col-md-12"><?php echo $this->Form->input('factory_details', array('type' => 'checkbox', 'label' => false, 'legend' => false, 'div' => false, 'style' => 'float:left;margin:10px 10px 0 0;')); ?><h4><?php echo __('Factory Details are the same as Office Details'); ?></h4></div>
                <div class="col-md-12"><?php
                    echo "<label>" . __('Is supplier ISO certified?') . "</label>";
                    echo $this->Form->input('iso_certified', array('label' => false, 'legend' => false, 'div' => false, 'options' => array('1' => 'Yes', '0' => 'No'), 'type' => 'radio', 'style' => 'float:none'));
                    ?></div>

            </div>
            <div class="row">
                <div class="col-md-12"><hr /></div>
                <div class="col-md-3"><?php echo $this->Form->input('cst_registration_number', array('label' => __('CST Registration Number'))); ?></div>
                <div class="col-md-3"><?php echo $this->Form->input('st_registration_number', array('label' => __('ST Registration Number'))); ?></div>
                <div class="col-md-3"><?php echo $this->Form->input('incometax_number', array('label' => __('Income Tax Number'))); ?></div>
                <div class="col-md-3"><?php echo $this->Form->input('ssi_registration_number', array('label' => __('SSI Registration Number'))); ?></div>

                <div class="col-md-6"><?php echo $this->Form->input('range_of_products', array('label' => __('Range of Products'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('services_offered', array('label' => __('Services Offered'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('existing_facilities', array('label' => __('Existing Facilities'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('prominent_customers', array('label' => __('Prominent Customers'))); ?></div>

                <div class="col-md-12"><hr /></div>

                <div class="col-md-12">
                    <?php echo $this->Form->input('quality_assurence', array('label' => __('Quality Assurance'))); ?>
                    <span class="help-block">Quality Assurance Setup (Only for SSI units). You can upload organisation structure after saving this record.</span>
                </div>
                <div class="col-md-6"><?php echo $this->Form->input('facility_comments', array('label' => __('Facility Comments'))); ?>
                    <span class="help-block">If visit is necessary for manufacturing facilities mention visit details above</span>
                </div>

                <div class="col-md-6"><?php echo $this->Form->input('supplier_representative', array('label' => __('Supplier Representative'))); ?>
                    <span class="help-block">If Supplier's representative's visit is necessary to office then mention visit details above</span>
                </div>

                <div class="col-md-6"><?php echo $this->Form->input('trial_order', array('label' => __('Trial Order'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('order_date', array('label' => __('Order Date'))); ?></div>
            </div>
            <div class="row">
                <div class="col-md-12"><hr /></div>
                <div class="col-md-12 text-primary">
                    <h5>
                        <?php echo __("If the trial order result is satisfactory click YES from below.Supplier Selected as YES will be added to List of Acceptable Supplier's List"); ?>
                    </h5>
                </div>
                <div class="col-md-6">
                    <?php
                    $options = array(0 => 'No', 1 => 'Yes', 2 => 'On Hold');
                    echo $this->Form->input('supplier_selected', array('options' => $options, 'default'=>$this->request->data['SupplierRegistration']['supplier_selected'], 'label' => __('Is supplier selected as Acceptable Supplier ?')));
                    ?>
                </div>
                <div class="col-md-6">
                    <?php echo $this->Form->input('supplier_category_id', array('label' => __('Select Category'))); ?>
                </div>
                <div class="col-md-12">
                    <?php echo $this->Form->input('remarks', array('label' => __('Remarks'),'value'=>$this->request->data['SupplierRegistration']['remarks'])); ?>
                </div>

            </div>
            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => 'Publish'));
                }
            ?>
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>
        </div>

    <?php if ($this->data['SupplierRegistration']['contact_person_work'] == '') { ?>
        <script>$("#factory_details").find("input,textarea,button,select").prop("disabled", true);</script>
    <?php } ?>
<script>
    $("[name*='date']").datetimepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        'showTimepicker': false,
    }).attr('readonly', 'readonly');
</script>

        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>

    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#supplierRegistrations_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

