<div id="housekeepingResponsibilities_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="housekeepingResponsibilities form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Housekeeping Responsibility'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo $housekeepingResponsibility['HousekeepingResponsibility']['sr_no']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Housekeeping Checklist'); ?></td>
                    <td>
                        <?php echo $this->Html->link($housekeepingResponsibility['HousekeepingChecklist']['title'], array('controller' => 'housekeeping_checklists', 'action' => 'view', $housekeepingResponsibility['HousekeepingChecklist']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Employee'); ?></td>
                    <td>
                        <?php echo $this->Html->link($housekeepingResponsibility['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $housekeepingResponsibility['Employee']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Description'); ?></td>
                    <td>
                        <?php echo $housekeepingResponsibility['HousekeepingResponsibility']['description']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Schedule'); ?></td>
                    <td>
                        <?php echo $this->Html->link($housekeepingResponsibility['Schedule']['name'], array('controller' => 'schedules', 'action' => 'view', $housekeepingResponsibility['Schedule']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($housekeepingResponsibility['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($housekeepingResponsibility['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($housekeepingResponsibility['HousekeepingResponsibility']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $housekeepingResponsibility['HousekeepingResponsibility']['created_by'], 'recordId' => $housekeepingResponsibility['HousekeepingResponsibility']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#housekeepingResponsibilities_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $housekeepingResponsibility['HousekeepingResponsibility']['id'], 'ajax'), array('async' => true, 'update' => '#housekeepingResponsibilities_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#housekeepingResponsibilities_ajax'))); ?>
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
