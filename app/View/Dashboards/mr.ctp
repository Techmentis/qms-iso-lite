<script>
    $().load(function() {
    });
</script>
<div class="">
    <h4><?php echo __('Management Representative Dashboard'); ?></h4>
</div>
<div class="main nav panel">
    <div class="nav panel-body">
        <div class="row  panel-default">
            <div class="col-md-8">


                <div class="row">

                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Document Change Requests'); ?></h4>
                                <p><?php
                                        echo __('Create these request from ADD. These requests will be then available in MR meetings as topic.');
                                        echo '&nbsp;' . $this->Html->link(__('Document Amendment Record Sheet'), array('controller' => 'document_amendment_record_sheets', 'action' => 'index'), array('class' => 'text-primary'));
                                        echo '&nbsp;' . __('will be generated automatically.');
                                    ?></p>
                                <br />
                                <div class="btn-group">
                                    <?php echo $this->Html->link(__('Add'), array('controller' => 'change_addition_deletion_requests', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(__('See All'), array('controller' => 'change_addition_deletion_requests', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(' ' . $countChangeRequest, array('controller' => 'change_addition_deletion_requests', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Change Requests'))); ?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Meetings'); ?></h4>
                                <p>
                                    <?php
                                        echo __('Make sure you have added ');
                                        echo $this->Html->link(__('Branches'), array('controller' => 'branches', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                        echo $this->Html->link(__('Departments'), array('controller' => 'departments', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                        echo $this->Html->link(__('Employees'), array('controller' => 'employees', 'action' => 'index'), array('class' => 'text-primary'));
                                        echo '&nbsp;' . __('to create Meetings and send invites to employees.');
                                    ?>
                                    <br /><br /><strong class="text-info"><?php echo __('As per the standard you should have at-least one meeting per month.'); ?></strong>
                                </p>
                                <div class="btn-group">
                                    <?php echo $this->Html->link(__('Add'), array('controller' => 'meetings', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(__('See All'), array('controller' => 'meetings', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(' ' . $countMeetings, array('controller' => 'meetings', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Meetings'))); ?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Meeting Details'); ?></h4>
                                <p>
                                    <?php
                                        echo __('Make sure you have added ');
                                        echo $this->Html->link(__('Branches'), array('controller' => 'branches', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                        echo $this->Html->link(__('Departments'), array('controller' => 'departments', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                        echo $this->Html->link(__('Employees'), array('controller' => 'employees', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                        echo $this->Html->link(__('Meetings'), array('controller' => 'meetings', 'action' => 'index'), array('class' => 'text-primary'));
                                        echo '&nbsp;' . __('to add Meetings details.');
                                    ?>
                                    <br /><br /><strong class="text-info"><?php echo __('You can add meeting details after meeting dates.'); ?></strong>
                                </p>
                                <br />
                                <div class="btn-group">
                                    <?php echo $this->Html->link(__('Add'), array('controller' => 'meetings', 'action' => 'meeting_detail_lists'), array('class' => 'btn btn-default')); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="cleafix">&nbsp;</div>
                <div class="row">

                    <div class="col-md-8">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Manage Internal Audits'); ?></h4>
                                <p>
                                    <?php
                                        echo __('Make sure you have added ');
                                        echo $this->Html->link(__('Branches'), array('controller' => 'branches', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                        echo $this->Html->link(__('Employees'), array('controller' => 'employees', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                        echo $this->Html->link(__('Trained Internal Auditors'), array('controller' => 'list_of_trained_internal_auditors', 'action' => 'index'), array('class' => 'text-primary'));
                                        echo '&nbsp;' . __('to Prepare your Internal Audit Plan for the year.');
                                    ?>
                                    <br /><span class="text-info"><b><?php echo __('You need to create a schedule / plan first and then add actual audit details by choosing the plan from existing schedules.'); ?></b></span>
                                </p>

                                <div class="btn-group">
                                    <?php echo $this->Html->link(__('Add Schedule / Plan'), array('controller' => 'internal_audit_plans', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(__('Select Plan & add Audit Details'), array('controller' => 'internal_audit_plans', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                    <?php
                                    if (!($countNcs == 0)) {
                                        echo $this->Html->link(' ' . $countNcs, array('controller' => 'internal_audit_plans', 'action' => 'index'), array('type' => 'button', 'class' => 'btn  btn-danger', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Non Conformity Actions Required')));
                                    }
                                    ?>
                                    <?php echo $this->Html->link(' ' . $countInternalAudits, array('controller' => 'internal_audit_plans', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'top', 'data-toggle' => 'tooltip', 'title' => __('No. of Internal Audits'))); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('CAPA'); ?></h4>
                                <p>
                                    <?php
                                        echo __('Make sure you have added ');
                                        echo $this->Html->link(__('CAPA Sources'), array('controller' => 'capa_sources', 'action' => 'index'), array('class' => 'text-primary')) . ', ';
                                        echo $this->Html->link(__('CAPA Category'), array('controller' => 'capa_categories', 'action' => 'index'), array('class' => 'text-primary'));
                                        echo '&nbsp;' . __('to Add CAPA Plan');
                                    ?><br><br></p>
                                <div class="btn-group">
                                    <?php echo $this->Html->link(__('Add'), array('controller' => 'corrective_preventive_actions', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(__('See All'), array('controller' => 'corrective_preventive_actions', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(' ' . $countCapas, array('controller' => 'corrective_preventive_actions', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'top', 'data-toggle' => 'tooltip', 'title' => __('No. of CAPAs'))); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="cleafix">&nbsp;</div>
                <div class="row">

                    <div class="col-md-8">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4><?php echo __('Task'); ?></h4>
                                <p>
                                    <?php echo __('As per your standard procedure, you might have assigned various ISO related tasks to your employees. You can assign those tasks to specific employees by clicking ADD below.'); ?><br/><br/>
                                    <?php echo __('Once the task is assigned to the respective employees, based on the schedule, the employee will receive alerts on those tasks each time they login.'); ?><br /><br />
                                    <?php echo __('This will make your ISO related activity monitoring easy.'); ?>
                                </p>
                                <br /><br />
                                <div class="btn-group">
                                    <?php echo $this->Html->link(__('Add'), array('controller' => 'tasks', 'action' => 'lists'), array('class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(__('See All'), array('controller' => 'tasks', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-default')); ?>
                                    <?php echo $this->Html->link(' ' . $countTasks, array('controller' => 'tasks', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-info', 'data-placement' => 'bottom', 'data-toggle' => 'tooltip', 'title' => __('No. of Tasks'))); ?><script>$('.btn').tooltip();</script>
                                    <?php echo $this->Html->link(__('Task Monitor'), array('controller' => 'task_statuses', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-danger')); ?>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="col-md-4 hide">
                        <div class="panel bs-callout bs-callout-warning">
                            <h4><?php echo __('Custom Templates'); ?></h4>
                            <p><?php echo __('Template creation as per requirements. Also add schedules & auto generate reports.') ?></p>
                            <div class="btn-group">
                                <?php echo $this->Html->link(__('Add'), array('controller' => 'custom_templates', 'action' => 'lists'), array('class' => 'btn btn-primary')); ?>
                                <?php echo $this->Html->link(__('See All'), array('controller' => 'custom_templates', 'action' => 'index'), array('type' => 'button', 'class' => 'btn btn-success')); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="panel bs-callout bs-callout-warning">
                            <h4><?php echo __('Benchmarking'); ?></h4>
                            <p>
                                <?php echo __('For each Department, you need to assess the required data entry input for ISO related activities, on a daily / weekly / monthly basis.'); ?><br /><br />
                                <?php echo __('Based on the benchmark set, FlinkISO will automatically update you on the over all readiness.'); ?>
                            </p>
                            <?php echo $this->Html->link(__('Define Benchmarks'), array('controller' => 'benchmarks', 'action' => 'index'), array('class' => 'btn btn-primary')); ?>
                        </div>
                    </div>

                </div>

                <div class="cleafix">&nbsp;</div>
                <div class="row">

                    <div class="col-md-8" >
                        <div class="thumbnail" style="overflow: hidden">
                            <div class="caption">

                                <h4><?php echo __('Work in progress'); ?>
                                </h4>
                                <div id='chart_div_branches' class="pull-left" style="margin-right: 15px"></div>
                                <div id='chart_div_departments' class="pull-left"></div>
                            </div>
                        </div>
                    </div>


                    <script>
                        $(function() {
                            $("#from").datepicker({
                                defaultDate: "-2m",
                                changeMonth: true,
                                numberOfMonths: 3,
                                onClose: function(selectedDate) {
                                    $("#to").datepicker("option", "minDate", selectedDate);
                                }
                            });
                            $("#to").datepicker({
                                changeMonth: true,
                                numberOfMonths: 3,
                                onClose: function(selectedDate) {
                                    $("#from").datepicker("option", "maxDate", selectedDate);
                                }
                            });
                        });
                    </script>
                    <div class="col-md-4">
                        <div class="panel panel-info">
                            <div class="panel-heading"><h5><?php echo __('Non Conformities Report'); ?></h5></div>
                            <div class="panel-body">
                                <?php echo $this->Form->create('reports', array('action' => 'nc_report', 'role' => 'form', 'class' => 'form no-padding no-margin')); ?>
                                <p>Select start date and date to generate the report.</p>
                                <div class="row">
                                    <div class="col-md-12"><?php echo $this->Form->input('from', array('id' => 'from', 'label' => false, 'class' => 'btn', 'div' => false)); ?></div>
                                    <div class="col-md-12"><?php echo $this->Form->input('to', array('id' => 'to', 'label' => false, 'class' => 'btn', 'div' => false)); ?></div>
                                    <div class="col-md-12"><?php echo $this->Form->Submit('Submit', array('class' => 'btn btn-success ', 'div' => false)); ?></div>
                                </div>
                                <?php echo $this->Form->end(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="display: none">
                    <div class="col-md-12">
                        <div class="alert alert-info  fade in message"><h4><?php echo __('Why do we need this?'); ?></h4>
                            <p>
                                <?php echo __('Some Management Representative notes on this subject should appear here.'); ?><br />
                                <?php echo __('We can extract these from Helps section'); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <?php echo $this->element('helps'); ?>

            </div>
        </div>
		<div class="nav">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="list-group-item-heading"><?php echo __('Available Quality Documents (MR Department)'); ?><span class="glyphicon glyphicon-eye-open pull-right"></span></h3>
                        <p class="list-group-item-text"><?php echo __('You can add/view your company Quality Manuals / Procedures / Objectives / Records / Policies for MR department by clicking on the links below. <br /> These documents are available for all users.'); ?></p>
                    </div>
                    <div class="panel-body">
                    	<?php echo $this->Element('files',array('filesData' => array('files'=>$files,'action'=>$this->action))); ?></div>
                </div>
            </div>
        </div>
        
        <div class="nav">

            <div class="col-md-12">&nbsp;
                <script>
                    $(function() {
                        $("#tabs").tabs({
                            beforeSend: $("#busy-indicator-mr").show(),
                            complete: $("#busy-indicator-mr").hide(),
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
                <h4><?php echo __('List of available forms'); ?><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator-mr', 'class' => 'pull-right hide')); ?>
                <small>Contact <a href="mailto:support@flinkiso.com">FlinkISO&trade;</a> for any missing forms/formats.</small></h4>
                <div id="tabs">
                    <ul>
                        <?php foreach ($departments as $department): ?>
                            <li>
                                <?php echo $this->Html->link($department["Department"]["name"], array('controller' => 'master_list_of_format_departments', 'action' => 'listing', $department["Department"]["id"]), array('class' => 'btn btn-primary')); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        

    </div>

</div>

<script type='text/javascript' src='https://www.google.com/jsapi'></script>
<script type='text/javascript'>
    google.load('visualization', '1', {packages: ['gauge']});
    google.setOnLoadCallback(drawChart);
    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Branch', <?php echo $branchData ?>],
        ]);

        var options = {
            fontSize: 14,
            width: 280, height: 210,
            redFrom: 0, redTo: 30,
            greenFrom: 60, greenTo: 100,
            yellowFrom: 30, yellowTo: 60,
            minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div_branches'));
        chart.draw(data, options);

        var data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Departments', <?php echo $departmentData ?>],
        ]);

        var options = {
            width: 280, height: 210,
            redFrom: 0, redTo: 30,
            greenFrom: 60, greenTo: 100,
            yellowFrom: 30, yellowTo: 60,
            minorTicks: 5,
            style: {'font-size': 10}
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div_departments'));
        chart.draw(data, options);

        var data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['users', 80],
        ]);

    }
</script>
