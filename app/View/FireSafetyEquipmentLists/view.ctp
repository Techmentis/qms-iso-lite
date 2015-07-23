<div id="fireSafetyEquipmentLists_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="fireSafetyEquipmentLists form col-md-8">
            <h4><?php echo __('View Fire Safety Equipment List'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($fireSafetyEquipmentList['FireSafetyEquipmentList']['sr_no']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Fire Extinguisher'); ?></td>
                    <td>
                        <?php echo $this->Html->link($fireSafetyEquipmentList['FireExtinguisher']['name'], array('controller' => 'fire_extinguishers', 'action' => 'view', $fireSafetyEquipmentList['FireExtinguisher']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Fire Type'); ?></td>
                    <td>
                        <?php echo $this->Html->link($fireSafetyEquipmentList['FireType']['name'], array('controller' => 'fire_types', 'action' => 'view', $fireSafetyEquipmentList['FireType']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Branch'); ?></td>
                    <td>
                        <?php echo $this->Html->link($fireSafetyEquipmentList['Branch']['name'], array('controller' => 'branches', 'action' => 'view', $fireSafetyEquipmentList['Branch']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Department'); ?></td>
                    <td>
                        <?php echo $this->Html->link($fireSafetyEquipmentList['Department']['name'], array('controller' => 'departments', 'action' => 'view', $fireSafetyEquipmentList['Department']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($fireSafetyEquipmentList['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($fireSafetyEquipmentList['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($fireSafetyEquipmentList['FireSafetyEquipmentList']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $fireSafetyEquipmentList['FireSafetyEquipmentList']['created_by'], 'recordId' => $fireSafetyEquipmentList['FireSafetyEquipmentList']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#fireSafetyEquipmentLists_ajax'))); ?>\
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $fireSafetyEquipmentList['FireSafetyEquipmentList']['id'], 'ajax'), array('async' => true, 'update' => '#fireSafetyEquipmentLists_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#fireSafetyEquipmentLists_ajax'))); ?>
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
