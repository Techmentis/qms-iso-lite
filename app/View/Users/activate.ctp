<?php echo $this->Html->script(array('jquery.validate.min','jquery-form.min'));?>
<?php echo $this->fetch('script');?>

<script>
$(document).ready(function(){
			   
var request = $.ajax({
type: "POST",
url: "http://www.flinkiso.com/user_registration.php",
            data: {
                name: "<?php echo urlencode($user['User']['name']); ?>",
                username: "<?php echo urlencode($user['User']['username']); ?>",
     password : "<?php echo urlencode($user['User']['password']); ?>",
     email : "<?php echo urlencode($user['User']['username']);?>"
 },
 dataType: "html"
});
request.done(function( msg ) {
alert(msg);
});

//var posting = $.post( "https://www.flinkiso.com/user_registration.php", { "name": "<?php echo urlencode($user['User']['name']); ?>", "username" :"<?php echo urlencode($user['User']['username']); ?>",
//     "password" : "<?php echo urlencode($user['User']['password']); ?>",
//     "email" : "<?php echo urlencode($user['User']['username']);?>"
// }, function(data){
//			   $( "#login" ).prop( "disabled", false );
//			   
//			   });
//

});
</script>
<div id="approvals_ajax">
<?php echo $this->Session->flash();?><div class="nav">
<div class="approvals form col-md-8">
			   
			   <h2>Click here to login into application</h2>
			    <?php echo $this->Html->link('Login', array('controller' => 'users', 'action' => 'login',1), array('class'=>'btn btn-success', 'disabled'=>'disabled','id'=>'login')); ?>
</div>
    </div>
</div>
