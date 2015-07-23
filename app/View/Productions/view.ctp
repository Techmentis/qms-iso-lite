<div id="productions_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="productions form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Production'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Product'); ?></td>
                    <td>
                        <?php echo $this->Html->link($production['Product']['name'], array('controller' => 'products', 'action' => 'view', $production['Product']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Batch Number'); ?></td>
                    <td>
                        <?php echo h($production['Production']['batch_number']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Details'); ?></td>
                    <td>
                        <?php echo h($production['Production']['details']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Branch'); ?></td>
                    <td>
                        <?php echo $this->Html->link($production['Branch']['name'], array('controller' => 'branches', 'action' => 'view', $production['Branch']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Supervisor'); ?></td>
                    <td>
                        <?php echo $this->Html->link($production['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $production['Employee']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Start Date'); ?></td>
                    <td>
                        <?php echo h($production['Production']['start_date']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('End Date'); ?></td>
                    <td>
                        <?php echo h($production['Production']['end_date']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Remarks'); ?></td>
                    <td>
                        <?php echo h($production['Production']['remarks']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($production['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($production['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($production['Production']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $production['Production']['created_by'], 'recordId' => $production['Production']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#productions_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $production['Production']['id'], 'ajax'), array('async' => true, 'update' => '#productions_ajax'))); ?>
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
