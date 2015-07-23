<?php echo $this->Html->script(array('jquery.validate.min','jquery-form.min'));?>
<?php echo $this->fetch('script');?>
<script>
    $.validator.setDefaults();
    $().ready(function() {
   // $('#MaterialQualityCheckDetailAddQualityCheckForm').validate();
    $("#submit_id").click(function(){
        if($('#MaterialQualityCheckDetailAddToStockForm').valid()){
            $("#submit_id").prop("disabled",true);
            $("#submit-indicator").show();
            $('#MaterialQualityCheckDetailAddToStockForm').submit();
        }
      });
  });
</script>
<div id="materialQualityCheckDetails_ajax">
<?php echo $this->Session->flash();?>
<div class="nav panel panel-default">
<div class="materialQualityCheckDetails form col-md-8">
    <?php echo $this->Form->create(array('role'=>'form','class'=>'form')); ?>
    <?php echo $this->Form->input('delivery_challan_id',array('type'=>'hidden','value'=>$deliveryChallan['DeliveryChallan']['id'])); ?>
    <?php echo $this->Form->input('material_id',array('type'=>'hidden','value'=>$material['Material']['id'])); ?>

    <div class="row">
        <div class="col-md-12"><h4><label><?php echo __('ADD MATERIAL TO STOCK'); ?></label></h4></div>
    </div>
    <hr>
        <div class="row">
            <div class="col-md-2"><strong>Material</strong></div>
            <div class="col-md-10"><?php echo ':&nbsp;&nbsp;' . $material['Material']['name']; ?></div>
        </div>
        <div class="row">
            <div class="col-md-2"><strong>Delivery Challan</strong></div>
            <div class="col-md-10"><?php echo ':&nbsp;&nbsp;' . $deliveryChallan['DeliveryChallan']['name']; ?></div>
	</div>
        <br />&nbsp;
        <br />
        <div class="row">
             <div class="col-md-12">
<?php
  if(count($materialQualityCheckDetails)){?>
    <table class="table table-bordered table table-striped table-hover">
        <tr>
            <th colspan='2'>Step</th><th>Employee</th><th>Date</th><th>Quantity Received</th><th>Quantity Accpted</th>
        </tr>


  <?php }
foreach($materialQualityCheckDetails as $materialQualityCheckDetail){?>
    <tr>
        <td colspan='2'><?php echo $materialQualityCheckDetail['MaterialQualityCheck']['name'];?></td>
        <td><?php echo $materialQualityCheckDetail['Employee']['name'];?></td>
        <td><?php echo $materialQualityCheckDetail['MaterialQualityCheckDetail']['check_performed_date'];?></td>
        <td><?php echo $materialQualityCheckDetail['MaterialQualityCheckDetail']['quantity_received'];?></td>
        <td><?php echo $materialQualityCheckDetail['MaterialQualityCheckDetail']['quantity_accepted'];?></td>
        <?php $finalAccepted = $materialQualityCheckDetail['MaterialQualityCheckDetail']['quantity_accepted'];?>
    </tr>

<?php } ?>
 </table>
</div>
</div>
        <?php if(count($materialQualityCheckDetails)<$materialQualityCheckCount) {?>
        <div class="alert alert-danger">You can not add material to stock until all quality check steps are done.</div>
        <?php echo $this->Form->submit('Add to stock',array('class'=>'btn btn-primary btn-success','disabled'=>'disabled')); ?>
        <?php } else { ?>
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Form->input('remarks', array('type'=>'textarea')); ?>
                <?php echo $this->Form->input('totalAccepted', array('type'=>'text','type'=>'hidden','value'=>$finalAccepted)); ?>
            </div>
        </div>
        <br />
          <?php echo $this->Form->submit('Add to stock',array('class'=>'btn btn-primary btn-success','id'=>'submit_id')); ?>
          <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
         <?php } ?>
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