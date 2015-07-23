<?php echo $this->Html->script(array('jquery.validate.min','jquery-form.min','bootstrap-editable.min'));?>
<?php echo $this->Html->css(array('bootstrap-editable'));?>
<?php echo $this->fetch('script');?>
<?php echo $this->fetch('css');?>
<?php echo $this->element('checkbox-script'); ?>

<div  id="main">
<?php echo $this->Session->flash();?>
	<div class="systemTables ">
		<?php echo $this->element('nav-header-lists',array('postData'=>array('pluralHumanName'=>'System Tables','modelClass'=>'SystemTable','options'=>array("sr_no"=>"Sr No","name"=>"Name","system_name"=>"System Name","evidence_required"=>"Evidence Required","approvals_required"=>"Approvals Required"),'pluralVar'=>'systemTables'))); ?>

<script type="text/javascript">
$(document).ready(function(){
$('table th a, .pag_list li span a').on('click', function() {
	var url = $(this).attr("href");
	$('#main').load(url);
	return false;
});
});
</script>
<div class="row">
	<div class="col-md-12">
		<div class="alert alert-info">
			<ul>
				<li>Click on Empty or 1 to turn off either evidence required or approvals required.</li>
				<li>If for "Evidence Required" status is 1, then system will redirect users to view pages after adding a new record, form where they can upload evidances</li>
				<li>If for "Approval Required" status is 1, then system will approval panel for while adding new records</li>
			</ul>
		</div>
	</div>
</div>
		<div class="table-responsive">
		<?php echo $this->Form->create(array('class'=>'no-padding no-margin no-background'));?>
			<table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
				<tr>
					
					<th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>					
					<th><?php echo $this->Paginator->sort('evidence_required'); ?></th>
					<th><?php echo $this->Paginator->sort('approvals_required'); ?></th>					
				</tr>
				<?php if($systemTables){ ?>
<?php $x=0;
 foreach ($systemTables as $systemTable): ?>
<script>
	$(document).ready(function() {$('#evi-<?php echo $x; ?>').editable({
                           type:  'text',
                           pk:    '<?php echo $systemTable['SystemTable']['id']; ?>',
                           name:  'data.SystemTable.evidence_required',
                           url:   'system_tables/inplace_edit_evidence',  
                           title: 'Change Status'
                        });});
</script>
<script>
	$(document).ready(function() {$('#app-<?php echo $x; ?>').editable({
                           type:  'text',
                           pk:    '<?php echo $systemTable['SystemTable']['id']; ?>',
                           name:  'data.SystemTable.approvals_required',
                           url:   'system_tables/inplace_edit_approval',  
                           title: 'Change Status'
                        });});
</script>
	<tr>

		<td><?php echo h($systemTable['SystemTable']['name']); ?>&nbsp;</td>		
		<td><a href="#" id="evi-<?php echo $x; ?>"><?php echo $systemTable['SystemTable']['evidence_required']; ?></a>&nbsp;</td>
		<td><a href="#" id="app-<?php echo $x; ?>"><?php echo $systemTable['SystemTable']['approvals_required']; ?></a>&nbsp;</td>
		

		
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
<?php echo $this->element('advanced-search',array('postData'=>array("sr_no"=>"Sr No","name"=>"Name","system_name"=>"System Name","evidence_required"=>"Evidence Required","approvals_required"=>"Approvals Required"),'PublishedBranchList'=>array($PublishedBranchList))); ?>
<?php echo $this->element('import',array('postData'=>array("sr_no"=>"Sr No","name"=>"Name","system_name"=>"System Name","evidence_required"=>"Evidence Required","approvals_required"=>"Approvals Required",'modelName'=>$this->name))); ?>
<?php echo $this->element('approvals'); ?>
<?php echo $this->element('deleteall'); ?>
</div>
<?php echo $this->Js->writeBuffer();?>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>