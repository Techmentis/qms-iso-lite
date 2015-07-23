<?php
/**
*
* PHP 5
*
* CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
* Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
*
* Licensed under The MIT License
* For full copyright and license information, please see the LICENSE.txt
* Redistributions of files must retain the above copyright notice.
*
* @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
* @link          http://cakephp.org CakePHP(tm) Project
* @package       app.View.Layouts
* @since         CakePHP(tm) v 0.10.0.1076
* @license       http://www.opensource.org/licenses/mit-license.php MIT License
*/

$cakeDescription = __d('FlinkISO', 'ISO Made Easy!');
?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

       <title>
	       FlinkISO :
	       <?php echo $cakeDescription ?>
	       <?php //echo $title_for_layout; ?>
       </title>
       <!-- <link href='http://fonts.googleapis.com/css?family=Gudea:400,700,400italic' rel='stylesheet' type='text/css'> -->
       <?php
       echo $this->Html->meta('icon');
       echo $this->Html->css(array('bootstrap.min',
				   'layout',
				   'signin.min',
				   'custom-theme/jquery-ui-1.9.2.custom',
				   'tooltip.min',
				   'jquery-ui-timepicker-addon.min',
				   'validation/screen',
				   'bootstrap-chosen.min',
				   'forms.min',
				   'jquery-ui.min'));
       echo $this->Html->script(array('jquery.min','bootstrap.min','jquery-ui.min','tooltip.min',
				      'jquery.validate.min','TimelineJS-master/compiled/js/storyjs-embed','timeout.min',
				      'chosen.min','jquery-ui-timepicker-addon','jquery-ui-sliderAccess'));

       echo $this->fetch('meta');
       echo $this->fetch('css');
       echo $this->fetch('script');
       ?>
    <!--[if lt IE 9]>
	<?php
	    echo $this->Html->script(array('html5', 'respond.min'));
	    echo $this->fetch('script');
	?>
    <![endif]-->

    <?php if ($this->Session->read('TANDC') != 1) { ?>
        <script>
    	$("document").ready(function() {
    	    $("#notification-center").load("<?php echo Router::url('/', true); ?>notification_users/display_notifications")
    	});
        </script>

    <?php } ?>
    <script>
    //$(document).idleTimeout({
    //       inactivity:1200000, //20mins
    //       noconfirm:10000, //10 secs
    //       sessionAlive: 1199000,
    //       click_reset:true,
    //       redirect_url:"<?php //echo Router::url('/', true); ?>/users/logout",
    //       alive_url:'<?php //echo $this->action  ?>',
    //       lefttime:0
    //})
    </script>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-47318094-3', 'auto');
  ga('send', 'pageview');

</script>
</head>

<body data-twttr-rendered="true">

    <div class="">
	<div class="row" id="header">
	    <div class="col-md-2">
		<?php echo $this->Html->link($this->Html->image('../img/FlinkISO-Logo.png', array('id' => 'app_logo', 'class' => 'img-responsive')), array('controller' => 'users', 'action' => 'dashboard'), array('escape' => false)); ?>
	    </div>
	    <div class="col-md-7 col-xs-12 pull-left">
		<div id="notification-center">
		    <?php if (isset($install) && $install != true) { ?>
			<?php echo $this->Html->image('../img/indicator.gif', array('id' => 'notification-indicator')); ?>
		    <?php } else { ?>
    		    <p class="text-danger"><strong>Welcome <?php echo $this->Session->read('User.name') ?></strong><br/>
    			Thank you for signing up.
    		    </p>
		    <?php } ?>
		</div></div>
	    <div class="col-md-3 ">
		<div id="login-info">
		    <b><?php if(isset($companyDetails))echo $companyDetails['Company']['name'] ?><br/><?php echo $this->Session->read('User.branch') ?>&nbsp;<?php echo __('Branch') ?></b>
		    <hr  style="margin:3px 0; height:1px;" size="1" noshade="noshade" color="#6ac9f1"/>
		    <?php echo __('Welcome'); ?> :
		    <?php echo $this->Session->read('User.username'); ?><br /><?php echo __('Last Login'); ?> : <?php echo $this->Time->format('j F, Y h:i A', ($this->Session->read('User.lastLogin'))); ?>

		    </br >
		    <?php echo $this->Html->link('Change password', array('controller' => 'users', 'action' => 'change_password'), array('class' => 'badge btn-info')); ?>
		    <?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout'), array('class' => 'badge btn btn-info')); ?>

		</div>
	    </div>
	</div>
    </div>
<br />
    <div class="container">

	<?php echo $this->fetch('content'); ?>

    </div>
    <div class="container">
	<div class="">
	    <div id="footer" class="footer">
		<?php echo $this->element('footer'); ?>
	    </div>
	</div>

	<?php // echo $this->element('sql_dump');  ?>
    </div>
<!-- <script type='text/javascript'>(function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://widget.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({ c: 'cfe342c1-7a68-4658-a9e3-936d2321a077', f: true }); done = true; } }; })();</script> -->
    
</body>
</html>
