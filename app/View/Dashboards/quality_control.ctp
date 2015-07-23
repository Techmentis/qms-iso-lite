<div class="">
    <h4><?php echo __('Quality Control Dashboard'); ?></h4>
</div>
<div class="main nav panel">
    <div class="nav panel-body">
        <div class="row panel-default">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Customer Complaints'); ?></h4>
                                <p>
                                    <?php
                                        echo __('Make sure you have added ');
                                        echo $this->Html->link(__('Customers'), array('controller' => 'customers', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                        echo $this->Html->link(__('Products'), array('controller' => 'products', 'action' => 'index'), array('class' => 'text-primary'));
                                    ?><br /><br />
                                </p>
                                <div class="btn-group">
                                    <?php
                                        echo $this->Html->link(__('Add'), array('controller' => 'customer_complaints', 'action' => 'lists'), array('class' => 'btn btn-default'));
                                        echo $this->Html->link(__('See All'), array('controller' => 'customer_complaints', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default'));
                                        echo $this->Html->link(' ' . $openComplaints, array('controller' => 'customer_complaints', 'action' => 'customer_complaint_status'), array('type' => 'button', 'class' => 'btn btn-danger', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Open Customer Complaints')));
                                        echo $this->Html->link(' ' . $complaintResolved, array('controller' => 'customer_complaints', 'action' => 'customer_complaint_status/1'), array('type' => 'button', 'class' => 'btn btn-success', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Closed Customer Complaints')));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Measuring Devices for Calibrations'); ?></h4>
                                <p>
                                    <?php
                                        echo __('Make sure you have added ');
                                        echo $this->Html->link(__('Devices'), array('controller' => 'devices', 'action' => 'index'), array('class' => 'text-primary'));
                                    ?><br>
                                </p>
                                <div class="btn-group">
                                    <?php
                                        echo $this->Html->link(__('See All'), array('controller' => 'list_of_measuring_devices_for_calibrations', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default'));
                                        echo $this->Html->link(' ' . $countCalibdevices, array('controller' => 'list_of_measuring_devices_for_calibrations', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Measuring Devices')));
                                    ?>
                                </div><br/><br/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Calibrations'); ?></h4>
                                <p><?php echo __('List of all the calibrations performed on various devices.') ?></p><br/>
                                <div class="btn-group">
                                    <?php
                                        echo $this->Html->link(__('Add'), array('controller' => 'calibrations', 'action' => 'lists'), array('class' => 'btn btn-default'));
                                        echo $this->Html->link(__('See All'), array('controller' => 'calibrations', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default'));
                                        echo $this->Html->link(' ' . $countCalibs, array('controller' => 'list_of_measuring_devices_for_calibrations', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Calibrations')));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Customer Feedbacks'); ?></h4>
                                <p>
                                    <?php
                                        echo __('Make sure you have added ');
                                        echo $this->Html->link(__('Customers'), array('controller' => 'customers', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                        echo $this->Html->link(__('Questionnaire'), array('controller' => 'customer_feedback_questions', 'action' => 'index'), array('class' => 'text-primary'));
                                    ?><br /><br />
                                </p>
                                <div class="btn-group">
                                    <?php
                                        echo $this->Html->link(__('Add'), array('controller' => 'customer_feedbacks', 'action' => 'lists'), array('class' => 'btn btn-default'));
                                        echo $this->Html->link(__('See All'), array('controller' => 'customer_feedbacks', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default'));
                                        echo $this->Html->link(' ' . $countCustFeedbacks, array('controller' => 'list_of_measuring_devices_for_calibrations', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Customer Feedbacks')));
                                    ?>
                                    <script>$('.btn').tooltip();</script>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Add QC for Material'); ?></h4>
                                <p>
                                    <?php
                                        echo __('Make sure you have added ');
                                        echo $this->Html->link(__('Materials'), array('controller' => 'materials', 'action' => 'index'), array('class' => 'text-primary'));
                                    ?><br /><br />
                                </p>
                                <div class="btn-group">
                                    <?php
                                        echo $this->Html->link(__('Add'), array('controller' => 'material_quality_checks', 'action' => 'lists'), array('class' => 'btn btn-default'));
                                        echo $this->Html->link(__('See All'), array('controller' => 'material_quality_checks', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default'));
                                        echo $this->Html->link(' ' . $countMaterialQC, array('controller' => 'list_of_measuring_devices_for_calibrations', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of QC For Material')));
                                    ?>
                                    <script>$('.btn').tooltip();</script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Add Device Preventive Maintenance'); ?></h4>
                                <p>
                                    <?php
                                        echo __('Make sure you have added ');
                                        echo $this->Html->link(__('devices'), array('controller' => 'devices', 'action' => 'index'), array('class' => 'text-primary'));
                                    ?><br /><br />
                                </p>
                                <div class="btn-group">
                                    <?php
                                        echo $this->Html->link(__('Add'), array('controller' => 'device_maintenances', 'action' => 'lists'), array('class' => 'btn btn-default'));
                                        echo $this->Html->link(__('See All'), array('controller' => 'device_maintenances', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default'));
                                        echo $this->Html->link(' ' . $countDeviceMaintenance, array('controller' => 'device_maintenances', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of  Device Preventive Maintenance')));
                                    ?>
                                    <script>$('.btn').tooltip();</script>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <br />
                <div class="row">
                    <script>
                        $(function() {
                            $("#ccfrom").datepicker({
                                defaultDate: "-3m",
                                changeMonth: true,
                                numberOfMonths: 3,
                                onClose: function(selectedDate) {
                                    $("#ccto").datepicker("option", "minDate", selectedDate);
                                }
                            });
                            $("#ccto").datepicker({
                                changeMonth: true,
                                numberOfMonths: 3,
                                onClose: function(selectedDate) {
                                    $("#ccfrom").datepicker("option", "maxDate", selectedDate);
                                }
                            });
                        });
                    </script>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading"><?php echo __('Customer Complaints'); ?></div>
                            <div class="panel-body">
                                <?php echo $this->Form->create('reports', array('action' => 'customer_complaint_report', 'role' => 'form', 'class' => 'form no-padding no-margin')); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php echo $this->Form->input('from', array('id' => 'ccfrom', 'label' => false, 'class' => 'btn')); ?>
                                        <?php echo $this->Form->input('to', array('id' => 'ccto', 'label' => false, 'class' => 'btn')); ?>
                                        <?php echo $this->Form->Submit('Submit', array('class' => 'btn btn-success ')); ?>
                                    </div>
                                </div>
                                <?php echo $this->Form->end(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Note'); ?>
                                </h4>
                                <p>
                                    <?php
                                        echo '<strong>' . __('Measuring Devices for Calibrations : ') . '</strong>' . __('You don\'t require to "Add" Measuring Devices for Calibrations. This list automatically gets generated while you add a new device.');
                                    ?><br />
                                    <?php
                                        echo '<strong>' . __('Customer Feedback : ') . '</strong>' . __('Make sure you have added Questionnaire for adding customer feedback. Click on "Questionnaire" to add questions one by one.');
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="list-group-item-heading"><?php echo __('Available Quality Documents (QUALITY Department)'); ?><span class="glyphicon glyphicon-eye-open pull-right"></span></h3>
                                <p class="list-group-item-text"><?php echo __('You can add/view your company Quality Manuals / Procedures / Objectives / Records / Policies for Quality department by clicking on the links below. <br /> These documents are available for all users.'); ?></p>
                            </div>
                            <div class="panel-body">
                                <?php echo $this->Element('files',array('filesData' => array('files'=>$files,'action'=>$this->action))); ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(function() {
                    $("#tabs").tabs({
                        beforeLoad: function(event, ui) {
                            ui.jqXHR.error(function() {
                                ui.panel.html(
                                        "Error Loading ... " +
                                        "Please contact administrator.");
                            });
                        }
                    });
                });
            </script>
            <div class="col-md-4">
                <?php echo $this->element('helps'); ?>
            </div>
        </div>

    </div>

</div>
