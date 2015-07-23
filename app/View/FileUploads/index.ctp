

<script>
$(document).ready(function () {
    $('#selectAll').on('click', function () {
       $(this).closest('form').find(':checkbox').prop('checked', this.checked);
	getVals();
    });
});

function getVals(){
	var checkedValue = null;
	$("#recs_selected").val(null);
	$("#approve_recs_selected").val(null);
	var inputElements = document.getElementsByTagName('input');

	for(var i=0; inputElements[i]; ++i){

	      if(inputElements[i].className==="rec_ids" &&
		 inputElements[i].checked)
	      {
		   $("#approve_recs_selected").val($("#approve_recs_selected").val() + '+' + inputElements[i].value);
		   $("#recs_selected").val($("#recs_selected").val() + '+' + inputElements[i].value);

	      }
	}
}
</script>

<div  id="main">
<?php echo $this->Session->flash();?>
	<div class="fileUploads ">
		<?php echo $this->element('nav-header-lists',array('postData'=>array('pluralHumanName'=>'File Uploads','modelClass'=>'FileUpload','options'=>array("sr_no"=>"Sr No","record"=>"Record","file_details"=>"File Details","file_type"=>"File Type","file_status"=>"File Status","result"=>"Result"),'pluralVar'=>'fileUploads'))); ?>

<script type="text/javascript">
$(document).ready(function(){
$('table th a, .pag_list li span a').on('click', function() {
	var url = $(this).attr("href");
	$('#main').load(url);
	return false;
});
});
</script>
		<div class="table-responsive">
		<?php   echo $this->Form->create(array('class'=>'no-padding no-margin no-background'));?>
			<table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
				<tr>
                                    <!--<th><input type="checkbox" id="selectAll"></th>-->
				    <th><?php echo $this->Paginator->sort('file_details'); ?></th>
                                    <th><?php echo $this->Paginator->sort('system_table_id'); ?></th>
				    <th><?php echo $this->Paginator->sort('version'); ?></th>
				    <th><?php echo $this->Paginator->sort('user_id'); ?></th>
				    <th><?php echo $this->Paginator->sort('file_type'); ?></th>
				    <th><?php echo $this->Paginator->sort('file_status'); ?></th>
				    <th><?php echo $this->Paginator->sort('result'); ?></th>
				    <th><?php echo $this->Paginator->sort('comment'); ?></th>
				    <th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
				</tr>
				<?php 
                                if($fileUploads){ ?>
<?php $x=0;
 foreach ($fileUploads as $fileUpload): ?>
	<tr>

<!--		<td class=" actions">
		<?php echo  $this->element('actions',array('created'=>$fileUpload['FileUpload']['created_by'],'postVal'=>$fileUpload['FileUpload']['id'], 'softDelete'=>$fileUpload['FileUpload']['soft_delete'])); ?>
		</td>-->
                <td>
                    <?php $displayPath = Router::url('/').'files/'.$this->Session->read('User.company_id').'/'.$fileUpload['FileUpload']['file_dir'];?>
                    <a href="<?php echo $displayPath;?>"> <?php echo $fileUpload['FileUpload']['file_details']; ?> </a>
		&nbsp;</td>
		<td><?php echo h($fileUpload['SystemTable']['name']); ?>&nbsp;</td>
		<td><?php echo h($fileUpload['FileUpload']['version']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($fileUpload['User']['name'], array('controller' => 'users', 'action' => 'view', $fileUpload['User']['id'])); ?>
		</td>
		<td><?php echo h($fileUpload['FileUpload']['file_type']); ?>&nbsp;</td>
		<td><?php echo ($fileUpload['FileUpload']['file_status'])?'Available':'Deleted'; ?>&nbsp;</td>
		<td><?php echo h($fileUpload['FileUpload']['result']); ?>&nbsp;</td>
		<td><?php echo h($fileUpload['FileUpload']['comment']); ?>&nbsp;</td>

		<td width="60">
			<?php if($fileUpload['FileUpload']['publish'] == 1) { ?>
			<span class="glyphicon glyphicon-ok-sign"></span>
			<?php } else { ?>
			<span class="glyphicon glyphicon-remove-circle"></span>
			<?php } ?>&nbsp;</td>
	</tr>
<?php $x++;
 endforeach; ?>
<?php }else{ ?>
	<tr><td colspan=19><?php echo __('No results found');?></td></tr>
<?php } ?>
			</table>
<?php echo $this->Form->end();?>
		</div>
			<p>
			<?php
			echo $this->Paginator->options(array(
			'update' => '#main',
			'evalScripts' => true,
			'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
			));

			echo $this->Paginator->counter(array(
			'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
			));
			?>			</p>
			<ul class="pagination">
			<?php
		echo "<li class='previous'>".$this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'))."</li>";
		echo "<li>".$this->Paginator->numbers(array('separator' => ''))."</li>";
		echo "<li class='next'>".$this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'))."</li>";
	?>
			</ul>
		</div>
	</div>
	</div>

<?php echo $this->element('export'); ?>
<?php echo $this->element('fileupload_advanced_search',array('postData'=>array("sr_no"=>"Sr No","record"=>"Record","file_details"=>"File Details","file_type"=>"File Type","file_status"=>"File Status","result"=>"Result"),'PublishedBranchList'=>array($PublishedBranchList))); ?>
<?php echo $this->element('import',array('postData'=>array("sr_no"=>"Sr No","record"=>"Record","file_details"=>"File Details","file_type"=>"File Type","file_status"=>"File Status","result"=>"Result"))); ?>
<?php echo $this->element('approvals'); ?>
</div>
<?php echo $this->Js->writeBuffer();?>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>