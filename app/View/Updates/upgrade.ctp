<script>jQuery.ajaxSetup({async:false});</script>
<div class="col-md-12" style="font-family: monospace; padding: 20px" id="running-update<?php echo $update_id; ?>">
<?php
$i = 0;
$baseFolder = WWW_ROOT . 'files' . DS . 'Updates' . DS . $update_id;
?>
<?php
$count = 0;
foreach($updates as $key=>$update):
        if($key == 'folder_path') $folder_path=$update;        
        if($key == 'files'){
            foreach($update as $mainFolder=>$subFolders):
                foreach($subFolders as $folder=>$files):
                    if(count($files)>0){
                        foreach($files as $file_key=>$file):
                                $count++;     
                        endforeach;
                    }
                endforeach;
            endforeach;
        }
        endforeach;
        $increment =  100/$count;
        
        foreach($updates as $key=>$update):
        if($key == 'folder_path') $folder_path=$update;
        //file updates
        if($key == 'files'){
            foreach($update as $mainFolder=>$subFolders):
                foreach($subFolders as $folder=>$files):
                    if(count($files)>0){
                        foreach($files as $file_key=>$file):
                            $server = str_replace("//","/",$folder_path . DS . $mainFolder . DS . $folder . DS . $file['folder'] . DS . $file['name']);
                            $server = str_replace("http:/","http://",$server);
                            $server = base64_encode($server);
                            $local = base64_encode($baseFolder . DS . $mainFolder .DS . $folder .DS . $file['folder']);
                            
                            $fileName = $file['name'];
                            ?>
                            <script>
                                $().ready(function(){
                                    $("#up<?php echo $update_id; ?>").load("<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/copy_file/from:<?php echo $server; ?>/to:<?php echo $local; ?>/fileName:<?php echo $file['name'] ; ?>/increment:<?php echo $increment; ?>",
                                        function(responseTxt,statusTxt,xhr){
                                            if(statusTxt=="success")
                                                {$("#up<?php echo $i; ?>").attr('class', 'col-md-12');
                                            }
                                        });
                                });
                            </script>                        
                            <?php
                            $increment = $increment+100/$count;
                            $i++;
                        endforeach;
                    }

                endforeach;
            endforeach;
        } ?>        
        <?php
       
    endforeach;
?>
<script>jQuery.ajaxSetup({async:true});</script>
<div id="up<?php echo $update_id; ?>" class="col-md-12" style="font-family: monospace; font-size: 12px; color:#666"></div>
</div>
<?php $vars = base64_encode(json_encode($updates));?>
<script>
    $(document).ajaxStop(function() {
        $("#up<?php echo $update_id; ?>").load("<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/runsql/upgrade:<?php echo $update_id; ?>/baseDir:<?php echo base64_encode($baseFolder); ?>");
        $(this).unbind('ajaxStop');
});
</script>