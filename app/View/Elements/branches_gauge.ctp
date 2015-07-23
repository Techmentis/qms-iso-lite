<?php
    if(isset($departmentData))
	$departmentData = str_replace('<benchmark>', 10, $departmentData);

    $this->request->params['pass'][0] = isset($this->request->params['pass'][0])? $this->request->params['pass'][0]:'';
    $this->request->params['pass'][1] = isset($this->request->params['pass'][1])? $this->request->params['pass'][1]:'';
    $this->request->params['pass'][2] = isset($this->request->params['pass'][2])? $this->request->params['pass'][2]:'';
    if($this->request->params['pass'][0])$newDate = $this->request->params['pass'][0];
    else $newDate = date('Y-m-d');
?>

<!--<div class="panel panel-default" id="changeDates-<?php echo $newDate ?>">-->

    <div class="panel-heading"><h3 class="panel-title pull-left"><?php echo __('Dashboard - Department-wise'); ?></h3>
        <div style="padding: 0px 0px; overflow: auto">
            <div class="pull-right">
                <div class="btn-group">
                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span>', array('controller' => 'users', 'action' => 'branches_gauge', date('Y-m-d', strtotime('-1 day', strtotime($newDate))), $this->request->params['pass'][1], $this->request->params['pass'][2]), array('class' => 'lgauge btn btn-sm btn-warning ', 'style' => 'height:30px;color:#fff', 'escape' => false)); ?>
                    <?php echo $this->Html->link($newDate, array('controller' => 'users', 'action' => 'branches_gauge', $newDate, $this->request->params['pass'][1], $this->request->params['pass'][2]), array('class' => 'lgauge btn btn-sm btn-default ', 'escape' => false)); ?>
                    <?php echo $this->Html->link('<span class="btn-warning glyphicon glyphicon-chevron-right"></span>', array('controller' => 'users', 'action' => 'branches_gauge', date('Y-m-d', strtotime('+1 day', strtotime($newDate))), $this->request->params['pass'][1], $this->request->params['pass'][2]), array('class' => 'lgauge btn btn-sm btn-warning ', 'style' => 'height:30px;color:#fff', 'escape' => false)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
<script type="text/javascript">
    $(document).ready(function() {
        $('.lgauge').on('click', function() {
            var url = $(this).attr("href");
            $('#branches_guage').load(url);
            return false;
        });
    });
</script>
        
        <?php if(isset($record_found) && !$record_found){?>
                                        <div class="">
                                            <div class="panel-body">
                                                <h4 class="text-danger">No data found</h4>
                                            </div>
                                        </div>
                                <?php }else{ ?> 
        <?php
            $data = null;
            foreach ($PublishedDepartmentList as $key => $value):
                $file = new File(WWW_ROOT . "files" . DS . $this->Session->read('User.company_id') . DS . "graphs" . DS . date('Y-m-d') . DS . "departments" . DS . $key . DS . "gauge" . DS . $key . ".txt");
                if (file_exists($file->path)) {
                    $data = $file->read();
                    $data = json_decode($data, true);
                    $benchmark = $data['b'];
                    if ($data['b'])
                        $data = round($data['g']);
                    else
                        $data = 0;
                }else {
                    $data = 0;
                }
        ?>
<?php echo $this->Html->script(array('googlechart.min')); echo $this->fetch('script');?>
<script type='text/javascript'>

//    google.load('visualization', '1', {packages: ['gauge']});
//    google.setOnLoadCallback(drawChart);
    google.load('visualization', '1', {packages: ['gauge'], callback:drawChart});
    function drawChart() {
        var data = google.visualization.arrayToDataTable([['Label', 'Value'], ['', <?php echo round($data) ?>], ]);
        var options = {
            width: 200, height: 160,
            redFrom: 0, redTo: <?php echo round($benchmark * 30 / 100); ?>,
            greenFrom: <?php echo round($benchmark); ?>, greenTo: 100,
            yellowFrom:<?php echo round($benchmark * 30 / 100); ?>, yellowTo: <?php echo round($benchmark); ?>,
            minorTicks: 5, maxValue: <?php echo round($benchmark); ?>
        };

        var chart = new google.visualization.Gauge(document.getElementById('gague-<?php echo $key ?>'));
        chart.draw(data, options);

    }
</script>
            <div class="pull-left">
                <div style="width:100%; text-align:center; word-wrap: break-word"><h5><?php echo $value ?></h5></div>
                <div id='gague-<?php echo $key ?>' class="pull-left"></div>
            </div>
            <?php endforeach;} ?>
    </div>
