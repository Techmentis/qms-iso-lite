<div  id="main">
<?php echo $this->Session->flash();?>
	<div class="systemTables ">
		<?php echo $this->element('nav-header-lists',array('postData'=>array('pluralHumanName'=>'System Tables','modelClass'=>'SystemTable','options'=>array("sr_no"=>"Sr No","name"=>"Name","system_name"=>"System Name","evidence_required"=>"Evidence Required","approvals_required"=>"Approvals Required"),'pluralVar'=>'systemTables'))); ?>
		<div class="nav">
			<div id="tabs">
				<ul>
					<li><?php echo $this->Html->link(__('New System Table'), array('action' => 'add_ajax')); ?></li>
					<li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator','class'=>'pull-right')); ?></li>
				</ul>
			</div>
		</div>
	<div id="systemTables_tab_ajax"></div>
</div>

<script>
  $(function() {
    $( "#tabs" ).tabs({
      beforeLoad: function( event, ui ) {
	ui.jqXHR.error(function() {
	  ui.panel.html(
	    "Error Loading ... " +
	    "Please contact administrator." );
	});
      }
    });
  });
</script>

<?php echo $this->element('export'); ?>
<?php echo $this->element('advanced-search',array('postData'=>array("sr_no"=>"Sr No","name"=>"Name","system_name"=>"System Name","evidence_required"=>"Evidence Required","approvals_required"=>"Approvals Required"),'PublishedBranchList'=>array($PublishedBranchList))); ?>
<?php echo $this->element('import',array('postData'=>array("sr_no"=>"Sr No","name"=>"Name","system_name"=>"System Name","evidence_required"=>"Evidence Required","approvals_required"=>"Approvals Required"))); ?>
</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>