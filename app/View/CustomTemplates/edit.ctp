<script>
function get_fields($n,$text) {
	//$("#collapse-One").load("<?php echo Router::url('/', true);?>custom_templates/add_ajax/" + $n.value +"/" + $text );
	$( "#get_table_fields_div" ).load( "<?php echo Router::url('/', true);?>custom_templates/get_fields/" + $n.value );

}
</script>

<div id="customTemplates_ajax">
<?php echo $this->Session->flash();?>
<?php echo $this->Html->script(array('jquery.validate.min','jquery-form.min'));?>
<?php echo $this->fetch('script');?>

<script>
$.validator.setDefaults({
ignore: null,
errorPlacement: function(error, element) {
    if(  $(element).attr('name') == 'data[CustomTemplate][master_list_of_format_id]'){
	 $(element).next().after(error);
    } else if($(element).attr('name') == 'data[CustomTemplate][schedule_id]'){
	 $(element).next().after(error);
    }else{
	   $(element).after(error);
    }
},
});

$().ready(function() {
    $("#submit-indicator").hide();
    $("#submit_id").click(function(){
             if($('#CustomTemplateEditForm').valid()){
                 $("#submit_id").prop("disabled",true);
                 $("#submit-indicator").show();
                 $("#CustomTemplateEditForm").submit();
             }

        });
jQuery.validator.addMethod("greaterThanZero", function(value, element) {
    return this.optional(element) || (parseFloat(value) > 0);
}, "Please select the value");

$('#CustomTemplateEditForm').validate({
    rules: {
	"data[CustomTemplate][master_list_of_format_id]" : {
	    greaterThanZero:true,
	},
	"data[CustomTemplate][schedule_id]" : {
	    greaterThanZero:true,
	},
    }
});
    $('#CustomTemplateMasterListOfFormatId').change(function () {
	if( $( this ).val()!=-1 && $(this).next().next('label').hasClass("error")){
	    $(this).next().next('label').remove();
	}
    });
    $('#CustomTemplateScheduleId').change(function () {
	if( $( this ).val()!=-1 && $(this).next().next('label').hasClass("error")){
	    $(this).next().next('label').remove();
	}
    });

    });
</script>

<div class="nav panel panel-default">
<div class="customTemplates form col-md-8 panel">
<?php echo $this->Form->create('CustomTemplate',array('role'=>'form','class'=>'form')); ?>
<fieldset>
	<div class="row">
	<div class="col-md-12"><?php echo $this->Form->input('name',array('div'=>false)); ?></div>
	<div class="col-md-6"><?php echo $this->Form->input('master_list_of_format_id',array('onChange'=>'get_fields(this)')); ?></div>
	<div class="col-md-3"><?php echo $this->Form->input('schedule_id',array('options'=>$schedules)); ?></div>
	<div class="col-md-3"><?php echo $this->Form->input('report_type',array('options'=>array('Single Record','Multiple Records'))); ?></div>
	</div>
<script>
  $(function() {
    $( "#form-accordion" ).accordion({
      collapsible: true
    });
  });
  </script>
<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-One">
	  Header
	</a>
      </h4><span> (Header your would like to print)</span>
    </div>
    <div id="collapse-One" class="panel-collapse collapse in">
      <div class="panel-body">
	<textarea name="data[CustomTemplate][header]" id="template-header"  style="float:left; clear:both; margin: 20px 0">
<?php  echo $this->data['CustomTemplate']['header']; ?>
	</textarea>
      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-Two">
	  Records
	</a>
      </h4><span> (Actual form and it's details)</span>
    </div>
    <div id="collapse-Two" class="panel-collapse collapse">
      <div class="panel-body">
	<textarea  name="data[CustomTemplate][template_body]" id="template"  style="float:left; clear:both; margin: 20px 0">
<?php echo $this->data['CustomTemplate']['template_body']; ?>	</textarea>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-Three">
	  Footer
	</a>
      </h4><span> (Footer of your report)</span>
    </div>
    <div id="collapse-Three" class="panel-collapse collapse">
      <div class="panel-body">
	<textarea rows=4 name="data[CustomTemplate][footer]" id="template-footer"  style="float:left; clear:both; margin: 20px 0">
<?php // echo $this->data['CustomTemplate']['footer']; ?>
	</textarea>
      </div>
    </div>
  </div>
</div>
	<?php
		echo $this->Form->hidden('details',array('value'=>'NIL'));


	?>

	<?php if($showApprovals && $showApprovals['show_panel'] == true ) { ?>
	<?php echo $this->element('approval_form'); ?>
	<?php } else {echo $this->Form->input('publish', array('label'=> __('Publish'))); } ?>
	<?php echo $this->Form->submit(__('Submit'),array('div'=>false,'class'=>'btn btn-primary btn-success','id'=>'submit_id')); ?>
	<?php echo $this->Form->end(); ?>
	<?php echo $this->Js->writeBuffer();?>
</fieldset>
</div>
<div class="col-md-4">
	<p><?php echo $this->element('helps'); ?></p>
	<div id="get_table_fields_div">
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
<div class="panel panel-default">
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


<div class="panel panel-default">
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
</div>
	</div>
</div>
</div>
<?php echo $this->Html->script(array('ckeditor/ckeditor'));?>
<script type="text/javascript">
	CKEDITOR.replace( 'template-header',{toolbar: [
		[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'],
		{ name: 'insert', items: [ 'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak'] },
		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		{ name: 'document', items: [ 'Preview', '-', 'Templates' ] },
		'/',
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
		{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] },
		{ name: 'styles', items: [ 'Format', 'FontSize' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },


	]
});

CKEDITOR.replace( 'template',{toolbar: [
		[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'],
		{ name: 'insert', items: [ 'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak'] },
		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		{ name: 'document', items: [ 'Preview', '-', 'Templates' ] },
		'/',
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
		{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] },
		{ name: 'styles', items: [ 'Format', 'FontSize' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },


	]});

CKEDITOR.replace( 'template-footer',{toolbar: [
		[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'],
		{ name: 'insert', items: [ 'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak'] },
		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		{ name: 'document', items: [ 'Preview', '-', 'Templates' ] },
		'/',
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
		{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] },
		{ name: 'styles', items: [ 'Format', 'FontSize' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },


	]

});
</script>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>