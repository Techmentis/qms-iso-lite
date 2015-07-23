<?php $i =0 ; foreach($details as  $challanDetails):    ?>

<script>
    $("[name*='material_id']").chosen();
</script>

    <?php echo $this->Form->hidden('StockDetails.'.$i.'.materialid',array('value'=>$challanDetails['DeliveryChallanDetail']['material_id'])); ?>
    <div class="col-md-4"><?php echo $this->Form->input('StockDetails.'.$i.'.material_id',array('disabled','default'=>$challanDetails['DeliveryChallanDetail']['material_id'])); ?></div>
    <div class="col-md-2"><?php echo $this->Form->input('StockDetails.'.$i.'.received_date',array('value'=>$challanDetails['DeliveryChallan']['acknowledgement_date'])); ?></div>
    <div class="col-md-2"><?php echo $this->Form->input('StockDetails.'.$i.'.received',array('disabled','value'=>$challanDetails['DeliveryChallanDetail']['quantity_received'])); ?></div>
    <div class="col-md-2"><?php echo $this->Form->input('StockDetails.'.$i.'.added',array('disabled','value'=>$challanDetails['Stock']['total_received'])); ?></div>
    <div class="col-md-2">
        <?php if($challanDetails['Stock']['total_received'] - $challanDetails['DeliveryChallanDetail']['quantity_received'] < 0)
                echo $this->Form->input('StockDetails.'.$i.'.quantity',array('label'=>'Balance','value'=>$challanDetails['DeliveryChallanDetail']['quantity_received'] - $challanDetails['Stock']['total_received']));
                else
                echo $this->Form->input('StockDetails.'.$i.'.quantity',array('label'=>'Balance','disabled','value'=>$challanDetails['Stock']['total_received']));
            ?>
    </div>

    <?php echo $this->Form->hidden('StockDetails.'.$i.'.purchase_order_id',array('value'=>$challanDetails['DeliveryChallan']['purchase_order_id'])); ?>
    <?php echo $this->Form->hidden('StockDetails.'.$i.'.supplier_registration_id',array('value'=>$challanDetails['DeliveryChallan']['supplier_registration_id'])); ?>
    <div class="col-md-12"><?php echo $this->Form->input('StockDetails.'.$i.'.remarks',array('value'=>$challanDetails['DeliveryChallanDetail']['description'])); ?></div>
    <div class="col-md-12"><hr ></div>
<?php $i++; endforeach; ?>

<script>
    $("[name*='date']").datetimepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat:'yy-mm-dd',
      'showTimepicker':false,
    }).attr('readonly', 'readonly');
</script>
