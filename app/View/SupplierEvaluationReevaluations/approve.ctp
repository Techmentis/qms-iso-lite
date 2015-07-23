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
});

$().ready(function() {
jQuery.validator.addMethod("greaterThanZero", function(value, element) {
    return this.optional(element) || (parseFloat(value) > 0);
}, "Please select the value");

$('#SupplierEvaluationReevaluationApproveForm').validate({
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
$("#submit-indicator").hide();
    $("#submit_id").click(function(){
             if($('#SupplierEvaluationReevaluationApproveForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
		 $("#SupplierEvaluationReevaluationApproveForm").submit();
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
<?php echo $this->Session->flash();?>
<div class="nav panel panel-default">
<div class="supplierEvaluationReevaluations form col-md-8">
<h4><?php echo __('Approve Supplier Evaluation Reevaluation'); ?>
		<?php echo $this->Html->link(__('List'), array('action' => 'index'),array('id'=>'list','class'=>'label btn-info')); ?>
		</h4>
<?php echo $this->Form->create('SupplierEvaluationReevaluation',array('role'=>'form','class'=>'form')); ?>

	<?php echo $this->Form->input('id'); ?>

    <div class="row">
		<div class="col-md-6"><?php echo $this->Form->input('supplier_registration_id',array('style'=>'width:100%','disabled', 'label'=> __('Supplier'))); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('delivery_challan_id', array('disabled','label'=> __('Delivery Challan'))); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('product_id',array('disabled','style'=>'width:100%', 'label'=> __('Product'))); ?></div>
		<div class="col-md-3"><?php echo $this->Form->input('quantity_supplied', array('disabled','label'=> __('Quantity Supplied'))); ?></div>
		<div class="col-md-3"><?php echo $this->Form->input('quantity_accepted', array('label'=> __('Quantity Accepted'))); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('required_delivery_date', array('disabled','label'=> __('Required Delivery Date'))); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('actual_delivery_date', array('disabled','label'=> __('Actual Delivery Date'))); ?></div>
		<div class="col-md-12"><?php echo $this->Form->input('remarks', array('label'=> __('Remarks'))); ?></div>
    </div>

	<?php if($showApprovals && $showApprovals['show_panel'] == true ) { ?>
	<?php echo $this->element('approval_form'); ?>
	<?php } else {echo $this->Form->input('publish', array('label'=> __('Publish'))); } ?>
	<?php echo $this->Form->submit(__('Submit'),array('div'=>false,'class'=>'btn btn-primary btn-success','id'=>'submit_id')); ?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
	<?php echo $this->Form->end(); ?>
	<?php echo $this->Js->writeBuffer();?>

</div>
<div class="col-md-4">
	<p><?php echo $this->element('helps'); ?></p>
</div>
</div>
<?php echo $this->Js->get('#list');?>
<?php echo $this->Js->event('click',$this->Js->request(array('action' => 'index', 'ajax'),array('async' => true, 'update' => '#supplierEvaluationReevaluations_ajax')));?>

<?php echo $this->Js->writeBuffer();?>
</div>
