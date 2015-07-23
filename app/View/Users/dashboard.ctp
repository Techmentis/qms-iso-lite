<?php
  $daiy_reports = new Folder(WWW_ROOT . DS . 'files' . DS . $this->Session->read('User.company_id') . DS . 'Reports');
  if($daiy_reports->path == null){ ?>
  <br />
  <div class="alert alert-danger alert-dismissable">
	  We could not find auto-generated reports. To enable this functionality you will need to set up "Cron Jobs" or "Scheduled Task". Click
	  <?php echo $this->Html->link('here','https://www.flinkiso.com/help/how-to-create-cron-jobs.html',array('target'=>'_blank')); ?>
	  to learn more
  </div>
  <?php }
?>
<?php
  echo $this->Html->css('pure-css-speech-bubbles');
  echo $this->fetch('css');
?>

<?php if ($show_nc_alert) { ?>
  <div class="alert alert-danger alert-dismissable">
	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	  <span class="glyphicon glyphicon-warning-sign"></span>
	  <b><?php echo __('Non conformities are assigned to you for further actions requires your immediate attention, Check the list below under "Non Conformity Actions Required"'); ?></b>
  </div>
<?php } ?>

<?php /* if ($smtp_alert) { ?>
  <div class="alert alert-danger alert-dismissable">
	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	  <span class="glyphicon glyphicon-warning-sign"></span>
	  <b><?php echo __('SMTP is not setup properly.'); ?></b>
	  <p><?php echo $this->Html->link(__('click here to setup SMTP'), array('controller' => 'users', 'action' => 'smtp_details')) ?></p>
  </div>
<?php } */ ?>
<?php if ($preMeetingAlert) { ?>
  <div class="alert alert-info alert-dismissable">
	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	  <span class="glyphicon glyphicon-warning-sign"></span>
	  <b>  <?php echo $preMeetingAlert ?></b>
	  <p><?php echo $this->Html->link(__('click here for more details'), array('controller' => 'meetings', 'action' => 'meeting_view', $meeting_id)) ?></p>
  </div>
<?php } ?>

<?php if ($postMeetingAlert && $this->Session->read('User.is_mr') == true) { ?>
  <div class="alert alert-danger alert-dismissable">
	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	  <span class="glyphicon glyphicon-warning-sign"></span>
	  <b>  <?php echo $postMeetingAlert ?></b>
  </div>
<?php } ?>

<div class="">
  <?php echo $this->Session->flash(); ?>

  <?php
	  $graphDbSize = (str_replace('MB', '', $dbsize));
	  $graphUploadSize = (str_replace('MB', '', $uploadSize));
	  $usage = round(($graphDbSize + $graphUploadSize) * 100 / 102400);
  ?>
  <?php if ($this->Session->read('User.is_mr') == true or $this->Session->read('User.department') == 'Quality Control') { ?>
	  <div class="row row-max">
		  <div class="col-md-4">
			  <div class="alert alert-success dashboard-alert">
				  <?php echo floor($avg) ?>%
				  <span class="primary"><?php echo __('Data Entry'); ?></span>
				  <div class="progress">
					  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $avg ?>%">
						  <span class="sr-only">40% Complete (success)</span>
					  </div>
					  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php
						  if (isset($benchmark) || $benchmark != 0)
							  $cclass = 'btn btn-success';
						  else
							  $cclass = 'btn btn-danger';
						  echo $benchmark
					  ?>%">
						  <span class="sr-only">40% Complete (success)</span>
					  </div>
				  </div>
				  <?php
					  echo $readiness;
				  ?>%
				  <span class="warning"><?php echo $this->Html->link(__('Readiness') . ' <span class="glyphicon glyphicon-hand-right"></span>', array('controller' => 'dashboards', 'action' => 'readiness'), array('escape' => false)); ?></span>
				  <div class="progress">
					  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $readiness ?>%;">
						  <span class="sr-only"><?php echo __('60% Complete (warning)'); ?></span>
					  </div>
				  </div>
				  <?php if ($this->Session->read('User.is_mr') == true) { ?>
					  <div class="btn-group">
						  <?php echo $this->Html->link(__('Audit Trails'), array('controller' => 'user_sessions'), array('class' => 'btn btn-success')); ?>
						  <?php echo $this->Html->link(__('Benchmark'), array('controller' => 'benchmarks'), array('class' => $cclass)); ?>
					  </div>
				  <?php } ?>
			  </div>
		  </div>
		  <div class="col-md-4">
			  <div class="alert alert-warning dashboard-alert">
				  <ul class="nav nav-pills nav-stacked">

					  <li><?php
							  $capaReceived = '<span class="default badge pull-right btn-danger">' . $capaReceived . '</span>' . __('Number of CAPAs');
							  echo $this->Form->postLink($capaReceived, array('controller' => 'corrective_preventive_actions', 'action' => 'index'), array('escape' => false));
						  ?></li>

					  <li><?php
							  $openCapa = '<span class="default badge pull-right btn-danger">' . $openCapa . '</span>' . __('Open CAPAS');
							  echo $this->Form->postLink($openCapa, array('controller' => 'corrective_preventive_actions', 'action' => 'capa_status'), array('escape' => false));
						  ?></li>

					  <li><?php
							  $closeCapa = '<span class="default badge pull-right btn-success">' . $closeCapa . '</span>' . __('CAPAS Closed');
							  echo $this->Form->postLink($closeCapa, array('controller' => 'corrective_preventive_actions', 'action' => 'capa_status', 1), array('escape' => false));
						  ?></li>

					  <li><?php
							  $docChangeReq = '<span class="default badge pull-right btn-success">' . $docChangeReq . '</span>' . __('Number of document change requests');
							  echo $this->Form->postLink($docChangeReq, array('controller' => 'change_addition_deletion_requests', 'action' => 'index'), array('escape' => false));
						  ?></li>
				  </ul>
			  </div>

		  </div>

		  <div class="col-md-4">
			  <div class="alert alert-danger dashboard-alert">
				  <ul class="nav nav-pills nav-stacked">
					  <li><?php
							  $receivedNcs = '<span class="default badge pull-right btn-danger">' . $countNCs . '</span>' . __('Number of NCs found');
							  echo $this->Form->postLink($receivedNcs, array('controller' => 'corrective_preventive_actions', 'action' => 'get_ncs'), array('escape' => false));
						  ?></li>

					  <li><?php
							  $openNcs = '<span class="default badge pull-right btn-danger">' . $countNCsOpen . '</span>' . __('Number of NCs open');
							  echo $this->Form->postLink($openNcs, array('controller' => 'corrective_preventive_actions', 'action' => 'get_ncs', 1), array('escape' => false));
						  ?></li>

					  <li><?php
							  $receivedCc = '<span class="default badge pull-right btn-danger">' . $complaintReceived . '</span>' . __('Number of Customer Complaints recieved');
							  echo $this->Form->postLink($receivedCc, array('controller' => 'customer_complaints', 'action' => 'index'), array('escape' => false));
						  ?></li>

					  <li><?php
							  $openCc = '<span class="default badge pull-right btn-danger">' . $complaintOpen . '</span>' . __('Number of Customer Complaints open');
							  echo $this->Form->postLink($openCc, array('controller' => 'customer_complaints', 'action' => 'customer_complaint_status'), array('escape' => false));
						  ?></li>
				  </ul>
			  </div>
		  </div>
	  </div>
  <?php } ?>


  <div class="row">
	  <div class="panel panel-danger">
		  <div class="panel-heading"><h3 class="panel-title"><?php echo __("Pending Approvals"); ?>
				  <span class="badge btn-danger pull-right"><?php echo $approvalsCount; ?></span></h3>
		  </div>
		  <div class="panel-body">
			  <table class="table table-condensed">
				  <tr>
					  <th><?php echo __("From"); ?></th>
					  <th><?php echo __("About"); ?></th>
					  <th><?php if ($this->request->controller != 'customer_feedbacks') echo __("Comments"); ?></th>
					  <th class="col-md-1"><?php echo __("Date/Time"); ?></th>
					  <th class="col-md-1"><?php echo __("Act"); ?></th>
				  </tr>

				 
					  <tr>
						  <td colspan="5">Get your approval alerts here!</td>
					  </tr>
				 
			  </table>
		  </div>
	  </div>
  </div>



<div class="row">
  <div id="blockuser_ajax" class="task_main">
	  <?php if (isset($blockedUser) && $blockedUser != null) echo $this->element('blockeduser'); ?>
  </div>
</div>

<div class="row">
  <div  class="col-md-12 no-padding">
	  <div id="task-tabs" class="no-margin">
		  <ul>
				  <li><?php $capa_cnt = ($assignedOpenCapa)>0 ? ' <span class="badge btn-danger">'.$assignedOpenCapa.'</span>': '';
                                 // $capa_cnt = ' <span class="badge btn-danger">'.$capa_cnt.'</span>'; ?>
                                  <?php echo $this->Html->link(__('Capa Assigned')."  ".$capa_cnt, array('controller' => 'corrective_preventive_actions','action'=>'capa_assigned'), array('escape' => false)); 

                                  ?>
                                  </li>

				  <li><?php     $totalComplaints_cnt = ($complaintOpen)>0 ? ' <span class="badge btn-danger">'.$complaintOpen.'</span>' : '';
                                  //$totalComplaints_cnt = ' <span class="badge btn-danger">'.$totalComplaints.'</span>'; ?>
                                  <?php echo $this->Html->link(__('Customer Complaints').' '.$totalComplaints_cnt, array('controller' => 'customer_complaints','action'=>'get_customer_complaints'), array('escape' => false)); ?></li>

				  <li><?php     $countNextCalibrations = $countNextCalibrations>0 ? $countNextCalibrations: '';
                                                $Calibrations_cnt = ' <span class="badge btn-danger">'.$countNextCalibrations.'</span>'; ?>
                                  <?php echo $this->Html->link(__('Calibrations').' '.$Calibrations_cnt, array('controller' => 'calibrations','action'=>'get_next_calibration'), array('escape' => false)); ?></li>

				  <li><?php     $qcStepsCount_cnt = $qcStepsCount>0 ? ' <span class="badge btn-danger">'.$qcStepsCount.'</span>': '';
                                //  $qcStepsCount_cnt = ' <span class="badge btn-danger">'.$qcStepsCount.'</span>'; ?>
                                  <?php echo $this->Html->link(__('Materials').' '.$qcStepsCount_cnt, array('controller' => 'materials','action'=>'get_material_qc_required'), array('escape' => false)); ?></li>

				  <li><?php $materialQCrequiredCount_cnt = $materialQCrequiredCount>0 ? ' <span class="badge btn-danger">'.$materialQCrequiredCount.'</span>': '';
                                 // $materialQCrequiredCount_cnt = ' <span class="badge btn-danger">'.$materialQCrequiredCount.'</span>'; ?>
                                  <?php echo $this->Html->link(__('QC Required').' '.$materialQCrequiredCount_cnt, array('controller' => 'delivery_challans','action'=>'get_delivered_material_qc'), array('escape' => false)); ?></li>

				  <li><?php     $deviceMaintainancesCount_cnt = $deviceMaintainancesCount>0 ? ' <span class="badge btn-danger">'.$deviceMaintainancesCount.'</span>': '';
                                  //$deviceMaintainancesCount_cnt = ' <span class="badge btn-danger">'.$deviceMaintainancesCount.'</span>'; ?>
                                  <?php echo $this->Html->link(__('Device Maintenances').' '.$deviceMaintainancesCount_cnt, array('controller' => 'device_maintenances','action'=>'get_device_maintainance'), array('escape' => false)); ?></li>


				  <li><?php $task_cnt = ($tasks)>0 ? ' <span class="badge btn-danger">'.$tasks.'</span>': '';
                                  //$task_cnt = ' <span class="badge btn-danger">'.$task_cnt.'</span>'; ?>
                                  <?php echo $this->Html->link(__('Task').' '.$task_cnt, array('controller' => 'tasks','action'=>'get_task'), array('escape' => false)); ?></li>

				  <li><?php echo $this->Html->image('indicator.gif', array('id' => 'todo-busy-indicator', 'class' => 'pull-right')); ?></li>
			  </ul>
		  </div>
	  </div>

<script>
$(document).ready(function() {
	$.ajaxSetup({
             cache:false,
         });

    $( "#task-tabs" ).tabs({
         load: function( event, ui ) {
             $("#todo-busy-indicator").hide();
        },
        ajaxOptions: {
            error: function( xhr, status, index, anchor ) {
                $( anchor.hash ).html(
                    "Couldn't load this tab. We'll try to fix this as soon as possible. " +
                    "If this wouldn't be a demo." );
            }
        }
    });

	$( "#task-tabs li" ).click(function() {
  		$("#todo-busy-indicator").show();
	});
});
</script>


</div>


<?php if ($this->Session->read('User.is_mr') == true) { ?>
<div class="row">
  <div  class="col-md-12 no-padding">
	  <div id="files-tabs" class="no-margin">
		  <ul>
				  <li><?php echo $this->Html->link(__('Quality System Manual'), array('action' => 'dashboard_files','quality_system_manual', NULL,NULL), array('escape' => false)); ?></li>
				  <li><?php echo $this->Html->link(__('Quality System Procedures'), array('action' => 'dashboard_files', 'quality_system_procedures', NULL,NULL), array('escape' => false)); ?> </li>
				  <li><?php echo $this->Html->link(__('Process Chart'), array('action' => 'dashboard_files', 'process_chart', NULL,NULL), array('escape' => false)); ?> </li>
				  <li><?php echo $this->Html->link(__('Guidelines'), array('action' => 'dashboard_files', 'guidelines', NULL,NULL), array('escape' => false)); ?> </li>
				  <li><?php echo $this->Html->link(__('Work Instructions'), array('action' => 'dashboard_files', 'work_instructions', NULL,NULL), array('escape' => false)); ?> </li>                  
				  <li><?php echo $this->Html->link(__('Formats'), array('action' => 'dashboard_files', 'formats', NULL,NULL), array('escape' => false)); ?> </li>                                    
				  <li><?php echo $this->Html->image('indicator.gif', array('id' => 'file-busy-indicator', 'class' => 'pull-right')); ?></li>
			  </ul>
		  </div>
	  </div>

<script>
$(document).ready(function() {

$.ajaxSetup({
    cache:false,
   // success: function() {$("#message-busy-indicator").hide();}
    });
    $( "#files-tabs" ).tabs({
         load: function( event, ui ) {
           $("#file-busy-indicator").hide();
        },
        ajaxOptions: {
            error: function( xhr, status, index, anchor ) {
                $( anchor.hash ).html(
                    "Couldn't load this tab. We'll try to fix this as soon as possible. " +
                    "If this wouldn't be a demo." );
            }
        }
    });

	$( "#files-tabs li" ).click(function() {
  		$("#file-busy-indicator").show();
	});
});
</script>


</div>
<?php } ?>
<?php if ($this->Session->read('User.is_mr') == false) { ?>
  <div class="row">
	  <div class="users form col-md-12 no-padding">
              <div id="messages_ajax">
<script>
$(document).ready(function() {
	$.ajaxSetup({
    cache:false,
   // success: function() {$("#message-busy-indicator").hide();}
    });

    $( "#message_tabs" ).tabs({
          load: function( event, ui ) {
            $("#message-busy-indicator").hide();
        },
        ajaxOptions: {
            error: function( xhr, status, index, anchor ) {
                $( anchor.hash ).html(
                    "Couldn't load this tab. We'll try to fix this as soon as possible. " +
                    "If this wouldn't be a demo." );
            }
        }
    });

	$( "#message_tabs li" ).click(function() {
  		$("#message-busy-indicator").show();
	});
});
</script>
<?php $unread = isset($unread) ? $unread : ''; ?>
		  <div id="message_tabs">
			  <ul>
				<li><?php echo $this->Html->Link('Inbox (' . $unread . ' Unread Messages)', array('controller' => 'messages', 'action' => 'inbox',$this->request->params['controller']), array('span' => 'Retriving Data')); ?></li>
				<li><?php echo $this->Html->Link('Sent', array('controller' => 'messages', 'action' => 'sent',$this->request->params['controller']), array('span' => 'Retriving Data')); ?></li>
				<li><?php echo $this->Html->Link('Compose', array('controller' => 'messages', 'action' => 'add',$this->request->params['controller']), array('span' => 'Retriving Data')); ?></li>
				<li><?php echo $this->Html->Link('Trash', array('controller' => 'messages', 'action' => 'trash',$this->request->params['controller']), array('span' => 'Retriving Data')); ?></li>
                <li><?php echo $this->Html->image('indicator.gif', array('id' => 'message-busy-indicator', 'class' => 'pull-right')); ?></li>
			  </ul>
		  </div>

	  </div>
	  </div>
  </div>
<?php } ?>
  <div class="row" style="min-height:440px;">
  <div id="subtabs">
	  <ul>
				<li><?php echo $this->Html->link(__('Timeline'), array('controller' => 'timelines', 'action' => 'timeline')); ?></li>
		  <?php if ($this->Session->read('User.is_mr') != false) { ?>
			  <li><?php echo $this->Html->link(__('Record Graph'), array('controller' => 'histories', 'action' => 'graph_data')); ?></li>
			  <li><?php echo $this->Html->link(__('Branch Graph'), array('controller' => 'histories', 'action' => 'graph_data_branches')); ?></li>
			  <li><?php echo $this->Html->link(__('Department Graph'), array('controller' => 'histories', 'action' => 'graph_data_departments')); ?></li>
            <li><?php echo $this->Html->image('indicator.gif', array('id' => 'subtabs-busy-indicator', 'class' => 'pull-right')); ?></li>
		  <?php } ?>
	  </ul>
  </div>
</div>
<div id="subtabs_ajax"></div>

<script>
$(document).ready(function() {
	$.ajaxSetup({
    cache:false,
   // success: function() {
      //  alert(2324);
      //  $("#subtabs-busy-indicator").hide();}
    });

    $( "#subtabs" ).tabs({
        load: function( event, ui ) {
            $("#subtabs-busy-indicator").hide();
        },
        ajaxOptions: {
            error: function( xhr, status, index, anchor ) {
                $( anchor.hash ).html(
                    "Couldn't load this tab. We'll try to fix this as soon as possible. " +
                    "If this wouldn't be a demo." );
            }
        }
    });

	$( "#subtabs li" ).click(function() {
  		$("#subtabs-busy-indicator").show();
	});
});
</script>


<?php if ($this->Session->read('User.is_mr') != false) { ?>
  <div class="row row-max">
	  <?php
		  echo $this->Html->script(array('googlechart.min'));
		  echo $this->fetch('script');
	  ?>

	  <div class="col-md-8">
              <div class="panel panel-default" id="branches_guage">
		  <?php echo $this->element('branches_gauge'); ?>
              </div>
	  </div>
	  <div class="col-md-4">
              <div id ="branchwise_guage">
		  <div class="panel panel-default">
			  <div class="panel-heading"><h3 class="panel-title pull-left"><?php echo __("Dashboard - Branchwise"); ?></h3>
                            <div style="padding: 0px 0px; overflow: auto">
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <?php
                                            $this->request->params['pass'][0] = isset($this->request->params['pass'][0])? $this->request->params['pass'][0]:'';
                                            $this->request->params['pass'][1] = isset($this->request->params['pass'][1])? $this->request->params['pass'][1]:'';
                                            $this->request->params['pass'][2] = isset($this->request->params['pass'][2])? $this->request->params['pass'][2]:'';
                                            if($this->request->params['pass'][0])$newDate = $this->request->params['pass'][0];
                                            else $newDate = date('Y-m-d');
                                        ?>
                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                $('.lk1').on('click', function() {
                                                        var url = $(this).attr("href");
                                                        $('#branchwise_guage').load(url);
                                                        return false;
                                                });
                                                });
                                        </script>
                                        <?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span>', array('controller'=>'histories','action'=>'branchwise_guage',date('Y-m-d',strtotime('-1 day',strtotime($newDate))),$this->request->params['pass'][1],$this->request->params['pass'][2]),array('class'=>'lk1 btn btn-sm btn-warning ','style'=>'height:30px;color:#fff','escape'=>false)); ?>
                                        <?php echo $this->Html->link($newDate , array('controller'=>'histories','action'=>'branchwise_guage',$newDate,$this->request->params['pass'][1],$this->request->params['pass'][2]),array('class'=>'lk1 btn btn-sm btn-default ','escape'=>false)); ?>
                                        <?php echo $this->Html->link('<span class="btn-warning glyphicon glyphicon-chevron-right"></span>', array('controller'=>'histories','action'=>'branchwise_guage',date('Y-m-d',strtotime('+1 day',strtotime($newDate))),$this->request->params['pass'][1],$this->request->params['pass'][2]),array('class'=>'lk1 btn btn-sm btn-warning ','style'=>'height:30px;color:#fff','escape'=>false)); ?>
                                    </div>
                                </div>
                            </div>
                         </div>
			  <div class="panel-body">
				  <?php
					  $data = null;
					  foreach ($PublishedBranchList as $key => $value):
						  $file = new File(WWW_ROOT . DS . "files" . DS . $this->Session->read('User.company_id') . DS . "graphs" . DS . date('Y-m-d') . DS . "branches" . DS . $key . DS . "gauge" . DS . $key . ".txt");

						  if (file_exists($file->path)) {
							  $data = $file->read();
							  $data = json_decode($data, true);
							  if ($data['b'])
								  $data = round($data['g']) * 100 / round($data['b']);
							  else
								  $data = 0;
						  }else {
							  $data = 1;
						  }
				  ?>
                            <script type='text/javascript'>
                              google.load('visualization', '1', {packages: ['gauge']});
                              google.setOnLoadCallback(drawChart);
                              function drawChart() {

                                      var data = google.visualization.arrayToDataTable([
                                              ['Label', 'Value'],
                                              ['', <?php echo round($data) ?>],
                                      ]);

                                      var options = {
                                              width: 200, height: 160,
                                              redFrom: 0, redTo: 30,
                                              greenFrom: 60, greenTo: 100,
                                              yellowFrom: 30, yellowTo: 60,
                                              minorTicks: 5,
                                      };

                                      var chart = new google.visualization.Gauge(document.getElementById('<?php echo $key ?>'));
                                      chart.draw(data, options);

                              }
                            </script>
                            <div class="pull-left">
                                <div style="width:100%; text-align:center; word-wrap: break-word"><h5><?php echo $value ?></h5></div>
                                <div id='<?php echo $key ?>' class="pull-left"></div>
                            </div>
                            <?php endforeach; ?>
                      </div>
                    </div>
                </div>
           </div>
</div>

<?php } ?>

<script>
  $("[name*='date']").datepicker({
	  changeMonth: true,
	  changeYear: true,
	  dateFormat: 'yy-mm-dd',
  });
</script>

<div class="row row-max" style="display: none">
  <div class="col-sm-6 col-md-6">
	  <div class="panel panel-default">
		  <ul class="nav nav-pills nav-stacked">
			  <li class="active"><a href="#"><span class="badge pull-right"><?php echo $dbsize . " of Database" ?></span><span class="badge pull-right"><?php echo $uploadSize . " or 100GB" ?></span><?php echo __('System Usage'); ?></a></li>
			  <?php foreach ($file_uploads as $upload): ?>
				  <li>
					  <a>
						  <b>
							  <?php echo $upload['FileUpload']['file_details']; ?>.<?php echo $upload['FileUpload']['file_type']; ?> </b><?php
								  echo __(' By ');
								  echo $upload['User']['username'];
								  echo __(' on ');
								  echo $this->Time->nice($upload['FileUpload']['created'])
							  ?>
					  </a>
				  </li>
			  <?php endforeach; ?>
		  </ul>
	  </div>
  </div>


  <div class="col-sm-6 col-md-6">
	  <div class="panel panel-default">
		  <ul class="nav nav-pills nav-stacked">
			  <li class="active"><a href="#"><span class="badge pull-right"><?php echo '20'; ?></span><?php echo __('System Usage'); ?></a></li>
			  <li><a href="#"><span class="default badge btn-info pull-right"><?php echo '2'; ?></span><?php echo __('Data Entry Section'); ?></a></li>
			  <li><a href="#"><span class="default badge btn-info pull-right"><?php echo '8'; ?></span><?php echo __('Quality Control Section'); ?></a></li>
			  <li><a href="#"><span class="default badge btn-info pull-right"><?php echo '4'; ?></span><?php echo __('Personal & Admin Section'); ?></a></li>
			  <li><a href="#"><span class="default badge btn-info pull-right"><?php echo '9'; ?></span><?php echo __('Purchase Section'); ?></a></li>
		  </ul>
	  </div>
  </div>
</div>

<?php if ($companyMessage && $companyMessage['Company']['welcome_message']) { ?>
  <div class="row row-max">
	  <div class="col-sm-12 col-md-12">
		  <h3 class="text-primary"><?php echo __('Welcome Message'); ?></h3>
		  <div class="callout border-callout">
			  <p><?php echo $companyMessage['Company']['welcome_message'] ?></p>
			  <b class="border-notch notch"></b>
			  <b class="notch"></b>
		  </div>
	  </div>
  </div>
<?php } ?>

<?php if ($companyMessage && $companyMessage['Company']['description']) { ?>
  <div class="row row-max">
	  <div class="col-sm-12 col-md-12">
		  <h3 class="text-primary"><?php echo __('Message form Director'); ?></h3>
		  <div class="callout border-callout">
			  <p><?php echo $companyMessage['Company']['description'] ?></p>
			  <b class="border-notch notch"></b>
			  <b class="notch"></b>
		  </div>
	  </div>
  </div>
<?php } ?>


<?php if ($companyMessage && $companyMessage['Company']['quality_policy']) { ?>
  <div class="row row-max">
	  <div class="col-sm-12 col-md-12">
		  <div class="panel panel-default">
			  <h3 class="text-primary"><?php echo __('Quality Policy'); ?></h3>
			  <div class="callout border-callout">
				  <p><?php echo $companyMessage['Company']['quality_policy'] ?></p>
				  <b class="border-notch notch"></b>
				  <b class="notch"></b>
			  </div>
		  </div>
	  </div>
  </div>
<?php } ?>

<?php if ($companyMessage && $companyMessage['Company']['vision_statement']) { ?>
  <div class="row row-max">
	  <div class="col-sm-12 col-md-12">
		  <div class="panel panel-default">
			  <h3 class="text-primary"><?php echo __('Vision Statement'); ?></h3>
			  <div class="callout border-callout">
				  <p><?php echo $companyMessage['Company']['vision_statement'] ?></p>
				  <b class="border-notch notch"></b>
				  <b class="notch"></b>
			  </div>
		  </div>
	  </div>
  </div>
<?php } ?>

<?php if ($companyMessage && $companyMessage['Company']['mission_statement']) { ?>
  <div class="row row-max">
	  <div class="col-sm-12 col-md-12">
		  <h3 class="text-primary"><?php echo __('Mission Statement'); ?></h3>
		  <div class="callout border-callout">
			  <p><?php echo $companyMessage['Company']['mission_statement'] ?></p>
			  <b class="border-notch notch"></b>
			  <b class="notch"></b>
		  </div>
	  </div>
  </div>
<?php } ?>
