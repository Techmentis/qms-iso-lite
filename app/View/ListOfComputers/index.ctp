
<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
    <?php echo $this->Session->flash(); ?>
    <div class="listOfComputers ">
        <?php echo $this->element('nav-header-lists', array('postData' => array('pluralHumanName' => 'List Of Computers', 'modelClass' => 'ListOfComputer', 'options' => array("sr_no" => "Sr No", "make" => "Make", "serial_number" => "Serial Number", "price" => "Price", "installation_date" => "Installation Date", "other_details" => "Other Details"), 'pluralVar' => 'listOfComputers'))); ?>

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
                    <th><?php echo $this->Paginator->sort('employee_id', __('Employee')); ?></th>
                    <th><?php echo $this->Paginator->sort('make', __('Make')); ?></th>
                    <th><?php echo $this->Paginator->sort('serial_number', __('Serial Number')); ?></th>
                    <th><?php echo $this->Paginator->sort('supplier_registration_id', __('Supplier')); ?></th>
                    <th><?php echo $this->Paginator->sort('purchase_order_id', __('Purchase Order')); ?></th>
                    <th><?php echo $this->Paginator->sort('price', __('Price')); ?></th>
                    <th><?php echo $this->Paginator->sort('installation_date', __('Installation Date')); ?></th>
                    <th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('approved_by'); ?></th>
                    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
                </tr>
                <?php
                    if ($listOfComputers) {
                        $x = 0;
                        foreach ($listOfComputers as $listOfComputer):
                ?>
                <tr>

                    <td class=" actions">
                        <?php echo $this->element('actions', array('created' => $listOfComputer['ListOfComputer']['created_by'], 'postVal' => $listOfComputer['ListOfComputer']['id'], 'softDelete' => $listOfComputer['ListOfComputer']['soft_delete'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($listOfComputer['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $listOfComputer['Employee']['id'])); ?>
                    </td>
                    <td><?php echo $listOfComputer['ListOfComputer']['make']; ?>&nbsp;</td>
                    <td><?php echo $listOfComputer['ListOfComputer']['serial_number']; ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($listOfComputer['SupplierRegistration']['title'], array('controller' => 'supplier_registrations', 'action' => 'view', $listOfComputer['SupplierRegistration']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($listOfComputer['PurchaseOrder']['title'], array('controller' => 'purchase_orders', 'action' => 'view', $listOfComputer['PurchaseOrder']['id'])); ?>
                    </td>
                    <td><?php echo $listOfComputer['ListOfComputer']['price']; ?>&nbsp;</td>
                    <td><?php echo $listOfComputer['ListOfComputer']['installation_date']; ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$listOfComputer['ListOfComputer']['prepared_by']]); ?>&nbsp;</td>
                    <td><?php echo h($PublishedEmployeeList[$listOfComputer['ListOfComputer']['approved_by']]); ?>&nbsp;</td>
                    <td width="60">
                        <?php if ($listOfComputer['ListOfComputer']['publish'] == 1) { ?>
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
                <tr><td colspan=20><?php echo __('No results found'); ?></td></tr>
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
<?php echo $this->element('advanced-search', array('postData' => array("sr_no" => "Sr No", "make" => "Make", "serial_number" => "Serial Number", "price" => "Price", "installation_date" => "Installation Date", "other_details" => "Other Details"), 'PublishedBranchList' => array($PublishedBranchList))); ?>
<?php echo $this->element('import', array('postData' => array("sr_no" => "Sr No", "make" => "Make", "serial_number" => "Serial Number", "price" => "Price", "installation_date" => "Installation Date", "other_details" => "Other Details"))); ?>
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