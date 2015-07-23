<?php echo $this->Html->script(array('jquery.validate.min', 'jquery-form.min')); ?>
<?php echo $this->fetch('script');
 if(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&  $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')   $protocol = 'https://';
else
     $protocol = 'http://'; ?>
<script>
    $('document').ready(function() {
        $.ajax({
            type: 'GET',
            url: '<?php echo $protocol; ?>www.flinkiso.com/connection-test.php',
            data: {
                field: 'value'
            },
            dataType: 'jsonp',
            crossDomain: true,
            success: function(response) {
                if (response) {
                    $('#submit_liscence').prop('disabled', false);
                    $('#notconnected').hide();
                }
            },
            error: function(request, error)
            {
                $('#notconnected').show();
            }
        });
        $('#UserLoginForm').validate();
        $('#UserRegisterForm').validate();
        $('#LiscenceKeyRegisterForm').validate({
            rules: {
                "data[LiscenceKey][liscence_key]": {
                    required: true,
                }}});
        $('#users_ajax_new').hide();
        $('#submit_id').click(function() {
            if ($('#UserPassword').val() != $('#UserRepassword').val()) {
                alert("Password Mismatch");
                return false;
            } else {
                if ($('#UserRegisterForm').valid()) {
                    $("#submit_id").prop("disabled", true);
                    $("#submit-indicator_register").show();
                    $("#UserRegisterForm").submit();
                }
                else {
                    $("#submit_id").prop("disabled", false);
                    $("#submit-indicator_register").hide();
                }
            }
        });
        $('#skip_for_now').hide();
        $("#submit-indicator_register").hide();
        $("#submit-indicator").hide();
        $("#submit_liscence").click(function() {
            if ($("#LiscenceKeyRegisterForm").valid()) {
                $("#submit-indicator").show();
                $("#submit_liscence").prop("disabled", true);

                $.ajax({
                    type: 'POST',
                    url: '<?php echo $protocol; ?>www.flinkiso.com/checkLicenceKey.php',
                    data: {
                        liscence_key: $('#LiscenceKeyLiscenceKey').val(),
                    },
                    crossDomain: true,
                    timeout: 15000,
                    success: function(data) {

                        var userData = $.parseJSON(data);
                        $("#submit-indicator").hide();
                        $("#submit_liscence").prop("disabled", false);
                        if (data === 'null' || data === "" || userData.length === 0) {
                            $('#LiscenceKeyLiscenceKey').val('');
                            $('#LiscenceKeyLiscenceKey').addClass('error');
                            $('#getLiscence').text('You have entered an invalid Licence key').show();
                            $('#users_ajax_new').hide();
                            $('#liscence_form').show();

                        } else {
                            var userData = $.parseJSON(data);

                            $('#getLiscence').hide();
                            $('#LiscenceKeyLiscenceKey').removeClass('error');
                            $('#UserName').val(userData['name']);
                            $('#UserCompany').val(userData['company']);
                            $('#UserEmail').val(userData['email']);
                            $('#checkemail').load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/check_email/' + $('#UserEmail').val(), function(response, status, xhr) {
                                if (response !== '') {
                                    $('#UserEmail').val('');
                                    $('#UserEmail').addClass('error');
                                }
                            });
                            $('#UserPhone').val(userData['phone']);
                            $("input[id='UserCity']").val(userData['city']);
                            $("input[id='UserCountry']").val(userData['country']);
                            $("input[id='UserZip']").val(userData['zip']);
                            $("input[id='UserLiscenceKeyInstalled']").val(userData['download_key']);
                            $('#users_ajax_new').show();
                            $('#liscence_form').hide();
                        }
                    },
                    error: function(request, error)
                    {
                        $("#submit-indicator").hide();
                        $("#submit_liscence").prop("disabled", false);
                        if (error == "timeout") {
                            $('#skip_for_now').show();
                        }
                        $('#skip_for_now').click(function() {
                            $('#liscence_form').hide();
                            $('#users_ajax_new').show();
                            var liscence_key = $('#LiscenceKeyLiscenceKey').val();
                            $("input[id='UserLiscenceKeyInstalled']").val(liscence_key);
                        });
                    }
                });
            }
        });
        $("#LiscenceKeyLiscenceKey").focus(function() {
            $('#getLiscence').hide();
        });
    });
</script>

<?php
// $location = file_get_contents('http://freegeoip.net/json');
// $location = json_decode($location,true);
?>
<?php echo $this->Session->flash(); ?>
<script>
    $(document).ready(function() {
        $('#UserEmail').change(function() {
            $('#checkemail').load('<?php echo Router::url('/', true); ?><?php echo $this->request->params['controller'] ?>/check_email/' + $('#UserEmail').val(), function(response, status, xhr) {
                if (response !== '') {
                    $('#checkemail').show();
                    $('#UserEmail').val('');
                    $('#UserEmail').addClass('error');
                } else {
                    $('#UserEmail').removeClass('error');
                    $('#checkemail').hide();
                }
            });
        });
    });
</script>
<div id="users_ajax">
    <div class="panel">
	<div class="nav">
	    <div class="col-md-12">
		<h5><strong>Installation Progress</strong></h5>
		<div class="progress progress-striped active" style="background: #CCC">
		    <div class="progress-bar"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
		    </div>
		</div>
	    </div>
	    <div class="col-md-8">
		<div class="nav">
		    <div class="panel panel-default">
			<div class="panel-heading">
			    <div class="panel-title">
				<h3 style="margin-top:10px">Register your copy of free FlinkISO&trade;</h3>
			    </div>
			    <p>This software is provided to you for free by <a href="http://www.techmentis.biz" target="_blank">Techmentis</a>. In order to serve our customers, we will require their correct credentials. Once you register your copy with your license key, it will be easier for us to provide support & other help.</p>
			</div>
                        <div class="panel-body">
                            <div id ="notconnected">
                                <div class="alert alert-danger">
                                    No Internet Connection.
                                </div>
                            </div>
			    <div id ="liscence_form">

				<?php echo $this->Form->create('LiscenceKey', array('role' => 'form', 'class' => 'form no-margin no-padding')); ?>
				<div class="col-md-6">


				    <?php echo $this->Form->input('liscence_key', array('placeholder' => 'enter license key', 'label' => 'License Key'));
				    ?>
				    <label id="getLiscence" class="error" style="clear:both" ></label>
				</div>
				<div class="col-md-6">
				    <?php echo $this->Form->button('Submit License Key', array('label' => false, 'type' => 'button', 'id' => 'submit_liscence', 'class' => 'btn btn-success', 'disabled' => true, 'style' => 'margin-top:25px;'));?>
				    <?php echo $this->Form->button('Skip for now', array('label' => false, 'type' => 'button', 'id' => 'skip_for_now', 'class' => 'btn btn-link', 'style' => 'margin-top:25px;'));?>

				    <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator')); ?>
				</div>
				<div class="col-md-12">
				    <p>License Key is sent to you on your email address while you registered with us on our website. Copy & Paste that license key in the text field abobe and click "Submit License Key" button.</p>
				    <p>System will then validate your copy of FlinkISO&trade; and you will enjoy full benefits of the registered users.</p>
				    <p>Please Note :  Once you register & install this on your server, you will not have to install this same application to any of your user's machine. You can directly send them a link to your server & they can access the application. Make sure you create users once you are in.</p>
				</div>
				<?php if ($response != 0) { ?>
    				<div class="clearfix">&nbsp;</div><hr />
    				<h3>Why does FlinkISO needs Internet Connection?</h3>
    				FlinkISO will always require internet connection for following reasons :
    				<ul>
    				    <li>Registration of your copy of FlinkISO. After your copy is registered, you will get an email with your user id & password. You can use this information to login to our online forums & communities for free help.</li>
    				    <li>Viewing of google charts which is integral part of your application which requires internet connection</li>
    				    <li>Sending email notifications to your users regarding meetings, audits etc</li>
    				</ul>

				<?php } ?>
				<?php echo $this->Form->end(); ?>
                            </div>
                            <div class="col-md-12">
                                <div id="checkemail">

                                </div>
                            </div>
                            <div id="users_ajax_new" style="display: none;">
				<?php echo $this->Form->create('User', array('role' => 'form', 'class' => 'form no-margin no-padding')); ?>
				<div class="col-md-6"><?php echo $this->Form->input('name', array('placeholder' => 'Please enter your name')); ?></div>
				<div class="col-md-6"><?php echo $this->Form->input('company', array('placeholder' => 'Please enter your company name')); ?></div>
				<div class="col-md-6"><?php echo $this->Form->input('email', array('placeholder' => 'Please enter your valid email', 'label' => 'Your email address will be your username')); ?></div>
				<div class="col-md-6"><?php echo $this->Form->input('phone', array('placeholder' => 'Please enter your phone')); ?></div>
				<div class="col-md-6"><?php echo $this->Form->input('password', array('label' => __('Password'))); ?></div>
				<div class="col-md-6"><?php echo $this->Form->input('repassword', array('type' => 'password', 'label' => __('Re-type Password'))); ?></div>
				<div class="col-md-12 help">Please enter a new password which you would like to use to access FlinkISO&trade;</div>
				<div class="col-md-12 hide"><?php echo $this->Form->input('sample_data', array('value' => 0, 'label' => __('Install Sample Data'))); ?></div>
				<?php echo $this->Form->hidden('liscence_key_installed', array('placeholder' => 'enter licsence key', 'label' => false)); ?>
				<?php echo $this->Form->hidden('city', array('placeholder' => 'Please enter your city')); ?>
				<?php echo $this->Form->hidden('state', array('placeholder' => 'Please enter your state')); ?>
				<?php echo $this->Form->hidden('country', array('placeholder' => 'Please enter your country')); ?>
				<?php echo $this->Form->hidden('zip', array('placeholder' => 'Please enter pincode / zipcode')); ?>
                                <br />&nbsp;
                                <br />&nbsp;
                                <br />

				<div class="col-md-6">
				    <?php echo $this->Form->submit(__('Create My Free Account Now!'), array('div' => false, 'class' => 'btn btn-lg btn-success', 'update' => '#users_ajax', 'async' => 'false', 'id' => 'submit_id')); ?>
				    <?php echo $this->Html->image('indicator.gif', array('id' => 'submit-indicator_register')); ?>
				</div>
				<?php echo $this->Form->end(); ?>
                            </div>

			    <div class="col-md-12">
				<br /><br /><span id="siteseal" style="margin-top:20px"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=xf1CnWvbgitNP5hRlt9jx4GR7bvuKfEGP6Drm6IxMnpT3hd4u0j9J"></script>
				    Data transmitted to FlinkISO&trade; is secure & encrypted with <u>256-bit Secure Sockets Layer encryption.</u><br /></span>
			    </div>
			    <div class="nav">
				<div class="col-md-12">
				</div>
			    </div>
			</div>

		    </div>
		</div>

	    </div>
	    <div class="col-md-4">
		<div class="panel panel-default panel-body">
		    <h3 class="text-info"  style="margin-top:10px">What's in this version?</h3>
		    <ul style="font-size: 13px; font-weight: 700; color: #444; line-height: 25px; padding-left: 12px">
			<li>Entire application without restrictions</li>
			<li>You can add/delete data</li>
			<li>You can upload files</li>
			<li>Your data will not be visible to others</li>
			<li>Import &amp; Export data in Excel Sheets</li>
			<li>Create users, branches, employees etc</li>
			<li>CAPA, Internal Audits, HR</li>
			<li>Manage Supplier Evaluations</li>
			<li>Manage Customer Complaints</li>
			<li>Contact us for any customization</li>
			<li>Access our forums & help sections</li>
		    </ul>
		</div>
		<div class="alert alert-info hide">
		    <h3><?php echo $this->Html->link('Existing User Login', array('action' => 'login')) ?></h3>
		</div>

	    </div>
	</div>
    </div>
</div>

<script>$.ajaxSetup({beforeSend:function(){$("#busy-indicator").show();},complete:function(){$("#busy-indicator").hide();}});</script>