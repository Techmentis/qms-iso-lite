<div  id="main">
<?php echo $this->Session->flash();?>	
	<div class="histories ">
		<?php echo $this->element('nav-header-lists',array('postData'=>array('pluralHumanName'=>'Histories','modelClass'=>'History','options'=>array("sr_no"=>"Sr No","model_name"=>"Model Name","controller_name"=>"Controller Name","action"=>"Action","get_values"=>"Get Values","post_values"=>"Post Values"),'pluralVar'=>'histories'))); ?>
		<div class="nav">
			<div id="tabs">	
				<ul>
					<li><?php echo $this->Html->link(__('New History'), array('action' => 'add_ajax')); ?></li>
					<li><?php echo $this->Html->link(__('Add User Session'), array('controller' => 'user_sessions', 'action' => 'add_ajax')); ?> </li>
					<li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator','class'=>'pull-right')); ?></li>
				</ul>
			</div>
		</div>
	<div id="histories_tab_ajax"></div>
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
<?php echo $this->element('advanced-search',array('postData'=>array("sr_no"=>"Sr No","model_name"=>"Model Name","controller_name"=>"Controller Name","action"=>"Action","get_values"=>"Get Values","post_values"=>"Post Values"),'PublishedBranchList'=>array($PublishedBranchList))); ?>
<?php echo $this->element('import',array('postData'=>array("sr_no"=>"Sr No","model_name"=>"Model Name","controller_name"=>"Controller Name","action"=>"Action","get_values"=>"Get Values","post_values"=>"Post Values"))); ?>
</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>