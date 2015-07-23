<div class="">
    <h4><?php echo __('Store Dashboard'); ?></h4>
</div>
<div class="main nav panel">
    <div class="nav panel-body">
        <div class="row  panel-default">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Dillivery Challans'); ?></h4>
                                <p>You must have added
                                    <?php echo $this->Html->link(__('Branches'), array('controller' => 'branches', 'action' => 'lists'), array('class' => 'text-primary')); ?>,
                                    <?php echo $this->Html->link(__('Departments'), array('controller' => 'departments', 'action' => 'lists'), array('class' => 'text-primary')); ?>,
                                    <?php echo $this->Html->link(__('Customers'), array('controller' => 'customers', 'action' => 'lists'), array('class' => 'text-primary')); ?>,
                                    <?php echo $this->Html->link(__('Suppliers'), array('controller' => 'supplier_registrations', 'action' => 'lists'), array('class' => 'text-primary')); ?> to add Dillivery Challans</p>
                                <p>
                                    <?php echo $this->Html->link(__('Add'), array('controller' => 'DeliveryChallans', 'action' => 'add_ajax'), array('class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(__('See All'), array('controller' => 'DeliveryChallans', 'action' => 'index'), array('class' => 'btn btn-default')); ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Materials\' List With Shelf Life'); ?></h4>
                                <p>You must have added <?php echo $this->Html->link(__('Materials'), array('controller' => 'materials', 'action' => 'lists'), array('class' => 'text-primary')); ?></p>
                                <p>
                                    <?php echo $this->Html->link(__('Add'), array('controller' => 'MaterialListWithShelfLives', 'action' => 'add'), array('class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(__('See All'), array('controller' => 'MaterialListWithShelfLives', 'action' => 'index'), array('class' => 'btn btn-default')); ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Order Details Forms'); ?></h4>
                                <p>You must have added
                                    <?php echo $this->Html->link(__('Purchase Orders'), array('controller' => 'PurchaseOrders', 'action' => 'add_ajax'), array('class' => 'text-primary')); ?>,
                                    <?php echo $this->Html->link(__('Products'), array('controller' => 'products', 'action' => 'add_ajax'), array('class' => 'text-primary')); ?>,
                                    <?php echo $this->Html->link(__('Devices'), array('controller' => 'Devices', 'action' => 'add_ajax'), array('class' => 'text-primary')); ?>,
                                    <?php echo $this->Html->link(__('Delivery Challans'), array('controller' => 'delivery_challans', 'action' => 'add_ajax'), array('class' => 'text-primary')); ?> alredy<br/></p>
                                <p>
                                    <?php echo $this->Html->link(__('Add'), array('controller' => 'OrderDetailsForms', 'action' => 'add'), array('class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(__('See All'), array('controller' => 'OrderDetailsForms', 'action' => 'index'), array('class' => 'btn btn-default')); ?>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
                <br/>
                <div class="row">

                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Purchase Order'); ?><div class="badge btn-danger pull-right">8</div></h4>
                                <p><?php echo __('Add Purchase Orders'); ?><br><br></p>
                                <p>
                                    <?php echo $this->Html->link(__('Add'), array('controller' => 'PurchaseOrders', 'action' => 'add_ajax'), array('class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(__('See All'), array('controller' => 'PurchaseOrders', 'action' => 'index'), array('class' => 'btn btn-default')); ?>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
                <br/>
                <div class="row" style="display: none">
                    <div class="col-md-12">
                        <div class="alert alert-info  fade in message"><h4>Why do we need this ?</h4>
                            <p>Some Management Representative notes on this subject should appear here. <br /> We can extract these from Helps section </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <?php echo $this->element('helps'); ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">&nbsp;</div>
        </div>
        
    </div>
</div>
