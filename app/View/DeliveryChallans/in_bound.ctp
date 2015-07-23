<?php echo $this->element('checkbox-script'); ?>

<div  id="main" class="inbound">
    <?php echo $this->Session->flash(); ?>
    <div class="deliveryChallans ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Delivery Challans', 'modelClass' => 'DeliveryChallan', 'options' => array("sr_no" => "Sr No", "challan_number" => "Challan Number", "challan_date" => "Challan Date", "challan_details" => "Challan Details", "customer_details" => "Customer Details", "other_reference_number" => "Other Reference Number", "details" => "Details", "remarks" => "Remarks"), 'pluralVar' => 'deliveryChallans'))); ?>

        <script type="text/javascript">
            $(document).ready(function() {
                $('table th a, .pag_list li span a').on('click', function() {
                    var url = $(this).attr("href");
                    $('.inbound').load(url);
                    return false;
                });
            });
        </script>
        <div class="table-responsive">
            <?php echo $this->Form->create(array('class' => 'no-padding no-margin no-background')); ?>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
                <tr>
                    <th colspan="2"><input type="checkbox" id="selectAll"></th>
                    <th><?php echo $this->Paginator->sort('sr_no', __('Sr. No')); ?></th>
                    <th><?php echo $this->Paginator->sort('branch_id', __('Branch')); ?></th>
                    <th><?php echo $this->Paginator->sort('department_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('challan_number'); ?></th>
                    <th><?php echo $this->Paginator->sort('challan_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('challan_details'); ?></th>
                    <th><?php echo $this->Paginator->sort('customer_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('customer_details'); ?></th>
                    <th><?php echo $this->Paginator->sort('supplier_registration_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('other_reference_number'); ?></th>
                    <th><?php echo $this->Paginator->sort('details'); ?></th>
                    <th><?php echo $this->Paginator->sort('remarks'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php
                if ($deliveryChallans) {
                    $x = 0;
                    foreach ($deliveryChallans as $deliveryChallan):
                        ?>
                        <tr>
                            <td width="15"><?php echo $this->Form->checkbox('rec_ids_' . $x, array('label' => false, 'value' => $deliveryChallan['DeliveryChallan']['id'], 'multiple' => 'checkbox', 'class' => 'rec_ids', 'onClick' => 'getVals()')); ?></td>
                            <td class=" actions">
                                <?php echo $this->element('actions', array('postVal' => $deliveryChallan['DeliveryChallan']['id'], 'softDelete' => $deliveryChallan['DeliveryChallan']['soft_delete'])); ?>
                            </td>
                            <td width="50"><?php echo h($deliveryChallan['DeliveryChallan']['sr_no']); ?>&nbsp;</td>
                            <td>
                                <?php echo $this->Html->link($deliveryChallan['Branch']['name'], array('controller' => 'branches', 'action' => 'view', $deliveryChallan['Branch']['id'])); ?>
                            </td>
                            <td>
                                <?php echo $this->Html->link($deliveryChallan['Department']['name'], array('controller' => 'departments', 'action' => 'view', $deliveryChallan['Department']['id'])); ?>
                            </td>
                            <td><?php echo h($deliveryChallan['DeliveryChallan']['challan_number']); ?>&nbsp;</td>
                            <td><?php echo h($deliveryChallan['DeliveryChallan']['challan_date']); ?>&nbsp;</td>
                            <td><?php echo h($deliveryChallan['DeliveryChallan']['challan_details']); ?>&nbsp;</td>
                            <td>
                                <?php echo $this->Html->link($deliveryChallan['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $deliveryChallan['Customer']['id'])); ?>
                            </td>
                            <td><?php echo h($deliveryChallan['DeliveryChallan']['customer_details']); ?>&nbsp;</td>
                            <td>
                                <?php echo $this->Html->link($deliveryChallan['SupplierRegistration']['title'], array('controller' => 'supplier_registrations', 'action' => 'view', $deliveryChallan['SupplierRegistration']['id'])); ?>
                            </td>
                            <td><?php echo h($deliveryChallan['DeliveryChallan']['other_reference_number']); ?>&nbsp;</td>
                            <td><?php echo h($deliveryChallan['DeliveryChallan']['details']); ?>&nbsp;</td>
                            <td><?php echo h($deliveryChallan['DeliveryChallan']['remarks']); ?>&nbsp;</td>

                            <td width="60">
                                <?php if ($deliveryChallan['DeliveryChallan']['publish'] == 1) { ?>
                                    <span class="glyphicon glyphicon-ok-sign"></span>
                                <?php } else { ?>
                                    <span class="glyphicon glyphicon-remove-circle"></span>
                                <?php } ?>&nbsp;</td>
                        </tr>
                        <?php
                        $x++;
                    endforeach;
                } else {
                    ?>
                    <tr><td colspan=23>No results found</td></tr>
                <?php } ?>
            </table>
            <?php echo $this->Form->end(); ?>
        </div>
        <p>
            <?php
            echo $this->Paginator->options(array(
                'update' => '.inbound',
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
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "challan_number" => "Challan Number", "challan_date" => "Challan Date", "challan_details" => "Challan Details", "customer_details" => "Customer Details", "other_reference_number" => "Other Reference Number", "details" => "Details", "remarks" => "Remarks"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "challan_number" => "Challan Number", "challan_date" => "Challan Date", "challan_details" => "Challan Details", "customer_details" => "Customer Details", "other_reference_number" => "Other Reference Number", "details" => "Details", "remarks" => "Remarks"))); ?>
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