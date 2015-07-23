<div id="main">
    <div class="">
        <h4><?php echo __('Production Dashboard'); ?></h3>
    </div>
    <div class="main nav panel">
        <div class="nav panel-body">
            <div class="row  panel-default">
                <div class="col-md-8">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h4><?php echo __('Raw Material'); ?></h4>
                                    <p>
                                        <?php
                                            echo __('Raw material is required for products. You can add required raw materials here and add those to existing products.');
                                        ?>
                                    <div class="btn-group">
                                        <?php echo $this->Html->link(__('Add'), array('controller' => 'materials', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(__('See All'), array('controller' => 'materials', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(' ' . $countMaterials, array('controller' => 'materials', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('FlinkISO Users'))); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h4><?php echo __('List of Products'); ?></h4>
                                    <p>
                                        <?php
                                            echo __('Before you add new product you may like to add required materials for the products ');
                                            echo $this->Html->link(__('Materials'), array('controller' => 'materials', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                        ?><br /><br />
                                    </p>
                                    <div class="btn-group">
                                        <?php echo $this->Html->link(__('Add'), array('controller' => 'products', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(__('See All'), array('controller' => 'products', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(' ' . $countProducts, array('controller' => 'products', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Softwares'))); ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h4><?php echo __('Add production Batch'); ?></h4>
                                    <p>
                                        <?php
                                            echo __('To add production details you need ');
                                            echo $this->Html->link(__('Raw Material'), array('controller' => 'materials', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                            echo $this->Html->link(__('products'), array('controller' => 'products', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                        ?><br /><br /><br />
                                    </p>
                                    <div class="btn-group">
                                        <?php echo $this->Html->link(__('Add'), array('controller' => 'productions', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(__('See All'), array('controller' => 'productions', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(' ' . $countProductions, array('controller' => 'productions', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Computers'))); ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <br />
                    <div class="row">

                        <div class="col-md-4">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h4><?php echo __('Add Stock To Batch'); ?></h4>
                                    <p>
                                        <?php
                                            echo __('Before you add stock details, you require ');
                                            echo $this->Html->link(__('Raw Material'), array('controller' => 'materials', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                            echo $this->Html->link(__('Delivery Challans'), array('controller' => 'delivery_challans', 'action' => 'index'), array('class' => 'text-primary'));
                                        ?>
                                    </p><br />
                                    <div class="btn-group">
                                        <?php echo $this->Html->link(__('Add'), array('controller' => 'stocks', 'action' => 'lists', 0), array('class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(__('See All'), array('controller' => 'stocks', 'action' => 'index', 0), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(' ' . $addToStocks, array('controller' => 'stocks', 'action' => 'index', 0), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Computers/Softwares'))); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h4><?php echo __('Incoming Stock'); ?></h4>
                                    <p>
                                        <?php
                                            echo __('Materials that does not require quality checks, gets automatically added to Incoming Stock from Delivery Challan.'); ?><br/>
                                    </p>
                                    <div class="btn-group">
                                        <?php echo $this->Html->link(__('See All'), array('controller' => 'stocks', 'action' => 'index', 1), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(' ' . $addFromStocks, array('controller' => 'stocks', 'action' => 'index', 1), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Computers/Softwares'))); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h4><?php echo __('Stock Status'); ?></h4>
                                    <p>
                                        <?php
                                            echo __('based on Inwards VA Outwards stock, stock stastus will be generated. Choose date range & material to generate stock status.');
                                        ?><br/>
                                    </p>
                                    <div class="btn-group">
                                        <?php echo $this->Html->link(__('See Stock Status'), array('controller' => 'stocks', 'action' => 'stock_status'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br/>



                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="list-group-item-heading"><?php echo __('Available Quality Documents (Production Department)'); ?><span class="glyphicon glyphicon-eye-open pull-right"></span></h3>
                            <p class="list-group-item-text"><?php echo __('You can add/view your company Quality Manuals / Procedures / Objectives / Records / Policies for EDP department by clicking on the links below.') . '<br />' . __('These documents are available for all users.'); ?></p>
                        </div>
                        <div class="panel-body">
                            <?php echo $this->Element('files',array('filesData' => array('files'=>$files,'action'=>$this->action))); ?>

                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <?php echo $this->element('helps'); ?>
                </div>
            </div>

        </div>
    </div>
</div>