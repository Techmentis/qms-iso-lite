<h2><?php echo __('Purchase Order Details'); ?></h2>
<table class="table table-responsive">
    <tr>
        <td><?php echo __('Title'); ?></td>
        <td><?php echo h($purchaseOrder['PurchaseOrder']['title']); ?>&nbsp;</td>
    </tr>
    <tr>
        <td><?php echo __('Type'); ?></td>
        <td><?php
                if ($purchaseOrder['PurchaseOrder']['type'] == 0) {
                    echo 'Inbound';
                }
                if ($purchaseOrder['PurchaseOrder']['type'] == 1) {
                    echo 'Outbound';
                }
                if ($purchaseOrder['PurchaseOrder']['type'] == 2) {
                    echo 'Other';
                }
            ?>&nbsp;
        </td>
    </tr>
    <tr>
        <td><?php echo __('Order Number'); ?></td>
        <td><?php echo h($purchaseOrder['PurchaseOrder']['purchase_order_number']); ?>&nbsp;</td>
    </tr>
    <tr>
        <td><?php echo __('Order Date'); ?></td>
        <td><?php echo h($purchaseOrder['PurchaseOrder']['order_date']); ?>&nbsp;</td>
    </tr>
    <tr>
        <td><?php echo __('Intimation'); ?></td>
        <td><?php echo $purchaseOrder['PurchaseOrder']['intimation']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td><?php echo __('Expected Develivery Date'); ?></td>
        <td><?php echo $purchaseOrder['PurchaseOrder']['expected_delivery_date']; ?>&nbsp;</td>
    </tr>
    <tr>
        <?php if ($purchaseOrder['PurchaseOrder']['type'] == 1) { ?>
            <td><?php echo __('Supplier'); ?></td>
            <td><?php echo $purchaseOrder['SupplierRegistration']['title']; ?>&nbsp;

        <?php } if ($purchaseOrder['PurchaseOrder']['type'] == 0) { ?>
            <td><?php echo __('Customer'); ?></td>
            <td><?php echo $purchaseOrder['Customer']['name']; ?>&nbsp;
        <?php } if ($purchaseOrder['PurchaseOrder']['type'] == 2) { ?>
            <td><?php echo __('Other'); ?></td>
            <td><?php echo $purchaseOrder['PurchaseOrder']['other']; ?>&nbsp;
        <?php } ?>
        </td>
    </tr>
</table>

<table class="table table-responsive">
    <tr>
        <th><?php echo __('Number'); ?></th>
        <th colspan="3"><?php echo h('Product/ Device/ Material/ Other'); ?></th>
        <th><?php echo __('Quantity Ordered'); ?></th>
        <th><?php echo __('Description'); ?></th>
        <th><?php echo __('Discount'); ?></th>
        <th><?php echo __('Rate'); ?></th>
        <th><?php echo __('Total'); ?></th>
    </tr>
    <?php $i = 1; ?>
    <?php foreach ($purchaseOrderDetails as $purchaseOrderDetail) { ?>
        <?php if ($purchaseOrderDetail['Material']['qc_required'] != 0) { ?>
            <tr class="alert alert-danger">
            <?php } else { ?>
            <tr>
            <?php } ?>
            <td><?php echo h($purchaseOrderDetail['PurchaseOrderDetail']['item_number']); ?>&nbsp;</td>
            <td colspan="3">
                <?php echo $this->Html->link($purchaseOrderDetail['Product']['name'], array('controller' => 'products', 'action' => 'view', $purchaseOrderDetail['Product']['id'])); ?>
                <?php echo $this->Html->link($purchaseOrderDetail['Device']['name'], array('controller' => 'devices', 'action' => 'view', $purchaseOrderDetail['Device']['id'])); ?>
                <?php echo $this->Html->link($purchaseOrderDetail['Material']['name'], array('controller' => 'materials', 'action' => 'view', $purchaseOrderDetail['Material']['id'])); ?>
                <?php echo $purchaseOrderDetail['PurchaseOrderDetail']['other']; ?>
            </td>
            <td><?php echo h($purchaseOrderDetail['PurchaseOrderDetail']['quantity']); ?>&nbsp;</td>
            <td><?php echo h($purchaseOrderDetail['PurchaseOrderDetail']['description']); ?>&nbsp;</td>
            <td><?php
                if ($purchaseOrderDetail['PurchaseOrderDetail']['discount'] > 0)
                    echo h($purchaseOrderDetail['PurchaseOrderDetail']['discount']);
                else
                    echo '0%';
                ?>&nbsp;</td>
            <td><?php echo h($purchaseOrderDetail['PurchaseOrderDetail']['rate']); ?>&nbsp;</td>
            <td><?php echo h($purchaseOrderDetail['PurchaseOrderDetail']['total']); ?>&nbsp;</td>
        </tr>
        <?php if ($purchaseOrderDetail['Material']['qc_required'] != 0) { ?>
            <tr class="alert alert-danger">
            <?php } else { ?>
            <tr>
            <?php } ?>
            <th colspan="3"><br /><h4><?php echo __('Challan Values'); ?></h4></th>
    <th><?php echo $this->Form->input('delivery_challan_details.' . $i . '.quantity', array('value' => $purchaseOrderDetail['PurchaseOrderDetail']['quantity'], 'readonly' => 'readonly')); ?></th>
    <th><?php echo $this->Form->input('delivery_challan_details.' . $i . '.quantity_received', array('label' => 'Received', 'value' => $purchaseOrderDetail['PurchaseOrderDetail']['quantity'])); ?></th>
    <th><?php echo $this->Form->input('delivery_challan_details.' . $i . '.description', array('value' => $purchaseOrderDetail['PurchaseOrderDetail']['description'])); ?></th>
    <th><?php echo $this->Form->input('delivery_challan_details.' . $i . '.discount', array('placeholder' => '0%', 'value' => $purchaseOrderDetail['PurchaseOrderDetail']['discount'])); ?></th>
    <th><?php echo $this->Form->input('delivery_challan_details.' . $i . '.rate', array('value' => $purchaseOrderDetail['PurchaseOrderDetail']['rate'])); ?></th>
    <th><?php echo $this->Form->input('delivery_challan_details.' . $i . '.total', array('value' => $purchaseOrderDetail['PurchaseOrderDetail']['total'], 'readonly' => 'readonly')); ?></th>
    </tr>
    <?php if ($purchaseOrderDetail['Material']['qc_required'] != 0) { ?>
        <tr class="alert alert-danger">
            <td colspan="9">
                <h6><span class="glyphicon glyphicon-hand-right">&nbsp;</span><?php echo __('This material requires Quality Checks therefore it can not be added to Stock.'); ?></h6>
            </td>&nbsp;</tr>
    <?php } ?>
    <tr>
        <th><?php echo $this->Form->hidden('delivery_challan_details.' . $i . '.product_id', array('value' => $purchaseOrderDetail['Product']['id'])); ?></th>
        <th><?php echo $this->Form->hidden('delivery_challan_details.' . $i . '.device_id', array('value' => $purchaseOrderDetail['Device']['id'])); ?></th>
        <th><?php echo $this->Form->hidden('delivery_challan_details.' . $i . '.material_id', array('value' => $purchaseOrderDetail['Material']['id'])); ?></th>
        <th><?php echo $this->Form->hidden('delivery_challan_details.' . $i . '.purchase_order_id', array('value' => $purchaseOrder['PurchaseOrder']['id'])); ?></th>
        <th><?php echo $this->Form->hidden('delivery_challan_details.' . $i . '.purchase_order_details_id', array('value' => $purchaseOrderDetail['PurchaseOrderDetail']['id'])); ?></th>
        <th><?php echo $this->Form->hidden('delivery_challan_details.' . $i . '.item_number', array('value' => $purchaseOrderDetail['PurchaseOrderDetail']['item_number'])); ?></th>
    </tr>
    <script>
        $('#delivery_challan_details<?php echo $i; ?>Rate').blur(function() {
            var total = $('#delivery_challan_details<?php echo $i; ?>Rate').val() * $('#delivery_challan_details<?php echo $i; ?>QuantityReceived').val();

            if ($('#delivery_challan_details<?php echo $i; ?>Rate').val() != null) {
                var total = total - (total * $('#delivery_challan_details<?php echo $i; ?>Discount').val() / 100);
            } else {
                var total = total;
            }
            $('#delivery_challan_details<?php echo $i; ?>Total').val(total);
        });
        $('#delivery_challan_details<?php echo $i; ?>Discount').blur(function() {
            var total = $('#delivery_challan_details<?php echo $i; ?>Rate').val() * $('#delivery_challan_details<?php echo $i; ?>QuantityReceived').val();

            if ($('#delivery_challan_details<?php echo $i; ?>Rate').val() != null) {
                var total = total - (total * $('#delivery_challan_details<?php echo $i; ?>Discount').val() / 100);
            } else {
                var total = total;
            }
            $('#delivery_challan_details<?php echo $i; ?>Total').val(total);
        });
        $('#delivery_challan_details<?php echo $i; ?>QuantityReceived').blur(function() {
            var total = $('#delivery_challan_details<?php echo $i; ?>Rate').val() * $('#delivery_challan_details<?php echo $i; ?>QuantityReceived').val();
            if ($('#delivery_challan_details<?php echo $i; ?>Rate').val() != null) {
                var total = total - (total * $('#delivery_challan_details<?php echo $i; ?>Discount').val() / 100);
            } else {
                var total = total;
            }
            $('#delivery_challan_details<?php echo $i; ?>Total').val(total);
        });
    </script>
    <?php $i++; } ?>
</table>
<hr>