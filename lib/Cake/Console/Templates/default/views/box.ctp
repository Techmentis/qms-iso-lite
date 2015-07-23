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
</script><?php echo "<?php echo \$this->Session->flash();?>"; ?>	
	<div class="<?php echo $pluralVar; ?> ">
		<div id="main">
		<?php echo "<?php echo \$this->element('nav-header-lists',array('postData'=>array('pluralHumanName'=>'{$pluralHumanName}','modelClass'=>'{$modelClass}','options'=>array($options),'pluralVar'=>'{$pluralVar}'))); ?>\n"; ?>	
		
<script type="text/javascript">
$(document).ready(function(){
$('dl dt a').on('click', function() {
	var url = $(this).attr("href");
	$('#main').load(url);
	return false;
});
});
</script>
		<div class="container row  row table-responsive">

			<?php
					echo "<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
					echo "\t<div class='col-md-4'>\n<div class='box-pad'>";
					
					echo "\t\t<div class=\"btn-group\">\n";
					echo "\t\t<button type=\"button\" data-toggle=\"dropdown\" class=\"dropdown-toggle btn  btn-sm btn-info \"><span class=\" glyphicon glyphicon-wrench\"></span></button>\n";
					echo "\t\t\t</button>\n";					
					echo "\t\t\t\t<ul class=\"dropdown-menu\" role=\"menu\">\n";
					echo "\t\t\t\t<li><?php echo \$this->Html->link(__('View / Upload Evidence'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?></li>\n";
					echo "\t\t\t\t<li><?php echo \$this->Html->link(__('Edit'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?></li>\n";
					echo "\t\t\t\t<li><?php echo \$this->Form->postLink(__('Delete'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('style'=>'display:none'), __('Are you sure you want to delete this record ?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?></li>\n";
					echo "\t\t\t\t<li class=\"divider\"></li>\n";		
					echo "\t\t\t\t<li><?php echo \$this->Form->postLink(__('Delete Record'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('class'=>''), __('Are you sure ?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?></li>\n";
					
					echo "\t\t\t</ul>\n";
					echo "\t\t</div>\n";
					
					echo "<dl>";
					
					foreach ($fields as $field) {
						if($field != 'id' && $field !='created_by' && $field != 'created' && $field != 'modified' && $field != 'modified_by'  && $field != 'soft_delete' && $field != 'system_table_id'  && $field != 'master_list_of_format_id'  && $field != 'branchid'  && $field != 'departmentid')
						{
						if($field == 'publish'){
							echo "\n\t\t<dt><?php echo \$this->Paginator->sort('{$field}') ?></dt><dd>";
							echo "\n\t\t\t<?php if(\${$singularVar}['{$modelClass}']['{$field}'] == 1) { ?>";
							echo "\n\t\t\t<span class=\"glyphicon glyphicon-ok-sign\"></span>";
							echo "\n\t\t\t<?php } else { ?>";
							echo "\n\t\t\t<span class=\"glyphicon glyphicon-remove-circle\"></span>";
							echo "\n\t\t\t<?php } ?>";
							echo "&nbsp;</dtd>\n";
						    
						}else{
						$isKey = false;
						if (!empty($associations['belongsTo'])) {
							foreach ($associations['belongsTo'] as $alias => $details) {
								if ($field === $details['foreignKey']) {
									$isKey = true;
									echo "\n\t\t\t<dt><?php echo \$this->Paginator->sort('{$field}') .\"</dt><dd>:\". \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t<dd>\n";
									break;
								}
							}
						}
						if ($isKey !== true) {
							echo "\t\t<dt><?php echo \$this->Paginator->sort('{$field}') .\"</dt><dd>: \". h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;<dd>\n";
						}
						}
						}
					}
		      
					echo "\t</dl>\n";
					echo "<?php echo \$this->Form->checkbox('rec_ids_'.\$i,array('label'=>false,'value'=>\${$singularVar}['{$modelClass}']['id'],'multiple'=>'checkbox','class'=>'rec_ids')); ?></div></div>";
				echo "<?php endforeach; ?>\n";
				?>
			
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


<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>