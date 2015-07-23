<div class="fDivs" style="text-align:center; width:25%;padding: 0px 5px">
    <h1><div class="glyphicon glyphicon-file text-lg"></div></h1>
    <h4><?php echo Inflector::Humanize($fileDetails['basename']) ?></h4>
    <h5><?php
            if ($fileDetails['filesize'] < 1000000) {
                echo round($fileDetails['filesize'] / 1024) . 'kb';
            } else {
                echo round($fileDetails['filesize'] / 1024) . 'kb';
            }
        ?></h5>

    <?php echo $this->Html->link('Download', '/files/' . $this->Session->read("User.company_id") . '/SavedReports' . $path, array('class' => 'btn btn-md btn-success')); ?>

</div>
