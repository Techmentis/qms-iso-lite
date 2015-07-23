<?php 
$options = array();
foreach($fields as $field){
	if($field != 'id' && $field !='created_by' && $field != 'created' && $field != 'branchid' && $field != 'departmentid' && $field != 'modified' && $field != 'modified_by'  && $field != 'soft_delete'  && $field != 'publish' && $field != 'system_table_id'  && $field != 'master_list_of_format_id')
	{
		if(strpos($field,'_id') == false)$options[]=array($field => __(Inflector::humanize(preg_replace('/_id$/', '', $field))));
	}
}
$options = str_replace(":","=>",str_replace("}","",str_replace("{","",str_replace(']','',str_replace('[','',json_encode($options))))));
?>
<div  id="main">
<?php echo "<?php echo \$this->Session->flash();?>"; ?>	
	<div class="<?php echo $pluralVar; ?> ">
		<?php echo "<?php echo \$this->element('nav-header-lists',array('postData'=>array('pluralHumanName'=>'{$pluralHumanName}','modelClass'=>'{$modelClass}','options'=>array($options),'pluralVar'=>'{$pluralVar}'))); ?>\n"; ?>
		<div class="nav">
			<div id="tabs">	
				<ul>
					<li><?php echo "<?php echo \$this->Html->link(__('New " . $singularHumanName . "'), array('action' => 'add_ajax')); ?>"; ?></li>
<?php
	$done = array();
	foreach ($associations as $type => $data) {
		foreach ($data as $alias => $details) {
			if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
				if(
					Inflector::humanize(Inflector::underscore($alias)) != 'Created By'
					&& Inflector::humanize(Inflector::underscore($alias)) != 'Master List Of Format'
					&& Inflector::humanize(Inflector::underscore($alias)) != 'System Table'
					&& Inflector::humanize(Inflector::underscore($alias)) != 'Modified By'
					&& Inflector::humanize(Inflector::underscore($alias)) != 'Branch Ids'
					&& Inflector::humanize(Inflector::underscore($alias)) != 'Department Ids'
				){
echo "\t\t\t\t\t<li><?php echo \$this->Html->link(__('Add " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add_ajax')); ?> </li>\n";
				$done[] = $details['controller'];
				}
			}
		}
	}
?>
					<li><?php printf("<?php echo \$this->Html->image('indicator.gif', array('id' => 'busy-indicator','class'=>'pull-right')); ?>");?></li>
				</ul>
			</div>
		</div>
	<div id="<?php echo $pluralVar; ?>_tab_ajax"></div>
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

<?php echo "<?php echo \$this->element('export'); ?>\n"; ?>
<?php echo "<?php echo \$this->element('advanced-search',array('postData'=>array(".$options ."),'PublishedBranchList'=>array(\$PublishedBranchList))); ?>\n"; ?>
<?php echo "<?php echo \$this->element('import',array('postData'=>array(".$options ."))); ?>\n"; ?>
</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>