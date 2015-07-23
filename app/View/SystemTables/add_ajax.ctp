<?php echo $this->Html->script(array('jquery.validate.min','jquery-form.min'));?>
<?php echo $this->fetch('script');?>

<script>
    $.validator.setDefaults({
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                url:"<?php echo Router::url('/', true);?><?php echo $this->request->params['controller']?>/add_ajax",
                type:'POST',
                target: '#main',
                beforeSend: function(){
                    $("#submit_id").prop("disabled",true);
                    $("#submit-indicator").show();
                },
                complete: function() {
                    $("#submit_id").removeAttr("disabled");
                    $("#submit-indicator").hide();
                },
            });
        }
    });

    $().ready(function() {
        $("#submit-indicator").hide();
        $('#SystemTableAddAjaxForm').validate();
    });
</script>

<div id="systemTables_ajax">
<?php echo $this->Session->flash();?><div class="nav">
<div class="systemTables form col-md-8">
    <h4><?php __('Add System Table'); ?></h4>
    <?php echo $this->Form->create('SystemTable',array('role'=>'form','class'=>'form','default'=>false)); ?>
    <fieldset>
	<?php
	    echo $this->Form->input('name');
	    echo $this->Form->input('system_name');
	    echo $this->Form->input('evidence_required');
	    echo $this->Form->input('approvals_required');
	    echo $this->Form->input('branchid',array('type'=>'hidden','value'=>$this->Session->read('User.branch_id')));
	    echo $this->Form->input('departmentid',array('type'=>'hidden','value'=>$this->Session->read('User.department_id')));
	    echo $this->Form->input('master_list_of_format_id',array('type'=>'hidden','value'=>$documentDetails['MasterListOfFormat']['id']));
	?>
	<?php if($showApprovals && $showApprovals['show_panel'] == true ) { ?>
	<?php echo $this->element('approval_form'); ?>
	<?php } else {echo $this->Form->input('publish', array('label'=> __('Publish'))); } ?>
	<?php echo $this->Form->submit(__('Submit'),array('div'=>false,'class'=>'btn btn-primary btn-success','update'=>'#systemTables_ajax','async' => 'false','id'=>'submit_id')); ?>
        <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?><?php echo $this->Form->end(); ?>
	<?php echo $this->Js->writeBuffer();?>
    </fieldset>
</div>
<script> $("[name*='date']").datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat:'yy-mm-dd',
    }); </script>
<div class="col-md-4">
	<p><?php echo $this->element('helps'); ?></p>
</div>
</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>