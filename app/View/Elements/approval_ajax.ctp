    <?php echo $this->Html->script(array('jquery.min','bootstrap.min')); 
     $this->Html->css(array('bootstrap.min'));
    ?>
    <?php echo $this->fetch('script'); $this->fetch('css'); ?>

<script>
$(document).ready(function(){
    
	$.ajaxSetup({cache:false});
	$('#approval_model_window<?php echo $record_id; ?>').modal();
	});


</script>

<style>.modal-dialog{ width:80%}</style>
<div class="modal fade" id="approval_model_window<?php echo $record_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">View / Upload Approval Files</h4>
      </div>
      <div class="modal-body">


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
        <?php foreach($approval_files as $file):
            if($file['FileUpload']['file_status'] == 0)echo "<tr class='danger text-danger'>";
	else echo "<tr>";
	$webroot = "/ajax_multi_upload";
	$fullPath = WWW_ROOT . DS. '/files/'.$this->Session->read('User.company_id').'/upload/'.$file['FileUpload']['created_by'] . '/approvals/' . $record_id . '/'.$file['FileUpload']['file_details'].'.'.$file['FileUpload']['file_type'];
	$displayPath = '/files/'.$this->Session->read('User.company_id').'/upload/'.$file['FileUpload']['created_by'] . '/approvals/' . $record_id . '/'. $file['FileUpload']['file_details'].'.'.$file['FileUpload']['file_type'];
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
                echo $this->Html->link('Edit',array('controller'=>'file_uploads','action'=>'edit',$file['FileUpload']['id'],'approvals',$this->request->params['pass'][0]),array('class'=>'badge btn-warning')); 
                echo $this->Html->link($this->Html->image('../ajax_multi_upload/img/delete.png'),$delUrl,array('escape'=>FALSE));
            }else {
                echo $this->Html->link('Edit',array('controller'=>'file_uploads','action'=>'edit',$file['FileUpload']['id'],'approvals',$this->request->params['pass'][0]),array('class'=>'badge btn-warning')); 
            }
        ?></td>                
    </tr>
<?php endforeach; ?>
</table>





<?php echo $this->Form->create('Upload', array('role' => 'form', 'class' => 'form')); ?>
<?php
	echo $this->Upload->edit('upload', $this->Session->read('User.id') . '/approvals/' . $record_id,false);
	echo $this->Form->end();
?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
