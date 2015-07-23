<div id="main">
    <div class="">
        <h4><?php echo __('Business Development Dashboard'); ?></h4>
    </div>
    <div class="main nav panel">
        <div class="nav panel-body">
            <div class="row  panel-default">
                <div class="col-md-8">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h4><?php echo __('Customers'); ?></h4>
                                    <p>
                                        <?php echo __('Click Add to add new customer or click on See All to view list of existing customers') ?>
                                    </p>
                                    <div class="btn-group">
                                        <?php echo $this->Html->link(__('Add'), array('controller' => 'customers', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(__('See All'), array('controller' => 'customers', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(' ' . $countCustomers, array('controller' => 'customers', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('Customers'))); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h4><?php echo __('Customer Meetings'); ?></h4>
                                    <p>
                                        <?php
                                            echo __('Before you add customer meetings make sure you have added ');
                                            echo $this->Html->link(__('Employees'), array('controller' => 'employees', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                            echo $this->Html->link(__('Customers'), array('controller' => 'customers', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                        ?>
                                    </p>
                                    <div class="btn-group">
                                        <?php echo $this->Html->link(__('Add'), array('controller' => 'customer_meetings', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(__('See All'), array('controller' => 'customer_meetings', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(' ' . $countCustomerMeetings, array('controller' => 'customer_meetings', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Meetings'))); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h4><?php echo __('Proposals'); ?></h4>
                                    <p>
                                        <?php
                                            echo __('Before you add proposals make sure you have added ');
                                            echo $this->Html->link(__('Customers'), array('controller' => 'customers', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                            echo $this->Html->link(__('Employees'), array('controller' => 'employees', 'action' => 'index'), array('class' => 'text-primary'));
                                        ?>
                                    </p>
                                    <div class="btn-group">
                                        <?php echo $this->Html->link(__('Add'), array('controller' => 'proposals', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(__('See All'), array('controller' => 'proposals', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(' ' . $countClientProposals, array('controller' => 'proposals', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Proposals'))); ?>
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
                                    <h4><?php echo __('Proposal Followups'); ?></h4>
                                    <p>
                                        <?php
                                            echo __('Before you add proposal followups make sure you have added ');
                                            echo $this->Html->link(__('Proposal'), array('controller' => 'proposals', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                            echo $this->Html->link(__('Employees'), array('controller' => 'employees', 'action' => 'index'), array('class' => 'text-primary'));
                                        ?><br /><br />
                                    </p>
                                    <div class="btn-group">
                                        <?php echo $this->Html->link(__('Add'), array('controller' => 'proposal_followups', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(__('See All'), array('controller' => 'proposal_followups', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(' ' . $countProposalFollowups, array('controller' => 'proposal_followups', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Proposals Followups'))); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br/>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="list-group-item-heading"><?php echo __('Available Quality Documents (BD Department)'); ?><span class="glyphicon glyphicon-eye-open pull-right"></span></h3>
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

            <div class="row">
                <div class="col-md-12">
                    <script>
                        $(function() {
                            $("#dashboardStartDate").datepicker({
                                dateFormat: 'yy-m-d',
                                defaultDate: "-1m",
                                changeMonth: true,
                                numberOfMonths: 2,
                                onClose: function(selectedDate) {
                                    $("#dashboardEndDate").datepicker("option", "minDate", selectedDate);
                                }
                            });
                            $("#dashboardEndDate").datepicker({
                                dateFormat: 'yy-m-d',
                                defaultDate: "d",
                                maxDate: "d",
                                changeMonth: true,
                                numberOfMonths: 2,
                                onClose: function(selectedDate) {
                                    $("#dashboardStartDate").datepicker("option", "maxDate", selectedDate);
                                }
                            });
                        });

                        $(function() {
                            $("#dashboardEndDate").change(function() {
                                if ($("#dashboardEndDate").val() != '') {
                                    $("#mapping").load('result_mapping/' + $("#dashboardStartDate").val() + '/' + $("#dashboardEndDate").val());
                                }
                            });
                            $("#dashboardStartDate").change(function() {
                                if ($("#dashboardEndDate").val() != '') {
                                    $("#mapping").load('result_mapping/' + $("#dashboardStartDate").val() + '/' + $("#dashboardEndDate").val());
                                }

                            });
                        });
                    </script>

                    <?php echo $this->Form->create('dashboard', array('controller' => 'dashboard', 'action' => 'bd')); ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-8"><h3 class="list-group-item-heading"><?php echo __('Conversion Rate'); ?></h3></div>
                                <div class="col-md-2"><?php echo $this->Form->input('start_date', array('placeholder' => 'Select Start Date', 'div' => false, 'label' => false, 'class' => ('disabled'), 'readonly')); ?></div>
                                <div class="col-md-2"><?php echo $this->Form->input('end_date', array('placeholder' => 'Select End Date', 'div' => false, 'label' => false, 'class' => ('disabled'), 'readonly')); ?></div>
                            </div>
                            <?php echo $this->Form->end(); ?>
                        </div>
                        <div class="panel-body" id="mapping">
                            <?php echo $this->element('result_mapping'); ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>