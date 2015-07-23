<div id="masterListOfFormatDepartments_ajax">
<?php echo $this->Session->flash();?>
<div class="nav">
<div class="masterListOfFormatDepartments form col-md-12">
<table class="table table-responsive">
	<tr>
		<th><?php echo __('Document Title'); ?></th>
		<th><?php echo __('Number'); ?></th>
		<th><?php echo __('Issue Number'); ?></th>
		<th><?php echo __('Revision Number'); ?></th>
		<th><?php echo __('Revision Date'); ?></th>
		<th><?php echo __('Prepared By'); ?></th>
		<th><?php echo __('Approved By'); ?></th>                
	</tr>
	<?php foreach($masterListOfFormatDepartment as $document): ?>
    <?php if($document['flag'] == TRUE) echo "<tr class='warning'>";
	else echo "<tr>"; 
	?>
	<td>
    <?php
		$count = 0 ;
		foreach($PublishedUserList as $key=>$value):
			$dir = new Folder(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/upload/' . $key . '/master_list_of_formats/' . $document['MasterListOfFormat']['id'] . '/');
           $folders = $dir->read();
			$count = $count + count($folders[1]);
		endforeach;		
		
		if($count == 0)echo '<span class="badge btn-info">' . $count .' </span>';
		else echo '<span class="badge btn-primary">'.$count .'</span>';
		?>
       <?php echo $this->Html->link($document['MasterListOfFormat']['title'],array('controller'=>'master_list_of_formats','action'=>'view',$document['MasterListOfFormat']['id'])); ?>
    </td>
	<td><?php echo $document['MasterListOfFormat']['document_number']; ?></td>
	<td><?php echo $document['MasterListOfFormat']['issue_number']; ?></td>
	<td><?php echo $document['MasterListOfFormat']['revision_number']; ?></td>
	<td><?php echo $document['MasterListOfFormat']['revision_date']; ?></td>
	<td><?php echo $document['PreparedBy']['name']; ?></td>
	<td><?php echo $document['ApprovedBy']['name']; ?></td>        
	</tr>
	<?php endforeach ?>

</table>
</div></div>
<?php echo $this->Js->writeBuffer();?>
</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>
