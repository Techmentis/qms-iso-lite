
<div class="panel panel-default" id ="branchwise_guage">
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
				<?php if(!$record_found){?>
                                        <div class="">
                                            <div class="panel-body">
                                                <h4 class="text-danger">No data found</h4>
                                            </div>
                                        </div>
                                <?php }else{ ?>  
                              <?php
					  $data = null;
					  foreach ($PublishedBranchList as $key => $value):
						  $file = new File(WWW_ROOT . DS . "files" . DS . $this->Session->read('User.company_id') . DS . "graphs" . DS . $newDate . DS . "branches" . DS . $key . DS . "gauge" . DS . $key . ".txt");

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
<?php echo $this->Html->script(array('googlechart.min')); echo $this->fetch('script');?>

<script type='text/javascript'>
  google.load('visualization', '1', {packages: ['gauge'], callback:drawChart});
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
<?php endforeach; }?>
</div>
</div>
