<?php if ($deviceMaintainances) { ?>

    <script>$('#device-maintainance-busy-indicator').hide()</script>
    <div id="device_maintainance" style="padding:10px;">
       
                <h3 class="panel-title"><?php echo __('Device Maintainance'); ?>
                    <span class='badge btn-danger'><?php echo $deviceMaintainancesCount; ?></span>
                </h3>
         <hr/>

                <table class="table table-condensed">
                    <tr>
                        <th><?php echo __("Device Name"); ?></th>
                        <th><?php echo __("Maintenance Performed Date"); ?></th>
                        <th><?php echo __("Status"); ?></th>
                        <th><?php echo __("Next Maintenance Date"); ?></th>
                        <th class="col-md-1"><?php echo __("Act"); ?></th>
                    </tr>
                    <?php foreach ($deviceMaintainances as $deviceMaintainance): ?>
                    <tr>
                        <td><?php echo $this->Html->link($deviceMaintainance['Device']['name'], array('controller' => 'devices', 'action' => 'view', $deviceMaintainance['Device']['id'])); ?></td>
                        <td><?php echo h($deviceMaintainance['DeviceMaintenance']['maintenance_performed_date']); ?></td>
                        <td><?php echo h($deviceMaintainance['DeviceMaintenance']['status'] ? 'In use' : 'Not in use'); ?></td>
                        <td><?php echo h($deviceMaintainance['DeviceMaintenance']['next_maintanence_date']); ?></td>
                        <td><?php echo $this->Html->link(__('Act'), array('controller' => 'device_maintenances', 'action' => 'lists', $deviceMaintainance['DeviceMaintenance']['id']), array('class' => 'badge btn-warning')); ?></td>

                    </tr>
                    <?php endforeach; ?>
                </table>
          
                <?php
                    echo $this->Paginator->options(array(
                        'update' => '#device_maintainance',
                        'evalScripts' => true,
                        'before' => $this->Js->get('#device-maintainance-busy-indicator')->effect('fadeIn', array('buffer' => false)),
                        'complete' => $this->Js->get('#device-maintainance-busy-indicator')->effect('fadeOut', array('buffer' => false)),
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
    <div id="device_maintainance" style="padding:10px">
          
          <h3 class="panel-title"><?php echo __('Device Maintainance'); ?></h3>
                    <hr/>
   No data Found

    </div>
   <?php
} ?>