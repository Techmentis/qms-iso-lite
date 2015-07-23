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
    submitHandler: function(form) {
	$(form).ajaxSubmit({
	url:"<?php echo Router::url('/', true);?><?php echo $this->request->params['controller']?>/add_ajax",
	type:'POST',
	target: '#customTemplates_ajax',
	beforeSend: function(){
			   $("#submit_id").prop("disabled",true);
			    $("#submit-indicator").show();
			},
		complete: function() {
			   $("#submit_id").removeAttr("disabled");
			   $("#submit-indicator").hide();
			},
	    error: function (request, status, error) {
		//alert(request.responseText);
		alert('Action failed!');
	    }
	});
    }
});

$().ready(function() {
    $("#submit-indicator").hide();
    jQuery.validator.addMethod("greaterThanZero", function(value, element) {
	return this.optional(element) || (parseFloat(value) > 0);
    }, "Please select the value");

    $('#CustomTemplateAddAjaxForm').validate({
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

<div class="nav">
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
<p>Select Header Template</p>
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
		<p>Select the template from above</p>

	</textarea>
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
        <textarea rows=4 name="data[CustomTemplate][footer]" id="template-footer"  style="float:left; clear:both; margin: 20px 0"></textarea>
      </div>
    </div>
  </div>
</div>
		<?php
		echo  $this->Form->input('description',array('div'=>false));
		echo $this->Form->hidden('details',array('value'=>'NIL'));
		echo $this->Form->input('branchid',array('type'=>'hidden','value'=>$this->Session->read('User.branch_id')));
		echo $this->Form->input('departmentid',array('type'=>'hidden','value'=>$this->Session->read('User.department_id')));
	?>
	<?php if($showApprovals && $showApprovals['show_panel'] == true ) { ?>
		<div class="clearfix">&nbsp;</div>
				<div class="panel panel-default">
				<div class="panel-heading"><h3 class="panel-title">
				<?php echo __("Send for approval") ?></h3></div>
				<div class="panel-body"><?php echo __("Records added to this table will be send to the person you choose from the list below.")?>
			<?php echo $this->Form->input('Approval.user_id',array('options'=>$userids));?>
			<?php echo $this->Form->input('Approval.comments',array('type'=>'textarea'));?>
		<?php if($showApprovals['show_publish'] == true)echo $this->Form->input('publish',array('label'=>'Do not send forward. Publish Now')) ?>
	</div> <?php } else {echo $this->Form->input('publish', array('label'=> __('Publish'))); }
 ?>

<?php echo $this->Form->submit(__('Submit'),array('div'=>false,'class'=>'btn btn-primary btn-success','id'=>'submit_id')); ?>
<?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
<?php echo $this->Form->end(); ?>
<?php echo $this->Js->writeBuffer();?>
	</fieldset>
</div>
<div class="col-md-4">
	<p><?php echo $this->element('helps'); ?></p>
	<div id="get_table_fields_div"></div>
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