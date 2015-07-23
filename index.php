<?php
/**
 * Requests collector.
 *
 *  This file collects requests if:
 * - no mod_rewrite is available or .htaccess files are not supported
 *  - requires App.baseUrl to be uncommented in app/Config/core.php
 * - app/webroot is not set as a document root.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c), Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 *  Get Cake's root directory
 */
$cakeDescription = 'FlinkISO ISO Made Easy!';
?>
<!DOCTYPE html>
<html>
    <head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<link href="app/webroot/css/layout.css" type="text/css" rel="stylesheet" />
	<link href="app/webroot/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="app/webroot/js/jquery.min.js"></script>
	<script type="text/javascript" src="app/webroot/js/jquery-form.min.js"></script>
	<script type="text/javascript" src="app/webroot/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="app/webroot/js/html5.js"></script>
	<script type="text/javascript" src="app/webroot/js/respond.min.js"></script>
	<title>
	    FlinkISO : Lite Version	    
	</title>
    </head>
    <body data-twttr-rendered="true">
		<div class="container">
	    	<div class="row" id="header">
				<div class="col-md-2">
		    		<img src="app/webroot/img/FlinkISO-Logo.png" id='app_logo'>
				</div>
				<div class="col-md-10">
		    		<h1 class="pull-right" style="margin-top:20px">Free Open Source QMS</h1>
				</div>
	    	</div>
		</div>
		<div class="container">
	    	<div class="nav panel panel-default">
				<div class="col-md-12">
		    		<div class="col-md-12">
						<h5><strong>Installation Progress</strong></h5>
						<div class="progress progress-striped active" style="background: #CCC">
			    			<div class="progress-bar"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 2%"></div>
						</div>
		    		</div>
		    		<div class="col-md-12">
		    			<h3>Welcome to FlinkISO <small>Lite</small></h3>
		    			<p>Developed on a cakePHP framework, FlinkISO Lite follows system requirements of cakePHP. For more details visit : <a href="http://book.cakephp.org/2.0/en/installation.html" target="_blank">http://book.cakephp.org/2.0/en/installation.html</a></p>
		    			<p><strong>Additinal FlinkISO requirments :</strong> 
		    				<ul>
		    					<li>License Key : You can get the license key from <a href="https://www.flinkiso.com/sign-in/register.html"  target="_blank">https://www.flinkiso.com/sign-in/register.html</a> after registration.</li>
		    					<li>Make sure that entire directory has a write permissions.</li>
		    					<li>SMTP server details for sending emails after installation.</li>
		    					<li>cURL installed and enabled.</li>
		    				</ul>		    			
		    			<p>		 
		    			<p class="text-center"><a href="install.php" class='btn btn-info btn-lg'>Start Installation</a></p>
		    			<p class="text-center"><small>For installation support, contact us : <a href="mailto:help@flinkiso.com">help@flinkiso.com</a>.</small></p>       		
			    		
			    	</div>
		    	</div>
			</div>
			<div class="row">
				<div class="col-md-12">					
					<div class="col-md-12 panel panel-default panel-body"><h2 class="text-center">What's included?</h2><table class="table table-responsive pricing-included"><tbody><tr><td><h3>Features & Models</h3></td><td align="center"><h3>FlinkISO <small>Lite</small></h3></td></tr><tr><td>Unlimited Users, Employees, Branches etc</td><td align="center"><span class="glyphicon glyphicon-ok text-success"></span></td></tr><tr><td>No Per user , Per seat cost or commercial licensing</td><td align="center"><span class="glyphicon glyphicon-ok text-success"></span></td></tr><tr><td>Cron Jobs, Schedule Tasks</td><td align="center"><span class="glyphicon glyphicon-ok text-success"></span></td></tr><tr><td>SMTP Setup</td><td align="center"><span class="glyphicon glyphicon-ok text-success"></span></td></tr><tr><td>Email Notification</td><td align="center"><span class="glyphicon glyphicon-ok text-success"></span></td></tr><tr><td>Internal Messaging</td><td align="center"><span class="glyphicon glyphicon-ok text-success"></span></td></tr><tr><td>Time Line</td><td align="center"><span class="glyphicon glyphicon-ok text-success"></span></td></tr><tr><td>Notifications</td><td align="center"><span class="glyphicon glyphicon-ok text-success"></span></td></tr><tr><td>Digital Signatures</td><td align="center"><span class="glyphicon glyphicon-remove text-danger"></span></td></tr><tr><td>Two Factor Authentication</td><td align="center"><span class="glyphicon glyphicon-remove text-danger"></span></td></tr><tr><td>Auto Approval Process</td><td align="center"><span class="glyphicon glyphicon-remove text-danger"></span></td></tr><tr><td>Email Triggers</td><td align="center"><span class="glyphicon glyphicon-remove text-danger"></span></td></tr><tr><td>Password Policy</td><td align="center"><span class="glyphicon glyphicon-remove text-danger"></span></td></tr><tr><td>Incident Reporting</td><td align="center"><span class="glyphicon glyphicon-remove text-danger"></span></td></tr><tr><td>Business Development beta</td><td align="center"><span class="glyphicon glyphicon-remove text-danger"></span></td></tr><tr><td>On Screen Search</td><td align="center"><span class="glyphicon glyphicon-remove text-danger"></span></td></tr><tr><td>Import Export</td><td align="center"><span class="glyphicon glyphicon-remove text-danger"></span></td></tr><tr><td>Set up assistance</td><td align="center"><span class="glyphicon glyphicon-remove text-danger"></span></td></tr><tr><td>Unrestricted Application with source code</td><td align="center"><span class="glyphicon glyphicon-ok text-success"></span></td></tr><tr><td>Export to Excel-PDF</td><td align="center"><span class="glyphicon glyphicon-remove text-danger"></span></td></tr><tr><td>Rich Text Editor</td><td align="center"><span class="glyphicon glyphicon-ok text-success"></span></td></tr></tbody></table></div>	
				</div>

			</div>	
	    	<div class="container">
			<div class="">
		    	<div id="footer" class="footer">
					<ul style="padding-left: 0px">
			    		<li><a href='https://www.flinkiso.com/'>About FlinkISO &trade;</a>
			    		<li><a href='https://www.flinkiso.com/terms-and-conditions.html'>Terms & Conditions</a>
			    		<li><a href='https://flinkiso.com/contact-us.html'>Contact us</a>
					</ul>
					<span id="disclaimer">
			    		<p>IN NO EVENT SHALL TECHMENTIS GLOBAL SERVICES PVT LTD. BE LIABLE TO ANY PARTY FOR DIRECT, INDIRECT, SPECIAL, INCIDENTAL, OR CONSEQUENTIAL DAMAGES, INCLUDING LOST PROFITS, ARISING OUT OF THE USE OF THIS SOFTWARE AND ITS DOCUMENTATION, EVEN IF TECHMENTIS GLOBAL SERVICES PVT LTD. HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
						<br /><br />TECHMENTIS GLOBAL SERVICES PVT LTD. SPECIFICALLY DISCLAIMS ANY WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE. THE SOFTWARE AND ACCOMPANYING DOCUMENTATION, IF ANY, PROVIDED HEREUNDER IS PROVIDED "AS IS". TECHMENTIS GLOBAL SERVICES PVT LTD. HAS NO OBLIGATION TO PROVIDE MAINTENANCE, SUPPORT, UPDATES, ENHANCEMENTS, OR MODIFICATIONS.</p>
			    		<img src="app/webroot/img/techmentis-logo-small.jpg" id='techmentis_logo'>copyright &copy; 2013 <br/> TECHMENTIS GLOBAL SERVICES PVT LTD.
			    	</span>
		    	</div>
			</div>
	    </div>
	</body>
</html>