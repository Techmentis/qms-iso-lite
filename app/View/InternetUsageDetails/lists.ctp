<div  id="main">
<?php echo $this->Session->flash();?>	
	<div class="internetUsageDetails ">
		<?php echo $this->element('nav-header-lists',array('postData'=>array('pluralHumanName'=>'Internet Usage Details','modelClass'=>'InternetUsageDetail','options'=>array("sr_no"=>"Sr No","internet_provider_name"=>"Internet Provider Name","plan_details"=>"Plan Details","from_date"=>"From Date","to_date"=>"To Date","download"=>"Download"),'pluralVar'=>'internetUsageDetails'))); ?>
		<div class="nav">
			<div id="tabs">	
				<ul>
					<li><?php echo $this->Html->link(__('New Internet Usage Detail'), array('action' => 'add_ajax')); ?></li>
					<li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator','class'=>'pull-right')); ?></li>
				</ul>
			</div>
		</div>
	<div id="internetUsageDetails_tab_ajax"></div>
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
<?php echo $this->element('advanced-search',array('postData'=>array("sr_no"=>"Sr No","internet_provider_name"=>"Internet Provider Name","plan_details"=>"Plan Details","from_date"=>"From Date","to_date"=>"To Date","download"=>"Download"),'PublishedBranchList'=>array($PublishedBranchList))); ?>
<?php echo $this->element('import',array('postData'=>array("sr_no"=>"Sr No","internet_provider_name"=>"Internet Provider Name","plan_details"=>"Plan Details","from_date"=>"From Date","to_date"=>"To Date","download"=>"Download"))); ?>
</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>