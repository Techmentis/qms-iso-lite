
<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
<?php echo $this->Session->flash();?>
	<div class="products ">
		<?php echo $this->element('nav-header-lists',array('postData'=>array('pluralHumanName'=>'Products','modelClass'=>'Product','options'=>array("sr_no"=>"Sr No","name"=>"Name","description"=>"Description"),'pluralVar'=>'products'))); ?>

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
                                <th><?php echo __('Required Material'); ?></th>
				<th><?php echo $this->Paginator->sort('branch_id', __('Branch')); ?></th>
				<th><?php echo $this->Paginator->sort('department_id'); ?></th>
				<th><?php echo $this->Paginator->sort('prepared_by'); ?></th>
				<th><?php echo $this->Paginator->sort('approved_by'); ?></th>
				<th><?php echo $this->Paginator->sort('publish', __('Publish')); ?></th>
			</tr>
			<?php if($products){ ?>
<?php $x=0;
foreach ($products as $product): ?>
			<tr>

				<td class=" actions">
				    <?php echo  $this->element('actions',array('created'=>$product['Product']['created_by'],'postVal'=>$product['Product']['id'], 'softDelete'=>$product['Product']['soft_delete'])); ?>
				</td>
				<td><?php echo h($product['Product']['name']); ?>&nbsp;</td>
                                <td>
                                    <?php
                                        foreach ($product['ProductMaterial'] as $ProductMaterial):
                                            $materialNames[] = $materials[$ProductMaterial['material_id']];
                                        endforeach;
                                        echo $requiredMaterial = implode(', ', $materialNames);
                                        unset($materialNames);
                                    ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($product['Branch']['name'], array('controller' => 'branches', 'action' => 'view', $product['Branch']['id'])); ?>
				</td>
				<td>
					<?php echo $this->Html->link($product['Department']['name'], array('controller' => 'departments', 'action' => 'view', $product['Department']['id'])); ?>
				</td>
				<td><?php echo h($PublishedEmployeeList[$product['Product']['prepared_by']]); ?>&nbsp;</td>
				<td><?php echo h($PublishedEmployeeList[$product['Product']['approved_by']]); ?>&nbsp;</td>

				<td width="60">
					<?php if($product['Product']['publish'] == 1) { ?>
					<span class="glyphicon glyphicon-ok-sign"></span>
					<?php } else { ?>
					<span class="glyphicon glyphicon-remove-circle"></span>
					<?php } ?>&nbsp;</td>
			</tr>
<?php $x++;
endforeach; ?>
<?php }else{ ?>
			<tr><td colspan=16><?php echo __('No results found'); ?></td></tr>
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
<?php echo $this->element('advanced-search',array('postData'=>array("name"=>"Name","description"=>"Description"),'PublishedBranchList'=>array($PublishedBranchList))); ?>
<?php echo $this->element('import',array('postData'=>array("sr_no"=>"Sr No","name"=>"Name","description"=>"Description"))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->element('common'); ?>
</div>
<?php echo $this->Js->writeBuffer();?>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>