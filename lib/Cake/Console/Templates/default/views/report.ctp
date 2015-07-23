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
	if($field != 'id' && $field !='created_by' && $field != 'created' && $field != 'modified' && $field != 'modified_by' && $field != 'publish' && $field != 'soft_delete')
	{
		if(strpos($field,'_id') == false)$options[]=array($field => __(Inflector::humanize(preg_replace('/_id$/', '', $field))));
	}
}
$options = str_replace(":","=>",str_replace("}","",str_replace("{","",str_replace(']','',str_replace('[','',json_encode($options))))));
?>
<?php echo "<?php echo \$this->Html->script(array('openwysiwyg/scripts/wysiwyg','openwysiwyg/scripts/wysiwyg-settings','jquery-ui'));\n ?>";?>
<?php echo "<?php echo \$this->Html->css(array('openwysiwyg/styles/wysiwyg'));\n ?>";?>
<script type="text/javascript">
    WYSIWYG.attach('ReportDetails',full);
</script>
<div id="reports_ajax">
    <?php echo "<?php echo \$this->Session->flash();?>\n"; ?>	
        <div class="nav">
            <div class="reports form col-md-8">
            <h4><?php echo __('Add Report'); ?>
            <?php printf("<?php echo \$this->Html->link(__('List'), array('action' => 'index'),array('id'=>'list','class'=>'label btn-info'));\n ?>");?>
	    <?php printf("<?php echo \$this->Html->link('', '#advanced_search',array('class'=>'glyphicon glyphicon-search h4-title','data-toggle'=>'modal')); ?>\n");?>
	    <?php printf("<?php echo \$this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>\n");?>
	    </h4>
            <?php echo "<?php echo \$this->Form->create('Report',array('controller'=>'reports','action'=>'add'),array('role'=>'form','class'=>'form'));\n ?>";?>
	<fieldset>
    	<div class="panel panel-default">
            <div class="panel-body">
            Below is the system generated report. You can modify this report and save it under report center. <br/>
            Report is rendered in a Text Editor so that you can make the required changes.<br/>
            You can either publish this report as it is or keep it ready in reports center.
            </div>
        </div>	
        <textarea id="ReportDetails" name="data[Report][details]" style="float:left; clear:both">        
	<table cellpadding="2" cellspacing="2" border="1" width="100%" style="font-size:10px">
		<tr>
			<td colspan="4"><h2>Company Name (ISO CERTFICATION DOCUMENTS) :</h2>Powered by : FlinkISO ™</td>
		</tr>
		<tr>
			<td>Document Title </td><td>&nbsp;<?php echo "<?php echo h(\${$singularVar}['MasterListOfFormat']['title']); ?>";?></td>
			<td>Document Number</td><td>&nbsp;<?php echo "<?php echo h(\${$singularVar}['MasterListOfFormat']['document_number']); ?>"?></td>
		</tr>
		<tr>
			<td>Revision Number </td><td>&nbsp;<?php echo "<?php echo h(\${$singularVar}['MasterListOfFormat']['revision_number']); ?>"?></td>
			<td>Revision Date</td><td>&nbsp;<?php echo "<?php echo h(\${$singularVar}['MasterListOfFormat']['revision_date']); ?>"?></td>
		</tr>
                </table>
	<table cellpadding="2" cellspacing="2" border="1" width="100%" style="font-size:10px">
		<tr>
<?php foreach ($fields as $field): ?>
<?php if($field != 'id' && $field !='created_by' && $field != 'created' && $field != 'modified' && $field != 'modified_by'  && $field != 'soft_delete' && $field != 'system_table_id'  && $field != 'master_list_of_format_id'){ ?>
				<th><?php echo "<?php echo h(Inflector::humanize(\"{$field}\"));?>" ?></th>
<?php	} ?>
<?php endforeach; ?>
				
				</tr>
	<tr>
	<?php
					echo "<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
					echo "\t<tr>\n";
					foreach ($fields as $field) {
						if($field != 'id' && $field !='created_by' && $field != 'created' && $field != 'modified' && $field != 'modified_by'  && $field != 'soft_delete'  && $field != 'system_table_id'  && $field != 'master_list_of_format_id')
						{
							$isKey = false;
							if (!empty($associations['belongsTo']))
							{
								foreach ($associations['belongsTo'] as $alias => $details) {
									if ($field === $details['foreignKey']) {
										$isKey = true;
							
										echo "\t\t<td width=\"50\"><?php echo h(\${$singularVar}['{$alias}']['{$details['displayField']}']); ?>&nbsp;</td>\n";	
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
				echo "\t</tr>\n"; 
				echo "\t<?php endforeach; ?>\n";
				?>
			</table>
			<table cellpadding="2" cellspacing="2" border="1" width="100%" style="font-size:10px">
		                <tr>
		                    <td>Prepared By </td><td>&nbsp;</td>
		                    <td>Approved By</td><td>&nbsp;</td>
		                </tr>
			</table>
	        </textarea>
	<?php
		echo "<?php echo \$this->Form->input('title');?>\n";
		echo "<?php echo \$this->Form->input('branch_id',array('style'=>'width:90%','options'=>\$PublishedBranchList));?>\n";
		echo "<?php echo \$this->Js->link('Add New',array('controller'=>'branchs','action'=>'add'),array('class'=>'label btn-info','update'=>'#reports_ajax'));?>\n";
		echo "<?php echo \$this->Form->input('department_id',array('style'=>'width:90%','options'=>\$PublishedDepartmentList));?>\n";
		echo "<?php echo \$this->Js->link('Add New',array('controller'=>'departments','action'=>'add'),array('class'=>'label btn-info','update'=>'#reports_ajax'));?>\n";
		echo "<?php echo \$this->Form->input('master_list_of_format_id',array('style'=>'width:90%'));?>\n";
		echo "<?php echo \$this->Js->link('Add New',array('controller'=>'master_list_of_formats','action'=>'add'),array('class'=>'label btn-info','update'=>'#reports_ajax'));?>\n";
		echo "<?php echo \$this->Form->input('description');?>\n";
                echo "<?php echo \$this->Form->input('report_date');?>\n";
		echo "<?php echo \$this->Form->input('publish');?>\n";
                echo "<?php echo \$this->Form->submit('Submit',array('div'=>false,'class'=>'btn btn-primary btn-success'));?>\n";
                echo "<?php echo \$this->Form->end();?>\n";
                echo "<?php echo \$this->Js->writeBuffer();?>\n";
        ?>

</fieldset>
</div>
<script> $("#ReportReportDate").datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat:'yy-mm-dd',
    }); </script>
<div class="col-md-4">

	<p><?php echo "<?php echo \$this->element('helps');\n ?>"?></p>
</div>
</div>
<?php echo "<?php echo \$this->Js->get('#list');\n ?>"?>
<?php echo "<?php echo \$this->Js->event('click',\$this->Js->request(array('action' => 'index', 'ajax'),array('async' => true, 'update' => '#reports_ajax')));\n ?>"?>

<?php echo "<?php echo \$this->Js->writeBuffer();\n ?>"?>

<?php
	echo "\t\t<div class=\"modal fade\" id=\"advanced_search\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">\n";
	echo "\t\t<div class=\"modal-dialog\">\n";
	echo "\t\t<div class=\"modal-content\">\n";
	echo "\t\t<div class=\"modal-header\">\n";
	echo "\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>\n";
	echo "\t\t<h4 class=\"modal-title\">".__('Advanced Search')."</h4>\n";
        echo "\t\t</div>\n";
	echo "<div class=\"modal-body\"><?php echo \$this->element('advanced-search',array('postData'=>array(".$options ."),'PublishedBranchList'=>array(\$PublishedBranchList))); ?></div>\n";
        echo "\t\t<div class=\"modal-footer\">\n";
	echo "\t\t<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\n";
        echo "\t\t</div></div></div></div>\n";
        
?>


</div></div></div>
</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>
	