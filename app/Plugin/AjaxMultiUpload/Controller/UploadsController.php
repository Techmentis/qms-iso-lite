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
 
class UploadsController extends AjaxMultiUploadAppController {

	public $name = "Upload";
	public $uses = null;

	// list of valid extensions, ex. array("jpeg", "xml", "bmp")
	public $allowedExtensions = array();

	public function upload($dir=null) {
		// max file size in bytes
		$size = Configure::read ('AMU.filesizeMB');
		if (strlen($size) < 1) $size = 4;
		$relPath = Configure::read ('AMU.directory');
		if (strlen($relPath) < 1) $relPath = "files/".$_SESSION['User']['company_id'];

		$sizeLimit = $size * 1024 * 1024;
                $this->layout = "ajax";
	       // Configure::write('debug', 0);
		$directory = WWW_ROOT . DS . $relPath;
 
		if ($dir === null) {
			$this->set("result", "{\"error\":\"Upload controller was passed a null value.\"}");
			return;
		}
		// Replace underscores delimiter with slash
		$dir = str_replace ("___", "/", $dir);
		// dir for saving in model
		$get_dir = $dir;
		$dir = $directory . DS . "$dir/";
		
		if (!file_exists($dir)) {
			mkdir($dir, 0777, true);
		}
		$uploader = new qqFileUploader($this->allowedExtensions, 
			$sizeLimit);
		$result = $uploader->handleUpload($dir);
		$this->_upload_add($result['details']['filename'],$result['details']['ext'],$result['details']['message'],$get_dir);		
		$this->set("result", htmlspecialchars(json_encode($result), ENT_NOQUOTES));
		
		
		
	}

	/**
	 *
	 * delete a file
	 *
	 * Thanks to traedamatic @ github
	 */
	public function delete($file = null) {
		if(is_null($file)) {
			$this->Session->setFlash(__('File parameter is missing'));
			$this->redirect($this->referer());
		}
		$file = base64_decode($file);
		if(file_exists($file)) {
			//Configure::write('debug',1);
			//debug($file);
			
			$path = explode('/files/',$file);
			$split = explode('/',$path[1]);
			
			//debug($split);
			//if folder == uploads
			//split[0] = directory
			//split[1] = userid
			//split[2] = table name
			//split[3] = record id
			//split[4] = filename
			
			$file_name = explode('.',$split[4]);
			
			if($split[0] == 'upload'){
				$this->loadModel('FileUpload');
				$this->loadModel('SystemTable');
				$this->SystemTable->recursive = 0;
				$this->FileUpload->recursive = -1;
				// find table id
				$table = $this->SystemTable->find('first',array(
										'fields'=>array('SystemTable.id','SystemTable.system_name'),
										'conditions'=>array('SystemTable.system_name'=>$split[2])));
				$file_find = $this->FileUpload->find('first', array(
										'conditions'=>array(
															'FileUpload.system_table_id'=>$table['SystemTable']['id'],
															'FileUpload.user_id'=>$split[1],
															'FileUpload.record'=>$split[3],
															'FileUpload.file_details'=>$file_name[0],
															'FileUpload.file_type'=>$file_name[1]
															)
												));
				
				$data['id'] = $file_find['FileUpload']['id'];
				$data['publish'] = 0;
				$this->FileUpload->save($data);
			}
			
			
			//exit;
			if(unlink($file)) {
				$this->Session->setFlash(__('File deleted!'));				
			} else {
				$this->Session->setFlash(__('Unable to delete File'));					
			}
		} else {
			$this->Session->setFlash(__('File does not exist!'));					
		}
		
		$this->redirect($this->referer());	
	}
}

?>
