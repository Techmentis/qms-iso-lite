<?php
    $this->request->params['pass'][0] = isset($this->request->params['pass'][0])? $this->request->params['pass'][0]:'';
    $this->request->params['pass'][1] = isset($this->request->params['pass'][1])? $this->request->params['pass'][1]:'';
    $this->request->params['pass'][2] = isset($this->request->params['pass'][2])? $this->request->params['pass'][2]:'';

  if($this->request->params['pass'][0])$newDate = $this->request->params['pass'][0];
  else $newDate = date('Y-m-d');	    
?>
<script type="text/javascript">
    $(document).ready(function(){
            $('.lk').on('click', function() {
            var tab_id = $("#subtabs .ui-tabs-panel:visible").attr("id");
	    var url = $(this).attr("href");
            $('#'+tab_id).load(url);
	    return false;
    });
    });
    </script>
<div style="padding: 0px 10px; overflow: auto">
<div class="pull-right">	
	    <div class="btn-group">	    
		<?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span>', array('controller'=>'histories','action'=>'graph_data_branches',date('Y-m-d',strtotime('-1 day',strtotime($newDate))),$this->request->params['pass'][1],$this->request->params['pass'][2]),array('class'=>'lk btn btn-sm btn-warning ','style'=>'height:30px;color:#fff','escape'=>false)); ?>
		<?php echo $this->Html->link($newDate , array('controller'=>'histories','action'=>'graph_data_branches',$newDate,$this->request->params['pass'][1],$this->request->params['pass'][2]),array('class'=>'lk btn btn-sm btn-default ','escape'=>false)); ?>
		<?php echo $this->Html->link('<span class="btn-warning glyphicon glyphicon-chevron-right"></span>', array('controller'=>'histories','action'=>'graph_data_branches',date('Y-m-d',strtotime('+1 day',strtotime($newDate))),$this->request->params['pass'][1],$this->request->params['pass'][2]),array('class'=>'lk btn btn-sm btn-warning ','style'=>'height:30px;color:#fff','escape'=>false)); ?>
	    </div>	
</div>
</div>

<?php if(isset($branch_data) && $branch_data != false) { ?>
<div style="clear:both">
<?php

echo $this->Html->script(array('googlechart.min'));
//echo $this->fetch('script');
?>
    <script >		
      google.load("visualization", "1", {packages:["corechart"], callback:drawChart});
      
      
      function drawChart() {		
        var data = google.visualization.arrayToDataTable(<?php echo $branch_data ?>);

        var options = {
          title: 'Data Entry Graph',
          hAxis: {title: 'Days',  titleTextStyle: {color: '#ccc'}},
          vAxis: {title:'Records',minValue: 0},
	  seriesType: "bars",
	  series: {1: {type: "line"}},
	  colors:['#5BC0DE','#f0ad4e'],
        };

        var chart = new google.visualization.ComboChart(document.getElementById('branch_chart_div'));
        chart.draw(data, options);
      }

</script>

<div id="branch_chart_div" style="width: 100%; height: 400px;"></div>
</div>
<?php }else {  ?>
  <div class="">
    <div class="panel-body">
	<h4 class="text-danger">No data found</h4>
	<p>These graphs are generated as per the benchmarks you have set for each departments in each branch.</p>
	<p>System collects the data entered in each branch and then creates a report at end of the day.</p>
    </div>
  </div>
  <?php } ?>
    