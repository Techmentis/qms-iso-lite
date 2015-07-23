<div id="up<?php echo $update_id; ?>" class="col-md-12" style="font-family: monospace; font-size: 12px; color:#666">
<h5 class="col-md-12">Optimizing Database...</h5>
<?php
    foreach($updates as $key=>$update):
    
        if($key == 'version')$version = (string)$update;
        if($key == 'update_id')$update_id = (string)$update;
        
        foreach($update as $dKey=>$dValue): 
            if($key == 'execute_url')
            {
                if((string)$update->change_required == 'Yes')
                {
                    if($dKey == 'url')
                    {
                        $url = (string)$dValue;
                            if(isset($url))
                            {
                              
?>
                                <script>
                                    $().ready(function(){
                                    $("#up<?php echo $update_id ?>").load("<?php echo Router::url('/', true); ?><?php echo $url; ?>",
                                        function(responseTxt,statusTxt,xhr){
                                            if(statusTxt=="success")
                                                {$("#db<?php echo $i; ?>").attr('class', 'col-md-12')
             }
        });
                                });
                                </script>
                              
                                <div id="db<?php echo $i; ?>" class="col-md-12" style="font-family: monospace; font-size: 12px;">
                                <?php echo $this->Html->Image('spinner2-black.gif',array('style'=>'width:8px;height:8px'));?>
                                    Running sql for optimizing database...
                                </div>
<?php                         
                            }
                    }
                }
            }
            //$i++;
            endforeach;
    endforeach;       
?>
         
            
<?php 
      if(!isset($url)) { ?>
           <div  class="col-md-12" style="font-family: monospace; font-size: 12px; color:#666">   
           Database optimization not required.
           </div>
    <?php  }
?>
</div>
</div>
<script>jQuery.ajaxSetup({async:false});</script>


<?php
$vars = base64_encode(json_encode(array('update_id'=>$update_id,'version'=>$version)));?>

<script>
    $(document).ajaxStop(function() {
        $("#up<?php echo $update_id ?>").load("<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/update_complete/<?php echo $vars; ?>/<?php echo $this->request->params['named']['baseDir'] ?>", function( response, status, xhr ) {
            });
        $(this).unbind('ajaxStop');
});
</script>
<script>jQuery.ajaxSetup({async:true});</script>
        