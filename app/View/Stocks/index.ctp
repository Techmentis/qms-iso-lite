<script>
    $(document).ready(function () {
        $('#selectAll').on('click', function () {
            $(this).closest('form').find(':checkbox').prop('checked', this.checked);
            getVals();
        });
    });

    function getVals() {
        var checkedValue = null;
        $("#recs_selected").val(null);
        $("#approve_recs_selected").val(null);
        var inputElements = document.getElementsByTagName('input');

        for (var i = 0; inputElements[i]; ++i) {

            if (inputElements[i].className === "rec_ids" &&
                inputElements[i].checked) {
                $("#approve_recs_selected").val($("#approve_recs_selected").val() + '+' + inputElements[i].value);
                $("#recs_selected").val($("#recs_selected").val() + '+' + inputElements[i].value);

            }
        }
    }
</script>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="stocks ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'Stocks', 'modelClass' => 'Stock', 'options' => array("sr_no" => "Sr No", "type" => "Type", "received_date" => "Received Date", "production_date" => "Production Date", "quantity" => "Quantity", "quantity_consumed" => "Quantity Consumed", "remarks" => "Remarks"), 'pluralVar' => 'stocks'))); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('table th a, .pag_list li span a').on('click', function () {
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
                    <th><?php echo $this->Paginator->sort('type'); ?></th>
                    <th><?php echo $this->Paginator->sort('material_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('material_type_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('list_of_acceptable_supplier_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('purchase_order_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('delivery_challan_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('received_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('production_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('production_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('quantity'); ?></th>
                    <th><?php echo $this->Paginator->sort('quantity_consumed'); ?></th>
                    <th><?php echo $this->Paginator->sort('branch_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('remarks'); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish'); ?></th>


                </tr>
                <?php if ($stocks) {
                        $x = 0;
                        foreach ($stocks as $stock):
                ?>
                <tr>
                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $stock['Stock']['created_by'], 'postVal' => $stock['Stock']['id'], 'softDelete' => $stock['Stock']['soft_delete'])); ?>
                    </td>

                    <td><?php echo h($stock['Stock']['type']); ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($stock['Material']['name'], array('controller' => 'materials', 'action' => 'view', $stock['Material']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($stock['MaterialType']['name'], array('controller' => 'material_types', 'action' => 'view', $stock['MaterialType']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($stock['ListOfAcceptableSupplier']['id'], array('controller' => 'list_of_acceptable_suppliers', 'action' => 'view', $stock['ListOfAcceptableSupplier']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($stock['PurchaseOrder']['title'], array('controller' => 'purchase_orders', 'action' => 'view', $stock['PurchaseOrder']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($stock['DeliveryChallan']['id'], array('controller' => 'delivery_challans', 'action' => 'view', $stock['DeliveryChallan']['id'])); ?>
                    </td>
                    <td><?php echo h($stock['Stock']['received_date']); ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($stock['Production']['id'], array('controller' => 'productions', 'action' => 'view', $stock['Production']['id'])); ?>
                    </td>
                    <td><?php echo h($stock['Stock']['production_date']); ?>&nbsp;</td>
                    <td><?php echo h($stock['Stock']['quantity']); ?>&nbsp;</td>
                    <td><?php echo h($stock['Stock']['quantity_consumed']); ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($stock['Branch']['name'], array('controller' => 'branches', 'action' => 'view', $stock['Branch']['id'])); ?>
                    </td>
                    <td><?php echo h($stock['Stock']['remarks']); ?>&nbsp;</td>
                    <td><?php echo h($stock['PreparedBy']['prepared_by']); ?>&nbsp;</td>
                    <td><?php echo h($stock['ApprovedBy']['approved_by']); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($stock['Stock']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($stock['Company']['name'], array('controller' => 'companies', 'action' => 'view', $stock['Company']['id'])); ?>
                    </td>
                </tr>
                <?php
                    $x++;
                    endforeach;
                    } else {
                ?>
                <tr><td colspan=26>No results found</td></tr>
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
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "type" => "Type", "received_date" => "Received Date", "production_date" => "Production Date", "quantity" => "Quantity", "quantity_consumed" => "Quantity Consumed", "remarks" => "Remarks", 'flag' => $this->request->params['pass'][0]), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "type" => "Type", "received_date" => "Received Date", "production_date" => "Production Date", "quantity" => "Quantity", "quantity_consumed" => "Quantity Consumed", "remarks" => "Remarks"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->element('common'); ?>
<?php echo $this->Js->writeBuffer(); ?>

<script>
    $.ajaxSetup({
        beforeSend: function () {
            $("#busy-indicator").show();
        },
        complete: function () {
            $("#busy-indicator").hide();
        }
    });
</script>