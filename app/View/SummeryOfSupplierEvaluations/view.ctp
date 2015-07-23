<div id="summeryOfSupplierEvaluations_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="summeryOfSupplierEvaluations form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Summary Of Supplier Evaluation'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Supplier'); ?></td>
                    <td>
                        <?php echo $this->Html->link($summeryOfSupplierEvaluation['SupplierRegistration']['title'], array('controller' => 'supplier_registrations', 'action' => 'view', $summeryOfSupplierEvaluation['SupplierRegistration']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Supplier Category'); ?></td>
                    <td>
                        <?php echo $this->Html->link($summeryOfSupplierEvaluation['SupplierCategory']['name'], array('controller' => 'supplier_categories', 'action' => 'view', $summeryOfSupplierEvaluation['SupplierCategory']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Remarks'); ?></td>
                    <td>
                        <?php echo h($summeryOfSupplierEvaluation['SummeryOfSupplierEvaluation']['remarks']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Evaluation Date'); ?></td>
                    <td>
                        <?php echo h($summeryOfSupplierEvaluation['SummeryOfSupplierEvaluation']['evaluation_date']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Employee'); ?></td>
                    <td>
                        <?php echo $this->Html->link($summeryOfSupplierEvaluation['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $summeryOfSupplierEvaluation['Employee']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($summeryOfSupplierEvaluation['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($summeryOfSupplierEvaluation['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($summeryOfSupplierEvaluation['SummeryOfSupplierEvaluation']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>
            <?php echo $this->element('upload-edit', array('usersId' => $summeryOfSupplierEvaluation['SummeryOfSupplierEvaluation']['created_by'], 'recordId' => $summeryOfSupplierEvaluation['SummeryOfSupplierEvaluation']['id'])); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#summeryOfSupplierEvaluations_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $summeryOfSupplierEvaluation['SummeryOfSupplierEvaluation']['id'], 'ajax'), array('async' => true, 'update' => '#summeryOfSupplierEvaluations_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#summeryOfSupplierEvaluations_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
</div>

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
