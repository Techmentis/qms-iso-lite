<div style="padding: 10px">
<div class="row">
 <div class="col-md-8">
 <h5>Sample Files</h5>
 <p>
 Sample files are files generated automatically by the FlinkISO application. You can add your data to these sample files and later import the data.
 </p>
 </div>
 <div class="col-md-4">

<?php
$ref = explode('/',str_replace(Router::url('/', true),'',$ref));
echo $this->Form->create('file_uploads',array('controller'=>'file_uploads','action'=>'export_xls'),array('role'=>'form','class'=>'form'));
echo $this->Form->hidden('postData',array('value'=>json_encode($tableFields)));
echo $this->Form->hidden('fileName',array('value'=>$ref[0]));
echo $this->Form->submit('Download Sample',array('class'=>'btn  btn-lg btn-success'));
echo $this->Form->end();

?>

  
 </div>
</div>
</div>