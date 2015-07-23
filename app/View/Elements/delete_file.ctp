<div style="color:#000">
<?php if($val['message']){ ?>
<span class="glyphicon glyphicon-ok text-success"></span>
<?php echo $val['message'];?></div>
<?php } else { ?>
<span class="glyphicon glyphicon-remove text-danger"></span>
<?php echo $val['message'];?></div>
<?php } ?>