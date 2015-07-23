<div id="purchaseOrders_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="purchaseOrders form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Purchase Order'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr>
                    <td><?php echo __('Title'); ?></td>
                    <td>
                        <?php echo h($purchaseOrder['PurchaseOrder']['title']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td><?php echo __('Purchase Order Number'); ?></td>
                    <td>
                        <?php echo h($purchaseOrder['PurchaseOrder']['purchase_order_number']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td><?php echo __('Order Date'); ?></td>
                    <td>
                        <?php echo h($purchaseOrder['PurchaseOrder']['order_date']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td><?php echo __('Type'); ?></td>
                    <td>
                        <?php
                        if ($purchaseOrder['PurchaseOrder']['type'] == 0)
                            echo __('Inbound');
                        else if ($purchaseOrder['PurchaseOrder']['type'] == 1)
                            echo __('Outbound');
                        else
                            echo __('Other');
                        ?>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td><?php
                            if ($purchaseOrder['PurchaseOrder']['type'] == 1)
                                echo __('Supplier');
                            else if ($purchaseOrder['PurchaseOrder']['type'] == 0)
                                echo __('Customer');
                            else
                                echo __('Other');
                        ?>
                    <td>
                        <?php if ($purchaseOrder['PurchaseOrder']['type'] == 0) echo $this->Html->link($purchaseOrder['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $purchaseOrder['Customer']['id'])); ?>
                        <?php if ($purchaseOrder['PurchaseOrder']['type'] == 1) echo $this->Html->link($purchaseOrder['SupplierRegistration']['title'], array('controller' => 'supplier_registrations', 'action' => 'view', $purchaseOrder['SupplierRegistration']['id'])); ?>
                        <?php if ($purchaseOrder['PurchaseOrder']['type'] == 2) echo h($purchaseOrder['PurchaseOrder']['other']); ?>
                    </td>
                </tr>

                <tr>
                    <td><?php echo __('Details'); ?></td>
                    <td>
                        <?php echo h($purchaseOrder['PurchaseOrder']['details']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td><?php echo __('Intimation'); ?></td>
                    <td>
                        <?php echo $purchaseOrder['PurchaseOrder']['intimation']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td><?php echo __('Expected Delivery Date'); ?></td>
                    <td>
                        <?php echo $purchaseOrder['PurchaseOrder']['expected_delivery_date']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($purchaseOrder['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($purchaseOrder['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($purchaseOrder['PurchaseOrder']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;</td>
                </tr>

            </table>

            <table class="table table-responsive">
                <tr><td colspan="9"><h4><?php echo __('Order Details') . " " . $i; ?></h4></td></tr>
                <tr>
                    <th><?php echo __('Product/ Device/ Material/ Other'); ?></th>
                    <th><?php echo __('Item Number'); ?></th>
                    <th><?php echo __('Quantity'); ?></th>
                    <th><?php echo __('Rate'); ?></th>
                    <th><?php echo __('Discount'); ?></th>
                    <th><?php echo __('Total'); ?></th>
                    <th><?php echo __('Description'); ?></th>
                    <th><?php echo __('Publish'); ?></th>
                </tr>

                <?php $i = 1; ?>
                <?php foreach ($purchaseOrderDetails as $purchaseOrderDetail) { ?>
                <tr>
                    <td>
                        <?php
                        if ($purchaseOrderDetail['PurchaseOrderDetail']['product_id'] != -1) {
                            echo $this->Html->link($purchaseOrderDetail['Product']['name'], array('controller' => 'products', 'action' => 'view', $purchaseOrderDetail['Product']['id']));
                        } elseif ($purchaseOrderDetail['PurchaseOrderDetail']['device_id'] != -1) {
                            echo $this->Html->link($purchaseOrderDetail['Device']['name'], array('controller' => 'devices', 'action' => 'view', $purchaseOrderDetail['Device']['id']));
                        } elseif ($purchaseOrderDetail['PurchaseOrderDetail']['material_id'] != -1) {
                            echo $this->Html->link($purchaseOrderDetail['Material']['name'], array('controller' => 'materials', 'action' => 'view', $purchaseOrderDetail['Material']['id']));
                        } elseif ($purchaseOrderDetail['PurchaseOrderDetail']['other'] != NULL) {
                            echo($purchaseOrderDetail['PurchaseOrderDetail']['other']);
                        }
                        ?>&nbsp;
                    </td>
                    <td>
                        <?php echo h($purchaseOrderDetail['PurchaseOrderDetail']['item_number']); ?>
                        &nbsp;
                    </td>
                    <td>
                        <?php echo h($purchaseOrderDetail['PurchaseOrderDetail']['quantity']); ?>
                        &nbsp;
                    </td>
                    <td>
                        <?php echo h($purchaseOrderDetail['PurchaseOrderDetail']['rate']); ?>
                        &nbsp;
                    </td>
                    <td>
                        <?php
                        if ($purchaseOrderDetail['PurchaseOrderDetail']['discount'] != NULL) {
                            echo h($purchaseOrderDetail['PurchaseOrderDetail']['discount']) . "%";
                        } else {
                            echo '&#8212;';
                        }
                        ?>
                        &nbsp;
                    </td>
                    <td>
                        <?php echo h($purchaseOrderDetail['PurchaseOrderDetail']['total']); ?>
                        &nbsp;
                    </td>
                    <td>
                        <?php echo h($purchaseOrderDetail['PurchaseOrderDetail']['description']); ?>
                        &nbsp;
                    </td>
                    <td>
                        <?php if ($purchaseOrderDetail['PurchaseOrderDetail']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;</tr>

                <?php $i++; } ?>
            </table>
        <?php echo $this->element('upload-edit', array('usersId' => $purchaseOrder['PurchaseOrder']['created_by'], 'recordId' => $purchaseOrder['PurchaseOrder']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>

    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#purchaseOrders_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $purchaseOrder['PurchaseOrder']['id'], 'ajax'), array('async' => true, 'update' => '#purchaseOrders_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#purchaseOrders_ajax'))); ?>
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
