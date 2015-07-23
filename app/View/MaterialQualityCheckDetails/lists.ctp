<div  id="main">
<?php echo $this->Session->flash();?>	
	<div class="materialQualityCheckDetails ">
		<?php echo $this->element('nav-header-lists',array('postData'=>array('pluralHumanName'=>'Material Quality Check Details','modelClass'=>'MaterialQualityCheckDetail','options'=>array("sr_no"=>"Sr No","material_quality_check"=>"Material Quality Check","check_performed_date"=>"Check Performed Date","quantity_received"=>"Quantity Received","quantity_accepted"=>"Quantity Accepted"),'pluralVar'=>'materialQualityCheckDetails'))); ?>
		<div class="nav">
			<div id="tabs">	
				<ul>
					<li><?php echo $this->Html->link(__('New Material Quality Check Detail'), array('action' => 'add_ajax')); ?></li>
					<li><?php echo $this->Html->link(__('Add Employee'), array('controller' => 'employees', 'action' => 'add_ajax')); ?> </li>
					<li><?php echo $this->Html->link(__('Add Company'), array('controller' => 'companies', 'action' => 'add_ajax')); ?> </li>
					<li><?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator','class'=>'pull-right')); ?></li>
				</ul>
			</div>
		</div>
	<div id="materialQualityCheckDetails_tab_ajax"></div>
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
<?php echo $this->element('advanced-search',array('postData'=>array("sr_no"=>"Sr No","material_quality_check"=>"Material Quality Check","check_performed_date"=>"Check Performed Date","quantity_received"=>"Quantity Received","quantity_accepted"=>"Quantity Accepted"),'PublishedBanchList'=>array($PublishedBanchList))); ?>
<?php echo $this->element('import',array('postData'=>array("sr_no"=>"Sr No","material_quality_check"=>"Material Quality Check","check_performed_date"=>"Check Performed Date","quantity_received"=>"Quantity Received","quantity_accepted"=>"Quantity Accepted"))); ?>
</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>