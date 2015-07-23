<?php echo $message = "
<style>
body {
	font-family: Arial;
	font-size: 13px;
	padding: 20px 10px;
	width: 780px;
	line-height: 20px;
	background: #cdcdcd;
}

label{ }

</style> 
<html>
<body>
<div style=\"background:#555555 ; margin:0px; float:left; padding:5px 20px; border-bottom:1px dashed #FFFFFF; width:820px;\"> <a href=\"https://www.flinkiso.com\" target=\"_blank\" style=\"padding:0px; margin:0px;\"><img src=\"https://www.flinkiso.com/FlinkISO-Logo.png\" style=\"box-shadow:0 0 0\"></a>
  <h1 style=\"float:right; color:#cccccc; margin-top:35px\"> Free Open Source QMS</h1>
</div>
<div style=\"background:#16AFDD;margin:0px; float:left; padding:5px 20px; border-bottom:1px dashed #FFFFFF; color:#fff; width:820px; text-shadow:0px 0px 1px #000000; line-height:19px\">
	<h2>Performance Review Questions</h2>	
</div>
<div style=\"background:#f9f9f9 url(http://www.flinkiso.com/images/white_texture.png) ;margin:0px; float:left; padding:5px 20px; color:#333333; width:820px\">
        <p>
        <div style='border:1px solid #ccc'>
        <table>
            <tr>
                <td style='padding:10px'>
                    Dear ".$recipientName.", <br /><br />
		    You are receiving this email in response to your appraisal session.
		    <br /><br />
		    To answer your performance review questions, please click the link below.
		    <br /><br />
		    <a href='".$baseurl."'>Appraisal Questions</a>
		    <br /><br />
		    <em><strong>Login to FlinkISO application before you attend the appraisal session. This link will be active till " . $appraisalDate . ".</strong></em>
		    <br /><br />
                    If you need any additional support, please contact " . $appraiserName . " (" . $appraiserEmail . ")<br/><br/>
                    <strong>For more information contact us at +91 22 28766060</strong>
                    <br/><br/>
                    Warm Regards<br/>
                    Team - FlinkISO.com
                </td>
            </tr>
            </table>
        </div>
        </p>

</div>
<div style=\"line-height:16px;background:#414243;margin:0 0 20px 0; float:left; padding:5px 20px; color:#fff; width:820px\">
<span style=\"float:right\">Website : <a href=\"https://www.flinkiso.com\" style=\"color:#ffffff\" target=\"_blank\">www.flinkiso.com</a> <br />
For Support : <a href=\"mailto:support@flinkiso.com\" style=\"color:#ffffff\">support@flinkiso.com</a> <br />
copyrights &copy; 2014 </span> <span class=\"godaddy-img\" style=\"float: left; margin-top:6px; box-shadow:0 0 0 \"></span>
        
        </div>
    </body>
</html>";
?>