<?php echo $this->Html->script(array('jquery.validate.min','jquery-form.min'));?>
<?php echo $this->fetch('script');?>

<script>
$.validator.setDefaults({
    ignore: null,
    errorPlacement: function(error, element) {
        if(  $(element).attr('name') == 'data[MaterialQualityCheckDetail][employee_id]'){
             $(element).next().after(error);
        }else{
               $(element).after(error);
        }
    },
});
$().ready(function() {
    $("#submit_id").click(function(){
        if($('#MaterialQualityCheckDetailAddQualityCheckForm').valid()){
            $("#submit_id").prop("disabled",true);
            $("#submit-indicator").show();
            $('#MaterialQualityCheckDetailAddQualityCheckForm').submit();
        }
      });
    jQuery.validator.addMethod("greaterThanZero", function(value, element) {
	return this.optional(element) || (parseFloat(value) > 0);
    }, "Please select the value");
$('#MaterialQualityCheckDetailAddQualityCheckForm').validate({
    rules: {
        "data[MaterialQualityCheckDetail][employee_id]" : {
           greaterThanZero:true,
         },
        "data[MaterialQualityCheckDetail][quantity_accepted]": {
            required: true,
            number:true,
            max: parseInt($('#MaterialQualityCheckDetailQuantityReceived').val())
        }
    }

});
    $('#MaterialQualityCheckDetailEmployeeId').change(function () {
        if( $( this ).val()!=-1 && $(this).next().next('label').hasClass("error")){
            $(this).next().next('label').remove();
        }
    });
});
</script>


<div id="materialQualityCheckDetails_ajax" >
<?php echo $this->Session->flash();?>
<div class="nav panel panel-default">
<div class="materialQualityCheckDetails form col-md-8">

<?php echo $this->Form->create(array('role'=>'form','class'=>'form')); ?>

		<?php echo $this->Form->input('id', array('type'=>'hidden','value'=>$materialQualityCheckDetail['MaterialQualityCheckDetail']['id'])); ?>
		<?php echo $this->Form->input('delivery_challan_id',array('type'=>'hidden','value'=>$deliveryChallan['DeliveryChallan']['id'])); ?>
		<?php echo $this->Form->input('material_quality_check_id',array('type'=>'hidden','value'=>$materialQualityChecks['MaterialQualityCheck']['id'])); ?>
		<?php //echo "<pre>"; print_r($materialQualityChecks); ?>
	<div class="row">
            <div class="col-md-12"><h4><label><?php echo $materialQualityChecks['MaterialQualityCheck']['name']; ?></label></h4></div>
        </div>
        <hr>

	<div class="row">
            <div class="col-md-2"><strong>Details</strong></div>
            <div class="col-md-10"><?php echo ':&nbsp;&nbsp;' . $materialQualityChecks['MaterialQualityCheck']['details']; ?></div>
        </div>
	<div class="row">
            <div class="col-md-2"><strong>Material</strong></div>
            <div class="col-md-10"><?php echo ':&nbsp;&nbsp;' . $materialQualityChecks['Material']['name']; ?></div>
        </div>
        <div class="row">
            <div class="col-md-2"><strong>Delivery Challan</strong></div>
            <div class="col-md-10"><?php echo ':&nbsp;&nbsp;' . $deliveryChallan['DeliveryChallan']['name']; ?></div>
	</div>
        <div class="row">&nbsp;</div>
	<div class="row">
            <div class="col-md-6"><?php echo $this->Form->input('employee_id', array('value'=>$materialQualityCheckDetail['MaterialQualityCheckDetail']['employee_id'],'options'=>$PublishedEmployeeList)); ?></div>
            <div class="col-md-6"><?php echo $this->Form->input('check_performed_date', array('value'=>$materialQualityCheckDetail['MaterialQualityCheckDetail']['check_performed_date'])); ?></div>
        </div>
        <div class="row">
            <div class="col-md-6"><?php echo $this->Form->input('quantity_received', array('value'=> $qtyRecd, 'readonly'=>'readonly')); ?></div>
            <div class="col-md-6"><?php echo $this->Form->input('quantity_accepted', array('value'=>$materialQualityCheckDetail['MaterialQualityCheckDetail']['quantity_accepted'])); ?></div>
        </div>
        <div class="row">
            <div class="col-md-6"><?php echo $this->Form->input('branchid',array('type'=>'hidden','value'=>$this->Session->read('User.branch_id'))); ?></div>
            <div class="col-md-6"><?php echo $this->Form->input('departmentid',array('type'=>'hidden','value'=>$this->Session->read('User.department_id'))); ?></div>
        </div>
	<?php //if($show_approvals && $show_approvals['show_panel'] == true ) { ?>
	<?php //echo $this->element('approval_form'); ?>
	<?php //} else {echo $this->Form->input('publish'); } ?>
<?php if($active_status == 'disabled'){?>
	<script>
	$('div *').prop('disabled',true);
	</script>
	<div class="alert alert-danger">You can not save this step until all previous quality check steps are done.</div>
<?php } ?>

<?php echo $this->Form->submit('Submit',array('div'=>false,'class'=>'btn btn-primary btn-success','id'=>'submit_id')); ?>
          <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
<?php echo $this->Form->end(); ?>
<?php echo $this->Js->writeBuffer();?>


</div>
<div class="col-md-4">
	<p><?php echo $this->element('helps'); ?></p>
</div>
</div>

<?php echo $this->Js->writeBuffer();?>
<script>
    var myDate = new Date();
    var newDate =   new Date(myDate.getFullYear()-18,myDate.getMonth(),myDate.getDate());
    $("[name*='date']").datetimepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat:'yy-mm-dd',
      'showTimepicker':false,

    }).attr('readonly', 'readonly');
</script>
</div>

