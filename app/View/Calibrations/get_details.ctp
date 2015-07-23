<br /><br />
<div class="panel panel-default pane-body">
    <h4>&nbsp;&nbsp;<?php echo __('Device Values'); ?></h4>
    <table class="table table-respolsive">
        <tr>
            <th><?php echo __('Least Count') ?></th>
            <th><?php echo __('Required Accuracy') ?></th>
            <th><?php echo __('Range') ?></th>
        </tr>
        <tr>
            <td><?php echo $device['Device']['least_count'] ?></td>
            <td><?php echo $device['Device']['required_accuracy'] ?></td>
            <td><?php echo $device['Device']['range'] ?></td>
        </tr>
        <tr>
            <th><?php echo __('Default Calibration') ?></th>
            <th><?php echo __('Calibration Required') ?></th>
            <th><?php echo __('Actual Calibration') ?></th>
        </tr>
        <tr>
            <td><?php echo $device['Device']['default_calibration'] ?></td>
            <td><?php echo $device['Device']['required_calibration'] ?></td>
            <td><?php echo $device['Device']['actual_calibration'] ?></td>
        </tr>
    </table>
</div>