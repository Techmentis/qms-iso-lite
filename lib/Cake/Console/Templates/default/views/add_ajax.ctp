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
<?php echo "<?php echo \$this->Html->script(array('jquery.validate','jquery-form'));?>\n";?>
<?php echo "<?php echo \$this->fetch('script');?>\n"; ?>

<?php echo
"<script>
$.validator.setDefaults({
submitHandler: function(form) {
$(form).ajaxSubmit({
url:'".$pluralVar."/add_ajax',
type:'POST',
target: '#".$pluralVar."_ajax'});}
});

$().ready(function() {
$('#".$modelClass."AddAjaxForm').validate();});
</script>\n\n"
?>
<div id="<?php echo $pluralVar; ?>_ajax">
<?php echo "<?php echo \$this->Session->flash();?>"; ?>
<div class="nav">
<div class="<?php echo $pluralVar; ?> form col-md-8">
<h4><?php echo __('Add ' .$singularHumanName); ?></h4>
<?php echo "<?php echo \$this->Form->create('{$modelClass}',array('role'=>'form','class'=>'form','default'=>false)); ?>\n"; ?>
<fieldset>
		<?php
		echo "\t<?php\n";
		foreach ($fields as $field)
		{
			if (strpos($action, 'add') !== false && $field == $primaryKey || $field =='sr_no')
				{
				continue;
				} elseif (!in_array($field, array('created', 'modified', 'updated','created_by','modified_by','soft_delete','system_table_id','master_list_of_format_id','publish')))
				{
				
					if (strpos($field, '_id') !== false){
						$model_name_new = explode("_id",$field);
						echo "\t\techo \$this->Form->input('{$field}',array('style'=>'width:90%')); \n";
						echo "\t\techo \$this->Js->link('Add New',array('controller'=>'{$model_name_new[0]}s','action'=>'add_ajax'),array('class'=>'label btn-info pull-right white-link','update'=>'#".$pluralVar."_ajax'));\n";
					}else{
						if(in_array($field, array('branchid'))){
							echo "\t\techo \$this->Form->input('{$field}',array('type'=>'hidden','value'=>\$this->Session->read('User.branch_id'))); \n";
						}elseif(in_array($field, array('departmentid'))){
							echo "\t\techo \$this->Form->input('{$field}',array('type'=>'hidden','value'=>\$this->Session->read('User.department_id'))); \n";
						}else{
						if($field == 'prepared_by' or $field == 'approved_by'){
							$model_name_new = explode("_id",$field);
							echo "\t\techo \$this->Form->input('{$field}',array('options'=>\$prepared_by,'style'=>'width:90%')); \n";
							echo "\t\techo \$this->Js->link('Add New',array('controller'=>'{$model_name_new[0]}s','action'=>'add_ajax'),array('class'=>'label btn-info pull-right white-link','update'=>'#".$pluralVar."_ajax'));\n";
						}else{
							echo "\t\techo \$this->Form->input('{$field}'); \n";
						}
						}
					}
					
			}
		}
		if (!empty($associations['hasAndBelongsToMany']))
		{
			foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData)
			{
				echo "\t\techo \$this->Form->input('{$assocName}');\n";
			}
		}
		
		echo "\t?>\n";
?>
<?php
	echo "\t<?php if(\$show_approvals && \$show_approvals['show_panel'] == true ) { ?>\n";
	echo "\t\t<div class=\"clearfix\">&nbsp;</div>\n\t\t\t\t<div class=\"panel panel-default\">\n\t\t\t\t<div class=\"panel-heading\"><h3 class=\"panel-title\">\n\t\t\t\t<?php echo __(\"Send for approval\") ?></h3></div>\n\t\t\t\t<div class=\"panel-body\"><?php echo __(\"Records added to this table will be send to the person you choose from the list below.\")?>\n";
	echo "\t\t\t<?php echo \$this->Form->input('Approval.user_id',array('options'=>\$userids));?>\n";
	echo "\t\t\t<?php echo \$this->Form->input('Approval.comments',array('type'=>'textarea'));?>\n";
	echo "\t\t<?php if(\$show_approvals['show_publish'] == true)echo \$this->Form->input('publish',array('label'=>'Do not send forward. Publish Now')) ?>\n";
	echo "\t</div> <?php } else {echo \$this->Form->input('publish'); }\n ?>\n";
?>

<?php
	
	echo "<?php echo \$this->Form->submit('Submit',array('div'=>false,'class'=>'btn btn-primary btn-success','update'=>'#".$pluralVar."_ajax','async' => 'false')); ?>\n";
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
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>