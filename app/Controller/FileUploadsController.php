<?php

App::uses('AppController', 'Controller');
App::import('Vendor', 'Spreadsheet_Excel_Reader', array(
    'file' => 'Excel/reader.php'
));
App::import('Vendor', 'PHPExcel', array(
    'file' => 'Excel/PHPExcel.php'
));
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * FileUploads Controller
 *
 * @property FileUpload $FileUpload
 */
class FileUploadsController extends AppController {

    public $components = array(
        'RequestHandler',
        'Session',
        'AjaxMultiUpload.Upload'
    );
    public $helpers = array(
        'Js',
        'Session',
        'Paginator',
        'Tinymce'
    );

    public function _get_system_table_id() {
        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = - 1;
        $systemTableId = $this->SystemTable->find('first', array(
            'conditions' => array(
                'SystemTable.system_name' => $this->request->params['controller']
            )
        ));
        return $systemTableId['SystemTable']['id'];
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $conditions = $this->_check_request();
        $this->paginate = array(
            'order' => array(
                'FileUpload.sr_no' => 'DESC'
            ),
            'conditions' => array(
                $conditions
            )
        );
        $this->FileUpload->recursive = 0;
        $this->set('fileUploads', $this->paginate());

        $this->_get_count();
    }

    /**
     * adcanced_search method
     * Advanced search by - TGS
     * @return void
     */
    public function file_advanced_search() {
        
        if($this->request->query){
            $conditions = array();
            if ($this->request->query['keywords']) {
                $searchArray = array();
                if ($this->request->query['strict_search'] == 0) {
                    $searchKeys[] = $this->request->query['keywords'];
                } else {
                    $searchKeys = explode(" ", $this->request->query['keywords']);
                }
                foreach ($searchKeys as $searchKey):
                    foreach ($this->request->query['search_fields'] as $search):
                        if ($this->request->query['strict_search'] == 0)
                            $searchArray[] = array('FileUpload.' . $search => $searchKey);
                        else
                            $searchArray[] = array('FileUpload.' . $search . ' like ' => '%' . $searchKey . '%');
                    endforeach;
                endforeach;
                if ($this->request->query['strict_search'] == 0)
                    $conditions[] = array('and' => array('or' => $searchArray));
                else
                    $conditions[] = array('or' => $searchArray);
            }

            if ($this->request->query['branch_list']) {
                foreach ($this->request->query['branch_list'] as $branches):
                    $branchConditions[] = array(
                        'FileUpload.branchid' => $branches
                    );
                endforeach;
                if ($this->request->query['strict_search'] == 0)
                    $conditions[] = array('and' => array('or' => $branchConditions));
                else
                    $conditions[] = array('or' => $branchConditions);
            }
            if ($this->request->query['system_table_id'] != -1) {
                $systemTableIdConditions[] = array('FileUpload.system_table_id' => $this->request->query['system_table_id']);
                if ($this->request->query['strict_search'] == 0)
                    $conditions[] = array('and' => $systemTableIdConditions);
                else
                    $conditions[] = array('or' => $systemTableIdConditions);
            }
            if ($this->request->query['master_list_of_id'] != -1) {
                $masterListConditions[] = array('FileUpload.master_list_of_format_id' => $this->request->query['master_list_of_id']);
                if ($this->request->query['strict_search'] == 0)
                    $conditions[] = array('and' => $masterListConditions);
                else
                    $conditions[] = array('or' => $masterListConditions);
            }
            if (!$this->request->query['to-date'])
                $this->request->query['to-date'] = date('Y-m-d');
            if ($this->request->query['from-date']) {
                $conditions[] = array(
                'FileUpload.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])),
                'FileUpload.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date']))
            );
        }
        $conditions =  $this->advance_search_common($conditions);
        unset($this->request->query);
        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array(
                'FileUpload.branch_id' => $this->Session->read('User.branch_id')
            );
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array(
                'FileUpload.created_by' => $this->Session->read('User.id')
            );
        $conditions[] = array(
            $onlyBranch,
            $onlyOwn
        );
        $this->FileUpload->recursive = 0;
        $this->paginate = array(
            'order' => array(
                'FileUpload.sr_no' => 'DESC'
            ),
            'conditions' => $conditions,
            'FileUpload.soft_delete' => 0
        );
        $this->set('fileUploads', $this->paginate());
        $this->_get_count();
        $this->render('index');
        }
        $PublishedEmployeeList = $this->requestAction('App/get_model_list/Employee/');
        $PublishedBranchList = $this->requestAction('App/get_model_list/Branch/');
        $system_table = $this->requestAction('App/get_model_list/SystemTable/');
        $masterListOfFormat = $this->requestAction('App/get_model_list/MasterListOfFormat/');
        $this->set(compact('masterListOfFormat','PublishedEmployeeList','PublishedBranchList','system_table'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->FileUpload->exists($id)) {
            throw new NotFoundException(__('Invalid file upload'));
        }

        $options = array('conditions' => array('FileUpload.' . $this->FileUpload->primaryKey => $id));
        $this->set('fileUpload', $this->FileUpload->find('first', $options));
    }

    /**
     * list method
     *
     * @return void
     */
    public function lists() {
        $this->_get_count();
    }

    /**
     * add_ajax method
     *
     * @return void
     */
    public function add_ajax() {
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }

        if ($this->request->is('post')) {
            $this->request->data['FileUpload']['system_table_id'] = $this->_get_system_table_id();
            $this->FileUpload->create();
            if ($this->FileUpload->save($this->request->data)) {
                if ($this->_show_approvals()) {
                    $this->loadModel('Approval');
                    $this->Approval->create();
                    $this->request->data['Approval']['model_name'] = 'FileUpload';
                    $this->request->data['Approval']['controller_name'] = $this->request->params['controller'];
                    $this->request->data['Approval']['user_id'] = $this->request->data['Approval']['user_id'];
                    $this->request->data['Approval']['from'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['created_by'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['modified_by'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['record'] = $this->FileUpload->id;
                    $this->Approval->save($this->request->data['Approval']);
                }

                $this->Session->setFlash(__('The file upload has been saved'));
                if ($this->_show_evidence() == true)
                    $this->redirect(array(
                        'action' => 'view',
                        $this->FileUpload->id
                    ));
                else
                    $this->redirect(str_replace('/lists', '/add_ajax', $this->referer()));
            }
            else {
                $this->Session->setFlash(__('The file upload could not be saved. Please, try again.'));
            }
        }

        $systemTables = $this->FileUpload->SystemTable->find('list', array(
            'conditions' => array(
                'SystemTable.publish' => 1,
                'SystemTable.soft_delete' => 0
            )
        ));
        $users = $this->FileUpload->User->find('list', array(
            'conditions' => array(
                'User.publish' => 1,
                'User.soft_delete' => 0
            )
        ));
        $userSessions = $this->FileUpload->UserSession->find('list', array(
            'conditions' => array(
                'UserSession.publish' => 1,
                'UserSession.soft_delete' => 0
            )
        ));
        $masterListOfFormats = $this->FileUpload->MasterListOfFormat->find('list', array(
            'conditions' => array(
                'MasterListOfFormat.publish' => 1,
                'MasterListOfFormat.soft_delete' => 0
            )
        ));
        $this->set(compact('systemTables', 'users', 'userSessions', 'masterListOfFormats'));
        $count = $this->FileUpload->find('count');
        $published = $this->FileUpload->find('count', array(
            'conditions' => array(
                'FileUpload.publish' => 1
            )
        ));
        $unpublished = $this->FileUpload->find('count', array(
            'conditions' => array(
                'FileUpload.publish' => 0
            )
        ));
        $this->set(compact('count', 'published', 'unpublished'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
		
		
		
        if (!$this->FileUpload->exists($id)) {
            throw new NotFoundException(__('Invalid file upload'));
        }

        if ($this->_show_approvals()) {
            $this->set(array('show_approvals' => $this->_show_approvals()));
        }
			
	$check_versions = $this->FileUpload->find('all',array('conditions'=>array(
		   	'FileUpload.system_table_id'=>$this->request->params['pass'][1],
		   	'FileUpload.record'=>$this->request->params['pass'][2],
			'FileUpload.id <> ' =>$this->request->params['pass'][0],
			)));
	$this->set('revisions',$check_versions);	
			
			
        if ($this->request->is('post') || $this->request->is('put')) {
			
			
			
			$this->request->data['FileUpload']['file_details']=str_replace('.','-',$this->request->data['FileUpload']['file_details']);
				$this->request->data['FileUpload']['file_details'] = str_replace(' ','-',$this->request->data['FileUpload']['file_details']);	
			
			if($this->request->params['pass'][1] == 'products'){

				$file_from = WWW_ROOT .  'files'. DS . $this->Session->read('User.company_id') . DS . "upload" . DS . $this->Session->read('User.id') . DS . 'products'  . DS . $this->request->params['pass'][3] .DS .$this->request->params['pass'][2]. DS .$this->request->data['FileUpload']['old_file_details'].'.'.$this->request->data['FileUpload']['file_type'];
				$file_to = WWW_ROOT .  'files'. DS . $this->Session->read('User.company_id') . DS . "upload" . DS . $this->Session->read('User.id') . DS  . 'products' . DS . $this->request->params['pass'][3] .DS .$this->request->params['pass'][2]. DS .$this->request->data['FileUpload']['file_details'].'.'.$this->request->data['FileUpload']['file_type'];				
			
			}elseif($this->request->params['pass'][1] == 'users'){
	
				$file_from = WWW_ROOT .  'files'. DS . $this->Session->read('User.company_id') . DS . "upload" . DS . 'documents' . DS . $this->request->params['pass'][2] . DS .$this->request->data['FileUpload']['old_file_details'].'.'.$this->request->data['FileUpload']['file_type'];
				$file_to = WWW_ROOT .  'files'. DS . $this->Session->read('User.company_id') . DS . "upload" . DS . 'documents' . DS  .$this->request->params['pass'][2] . DS .$this->request->data['FileUpload']['file_details'].'.'.$this->request->data['FileUpload']['file_type'];				
			}else{
			
				$file_from = WWW_ROOT .  'files'. DS . $this->Session->read('User.company_id') . DS . "upload" . DS . $this->Session->read('User.id') . DS . $this->request->data['FileUpload']['controller'] . DS . $this->request->data['FileUpload']['record'] . DS .$this->request->data['FileUpload']['old_file_details'].'.'.$this->request->data['FileUpload']['file_type'];
				$file_to = WWW_ROOT .  'files'. DS . $this->Session->read('User.company_id') . DS . "upload" . DS . $this->Session->read('User.id') . DS . $this->request->data['FileUpload']['controller'] . DS . $this->request->data['FileUpload']['record'] . DS .$this->request->data['FileUpload']['file_details'].'.'.$this->request->data['FileUpload']['file_type'];			
			}
			if(rename($file_from,$file_to)==false){
				$this->Session->setFlash(__('Failed to update'));
				//$this->redirect(array('controller'=>$this->request->data['FileUpload']['controller'],'action' => 'view',$this->request->data['FileUpload']['record']));
			}

			$this->request->data['FileUpload']['file_dir'] = $this->request->data['FileUpload']['file_dir'] . DS .$this->request->data['FileUpload']['file_details'].'.'.$this->request->data['FileUpload']['file_type'];
           
		   $check_versions = $this->FileUpload->find('all',array('conditions'=>array(
		   	'FileUpload.system_table_id'=>$this->request->data['FileUpload']['system_table_id'],
		   	'FileUpload.record'=>$this->request->data['FileUpload']['record'],			
			)));
		   $this->set('revisions',$check_versions);
		   if(count($check_versions) <= 1)$this->request->data['FileUpload']['archive'] = 0;
   
		    if ($this->FileUpload->save($this->request->data)) {
                  $this->Session->setFlash(__('The file upload has been saved'));
              if($this->request->params['pass'][1] == 'dashboards'){
                    $this->redirect(array('controller'=>'dashboards','action' => strtolower($this->request->data['FileUpload']['record'])));
				}elseif($this->request->params['pass'][1] == 'users'){
					$this->redirect(array('controller'=>'users','action' => 'dashboard'));
				}elseif($this->request->params['pass'][1] == 'products'){
					$this->redirect(array('controller'=>'products','action' => 'view',$this->request->params['pass'][3]));
				}else{
					  $this->redirect($this->referer());
					  //$this->redirect(array('controller'=>$this->request->data['FileUpload']['controller'],'action' => 'view',$this->request->data['FileUpload']['record']));
				}
            }
            else {
                $this->Session->setFlash(__('The file upload could not be saved. Please, try again.'));
            }
        } else {
            $options = array(
                'conditions' => array(
                    'FileUpload.' . $this->FileUpload->primaryKey => $id
                )
            );
            $this->request->data = $this->FileUpload->find('first', $options);
        }

        $systemTables = $this->FileUpload->SystemTable->find('list', array(
            'conditions' => array(
                'SystemTable.publish' => 1,
                'SystemTable.soft_delete' => 0
            )
        ));
        $users = $this->FileUpload->User->find('list', array(
            'conditions' => array(
                'User.publish' => 1,
                'User.soft_delete' => 0
            )
        ));
		
		 $masterListOfFormats = $this->FileUpload->MasterListOfFormat->find('list', array(
            'conditions' => array(
                'MasterListOfFormat.publish' => 1,
                'MasterListOfFormat.soft_delete' => 0
            )
        ));
		$PublishedEmployeeList = $this->_get_employee_list();
		$this->set(compact('systemTables', 'users', 'userSessions', 'masterListOfFormats','PublishedEmployeeList'));
        $count = $this->FileUpload->find('count');
        $published = $this->FileUpload->find('count', array(
            'conditions' => array(
                'FileUpload.publish' => 1
            )
        ));
        $unpublished = $this->FileUpload->find('count', array(
            'conditions' => array(
                'FileUpload.publish' => 0
            )
        ));
        $this->set(compact('count', 'published', 'unpublished'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->FileUpload->exists($id)) {
            throw new NotFoundException(__('Invalid file upload'));
        }

        $this->loadModel('Approval');
        if (!$this->Approval->exists($approvalId)) {
            throw new NotFoundException(__('Invalid approval id'));
        }

        $approval = $this->Approval->read(null, $approvalId);
        $this->set('same', $approval['Approval']['user_id']);

        if ($this->_show_approvals()) {
            $this->loadModel('User');
            $this->User->recursive = 0;
            $userids = $this->User->find('list', array(
                'order' => array(
                    'User.name' => 'ASC'
                ),
                'conditions' => array(
                    'User.publish' => 1,
                    'User.soft_delete' => 0
                )
            ));
            $this->set(array(
                'userids' => $userids,
                'show_approvals' => $this->_show_approvals()
            ));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->FileUpload->save($this->request->data)) {
                if ($this->request->data['FileUpload']['publish'] == 0 && $this->_show_approvals()) {
                    $this->loadModel('Approval');
                    $this->Approval->create();
                    $this->request->data['Approval']['model_name'] = 'FileUpload';
                    $this->request->data['Approval']['controller_name'] = $this->request->params['controller'];
                    $this->request->data['Approval']['from'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['user_id'] = $this->request->data['Approval']['user_id'];
                    $this->request->data['Approval']['created_by'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['modified_by'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['record'] = $this->FileUpload->id;
                    $this->Approval->save($this->request->data['Approval']);
                    $this->Session->setFlash(__('The file upload has been saved'));
                    if ($this->_show_evidence() == true)
                        $this->redirect(array(
                            'action' => 'view',
                            $id
                        ));
                    else
                        $this->redirect(array(
                            'action' => 'view', $id
                        ));
                }
                else {
                    $this->Approval->read(null, $approvalId);
                    $data['Approval']['status'] = 'Approved';
                    $data['Approval']['modified_by'] = $this->Session->read('User.id');
                    $this->Approval->save($data);
                    $this->Session->setFlash(__('The branch has been published'));
                    if ($this->_show_evidence() == true)
                        $this->redirect(array(
                            'action' => 'view',
                            $id
                        ));
                    else
                        $this->redirect(array(
                            'action' => 'view', $id
                        ));
                }
            }
            else {
                $this->Session->setFlash(__('The file upload could not be saved. Please, try again.'));
            }
        } else {
            $options = array(
                'conditions' => array(
                    'FileUpload.' . $this->FileUpload->primaryKey => $id
                )
            );
            $this->request->data = $this->FileUpload->find('first', $options);
        }

        $systemTables = $this->FileUpload->SystemTable->find('list', array(
            'conditions' => array(
                'SystemTable.publish' => 1,
                'SystemTable.soft_delete' => 0
            )
        ));
        $users = $this->FileUpload->User->find('list', array(
            'conditions' => array(
                'User.publish' => 1,
                'User.soft_delete' => 0
            )
        ));
        $userSessions = $this->FileUpload->UserSession->find('list', array(
            'conditions' => array(
                'UserSession.publish' => 1,
                'UserSession.soft_delete' => 0
            )
        ));
        $masterListOfFormats = $this->FileUpload->MasterListOfFormat->find('list', array(
            'conditions' => array(
                'MasterListOfFormat.publish' => 1,
                'MasterListOfFormat.soft_delete' => 0
            )
        ));
        $this->set(compact('systemTables', 'users', 'userSessions', 'masterListOfFormats'));
        $count = $this->FileUpload->find('count');
        $published = $this->FileUpload->find('count', array(
            'conditions' => array(
                'FileUpload.publish' => 1
            )
        ));
        $unpublished = $this->FileUpload->find('count', array(
            'conditions' => array(
                'FileUpload.publish' => 0
            )
        ));
        $this->set(compact('count', 'published', 'unpublished'));
    }

    function export() {
        $this->set('ref', $this->referer());
        $this->set('tableFields', $this->tableFields);
    }

    public function _check_access($modelName = null) {
        $this->loadModel('User');
        $this->User->recursive = 0;
        $userAccess = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Session->read('User.id')
            ),
            'fields' => array(
                'User.user_access'
            )
        ));
        $newData = json_decode($userAccess['User']['user_access'], true);
        if (!$newData) {
            return true;
        } else {
            foreach ($newData['user_access'] as $m):
                $model = array_keys($m);
                if (Inflector::Singularize(Inflector::Classify($model[0])) == $modelName) {

                    if ($m[$model[0]]['allow'] == true) {
                        return true;
                    } else {
                        return false;
                    }
                }

            endforeach;
        }
    }

    function export_xls() {
        
    }

    public function _get_assosciate_data() {
        
    }
    public function _get_custom_array_data() {
        
    }

    function export_xls_data() {
        
    }
    public function choose() {
        
    }

    public function beforeFilter() {
        
    }

    public  function beforeRender() {

    }

    public function import_data($systemTableId = null, $userId = null, $fileName = null) {

    }

    public function compare_data() {

    }

    public function _add_imported_data($importedData = null, $importModel, $comapanyId = null) {
        
    }

    public function _get_forign_key_value($modelName, $recordName) {

    }

    public function show_file() {
        $this->layout = "ajax";
    }

    public function create_header() {
        
    }

public function approval_ajax(){
		$this->loadModel('SystemTable');
		$approval_system_table = $this->SystemTable->find('first',array('conditions'=>array('SystemTable.system_name'=>'approvals')));
		$approval_files = $this->FileUpload->find('all',array('conditions'=>array('FileUpload.record'=>$this->request->params['pass'][0],'FileUpload.system_table_id'=>$approval_system_table['SystemTable']['id'])));
		$this->set('approval_files',$approval_files);
	}
public function approval_ajax_file_count(){
		$this->loadModel('SystemTable');
		$approval_system_table = $this->SystemTable->find('first',array('conditions'=>array('SystemTable.system_name'=>'approvals')));
		$approval_files = $this->FileUpload->find('count',array('conditions'=>array('FileUpload.record'=>$this->request->params['pass'][0],'FileUpload.system_table_id'=>$approval_system_table['SystemTable']['id'])));
		$this->set('approval_files_count',$approval_files);
	}


}

