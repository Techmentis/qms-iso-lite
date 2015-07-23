<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script'); ?>
<script>
      $().ready(function() {
    $("#submit-indicator-customize").hide();
    $("[name*='customize_form']").submit(function(){
      
          $("[name*='customize_form']").ajaxSubmit({
                url: "<?php echo Router::url('/', true) . $this->request->params['controller'] .'/send_customise'; ?>",
                type: 'POST',
                target: '#cust',
                beforeSend: function(){
                    
                    $("#submit_id").prop("disabled",true);
                    $("#submit-indicator-customize").show();
                },
                complete: function() {
                   $("#submit_id").removeAttr("disabled");
                   $("#submit-indicator-customize").hide();
                },
                error: function(request, status, error) {
                    //alert(request.responseText);
                    alert('Action failed!');
                }
	    });
    });
    });
</script>

<div class="panel panel-warning">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#custom">
                    <?php echo __('Would you like to customize this?'); ?>
                </a>
                <span class="glyphicon glyphicon-cog pull-right"></span>
            </h4>
        </div>
        <div id="custom" class="panel-collapse collapse">
            <div class="panel-body" id="cust">
                <h4>Fill this form<small> and we will get back to you shortly with customization quote</small></h4>
                <?php
                    echo $this->Form->create('customize', array('role' => 'form', 'class' => 'form', 'default' => false,'name'=>'customize_form')); 

                    echo $this->Form->input('customization_title',array('label'=>false,'placeholder'=>'Add Customization Title here','required'=>'required'));
                    echo $this->Form->hidden('company',array('value'=>$companyDetails['Company']['name']));
                    echo $this->Form->hidden('branch_name',array('value'=>$this->Session->read('User.branch')));
                    echo $this->Form->hidden('employee',array('value'=>$this->Session->read('User.username')));
                    echo $this->Form->hidden('request_for',array('value'=>$this->request->url));
                    echo $this->Form->input('customization_details',array('type'=>'textarea','label'=>false,'placeholder'=>'Add customization details here','required'=>'required'));
                    echo $this->Form->submit('Submit', array('div' => false, 'class' => 'btn btn-primary btn-success', 'update' => '#cust', 'async' => 'false','id'=>'submit_id'));
                    echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator-customize'));
                    echo $this->Form->end();
                ?>
              <?php echo $this->Js->writeBuffer(); ?>  
            </div>
        </div>
    </div>
