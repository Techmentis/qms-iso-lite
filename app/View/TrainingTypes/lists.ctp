<div  id="main">
<?php echo $this->Session->flash();?>	
	<div class="trainingTypes ">
		<?php echo $this->element('nav-header-lists',array('postData'=>array('pluralHumanName'=>'Training Types','modelClass'=>'TrainingType','options'=>array("sr_no"=>"Sr No","title"=>"Title","training_description"=>"Training Description","mandetory"=>"Mandetory"),'pluralVar'=>'trainingTypes'))); ?>
		<div class="nav">
			<div id="tabs">	
				<ul>
					<li><?php echo $this->Html->link(__('New Training Type'), array('action' => 'add_ajax')); ?></li>

					<li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator','class'=>'pull-right')); ?></li>
				</ul>
			</div>
		</div>
	<div id="trainingTypes_tab_ajax"></div>
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
<?php echo $this->element('advanced-search',array('postData'=>array("sr_no"=>"Sr No","title"=>"Title","training_description"=>"Training Description","mandetory"=>"Mandetory"),'PublishedBranchList'=>array($PublishedBranchList))); ?>
<?php echo $this->element('import',array('postData'=>array("sr_no"=>"Sr No","title"=>"Title","training_description"=>"Training Description","mandetory"=>"Mandetory"))); ?>
</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>