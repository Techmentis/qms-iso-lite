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
 
class FileUploadsController extends AjaxMultiUploadAppController {

	public $name = "Upload";
	public $uses = null;

	// list of valid extensions, ex. array("jpeg", "xml", "bmp")
	public $allowedExtensions = array();

	public function upload($dir=null,$flag=null) {
		// max file size in bytes
		$size = Configure::read ('AMU.filesizeMB');
		if (strlen($size) < 1) $size = 4;
		$relPath = Configure::read ('AMU.directory');
		if (strlen($relPath) < 1) $relPath = "files/".$_SESSION['User']['company_id'];

		$sizeLimit = $size * 1024 * 1024;
                $this->layout = "ajax";
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
		if($flag==1)$allowedExtensions = array('xls','xlxs');
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$result = $uploader->handleUpload($dir,FALSE,$flag);	
		$this->set("result", htmlspecialchars(json_encode($result), ENT_NOQUOTES));
		$this->_upload_add($result['details']['filename'],$result['details']['ext'],$result['details']['message'],$get_dir);	

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
		$file = str_replace('\\/',DS,$file);
		$file = str_replace('\\',DS,$file);			
		$newFile = str_replace('//','/',$file);

	
		
	//	if(file_exists($file)) {
			$path = explode('/files/',$file);
			$split = explode('/',$path[1]);
			//if folder == uploads
			//split[0] = directory
			//split[1] = userid
			//split[2] = table name
			//split[3] = record id
			//split[4] = filename
			
			$file_name = explode('.',$split[5]);
			//if($split[1] == 'upload'){
	
				$this->loadModel('FileUpload');
			//	$this->loadModel('SystemTable');
			//	$this->SystemTable->recursive = 0;
				$this->FileUpload->recursive = -1;
				// find table id
				
				/*$table = $this->SystemTable->find('first',array(
										'fields'=>array('SystemTable.id','SystemTable.system_name'),
										'conditions'=>array('SystemTable.system_name'=>$split[3])));

				if($split[2] == 'documents'){
					
					if($split[3]=='bd' || $split[3]=='edp' || $split[3]=='hr' || $split[3]=='mr' || $split[3]=='personal_admin' || $split[3]=='production' || $split[3]=='purchase'  || $split[3]=='quality_control' ){
						$file_name = explode('.',$split[4]);
						$conditions = array('FileUpload.system_table_id'=>'dashboards',
										'FileUpload.file_details'=>$file_name[0],
										'FileUpload.file_type'=>$file_name[1]);										
					}else{
					
					$file_name = explode('.',$split[3]);
					$table = $this->SystemTable->find('first',array(
										'fields'=>array('SystemTable.id','SystemTable.system_name'),
										'conditions'=>array('SystemTable.system_name'=>'users')));
										
					$conditions = array('FileUpload.system_table_id'=>$table['SystemTable']['id'],
										'FileUpload.file_details'=>$file_name[0],
										'FileUpload.file_type'=>$file_name[1]);
					}
				}else{
					$conditions = array('FileUpload.system_table_id'=>$table['SystemTable']['id'],
										'FileUpload.record'=>$split[4],
										'FileUpload.file_details'=>$file_name[0],
										'FileUpload.file_type'=>$file_name[1]);
				}
				*/

				$conditions = array('FileUpload.file_dir'=>substr(str_replace(WWW_ROOT .DS. 'files' .DS. $this->Session->read('User.company_id'),NULL,$newFile),1));
				
				$file_find = $this->FileUpload->find('first', array(
										'conditions'=> $conditions
												));

				$data['id'] = $file_find['FileUpload']['id'];
				$data['publish'] = 1;
				$data['file_status'] = 0;
				$data['result'] = 'File Deleted';
				$this->FileUpload->save($data);
	//		}
			
			

			if(unlink($file)) {
				$this->Session->setFlash(__('File deleted!'));				
			} else {
				$this->Session->setFlash(__('Unable to delete File'));					
			}
		/*} else {
			$this->Session->setFlash(__('File does not exist!'));					
		}*/
		
		$this->redirect($this->referer());	
	}
}

?>
