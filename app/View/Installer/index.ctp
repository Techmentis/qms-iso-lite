<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>
<script>
    $.validator.setDefaults();
    $().ready(function() {
	$('#InstallerIndexForm').validate();
	$("#submit-indicator").hide();
	$("#submit_id").click(function() {
	    if ($('#InstallerIndexForm').valid()) {
		$("#submit_id").prop("disabled", true);
		$("#submit-indicator").show();
		$("#InstallerIndexForm").submit();
	    }
	});
    });
</script>

<div id="installation_ajax">

    <div class="nav panel panel-default">
	<?php echo $this->Session->flash(); ?>
	<div class="col-md-12">
	    <h5><strong>Installation Progress</strong></h5>
	    <div class="progress progress-striped active" style="background: #CCC">
		<div class="progress-bar"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 33.33%">
		</div>
	    </div>
	</div>

        <div class="installations form col-md-8">
	    <h2>Database Configuration</h2>
	    <?php echo $this->Form->create('Installer', array('role' => 'form', 'class' => 'form')); ?>

	    <div class="row">
		<div class="col-md-6"><?php echo $this->Form->input('datasource', array('style' => 'width:100%', 'type' => 'hidden', 'value' => 'Database/Mysql')); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('persistent', array('style' => 'width:100%', 'type' => 'hidden', 'value' => 'false')); ?></div>
	    </div>
	    <div class="row">
		<div class="col-md-6"><?php echo $this->Form->input('host', array('style' => 'width:100%', 'label' => __('Host Name'), 'required' => 'required', 'value' => 'localhost')); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('database', array('style' => 'width:100%', 'label' => __('Database Name'), 'required' => 'required', 'value' => 'flinkiso')); ?></div>
	    </div>
	    <div class="row">
		<div class="col-md-6"><?php echo $this->Form->input('login', array('style' => 'width:100%', 'label' => __('Database User'), 'required' => 'required', 'value' => 'root')); ?></div>
		<div class="col-md-6"><?php echo $this->Form->input('password', array('style' => 'width:100%', 'label' => __('Database Password'))); ?></div>
	    </div>
	    <div class="row">
		<div class="col-md-6"><?php echo $this->Form->input('prefix', array('style' => 'width:100%', 'label' => __('Prefix'))); ?></div>

	    </div>
	    <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'class' => 'btn btn-primary btn-success', 'id' => 'submit_id')); ?>
	    <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
	    <?php echo $this->Form->end(); ?>
	    <?php echo $this->Js->writeBuffer(); ?>
        </div>
        <div class="col-md-4">
            <p><?php echo $this->element('helps'); ?></p>
        </div>
    </div>
</div>
<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>