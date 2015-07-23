<div id="companies_ajax">
<?php echo $this->Session->flash();?>
<div class="nav  panel panel-default">
<div class="companies form col-md-8">
<h4><?php echo __('View Company'); ?>
		<?php echo $this->Html->link(__('Edit'), '#edit',array('id'=>'edit','class'=>'label btn-info','data-toggle'=>'modal')); ?>
                <?php if($company['Company']['sample_data'] == 1):?>
                <?php echo $this->Form->postLink(__('Remove Sample Data'), array('action' => 'remove_sample', $company['Company']['id']), array('class' => 'label btn-info'), __('Are you sure to remove sample data of %s?',$company['Company']['name'])); ?>
                <?php endif; ?>
		<?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
		</h4>
<table class="table table-responsive">
		<tr>
		<td colspan="4">
			<h3><?php echo h($company['Company']['name']); ?></h3>
			&nbsp;
		</td>
		</tr>		
		<tr><th colspan="4"><h4><?php echo __('Company Description'); ?></h4></th></tr>
		<tr>
				<td colspan="4">
					<?php echo html_entity_decode($company['Company']['description']); ?>
					&nbsp;
				</td>
		</tr>
		<tr><th colspan="4"><h4><?php echo __('Welcome Message for Users'); ?></h4></th></tr>
		<tr>
				<td colspan="4">
					<?php echo html_entity_decode($company['Company']['welcome_message']); ?>
					&nbsp;
				</td>
		</tr>
		<tr><th colspan="4"><h4><?php echo __('Company Audit Plan'); ?></h4></th></tr>
		<tr>
				<td colspan="4">
					<?php echo htmlspecialchars_decode($company['Company']['audit_plan']); ?>
					&nbsp;
				</td>
		</tr>

</table>
</div>
<div class="col-md-4">
	<p><?php echo $this->element('helps'); ?></p>
</div>
</div>
</div>
  <div id="files-tabs" class="no-margin">
		  <ul>
				  <li><?php echo $this->Html->link(__('Documents Level 1') . ' <span class="badge btn-default">' . $uploadCount . "</span>", array('controller'=>'users','action' => 'dashboard_files','level-1', NULL,NULL), array('escape' => false)); ?></li>
				  <li><?php echo $this->Html->link(__('Documents Level 2') . ' <span class="badge btn-default">' . $uploadCount . "</span>", array('controller'=>'users','action' => 'dashboard_files', 'level-2', NULL,NULL), array('escape' => false)); ?> </li>
				  <li><?php echo $this->Html->link(__('Documents Level 3') . ' <span class="badge btn-default">' . $uploadCount . "</span>", array('controller'=>'users','action' => 'dashboard_files', 'level-3', NULL,NULL), array('escape' => false)); ?> </li>
				  <li><?php echo $this->Html->link(__('Documents Level 4') . ' <span class="badge btn-default">' . $uploadCount . "</span>", array('controller'=>'users','action' => 'dashboard_files', 'level-4', NULL,NULL), array('escape' => false)); ?> </li>
				  <li><?php echo $this->Html->image('indicator.gif', array('id' => 'file-busy-indicator', 'class' => 'pull-right hide')); ?></li>
			  </ul>
	
<script>
  $(function() {
	  $("#files-tabs").tabs({
		  beforeLoad: function(event, ui) {
			  ui.jqXHR.error(function() {
				  ui.panel.html(
						  "Error Loading ... " +
						  "Please contact administrator.");
			  });
		  }
	  });
  });
  $.ajaxSetup({beforeSend: function() {
		  $("#file-busy-indicator").show();
	  }, complete: function() {
		  $("#file-busy-indicator").hide();
	  }});
</script>
</div>
<?php echo $this->Js->get('#list');?>
<?php echo $this->Js->event('click',$this->Js->request(array('action' => 'index', 'ajax'),array('async' => true, 'update' => '#companies_ajax')));?>

<?php echo $this->Js->get('#edit');?>
<?php echo $this->Js->event('click',$this->Js->request(array('action' => 'edit',$company['Company']['id'] ,'ajax'),array('async' => true, 'update' => '#companies_ajax')));?>
<?php echo $this->Js->writeBuffer();?>


<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>
