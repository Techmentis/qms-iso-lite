
  <div id="db<?php echo $i; ?>" class="col-md-12" style="font-family: monospace; font-size: 14px; color:#666">
                                <?php echo $this->Html->Image('spinner2-black.gif',array('style'=>'width:10px;height:10px'));?>
                                  Downloading files to  temporary location..
                                </div><br/><br/>

<?php if($val['message']){ ?>
<?php echo $val['message'];?></div>
<?php } else { ?>
<?php echo $val['message'];?></div>
<?php } ?>
<div class="progress">
  <div class="progress-bar " role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $val['increment']; ?>%;">
    <?php echo round($val['increment']); ?>%
  </div>
</div>