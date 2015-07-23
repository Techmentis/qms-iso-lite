<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>

<script>
    $.validator.setDefaults({
    ignore: null,
            errorPlacement: function(error, element) {
                if ($(element).attr('name') == 'data[CorrectivePreventiveAction][capa_source_id]'){
                    $(element).next().after(error);
                } else if ($(element).attr('name') == 'data[CorrectivePreventiveAction][capa_category_id]') {
                    $(element).next().after(error);
                } else if ($(element).attr('name') == 'data[CorrectivePreventiveAction][suggestion_form_id]') {
                    $(element).next().after(error);
                } else if ($(element).attr('name') == 'data[CorrectivePreventiveAction][customer_complaint_id]') {
                    $(element).next().after(error);
                } else if ($(element).attr('name') == 'data[CorrectivePreventiveAction][supplier_registration_id]') {
                    $(element).next().after(error);
                } else if ($(element).attr('name') == 'data[CorrectivePreventiveAction][product_id]') {
                    $(element).next().after(error);
                } else if ($(element).attr('name') == 'data[CorrectivePreventiveAction][device_id]') {
                    $(element).next().after(error);
                } else if ($(element).attr('name') == 'data[CorrectivePreventiveAction][material_id]') {
                    $(element).next().after(error);
                } else if ($(element).attr('name') == 'data[CorrectivePreventiveAction][internal_audit_id]') {
                    $(element).next().after(error);
                } else  if ($(element).attr('name') == 'data[CorrectivePreventiveAction][closed_by]') {
                $(element).next().after(error);
                } else  if ($(element).attr('name') == 'data[CorrectivePreventiveAction][closed_on_date]') {
                $(element).next().after(error);
                } else  if ($(element).attr('name') == 'data[CorrectivePreventiveAction][master_list_of_format]') {
		    $(element).next().after(error);
                }else{
                    $(element).after(error);
                }
            }
    });

    $().ready(function() {
            $("#submit-indicator").hide();
	    $("#submit_id").click(function(){
	    if($('#CorrectivePreventiveActionApproveForm').valid()){
		$("#submit_id").prop("disabled",true);
		$("#submit-indicator").show();
		$("#CorrectivePreventiveActionApproveForm").submit();
	    }
        });

        jQuery.validator.addMethod("greaterThanZero", function(value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");
        $('#CorrectivePreventiveActionApproveForm').validate({
            rules: {
                "data[CorrectivePreventiveAction][capa_source_id]" : {
                    greaterThanZero:true,
                },
                "data[CorrectivePreventiveAction][capa_category_id]" : {
                    greaterThanZero:true,
                },
                <?php if ($this->request->data['CorrectivePreventiveAction']['capa_category_id'] == "5245a8fc-8f4c-4ab5-ab27-41f2c6c3268c") { ?>
                    "data[CorrectivePreventiveAction][internal_audit_id]" : {
                    greaterThanZero:true,
                },
                <?php } elseif ($this->request->data['CorrectivePreventiveAction']['capa_category_id'] == "5245a90d-1f4c-4693-9853-41ebc6c3268c") { ?>
                    "data[CorrectivePreventiveAction][suggestion_form_id]" : {
                        greaterThanZero:true,
                    },
                <?php } elseif ($this->request->data['CorrectivePreventiveAction']['capa_category_id'] == "5245a935-7f58-482c-83c5-41f1c6c3268c") { ?>
                    "data[CorrectivePreventiveAction][customer_complaint_id]" : {
                        greaterThanZero:true,
                    },
                <?php } elseif ($this->request->data['CorrectivePreventiveAction']['capa_category_id'] == "5245a95b-1340-4531-8d4a-4151c6c3268c") { ?>
                    "data[CorrectivePreventiveAction][supplier_registration_id]" : {
                        greaterThanZero:true,
                    },
                <?php } elseif ($this->request->data['CorrectivePreventiveAction']['capa_category_id'] == "528fcdd7-63ec-497e-b4f3-01e5c6c3268c") { ?>
                    "data[CorrectivePreventiveAction][product_id]" : {
                        greaterThanZero:true,
                    },
                <?php } elseif ($this->request->data['CorrectivePreventiveAction']['capa_category_id'] == "528fcdd7-63ec-497e-b4f3-01e5c6c3268c") { ?>
                    "data[CorrectivePreventiveAction][device_id]" : {
                        greaterThanZero:true,
                    },
                <?php } elseif ($this->request->data['CorrectivePreventiveAction']['capa_category_id'] == "53200cde-bb2c-4236-be8c-f90d51f38a45") { ?>
                    "data[CorrectivePreventiveAction][material_id]" : {
                        greaterThanZero:true,
                    }
                <?php } ?>
            }
        });

        if ($('#CorrectivePreventiveActionCapaCategoryId').val() == "5245a8fc-8f4c-4ab5-ab27-41f2c6c3268c") {
                $("#audit").show();
                $("#CorrectivePreventiveActionInternalAuditId").rules("add", {greaterThanZero: true});
                $("#CorrectivePreventiveActionInternalAuditId_chosen").width('340px');
                $("#suggestion").hide();
                $("#complaint").hide();
                $("#supplier").hide();
                $("#product").hide();
                $("#device").hide();
                $("#material").hide();
                $('#CorrectivePreventiveActionMaterialId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSuggestionFormId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionCustomerComplaintId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSupplierRegistrationId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionProductId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionDeviceId').val(0).trigger('chosen:updated').rules('remove');
            } else if ($('#CorrectivePreventiveActionCapaCategoryId').val() == "5245a90d-1f4c-4693-9853-41ebc6c3268c") {
                $("#suggestion").show();
                $("#CorrectivePreventiveActionSuggestionFormId").rules("add", {greaterThanZero: true});
                $("#CorrectivePreventiveActionSuggestionFormId_chosen").width('340px');
                $("#audit").hide();
                $("#complaint").hide();
                $("#supplier").hide();
                $("#product").hide();
                $("#device").hide();
                $("#material").hide();
                $('#CorrectivePreventiveActionMaterialId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionInternalAuditId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionCustomerComplaintId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSupplierRegistrationId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionProductId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionDeviceId').val(0).trigger('chosen:updated').rules('remove');
            } else if ($('#CorrectivePreventiveActionCapaCategoryId').val() == "5245a935-7f58-482c-83c5-41f1c6c3268c") {
                $("#complaint").show();
                $("#CorrectivePreventiveActionCustomerComplaintId").rules("add", {greaterThanZero: true});
                $("#CorrectivePreventiveActionCustomerComplaintId_chosen").width('340px');
                $("#suggestion").hide();
                $("#audit").hide();
                $("#supplier").hide();
                $("#product").hide();
                $("#device").hide();
                $("#material").hide();
                $('#CorrectivePreventiveActionMaterialId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionInternalAuditId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSuggestionFormId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSupplierRegistrationId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionProductId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionDeviceId').val(0).trigger('chosen:updated').rules('remove');
            } else if ($('#CorrectivePreventiveActionCapaCategoryId').val() == "5245a95b-1340-4531-8d4a-4151c6c3268c") {
                $("#supplier").show();
                $("#CorrectivePreventiveActionSupplierRegistrationId").rules("add", {greaterThanZero: true});
                $("#CorrectivePreventiveActionSupplierRegistrationId_chosen").width('340px');
                $("#suggestion").hide();
                $("#audit").hide();
                $("#complaint").hide();
                $("#product").hide();
                $("#device").hide();
                $("#material").hide();
                $('#CorrectivePreventiveActionMaterialId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionInternalAuditId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSuggestionFormId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionCustomerComplaintId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionProductId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionDeviceId').val(0).trigger('chosen:updated').rules('remove');
            } else if ($('#CorrectivePreventiveActionCapaCategoryId').val() == "528fcdd7-63ec-497e-b4f3-01e5c6c3268c") {
                $("#product").show();
                $("#CorrectivePreventiveActionProductId").rules("add", {greaterThanZero: true});
                $("#CorrectivePreventiveActionProductId_chosen").width('340px');
                $("#suggestion").hide();
                $("#audit").hide();
                $("#complaint").hide();
                $("#supplier").hide();
                $("#device").hide();
                $("#material").hide();
                $('#CorrectivePreventiveActionMaterialId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionInternalAuditId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSuggestionFormId').val(0).trigger('chosen:updated').rules('remove'); ;
                $('#CorrectivePreventiveActionCustomerComplaintId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSupplierRegistrationId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionDeviceId').val(0).trigger('chosen:updated').rules('remove');
            } else if ($('#CorrectivePreventiveActionCapaCategoryId').val() == "533e94b8-7b70-4fad-bcdd-1a3a51f38a45") {
                $("#device").show();
                $("#CorrectivePreventiveActionDeviceId").rules("add", {greaterThanZero: true});
                $("#CorrectivePreventiveActionDeviceId_chosen").width('340px');
                $("#suggestion").hide();
                $("#audit").hide();
                $("#complaint").hide();
                $("#supplier").hide();
                $("#product").hide();
                $("#material").hide();
                $('#CorrectivePreventiveActionMaterialId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionInternalAuditId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSuggestionFormId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionCustomerComplaintId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSupplierRegistrationId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionProductId').val(0).trigger('chosen:updated').rules('remove');
            } else if ($('#CorrectivePreventiveActionCapaCategoryId').val() == "53200cde-bb2c-4236-be8c-f90d51f38a45") {
                $("#material").show();
                $("#CorrectivePreventiveActionMaterialId").rules("add", {greaterThanZero: true});
                $("#CorrectivePreventiveActionMaterialId_chosen").width('340px');
                $("#suggestion").hide();
                $("#audit").hide();
                $("#complaint").hide();
                $("#supplier").hide();
                $("#product").hide();
                $("#device").hide();
                $('#CorrectivePreventiveActionInternalAuditId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSuggestionFormId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionCustomerComplaintId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSupplierRegistrationId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionProductId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionDeviceId').val(0).trigger('chosen:updated').rules('remove');
            } else {
                $("#material").hide();
                $("#suggestion").hide();
                $("#audit").hide();
                $("#complaint").hide();
                $("#supplier").hide();
                $("#product").hide();
                $("#device").hide();
                $('#CorrectivePreventiveActionMaterialId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionInternalAuditId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSuggestionFormId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionCustomerComplaintId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSupplierRegistrationId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionProductId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionDeviceId').val(0).trigger('chosen:updated').rules('remove');
            }
        $('#CorrectivePreventiveActionCapaSourceId').change(function () {
            if ($(this).val() != - 1 && $(this).next().next('label').hasClass("error")){
                $(this).next().next('label').remove();
            }
        });
        $('#CorrectivePreventiveActionCapaCategoryId').change(function () {
            if ($(this).val() != - 1 && $(this).next().next('label').hasClass("error")){
                $(this).next().next('label').remove();
            }
        });
        $('#CorrectivePreventiveActionProductId').change(function () {
            if ($(this).val() != - 1 && $(this).next().next('label').hasClass("error")){
                $(this).next().next('label').remove();
            }
        });
        $('#CorrectivePreventiveActionInternalAuditId').change(function () {
            if ($(this).val() != - 1 && $(this).next().next('label').hasClass("error")){
                $(this).next().next('label').remove();
            }
        });
        $('#CorrectivePreventiveActionSuggestionFormId').change(function () {
            if ($(this).val() != - 1 && $(this).next().next('label').hasClass("error")){
                $(this).next().next('label').remove();
            }
        });
        $('#CorrectivePreventiveActionCustomerComplaintId').change(function () {
            if ($(this).val() != - 1 && $(this).next().next('label').hasClass("error")){
                $(this).next().next('label').remove();
            }
        });
        $('#CorrectivePreventiveActionSupplierRegistrationId').change(function () {
            if ($(this).val() != - 1 && $(this).next().next('label').hasClass("error")){
                $(this).next().next('label').remove();
            }
        });
        $('#CorrectivePreventiveActionDeviceId').change(function () {
            if ($(this).val() != - 1 && $(this).next().next('label').hasClass("error")){
                $(this).next().next('label').remove();
            }
        });
        $('#CorrectivePreventiveActionMaterialId').change(function () {
            if ($(this).val() != - 1 && $(this).next().next('label').hasClass("error")){
                $(this).next().next('label').remove();
            }
        });
        $('#CorrectivePreventiveActionMasterListOfFormat').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });
        $('#CorrectivePreventiveActionClosedBy').change(function () {
            if ($(this).val() != -1 && $(this).next().next('label').hasClass("error")) {
                $(this).next().next('label').remove();
            }
        });

	$("[name='data[CorrectivePreventiveAction][document_changes_required]']").click(function(){
	    docChangeRequired();
	});
        handleUserTermsChange();
        currentStatus();
        docChangeRequired();
        $('#CorrectivePreventiveActionCapaCategoryId').change(function(){
            if ($('#CorrectivePreventiveActionCapaCategoryId').val() == "5245a8fc-8f4c-4ab5-ab27-41f2c6c3268c") {
                $("#audit").show();
                $("#CorrectivePreventiveActionInternalAuditId").rules("add", {greaterThanZero: true});
                $("#CorrectivePreventiveActionInternalAuditId_chosen").width('340px');
                $("#suggestion").hide();
                $("#complaint").hide();
                $("#supplier").hide();
                $("#product").hide();
                $("#device").hide();
                $("#material").hide();
                $('#CorrectivePreventiveActionMaterialId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSuggestionFormId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionCustomerComplaintId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSupplierRegistrationId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionProductId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionDeviceId').val(0).trigger('chosen:updated').rules('remove');
            } else if ($('#CorrectivePreventiveActionCapaCategoryId').val() == "5245a90d-1f4c-4693-9853-41ebc6c3268c") {
                $("#suggestion").show();
            	$("#CorrectivePreventiveActionSuggestionFormId").rules("add", {greaterThanZero: true});
                $("#CorrectivePreventiveActionSuggestionFormId_chosen").width('340px');
                $("#audit").hide();
                $("#complaint").hide();
                $("#supplier").hide();
                $("#product").hide();
                $("#device").hide();
                $("#material").hide();
                $('#CorrectivePreventiveActionMaterialId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionInternalAuditId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionCustomerComplaintId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSupplierRegistrationId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionProductId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionDeviceId').val(0).trigger('chosen:updated').rules('remove');
	    } else if ($('#CorrectivePreventiveActionCapaCategoryId').val() == "5245a935-7f58-482c-83c5-41f1c6c3268c") {
                $("#complaint").show();
            	$("#CorrectivePreventiveActionCustomerComplaintId").rules("add", {greaterThanZero: true});
                $("#CorrectivePreventiveActionCustomerComplaintId_chosen").width('340px');
                $("#suggestion").hide();
                $("#audit").hide();
                $("#supplier").hide();
                $("#product").hide();
                $("#device").hide();
                $("#material").hide();
                $('#CorrectivePreventiveActionMaterialId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionInternalAuditId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSuggestionFormId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSupplierRegistrationId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionProductId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionDeviceId').val(0).trigger('chosen:updated').rules('remove');
	    } else if ($('#CorrectivePreventiveActionCapaCategoryId').val() == "5245a95b-1340-4531-8d4a-4151c6c3268c") {
                $("#supplier").show();
            	$("#CorrectivePreventiveActionSupplierRegistrationId").rules("add", {greaterThanZero: true});
                $("#CorrectivePreventiveActionSupplierRegistrationId_chosen").width('340px');
                $("#suggestion").hide();
                $("#audit").hide();
                $("#complaint").hide();
                $("#product").hide();
                $("#device").hide();
                $("#material").hide();
                $('#CorrectivePreventiveActionMaterialId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionInternalAuditId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSuggestionFormId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionCustomerComplaintId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionProductId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionDeviceId').val(0).trigger('chosen:updated').rules('remove');
	    } else if ($('#CorrectivePreventiveActionCapaCategoryId').val() == "528fcdd7-63ec-497e-b4f3-01e5c6c3268c") {
                $("#product").show();
            	$("#CorrectivePreventiveActionProductId").rules("add", {greaterThanZero: true});
                $("#CorrectivePreventiveActionProductId_chosen").width('340px');
                $("#suggestion").hide();
                $("#audit").hide();
                $("#complaint").hide();
                $("#supplier").hide();
                $("#device").hide();
                $("#material").hide();
                $('#CorrectivePreventiveActionMaterialId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionInternalAuditId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSuggestionFormId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionCustomerComplaintId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSupplierRegistrationId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionDeviceId').val(0).trigger('chosen:updated').rules('remove');
	    } else if ($('#CorrectivePreventiveActionCapaCategoryId').val() == "533e94b8-7b70-4fad-bcdd-1a3a51f38a45") {
                $("#device").show();
            	$("#CorrectivePreventiveActionDeviceId").rules("add", {greaterThanZero: true});
                $("#CorrectivePreventiveActionDeviceId_chosen").width('340px');
                $("#suggestion").hide();
                $("#audit").hide();
                $("#complaint").hide();
                $("#supplier").hide();
                $("#product").hide();
                $("#material").hide();
                $('#CorrectivePreventiveActionMaterialId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionInternalAuditId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSuggestionFormId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionCustomerComplaintId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSupplierRegistrationId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionProductId').val(0).trigger('chosen:updated').rules('remove');
            } else if ($('#CorrectivePreventiveActionCapaCategoryId').val() == "53200cde-bb2c-4236-be8c-f90d51f38a45") {
                $("#material").show();
            	$("#CorrectivePreventiveActionMaterialId").rules("add", {greaterThanZero: true});
                $("#CorrectivePreventiveActionMaterialId_chosen").width('340px');
                $("#suggestion").hide();
                $("#audit").hide();
                $("#complaint").hide();
                $("#supplier").hide();
                $("#product").hide();
                $("#device").hide();
                $('#CorrectivePreventiveActionInternalAuditId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSuggestionFormId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionCustomerComplaintId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSupplierRegistrationId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionProductId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionDeviceId').val(0).trigger('chosen:updated').rules('remove');
	    } else {
                $("#material").hide();
                $("#suggestion").hide();
                $("#audit").hide();
                $("#complaint").hide();
                $("#supplier").hide();
                $("#product").hide();
                $("#device").hide();
                $('#CorrectivePreventiveActionMaterialId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionInternalAuditId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSuggestionFormId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionCustomerComplaintId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionSupplierRegistrationId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionProductId').val(0).trigger('chosen:updated').rules('remove');
                $('#CorrectivePreventiveActionDeviceId').val(0).trigger('chosen:updated').rules('remove');
            }
        });
    });
    function currentStatus() {
	var status = $("[name='data[CorrectivePreventiveAction][current_status]']:checked").val();
	if (status == 1) {
	    $('#CorrectivePreventiveActionClosedBy').prop('disabled',false).trigger('chosen:updated');
	    $('#CorrectivePreventiveActionClosedOnDate').prop('disabled', false);
	    $('#CorrectivePreventiveActionClosedBy').rules('add', { greaterThanZero: true});
	    $('#CorrectivePreventiveActionClosedOnDate').rules('add', { required: true, number: false});
	    $("#statusCloseDetails").find("input,textarea,button,select,div").prop("disabled", false);
	    $("#statusCloseDetails").find("select").prop("disabled", false).trigger('chosen:updated');
	} else if (status == 0) {
	    $('#CorrectivePreventiveActionClosedBy').next().next('label').remove();
	    $('#CorrectivePreventiveActionClosedBy').prop('disabled',true).trigger('chosen:updated');
	    $('#CorrectivePreventiveActionClosedOnDate').next('label').remove();
	    $('#CorrectivePreventiveActionClosedOnDate').prop('disabled', true);
	    $('#CorrectivePreventiveActionClosedBy').rules('remove');
	    $('#CorrectivePreventiveActionClosedBy').val('-1').trigger('chosen:updated');
	    $('#CorrectivePreventiveActionClosedOnDate').rules('remove');
	    $('#CorrectivePreventiveActionClosedOnDate').val('');
	    $("#statusCloseDetails").find("input,textarea,button,select,div").prop("disabled", true);
	    $("#statusCloseDetails").find("input,textarea,button,select,div").val('');
	    $("#statusCloseDetails").find("select").prop("disabled", true).trigger('chosen:updated');
        }
    }

    function docChangeRequired(){
	var changeRequired = $("[name='data[CorrectivePreventiveAction][document_changes_required]']").is(':checked');
	if(changeRequired == true){
	    $("#docChangeReq").show();
	    $("#CorrectivePreventiveActionMasterListOfFormat_chosen").width('100%');
	    $("#CorrectivePreventiveActionMasterListOfFormat").rules('add', {greaterThanZero: true});
	    $("#CorrectivePreventiveActionCurrentDocumentDetails").rules('add', {required: true});
	    $("#CorrectivePreventiveActionRequestDetails").rules('add', {required: true});
	    $("#CorrectivePreventiveActionProposedChanges").rules('add', {required: true});
	    $("#CorrectivePreventiveActionReasonForChange").rules('add', {required: true});
	    $("#docChangeReq").find("select").prop("disabled", false).trigger('chosen:updated');
	    $("[name='data[CorrectivePreventiveAction][document_changes_required]']").val(1);
	} else {
	    $("#docChangeReq").hide();
	    $("#docChangeReq").find("input, textarea, select, button, select, div").val("");
	    $("#docChangeReq").find("select").prop("disabled", true).trigger('chosen:updated');
	    $("[name='data[CorrectivePreventiveAction][document_changes_required]']").val(0);

	    $("#CorrectivePreventiveActionMasterListOfFormat").rules('remove');
	    $("#CorrectivePreventiveActionCurrentDocumentDetails").rules("remove");
	    $("#CorrectivePreventiveActionRequestDetails").rules('remove');
	    $("#CorrectivePreventiveActionProposedChanges").rules('remove');
	    $("#CorrectivePreventiveActionReasonForChange").rules('remove');

	    $("#CorrectivePreventiveActionMasterListOfFormat").next().next('label').remove();
	    $("#CorrectivePreventiveActionRequestDetails").next('label').remove();
	    $("#CorrectivePreventiveActionProposedChanges").next('label').remove();
	    $("#CorrectivePreventiveActionReasonForChange").next('label').remove();
	    $("#CorrectivePreventiveActionCurrentDocumentDetails").next('label').remove();
	}
    }
    function handleUserTermsChange() {
        var $userTerms = $('#CorrectivePreventiveActionRootCauseAnalysisRequired');
        $userTerms.bind('change', function () {
            if ($userTerms.is(':checked')) {
                $("#root_cause_div").find("input,textarea,button,select").prop("disabled", false);
                $("#root_cause_div").find("select").prop("disabled", false).trigger('chosen:updated');
            } else {
                $("#root_cause_div").find("input,textarea,button, select, div").prop("disabled", true);
                $("#root_cause_div").find("input,textarea,button,select,div").val("");
		        $("#root_cause_div").find("select").prop("disabled", true).trigger('chosen:updated');
            }
        }).trigger('change');
    }
</script>
<div id="correctivePreventiveActions_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="correctivePreventiveActions form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('Approve Corrective Preventive Action'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'lists'), array('id' => 'list', 'class' => 'label btn-info')); ?>
            </h4>

            <?php echo $this->Form->create('CorrectivePreventiveAction', array('role' => 'form', 'class' => 'form')); ?>
            <?php echo $this->Form->input('id'); ?>
            <?php echo $this->Form->hidden('change_addition_deletion_request_id'); ?>

            <div class="row">
                <legend><?php echo __('Step - 1'); ?></legend>
                <div class="col-md-12">
                    <?php
                        echo "<label>" . __('Select Action') . "</label>";
                        echo $this->Form->input('capa_type', array('label' => false, 'legend' => false, 'value' => false, 'div' => false, 'options' => array('0' => 'Corrective Action', '1' => 'Preventive Action', '2' => 'Both'), 'type' => 'radio', 'value' => $this->request->data['CorrectivePreventiveAction']['capa_type'], 'style' => 'float:none'));
                    ?>
                </div>
                <div class="col-md-6"><?php echo $this->Form->input('name', array('label' => __('Name'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('number', array('label' => __('Number'))); ?></div>
            </div>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('capa_source_id', array('style' => 'width:100%', 'label' => __('CAPA Source'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('capa_category_id', array('style' => 'width:100%', 'label' => __('CAPA Category'))); ?></div>
            </div>
            <div class="row">
                <div id="get_details">
                    <div id="audit" <?php if ($this->data['CorrectivePreventiveAction']['internal_audit_id'] == '-1' || $this->data['CorrectivePreventiveAction']['internal_audit_id'] == NULL) { ?>style="display: none"<?php } ?>>
                        <div class="col-md-6"><?php echo $this->Form->input('internal_audit_id', array('style' => 'width:100%', 'label' => __('Select Internal Audit'))); ?></div>
                    </div>
                    <div id="suggestion" <?php if ($this->data['CorrectivePreventiveAction']['Suggestion_form_id'] == '-1' || $this->data['CorrectivePreventiveAction']['suggestion_form_id'] == NULL) { ?>style="display: none"<?php } ?>>
                        <div class="col-md-6"><?php echo $this->Form->input('suggestion_form_id', array('style' => 'width:100%', 'label' => __('Select Suggestion Form'))); ?></div>
                    </div>
                    <div id="complaint" <?php if ($this->data['CorrectivePreventiveAction']['customer_complaint_id'] == '-1' || $this->data['CorrectivePreventiveAction']['customer_complaint_id'] == NULL) { ?>style="display: none"<?php } ?>>
                        <div class="col-md-6"><?php echo $this->Form->input('customer_complaint_id', array('style' => 'width:100%', 'label' => __('Select Customer Complaint'))); ?></div>
                    </div>
                    <div id="supplier" <?php if ($this->data['CorrectivePreventiveAction']['supplier_registration_id'] == '-1' || $this->data['CorrectivePreventiveAction']['supplier_registration_id'] == NULL) { ?>style="display: none"<?php } ?>>
                        <div class="col-md-6"><?php echo $this->Form->input('supplier_registration_id', array('style' => 'width:100%', 'label' => __('Select Supplier'))); ?></div>
                    </div>
                    <div id="product" <?php if ($this->data['CorrectivePreventiveAction']['product_id'] == '-1' || $this->data['CorrectivePreventiveAction']['product_id'] == NULL) { ?>style="display: none"<?php } ?>>
                        <div class="col-md-6"><?php echo $this->Form->input('product_id', array('style' => 'width:100%', 'label' => __('Select Product'))); ?></div>
                    </div>
                    <div id="device" <?php if ($this->data['CorrectivePreventiveAction']['device_id'] == '-1' || $this->data['CorrectivePreventiveAction']['device_id'] == NULL) { ?>style="display: none"<?php } ?>><div class="col-md-6"><?php echo $this->Form->input('device_id', array('style' => 'width:100%', 'label' => __('Select Device'))); ?></div></div>
                    <div id="material" <?php if ($this->data['CorrectivePreventiveAction']['material_id'] == '-1' || $this->data['CorrectivePreventiveAction']['material_id'] == NULL) { ?>style="display: none"<?php } ?>>
                        <div class="col-md-6"><?php echo $this->Form->input('material_id', array('style' => 'width:100%', 'label' => __('Select Material'))); ?></div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-6"><?php echo $this->Form->input('assigned_to', array('options' => $PublishedEmployeeList, 'label' => __('Assigned To'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('target_date', array('label' => __('Target Date'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('initial_remarks', array('label' => __('Initial Remarks'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('proposed_immidiate_action', array('label' => __('Proposed Immediate Action'))); ?></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php
                        echo "<label>" . __('Current Status') . "</label>";
                        echo $this->Form->input('current_status', array('label' => false, 'legend' => false, 'div' => false, 'options' => array('0' => 'Open', '1' => 'Close'), 'type' => 'radio', 'style' => 'float:none','onclick' => 'currentStatus()'));
                    ?>
                </div>
            </div>
            <div id="statusCloseDetails" class="row">
                <div class="col-md-6"><?php echo $this->Form->input('completed_by', array('options' => $PublishedEmployeeList, 'label' => __('Completed By'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('completed_on_date', array('label' => __('Completed on Date'))); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('completion_remarks', array('label' => __('Completion Remarks'))); ?></div>
            </div>
            <div class="row">
                <br /><br />
                <legend><?php echo __('Step - 2'); ?></legend>
                <div class="col-md-12 text-danger"><?php echo $this->Form->input('root_cause_analysis_required', array('label' => __('Root Cause Analysis Required'))); ?></div>
            </div>
            <div class="row" id="root_cause_div">
                <div class="col-md-12"><?php echo $this->Form->input('root_cause', array('label' => __('Root Cause'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('determined_by', array('options' => $PublishedEmployeeList, 'label' => __('Determined By'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('determined_on_date', array('label' => __('Determined On Date'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('root_cause_remarks', array('label' => __('Root Cause Remarks'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('proposed_longterm_action', array('label' => __('Proposed Long-Term Action'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('action_assigned_to', array('options' => $PublishedEmployeeList, 'label' => __('Action Assigned to'))); ?></div>
                <br /><br />
                <div class="col-md-12"><legend>Step - 3</legend></div>
                <div class="col-md-6"><?php echo $this->Form->input('action_completed_on_date', array('label' => __('Action Completed on Date'))); ?></div>
                <div class="clearfix"></div>
                <div class="col-md-6"><?php echo $this->Form->input('action_completion_remarks', array('label' => __('Action Completion Remarks'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('effectiveness', array('label' => __('Effectiveness'))); ?></div>
                <div class="col-md-12"><?php echo $this->Form->input('closure_remarks', array('label' => 'Closure Remarks')) ?></div>
	    </div>
	    <hr>
	    <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('document_changes_required', array('type' => 'checkbox', 'label' => __('Document Changes Required'))); ?></div>

		<div id="docChangeReq">
		    <div class="col-md-6"><?php echo $this->Form->input('master_list_of_format', array('selected' => $changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['master_list_of_format'], 'options' => $masterListOfFormats)); ?></div>
		    <div class="col-md-12"><?php echo $this->Form->input('current_document_details', array('type' => 'textarea', 'value' => $changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['current_document_details'])); ?></div>
		    <div class="col-md-12"><?php echo $this->Form->input('request_details', array('type' => 'textarea', 'value' => $changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['request_details'])); ?></div>
		    <div class="col-md-12"><?php echo $this->Form->input('proposed_changes', array('type' => 'textarea', 'value' => $changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['proposed_changes'])); ?></div>
		    <div class="col-md-12"><?php echo $this->Form->input('reason_for_change', array('type' => 'textarea', 'value' => $changeAdditionDeletionRequest['ChangeAdditionDeletionRequest']['reason_for_change'])); ?></div>
		    <div class="clearfix">&nbsp;</div>
		</div>
            </div>
            <div class="row">
                <div class="col-md-6"><?php echo $this->Form->input('closed_by', array('options' => $PublishedEmployeeList, 'label' => __('Closed By'))); ?></div>
                <div class="col-md-6"><?php echo $this->Form->input('closed_on_date', array('label' => __('Closed on Date'))); ?></div>
            </div>

            <?php
                if ($showApprovals && $showApprovals['show_panel'] == true) {
                    echo $this->element('approval_form');
                } else {
                    echo $this->Form->input('publish', array('label' => __('Publish')));
                }
            ?>
            <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
            <?php echo $this->Form->end(); ?>
            <?php echo $this->Js->writeBuffer(); ?>

        </div>
<script>
    var targetDate = $('#CorrectivePreventiveActionTargetDate');
    var completedOnDate = $('#CorrectivePreventiveActionCompletedOnDate');
    var closedOnDate = $('#CorrectivePreventiveActionClosedOnDate');
    var determinedOnDate = $('#CorrectivePreventiveActionDeterminedOnDate');
    var actionCompletedOnDate = $('#CorrectivePreventiveActionActionCompletedOnDate');

    targetDate.datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,

        onSelect: function(selectedDate) {
            completedOnDate.datetimepicker('option', 'minDate', targetDate.datepicker('getDate'));
            closedOnDate.datetimepicker('option', 'minDate', targetDate.datepicker('getDate'));
            determinedOnDate.datetimepicker('option', 'minDate', targetDate.datepicker('getDate'));
            actionCompletedOnDate.datetimepicker('option', 'minDate', targetDate.datepicker('getDate'));
        }
    }).attr('readonly', 'readonly');

    determinedOnDate.datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,

        onSelect: function(selectedDate) {
            actionCompletedOnDate.datetimepicker('option', 'minDate', determinedOnDate.datepicker('getDate'));
        }
    }).attr('readonly', 'readonly');

    $("#CorrectivePreventiveActionCompletedOnDate").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
    }).attr('readonly', 'readonly');

    $("#CorrectivePreventiveActionClosedOnDate").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
    }).attr('readonly', 'readonly');

    $("#CorrectivePreventiveActionActionCompletedOnDate").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
    }).attr('readonly', 'readonly');
</script>

        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#correctivePreventiveActions_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>