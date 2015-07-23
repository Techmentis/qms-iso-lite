<div id="deliveryChallans_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="deliveryChallans form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Delivery Challan'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Branch'); ?></td>
                    <td>
                        <?php echo $this->Html->link($deliveryChallan['Branch']['name'], array('controller' => 'branches', 'action' => 'view', $deliveryChallan['Branch']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Department'); ?></td>
                    <td>
                        <?php echo $this->Html->link($deliveryChallan['Department']['name'], array('controller' => 'departments', 'action' => 'view', $deliveryChallan['Department']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td><?php echo __('Purchase Order Number'); ?></td>
                    <td>
                        <?php echo h($deliveryChallan['PurchaseOrder']['purchase_order_number']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Challan Number'); ?></td>
                    <td>
                        <?php echo h($deliveryChallan['DeliveryChallan']['challan_number']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Challan Date'); ?></td>
                    <td>
                        <?php echo h($deliveryChallan['DeliveryChallan']['challan_date']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prices'); ?></td>
                    <td>
                        <?php echo h($deliveryChallan['DeliveryChallan']['prices']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Ship By'); ?></td>
                    <td>
                        <?php echo h($deliveryChallan['DeliveryChallan']['ship_by']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Shipping Details'); ?></td>
                    <td>
                        <?php echo h($deliveryChallan['DeliveryChallan']['shipping_details']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Insurance'); ?></td>
                    <td>
                        <?php echo $deliveryChallan['DeliveryChallan']['insurance']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Shipping Date'); ?></td>
                    <td>
                        <?php echo h($deliveryChallan['DeliveryChallan']['shipping_date']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Ship To'); ?></td>
                    <td>
                        <?php echo h($deliveryChallan['DeliveryChallan']['ship_to']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Payment Details'); ?></td>
                    <td>
                        <?php echo h($deliveryChallan['DeliveryChallan']['payment_details']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Invoice To'); ?></td>
                    <td>
                        <?php echo h($deliveryChallan['DeliveryChallan']['invoice_to']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Acknowledgement Details'); ?></td>
                    <td>
                        <?php echo h($deliveryChallan['DeliveryChallan']['acknowledgement_details']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Acknowledgement Date'); ?></td>
                    <td>
                        <?php echo h($deliveryChallan['DeliveryChallan']['acknowledgement_date']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($deliveryChallan['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($deliveryChallan['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($deliveryChallan['DeliveryChallan']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>

            </table>
            <table class="table table-responsive">
                <tr><td colspan="9"><h4><?php echo __('Delivery Challan Detail') ; ?></h4></td></tr>
                <tr>
                    <th><?php echo __('Number'); ?></th>
                    <th><?php echo __('Product / Device/ Material/ Other'); ?></th>
                    <th><?php echo __('Quantity Ordered'); ?></th>
                    <th><?php echo __('Quantity Received'); ?></th>
                    <th><?php echo __('Rate'); ?></th>
                    <th><?php echo __('Discount'); ?></th>
                    <th class="text-center"><?php echo __('Material QC Required?'); ?></th>
                    <th><?php echo __('Total'); ?></th>
                </tr>
                <?php
                    $i = 1;
                    foreach ($deliveryChallanDetails as $deliveryChallanDetail) {
                ?>
                <tr>
                    <td>
                        <?php echo h($deliveryChallanDetail['DeliveryChallanDetail']['item_number']); ?>
                        &nbsp;
                    </td>
                    <td>
                        <?php echo $this->Html->link($deliveryChallanDetail['Product']['name'], array('controller' => 'products', 'action' => 'view', $deliveryChallanDetail['Product']['id'])); ?>
                        <?php echo $this->Html->link($deliveryChallanDetail['Device']['name'], array('controller' => 'devices', 'action' => 'view', $deliveryChallanDetail['Device']['id'])); ?>
                        <?php echo $this->Html->link($deliveryChallanDetail['Material']['name'], array('controller' => 'materials', 'action' => 'view', $deliveryChallanDetail['Material']['id'])); ?>
                        <?php echo h($deliveryChallanDetail['PurchaseOrderDetail']['other']); ?>
                        &nbsp;
                    </td>
                    <td>
                        <?php echo h($deliveryChallanDetail['DeliveryChallanDetail']['quantity']); ?>
                        &nbsp;
                    </td>
                    <td>
                        <?php echo h($deliveryChallanDetail['DeliveryChallanDetail']['quantity_received']); ?>
                        &nbsp;
                    </td>

                    <td>
                        <?php echo h($deliveryChallanDetail['DeliveryChallanDetail']['rate']); ?>
                        &nbsp;
                    </td>
                    <td>
                        <?php echo h($deliveryChallanDetail['DeliveryChallanDetail']['discount']); ?>
                        &nbsp;
                    </td>
                    <td class="text-center">
                        <?php echo h($deliveryChallanDetail['DeliveryChallanDetail']['material_qc_required']) ? __('Yes') : __('No'); ?>
                        &nbsp;
                    </td>
                    <td>
                        <?php echo h($deliveryChallanDetail['DeliveryChallanDetail']['total']); ?>
                        &nbsp;
                    </td>
                </tr>
                <?php $i++; } ?>
            </table>

            <?php echo $this->element('upload-edit', array('usersId' => $deliveryChallan['DeliveryChallan']['created_by'], 'recordId' => $deliveryChallan['DeliveryChallan']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#deliveryChallans_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $deliveryChallan['DeliveryChallan']['id'], 'ajax'), array('async' => true, 'update' => '#deliveryChallans_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#deliveryChallans_ajax'))); ?>
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
