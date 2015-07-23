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
		<?php printf("\n\t\t<?php echo \$this->Html->link(__('List'), array('action' => 'index'),array('id'=>'list','class'=>'label btn-info')); ?>\n"); ?>
		<?php printf("<?php echo \$this->Html->link(__('Import'), '#import',array('class'=>'label btn-info','data-toggle'=>'modal')); ?>\n"); ?>
		</h4>
<?php echo "<?php echo \$this->Form->create('{$modelClass}',array('role'=>'form','class'=>'form')); ?>\n"; ?>
	<fieldset>
		
<?php
		echo "\t<?php\n";
		foreach ($fields as $field) {
			if (strpos($action, 'add') !== false && $field == $primaryKey || $field =='sr_no') {
				continue;
			} elseif (!in_array($field, array('created', 'modified', 'updated','created_by','modified_by','soft_delete','system_table_id','master_list_of_format_id','publish','branch_id','department_id'))) {
				
						if (strpos($field, '_id') !== false){
							$model_name_new = explode("_id",$field);
							echo "\t\techo \$this->Form->input('{$field}',array('style'=>'width:90%')); \n";
							echo "\t\techo \$this->Js->link('Add New',array('controller'=>'{$model_name_new[0]}s','action'=>'add'),array('class'=>'label btn-info','update'=>'#".$pluralVar."_ajax'));\n";
						}else{
							if($field == 'prepared_by' or $field == 'approved_by'){
								$model_name_new = explode("_id",$field);
							echo "\t\techo \$this->Form->input('{$field}',array('options'=>\$prepared_by,'style'=>'width:90%')); \n";
							echo "\t\techo \$this->Js->link('Add New',array('controller'=>'{$model_name_new[0]}s','action'=>'add'),array('class'=>'label btn-info','update'=>'#".$pluralVar."_ajax'));\n";
						}else{
							echo "\t\techo \$this->Form->input('{$field}'); \n";
						}
						}
					
			}
		}
		if (!empty($associations['hasAndBelongsToMany'])) {
			foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
				echo "\t\techo \$this->Form->input('{$assocName}');\n";
			}
		}
		
		echo "\t?>\n";
?>
<?php
	echo "\t<?php if(\$show_approvals && \$show_approvals['show_panel'] == true ) { ?>\n";
	echo "\t\t<div class=\"clearfix\">&nbsp;</div><div class=\"panel panel-default\"> <div class=\"panel-heading\"><h3 class=\"panel-title\"><?php echo __(\"Send for approval\") ?></h3></div><div class=\"panel-body\"><?php echo __(\"Records added to this table will be send to the person you choose from the list below.\")?>\n";
	echo "\t\t\t<?php echo \$this->Form->input('Approval.user_id',array('options'=>\$userids));?>\n";
	echo "\t\t\t<?php echo \$this->Form->input('Approval.comments',array('type'=>'textarea'));?>\n";
	echo "\t\t<?php if(\$same == \$this->Session->read('User.id'))echo \$this->Form->input('publish',array('label'=>'Do not send forward. Publish Now')) ?>\n";
	echo "\t</div>\n";
	?>
		<?php echo "<?php echo \$this->element(\"approval_history\");?>\n"; ?>
		<?php echo "</div><?php } else { ?>\n"?>
	<?php
	echo "\t\t\t<?php echo \$this->Form->input('publish');?>\n";
	echo "\t<?php } ?>\n";
?>
<?php
	
	echo "<?php echo \$this->Form->submit('Submit',array('div'=>false,'class'=>'btn btn-primary btn-success')); ?>\n";
	echo "<?php echo \$this->Form->end(); ?>\n";
	echo "<?php echo \$this->Js->writeBuffer();?>\n";
?>
	</fieldset>
</div>
<script> $("[name*='date']").datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat:'yy-mm-dd',
    }); </script>
<div class="col-md-4">
	<p><?php echo "<?php echo \$this->element('helps'); ?>" ?></p>
</div>
</div>
<?php echo "<?php echo \$this->Js->get('#list');?>\n" ?>
<?php echo "<?php echo \$this->Js->event('click',\$this->Js->request(array('action' => 'index', 'ajax'),array('async' => true, 'update' => '#".$pluralVar."_ajax')));?>\n"?>

<?php echo "<?php echo \$this->Js->writeBuffer();?>\n" ?>
</div>
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