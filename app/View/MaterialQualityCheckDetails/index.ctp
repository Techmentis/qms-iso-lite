<?php echo $this->element('checkbox-script'); ?>
<div  id="main">
<?php echo $this->Session->flash();?>
	<div class="materialQualityCheckDetails ">
		<?php echo $this->element('nav-header-lists',array('postData'=>array('pluralHumanName'=>'Material Quality Check Details','modelClass'=>'MaterialQualityCheckDetail','options'=>array("sr_no"=>"Sr No","material_quality_check"=>"Material Quality Check","check_performed_date"=>"Check Performed Date","quantity_received"=>"Quantity Received","quantity_accepted"=>"Quantity Accepted"),'pluralVar'=>'materialQualityCheckDetails'))); ?>

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
					<th><?php echo $this->Paginator->sort('material_quality_check',__('Material Quality Check')); ?></th>					<th><?php echo $this->Paginator->sort('employee_id',__('Employee Id')); ?></th>					<th><?php echo $this->Paginator->sort('check_performed_date',__('Check Performed Date')); ?></th>					<th><?php echo $this->Paginator->sort('quantity_received',__('Quantity Received')); ?></th>					<th><?php echo $this->Paginator->sort('quantity_accepted',__('Quantity Accepted')); ?></th>					<th><?php echo $this->Paginator->sort('publish',__('Publish')); ?></th>				</tr>
				<?php if($materialQualityCheckDetails){ ?>
<?php $x=0;
 foreach ($materialQualityCheckDetails as $materialQualityCheckDetail): ?>
	<tr>
		<td class=" actions">
			<?php echo  $this->element('actions',array('created'=>$materialQualityCheckDetail['MaterialQualityCheckDetail']['created_by'],'postVal'=>$materialQualityCheckDetail['MaterialQualityCheckDetail']['id'], 'softDelete'=>$materialQualityCheckDetail['MaterialQualityCheckDetail']['soft_delete'])); ?>
		</td>
		<td><?php echo h($materialQualityCheckDetail['MaterialQualityCheck']['name']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($materialQualityCheckDetail['Employee']['name'], array('controller' => 'employees', 'action' => 'view', $materialQualityCheckDetail['Employee']['id'])); ?>
		</td>
		<td><?php echo h($materialQualityCheckDetail['MaterialQualityCheckDetail']['check_performed_date']); ?>&nbsp;</td>
		<td><?php echo h($materialQualityCheckDetail['MaterialQualityCheckDetail']['quantity_received']); ?>&nbsp;</td>
		<td><?php echo h($materialQualityCheckDetail['MaterialQualityCheckDetail']['quantity_accepted']); ?>&nbsp;</td>

		<td width="60">
			<?php if($materialQualityCheckDetail['MaterialQualityCheckDetail']['publish'] == 1) { ?>
			<span class="glyphicon glyphicon-ok-sign"></span>
			<?php } else { ?>
			<span class="glyphicon glyphicon-remove-circle"></span>
			<?php } ?>&nbsp;</td>
	</tr>
<?php $x++;
 endforeach; ?>
<?php }else{ ?>
	<tr><td colspan='6'><?php echo __('No results found'); ?></td></tr>
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
<?php echo $this->element('advanced-search',array('postData'=>array("sr_no"=>"Sr No","material_quality_check"=>"Material Quality Check","check_performed_date"=>"Check Performed Date","quantity_received"=>"Quantity Received","quantity_accepted"=>"Quantity Accepted"),'PublishedBanchList'=>array($PublishedBanchList))); ?>
<?php echo $this->element('import',array('postData'=>array("sr_no"=>"Sr No","material_quality_check"=>"Material Quality Check","check_performed_date"=>"Check Performed Date","quantity_received"=>"Quantity Received","quantity_accepted"=>"Quantity Accepted"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->element('common'); ?>
</div>
<?php echo $this->Js->writeBuffer();?>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>