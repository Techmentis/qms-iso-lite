<?php
App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Companies Controller
 *
 * @property Company $Company
 */
class CompaniesController extends AppController {

public function _getSystemtableid()
{

    $this->loadModel('SystemTable');
    $this->SystemTable->recursive = -1;
    $sys_id = $this->SystemTable->find('first',array('conditions'=>array('SystemTable.system_name'=>$this->request->params['controller']))) ;
    return $sys_id['SystemTable']['id'];
}

/**
 * request handling by - TGS
 *
 */
/**
 * _check_request method
 *
 * @return void
 */


/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Company->exists($id)) {
			throw new NotFoundException(__('Invalid company'));
		}
		$options = array('conditions' => array('Company.' . $this->Company->primaryKey => $id));
		$this->set('company', $this->Company->find('first', $options));
	}



/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Company->exists($id)) {
			throw new NotFoundException(__('Invalid company'));
		}
		if($this->_show_approvals()){
			$this->loadModel('User');
			$this->User->recursive = 0;
			$userids = $this->User->find('list',array('order'=>array('User.name'=>'ASC'),'conditions'=>array('User.publish'=>1,'User.soft_delete'=>0)));
			$this->set(array('userids'=>$userids,'show_approvals'=>$this->_show_approvals()));
		}


		if ($this->request->is('post') || $this->request->is('put')) {
			$company_name = $this->_get_company();
                        $this->request->data['Company']['system_table_id'] = $this->_getSystemtableid();
			$this->request->data['Company']['name'] = $company_name['Company']['name'];
			$this->request->data['Company']['number_of_branches'] = $this->Company->BranchId->find('count',array('conditions'=>array('BranchId.soft_delete'=>0,'BranchId.publish'=>1)));

			if ($this->Company->save($this->request->data)) {
				if($this->_show_approvals()){
					$this->loadModel('Approval');
					$this->Approval->create();
					$this->request->data['Approval']['model_name']='Company';
					$this->request->data['Approval']['controller_name']=$this->request->params['controller'];
					$this->request->data['Approval']['from']=$this->Session->read('User.id');
					$this->request->data['Approval']['user_id']=$this->request->data['Approval']['user_id'];
					$this->request->data['Approval']['created_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['modified_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['record']=$this->Company->id;
					$this->Approval->save($this->request->data['Approval']);
				}
				$this->Session->setFlash(__('The company has been saved'));
				if($this->_show_evidence() == true)$this->redirect(array('action' => 'view',$id));
				else $this->redirect(array('action' => 'view',$id));
			} else {
				$this->Session->setFlash(__('The company could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Company.' . $this->Company->primaryKey => $id));
			$this->request->data = $this->Company->find('first', $options);
		}
		$systemTables = $this->Company->SystemTable->find('list',array('conditions'=>array('SystemTable.publish'=>1,'SystemTable.soft_delete'=>0)));
		$masterListOfFormats = $this->Company->MasterListOfFormat->find('list',array('conditions'=>array('MasterListOfFormat.publish'=>1,'MasterListOfFormat.soft_delete'=>0)));
		$schedules = $this->Company->Schedule->find('list');

		$this->set(compact('systemTables', 'masterListOfFormats','schedules'));
		$count = $this->Company->find('count');
		$published = $this->Company->find('count',array('conditions'=>array('Company.publish'=>1)));
		$unpublished = $this->Company->find('count',array('conditions'=>array('Company.publish'=>0)));

		$this->set(compact('count','published','unpublished'));
	}

    private function _sql_query($flag = Null) {
        $db = ConnectionManager::getDataSource('default');
        if(isset($flag) && $flag == 'insert')
            $path = WWW_ROOT . "DB" . DS . "insert.sql";
        if(isset($flag) && $flag == 'remove')
            $path = WWW_ROOT . "DB" . DS . "delete.sql";
        $fileName = new File($path);
        if($fileName)
        {
            $statements = $fileName->read();
            $statements = explode(';', $statements);
            $this->loadModel('User');
            $prefix = $this->User->tablePrefix;
            foreach ($statements as $statement) {
                if (trim($statement) != '') {
		   $statement = str_replace("TRUNCATE TABLE `", "TRUNCATE TABLE `$prefix",  $statement);
                   $query =  $db->query($statement);
                }
            }
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    

}
