<div id="main">
    <div class="">
        <h4><?php echo __('Electronic Data Processing Dashboard'); ?></h3>
    </div>
    <div class="main nav panel">
        <div class="nav panel-body">
            <div class="row  panel-default">
                <div class="col-md-8">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h4><?php echo __('FlinkISO Users'); ?></h4>
                                    <p>
                                        <?php
                                            echo __('Before you create any user make sure you have added ');
                                            echo $this->Html->link(__('Employees'), array('controller' => 'employees', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                            echo $this->Html->link(__('Designations'), array('controller' => 'designations', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                            echo $this->Html->link(__('Branches'), array('controller' => 'branches', 'action' => 'index'), array('class' => 'text-primary'));
                                        ?><br/></p>
                                    <div class="btn-group">
                                        <?php echo $this->Html->link(__('Add'), array('controller' => 'users', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(__('See All'), array('controller' => 'users', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(' ' . $countUsers, array('controller' => 'users', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('FlinkISO Users'))); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h4><?php echo __('List of softwares'); ?></h4>
                                    <p>
                                        <?php
                                            echo __('Before you create the software list make sure you have added ');
                                            echo $this->Html->link(__('Employees'), array('controller' => 'employees', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                            echo $this->Html->link(__('Designations'), array('controller' => 'designations', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                            echo $this->Html->link(__('Branches'), array('controller' => 'branches', 'action' => 'index'), array('class' => 'text-primary'));
                                        ?>
                                    </p>
                                    <div class="btn-group">
                                        <?php echo $this->Html->link(__('Add'), array('controller' => 'list_of_softwares', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(__('See All'), array('controller' => 'list_of_softwares', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(' ' . $countListOfSofts, array('controller' => 'list_of_softwares', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Softwares'))); ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h4><?php echo __('List of Computers'); ?></h4>
                                    <p>
                                        <?php
                                            echo __('To add List Of Computers make sure you have added ');
                                            echo $this->Html->link(__('Employees'), array('controller' => 'employees', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                            echo $this->Html->link(__('Suppliers'), array('controller' => 'supplier_registrations', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                            echo $this->Html->link(__('Purchase Orders'), array('controller' => 'purchase_orders', 'action' => 'index'), array('class' => 'text-primary'));
                                        ?><br /><br />
                                    </p>
                                    <div class="btn-group">
                                        <?php echo $this->Html->link(__('Add'), array('controller' => 'list_of_computers', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(__('See All'), array('controller' => 'list_of_computers', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(' ' . $countListofcomps, array('controller' => 'list_of_computers', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Computers'))); ?>
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
                                    <h4><?php echo __('Computers/Softwares'); ?></h4>
                                    <p>
                                        <?php
                                            echo __('To add list of Softwares make sure you have added ');
                                            echo $this->Html->link(__('Software Types'), array('controller' => 'software_types', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                            echo $this->Html->link(__('Storage Devices'), array('controller' => 'devices', 'action' => 'index'), array('class' => 'text-primary'));
                                        ?><br/><br/>
                                    </p>
                                    <div class="btn-group">
                                        <?php echo $this->Html->link(__('Add'), array('controller' => 'list_of_computer_list_of_softwares', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(__('See All'), array('controller' => 'list_of_computer_list_of_softwares', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(' ' . $countListOfCompSofts, array('controller' => 'list_of_computer_list_of_softwares', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Computers/Softwares'))); ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h4><?php echo __('Data Backups'); ?></h4>
                                    <p>
                                        <?php
                                            echo __('Step-I is to create ');
                                            echo $this->Html->link(__('Data Backups'), array('controller' => 'data_back_ups', 'action' => 'index'), array('class' => 'text-primary'));
                                            echo '&nbsp;' . __('& Step-II is to create Backup Details and assign it to users from ');
                                            echo $this->Html->link(__('Daily Backup Details'), array('controller' => 'daily_backup_details', 'action' => 'index'), array('class' => 'text-primary'));
                                        ?>
                                    </p>
                                    <div class="btn-group">
                                        <?php echo $this->Html->link(__('See Logbook'), array('controller' => 'databackup_logbooks', 'action' => 'index'), array('class' => 'btn btn-default')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h4><?php echo __('List of Usernames'); ?></h4>
                                    <p>
                                        <?php
                                            echo __('Before you add List of Usernames make sure you have already added ');
                                            echo $this->Html->link(__('List of Computers'), array('controller' => 'ListOfComputers', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                            echo $this->Html->link(__('Employees'), array('controller' => 'employees', 'action' => 'index'), array('class' => 'text-primary'));
                                        ?><br/>
                                    </p>
                                    <div class="btn-group">
                                        <?php echo $this->Html->link(__('Add'), array('controller' => 'username_password_details', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(__('See All'), array('controller' => 'username_password_details', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                        <?php echo $this->Html->link(' ' . $countUsrPassDetails, array('controller' => 'username_password_details', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Usernames'))); ?>
                                        <script>$('.btn').tooltip();</script>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br/>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="list-group-item-heading"><?php echo __('Available Quality Documents (EDP Department)'); ?><span class="glyphicon glyphicon-eye-open pull-right"></span></h3>
                            <p class="list-group-item-text"><?php echo __('You can add/view your company Quality Manuals / Procedures / Objectives / Records / Policies for EDP department by clicking on the links below.') . '<br />' . __('These documents are available for all users.'); ?></p>
                        </div>
                        <div class="panel-body">
                            <?php echo $this->Element('files',array('filesData' => array('files'=>$files,'action'=>$this->action))); ?>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <?php echo $this->element('helps'); ?>

                    <script>
                        $(function() {
                            $("#ddfrom").datepicker({
                                changeMonth: true,
                                numberOfMonths: 1,
                                onClose: function(selectedDate) {
                                    $("#ddto").datepicker("option", "minDate", selectedDate);
                                }
                            });
                            $("#ddto").datepicker({
                                changeMonth: true,
                                numberOfMonths: 1,
                                onClose: function(selectedDate) {
                                    $("#ddfrom").datepicker("option", "maxDate", selectedDate);
                                }
                            });
                        });
                    </script>

                    <br />
                    <div class="panel panel-default">
                        <div class="panel-heading"><?php echo __('Data Entry Report'); ?></div>
                        <div class="panel-body">
                            <?php echo $this->Form->create('reports', array('action' => 'data_entry_report', 'role' => 'form', 'class' => 'form no-padding no-margin')); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <?php echo $this->Form->input('from', array('id' => 'ddfrom', 'label' => false, 'class' => 'btn', 'div' => array('class' => 'input-group-btn'))); ?>
                                        <?php echo $this->Form->input('to', array('id' => 'ddto', 'label' => false, 'class' => 'btn', 'div' => array('class' => 'input-group-btn'))); ?>
                                        <?php echo $this->Form->Submit('Submit', array('class' => 'btn btn-success ', 'div' => array('class' => 'input-group-btn'))); ?>
                                    </div>
                                </div>
                            </div>
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>Database : <?php echo $dbSize ?></p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo round($dbSize * 100 / 1000) ?>%;">
                                    <span class="sr-only"><?php echo __('60% Complete'); ?></span>
                                </div>
                            </div>
                            <p>Files: <?php echo $folderSize ?></p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo round($folderSize * 100 / 1000) ?>%;">
                                    <span class="sr-only"><?php echo __('60% Complete'); ?></span>
                                </div>
                            </div>
                            <p>Total: <?php echo $totalSize; ?></p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo round(($totalSize) * 100 / 1000) ?>%;">
                                    <span class="sr-only"><?php echo __('60% Complete'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div><br />
            <?php echo $this->element('databackup'); ?>

        </div>

    </div>
</div>