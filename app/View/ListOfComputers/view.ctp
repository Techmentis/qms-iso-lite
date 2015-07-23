<div id="listOfComputers_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="listOfComputers form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View List Of Computer'); ?> <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo $listOfComputer['ListOfComputer']['sr_no']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Employee'); ?></td>
                    <td>
                        <?php echo $this->Html->link($listOfComputer['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $listOfComputer['Employee']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Make'); ?></td>
                    <td>
                        <?php echo $listOfComputer['ListOfComputer']['make']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Serial Number'); ?></td>
                    <td>
                        <?php echo $listOfComputer['ListOfComputer']['serial_number']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Supplier'); ?></td>
                    <td>
                        <?php echo $this->Html->link($listOfComputer['SupplierRegistration']['title'], array('controller' => 'supplier_registrations', 'action' => 'view', $listOfComputer['SupplierRegistration']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Purchase Order'); ?></td>
                    <td>
                        <?php echo $this->Html->link($listOfComputer['PurchaseOrder']['title'], array('controller' => 'purchase_orders', 'action' => 'view', $listOfComputer['PurchaseOrder']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Price'); ?></td>
                    <td>
                        <?php echo $listOfComputer['ListOfComputer']['price']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Installation Date'); ?></td>
                    <td>
                        <?php echo $listOfComputer['ListOfComputer']['installation_date']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Other Details'); ?></td>
                    <td>
                        <?php echo $listOfComputer['ListOfComputer']['other_details']; ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($listOfComputer['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($listOfComputer['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($listOfComputer['ListOfComputer']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>

            <h4><?php echo __('List of Installed Software'); ?></h4>
            <div class="table-responsive">
                <table cellpadding="0" cellspacing="0" class="table table table-striped table-hover">
                    <tr>
                        <th><?php echo __('Software Name'); ?></th>
                        <th><?php echo __('Installation Date'); ?></th>
                        <th><?php echo __('Other Details'); ?></th>
                    </tr>
                    <?php if ($listOfComputerSoftware) {
                            $x = 0;
                            foreach ($listOfComputerSoftware as $listOfComputerListOfSoftware):
                    ?>
                    <tr>
                        <td>
                            <?php echo $this->Html->link($listOfComputerListOfSoftware['ListOfSoftware']['name'], array('controller' => 'list_of_softwares', 'action' => 'view', $listOfComputerListOfSoftware['ListOfSoftware']['id'])); ?>
                        </td>
                        <td><?php echo h($listOfComputerListOfSoftware['ListOfComputerListOfSoftware']['installation_date']); ?>&nbsp;</td>
                        <td><?php echo h($listOfComputerListOfSoftware['ListOfComputerListOfSoftware']['other_details']); ?>&nbsp;</td>

                    </tr>
                    <?php
                        $x++;
                        endforeach;
                        } else {
                    ?>
                    <tr><td colspan=16><?php echo __('No results found'); ?></td></tr>
                    <?php } ?>
                </table>
            </div>

            <?php echo $this->element('upload-edit', array('usersId' => $listOfComputer['ListOfComputer']['created_by'], 'recordId' => $listOfComputer['ListOfComputer']['id'])); ?>

        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#listOfComputers_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $listOfComputer['ListOfComputer']['id'], 'ajax'), array('async' => true, 'update' => '#listOfComputers_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#listOfComputers_ajax'))); ?>
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
