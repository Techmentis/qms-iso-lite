<?php echo $this->Html->script(array('jquery.validate.min','jquery-form.min'));?>
<?php echo $this->fetch('script');?>

<script>
    $.validator.setDefaults({
	ignore: null,
	errorPlacement: function(error, element) {
	    if($(element).attr('name') == 'data[SupplierEvaluationReevaluation][supplier_registration_id]' ||
	       $(element).attr('name') == 'data[SupplierEvaluationReevaluation][delivery_challan_id]' ||
	       $(element).attr('name') == 'data[SupplierEvaluationReevaluation][product_id]'){
		 $(element).next().after(error);
	    }else{
		   $(element).after(error);
	    }
	},
	submitHandler: function(form) {
	    $(form).ajaxSubmit({
		url:"<?php echo Router::url('/', true);?><?php echo $this->request->params['controller']?>/add_ajax",
		type:'POST',
		target: '#main',
		beforeSend: function(){
		    $("#submit_id").prop("disabled",true);
		    $("#submit-indicator").show();
		},
		complete: function() {
		    $("#submit_id").removeAttr("disabled");
		    $("#submit-indicator").hide();
		},
		error: function (request, status, error) {
		    //alert(request.responseText);
		    alert('Action failed!');
		}
	    });
	}
    });

    $().ready(function() {
        $("#submit-indicator").hide();
        jQuery.validator.addMethod("greaterThanZero", function(value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Please select the value");

        $('#SupplierEvaluationReevaluationAddAjaxForm').validate({
            rules: {
                "data[SupplierEvaluationReevaluation][supplier_registration_id]" : {
                    greaterThanZero:true,
                },
                "data[SupplierEvaluationReevaluation][delivery_challan_id]" : {
                    greaterThanZero:true,
                },
                "data[SupplierEvaluationReevaluation][product_id]" : {
                    greaterThanZero:true,
                },
            }
        });
        $('#SupplierEvaluationReevaluationSupplierRegistrationId').change(function () {
            if( $( this ).val()!=-1 && $(this).next().next('label').hasClass("error")){
                $(this).next().next('label').remove();
            }
        });
        $('#SupplierEvaluationReevaluationDeliveryChallanId').change(function () {
            if( $( this ).val()!=-1 && $(this).next().next('label').hasClass("error")){
                $(this).next().next('label').remove();
            }
        });
        $('#SupplierEvaluationReevaluationProductId').change(function () {
            if( $( this ).val()!=-1 && $(this).next().next('label').hasClass("error")){
                $(this).next().next('label').remove();
            }
        });
    });
</script>

<div id="supplierEvaluationReevaluations_ajax">
<?php echo $this->Session->flash();?><div class="nav">
<div class="supplierEvaluationReevaluations form col-md-8">
<h4><?php echo __('Add Supplier Evaluation Reevaluation');?></h4>
<?php echo $this->Form->create('SupplierEvaluationReevaluation',array('role'=>'form','class'=>'form','default'=>false)); ?>

    <div class="row">
		<div class="col-md-6"><?php echo $this->Form->input('supplier_registration_id',array('style'=>'width:100%','label'=> __('Supplier'))); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('SupplierEvaluationReevaluation.delivery_challan_id', array('label'=> __('Delivery Challan')),array('type'=>'select')); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('product_id',array('style'=>'width:100%', 'label'=> __('Product'))); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('quantity_supplied', array('label'=> __('Quantity Supplied'))); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('quantity_accepted', array('label'=> __('Quantity Accepted'))); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('required_delivery_date', array('label'=> __('Required Delivery Date'))); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('actual_delivery_datedate', array('label'=> __('Actual Delivery Date'))); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('remarks', array('label'=> __('Remarks'))); ?></div>
		<?php
		    echo $this->Form->input('branchid',array('type'=>'hidden','value'=>$this->Session->read('User.branch_id')));
		    echo $this->Form->input('departmentid',array('type'=>'hidden','value'=>$this->Session->read('User.department_id')));
		    echo $this->Form->input('master_list_of_format_id',array('type'=>'hidden','value'=>$documentDetails['MasterListOfFormat']['id']));
		?>
    </div>

    <?php if($showApprovals && $showApprovals['show_panel'] == true ) { ?>
    <?php echo $this->element('approval_form'); ?>
    <?php } else {echo $this->Form->input('publish', array('label'=> __('Publish'))); } ?>
    <?php echo $this->Form->submit(__('Submit'),array('div'=>false,'class'=>'btn btn-primary btn-success','update'=>'#supplierEvaluationReevaluations_ajax','async' => 'false','id'=>'submit_id')); ?>
    <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
    <?php echo $this->Form->end(); ?>
    <?php echo $this->Js->writeBuffer();?>

</div>
<div class="col-md-4">
	<p><?php echo $this->element('helps'); ?></p>
</div>
</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>