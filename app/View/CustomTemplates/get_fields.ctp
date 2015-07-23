<div class="panel-group" id="accordions">
	<div class="panel panel-primary">
		<div class="panel-heading">
				<h4 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordions" href="#master">
	  <?php echo $form_details['MasterListOfFormat']['title'] ?> </h4></a><p>(Drag-Drop these fields in table for parent record)</p>
				
				</h4>
		</div>
		<div id="master" class="panel-collapse collapse">
				<div class="panel-body">
				<?php $i=0; foreach($form_schema as $formKeys => $formValues):
					if ((strpos($formKeys,'_id')) === false) {				
					echo $this->Html->link(Inflector::Humanize($formKeys),' <FlinkISO> report-'.$sys_table_name.'-'.$formKeys.' </FlinkISO> ',array('class'=>'badge label-info add-margin'));
					}else{
					echo '<span class="badge label-default add-margin">'. Inflector::Humanize($formKeys) .'</span>';		
					}
				endforeach; ?>
				</div>
		</div>
	</div>
<?php $i=0; foreach($hasMany_form_schemas as $keys => $hasMany_form_schema): ?>
	<div class="panel panel-danger">
		<div class="panel-heading">
				<h4 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordions" href="#master<?php echo $i ?>">
				<?php echo Inflector::humanize(Inflector::tableize($keys)) ?></a></h4>
				<p>(Drag-Drop these fields in table for related record)</p>				
				
		</div>
		<div id="master<?php echo $i ?>" class="panel-collapse collapse">
				<div class="panel-body">
				<?php foreach($hasMany_form_schema as $related_field => $related_values):
					echo $this->Html->link(Inflector::humanize($related_field),' <FlinkISO> report-'.$keys.'-'.$related_field .' </FlinkISO> ',array('class'=>'badge label-info add-margin'));
					endforeach;
				?>
				</div>
		</div>
	</div>
<?php
$i ++;
endforeach; ?>

<?php $i=0; foreach($associated_form_schemas as $keys => $associated_form_schema): ?>
	<div class="panel panel-info">
		<div class="panel-heading">
				<h4 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordions" href="#master<?php echo $i ?>">
				<?php echo Inflector::humanize(Inflector::tableize($keys)) ?></a></h4>
				<p>(Drag-Drop these fields in table for related record)</p>				
				
		</div>
		<div id="master<?php echo $i ?>" class="panel-collapse collapse">
				<div class="panel-body">
				<?php foreach($associated_form_schema as $related_field => $related_values):
					echo $this->Html->link(Inflector::humanize($related_field),' <FlinkISO> report-'.$keys.'-'.$related_field .' </FlinkISO> ',array('class'=>'badge label-info add-margin'));
					endforeach;
				?>
				</div>
		</div>
	</div>
<?php
$i ++;
endforeach; ?>

<div class="panel panel-success">
		<div class="panel-heading">
				<h4 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordions" href="#common">
	  Common Data</h4></a><p>(Drag-Drop these fields in table for parent record)</p>
				
				</h4>
		</div>
		<div id="common" class="panel-collapse collapse">
				<div class="panel-body">
				<?php
		echo $this->Html->link("seperator",'#seperator',array('class'=>'badge label-success add-margin'));
		echo $this->Html->link("date",'#date',array('class'=>'badge label-success add-margin'));
		echo $this->Html->link("number",'#numbers',array('class'=>'badge label-success add-margin'));
	?>
				</div>
		</div>
	</div>
	

<div class="panel panel-success">
		<div class="panel-heading">
				<h4 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordions" href="#legends">
	  Legends</h4></a><p>(Drag-Drop these fields in table for parent record)</p>
				
				</h4>
		</div>
		<div id="legends" class="panel-collapse collapse">
				<div class="panel-body">
				<p>
		<span class="badge label-default add-margin">Keys</span> = These are foreign fields. Values for these fields should be taken form the Related Tables
		<hr/>
		<span class="badge label-success add-margin">Keys</span> = These are regular non-database values. Like, to print current date of the repost drag-drop "date" or to print number counter (1,2,3,4..) drag & drop  "number" etc.
		</p>
				</div>
		</div>
	</div>
	
</div>
<?php // echo json_encode($form_details) ?>
<?php // echo json_encode($form_schema) ?>
<?php // echo json_encode($associated_forms) ?>
