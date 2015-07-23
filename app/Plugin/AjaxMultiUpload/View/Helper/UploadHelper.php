<?php 
/**
 *
 * Dual-licensed under the GNU GPL v3 and the MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2012, Suman (srs81 @ GitHub)
 * @package       plugin
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 *                and/or GNU GPL v3 (http://www.gnu.org/copyleft/gpl.html)
 */
 
class UploadHelper extends AppHelper {


	public function view ($model, $id, $edit=false) {
		$results = $this->listing ($model, $id);
				
		$directory = $results['directory'];
		$baseUrl = $results['baseUrl'];
		$files = $results['files'];

		$str = "";
		$count = 0;
		$webroot = Router::url("/") . "ajax_multi_upload";
		if(1 < 0){
		$str .= "<div class='row'><div class='col-md-12'><h4>Images</h4></div>";
		foreach ($files as $file) {				
			$type = pathinfo($file, PATHINFO_EXTENSION);
			$f = basename($file);
			$url = $baseUrl . "/$f";
				if(($type == "jpeg") || ($type == "jpg") || ($type == "png" )|| ($type == "gif")){
					$baseEncFile = base64_encode($file);
					$delUrl = "$webroot/file_uploads/delete/$baseEncFile/";
					$str .= "<div class='col-md-3'><a href=$url target='_blank'><img src='$url' style='width:200px; height:200px' class='thumbnail' /></a>";
					$str .= "<a href='$delUrl' ><img class='ajax-delete-button' src='" . Router::url("/") . "ajax_multi_upload/img/delete.png' alt='Delete' /></a>&nbsp;<small>". $f ."</small></div>";
				}
		}
		$str .= "</div><br />
		<h4>Other files</h4>
		<table class='table table-condensed  table-striped' style='width:100%;max-width:1100px'><tr><th>File Type</th><th>File Details</th><th>Action</th></tr>";
		
		foreach ($files as $file) {
			$type = pathinfo($file, PATHINFO_EXTENSION);			
				$filesize = $this->format_bytes (filesize ($file));
				$f = basename($file);
				$url = $baseUrl . "/$f";
				if($type)
				{
					
					if(($type != "jpeg") && ($type != "jpg") && ($type != "png" ) && ($type != "gif")){
					$str .= "<tr><td><img src='" . Router::url("/") . "ajax_multi_upload/img/fileicons/$type.png' /></td>";
					$str .= "<td><a target='_blank' href=$url>" . $f . "</a> ($filesize)";
					if ($edit) {
						$baseEncFile = base64_encode ($file);
						$delUrl = "$webroot/file_uploads/delete/$baseEncFile/";			
						$str .= "<td><a href='$delUrl'><img src='" . Router::url("/") . 
							"ajax_multi_upload/img/delete.png' alt='Delete' /></a></td>";
					}
					$str .= "</td></tr>\n";
					}
				}
		}
		$str .= "</table>\n";	
		}
		return $str;
	}

	public function listing ($model, $id) {
		$dir = Configure::read('AMU.directory');
		if (strlen($dir) < 1) $dir = "files/".$_SESSION['User']['company_id'];

		$lastDir = $this->last_dir ($model, $id);
		$directory = WWW_ROOT . DS . $dir . DS . $lastDir;
		$baseUrl = Router::url("/") . $dir . "/" . $lastDir;
		$files = glob ("$directory/*");
		return array("baseUrl" => $baseUrl, "directory" => $directory, "files" => $files);
	}

	public function edit ($model, $id, $flag) {
		$dir = Configure::read('AMU.directory');
		if (strlen($dir) < 1) $dir = "files";

		if($flag == null)$str = $this->view ($model, $id, true);
		$webroot = Router::url("/") . "ajax_multi_upload";
		// Replace / with underscores for Ajax controller
		$lastDir = str_replace ("/", "___", 
			$this->last_dir ($model, $id));
		$str .= <<<END
			<br /><br />
			<link rel="stylesheet" type="text/css" href="$webroot/css/fileuploader.css" />			
			<script src="$webroot/js/fileuploader.js" type="text/javascript"></script>
			<div class="AjaxMultiUpload$lastDir" name="AjaxMultiUpload">
				
			</div>			
			<script>
			
				if (typeof document.getElementsByClassName!='function') {
						
				    document.getElementsByClassName = function() {
				        var elms = document.getElementsByTagName('*');
				        var ei = new Array();
				        for (i=0;i<elms.length;i++) {
				            if (elms[i].getAttribute('class')) {
				                ecl = elms[i].getAttribute('class').split(' ');
				                for (j=0;j<ecl.length;j++) {
				                    if (ecl[j].toLowerCase() == arguments[0].toLowerCase()) {
				                        ei.push(elms[i]);
				                    }
				                }
				            } else if (elms[i].className) {
				                ecl = elms[i].className.split(' ');
				                for (j=0;j<ecl.length;j++) {
				                    if (ecl[j].toLowerCase() == arguments[0].toLowerCase()) {
				                        ei.push(elms[i]);
				                    }
				                }
				            }
				        }
				        return ei;
				    }					
				}
				
				
					var amuCollection = document.getElementsByClassName("AjaxMultiUpload$lastDir");
					for (var i = 0, max = amuCollection.length; i < max; i++) {					
							action = amuCollection[i].className.replace('AjaxMultiUpload', '');
							window['uploader'+i] = new qq.FileUploader({
								element: amuCollection[i],
								action: '$webroot/file_uploads/upload/' + action + '/$flag',
								debug: true
							});
						}
				
			</script>
END;
		return $str;
	}

	// The "last mile" of the directory path for where the files get uploaded
	public function last_dir ($model, $id) {
		return $model . "/" . $id;
	}

	// From http://php.net/manual/en/function.filesize.php
	public function format_bytes($size) {
		$units = array(' B', ' KB', ' MB', ' GB', ' TB');
		for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
		return round($size, 2).$units[$i];
	}
}
