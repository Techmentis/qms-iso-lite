<div id="listOfAcceptableSuppliers_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
            <div class="listOfAcceptableSuppliers form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Acceptable Supplier'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Supplier'); ?></td>
                    <td>
                        <?php echo $this->Html->link($listOfAcceptableSupplier['SupplierRegistration']['title'], array('controller' => 'supplier_registrations', 'action' => 'view', $listOfAcceptableSupplier['SupplierRegistration']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Supplier Category'); ?></td>
                    <td>
                        <?php echo $this->Html->link($listOfAcceptableSupplier['SupplierCategory']['name'], array('controller' => 'supplier_categories', 'action' => 'view', $listOfAcceptableSupplier['SupplierCategory']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Remarks'); ?></td>
                    <td>
                        <?php echo $listOfAcceptableSupplier['ListOfAcceptableSupplier']['remarks']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($listOfAcceptableSupplier['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($listOfAcceptableSupplier['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($listOfAcceptableSupplier['ListOfAcceptableSupplier']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $listOfAcceptableSupplier['ListOfAcceptableSupplier']['created_by'], 'recordId' => $listOfAcceptableSupplier['ListOfAcceptableSupplier']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>

    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#listOfAcceptableSuppliers_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $listOfAcceptableSupplier['ListOfAcceptableSupplier']['id'], 'ajax'), array('async' => true, 'update' => '#listOfAcceptableSuppliers_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#listOfAcceptableSuppliers_ajax'))); ?>
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
