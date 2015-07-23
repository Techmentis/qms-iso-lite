<div>
    <?php
    echo $this->Html->script(array('googlechart.min'));
    echo $this->fetch('script');
    ?>
    <script >
        google.load("visualization", "1", {packages: ["corechart"], callback: drawChart});
        function drawChart() {
            var data = google.visualization.arrayToDataTable(<?php echo $data ?>);

            var options = {
                title: 'Customer Complaints',
                hAxis: {title: 'Month', titleTextStyle: {color: '#333'}},
                vAxis: {title: 'Complaints', minValue: 0},
                seriesType: "bars",
                colors: ['#FD9D9D', '#FF0000', '#3D7832', '#52C33E'],
            };

            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }

    </script>

    <div id="chart_div" style="width: 100%; height: 400px;"></div>
</div>
<?php echo $this->Js->writeBuffer(); ?>