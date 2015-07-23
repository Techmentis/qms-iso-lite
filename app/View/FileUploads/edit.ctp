 <div id="fileUploads_ajax">
<?php echo $this->Session->flash();?>
<div class="nav panel panel-default">
<div class="fileUploads form col-md-8">
<h4><?php echo __('Edit File Upload'); ?>
		</h4>
<?php echo $this->Form->create('FileUpload',array('role'=>'form','class'=>'form')); ?>

	<?php echo $this->Form->input('id'); ?>

    <div class="row">
<div class="col-md-8"><?php 
		echo $this->Form->input('file_details',array('label'=>'File Name')); 
       echo $this->Form->hidden('old_file_details',array('label'=>'File Name','value'=>$this->data['FileUpload']['file_details'])); 
       echo $this->Form->hidden('file_dir',array('label'=>'File Dir','value'=>str_replace('/'.$this->data['FileUpload']['file_details'].'.'.$this->data['FileUpload']['file_type'],NULL,$this->data['FileUpload']['file_dir']))); ?>       
    </div>
	<div class="col-md-1"><br /><br />.<?php 
		echo $this->data['FileUpload']['file_type'];
		echo $this->Form->hidden('file_type'); ?>
    </div>  
	<div class="col-md-3"><?php 
		$ver = explode('ver-',$this->data['FileUpload']['file_details']);
		echo $this->Form->input('version',array('value'=>$ver['1'])); 
	?></div>
    <div class="col-md-4"><?php echo $this->Form->input('user_id',array('label'=>'Uploaded By','style'=>'width:100%')); ?></div>
   	<div class="col-md-4"><?php echo $this->Form->input('prepared_by',array('options'=>$PublishedEmployeeList,'label'=>'Prepared By','style'=>'width:100%')); ?></div>              
    <div class="col-md-4"><?php echo $this->Form->input('approved_by',array('options'=>$PublishedEmployeeList,'label'=>'Approved By','style'=>'width:100%')); ?></div>

    	<div class="col-md-12"><?php echo $this->Form->input('comment'); ?></div>
    	<div class="col-md-12"><?php echo $this->Form->input('archived'); ?></div>        

    </div>
<?php echo $this->Form->hidden('controller',array('value'=>$this->request->params['pass'][1])); ?>
<?php echo $this->Form->hidden('system_table_id',array('type'=>'text','value'=>$this->data['FileUpload']['system_table_id'])); ?>
<?php echo $this->Form->hidden('record',array('value'=>$this->data['FileUpload']['record'])); ?>

	<?php 
		if($this->request->params['pass'][1] == 'products')echo $this->Form->hidden('record',array('value'=>$this->request->params['pass'][3])); 
		else echo $this->Form->hidden('record',array('value'=>$this->request->params['pass'][2])); 
		
	?>
    <?php if($showApprovals && $showApprovals['show_panel'] == true ) { ?>
    <?php echo $this->element('approval_form'); ?>
    <?php } else {echo $this->Form->input('publish', array('label'=> __('Publish'))); } ?>
    <?php echo $this->Form->submit(__('Submit'),array('div'=>false,'class'=>'btn btn-primary btn-success')); ?>
    <?php echo $this->Form->end(); ?>
    <?php echo $this->Js->writeBuffer();?>

<div class="row">
<div class="col-md-12">
	<?php echo "<h4>&nbsp;&nbsp;" . __("Revision Files") . "</h4>"; ?>
<table class="table table-striped table-hover table-bordered table-responsive ">
	<tr>
		<th>File Name</th>
		<th>Version</th>
		<th>Comment</th>
		<th>By</th>
                <th>Prepared By</th>  
                <th>Approved By</th>                             
                <th>Created</th>          
		<th>Edit</th>                
	</tr>      
        <?php foreach($revisions as $file):
            if($file['FileUpload']['file_status'] == 0)echo "<tr class='danger text-danger'>";
	else echo "<tr>";
	$webroot = "/ajax_multi_upload";
	$fullPath = WWW_ROOT . DS. '/files/'.$this->Session->read('User.company_id').'/upload/'.$usersId . '/' . $this->request->params['controller'] . '/' . $recordId . '/'.$file['FileUpload']['file_details'].'.'.$file['FileUpload']['file_type'];
	$displayPath = '/files/'.$this->Session->read('User.company_id').'/upload/'.$usersId . '/' . $this->request->params['controller'] . '/' . $recordId . '/'. $file['FileUpload']['file_details'].'.'.$file['FileUpload']['file_type'];
	$baseEncFile = base64_encode($fullPath);
	$delUrl = "$webroot/file_uploads/delete//$baseEncFile/";
?>
        <td><?php echo $this->Html->image('../ajax_multi_upload/img/fileicons/'.$file['FileUpload']['file_type'].'.png'); ?> 
        <?php 
				if($file['FileUpload']['file_status'] == 1)echo $this->Html->link($file['FileUpload']['file_details'].'.'.$file['FileUpload']['file_type'],$displayPath,array('target'=>'_blank','escape'=>TRUE)); 
				else echo "<s>".$file['FileUpload']['file_details'].'.'.$file['FileUpload']['file_type']."</s>";		
		?></td>              
        <td><?php echo $file['FileUpload']['version']; ?></td>
        <td><?php echo $file['FileUpload']['comment']; ?></td> 
        <td><?php echo $file['CreatedBy']['name']; ?></td>  
		<td><?php echo $file['PreparedBy']['name']; ?></td>  
		<td><?php echo $file['ApprovedBy']['name']; ?></td>          
        <td>
        <?php
            if($file['FileUpload']['file_status'] == 0)echo "Deleted ". $this->Time->niceShort($file['FileUpload']['created']);
            else echo $this->Time->niceShort($file['FileUpload']['modified']);
        ?>
        </td>                                       
        <td>
        <?php 
            if($file['FileUpload']['file_status'] == 1){
                echo $this->Html->link('Edit',array('controller'=>'file_uploads','action'=>'edit',$file['FileUpload']['id'],$this->request->params['controller'],$this->request->params['pass'][0]),array('class'=>'badge btn-warning')); 
                echo $this->Html->link($this->Html->image('../ajax_multi_upload/img/delete.png'),$delUrl,array('escape'=>FALSE));
            }else {
                echo $this->Html->link('Edit',array('controller'=>'file_uploads','action'=>'edit',$file['FileUpload']['id'],$this->request->params['controller'],$this->request->params['pass'][0]),array('class'=>'badge btn-warning')); 
            }
        ?></td>                
    </tr>
<?php endforeach; ?>
</table>
</div>
</div>
</div>
<script> $("[name*='date']").datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat:'yy-mm-dd',
    }); </script>
<div class="col-md-4">
	<p><?php echo $this->element('helps'); ?></p>
</div>
</div>
</div>
