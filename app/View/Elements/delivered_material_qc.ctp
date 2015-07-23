<?php if ($materialQCrequired) { ?>
    <script>$('#delivered-material-qc-busy-indicator').hide(); </script>
    <div id="delivered_material_qc" style="padding:10px;">
        
                <h3 class="panel-title "><?php echo __('Materials that Requires QC'); ?>
                    <span class='badge btn-danger'><?php echo $materialQCrequiredCount; ?></span>
                </h3>
                <hr/>
                <table class="table table-condensed">
                    <tr>
                        <th><?php echo __("Material"); ?></th>
                        <th><?php echo __("Delivery Challan"); ?></th>
                        <th><?php echo __("Challan Date"); ?></th>
                        <th><?php echo __("Quantity Received"); ?></th>
                        <th><?php echo __("Act"); ?></th>
                    </tr>
                    <?php foreach ($materialQCrequired as $material): ?>
                        <tr>
                            <td><?php echo $material['Material']['name']; ?></td>
                            <td><?php echo $material['DeliveryChallan']['challan_number']; ?></td>
                            <td><?php echo $material['DeliveryChallan']['challan_date']; ?></td>
                            <td><?php echo $material['DeliveryChallanDetail']['quantity_received']; ?></td>
                            <td><?php
                                    if (!$material['MaterialQualityCheck']['redirect']) {
                                        echo $this->Html->link(__('Act'), array('controller' => 'material_quality_checks', 'action' => 'lists', $material['DeliveryChallanDetail']['material_id']), array('class' => 'badge btn-warning'));
                                    } else {
                                        echo $this->Html->link(__('Act'), array('controller' => 'material_quality_checks', 'action' => 'quality_check', $material['DeliveryChallanDetail']['delivery_challan_id'], $material['DeliveryChallanDetail']['material_id']), array('class' => 'badge btn-warning'));
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
           
                <?php
                    echo $this->Paginator->options(array(
                        'update' => '#delivered_material_qc',
                        'evalScripts' => true,
                        'before' => $this->Js->get('#delivered-material-qc-busy-indicator')->effect('fadeIn', array('buffer' => false)),
                        'complete' => $this->Js->get('#delivered-material-qc-busy-indicator')->effect('fadeOut', array('buffer' => false)),
                    ));
                ?>
                <ul class="pagination no-margin ">
                    <?php
                        echo "<li class='previous'>" . $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')) . "</li>";
                        echo "<li>" . $this->Paginator->numbers(array('separator' => '')) . "</li>";
                        echo "<li class='next'>" . $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')) . "</li>";
                    ?>
                </ul>
     </div>
    <?php echo $this->Js->writeBuffer(); ?>
<?php } else{ ?>
    <div id="delivered-material" style="padding:10px">
          
          <h3 class="panel-title"><?php echo __('Materials that Requires QC'); ?></h3>
                    <hr/>
   No data Found

    </div>
   <?php
} ?>