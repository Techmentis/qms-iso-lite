<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min', 'bootstrap-editable.min')); ?>
<?php echo $this->Html->css(array('bootstrap-editable')); ?>
<?php echo $this->fetch('script'); ?>
<?php echo $this->fetch('css'); ?>
<?php echo $this->element('checkbox-script'); ?>
<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="supplierEvaluationReevaluations ">

<script type="text/javascript">
    $(document).ready(function() {
        $('table th a, .pag_list li span a').on('click', function() {
            var url = $(this).attr("href");
            $('#main').load(url);
            return false;
        });
        $('#SupplierEvaluationReevaluationSupplierRegistrationId').chosen();
    });
</script>

<script>
    $().ready(function() {
        $("#SupplierEvaluationReevaluationSupplierRegistrationId").change(function() {
            $("#main").load(
                    "supplier_evaluation_reevaluations/evaluate/" + $("#SupplierEvaluationReevaluationSupplierRegistrationId").val())
        })
    });
</script>

        <div class="panel panel-default from add_ajax">
            <div class="row"><div class="col-md-6">
                    <?php
                    echo $this->Form->create('SupplierEvaluationReevaluation', array('role' => 'from', 'class' => 'from'));
                    echo $this->Form->input('supplier_registration_id', array('label' => __('Select Supplier from the list to evaluate.')));
                    echo $this->Form->end();
                    ?>
                </div>
                <div class="col-md-6"></div>
            </div>
        </div>
        <div class="alert alert-info">
            <b><?php echo __('In order to evaluate Suppliers, you need to add Quantity Shipped VS Quantity Accepted & Required Delivery Date VS Actual Delivery Date values for below table. Based on these values, evaluation will be done.'); ?></b>
        </div>
        <div class="table-responsive">
            <?php echo $this->Form->create(array('class' => 'no-padding no-margin no-background')); ?>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
                <tr>
                    <th><?php echo $this->Paginator->sort('supplier_registration_id', __('Supplier')); ?></th>
                    <th><?php echo $this->Paginator->sort('delivery_challan_id', __('Delivery Challan')); ?></th>
                    <th><?php echo $this->Paginator->sort('product_id', __('Product')); ?> / <?php echo $this->Paginator->sort('device_id', __('Device')); ?></th>
                    <th><?php echo $this->Paginator->sort('quantity_supplied', __('Quantity Supplied')); ?></th>
                    <th><?php echo $this->Paginator->sort('quantity_accepted', __('Quantity Accepted')); ?></th>
                    <th><?php echo $this->Paginator->sort('required_delivery_date', __('Required Delivery Date')); ?></th>
                    <th><?php echo $this->Paginator->sort('actual_delivery_date', __('Actual Delivery Date')); ?></th>
                    <th><?php echo $this->Paginator->sort('remarks', __('Remarks')); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php if ($supplierEvaluationReevaluations) {
                        $x = 0;
                        foreach ($supplierEvaluationReevaluations as $supplierEvaluationReevaluation):?>

                <tr>
                    <td>
                        <?php echo $this->Html->link($supplierEvaluationReevaluation['SupplierRegistration']['title'], array('controller' => 'supplier_registrations', 'action' => 'view', $supplierEvaluationReevaluation['SupplierRegistration']['id'])); ?>
                    </td>
                    <td><?php echo $supplierEvaluationReevaluation['DeliveryChallan']['name']; ?>&nbsp;</td>

                    <td>
                        <?php echo $this->Html->link($supplierEvaluationReevaluation['Material']['name'], array('controller' => 'material', 'action' => 'view', $supplierEvaluationReevaluation['Material']['id'])); ?>
                    </td>
                    <td><?php echo $supplierEvaluationReevaluation['SupplierEvaluationReevaluation']['quantity_supplied']; ?>&nbsp;</td>
                    <td><?php echo $supplierEvaluationReevaluation['SupplierEvaluationReevaluation']['quantity_accepted']; ?>&nbsp;</td>
                    <td><?php echo $supplierEvaluationReevaluation['SupplierEvaluationReevaluation']['required_delivery_date']; ?>&nbsp;</td>
                    <td><?php echo $supplierEvaluationReevaluation['SupplierEvaluationReevaluation']['actual_delivery_date']; ?>&nbsp;</td>
                    <td><?php echo $supplierEvaluationReevaluation['SupplierEvaluationReevaluation']['remarks']; ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$supplierEvaluationReevaluation['SupplierEvaluationReevaluation']['prepared_by']]); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$supplierEvaluationReevaluation['SupplierEvaluationReevaluation']['approved_by']]); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($supplierEvaluationReevaluation['SupplierEvaluationReevaluation']['publish'] == 1) { ?>
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
                <tr><td colspan=21><?php echo __('No results found'); ?></td></tr>
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
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "delivery_challan_id" => "Delivery Challan No", "challan_date" => "Challan Date", "quantity_supplied" => "Quantity Supplied", "quantity_accepted" => "Quantity Accepted", "required_delivery_date" => "Required Delivery Date", "actual_delivery_datedate" => "Actual Delivery Date", "remarks" => "Remarks"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "delivery_challan_id" => "Delivery Challan No", "challan_date" => "Challan Date", "quantity_supplied" => "Quantity Supplied", "quantity_accepted" => "Quantity Accepted", "required_delivery_date" => "Required Delivery Date", "actual_delivery_datedate" => "Actual Delivery Date", "remarks" => "Remarks"))); ?>
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