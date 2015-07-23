<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
<?php echo $this->Session->flash();?>
	<div class="internetUsageDetails ">
		<?php echo $this->element('nav-header-lists',array('postData'=>array('pluralHumanName'=>'Internet Usage Details','modelClass'=>'InternetUsageDetail','options'=>array("sr_no"=>"Sr No","internet_provider_name"=>"Internet Provider Name","plan_details"=>"Plan Details","from_date"=>"From Date","to_date"=>"To Date","download"=>"Download"),'pluralVar'=>'internetUsageDetails'))); ?>

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
					<th><?php echo $this->Paginator->sort('internet_provider_name'); ?></th>
					<th><?php echo $this->Paginator->sort('plan_details'); ?></th>
					<th><?php echo $this->Paginator->sort('from_date'); ?></th>
					<th><?php echo $this->Paginator->sort('to_date'); ?></th>
					<th><?php echo $this->Paginator->sort('download'); ?></th>
					<th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
					<th><?php echo $this->Paginator->sort('approved_by'); ?></th>
					<th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
				</tr>
				<?php if($internetUsageDetails){ ?>
<?php $x=0;
 foreach ($internetUsageDetails as $internetUsageDetail): ?>
	<tr>

		<td class=" actions">
		<?php echo  $this->element('actions',array('created'=>$internetUsageDetail['InternetUsageDetail']['created_by'], 'postVal'=>$internetUsageDetail['InternetUsageDetail']['id'], 'softDelete'=>$internetUsageDetail['InternetUsageDetail']['soft_delete'])); ?>
		</td>
		<td><?php echo h($internetUsageDetail['InternetUsageDetail']['internet_provider_name']); ?>&nbsp;</td>
		<td><?php echo h($internetUsageDetail['InternetUsageDetail']['plan_details']); ?>&nbsp;</td>
		<td><?php echo h($internetUsageDetail['InternetUsageDetail']['from_date']); ?>&nbsp;</td>
		<td><?php echo h($internetUsageDetail['InternetUsageDetail']['to_date']); ?>&nbsp;</td>
		<td><?php echo h($internetUsageDetail['InternetUsageDetail']['download']); ?>&nbsp;</td>
		<td><?php echo h($PublishedEmployeeList[$internetUsageDetail['InternetUsageDetail']['prepared_by']]); ?>&nbsp;</td>
		<td><?php echo h($PublishedEmployeeList[$internetUsageDetail['InternetUsageDetail']['approved_by']]); ?>&nbsp;</td>

		<td width="60">
			<?php if($internetUsageDetail['InternetUsageDetail']['publish'] == 1) { ?>
			<span class="glyphicon glyphicon-ok-sign"></span>
			<?php } else { ?>
			<span class="glyphicon glyphicon-remove-circle"></span>
			<?php } ?>&nbsp;</td>
	</tr>
<?php $x++;
 endforeach; ?>
<?php }else{ ?>
	<tr><td colspan=17>No results found</td></tr>
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
<?php echo $this->element('advanced-search',array('postData'=>array("sr_no"=>"Sr No","internet_provider_name"=>"Internet Provider Name","plan_details"=>"Plan Details","from_date"=>"From Date","to_date"=>"To Date","download"=>"Download"),'PublishedBranchList'=>array($PublishedBranchList))); ?>
<?php echo $this->element('import',array('postData'=>array("sr_no"=>"Sr No","internet_provider_name"=>"Internet Provider Name","plan_details"=>"Plan Details","from_date"=>"From Date","to_date"=>"To Date","download"=>"Download"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->element('common'); ?>
</div>
<?php echo $this->Js->writeBuffer();?>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>