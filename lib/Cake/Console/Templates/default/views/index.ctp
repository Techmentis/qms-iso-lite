<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

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
<script>
	function getVals(){
		
	var checkedValue = null;
	$("#recs_selected").val(null);
	var inputElements = document.getElementsByTagName('input');
	
	for(var i=0; inputElements[i]; ++i){
		
	      if(inputElements[i].className==="rec_ids" && 
		 inputElements[i].checked){
		   $("#recs_selected").val($("#recs_selected").val() + '+' + inputElements[i].value);
		   
	      }
	}
	}
</script>
<div  id="main">
<?php echo "<?php echo \$this->Session->flash();?>"; ?>	
	<div class="<?php echo $pluralVar; ?> ">
		<?php echo "<?php echo \$this->element('nav-header-lists',array('postData'=>array('pluralHumanName'=>'{$pluralHumanName}','modelClass'=>'{$modelClass}','options'=>array($options),'pluralVar'=>'{$pluralVar}'))); ?>\n"; ?>

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
		<?php echo "<?php echo \$this->Form->create(array('class'=>'no-padding no-margin no-background'));?>"?>				
			<table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
				<tr>
					<th></th>
					<th></th>
<?php $i=0; ?>					
<?php foreach ($fields as $field): ?>
<?php if($field != 'id' && $field !='created_by' && $field != 'created' && $field != 'modified' && $field != 'modified_by'  && $field != 'soft_delete' && $field != 'system_table_id'   && $field != 'master_list_of_format_id' && $field != 'branchid' && $field != 'departmentid'){ ?>
				<th><?php echo "<?php echo \$this->Paginator->sort('{$field}'); ?>";?></th>
<?php	} ?>
<?php	$i++; ?>
<?php endforeach; ?>
				
				</tr>
				<?php
					echo "<?php if(\${$pluralVar}){ ?>\n";
					echo "<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
					echo "\t<tr>\n";
					echo "<td width=\"15\"><?php echo \$this->Form->checkbox('rec_ids_'.\$i,array('label'=>false,'value'=>\${$singularVar}['{$modelClass}']['id'],'multiple'=>'checkbox','class'=>'rec_ids')); ?></td>";
					echo "\t\t<td class=\" actions\">\n";
					echo "\t\t<div class=\"btn-group\">\n";
					echo "\t\t<button type=\"button\" data-toggle=\"dropdown\" class=\"dropdown-toggle btn  btn-sm btn-default \"><span class=\" glyphicon glyphicon-wrench\"></span></button>\n";
					
					echo "\t\t\t</button>\n";
					echo "\t\t\t\t<ul class=\"dropdown-menu\" role=\"menu\">\n";
					echo "\t\t\t\t<li><?php echo \$this->Html->link(__('View / Upload Evidence'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?></li>\n";
					echo "\t\t\t\t<li><?php echo \$this->Html->link(__('Edit'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?></li>\n";
					echo "\t\t\t\t<li><?php echo \$this->Form->postLink(__('Delete'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('style'=>'display:none'), __('Are you sure you want to delete this record ?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?></li>\n";
					echo "\t\t\t\t<li class=\"divider\"></li>\n";		
					echo "\t\t\t\t<li><?php echo \$this->Form->postLink(__('Delete Record'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('class'=>''), __('Are you sure ?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?></li>\n";
					echo "\t\t\t</ul>\n";
					echo "\t\t</div>\n";
					echo "\t\t</td>\n";
					foreach ($fields as $field) {
						if($field != 'id' && $field !='created_by' && $field != 'created' && $field != 'modified' && $field != 'modified_by'  && $field != 'soft_delete'  && $field != 'system_table_id'   && $field != 'master_list_of_format_id' && $field != 'branchid' && $field != 'departmentid'){
						
						if($field == 'publish'){
							echo "\n\t\t<td width=\"60\">";
							echo "\n\t\t\t<?php if(\${$singularVar}['{$modelClass}']['{$field}'] == 1) { ?>";
							echo "\n\t\t\t<span class=\"glyphicon glyphicon-ok-sign\"></span>";
							echo "\n\t\t\t<?php } else { ?>";
							echo "\n\t\t\t<span class=\"glyphicon glyphicon-remove-circle\"></span>";
							echo "\n\t\t\t<?php } ?>";
							echo "&nbsp;</td>\n";	
						}else
						{
						
							$isKey = false;
							if (!empty($associations['belongsTo'])) {
								foreach ($associations['belongsTo'] as $alias => $details) {
									if ($field === $details['foreignKey']) {
										$isKey = true;
										echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
										break;
									}
								}
							}
							if ($isKey !== true) {
								if($field == 'sr_no'){
									echo "\t\t<td width=\"50\"><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";	
									}else{
									echo "\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";	
									}
								
							}
						}
						
					}
					}
		      
					
					echo "\t</tr>\n"; 
				echo "<?php endforeach; ?>\n";
				echo "<?php }else{ ?>\n";
				echo "\t<tr><td colspan=".$i.">No results found</td></tr>\n";
				echo "<?php } ?>\n";
				?>
			</table>
<?php echo "<?php echo \$this->Form->end();?>" ?>			
		</div>
			<p>
			<?php echo "<?php
			echo \$this->Paginator->options(array(
			'update' => '#main',
			'evalScripts' => true,
			'before' => \$this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			'complete' => \$this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
			));
			
			echo \$this->Paginator->counter(array(
			'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
			));
			?>"; ?>
			</p>
			<ul class="pagination">
			<?php
				echo "<?php\n";
				echo "\t\techo \"<li class='previous'>\".\$this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')).\"</li>\";\n";
				echo "\t\techo \"<li>\".\$this->Paginator->numbers(array('separator' => '')).\"</li>\";\n";
				echo "\t\techo \"<li class='next'>\".\$this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')).\"</li>\";\n";
				echo "\t?>\n";
			?>
			</ul>
		</div>
	</div>
	</div>	

<?php echo "<?php echo \$this->element('export'); ?>\n"; ?>
<?php echo "<?php echo \$this->element('advanced-search',array('postData'=>array(".$options ."),'PublishedBranchList'=>array(\$PublishedBranchList))); ?>\n"; ?>
<?php echo "<?php echo \$this->element('import',array('postData'=>array(".$options ."))); ?>\n"; ?>
<?php echo "<?php echo \$this->element('export'); ?>\n"; ?>
<?php echo "<?php echo \$this->element('approvals'); ?>\n"; ?>
</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>