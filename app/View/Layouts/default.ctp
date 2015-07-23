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
	       <?php echo $companyDetails['Company']['name'] ?>
       </title>
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
    <?php if ($this->Session->read('TANDC') != 1) { ?>
        <script>
    	$("document").ready(function() {
    	    $("#notification-center").load("<?php echo Router::url('/', true); ?>notification_users/display_notifications")
    	});
        </script>

    <?php } ?>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
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

    <?php echo $this->element('top-menu'); ?>
    <div class="container">

	<?php echo $this->fetch('content'); ?>

    </div>
    <div class="container">
	<div class="">
	    <div id="footer" class="footer">
		<?php echo $this->element('footer'); ?>
	    </div>
	</div>
    </div>
    
</body>
</html>
