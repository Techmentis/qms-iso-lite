<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="supplierEvaluationReevaluations ">

<script type="text/javascript">
    $(document).ready(function() {
        $('table th a, .pag_list li span a').on('click', function() {
            var url = $(this).attr("href");
            $('#main').load(url);
            return false;
        });
    });
</script>
<script>
    $().ready(function() {
        $("#SupplierEvaluationReevaluationSupplierRegistrationId").change(function() {
            $("#main").load(
                    "supplier_evaluation_reevaluations/evaluate/" + $("#SupplierEvaluationReevaluationSupplierRegistrationId").val())
        })
    });
</script>

        <div class="panel panel-default from add_ajax">
            <div class="row">
                <div class="col-md-6">
                    <?php
                        echo $this->Form->create('SupplierEvaluationReevaluation', array('role' => 'from', 'class' => 'from'));
                        echo $this->Form->input('supplier_registration_id', array('label' => __('Select Supplier from the list to evaluate.'), 'default' => $supplier_registration_id));
                        echo $this->Form->end();
                    ?>
                </div>
                <div class="col-md-6"></div>
            </div>
        </div>

        <?php if ($this->request->params['pass'][0]) { ?>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="pane-title"><h4>Supplier Information
                            <?php echo $this->Html->link('View Full Details', array('controller' => 'supplier_registrations', 'action' => 'view', $supplierRegistration['SupplierRegistration']['id']), array('target' => '_blank', 'class' => 'label btn-sm btn-info')); ?></h4>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class=" col-md-6">
                            <table class="table table-responsive">
                                <tr><td><?php echo __('Title'); ?></td>
                                    <td>
                                        <?php echo $supplierRegistration['SupplierRegistration']['title']; ?>
                                        &nbsp;
                                    </td></tr>
                                <tr><td><?php echo __('Number'); ?></td>
                                    <td>
                                        <?php echo $supplierRegistration['SupplierRegistration']['number']; ?>
                                        &nbsp;
                                    </td></tr>
                                <tr><td><?php echo __('Type Of Company'); ?></td>
                                    <td>
                                        <?php echo $supplierRegistration['SupplierRegistration']['type_of_company']; ?>
                                        &nbsp;
                                    </td></tr>
                                <tr><td><?php echo __('Contact Person Office'); ?></td>
                                    <td>
                                        <?php echo $supplierRegistration['SupplierRegistration']['contact_person_office']; ?>
                                        &nbsp;
                                    </td></tr>
                            </table>
                        </div>
                        <div class=" col-md-6">
                            <table class="table table-responsive">

                                <tr><td><?php echo __('Office Telephone'); ?></td>
                                    <td>
                                        <?php echo $supplierRegistration['SupplierRegistration']['office_telephone']; ?>
                                        &nbsp;
                                    </td></tr>
                                <tr><td><?php echo __('Work Telephone'); ?></td>
                                    <td>
                                        <?php echo $supplierRegistration['SupplierRegistration']['work_telephone']; ?>
                                        &nbsp;
                                    </td></tr>
                                <tr><td><?php echo __('Office Fax'); ?></td>
                                    <td>
                                        <?php echo $supplierRegistration['SupplierRegistration']['office_fax']; ?>
                                        &nbsp;
                                    </td></tr>
                                <tr><td><?php echo __('Publish'); ?></td>
                                    <td>
                                        <?php if ($supplierRegistration['SupplierRegistration']['publish'] == 1) { ?>
                                            <span class="glyphicon glyphicon-ok-sign"></span>
                                        <?php } else { ?>
                                            <span class="glyphicon glyphicon-remove-circle"></span>
                                        <?php } ?>&nbsp;</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($hasData == true) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php if ($accepted * 100 / $supplied > 98) { ?><div class="alert alert-success"> <?php } ?>
                            <?php if ($accepted * 100 / $supplied < 98 && $accepted * 100 / $supplied > 90) { ?><div class="alert alert-warning"> <?php } ?>
                                <?php if ($accepted * 100 / $supplied < 90) { ?><div class="alert alert-danger"> <?php } ?>
                                    <div class="row">
                                        <div class="col-md-5"><h3>Total Number Of Goods Supplied : <?php echo $supplied ?> </h3></div>
                                        <div class="col-md-5"><h3>Total Number Of Goods Accepted : <?php echo $accepted ?> </h3></div>
                                        <div class="col-md-2">
                                            <?php if ($accepted * 100 / $supplied > 98) { ?><div class="badge btn-success"> <?php } ?>
                                                <?php if ($accepted * 100 / $supplied < 98 && $accepted * 100 / $supplied > 90) { ?><div class="badge btn-warning"> <?php } ?>
                                                    <?php if ($accepted * 100 / $supplied < 90) { ?><div class="badge btn-danger"><?php } ?>
                                                        <h1 style="margin-top: 10px">
                                                            <?php echo round($accepted * 100 / $supplied) ?>%
                                                        </h1>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5"><h5>Total Number Of Challans : <?php echo $challanCount ?></h5></div>
                                                <div class="col-md-5"><h5>Delay in delivery :<?php echo $dateCount ?> (times)</h5></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php echo $this->Html->script(array('googlechart.min')); ?>

<script>
    google.load("visualization", "1", {packages: ["corechart"], callback: drawChart});


    function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo $data ?>);

        var options = {
            title: '',
            hAxis: {title: 'Challan Dates', titleTextStyle: {color: '#333'}},
            vAxis: {title: 'Quantity', minValue: 0},
            colors: ['#5BC0DE', '#f0ad4e'],
        };

        var chart = new google.visualization.AreaChart(document.getElementById('branch_chart_div'));
        chart.draw(data, options);
    }

</script>

                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <div class="pane-title"><h4>Supplier Quantity Supplied / Quantity Accepted Chart (Challan-wise)</h4></div>
                                    </div>
                                    <div class="panel-body">

                                        <div id="branch_chart_div" style="width: 100%; height: 400px;"></div>
                                    </div>
                                </div>
                            </div>

                        <?php } else { ?>
                            <div class="alert alert-danger">
                                <h4>No data found for evaluation </h4>
                                <p>To evaluate any supplier, system requires Purchase Orders, Delivery Challas as well as information regarding Quantity Orderd, Quantity Supplier, Quantity Accepted and delivery delays if any.</p>
                                <p>Based on your entries in Purchase Orders and Delivery Challas, system automatically adds you supplier's details, challan details & purchase order details in Evaluation Table.</p>
                                <p>You will need to then add, Accepted Quantity manually.</p>
                                <p>Based of that graph will be generated which would enable you to evaluate and add each supplier to correct categories.</p>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title"><h4>Evaluate</h4></div>
                        </div>
                        <div class="panel-body" id="evaluate">

<script>
    $.validator.setDefaults({
        ignore: null,
        errorPlacement: function(error, element) {
            if ($(element).attr('name') == 'data[ListOfAcceptableSupplier][supplier_registration_id]' ||
                    $(element).attr('name') == 'data[ListOfAcceptableSupplier][supplier_category_id]') {
                $(element).next().after(error);
            } else {
                $(element).after(error);
            }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                url: "<?php echo Router::url('/', true); ?>list_of_acceptabe_suppliers/add/<?php echo $supplierRegistration['SupplierRegistration']['id'] ?>",
		type: 'POST',
		target: '#evaluate',
		error: function(request, status, error) {
		    //alert(request.responseText);
		    alert('Action failed!');
		}
	    });
	}
    });

    $().ready(function() {
	jQuery.validator.addMethod("greaterThanZero", function(value, element) {
	    return this.optional(element) || (parseFloat(value) > 0);
	}, "Please select the value");

	$('#ListOfAcceptableSupplierAddAjaxForm').validate({
	    rules: {
		"data[ListOfAcceptableSupplier][supplier_registration_id]": {
		    greaterThanZero: true,
		},
		"data[ListOfAcceptableSupplier][supplier_category_id]": {
		    greaterThanZero: true,
		},
	    }
	});
	$('#ListOfAcceptableSupplierSupplierRegistrationId').change(function() {
	    if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
		$(this).next().next('label').remove();
	    }
	});
	$('#ListOfAcceptableSupplierSupplierCategoryId').change(function() {
	    if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
		$(this).next().next('label').remove();
	    }
	});
    });
</script>

                            <div id="listOfAcceptableSuppliers_ajax">
                                <?php echo $this->Session->flash(); ?>
                                <div class="nav">
                                    <div class="listOfAcceptableSuppliers form col-md-8">
                                        <h4><?php echo __('Add List Of Acceptable Supplier'); ?></h4>
                                        <?php echo $this->Form->create('ListOfAcceptableSupplier', array('controller' => 'list_of_acceptabe_suppliers', 'action' => 'add', $supplierRegistration['SupplierRegistration']['id']), array('role' => 'form', 'class' => 'form', 'default' => true)); ?>

                                        <div class="row">
                                            <?php echo $this->Form->hidden('supplier_registration_id', array('value' => $supplierRegistration['SupplierRegistration']['id'])); ?>
                                            <div class="col-md-12"><?php echo $this->Form->input('supplier_category_id', array('style' => 'width:100%', 'label' => __('Supplier Category'))); ?></div>
                                            <div class="col-md-12"><?php echo $this->Form->input('remarks', array('label' => __('Remarks'))); ?></div>
                                            <?php echo $this->Form->input('employee_id', array('type' => 'hidden', 'value' => $this->Session->read('User.employee_id'))); ?>
                                            <?php echo $this->Form->input('branchid', array('type' => 'hidden', 'value' => $this->Session->read('User.branch_id'))); ?>
                                            <?php echo $this->Form->input('departmentid', array('type' => 'hidden', 'value' => $this->Session->read('User.department_id'))); ?>
                                            <div class="col-md-6"><?php echo $this->Form->input('approved_by',array('type'=>'select','options'=>$PublishedEmployeeList,'default'=>$this->Session->read('User.employee_id')));?></div>
                                            <div class="col-md-6"><?php echo $this->Form->input('prepared_by',array('type'=>'select','options'=>$PublishedEmployeeList));?></div>
                                        </div>
                                        <?php echo $this->Form->input('publish', array('label' => __('Publish')));?><br/><br/>
                                        <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#listOfAcceptableSuppliers_ajax', 'async' => 'false')); ?>
                                        <?php echo $this->Form->end(); ?>
                                        <?php echo $this->Js->writeBuffer(); ?>

                                    </div>
                                    <div class="col-md-4">
                                        <p><?php echo $this->element('helps'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } else { ?>

<script>
    $().ready(function() {
        $("#SupplierEvaluationReevaluationSupplierRegistrationId").change(function() {
            $("#main").load('supplier_evaluation_reevaluations/index/' + $("#SupplierEvaluationReevaluationSupplierRegistrationId").val())
        })
    });
</script>

                <div class="panel panel-default from">
                    <?php
                        echo $this->Form->create('SupplierEvaluationReevaluation', '#', array('role' => 'from', 'class' => 'from'));
                        echo $this->Form->input('supplier_registration_id');
                        echo $this->Form->submit('Submit');
                        echo $this->Form->end();
                    ?>
                </div>

            <?php } ?>
            <?php echo $this->element('export'); ?>
            <?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "delivery_challan_id" => "Delivery Challan No", "challan_date" => "Challan Date", "quantity_supplied" => "Quantity Supplied", "quantity_accepted" => "Quantity Accepted", "required_delivery_date" => "Required Delivery Date", "actual_delivery_datedate" => "Actual Delivery Date", "remarks" => "Remarks"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
            <?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "delivery_challan_id" => "Delivery Challan No", "challan_date" => "Challan Date", "quantity_supplied" => "Quantity Supplied", "quantity_accepted" => "Quantity Accepted", "required_delivery_date" => "Required Delivery Date", "actual_delivery_datedate" => "Actual Delivery Date", "remarks" => "Remarks"))); ?>
            <?php echo $this->element('approvals'); ?>
            <?php echo $this->element('common'); ?>
        </div>
        <?php echo $this->Js->writeBuffer(); ?>
    </div>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>