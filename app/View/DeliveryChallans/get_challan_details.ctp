<h2><?php echo __('Purchase Order Details'); ?></h2>
<table class="table table-responsive">
    <tr>
        <td><?php echo __('Title'); ?></td>
        <td><?php echo h($challanDetails['PurchaseOrder']['title']);?>&nbsp;</td>
    </tr>
    <tr>
        <td><?php echo __('Type'); ?></td>
        <td><?php
                if ($challanDetails['PurchaseOrder']['type'] == 0) {
                    echo 'Inbound';
                }
                if ($challanDetails['PurchaseOrder']['type'] == 1) {
                    echo 'Outbound';
                }
                if ($challanDetails['PurchaseOrder']['type'] == 2) {
                    echo 'Other';
                }
            ?>&nbsp;</td>
    </tr>
    <tr>
        <td><?php echo __('Order Date'); ?></td>
        <td><?php echo h($challanDetails['PurchaseOrder']['order_date']); ?>&nbsp;</td>
    </tr>
    <tr>
        <td><?php echo __('Intimation'); ?></td>
        <td><?php echo $challanDetails['PurchaseOrder']['intimation']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td><?php echo __('Expected Develivery Date'); ?></td>
        <td><?php echo $challanDetails['PurchaseOrder']['expected_delivery_date']; ?>&nbsp;</td>
    </tr>
    <tr>
        <td><?php echo __('Supplier'); ?></td>
        <td><?php echo $challanDetails['SupplierRegistration']['title']; ?>&nbsp;</td>
    </tr>
</table>

<table class="table table-responsive">
    <tr>

        <th colspan="3"><?php echo __('Number'); ?></th>
        <th><?php echo __('Product/ Device/ Material/ Other'); ?></th>
        <th><?php echo h('Quantity Ordered'); ?></th>
        <th><?php echo __('Description'); ?></th>
        <th><?php echo __('Discount'); ?></th>
        <th><?php echo __('Rate'); ?></th>
        <th><?php echo __('Total'); ?></th>
    </tr>
    <?php $ij = 1; ?>
    <?php foreach ($challanDetails['DeliveryChallanDetail'] as $detail) { ?>
        <?php if ($detail['PurchaseOrderDetail'][3]['qc_required'] != 0) { ?>
            <tr class="alert alert-danger">
            <?php } else { ?>
            <tr>
            <?php } ?>
            <td colspan="3"><?php echo h($detail['PurchaseOrderDetail'][0]['item_number']); ?>&nbsp;</td>
            <td>
                <?php if (isset($detail['PurchaseOrderDetail'][1]['name'])) echo $this->Html->link($detail['PurchaseOrderDetail'][1]['name'], array('controller' => 'products', 'action' => 'view', $detail['PurchaseOrderDetail'][1]['id'])); ?>
                <?php if (isset($detail['PurchaseOrderDetail'][2]['name'])) echo $this->Html->link($detail['PurchaseOrderDetail'][2]['name'], array('controller' => 'devices', 'action' => 'view', $detail['PurchaseOrderDetail'][2]['id'])); ?>
                <?php if (isset($detail['PurchaseOrderDetail'][3]['name'])) echo $this->Html->link($detail['PurchaseOrderDetail'][3]['name'], array('controller' => 'materials', 'action' => 'view', $detail['PurchaseOrderDetail'][3]['id'])); ?>
                <?php if (isset($detail['PurchaseOrderDetail'][0]['other'])) echo $detail['PurchaseOrderDetail'][0]['other']; ?>
            </td>
            <td><?php echo h($detail['PurchaseOrderDetail'][0]['quantity']); ?>&nbsp;</td>
            <td><?php echo h($detail['PurchaseOrderDetail'][0]['description']); ?>&nbsp;</td>
            <td><?php echo h($detail['PurchaseOrderDetail'][0]['discount']); ?>&nbsp;</td>
            <td><?php echo h($detail['PurchaseOrderDetail'][0]['rate']); ?>&nbsp;</td>
            <td><?php echo h($detail['PurchaseOrderDetail'][0]['total']); ?>&nbsp;</td>
        </tr>
        <?php if ($detail['PurchaseOrderDetail'][3]['qc_required'] != 0) { ?>
            <tr class="alert alert-danger">
            <?php } else { ?>
            <tr>
            <?php } ?>
            <th colspan="3"><br /><h4><?php echo __('Challan Values'); ?></h4></th>
    <th><?php echo $this->Form->input('delivery_challan_details.' . $ij . '.quantity', array('value' => $detail['PurchaseOrderDetail'][0]['quantity'], 'readonly' => 'readonly')); ?></th>
    <th><?php echo $this->Form->input('delivery_challan_details.' . $ij . '.quantity_received', array('label' => 'Received', 'value' => $detail['quantity_received'])); ?></th>
    <th><?php echo $this->Form->input('delivery_challan_details.' . $ij . '.description', array('value' => $detail['description'])); ?></th>
    <th><?php echo $this->Form->input('delivery_challan_details.' . $ij . '.discount', array('value' => $detail['discount'])); ?></th>
    <th><?php echo $this->Form->input('delivery_challan_details.' . $ij . '.rate', array('value' => $detail['rate'])); ?></th>
    <th><?php echo $this->Form->input('delivery_challan_details.' . $ij . '.total', array('value' => $detail['total'], 'readonly' => 'readonly')); ?></th>
    </tr>
    <?php if ($detail['PurchaseOrderDetail'][3]['qc_required'] != 0) { ?>
        <tr class="alert alert-danger"><td colspan="9">
                <h6><span class="glyphicon glyphicon-hand-right">&nbsp;</span><?php echo __('This material requires Quality Checks therefore it can not be added to Stock.'); ?></h6>
            </td>&nbsp;</tr>
    <?php } ?>
    <tr>
        <th><?php echo $this->Form->hidden('delivery_challan_details.' . $ij . '.product_id', array('value' => $detail['PurchaseOrderDetail'][1]['id'])); ?></th>
        <th><?php echo $this->Form->hidden('delivery_challan_details.' . $ij . '.device_id', array('value' => $detail['PurchaseOrderDetail'][2]['id'])); ?></th>
        <th><?php echo $this->Form->hidden('delivery_challan_details.' . $ij . '.material_id', array('value' => $detail['PurchaseOrderDetail'][3]['id'])); ?></th>
        <th><?php echo $this->Form->hidden('delivery_challan_details.' . $ij . '.other', array('value' => $detail['PurchaseOrderDetail'][0]['other'])); ?></th>
        <th><?php echo $this->Form->hidden('delivery_challan_details.' . $ij . '.purchase_order_id', array('value' => $detail['PurchaseOrderDetail'][0]['purchase_order_id'])); ?></th>
        <th><?php echo $this->Form->hidden('delivery_challan_details.' . $ij . '.purchase_order_details_id', array('value' => $detail['PurchaseOrderDetail'][0]['id'])); ?></th>
        <th><?php echo $this->Form->hidden('delivery_challan_details.' . $ij . '.quantity_dispatch', array('value' => $detail['PurchaseOrderDetail'][0]['quantity_dispatch'])); ?></th>
        <th><?php echo $this->Form->hidden('delivery_challan_details.' . $ij . '.item_number', array('value' => $detail['PurchaseOrderDetail'][0]['item_number'])); ?></th>
    </tr>
    <script>
        $('#delivery_challan_details<?php echo $ij; ?>Rate').blur(function() {
            var total = $('#delivery_challan_details<?php echo $ij; ?>Rate').val() * $('#delivery_challan_details<?php echo $ij; ?>QuantityReceived').val();
            if ($('#delivery_challan_details<?php echo $ij; ?>Rate').val() != null) {
                var total = total - (total * $('#delivery_challan_details<?php echo $ij; ?>Discount').val() / 100);
            } else {
                var total = total;
            }
            $('#delivery_challan_details<?php echo $ij; ?>Total').val(total);
        });
        $('#delivery_challan_details<?php echo $ij; ?>QuantityReceived').blur(function() {
            var total = $('#delivery_challan_details<?php echo $ij; ?>Rate').val() * $('#delivery_challan_details<?php echo $ij; ?>QuantityReceived').val();
            if ($('#delivery_challan_details<?php echo $ij; ?>Rate').val() != null) {
                var total = total - (total * $('#delivery_challan_details<?php echo $ij; ?>Discount').val() / 100);
            } else {
                var total = total;
            }
            $('#delivery_challan_details<?php echo $ij; ?>Total').val(total);
        });
        $('#delivery_challan_details<?php echo $ij; ?>Discount').blur(function() {
            var total = $('#delivery_challan_details<?php echo $ij; ?>Rate').val() * $('#delivery_challan_details<?php echo $ij; ?>QuantityReceived').val();

            if ($('#delivery_challan_details<?php echo $ij; ?>Rate').val() != null) {
                var total = total - (total * $('#delivery_challan_details<?php echo $ij; ?>Discount').val() / 100);
            } else {
                var total = total;
            }
            $('#delivery_challan_details<?php echo $ij; ?>Total').val(total);
        });
    </script>
    <?php $ij++; } ?>
</table>
<hr>