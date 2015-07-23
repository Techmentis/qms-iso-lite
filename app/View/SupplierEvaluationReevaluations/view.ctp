<div id="supplierEvaluationReevaluations_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="supplierEvaluationReevaluations form col-md-8">
            <h4><?php echo __('View Supplier Evaluation Reevaluation'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Supplier'); ?></td>
                    <td>
                        <?php echo $this->Html->link($supplierEvaluationReevaluation['SupplierRegistration']['title'], array('controller' => 'supplier_registrations', 'action' => 'view', $supplierEvaluationReevaluation['SupplierRegistration']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Delivery Challan No'); ?></td>
                    <td>
                        <?php echo $supplierEvaluationReevaluation['DeliveryChallan']['name']; ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Product'); ?></td>
                    <td>
                        <?php echo $this->Html->link($supplierEvaluationReevaluation['Product']['name'], array('controller' => 'products', 'action' => 'view', $supplierEvaluationReevaluation['Product']['id'])); ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Quantity Supplied'); ?></td>
                    <td>
                        <?php echo $supplierEvaluationReevaluation['SupplierEvaluationReevaluation']['quantity_supplied']; ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Quantity Accepted'); ?></td>
                    <td>
                        <?php echo $supplierEvaluationReevaluation['SupplierEvaluationReevaluation']['quantity_accepted']; ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Required Delivery Date'); ?></td>
                    <td>
                        <?php echo $supplierEvaluationReevaluation['SupplierEvaluationReevaluation']['required_delivery_date']; ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Actual Delivery Date'); ?></td>
                    <td>
                        <?php echo $supplierEvaluationReevaluation['SupplierEvaluationReevaluation']['actual_delivery_datedate']; ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Remarks'); ?></td>
                    <td>
                        <?php echo $supplierEvaluationReevaluation['SupplierEvaluationReevaluation']['remarks']; ?>
                        &nbsp;
                    </td></tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($supplierEvaluationReevaluation['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($supplierEvaluationReevaluation['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>

                    <td>
                        <?php if ($supplierEvaluationReevaluation['SupplierEvaluationReevaluation']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;</td></tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $supplierEvaluationReevaluation['SupplierEvaluationReevaluation']['created_by'], 'recordId' => $supplierEvaluationReevaluation['SupplierEvaluationReevaluation']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#supplierEvaluationReevaluations_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $supplierEvaluationReevaluation['SupplierEvaluationReevaluation']['id'], 'ajax'), array('async' => true, 'update' => '#supplierEvaluationReevaluations_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#supplierEvaluationReevaluations_ajax'))); ?>
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
