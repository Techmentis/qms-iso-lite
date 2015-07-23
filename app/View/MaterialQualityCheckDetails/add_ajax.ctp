<?php echo $this->Html->script(array('jquery.validate.min','jquery-form.min'));?>
<?php echo $this->fetch('script');?>

<script>
$.validator.setDefaults({
submitHandler: function(form) {
$(form).ajaxSubmit({
url:'<?php echo Router::url('/', true);?><?php echo $this->request->params['controller']?>/add_ajax',
type:'POST',
target: '#main',
	error: function (request, status, error) {
        alert(request.responseText);
    }});}
});
</script>

<div id="materialQualityCheckDetails_ajax">
<?php echo $this->Session->flash();?>
<div class="nav">
<div class="materialQualityCheckDetails form col-md-8">
<h4><?php echo __('Add Material Quality Check Detail'); ?></h4>
<?php echo $this->Form->create('MaterialQualityCheckDetail',array('role'=>'form','class'=>'form','default'=>false)); ?>
<div class="row">
			<div class="col-md-6"><?php echo $this->Form->input('material_quality_check'); ?></div> 
	<div class="col-md-6"><?php echo $this->Form->input('employee_id'); ?></div> 
	<div class="col-md-6"><?php echo $this->Form->input('check_performed_date'); ?></div> 
	<div class="col-md-6"><?php echo $this->Form->input('quantity_received'); ?></div> 
	<div class="col-md-6"><?php echo $this->Form->input('quantity_accepted'); ?></div> 
			<?php echo $this->Form->input('branchid',array('type'=>'hidden','value'=>$this->Session->read('User.branch_id')));?>
		<?php echo $this->Form->input('departmentid',array('type'=>'hidden','value'=>$this->Session->read('User.department_id')));?>
		<?php echo $this->Form->input('master_list_of_format_id',array('type'=>'hidden','value'=>$document_details['MasterListOfFormat']['id']));?>
	
</div>
	<?php if($show_approvals && $show_approvals['show_panel'] == true ) { ?>
		<?php echo $this->element('approval_form'); ?>
    	</div> <?php } else {
	    echo $this->Form->input('publish', array('label' => __('Publish')));
	}
 ?>
<?php echo $this->Form->submit('Submit',array('div'=>false,'class'=>'btn btn-primary btn-success','update'=>'#materialQualityCheckDetails_ajax','async' => 'false')); ?>
<?php echo $this->Form->end(); ?>
<?php echo $this->Js->writeBuffer();?>
	
</div>
<div class="col-md-4">
	<p><?php echo $this->element('helps'); ?></p>
</div>
</div>
<script>$.ajaxSetup({beforeSend: function() {
	    $("#busy-indicator").show();
	}, complete: function() {
	    $("#busy-indicator").hide();
	}});</script>