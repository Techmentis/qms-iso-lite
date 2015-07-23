

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
	<div class="customTemplates ">
		<?php echo $this->element('nav-header-lists',array('postData'=>array('pluralHumanName'=>'Custom Templates','modelClass'=>'CustomTemplate','options'=>array("sr_no"=>"Sr No","name"=>"Name","description"=>"Description","details"=>"Details"),'pluralVar'=>'customTemplates'))); ?>

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
		<?php echo $this->Form->create(array('class'=>'no-padding no-margin no-background'));?>
			<table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
				<tr>
					<th><input type="checkbox" id="selectAll"></th>
					<th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
					<th><?php echo $this->Paginator->sort('description'); ?></th>
					<th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
				</tr>
				<?php if($customTemplates){ ?>
<?php $x=0;
 foreach ($customTemplates as $customTemplate): ?>
	<tr>
		<td class=" actions">
		    <?php echo  $this->element('actions',array('created'=>$customTemplate['CustomTemplate']['created_by'], 'postVal'=>$customTemplate['CustomTemplate']['id'], 'softDelete'=>$customTemplate['CustomTemplate']['soft_delete'])); ?>
		</td>
		<td><?php echo h($customTemplate['CustomTemplate']['name']); ?>&nbsp;</td>
		<td><?php echo h($customTemplate['CustomTemplate']['description']); ?>&nbsp;</td>
		<td width="60">
			<?php if($customTemplate['CustomTemplate']['publish'] == 1) { ?>
			<span class="glyphicon glyphicon-ok-sign"></span>
			<?php } else { ?>
			<span class="glyphicon glyphicon-remove-circle"></span>
			<?php } ?>&nbsp;</td>
	</tr>
<?php $x++;
 endforeach; ?>
<?php }else{ ?>
	<tr><td colspan=15>No results found</td></tr>
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
<?php echo $this->element('advanced-search',array('postData'=>array("sr_no"=>"Sr No","name"=>"Name","description"=>"Description","details"=>"Details"),'PublishedBranchList'=>array($PublishedBranchList))); ?>
<?php echo $this->element('import',array('postData'=>array("sr_no"=>"Sr No","name"=>"Name","description"=>"Description","details"=>"Details"))); ?>
<?php echo $this->element('approvals'); ?>
</div>
<?php echo $this->Js->writeBuffer();?>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>