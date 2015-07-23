<div class="row">
    <div class="col-md-12">
        <?php if(isset($results))foreach ($results as $key => $value): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        <?php echo $key ?>
                    </div>
                </div>
                <div class="panel-body">
                    <?php
                        $data = null;
                        $data = "[['Day','Stock In Hand','Stock Sent for Production'],";
                        foreach ($value as $val):
                            $data .= "['" . date('d-m-y', strtotime($val['date'])) . "'," . $val['quantity'] . "," . $val['quantity_consumed'] . "],";
                        endforeach;
                        $data .= "]";
                    ?>
                    <script >
                        google.load("visualization", "1", {packages: ["corechart"], callback: drawChart});
                        function drawChart() {
                            var data = google.visualization.arrayToDataTable(<?php echo $data ?>);
                            var options = {
                                title: null
                            };
                            var chart = new google.visualization.AreaChart(document.getElementById('chart_div_<?php echo $key ?>'));
                            chart.draw(data, options);
                        }
                    </script>
                    <div id="chart_div_<?php echo $key ?>"></div>
                 </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
