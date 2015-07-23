<?php echo $this->Html->script(array('jquery.validate.min','jquery-form.min'));?>
<?php echo $this->fetch('script');?>

<script>
$.validator.setDefaults({
submitHandler: function(form) {
$(form).ajaxSubmit({
url:'../internetUsageDetails/add_ajax',
type:'POST',
target: '#internetUsageDetails_ajax'});}
});

$().ready(function() {
$('#InternetUsageDetailAddAjaxForm').validate();});
</script>

<div id="internetUsageDetails_ajax">
<?php echo $this->Session->flash();?><div class="nav">
<div class="internetUsageDetails form col-md-8">
<h4><?php echo __('Add Internet Usage Detail'); ?></h4>
<?php echo $this->Form->create('InternetUsageDetail',array('role'=>'form','class'=>'form','default'=>false)); ?>

    <div class="row">
	<div class="col-md-6"><?php echo $this->Form->input('internet_provider_name'); ?></div>
	<div class="col-md-6"><?php echo $this->Form->input('plan_details'); ?></div>
	<div class="col-md-6"><?php echo $this->Form->input('from_date'); ?></div>
	<div class="col-md-6"><?php echo $this->Form->input('to_date'); ?></div>
	<div class="col-md-6"><?php echo $this->Form->input('download'); ?></div>
	<?php echo $this->Form->input('branchid',array('type'=>'hidden','value'=>$this->Session->read('User.branch_id'))); ?>
	<?php echo $this->Form->input('departmentid',array('type'=>'hidden','value'=>$this->Session->read('User.department_id'))); ?>
	<?php echo $this->Form->input('master_list_of_format_id',array('type'=>'hidden','value'=>$documentDetails['MasterListOfFormat']['id'])); ?>
    </div>

    <?php if($showApprovals && $showApprovals['show_panel'] == true ) { ?>
    <?php echo $this->element('approval_form'); ?>
    <?php } else {echo $this->Form->input('publish', array('label'=> __('Publish'))); } ?>
    <?php echo $this->Form->submit(__('Submit'),array('div'=>false,'class'=>'btn btn-primary btn-success','update'=>'#internetUsageDetails_ajax','async' => 'false')); ?>
    <?php echo $this->Form->end(); ?>
    <?php echo $this->Js->writeBuffer();?>

</div>
<script> $("[name*='date']").datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat:'yy-mm-dd',
    }); </script>
<div class="col-md-4">
	<p><?php echo $this->element('helps'); ?></p>
</div>
</div></div></div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>