<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="listOfSoftwares ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'List Of Softwares', 'modelClass' => 'ListOfSoftware', 'options' => array("sr_no" => "Sr No", "name" => "Name", "software_usage" => "Software Usage", "software_details" => "Software Details", "license_key" => "License Key", "storage_device_number" => "Storage Device Number", "backup_required" => "Backup Required"), 'pluralVar' => 'listOfSoftwares'))); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('table th a, .pag_list li span a').on('click', function() {
            var url = $(this).attr("href");
            $('#main').load(url);
            return false;
        });
    });
</script>

        <div class="table-responsive">
            <?php echo $this->Form->create(array('class' => 'no-padding no-margin no-background')); ?>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th><?php echo $this->Paginator->sort('name', __('Software Name')); ?></th>
                    <th><?php echo $this->Paginator->sort('software_type_id', __('Software Type')); ?></th>
                    <th><?php echo $this->Paginator->sort('software_usage', __('Software Usage')); ?></th>
                    <th><?php echo $this->Paginator->sort('storage_device_number', __('Storage Device Number')); ?></th>
                    <th><?php echo $this->Paginator->sort('employee_id', __('Employee')); ?></th>
                    <th><?php echo $this->Paginator->sort('backup_required', __('Backup Required')); ?></th>
                    <th><?php echo $this->Paginator->sort('schedule_id', __('Backup Schedule')); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php if ($listOfSoftwares) {
                        $x = 0;
                        foreach ($listOfSoftwares as $listOfSoftware):
                ?>
                <tr>
                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $listOfSoftware['ListOfSoftware']['created_by'], 'postVal' => $listOfSoftware['ListOfSoftware']['id'], 'softDelete' => $listOfSoftware['ListOfSoftware']['soft_delete'])); ?>
                    </td>
                    <td><?php echo $listOfSoftware['ListOfSoftware']['name']; ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($listOfSoftware['SoftwareType']['title'], array('controller' => 'software_types', 'action' => 'view', $listOfSoftware['SoftwareType']['id'])); ?>
                    </td>
                    <td><?php echo $listOfSoftware['ListOfSoftware']['software_usage']; ?>&nbsp;</td>
                    <td><?php echo $listOfSoftware['ListOfSoftware']['storage_device_number']; ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($listOfSoftware['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $listOfSoftware['Employee']['id'])); ?>
                    </td>
                    <td><?php echo $listOfSoftware['ListOfSoftware']['backup_required'] ? __('Yes') : __('No'); ?>&nbsp;</td>
                    <td>
                        <?php
                        if ($listOfSoftware['ListOfSoftware']['backup_required'] == 0) {
                            echo '&nbsp;';
                        } else {
                            echo $this->Html->link($listOfSoftware['Schedule']['name'], array('controller' => 'schedules', 'action' => 'view', $listOfSoftware['Schedule']['id']));
                        }
                        ?>
                    </td>
                    <td><?php echo h($PublishedEmployeeList[$listOfSoftware['ListOfSoftware']['prepared_by']]); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$listOfSoftware['ListOfSoftware']['approved_by']]); ?>&nbsp;</td>

                    <td width="60">
                        <?php if ($listOfSoftware['ListOfSoftware']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                </tr>
                <?php
                    $x++;
                    endforeach;
                    } else {
                ?>
                <tr><td colspan=21>No results found</td></tr>
                <?php } ?>
            </table>
            <?php echo $this->Form->end(); ?>
        </div>
        <p>
            <?php
                echo $this->Paginator->options(array(
                    'update' => '#main',
                    'evalScripts' => true,
                    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
                    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
                ));

                echo $this->Paginator->counter(array(
                    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                ));
            ?>
        </p>
        <ul class="pagination">
            <?php
                echo "<li class='previous'>" . $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')) . "</li>";
                echo "<li>" . $this->Paginator->numbers(array('separator' => '')) . "</li>";
                echo "<li class='next'>" . $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')) . "</li>";
            ?>
        </ul>
    </div>
</div>

<?php echo $this->element('export'); ?>
<?php echo $this->element('advanced-search', array('postData' => array("name" => "Name", "software_usage" => "Software Usage", "software_details" => "Software Details", "license_key" => "License Key", "storage_device_number" => "Storage Device Number", "backup_required" => "Backup Required"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "name" => "Name", "software_usage" => "Software Usage", "software_details" => "Software Details", "license_key" => "License Key", "storage_device_number" => "Storage Device Number", "backup_required" => "Backup Required"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->element('common'); ?>
<?php echo $this->Js->writeBuffer(); ?>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>