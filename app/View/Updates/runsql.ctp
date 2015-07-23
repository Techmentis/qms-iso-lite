<div id="up<?php echo $update_id; ?>" class="col-md-12" style="font-family: monospace; font-size: 12px; color:#666">
<h5 class="col-md-12">SQL...</h5>
<script>jQuery.ajaxSetup({async:false});</script>
<?php
$i = 0;
    foreach($updates as $key=>$update):
    
        if($key == 'version')$version = (string)$update;
        if($key == 'update_id')$update_id = (string)$update;
        
        foreach($update as $dKey=>$dValue): 
            if($key == 'database')
            {
                if((string)$update->change_required == 'Yes')
                {
                    if($dKey == 'sql_file')
                    {
                        $sqlFile = (string)$dValue;
                            if(isset($sqlFile))
                            {
                                $sqlFileName = basename($sqlFile);
                                $sqlFile = base64_encode($sqlFile);
                             
                                 
                                $sqlLocal = base64_encode(base64_decode($this->request->params['named']['baseDir']) . DS . "sql") ;
?>
                                <script>
                                    $().ready(function(){
                                    $("#db<?php echo $i; ?>").load("<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/copy_sql_file/from:<?php echo $sqlFile; ?>/to:<?php echo $sqlLocal; ?>/fileName:<?php echo $sqlFileName ; ?>",
                                        function(responseTxt,statusTxt,xhr){
                                            if(statusTxt=="success")
                                                {$("#db<?php echo $i; ?>").attr('class', 'col-md-12')
                                            }
                                        });
                                });
                                </script>
                                <div id="db<?php echo $i; ?>" class="col-md-12" style="font-family: monospace; font-size: 12px; color:#666">
                                <?php echo $this->Html->Image('spinner2-black.gif',array('style'=>'width:8px;height:8px'));?>
                                    coping SQL
                                </div>
<?php                         
                            }
                    }
                }
            }
            $i++;
            endforeach;
    endforeach;       
?>
         
            
<?php 
      if(!isset($sqlFile)) { ?>
           <div  class="col-md-12" style="font-family: monospace; font-size: 12px; color:#666">   
            SQL changes not required.
           </div>
    <?php  }
?>
              <div id="db<?php echo $i; ?>" class="col-md-12" style="font-family: monospace; font-size: 12px; color:#666">
                                <?php echo $this->Html->Image('spinner2-black.gif',array('style'=>'width:8px;height:8px'));?>
                                   Executing SQL files....
                                </div>
</div>
</div>

<?php
$vars = base64_encode(json_encode(array('update_id'=>$update_id,'version'=>$version)));?>
<script>
     $(document).ajaxStop(function() {
    
        $("#up<?php echo $update_id ?>").load("<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/download_complete/<?php echo $vars; ?>/<?php echo $this->request->params['named']['baseDir'] ?>", function( response, status, xhr ) {
            
                 $("#up<?php echo $update_id ?>").load("<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/execute_url/<?php echo $update_id; ?>/<?php echo $this->request->params['named']['baseDir'] ?>", function( response, status, xhr ) {
            });
        });
        $(this).unbind('ajaxStop');
});
</script>
<script>jQuery.ajaxSetup({async:true});</script>
