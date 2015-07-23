<?php echo $this->Html->script(array('googlechart.min')); ?>
<div class=" panel" >
    <?php echo $this->Session->flash(); ?>
    <div class="stocks">
        <?php echo $this->Form->create('Stock', array('role' => 'form', 'type' => 'get', 'class' => 'form no-padding no-margin', 'default' => false)); ?>
        <div class="col-md-3"><h4>Stock Status</h4></div>
        <?php if(isset($selectedMaterial)){?>
              <div class="col-md-12"><?php echo $this->Form->input('material_id', array('name'=>'material_id[]','type'=>'select','multiple' => true, 'style' => 'width:100%', 'options'=>$materials,'selected' => $selectedMaterial)); ?></div>
        <?php }else{?>
            <div class="col-md-12"><?php echo $this->Form->input('material_id', array('multiple' => true, 'style' => 'width:100%')); ?></div>
        <?php }?>
        <?php if(isset($this->request->data['start_date'])){?>
            <div class="col-md-2"><?php echo $this->Form->input('start_date', array('value' => $this->request->data['start_date'])); ?></div>
        <?php }else{?>
            <div class="col-md-2"><?php echo $this->Form->input('start_date'); ?></div>
        <?php }?>
        <?php if(isset($this->request->data['end_date'])){?>
            <div class="col-md-2"><?php echo $this->Form->input('end_date', array('value' => $this->request->data['end_date'])); ?></div>
        <?php }else{?>
            <div class="col-md-2"><?php echo $this->Form->input('end_date'); ?></div>
        <?php }?>    
        <div class="col-md-1"><?php echo $this->Js->submit('Submit', array('div' => false, 'class' => 'btn btn-primary btn-success', 'style' => 'margin-top:26px', 'update' => '#stocksstatus', 'type' => 'get', 'async' => 'false')); ?></div>
        <div class="col-md-7"><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator', 'class' => 'pull-right')); ?></div>
        <div class="col-md-12"><p><?php echo __('Select the meterial from "Material" input & select date range to get the stock status graph.') ?></p></div>
        <?php echo $this->Form->end(); ?>
    </div>
    <div id="stocksstatus" class="table-responsive panel-body"></div>
        <?php echo $this->Js->writeBuffer(); ?>
    <script>
        $('#StockMaterialId').chosen();
        $("[name*='date']").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
        });

        $.ajaxSetup({beforeSend: function() {
                $("#busy-indicator").show();
            }, complete: function() {
                $("#busy-indicator").hide();
            }
        });
    </script>
</div>


