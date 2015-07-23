<?php if ($nextCalibrations) { ?>
    <script>$('#calibration-notification-busy-indicator').hide()</script>
    <div id="next_calibrations" style="padding:10px;">
      
                <h3 class="panel-title">
                    <?php echo __("Upcoming Device Calibrations"); ?>
                    <?php echo $this->Html->link($countNextCalibrations, array('controller' => 'calibrations', 'action' => 'index'), array('id' => 'deviceCalibs', 'class' => 'badge btn-danger', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('Device Calibrations assigned to you'))); ?><script>$('#deviceCalibs').tooltip();</script>
                </h3> <hr/>
            
                <table class="table table-condensed">
                    <tr>
                        <th><?php echo __("Device"); ?></th>
                        <th><?php echo __("Device Number"); ?></th>
                        <th><?php echo __("Previous Calibration Date"); ?></th>
                        <th class="col-md-1"><?php echo __("Next Calibration Date"); ?></th>
                        <th class="col-md-1"><?php echo __("Act"); ?></th>
                    </tr>

                    <?php foreach ($nextCalibrations as $nextCalibration): ?>
                        <tr>
                            <td><?php echo $this->Html->link(h($nextCalibration['Device']['name']), array('controller' => 'devices', 'action' => 'view', $nextCalibration['Device']['id'])); ?></td>
                            <td><?php echo h($nextCalibration['Device']['number']); ?>&nbsp;</td>
                            <td><?php echo h($nextCalibration['Calibration']['calibration_date']); ?>&nbsp;</td>
                            <td><?php echo h($nextCalibration['Calibration']['next_calibration_date']); ?>&nbsp;</td>
                            <td>
                                <?php echo $this->Html->link(__('Act'), array('controller' => 'calibrations', 'action' => 'edit', $nextCalibration['Calibration']['id']), array('class' => 'badge btn-danger')); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
          
                <?php
                    echo $this->Paginator->options(array(
                        'update' => '#next_calibrations',
                        'evalScripts' => true,
                        'before' => $this->Js->get('#calibration-notification-busy-indicator')->effect('fadeIn', array('buffer' => false)),
                        'complete' => $this->Js->get('#calibration-notification-busy-indicator')->effect('fadeOut', array('buffer' => false)),
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
    <div id="caps_stauts" style="padding:10px">
          
          <h3 class="panel-title"><?php echo  __("Upcoming Device Calibrations"); ?>
            <?php echo $this->Html->link($countNextCalibrations, array('controller' => 'calibrations', 'action' => 'index'), array('id' => 'deviceCalibs', 'class' => 'badge btn-danger', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('Device Calibrations assigned to you'))); ?><script>$('#deviceCalibs').tooltip();</script>
          </h3>
                    <hr/>
   No data Found

    </div>
   <?php
} ?>