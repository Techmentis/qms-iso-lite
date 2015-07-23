<div id="products_ajax">
    <?php echo $this->Session->flash(); ?>
    <div class="nav panel panel-default">
        <div class="products form col-md-8">
            <h4><?php echo $this->element('breadcrumbs') . __('View Product'); ?>
                <?php echo $this->Html->link(__('List'), array('action' => 'index'), array('id' => 'list', 'class' => 'label btn-info')); ?>
                <?php echo $this->Html->link(__('Edit'), '#edit', array('id' => 'edit', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->link(__('Add'), '#add', array('id' => 'add', 'class' => 'label btn-info', 'data-toggle' => 'modal')); ?>
                <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
            </h4>
            <table class="table table-responsive">
                <tr><td><?php echo __('Sr. No'); ?></td>
                    <td>
                        <?php echo h($product['Product']['sr_no']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Name'); ?></td>
                    <td>
                        <?php echo h($product['Product']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Required Material'); ?></td>
                    <td>
                        <?php echo $requiredMaterial = implode(', ', $materialNames);?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Description'); ?></td>
                    <td>
                        <?php echo h($product['Product']['description']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Branch'); ?></td>
                    <td>
                        <?php echo $this->Html->link($product['Branch']['name'], array('controller' => 'branches', 'action' => 'view', $product['Branch']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Department'); ?></td>
                    <td>
                        <?php echo $this->Html->link($product['Department']['name'], array('controller' => 'departments', 'action' => 'view', $product['Department']['id'])); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Prepared By'); ?></td>
                    <td>
                        <?php echo h($product['PreparedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Approved By'); ?></td>
                    <td>
                        <?php echo h($product['ApprovedBy']['name']); ?>
                        &nbsp;
                    </td>
                </tr>
                <tr><td><?php echo __('Publish'); ?></td>
                    <td>
                        <?php if ($product['Product']['publish'] == 1) { ?>
                            <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php } else { ?>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        <?php } ?>&nbsp;</td>
                    &nbsp;
                </tr>
            </table>

        </div>

        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
 <div  class="col-md-12">
            <h2><?php echo __('Upload your product design related files below') ?></h2>
            <div id="product-tabs">
                <ul>
                    <li><?php echo $this->Html->link(__('Upload File') . ' <span class="badge btn-default">' . $uploadCount . "</span>", array('action' => 'product_design','ProductUpload', $product['Product']['id'], $product['Product']['created_by']), array('escape' => false)); ?></li>
                    <li><?php echo $this->Html->link(__('Product Plan') . ' <span class="badge btn-default">' . $ProductPlan . "</span>", array('action' => 'product_design', 'ProductPlan', $product['Product']['id'], $product['Product']['created_by']), array('escape' => false)); ?> </li>
                    <li><?php echo $this->Html->link(__('Product Requirment') . ' <span class="badge btn-default">' . $ProductRequirment . "</span>", array('action' => 'product_design', 'ProductRequirment', $product['Product']['id'], $product['Product']['created_by']), array('escape' => false)); ?> </li>
                    <li><?php echo $this->Html->link(__('Product Feasibility') . ' <span class="badge btn-default">' . $ProductFeasibility . "</span>", array('action' => 'product_design', 'ProductFeasibility', $product['Product']['id'], $product['Product']['created_by']), array('escape' => false)); ?> </li>
                    <li><?php echo $this->Html->link(__('Product Development Plan') . ' <span class="badge btn-default">' . $ProductDevelopment . "</span>", array('action' => 'product_design', 'ProductDevelopment', $product['Product']['id'], $product['Product']['created_by']), array('escape' => false)); ?> </li>
                    <li><?php echo $this->Html->link(__('Product Realisation') . ' <span class="badge btn-default">' . $ProductRealisation . "</span>", array('action' => 'product_design', 'ProductRealisation', $product['Product']['id'], $product['Product']['created_by']), array('escape' => false)); ?> </li>
                    <li><?php echo $this->Html->image('indicator.gif', array('id' => 'product-busy-indicator', 'class' => 'pull-right hide')); ?></li>
                </ul>
            </div>
        </div>

<script>
    $(function() {
        $("#product-tabs").tabs({
            beforeLoad: function(event, ui) {
                ui.jqXHR.error(function() {
                    ui.panel.html(
                            "Error Loading ... " +
                            "Please contact administrator.");
                });
            }
        });
    });
    $.ajaxSetup({beforeSend: function() {
            $("#product-busy-indicator").show();
        }, complete: function() {
            $("#product-busy-indicator").hide();
        }});
</script>

    </div>
    <?php $this->Js->get('#list'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'index', 'ajax'), array('async' => true, 'update' => '#products_ajax'))); ?>
    <?php $this->Js->get('#edit'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'edit', $product['Product']['id'], 'ajax'), array('async' => true, 'update' => '#products_ajax'))); ?>
    <?php $this->Js->get('#add'); ?>
    <?php echo $this->Js->event('click', $this->Js->request(array('action' => 'lists', null, 'ajax'), array('async' => true, 'update' => '#products_ajax'))); ?>
    <?php echo $this->Js->writeBuffer(); ?>
<script>
    $.ajaxSetup({beforeSend: function() {
            $("#busy-indicator").show();
        }, complete: function() {
            $("#busy-indicator").hide();
        }
    });
</script>
