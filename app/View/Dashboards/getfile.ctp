<div  class="fDivs" style="text-align:center">
    <h1><div class="glyphicon glyphicon-file text-lg"></div></h1>
    <h4><?php echo $fileDetails['basename'] ?></h4>
    <h5><?php
        if ($fileDetails['filesize'] < 1000000) {
            echo round($fileDetails['filesize'] / 1024) . 'kb';
        } else {
            echo round($fileDetails['filesize'] / 1024) . 'kb';
        }
        ?></h5>
    <p class="text-small">Last Modified :<?php echo date('Y-M-d h:m', $fileChange); ?></p>
    <?php echo $this->Html->link('Download', '/files/' . $path, array('class' => 'btn btn-md btn-success')); ?>

</div>
