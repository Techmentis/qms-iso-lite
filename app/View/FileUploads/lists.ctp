<div  id="main">
<?php echo $this->Session->flash();?>	
	<div class="fileUploads ">
		<?php echo $this->element('nav-header-lists',array('postData'=>array('pluralHumanName'=>'File Uploads','modelClass'=>'FileUpload','options'=>array("sr_no"=>"Sr No","record"=>"Record","file_details"=>"File Details","file_type"=>"File Type","file_status"=>"File Status","result"=>"Result"),'pluralVar'=>'fileUploads'))); ?>
		<div class="nav">
			<div id="tabs">	
				<ul>
					<li><?php echo $this->Html->link(__('New File Upload'), array('action' => 'add_ajax')); ?></li>
					<li><?php echo $this->Html->link(__('Add User'), array('controller' => 'users', 'action' => 'add_ajax')); ?> </li>
					<li><?php echo $this->Html->link(__('Add User Session'), array('controller' => 'user_sessions', 'action' => 'add_ajax')); ?> </li>
					<li><?php echo $this->Html->link(__('Add Evidence'), array('controller' => 'evidences', 'action' => 'add_ajax')); ?> </li>
					<li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator','class'=>'pull-right')); ?></li>
				</ul>
			</div>
		</div>
	<div id="fileUploads_tab_ajax"></div>
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
<?php echo $this->element('advanced-search',array('postData'=>array("sr_no"=>"Sr No","record"=>"Record","file_details"=>"File Details","file_type"=>"File Type","file_status"=>"File Status","result"=>"Result"),'PublishedBranchList'=>array($PublishedBranchList))); ?>
<?php echo $this->element('import',array('postData'=>array("sr_no"=>"Sr No","record"=>"Record","file_details"=>"File Details","file_type"=>"File Type","file_status"=>"File Status","result"=>"Result"))); ?>
</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>