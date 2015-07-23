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
<div id="<?php echo $pluralVar; ?>_ajax">
<?php echo "<?php echo \$this->Session->flash();?>"; ?>	
<div class="nav">
<div class="<?php echo $pluralVar; ?> form col-md-8">
<h4><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?>
		<?php printf("<?php echo \$this->Html->link(__('List'), array('action' => 'index'),array('id'=>'list','class'=>'label btn-info')); ?>\n"); ?>
		<?php printf("<?php echo \$this->Html->link(__('Edit'), '#edit',array('id'=>'edit','class'=>'label btn-info','data-toggle'=>'modal')); ?>\n"); ?>
		<?php printf("<?php echo \$this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>\n");?>
		</h4>
<table class="table table-responsive">
<?php
foreach ($fields as $field) {
	if($field != 'id' && $field !='created_by' && $field != 'created' && $field != 'modified' && $field != 'modified_by' && $field !='system_table_id' && $field !='master_list_of_format_id' && $field !='soft_delete'){ 
	$isKey = false;
	if($field == 'publish' || $field == 'soft_delete'){
		echo "\t\t<tr><td><?php echo __('" . Inflector::humanize($field) . "'); ?></td>\n";
		echo "\n\t\t<td>";
		echo "\n\t\t\t<?php if(\${$singularVar}['{$modelClass}']['{$field}'] == 1) { ?>";
		echo "\n\t\t\t<span class=\"glyphicon glyphicon-ok-sign\"></span>";
		echo "\n\t\t\t<?php } else { ?>";
		echo "\n\t\t\t<span class=\"glyphicon glyphicon-remove-circle\"></span>";
		echo "\n\t\t\t<?php } ?>";
		echo "&nbsp;</td>\n";
		echo "&nbsp;</td></tr>\n";
							
	}else{
	if (!empty($associations['belongsTo'])) {
		foreach ($associations['belongsTo'] as $alias => $details) {
			if ($field === $details['foreignKey']) {
				$isKey = true;
				echo "\t\t<tr><td><?php echo __('" . Inflector::humanize(Inflector::underscore($alias)) . "'); ?></td>\n";
				echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t\t&nbsp;\n\t\t</td></tr>\n";
				break;
			}
		}
	}
	if ($isKey !== true) {
		echo "\t\t<tr><td><?php echo __('" . Inflector::humanize($field) . "'); ?></td>\n";
		echo "\t\t<td>\n\t\t\t<?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>\n\t\t\t&nbsp;\n\t\t</td></tr>\n";
	}
	}
	}
}
?>
</table>
<?php echo "<?php echo \$this->Form->create('Upload',array('role'=>'form','class'=>'form')); ?>\n"?>
<?php echo "\t<fieldset>" ?>
<?php echo "\t\t<?php \n" ?>
<?php echo "\t\t\techo \$this->Upload->edit('upload',\$this->Session->read('User.id').'/'.\$this->request->params['controller'].'/'.\${$singularVar}['{$modelClass}']['id']);\n"?>
<?php echo "\t\t\techo \$this->Form->end(); ?>\n" ?>
<?php echo "\t</fieldset>" ?>
</div>
<div class="col-md-4">
	<p><?php echo "<?php echo \$this->element('helps'); ?>" ?></p>
</div>
</div>
<?php echo "<?php echo \$this->Js->get('#list');?>\n" ?>
<?php echo "<?php echo \$this->Js->event('click',\$this->Js->request(array('action' => 'index', 'ajax'),array('async' => true, 'update' => '#".$pluralVar."_ajax')));?>\n"?>

<?php echo "<?php echo \$this->Js->get('#edit');?>\n" ?>
<?php echo "<?php echo \$this->Js->event('click',\$this->Js->request(array('action' => 'edit',\${$singularVar}['{$modelClass}']['{$primaryKey}'] ,'ajax'),array('async' => true, 'update' => '#".$pluralVar."_ajax')));?>\n"?>


<?php echo "<?php echo \$this->Js->writeBuffer();?>\n" ?>

</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>
