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
			if($field != 'id' && $field !='created_by' && $field != 'created' && $field != 'modified' && $field != 'modified_by'  && $field != 'soft_delete'  && $field != 'publish' && $field != 'system_table_id'  && $field != 'master_list_of_format_id')
			{
				if(strpos($field,'_id') == false)$options[]=array($field => __(Inflector::humanize(preg_replace('/_id$/', '', $field))));
			}
				
		}
		$options = str_replace(":","=>",str_replace("}","",str_replace("{","",str_replace(']','',str_replace('[','',json_encode($options))))));
?>
<div  id="<?php echo $pluralVar; ?>_ajax">
<?php echo "<?php echo \$this->Session->flash();?>"; ?>	
	<div class="<?php echo $pluralVar; ?> ">
		<div class="container">
			<div class="row">
				<div class="col-md-4 pull-right">
					<div class="input-group pull-left">
						<?php echo "<?php echo \$this->Form->create('{$modelClass}',array('role'=>'form','class'=>'no-padding no-margin','id'=>'search-form','action'=>'search')); ?>\n"; ?>  
						<?php echo  "<?php echo \$this->Form->input(__('search'),array('label'=>false,'placeholder'=>'search','role'=>'form','class'=>'form-control','action'=>'search')); ?>\n"; ?>  	    
							<div class="input-group-btn">
								<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">Select Fields <span class="caret"></span></button>
								<ul class="dropdown-menu pull-right">
									<?php echo "<li class=\"search-dropdown\"><?php echo \$this->Form->input('search_field',array('multiple'=>'checkbox','options'=>array(".$options.")));?></li>"; ?>		
									<?php echo "<li><?php echo \$this->Js->submit('Submit',array('url'=>'search','div'=>false,'class'=>'btn btn-primary btn-success','update' => '#".$pluralVar."_ajax','type'=>'data','method'=>'post')); ?>\n;"?>
									<?php echo "<?php echo \$this->Form->end(); ?></li>\n";?>
								</ul>
							</div><!-- /btn-group -->
					</div><!-- /input-group -->
				</div><!-- /.col-lg-3 -->
			
				<div class="col-md-8">
					<h4><?php echo "<?php echo __('{$pluralHumanName}'); ?>\n"; ?>
					<?php printf("<?php echo \$this->Html->link(__('List'), array('action' => 'index'),array('id'=>'list','class'=>'label btn-info')); ?>\n"); ?>
					<?php printf("<?php echo \$this->Html->link(__('Add'), array('action' => 'add'),array('id'=>'addrecord','class'=>'label btn-primary')); ?>\n");?>
					<?php printf("<?php echo \$this->Html->link(__('Export'), '#export',array('class'=>'label btn-warning','data-toggle'=>'modal')); ?>\n");?>
					<?php printf("<?php echo \$this->Html->link(__('Import'), '#import',array('class'=>'label btn-info','data-toggle'=>'modal')); ?>\n");?>
					<?php printf("<?php echo \$this->Html->link('', '#advanced_search',array('class'=>'glyphicon glyphicon-search h4-title','data-toggle'=>'modal')); ?>\n");?>
					<?php printf("<?php echo \$this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>\n");?>
					
					</h4>
				    
				</div>
			</div>
		</div>
	
		<div class="table-responsive">
			<table cellpadding="0" cellspacing="0" class="table table-bordered table table-striped table-hover">
				<tr>
					<th></th>
<?php $i=0; ?>					
<?php foreach ($fields as $field): ?>
<?php if($field != 'id' && $field !='created_by' && $field != 'created' && $field != 'modified' && $field != 'modified_by'  && $field != 'soft_delete' && $field != 'system_table_id'  && $field != 'master_list_of_format_id'){ ?>
				<th><?php echo "<?php echo \$this->Paginator->sort('{$field}'); ?>";?></th>
<?php	} ?>
<?php	$i++; ?>
<?php endforeach; ?>
				
				</tr>
				<?php
					echo "<?php if(\${$pluralVar}){ ?>\n";
					echo "<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
					echo "\t<tr>\n";
					echo "\t\t<td class=\" actions\">\n";
					echo "\t\t<div class=\"btn-group\">\n";
					echo "\t\t<button type=\"button\" data-toggle=\"dropdown\" class=\"dropdown-toggle btn  btn-sm btn-default \"><span class=\" glyphicon glyphicon-wrench\"></span></button>\n";
					
					echo "\t\t\t</button>\n";
					echo "\t\t\t\t<ul class=\"dropdown-menu\" role=\"menu\">\n";
					echo "\t\t\t\t<li><?php echo \$this->Html->link(__('View'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?></li>\n";
					echo "\t\t\t\t<li><?php echo \$this->Html->link(__('Edit'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?></li>\n";
					echo "\t\t\t\t<li><?php echo \$this->Form->postLink(__('Delete'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('class'=>''), __('Are you sure you want to delete this record ?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?></li>\n";
					echo "\t\t\t\t<li class=\"divider\"></li>\n";		
					echo "\t\t\t\t<li><?php echo \$this->Html->link(__('Upload Evedance'), '#uploadevidance',array('data-toggle'=>'modal')); ?></li>\n";
					echo "\t\t\t\t<li><?php echo \$this->Html->link(__('Send for Approval'), '#makerchecker',array('data-toggle'=>'modal')); ?></li>\n";
					echo "\t\t\t\t<li><?php echo \$this->Form->postLink(__('Email Record'), array('controller'=>'message','action' => 'add', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('class'=>''), __('Are you sure ?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?></li>\n";
					echo "\t\t\t</ul>\n";
					echo "\t\t</div>\n";
					echo "\t\t</td>\n";
					foreach ($fields as $field) {
						if($field != 'id' && $field !='created_by' && $field != 'created' && $field != 'modified' && $field != 'modified_by'  && $field != 'soft_delete' && $field != 'system_table_id'  && $field != 'master_list_of_format_id')
						{
						
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
		</div>
			<p>
			<?php echo "<?php
			echo \$this->Paginator->options(array(
			'update' => '#".$pluralVar."_ajax',
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

<?php echo "<?php echo \$this->Js->get('#list');?>\n" ?>
<?php echo "<?php echo \$this->Js->event('click',\$this->Js->request(array('action' => 'index', 'ajax'),array('async' => true, 'update' => '#".$pluralVar."_ajax')));?>\n"?>

<?php echo "<?php echo \$this->Js->get('#addrecord');?>\n"?>
<?php echo "<?php echo \$this->Js->event('click',\$this->Js->request(array('action' => 'add', 'ajax'),array('async' => true, 'update' => '#".$pluralVar."_ajax')));?>\n"?>

<?php echo "<?php echo \$this->Js->writeBuffer();?>\n"?>


<?php
	echo "\t\t<div class=\"modal fade\" id=\"export\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">\n";
	echo "\t\t<div class=\"modal-dialog\">\n";
	echo "\t\t<div class=\"modal-content\">\n";
	echo "\t\t<div class=\"modal-header\">\n";
	echo "\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>\n";
	echo "\t\t<h4 class=\"modal-title\">Export Data</h4>\n";
        echo "\t\t</div>\n";
	echo "<div class=\"modal-body\"><?php echo \$this->element('export'); ?></div>\n";
        echo "\t\t<div class=\"modal-footer\">\n";
	echo "\t\t<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\n";
        echo "\t\t</div></div></div></div>\n";
        
?>

<?php
	echo "\t\t<div class=\"modal fade\" id=\"advanced_search\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">\n";
	echo "\t\t<div class=\"modal-dialog\">\n";
	echo "\t\t<div class=\"modal-content\">\n";
	echo "\t\t<div class=\"modal-header\">\n";
	echo "\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>\n";
	echo "\t\t<h4 class=\"modal-title\">Select Date range</h4>\n";
        echo "\t\t</div>\n";
	echo "<div class=\"modal-body\"><?php echo \$this->element('advanced-search',array('postData'=>array(".$options ."),'PublishedBranchList'=>array(\$PublishedBranchList))); ?></div>\n";
        echo "\t\t<div class=\"modal-footer\">\n";
	echo "\t\t<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\n";
        echo "\t\t</div></div></div></div>\n";
        
?>
<?php
	echo "\t\t<div class=\"modal fade\" id=\"makerchecker\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">\n";
	echo "\t\t<div class=\"modal-dialog\">\n";
	echo "\t\t<div class=\"modal-content\">\n";
	echo "\t\t<div class=\"modal-header\">\n";
	echo "\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>\n";
	echo "\t\t<h4 class=\"modal-title\">Send for Approval</h4>\n";
        echo "\t\t</div>\n";
	echo "<div class=\"modal-body\"><?php echo \$this->element('makerchecker'); ?></div>\n";
        echo "\t\t<div class=\"modal-footer\">\n";
	echo "\t\t<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\n";
        echo "\t\t</div></div></div></div>\n";
        
?>

<?php
	echo "\t\t<div class=\"modal fade\" id=\"uploadevidance\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">\n";
	echo "\t\t<div class=\"modal-dialog\">\n";
	echo "\t\t<div class=\"modal-content\">\n";
	echo "\t\t<div class=\"modal-header\">\n";
	echo "\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>\n";
	echo "\t\t<h4 class=\"modal-title\">Send for Approval</h4>\n";
        echo "\t\t</div>\n";
	echo "<div class=\"modal-body\"><?php echo \$this->element('makerchecker'); ?></div>\n";
        echo "\t\t<div class=\"modal-footer\">\n";
	echo "\t\t<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\n";
        echo "\t\t</div></div></div></div>\n";
        
?>


<?php
	echo "\t\t<div class=\"modal fade\" id=\"import\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">\n";
	echo "\t\t<div class=\"modal-dialog\">\n";
	echo "\t\t<div class=\"modal-content\">\n";
	echo "\t\t<div class=\"modal-header\">\n";
	echo "\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>\n";
	echo "\t\t<h4 class=\"modal-title\">Import from file (excel & csv formats only)</h4>\n";
        echo "\t\t</div>\n";
	echo "<div class=\"modal-body\"><?php echo \$this->element('import'); ?></div>\n";
        echo "\t\t<div class=\"modal-footer\">\n";
	echo "\t\t<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\n";
        echo "\t\t</div></div></div></div>\n";
        
?>

</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>