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
<html>
    <head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>
	    FlinkISO-Lite: Free Open Source QMS
	</title>
	<?php
	echo $this->Html->meta('icon');
	echo $this->Html->css(array('bootstrap.min', 'bootstrap-responsive.min', 'bootstrap-theme.min', 'layout', 'signin.min', 'custom-theme/jquery-ui-1.9.2.custom', 'tooltip.min', 'validation/screen'));
	echo $this->Html->script(array('jquery.min', 'bootstrap.min', 'jquery-ui.min', 'tooltip.min', 'jquery.validate.min'));
	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
	?>
	<!--<noscript>
	    <meta http-equiv="refresh" content="0; URL=https://flinkiso.com/system_requirement.html">
	</noscript>-->
	<script>$(".alert").alert();</script>
    </head>
    <body data-twttr-rendered="true">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	<div class="nav">
	    <div class="row" id="header">
		<div class="col-md-3">
		    <?php echo $this->Html->link($this->Html->image('../img/FlinkISO-Logo.png', array('id' => 'app_logo')), array('controller' => 'users', 'action' => 'login'), array('escape' => false)); ?>
		</div>
		<div class="col-md-6 visible-lg pull-left">
		    <div id="notification-center">
		    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		    <!-- notifications-ads -->
		    <ins class="adsbygoogle"
			 style="display:inline-block;width:320px;height:50px"
			 data-ad-client="ca-pub-2922039071440353"
			 data-ad-slot="7868701425"></ins>
		    <script>
		    (adsbygoogle = window.adsbygoogle || []).push({});
		    </script>
		    </div>
		</div>
		<div class="col-md-3">
		    
		</div>
	    </div>
	</div>
	<div class="container">
	    <?php echo $this->fetch('content'); ?>
	</div>
	<div class="container">
	    <div class="">
		<div id="footer" class="footer">
		    <?php echo $this->element('login-footer'); ?>
		</div>
	    </div>
	</div>	
    </body>
</html>
