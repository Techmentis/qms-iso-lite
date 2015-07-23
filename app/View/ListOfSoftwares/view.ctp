<div id="listOfSoftwares_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="listOfSoftwares form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View List Of Software'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo $listOfSoftware['ListOfSoftware']['sr_no']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Name'); ?></td>
                    <td>
                        <?php echo $listOfSoftware['ListOfSoftware']['name']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Software Type'); ?></td>
                    <td>
                        <?php echo $this->Html->link($listOfSoftware['SoftwareType']['title'], array('controller' => 'software_types', 'action' => 'view', $listOfSoftware['SoftwareType']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Software Usage'); ?></td>
                    <td>
                        <?php echo $listOfSoftware['ListOfSoftware']['software_usage']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Software Details'); ?></td>
                    <td>
                        <?php echo $listOfSoftware['ListOfSoftware']['software_details']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('License Key'); ?></td>
                    <td>
                        <?php echo '***********************' ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Storage Device Number'); ?></td>
                    <td>
                        <?php echo $listOfSoftware['ListOfSoftware']['storage_device_number']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Employee'); ?></td>
                    <td>
                        <?php echo $this->Html->link($listOfSoftware['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $listOfSoftware['Employee']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Backup Required'); ?></td>
                    <td>
                        <?php echo $listOfSoftware['ListOfSoftware']['backup_required'] ? 'Yes' : 'No'; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Backup Schedule'); ?></td>
                    <td>
                        <?php echo $this->Html->link($listOfSoftware['Schedule']['name'], array('controller' => 'schedules', 'action' => 'view', $listOfSoftware['Schedule']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($listOfSoftware['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($listOfSoftware['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($listOfSoftware['ListOfSoftware']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $listOfSoftware['ListOfSoftware']['created_by'], 'recordId' => $listOfSoftware['ListOfSoftware']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#listOfSoftwares_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $listOfSoftware['ListOfSoftware']['id'], 'ajax'), array('async' => true, 'update' => '#listOfSoftwares_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#listOfSoftwares_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>
