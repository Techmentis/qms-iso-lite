<div id="materialQualityChecks_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel">
        <div class="materialQualityChecks form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Material Quality Check'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Material'); ?></td>
                    <td><?php echo $this->Html->link($materialName['Material']['name'], array('controller' => 'materials', 'action' => 'view', $materialName['Material']['id'])); ?>			&nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($PublishedEmployeeList[$materialQualityChecks[0]['MaterialQualityCheck']['prepared_by']]); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($PublishedEmployeeList[$materialQualityChecks[0]['MaterialQualityCheck']['approved_by']]); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($materialQualityChecks[0]['MaterialQualityCheck']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>

            <?php
                $i = 0;
                foreach ($materialQualityChecks as $materialQualityCheck):
            ?>
                <tr><th colspan="2"><label><?php
                        echo h('Step - ');
                        echo ++$i;
                    ?></label></th>
                </tr>
                    <tr><td><?php echo __('Name'); ?></td>
                        <td>
                            <?php echo h($materialQualityCheck['MaterialQualityCheck']['name']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr><td><?php echo __('Details'); ?></td>
                        <td>
                            <?php echo h($materialQualityCheck['MaterialQualityCheck']['details']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr><td><?php echo __('Is Last Step'); ?></td>
                        <td>
                            <?php if ($materialQualityCheck['MaterialQualityCheck']['is_last_step'] == 1) { ?>
                                <?php echo __('Yes'); ?>
                            <?php } else { ?>
                                <?php echo __('No'); ?>
                            <?php } ?>&nbsp;</td>
                    </tr>
                    <tr><td><?php echo __('Is Active'); ?></td>
                        <td>
                            <?php if ($materialQualityCheck['MaterialQualityCheck']['active_status'] == 1) { ?>
                                <?php echo __('Yes'); ?>
                            <?php } else { ?>
                                <?php echo __('No'); ?>
                            <?php } ?>&nbsp;
                        </td>
                    </tr>

            <?php endforeach;?>
                </table>
            <?php echo $this->element('upload-edit', array('usersId' => $materialName['Material']['created_by'], 'recordId' => $materialName['Material']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#materialQualityChecks_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $materialName['Material']['id'], 'ajax'), array('async' => true, 'update' => '#materialQualityChecks_ajax'))); ?>
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
