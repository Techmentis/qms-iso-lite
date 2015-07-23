<?php echo $this->Html->script(array('jquery.validate.min','jquery-form.min', 'chosen.min'));?>
<?php echo $this->fetch('script');?>
<?php echo $this->Session->flash(); ?>

<script>
$.validator.setDefaults({
ignore: null,
errorPlacement: function(error, element) {
    if($(element).attr('name') == 'Message.to[]'){
	 $(element).next().after(error);
    }else{
	   $(element).after(error);
    }
},
submitHandler: function(form) {
$(form).ajaxSubmit({
url:"<?php echo Router::url('/', true);?><?php echo $this->request->params['controller']?>/add",
type:'POST',
beforeSend: function(){
                   $("#submit_id").prop("disabled",true);
                    $("#submit-indicator").show();
                },
        complete: function() {
                   $("#submit_id").removeAttr("disabled");
                   $("#submit-indicator").hide();
                },
//target: '#messages_ajax',
target: <?php if($controller){echo "'#ui-tabs-10'";} else {echo "'#messages_ajax'";}?>,
    error: function (request, status, error) {
        //alert(request.responseText);
	alert('Action failed!');
    }});}
});

$().ready(function() {

$(".chosen-select").chosen();
$("#submit-indicator").hide();
jQuery.validator.addMethod("greaterThanZero", function(value, element) {
    return this.optional(element) || (parseFloat(value) > 0);
}, "Please select the value");

$('#MessageAddForm').validate({
    rules: {
	"Message.to[]" : {
	    greaterThanZero:true,
	    required:true
	}
    }
});
    $('#Message.to').change(function () {
	if( $( this ).val()!=-1 && $(this).next().next('label').hasClass("error")){
	    $(this).next().next('label').remove();
	}
    });

});

</script>
<div class="nav">

	<?php
	echo $this->Form->create('Message',array('class'=>'form','width'=>'100%','role'=>'form','default'=>false)); ?>
	<table style="width:90%">
            <tr>
                <td>
                    <?php
                        echo $this->Form->input('Message.to',array('name'=>'Message.to[]','type' => 'select','class'=>'chzn-select', 'multiple','options' => $users,'label'=>__('Recepient'),'style'=>'width:100%'));
                        echo $this->Form->input('subject',array('class'=>'subject','div'=>false,'label'=>'Subject'));
                    ?>
                    <div style="clear:both; width:100%">
                        <?php
                            echo $this->Form->input('message',array('type' => 'textarea', 'escape' => false, 'class'=>'textEdit','div'=>false,'label'=>'Message', 'id'=>'message', 'style'=>''));
                        ?>
                    </div>
                    <?php
                            echo $this->Form->hidden('user_id',array('value'=>$this->Session->read('User.id')));
                            echo $this->Form->hidden('flag',array('value'=>'0'));
                            echo $this->Form->hidden('flag1',array('value'=>$controller));
                            echo $this->Form->hidden('priority',array('Label'=>'Priority', 'class'=>'checkbox inline'),array('options'=>array('High','Low')));
                    ?>
                    <?php if($controller == 'users'){
                            echo $this->Form->submit(__('Send'),array('div'=>false,'class'=>'btn btn-primary btn-success','update'=>'#ui-tabs-10','async' => 'false','id'=>'submit_id'));
                        }else{
                            echo $this->Form->submit(__('Send'),array('div'=>false,'class'=>'btn btn-primary btn-success','update'=>'#messages_ajax','async' => 'false','id'=>'submit_id')); 
                        }?>
            <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
              </td>
        </tr>

        </table>
</div>
<?php echo $this->Form->end(); ?>
<?php echo $this->Js->writeBuffer();?>