<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="purchaseOrders ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Purchase Orders', 'modelClass' => 'PurchaseOrder', 'options' => array("sr_no" => "Sr No", "title" => "Title", "order_date" => "Order Date"), 'pluralVar' => 'purchaseOrders'))); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('table th a, .pag_list li span a').on('click', function() {
            var url = $(this).attr("href");
            $('#main').load(url);
            return false;
        });
    });
</script>

        <div class="table-responsive">
            <?php echo $this->Form->create(array('class' => 'no-padding no-margin no-background')); ?>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th><?php echo $this->Paginator->sort('title'); ?></th>
                    <th><?php echo $this->Paginator->sort('type'); ?></th>
                    <th><?php echo $this->Paginator->sort('customer_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('supplier_registration_id', __('Supplier')); ?></th>
                    <th><?php echo $this->Paginator->sort('other'); ?></th>
                    <th><?php echo $this->Paginator->sort('purchase_order_number'); ?></th>
                    <th><?php echo $this->Paginator->sort('order_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php if ($purchaseOrders) {
                        $x = 0;
                        foreach ($purchaseOrders as $purchaseOrder):
                ?>
                <tr>
                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $purchaseOrder['PurchaseOrder']['created_by'], 'postVal' => $purchaseOrder['PurchaseOrder']['id'], 'softDelete' => $purchaseOrder['PurchaseOrder']['soft_delete'])); ?>

                    </td>
                    <td><?php echo h($purchaseOrder['PurchaseOrder']['title']); ?>&nbsp;</td>
                    <td><?php
                        if ($purchaseOrder['PurchaseOrder']['type'] == 1)
                            echo __('Outbound');
                        else if ($purchaseOrder['PurchaseOrder']['type'] == 0)
                            echo __('Inbound');
                        else
                            echo __('Other');
                        ?></td>
                    <td>
                        <?php if(isset($purchaseOrder['Customer']['name'])){ ?>
                        <?php echo $this->Html->link($purchaseOrder['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $purchaseOrder['Customer']['id'])); ?>
                        <?php }else { echo __('-'); }?>
                    </td>
                    <td>
                        <?php if(isset($purchaseOrder['SupplierRegistration']['title'])){ ?>
                        <?php echo $this->Html->link($purchaseOrder['SupplierRegistration']['title'], array('controller' => 'supplier_registrations', 'action' => 'view', $purchaseOrder['SupplierRegistration']['id'])); ?>
                         <?php }else { echo __('-'); }?>
                    </td>
                    <td>
                        <?php if(isset($purchaseOrder['PurchaseOrder']['other']) && $purchaseOrder['PurchaseOrder']['other'] != ''){ ?>
                        <?php echo h($purchaseOrder['PurchaseOrder']['other']); ?>
                        <?php }else { echo __('-'); }?>
                    </td>
                    <td><?php echo h($purchaseOrder['PurchaseOrder']['purchase_order_number']); ?>&nbsp;</td>
                    <td><?php echo h($purchaseOrder['PurchaseOrder']['order_date']); ?>&nbsp;</td>
                    <td><?php echo h($purchaseOrder['PreparedBy']['name']); ?>&nbsp;</td>
                    <td><?php echo h($purchaseOrder['ApprovedBy']['name']); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($purchaseOrder['PurchaseOrder']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                </tr>
                <?php endforeach;
                        } else {
                ?>
                    <tr><td colspan=14><?php echo __('No results found'); ?></td></tr>
                <?php } ?>
            </table>
            <?php echo $this->Form->end(); ?>
        </div>
        <p>
            <?php
                echo $this->Paginator->options(array(
                    'update' => '#main',
                    'evalScripts' => true,
                    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
                    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
                ));

                echo $this->Paginator->counter(array(
                    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                ));
            ?>
        </p>
        <ul class="pagination">
            <?php
                echo "<li class='previous'>" . $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')) . "</li>";
                echo "<li>" . $this->Paginator->numbers(array('separator' => '')) . "</li>";
                echo "<li class='next'>" . $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')) . "</li>";
            ?>
        </ul>
    </div>
</div>

<?php echo $this->element('export'); ?>
<?php echo $this->element('advanced-search', array('postData' => array("title" => "Title", "order_date" => "Order Date", "intimation" => "Intimation", "prices" => "Prices", "insurance" => "Insurance", "shipping_date" => "Shipping date", "ship_by" => "Ship By", "ship_to" => "Ship To", "shipping_details" => "Shipping Details", "invoice_to" => "Invoice To", "payment_details" => "Payment Details", "acknowledgement_details" => "Acknowledgement Details"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "title" => "Title", "order_date" => "Order Date"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->element('common'); ?>
<?php echo $this->Js->writeBuffer(); ?>

<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>