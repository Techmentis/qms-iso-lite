<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');


/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

    public $components = array('Ctrl');
    public $show_nc_alert = null;
    public $dbsize = null;
    public $task_performed = null;
    public $tasks = null;
    public $common_condition = array('OR' => array('History.action' => array('add', 'add_ajax'),
            array('History.model_name' => array('CakeError', 'NotificationUser', 'History', 'UserSession', 'Page', 'Dashboard', 'Error',
                    'NotificaionType', 'Approval', 'Benchmark', 'FileUpload', 'DataEntry', 'Help', 'MeetingBranch', 'MeetingDepartment',
                    'MeetingEmployee', 'MeetingTopic', 'Message', 'NotificationUser', 'PurchaseOrderDetail', 'NotificationUser', 'PurchaseOrderDetail',
                    'MasterListOfFormatBranch', 'MasterListOfFormatDepartment', 'MasterListOfFormatDistributor'),
                'History.action <>' => 'delete',
                'History.action <>' => 'soft_delete',
                'History.action <>' => 'purge',
                'History.post_values <>' => '[[],[]]'
    )));

    public function _get_system_table_id() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $this->request->params['controller'])));
        return $systemTableId['SystemTable']['id'];
    }

    public function welcome(){
		$this->layout = 'welcome';
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {

        $conditions = $this->_check_request();
        $this->paginate = array('order' => array('User.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->User->recursive = 0;
        $this->set('users', $this->paginate());

        $this->_get_count();
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
            $statements = explode('@#@', $statements);
	    $prefix = $this->User->tablePrefix;

            foreach ($statements as $statement) {
                if (trim($statement) != '') {
		   $statement = str_replace("INSERT INTO `", "INSERT INTO `$prefix",  $statement);
                   $query =  $db->query($statement);
                }
            }

            return TRUE;
        }else{
            return FALSE;
        }

    }
     public function _update_sql($companyId = null){
        $allModelNames = App::objects('Model');
        $excludeModel = array('AppModel','MasterListOfFormat','MasterListOfFormatBranch','MasterListOfFormatDepartment','MasterListOfFormatDistributor', 'MasterListOfWorkInstruction');
        foreach ($allModelNames as $allModelName){
            if(!in_array($allModelName, $excludeModel)){
                $this->loadModel($allModelName);
                if($this->$allModelName->hasField('company_id')){
		    $records = $this->$allModelName->updateAll(array('company_id'=> "'".$companyId."'"));
                 }
            }
        }
	$this->sample_file_upload($companyId);

    }

    public function remove_sample() {
        $flag = 'remove';
        if($this->_sql_query($flag)){
            $this->loadModel('Company');
            $this->Company->updateAll(array('Company.sample_data'=>0));
            $this->Session->setFlash('All data removed from Database succesfully');
        }
        else{
            $this->Session->setFlash('All data is not removed from Database');
        }
         $this->redirect(array('action'=>'dashboard'));
    }
    public function insert_sample_data() {
        $flag = 'insert';
        if($this->_sql_query($flag)){
            $this->Session->setFlash('Data inserted succesfully');
        }
        else{
            $this->Session->setFlash('Data is not inserted succesfully');
        }
    }

        public function sample_file_upload($companyId = null){
	    $this->loadModel('FileUpload');
	    $this->loadModel('SystemTable');

    }


    /**
     * adcanced_search method
     * Advanced search by - TGS
     * @return void
     */
    public function advanced_search() {
        $conditions = array();
        if ($this->request->query['keywords']) {
            $searchArray = array();
            if ($this->requset->query['strict_search'] == 0) {
                $searchKeys[] = $this->request->query['keywords'];
            } else {
                $searchKeys = explode(" ", $this->request->query['keywords']);
            }
            foreach ($searchKeys as $searchKey):
                foreach ($this->request->query['search_fields'] as $search):
                    if ($this->request->query['strict_search'] == 0)
                        $searchArray[] = array('User.' . $search => $searchKey);
                    else
                        $searchArray[] = array('User.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }
        if ($this->request->query['employee_id'] != -1) {
            $employeeConditions[] = array('User.employee_id' => $this->request->query['employee_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $employeeConditions);
            else
                $conditions[] = array('or' => $employeeConditions);
        }
        if ($this->request->query['language_id'] != -1) {
            $languageConditions[] = array('User.language_id' => $this->request->query['language_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $languageConditions);
            else
                $conditions[] = array('or' => $languageConditions);
        }
        if ($this->request->query['is_mr'] != '') {
            $mrConditions[] = array('User.is_mr' => $this->request->query['is_mr']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $mrConditions);
            else
                $conditions[] = array('or' => $mrConditions);
        }
        if ($this->request->query['is_view_all'] != '') {
            $viewAllConditions[] = array('User.is_view_all' => $this->request->query['is_view_all']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $viewAllConditions);
            else
                $conditions[] = array('or' => $viewAllConditions);
        }
        if ($this->request->query['is_approvar'] != '') {
            $isApprovarConditions[] = array('User.is_approvar' => $this->request->query['is_approvar']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $isApprovarConditions);
            else
                $conditions[] = array('or' => $isApprovarConditions);
        }
        if ($this->request->query['department_id']) {
            foreach ($this->request->query['department_id'] as $department_id):
                $departmentConditions[] = array('User.department_id' => $department_id);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('or' => $departmentConditions));
            else
                $conditions[] = array('or' => $departmentConditions);
        }
        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('User.branch_id' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('or' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('User.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'User.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
        unset($this->request->query);
       if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('Or' => array('User.branch_id' => $this->Session->read('User.branch_id'), 'User.id' => $this->Session->read('User.id')));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Or' => array('User.created_by' => $this->Session->read('User.id'), 'User.id' => $this->Session->read('User.id')));

        $conditions[] = array($onlyBranch, $onlyOwn);
        $this->User->recursive = 0;
        $this->paginate = array('order' => array('User.sr_no' => 'DESC'), 'conditions' => $conditions, 'User.soft_delete' => 0);
        $this->set('users', $this->paginate());

        $this->render('index');
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $this->set('user', $this->User->find('first', $options));
    }

    public function unblock_user($id = null) {

        $this->loadModel('User');
        if (!empty($id)) {

            $data['id'] = $id;
            $data['status'] = 1;
            if ($this->User->save($data))
                $this->Session->setFlash(__('User Unblocked'));
            else
                $this->Session->setFlash(__('Failed to Unblock'));
        }

        $blockedusercount = $this->User->find('count', array('conditions' => array('User.status' => 3, 'User.publish' => 1, 'User.soft_delete' => 0), 'recursive' => -1));
        $blockeduser = $this->User->find('all', array('conditions' => array('User.status' => 3, 'User.publish' => 1, 'User.soft_delete' => 0), 'recursive' => -1));
        $this->set(compact('blockedusercount', 'blockeduser'));
        return true;
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
            $this->request->data['User']['system_table_id'] = $this->_get_system_table_id();

            $userAccess = $this->User->find('first', array('conditions' => array('User.id' => $this->request->data['User']['copy_acl_from']), 'fields' => 'User.user_access'));

            if (!$userAccess['User']['user_access'])
                $userAccess['User']['user_access'] = $this->Ctrl->get_defaults();

            $this->loadModel('Employee');
            $this->Employee->recursive = 0;
            $userName = $this->Employee->find('first', array('conditions' => array('Employee.id' => $this->request->data['User']['employee_id']), 'fields' => array('Employee.name', 'Employee.office_email', 'Employee.personal_email')));
            $pwd = $this->request->data['User']['password'];
            $this->request->data['User']['user_access'] = $userAccess['User']['user_access'];
            $this->request->data['User']['name'] = $userName['Employee']['name'];
            $this->request->data['User']['password'] = Security::hash($this->request->data['User']['password'],'md5',true);
            $this->request->data['User']['status'] = 1;
            $this->request->data['User']['agree'] = 1;
            if ($this->request->data['User']['is_mr'] == 1) {
                $this->request->data['User']['user_access'] = '';
                $this->request->data['User']['is_view_all'] = 1;
                $this->request->data['User']['is_approvar'] = 1;
            }
           // $this->request->data['User']['copy_acl_from'] = $this->request->data['User']['user_id'];
            $this->User->create();
            if ($this->User->save($this->request->data)) {

                if ($userName['Employee']['office_email'] != '') {
                    $email = $userName['Employee']['office_email'];
                } else if ($userName['Employee']['personal_email'] != '') {
                    $email = $userName['Employee']['personal_email'];
                }
                if ($email) {
                    try{
                        App::uses('CakeEmail', 'Network/Email');
                        if($this->Session->read('User.is_smtp') == 1)
                        $EmailConfig = new CakeEmail("smtp");
                        if($this->Session->read('User.is_smtp') == 0)
                            $EmailConfig = new CakeEmail("default");
                        $EmailConfig->to($email);
                        $EmailConfig->subject('FlinkISO: Login Details');
                        $EmailConfig->template('loginDetail');
                        $EmailConfig->viewVars(array('username' => $this->request->data['User']['username'], 'password' => $pwd));
                        $EmailConfig->emailFormat('html');
                        $EmailConfig->send();
                    } catch(Exception $e) {
                         $this->Session->setFlash(__('The user has been saved but fail to send email. Please check smtp details.', true), 'smtp');

                    }

                }
                $this->_reset_benchmarking();

                $this->Session->setFlash(__('The user has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->User->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
        $aclUsers = $this->User->find('list', array('fields' => array('User.username'), 'conditions' => array('User.is_mr' => 0)));
        $languages = $this->User->Language->find('list', array('conditions' => array('Language.publish' => 1, 'Language.soft_delete' => 0)));
        $this->set(compact('languages', 'aclUsers'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
        public function edit($id = null) {
            if (!$this->User->exists($id)) {
                throw new NotFoundException(__('Invalid user'));
            }
            if ($this->_show_approvals()) {
                $this->set(array('showApprovals' => $this->_show_approvals()));
            }

            if ($this->request->is('post') || $this->request->is('put')) {
                $this->request->data['User']['system_table_id'] = $this->_get_system_table_id();

                /* if employee changes, name in user's table should also be changed
                 * if user is changes to MR, then user_access should be blank			 *
                 */
               

                if ($this->request->data['User']['is_mr'] == 1) {
                    $this->request->data['User']['user_access'] = '';
                    $this->request->data['User']['is_view_all'] = 1;
                    $this->request->data['User']['is_approvar'] = 1;
                }else if($this->request->data['User']['copy_acl_from']!='' && $this->request->data['User']['copy_acl_from']!=-1){
                    $userAccess = $this->User->find('first', array('conditions' => array('User.id' => $this->request->data['User']['copy_acl_from']), 
                    'fields' => 'User.user_access'));

                     if (!$userAccess['User']['user_access']){
                        
                         $userAccess = $this->User->find('first', array('conditions' => array('User.id' => $this->request->data['User']['id']), 
                         'fields' => 'User.user_access'));
                           if (!$userAccess['User']['user_access']){
                              $userAccess['User']['user_access'] = $this->Ctrl->get_defaults();
                }

                    }
                        
                }else{
                        $userAccess = $this->User->find('first', array('conditions' => array('User.id' => $this->request->data['User']['id']), 
                        'fields' => 'User.user_access'));
                   
                        if (!$userAccess['User']['user_access']){
                          
                              $userAccess['User']['user_access'] = $this->Ctrl->get_defaults();
                        }
                    
                }
            
               

                $employeeName = $this->User->Employee->find('first', array(
                    'fields' => array('Employee.id', 'Employee.name'),
                    'conditions' => array('Employee.id' => $this->request->data['User']['employee_id'])));
                $this->request->data['User']['name'] = $employeeName['Employee']['name'];
                $this->request->data['User']['user_access'] = $userAccess['User']['user_access'];

                if ($this->User->save($this->request->data)) {

                    $this->_reset_benchmarking();

                    $this->Session->setFlash(__('The user has been saved'));

                    if ($this->_show_approvals()) $this->_save_approvals ();

                    if ($this->_show_evidence() == true)
                        $this->redirect(array('action' => 'view', $id));
                    else
                        $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
                }
            } else {
                $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
                $this->request->data = $this->User->find('first', $options);
            }
            $aclUsers = $this->User->find('list', array('conditions' => array('User.publish' => 1, 'User.soft_delete' => 0, 'User.is_mr' => 0), 'fields' => array('User.username')));
            $languages = $this->User->Language->find('list', array('conditions' => array('Language.publish' => 1, 'Language.soft_delete' => 0)));

            $this->set(compact('aclUsers', 'languages'));
        }

    public function _reset_benchmarking() {

        // add to branch / department benchmark
        $this->loadModel('Benchmark');
        $this->Benchmark->recursive = 0;

        $this->User->recursive = 0;
        $userBenchmark = $this->User->find('all', array(
            'conditions' => array('User.branch_id' => $this->request->data['User']['branch_id'], 'User.department_id' => $this->request->data['User']['department_id']),
            'fields' => array('User.benchmark')
        ));
        $totalBenchmark = null;
        foreach ($userBenchmark as $benchmarks):
            $totalBenchmark = $totalBenchmark + $benchmarks['User']['benchmark'];
        endforeach;

        $branchList = $this->_get_branch_list();
        $departmentsList = $this->_get_department_list();

        foreach ($branchList as $key => $value):
            foreach ($departmentsList as $dkey => $dvalue):
                $this->Benchmark->deleteAll(array('Benchmark.branch_id' => $key, 'Benchmark.department_id' => $dkey), false);
                $users = $this->User->find('all', array(
                    'conditions' => array('User.publish' => 1, 'User.soft_delete' => 0, 'User.branch_id' => $key, 'User.department_id' => $dkey),
                    'fields' => array('User.id', 'User.username', 'User.benchmark', 'Branch.id', 'Branch.name', 'Department.id', 'Department.name')
                ));

                $totalBenchmark = 0;
                foreach ($users as $benchmarks):
                    $totalBenchmark = $totalBenchmark + $benchmarks['User']['benchmark'];
                endforeach;

                $newData['branch_id'] = $key;
                $newData['department_id'] = $dkey;
                $newData['benchmark'] = $totalBenchmark;
                $newData['branchid'] = $this->Session->read('User.branch_id');
                $newData['departmentid'] = $this->Session->read('User.department_id');
                $newData['created_by'] = $this->Session->read('User.id');
                $newData['modified_by'] = $this->Session->read('User.id');
                $newData['created'] = date('Y-m-d H:i:s');
                $newData['modified'] = date('Y-m-d H:i:s');
                $newData['publish'] = 1;
                $this->Benchmark->create();
                $this->Benchmark->save($newData, false);

            endforeach;
        endforeach;
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }

        $this->loadModel('Approval');
        if (!$this->Approval->exists($approvalId)) {
            throw new NotFoundException(__('Invalid approval id'));
        }

        $approval = $this->Approval->read(null, $approvalId);
        $this->set('same', $approval['Approval']['user_id']);

        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['User']['system_table_id'] = $this->_get_system_table_id();
             
            if ($this->request->data['User']['is_mr'] == 1) {
                $this->request->data['User']['user_access'] = '';
                $this->request->data['User']['is_view_all'] = 1;
                $this->request->data['User']['is_approvar'] = 1;
                }else if($this->request->data['User']['copy_acl_from']!='' && $this->request->data['User']['copy_acl_from']!=-1){
                    $userAccess = $this->User->find('first', array('conditions' => array('User.id' => $this->request->data['User']['user_id']), 
                    'fields' => 'User.user_access'));

                     if (!$userAccess['User']['user_access']){
                        
                         $userAccess = $this->User->find('first', array('conditions' => array('User.id' => $this->request->data['User']['id']), 
                         'fields' => 'User.user_access'));
                           if (!$userAccess['User']['user_access']){
                              $userAccess['User']['user_access'] = $this->Ctrl->get_defaults();
            }
                         
                    }
                        
                }else{
                        $userAccess = $this->User->find('first', array('conditions' => array('User.id' => $this->request->data['User']['id']), 
                        'fields' => 'User.user_access'));
                       if (!$userAccess['User']['user_access']){
                              $userAccess['User']['user_access'] = $this->Ctrl->get_defaults();
                        }
                    
                }
                $this->request->data['User']['user_access'] = $userAccess['User']['user_access'];
            if ($this->User->save($this->request->data)) {

                $this->Session->setFlash(__('The user has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        $aclUsers = $this->User->find('list', array('conditions' => array('User.publish' => 1, 'User.soft_delete' => 0, 'User.is_mr' => 0), 'fields' => array('User.username')));
        $languages = $this->User->Language->find('list', array('conditions' => array('Language.publish' => 1, 'Language.soft_delete' => 0)));
        $this->set(compact('aclUsers', 'languages'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {

        $modelName = $this->modelClass;
        $this->loadModel('Approval');
        if (!empty($id)) {
            if ($id == $this->Session->read('User.id')) {

                $this->Session->setFlash(__('Logged-in user can not be deleted!'));
                $this->redirect(array('action' => 'index'));
            }else{

                    $approves = $this->Approval->find('all',array('conditions'=>array('Approval.record'=>$id,'Approval.model_name'=>$modelName)));
                    foreach($approves as $approve)
                    {
                        $approve['Approval']['soft_delete']=1;
                        $this->Approval->save($approve, false);
                    }
                    $data['id'] = $id;
                    $data['soft_delete'] = 1;
                    $this->$modelName->save($data, false);
            }
        }
        $this->Session->setFlash(__('All selected value deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function delete_all($ids = null) {
        $flag = 1;
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);

        $modelName = $this->modelClass;
        $this->loadModel('Approval');
        if (!empty($ids)) {

            foreach ($ids as $id) {
                if (!empty($id)) {
                    if ($id == $this->Session->read('User.id')) {
                        $flag = 0;
                        $this->Session->setFlash(__('Logged-in user can not be deleted!'));
                    }else{
                        $approves = $this->Approval->find('all',array('conditions'=>array('Approval.record'=>$id,'Approval.model_name'=>$modelName)));
                        foreach($approves as $approve)
                        {
                            $approve['Approval']['soft_delete']=1;
                            $this->Approval->save($approve, false);
                        }
                        $data['id'] = $id;
                        $data['soft_delete'] = 1;
                        $this->$modelName->save($data, false);
                    }
                }
            }
        }
        if ($flag)
            $this->Session->setFlash(__('All selected users deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * Bake 
     *
     */
    public function reset_password($params = null, $user = null) {

        $this->layout = 'login';
        if (empty($params)) {

            if ($this->request->is('post') || $this->request->is('put')) {

                $user = $this->User->find('first', array('conditions' => array('User.status' => 1, 'User.username' => $this->data['User']['username'])));
                if (!empty($user)) {
                    if ($user['Employee']['office_email'] != '') {

                        $email = $user['Employee']['office_email'];
                    } else if ($user['Employee']['personal_email'] != '') {
                        $email = $user['Employee']['personal_email'];
                    } else {
                        $this->Session->setFlash(__('No email id for this user, try again.'), 'default', array('class'=>'alert-danger'));
                        $this->redirect(array('action' => 'reset_password'));
                    }

                    $this->_send_password_reset($email, $this->data['User']['username']);
                } else {
                    $this->Session->setFlash(__('Invalid Username, try again.'), 'default', array('class'=>'alert-danger'));
                    $this->redirect(array('action' => 'reset_password'));
                }
            } else {
                $this->_send_password_reset();
            }
        } else {
            $this->_check_reset_password($params);
        }
    }

    public function _check_reset_password($params = null) {


        $user = $this->User->checkPasswordToken($params);
        if (empty($user)) {
            $this->Session->setFlash(__('Invalid password reset token, try again.'), 'default', array('class'=>'alert-danger'));
            $this->redirect(array('action' => 'reset_password'));
        }
        $this->set('token', $params);
        $this->set('username', $user['User']['username']);
    }

    public function save_user_password() {

        if ($this->request->is('post')) {
            if (!empty($this->request->data) && $this->User->resetPassword($this->request->data)) {
                $this->Session->setFlash(__('Password changed, you can now login with your new password.'), 'default', array('class'=>'alert-success'));
                $this->redirect(array('controller' => 'users', 'action' => 'login'));
            }
        }
    }

    public function _get_mail_instance() {
        return new CakeEmail();
    }

    public function _send_password_reset($email = null, $username = null) {


        if (!empty($email) && !empty($username)) {
            $user = $this->User->passwordReset($email, $username);

            if (!empty($user)) {
                try{
                    $userCount = $this->User->find('count');
                    $companyId = $user['User']['company_id'];

                    $this->loadModel('Company');
                    $smtpSetup = $this->Company->find('first', array('conditions'=> array('Company.id'=>$companyId), 'fields'=> array('smtp_setup','is_smtp'),'recursive'=>-1));

                    if(($userCount == 1) && ($smtpSetup['Company']['smtp_setup'] == 0)){
                        $this->redirect(array('controller'=>'users', 'action'=>'reset_password', $this->User->data['User']['password_token']));
                    } else {
                        App::uses('CakeEmail', 'Network/Email');
                        if($smtpSetup['Company']['is_smtp'] == 1)
                        $EmailConfig = new CakeEmail("smtp");
                        if($smtpSetup['Company']['is_smtp'] == 0)
                            $EmailConfig = new CakeEmail("default");
                        $EmailConfig->to($email);
                        $EmailConfig->subject('FlinkISO: Password reset request');
                        $baseurl = Router::url('/', true) . $this->request->params['controller'] . "/reset_password/" . $this->User->data['User']['password_token'];
                        $EmailConfig->template('passwordTmp');
                        $EmailConfig->viewVars(array('baseurl' => $baseurl));
                        $EmailConfig->emailFormat('html');
                        $EmailConfig->send();

                        $this->Session->setFlash(__('Please check the email you have registered with us. An email has been sent with instruction to reset password.'), 'default', array('class'=>'alert-success'));
                        $this->redirect(array('controller' => 'users', 'action' => 'login'));
                    }
                 } catch(Exception $e) {
                         $this->Session->setFlash(__('Can not notify user using email. Please check SMTP details and email address is correct.'), 'default', array('class'=>'alert-danger'));
                 }
            }
        }
        $this->render('request_password_change');
    }

    public function login() {

	if (!file_exists(APP.'Config/installed.txt') && !file_exists(APP.'Config/installed_db.txt')) {
	     $this->redirect(array('controller' => 'installer', 'action' => 'index'));

	}else if (!file_exists(APP.'Config/installed.txt') && file_exists(APP.'Config/installed_db.txt')) {
	    // the routes for when the application has been db installed but user not registered
	     $this->redirect(array('controller' => 'users', 'action' => 'register'));
	}

        if ($this->request->is('ajax') == true) {
            $str = "Your session has expired, please login to continue";
            $this->Session->setFlash(__($str, true), 'default', array('class'=>'alert-danger'));
            $this->layout = 'ajax';
        } else {
            $this->layout = 'login';
        }

        if ($this->Session->read('User.id')) {

            $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
        }

        $allUsers = $this->User->find('all', array('conditions' => array('User.login_status' => 1)));
        $currentTime = date('Y-m-d H:i:s');
        foreach ($allUsers as $user) {
            $lastActTime = date('Y-m-d H:i:s', strtotime('+10 mins', strtotime($user['User']['last_activity'])));
            if ($lastActTime < $currentTime) {
                $this->User->read(null, $user['User']['id']);
                $data['User']['last_activity'] = date('Y-m-d H:i:s');
                $data['User']['login_status'] = 0;
                $this->User->save($data, false);
            }
        }

        if ($this->request->is('post')) {
            $this->loadModel('Company');
            $user = $this->User->find('first', array('conditions' => array('User.status' => 1, 'User.soft_delete' => 0, 'User.publish' => 1, 'User.username' => $this->data['User']['username'])));

            if ($user) {
                $companyId = $user['User']['company_id'];
                $companyData = $this->Company->find('first', array('conditions' => array('id' => $companyId), 'recursive' => -1));
                $currentTime = date('Y-m-d H:i:s');
                if ($companyData && $companyData['Company']['allow_multiple_login'] == 0 && $user['User']['login_status'] == 1) {
                    $this->Session->setFlash(__('Already Logged in. Please wait while your earlier session expires.', true), 'default', array('class' => 'alert-danger'));
                    $this->redirect(array('controller' => 'users', 'action' => 'login'));
                }

                if ($user['User']['password'] != Security::hash($this->data['User']['password'], 'md5', true)) {
                    if ($this->Session->read('Login.username') == $this->data['User']['username'] && $companyData['Company']['limit_login_attempt']) {
                        $this->Session->write('Login.count', $this->Session->read('Login.count') + 1);
                    } else {
                        $this->Session->write('Login.count', 1);
                    }
                    $this->Session->write('Login.username', $this->data['User']['username']);
                    if (3 <= ($this->Session->read('Login.count'))) {
                        $this->User->read(null, $user['User']['id']);
                        $data['User']['status'] = 3;
                        $this->User->save($data, false);

                        $this->Session->destroy();
                        $this->Session->setFlash(__('Your account is locked', true), 'default', array('class' => 'alert-danger'));
                        $this->redirect(array('controller' => 'users', 'action' => 'login'));
                    } else {
                        $this->Session->write('Login.username', $user['User']['username']);
                    }
                    if ($companyData['Company']['limit_login_attempt'])
                        $this->Session->setFlash(__('Incorrect login credential : You have ' . (3 - $this->Session->read('Login.count')) . ' attempts left', true), 'default', array('class' => 'alert-danger'));
                    else
                        $this->Session->setFlash(__('Incorrect login credential', true), 'default', array('class' => 'alert-danger'));

                    $this->redirect(array('controller' => 'users', 'action' => 'login'));                    
                } else {
                    if ($user['User']['last_login'] == '0000-00-00 00:00:00' && $user['User']['last_activity'] == '0000-00-00 00:00:00') {
                        $this->loadModel('Company');
                        $companyUsers = $this->User->find('all', array('conditions' => array('User.company_id' => $companyId, 'User.last_login !=' => '0000-00-00 00:00:00', 'User.last_activity !=' => '0000-00-00 00:00:00'), 'recursive' => -1));

                        if (count($companyUsers) == 0) {
                            $CompanyData['Company']['id'] = $companyId;
                            $CompanyData['Company']['flinkiso_start_date'] = date('Y-m-d H:i:s');
                            $CompanyData['Company']['flinkiso_end_date'] = date('Y-m-d H:i:s', strtotime('+15 days', strtotime(date('Y-m-d H:i:s'))));
                            $this->Company->save($CompanyData, false);
                        }
                    }
                }
                $this->User->read(null, $user['User']['id']);
                $data['User']['last_login'] = date('Y-m-d H:i:s');
                $data['User']['last_activity'] = date('Y-m-d H:i:s');
                $data['User']['login_status'] = 1;
                $this->User->save($data, false);
                $this->Session->write('User.id', $user['User']['id']);
                $this->Session->write('User.employee_id', $user['Employee']['id']);
                $this->Session->write('User.branch_id', $user['User']['branch_id']);
                $this->Session->write('User.department_id', $user['User']['department_id']);
                $this->Session->write('User.branch', $user['Branch']['name']);
                $this->Session->write('User.department', $user['Department']['name']);
                $this->Session->write('User.name', $user['Employee']['name']);
                $this->Session->write('User.username', $user['User']['username']);
                $this->Session->write('User.lastLogin', $user['User']['last_login']);
                $this->Session->write('User.is_mr', $user['User']['is_mr']);
                $this->Session->write('User.company_id', $user['User']['company_id']);
                $this->Session->write('User.is_smtp', $user['Company']['is_smtp']);
                if ($user['User']['is_mr'] == 1)
                    $this->Session->write('User.is_view_all', 1);
                else
                    $this->Session->write('User.is_view_all', $user['User']['is_view_all']);
                $this->Session->write('User.is_approvar', $user['User']['is_approvar']);
                $this->loadModel('Language');
                $languageData = array();
                $languageData = $this->Language->find('first', array(
                    'conditions' => array(
                        'Language.id' => $user['User']['language_id']),
                    'recursive' => - 1
                ));
                $this->Session->write('SessionLanguage', null);
                if ($languageData['Language']['short_code']) {
                    $this->Session->write('SessionLanguage', $languageData['Language']['short_code']);
                }
                $_SESSION['User']['id'] = $user['User']['id'];


                if ($user['User']['last_login'] == NULL) {
                    $this->Session->setFlash(__('Please change your password', true));
                    $this->redirect(array('controller' => 'users', 'action' => 'change_password'));
                } else {
                    if ($user['User']['agree'] && $user['User']['agree'] != 0) {
                        $this->Session->write('TANDC', 1);
                        $this->loadModel('UserSession');
                        $this->UserSession->create();
                        $data['UserSession']['ip_address'] = $_SERVER['REMOTE_ADDR'];
                        $data['UserSession']['browser_details'] = json_encode($_SERVER);
                        $data['UserSession']['start_time'] = date('Y-m-d H:i:s');
                        $data['UserSession']['end_time'] = date('Y-m-d H:i:s');
                        $data['UserSession']['user_id'] = $this->Session->read('User.id');
                        $data['UserSession']['employee_id'] = $this->Session->read('User.employee_id');
                        $data['UserSession']['company_id'] = $this->Session->read('User.company_id');
                        $this->UserSession->save($data, false);
                        $this->Session->write('User.user_session_id', $this->UserSession->id);
                        $this->redirect(array('controller' => 'users', 'action' => 'terms_and_conditions'));
                    } else {

                        $this->loadModel('UserSession');
                        $this->UserSession->create();
                        $data['UserSession']['ip_address'] = $_SERVER['REMOTE_ADDR'];
                        $data['UserSession']['browser_details'] = json_encode($_SERVER);
                        $data['UserSession']['start_time'] = date('Y-m-d H:i:s');
                        $data['UserSession']['end_time'] = date('Y-m-d H:i:s');
                        $data['UserSession']['user_id'] = $this->Session->read('User.id');
                        $data['UserSession']['employee_id'] = $this->Session->read('User.employee_id');
                        $data['UserSession']['company_id'] = $this->Session->read('User.company_id');
                        $this->UserSession->save($data, false);
                        $this->Session->write('User.user_session_id', $this->UserSession->id);


                        $this->loadModel('MasterListOfFormat');
                        $checkForms = $this->MasterListOfFormat->find('count', array('conditions' => array('MasterListOfFormat.company_id' => $this->Session->read('User.company_id'))));

                        /* if (isset($checkForms) && ($checkForms > 0)) */
                        $this->redirect(array('action' => 'dashboard'));
                        /* else
                          $this->redirect(array('action' => 'welcome')); */
                    }
                }
            }

            $this->Session->setFlash(__('Incorrect Login Credentials or your account is locked or already logged in', true), 'default', array('class' => 'alert-danger'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
    }

    public function logout() {
        if ($this->Session->read('User.id')) {
            $this->User->read(null, $this->Session->read('User.id'));

            $data['User']['login_status'] = 0;
            $this->User->save($data, false);

            $this->loadModel('UserSession');
            $data['UserSession']['id'] = $this->Session->read('User.user_session_id');
            $data['UserSession']['end_time'] = date('Y-m-d H:i:s');
            $this->UserSession->save($data, false);

            $this->Session->write('User.id', NULL);
            $this->Session->destroy('User');
        }
        $this->Session->setFlash(__('You have been logged out' . $this->Session->read('User.id'), true), 'default', array('class'=>'alert-danger'));
        $this->redirect(array('controller' => 'users', 'action' => 'login'));
    }

    public function dashboard() {

        $this->set(array('show_nc_alert' => false, 'dbsize' => null, 'task_performed' => null, 'tasks' => null));

        $this->loadModel('Company');
        $company = $this->Company->find('first', array('conditions' => array('id'=>$this->Session->read('User.company_id')),'fields'=>'smtp_setup', 'recursive'=>-1));
            if($company['Company']['smtp_setup'] == 0)
                $this->set('smtp_alert', true);
            else
                $this->set('smtp_alert', false);
        $company = $this->Company->find('first', array('conditions' => array('id'=>$this->Session->read('User.company_id')),'fields'=>'sample_data', 'recursive'=>-1));

            if($company['Company']['sample_data'] == 1)
                $this->set('sampleData', true);
            else
                $this->set('sampleData', false);

        //Approvals
        $this->loadModel('Approval');
        $this->Approval->recursive = 0;
        $approvals = $this->Approval->find('all', array('order' => array('Approval.sr_no' => 'desc'),'group'=>'Approval.record', 'conditions' => array('or' => array(array('Approval.status' => 0), array('Approval.status' => NULL)), 'Approval.user_id' => $this->Session->read('User.id'), 'Approval.soft_delete' => 0), 'fields' => array(
            'From.name', 'Approval.id', 'Approval.model_name', 'Approval.controller_name', 'Approval.record', 'Approval.comments', 'Approval.created')));
        $approvalsCount = count($approvals);
        $this->set(compact('approvalsCount', 'approvals'));

        if ($this->Session->read('User.is_mr') == true or $this->Session->read('User.department_id') == '5239c2ec-3240-456f-909f-5891c6c3268c') {

            // get Customer Complaints Count
            $this->loadModel('CustomerComplaint');
            $complaintReceived = $this->CustomerComplaint->find('count', array('conditions' => array('CustomerComplaint.soft_delete' => 0, 'CustomerComplaint.publish' => 1), 'recursive' => -1));
            $complaintOpen = $this->CustomerComplaint->find('count', array('conditions' => array('CustomerComplaint.current_status <>' => 1, 'CustomerComplaint.employee_id' => $this->Session->read('User.employee_id'),'CustomerComplaint.soft_delete' => 0, 'CustomerComplaint.publish' => 1), 'recursive' => -1));

            // get CAPA Count
            $this->loadModel('CorrectivePreventiveAction');
            $capaReceived = $this->CorrectivePreventiveAction->find('count', array('conditions' => array('CorrectivePreventiveAction.soft_delete' => 0, 'CorrectivePreventiveAction.publish' => 1), 'recursive' => -1));
            $openCapa = $this->CorrectivePreventiveAction->find('count', array('conditions' => array('CorrectivePreventiveAction.current_status' => 0, 'CorrectivePreventiveAction.soft_delete' => 0, 'CorrectivePreventiveAction.publish' => 1), 'recursive' => -1));
            $closeCapa = $this->CorrectivePreventiveAction->find('count', array('conditions' => array('CorrectivePreventiveAction.current_status' => 1, 'CorrectivePreventiveAction.soft_delete' => 0, 'CorrectivePreventiveAction.publish' => 1), 'recursive' => -1));

            $assignedOpenCapa = $this->CorrectivePreventiveAction->find('count', array(
            'order' => array('CorrectivePreventiveAction.target_date' => 'DESC'),
            'conditions' => array('OR' => array(
                    'CorrectivePreventiveAction.assigned_to' => $this->Session->read('User.employee_id'),
                    'CorrectivePreventiveAction.action_assigned_to' => $this->Session->read('User.employee_id'),
                ), 'CorrectivePreventiveAction.current_status' => 0, 'CorrectivePreventiveAction.soft_delete' => 0, 'CorrectivePreventiveAction.publish' => 1)));

            
            
            $this->set(compact('capaReceived','openCapa', 'closeCapa','assignedOpenCapa'));

            //Blocked User
            $blockedUserCount = $this->User->find('count', array('conditions' => array('User.status' => 3, 'User.publish' => 1, 'User.soft_delete' => 0), 'recursive' => -1));
            $blockedUser = $this->User->find('all', array('conditions' => array('User.status' => 3, 'User.publish' => 1, 'User.soft_delete' => 0), 'recursive' => -1));
            $this->set(compact('blockedUserCount', 'blockedUser'));

            // get NC Count
            $this->loadModel('InternalAudit');
            $countNCs = $this->InternalAudit->find('count', array('conditions' => array('InternalAudit.non_conformity_found' => 1, 'InternalAudit.publish' => 1, 'InternalAudit.soft_delete' => 0,'CorrectivePreventiveAction.soft_delete' => 0)));
            $countNCsOpen = $this->InternalAudit->find('count', array('conditions' => array('InternalAudit.non_conformity_found' => 1, 'InternalAudit.publish' => 1, 'InternalAudit.soft_delete' => 0, 'CorrectivePreventiveAction.current_status' => 0,'CorrectivePreventiveAction.soft_delete' => 0)));

            $this->set(compact('countNCs','countNCsOpen'));

            // get ChangeAdditionDeletionRequest Count
            $this->loadModel('ChangeAdditionDeletionRequest');
            $docChangeReq = $this->ChangeAdditionDeletionRequest->find('count', array('conditions' => array('ChangeAdditionDeletionRequest.soft_delete' => 0, 'ChangeAdditionDeletionRequest.publish' => 1), 'recursive' => -1));

            $file = new File(WWW_ROOT . "/files/" . $this->Session->read('User.company_id') . "/rediness.txt");
            if (file_exists($file->path))
                $readiness = $file->read();
            else
                $readiness = 0;
            $this->set(compact('capaReceived', 'complaintReceived', 'complaintOpen', 'countNCs', 'countNCsOpen', 'docChangeReq', 'readiness'));
        }

        // Get Assigned Calibration Count 
        
        $this->loadModel('Calibration');
        $countNextCalibrations = $this->Calibration->find('count',array('conditions'=>array('Device.employee_id' => $this->Session->read('User.employee_id'), 'Device.publish' => 1, 'Calibration.next_calibration_date >=' => date('Y-m-d'), 'Calibration.publish' => 1)));
        $this->set('countNextCalibrations',$countNextCalibrations);
        
        //Get Count for Materials.
        
        $this->loadModel('Material');
        App::uses('ConnectionManager', 'Model');
        $dataSource = ConnectionManager::getDataSource('default');
        $prefix = $dataSource->config['prefix'];
        $qcStepsCount = $this->Material->find('count',array('conditions' => array('Material.soft_delete' => 0, 'Material.publish' => 1, 'Material.qc_required' => 1, 'Material.id NOT IN (select material_id from '.$prefix.'material_quality_checks)')));
        $this->set('qcStepsCount',$qcStepsCount);
        
        //Get Count for Materials that required QC.
        
        // Get Count Device Maintainance.
        
        $this->loadModel('DeviceMaintenance');
            $currentDate = date('Y-m-d');
            $nextDate = date("Y-m-d", strtotime("$currentDate +7 day"));
            $deviceMaintainancesCount = $deviceMaintainancesCount = $this->DeviceMaintenance->find('count', array('conditions' => array('DeviceMaintenance.next_maintanence_date between ? and ?' => array($currentDate, $nextDate)), 'recursive' => 0));
            $this->set('deviceMaintainancesCount',$deviceMaintainancesCount);
            
        // Get Count For Tasks.
        $this->loadModel('Task');
            $onlyBranch = null;
        $onlyOwn = null;
        $condition1 = null;
        $condition2 = null;
        $condition3 = null;
        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('Task.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Task.created_by' => $this->Session->read('User.id'));
        if ($this->Session->read('User.is_mr') == 0) {
            $condition3 = array('Task.user_id' => $this->Session->read('User.id'));
        }
        $finalCond = array('OR' => array($onlyBranch, $onlyOwn, $condition3));
        if ($this->request->params['named']) {
            if ($this->request->params['named']['published'] == null)
                $condition1 = null;
            else
                $condition1 = array('Task.publish' => $this->request->params['named']['published']);
            if ($this->request->params['named']['soft_delete'] == null)
                $condition2 = null;
            else
                $condition2 = array('Task.soft_delete' => $this->request->params['named']['soft_delete']);
            if ($this->request->params['named']['soft_delete'] == null)
                $conditions = array($onlyBranch, $onlyOwn, $condition1, $condition3, 'Task.soft_delete' => 0);
            else
                $conditions = array($condition1, $condition2, $finalCond);
        }else {
            $conditions = array($finalCond, 'Task.soft_delete' => 0);
        }
        $options = array('conditions' => array($conditions));
        $tasks = $this->Task->find('count', $options);
        $this->set('tasks',$tasks);    

        //get upload folder size
        $var = APP ;
        $uploadSize = $this->_folder_size($var . 'webroot/files');
        $uploadSize = $this->_format_file_size($uploadSize[0]);
        $this->set('uploadSize', $uploadSize);


        $this->loadModel('SuggestionForm');

        if ($this->Session->read('User.is_mr') != 1) {
            $this->loadModel('Company');
            $companyMessage = $this->Company->find('first', array('fields' => array('description', 'welcome_message', 'quality_policy', 'mission_statement', 'vision_statement'), 'recursive' => -1));
            if ($companyMessage)
                $this->set('companyMessage', $companyMessage);
            else
                $this->set('companyMessage', null);
        }else {
            $this->set('companyMessage', null);
        }


        $this->_meeting_details_reminder();
        $this->_get_data_entry();
        if (file_exists(WWW_ROOT . "files/" . $this->Session->read('User.company_id') . "/rediness.txt")) {
             $file = new File(WWW_ROOT . "files/" . $this->Session->read('User.company_id') . "/rediness.txt");
             $readiness = $file->read();
        }
    }

    public function branches_gauge($newDate = null) {
        $PublishedDepartmentList = $this->_get_department_list();
        $record_found =0;
        foreach ($PublishedDepartmentList as $key => $value):
            $file = new File(WWW_ROOT . "files" . DS . $this->Session->read('User.company_id') . DS . "graphs" . DS . $newDate . DS . "departments" . DS . $key . DS . "gauge" . DS . $key . ".txt");
                if (file_exists($file->path)) {
                    $record_found = 1;
                }
        endforeach;
        $this->set(compact('newDate','record_found'));
        $this->render('/Elements/branches_gauge');
    }
    public function _folder_size($dir) {

        $countSize = 0;
        $count = 0;
        $dirArray = scandir($dir);
        foreach ($dirArray as $key => $fileName) {
            if ($fileName != ".." && $fileName != ".") {
                if (is_dir($dir . "/" . $fileName)) {
                    $newFolderSize = $this->_folder_size($dir . "/" . $fileName);
                    $countSize = $countSize + $newFolderSize[0];
                    $count = $count + $newFolderSize[1];
                } else if (is_file($dir . "/" . $fileName)) {
                    $countSize = $countSize + filesize($dir . "/" . $fileName);
                    $count++;
                }
            }
        }

        return array($countSize, $count);
    }

    public function user_access($id = null) {

        $this->User->recursive = 0;
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }

        $allControllers = $this->Ctrl->get();
        $otherControllers = array();
        $otherControllers['MR'] = array('change_addition_deletion_requests', 'document_amendment_record_sheets', 'meetings', 'internal_audits', 'internal_audit_plans', 'corrective_preventive_actions', 'capa_categories', 'capa_sources', 'tasks', 'benchmarks');
        $otherControllers['HR'] = array('training_need_identifications', 'courses', 'course_types', 'training_evaluations', 'competency_mappings', 'trainings', 'trainers', 'trainer_types', 'appraisals','appraisal_questions');
        $otherControllers['BD'] = array('customer_meetings', 'proposals', 'proposal_followups');
        $otherControllers['Purchase'] = array('supplier_registrations', 'supplier_categories', 'list_of_acceptable_suppliers', 'supplier_evaluation_reevaluations', 'summery_of_supplier_evaluations', 'delivery_challans', 'purchase_orders');
        $otherControllers['Admin'] = array('fire_extinguishers', 'housekeeping_checklists', 'housekeeping_responsibilities', 'fire_extinguisher_types');
        $otherControllers['Quality Control'] = array('customer_complaints', 'list_of_measuring_devices_for_calibrations', 'calibrations', 'customer_feedbacks', 'customer_feedback_questions','material_quality_checks','device_maintenances');
        $otherControllers['EDP'] = array('username_password_details', 'list_of_computers', 'list_of_softwares', 'list_of_computer_list_of_softwares', 'databackup_logbooks', 'daily_backup_details', 'data_back_ups');
        $otherControllers['Production'] = array('materials', 'productions', 'stocks');
        $otherControllers['Data Entry'] = array('branches', 'departments', 'designations', 'employees', 'users', 'products', 'devices', 'customers', 'software_types', 'training_types');

        $this->loadModel('MasterListOfFormatDepartment');
        foreach ($otherControllers as $key => $controllers):
            foreach ($controllers as $controller):
                $getActions = Inflector::camelize($controller) . 'Controller';
                if (isset($allControllers[$getActions]) && (!in_array("delete", $allControllers[$getActions]))) {
                    $allControllers[$getActions][] = 'delete';
                }
                $deptWise[$key][$controller]['actions'] = $allControllers[$getActions];
            endforeach;
        endforeach;

        $this->set('forms', $deptWise);
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->User->read(null, $id);
            //Default access
            $dashboard['mr'] = 1;
            $dashboard['hr'] = 1;
            $dashboard['bd'] = 1;
            $dashboard['production'] = 1;
            $dashboard['personal_admin'] = 1;
            $dashboard['quality_control'] = 1;
            $dashboard['edp'] = 1;
            $dashboard['purchase'] = 1;
            $this->request->data['ACL']['user_access']['dashboards'] = $dashboard;

            $error['error500'] = 1;
            $error['error404'] = 1;
            $this->request->data['ACL']['user_access']['errors'] = $error;

            $help['view'] = 1;
            $help['edit'] = 1;
            $help['help'] = 1;
            $this->request->data['ACL']['user_access']['helps'] = $help;

            $MessageUserSents['index'] = 1;
            $MessageUserSents['view'] = 1;
            $MessageUserSents['add'] = 1;
            $MessageUserSents['edit'] = 1;
            $MessageUserSents['delete'] = 1;
            $MessageUserSents['delete_all'] = 1;
            $this->request->data['ACL']['user_access']['message_user_sents'] = $MessageUserSents;

            $MessageUserThrashes['index'] = 1;
            $MessageUserThrashes['view'] = 1;
            $MessageUserThrashes['add'] = 1;
            $MessageUserThrashes['edit'] = 1;
            $MessageUserThrashes['delete'] = 1;
            $MessageUserThrashes['delete_all'] = 1;
            $this->request->data['ACL']['user_access']['message_user_thrashes'] = $MessageUserThrashes;


            $Messages['inbox'] = 1;
            $Messages['sent'] = 1;
            $Messages['trash'] = 1;
            $Messages['reply'] = 1;
            $Messages['index'] = 1;
            $Messages['view'] = 1;
            $Messages['add'] = 1;
            $Messages['edit'] = 1;
            $Messages['delete'] = 1;
            $Messages['delete_all'] = 1;
            $this->request->data['ACL']['user_access']['messages'] = $Messages;

            $NotificationUsers['display_notifications_initial'] = 1;
            $NotificationUsers['display_notifications'] = 1;
            $this->request->data['ACL']['user_access']['notification_users'] = $NotificationUsers;

            $Notifications['box'] = 1;
            $Notifications['search'] = 1;
            $Notifications['advanced_search'] = 1;
            $Notifications['lists'] = 1;
            $Notifications['index'] = 1;
            $Notifications['view'] = 1;
            $Notifications['add_ajax'] = 0;
            $Notifications['edit'] = 0;
            $Notifications['delete'] = 1;
            $Notifications['delete_all'] = 1;
            $this->request->data['ACL']['user_access']['notifications'] = $Notifications;

            $SuggestionForms['box'] = 1;
            $SuggestionForms['search'] = 1;
            $SuggestionForms['advanced_search'] = 1;
            $SuggestionForms['lists'] = 1;
            $SuggestionForms['index'] = 1;
            $SuggestionForms['view'] = 1;
            $SuggestionForms['add_ajax'] = 1;
            $SuggestionForms['edit'] = 1;
	        $SuggestionForms['delete'] = 1;
            $SuggestionForms['delete_all'] = 1;

            $this->request->data['ACL']['user_access']['suggestion_forms'] = $SuggestionForms;


            $this->request->data['ACL']['user_access']['users']['reset_password'] = 1;
            $this->request->data['ACL']['user_access']['users']['save_user_password'] = 1;
            $this->request->data['ACL']['user_access']['users']['login'] = 1;
            $this->request->data['ACL']['user_access']['users']['logout'] = 1;
            $this->request->data['ACL']['user_access']['users']['dashboard'] = 1;
            $this->request->data['ACL']['user_access']['users']['access_denied'] = 1;
            $this->request->data['ACL']['user_access']['users']['terms_and_conditions'] = 1;
            $this->request->data['ACL']['user_access']['users']['branches_gauge'] = 1;
            $this->request->data['ACL']['user_access']['users']['change_password'] = 1;
            $this->request->data['ACL']['user_access']['users']['check_email'] = 1;
            $this->request->data['ACL']['user_access']['users']['activate'] = 1;
            $this->request->data['ACL']['user_access']['users']['unblock_user'] = 1;
            $this->request->data['ACL']['user_access']['users']['register'] = 1;
            $this->request->data['ACL']['user_access']['users']['welcome'] = 1;
            $this->request->data['ACL']['user_access']['tasks']['get_task'] = 1;
            $this->request->data['ACL']['user_access']['productions']['get_batch'] = 1;

            $this->request->data['ACL']['user_access']['appraisals']['appraisal_notification_email'] = 1;
            $this->request->data['ACL']['user_access']['appraisals']['appraisal_review'] = 1;
            $this->request->data['ACL']['user_access']['appraisals']['self_appraisals'] = 1;

            $this->request->data['ACL']['user_access']['internal_audit_plans']['get_dept_clauses'] = 1;
            $this->request->data['ACL']['user_access']['branches']['get_branch_name'] = 1;
            $this->request->data['ACL']['user_access']['internal_audits']['send_email'] = 1;
            $this->request->data['ACL']['user_access']['internal_audits']['audit_details_add_ajax'] = 1;
            $this->request->data['ACL']['user_access']['internal_audit_plans']['add_branches'] = 1;
            $this->request->data['ACL']['user_access']['internal_audit_plans']['add_departments'] = 1;
            $this->request->data['ACL']['user_access']['meetings']['add_after_meeting_topics'] = 1;
            $this->request->data['ACL']['user_access']['meetings']['meeting_view'] = 1;



            $this->request->data['ACL']['user_access']['customers']['get_unique_values'] = 1;
            $this->request->data['ACL']['user_access']['customer_complaints']['get_customer_complaints'] = 1;
            $this->request->data['ACL']['user_access']['customer_complaints']['check_complaint_number'] = 1;
            $this->request->data['ACL']['user_access']['customer_meetings']['followup_count'] = 1;
            $this->request->data['ACL']['user_access']['proposal_followups']['followup_count'] = 1;
            $this->request->data['ACL']['user_access']['dashboards']['result_mapping'] = 1;


            if( $this->request->data['ACL']['user_access']['customer_meetings']['add_ajax'] == 1 || $this->request->data['ACL']['user_access']['customer_meetings']['edit'] == 1)
               $this->request->data['ACL']['user_access']['customer_meetings']['add_followups'] = 1;
            else
               $this->request->data['ACL']['user_access']['customer_meetings']['add_followups'] = 0;
               $this->request->data['ACL']['user_access']['calibrations']['get_details'] = 1;
               $this->request->data['ACL']['user_access']['customer_complaints']['customer_complaint_status'] = 1;
               $this->request->data['ACL']['user_access']['trainings']['get_details'] = 1;
               $this->request->data['ACL']['user_access']['corrective_preventive_actions']['get_details'] = 1;
               $this->request->data['ACL']['user_access']['supplier_registrations']['get_supplier_registration_title'] = 1;
               $this->request->data['ACL']['user_access']['employees']['get_employee_email'] = 1;
                $this->request->data['ACL']['user_access']['materials']['get_material_name'] = 1;
                $this->request->data['ACL']['user_access']['materials']['get_material_qc_required'] = 1;
                $this->request->data['ACL']['user_access']['materials']['get_purchase_order_number'] = 1;
                $this->request->data['ACL']['user_access']['purchase_orders']['add_purchase_order_details'] = 1;
                $this->request->data['ACL']['user_access']['purchase_orders']['get_purchase_order_number'] = 1;
                $this->request->data['ACL']['user_access']['list_of_computers']['add_new_software'] = 1;
                $this->request->data['ACL']['user_access']['appraisals']['add_questions'] = 1;
                $this->request->data['ACL']['user_access']['device_maintenances']['get_device_maintainance'] = 1;
                $this->request->data['ACL']['user_access']['calibrations']['get_next_calibration'] = 1;
                   $this->request->data['ACL']['user_access']['material_quality_checks']['get_process'] = 1;
                   $this->request->data['ACL']['user_access']['material_quality_checks']['get_material_check'] = 1;
                   $this->request->data['ACL']['user_access']['material_quality_checks']['material_count'] = 1;
               $this->request->data['ACL']['user_access']['stocks']['get_material'] = 1;
               $this->request->data['ACL']['user_access']['stocks']['get_material_details'] = 1;
               $this->request->data['ACL']['user_access']['stocks']['get_dc_details'] = 1;
            if( $this->request->data['ACL']['user_access']['supplier_evaluation_reevaluations']['evaluate'] == 1 ){
               $this->request->data['ACL']['user_access']['supplier_evaluation_reevaluations']['get_supplier_list'] = 1;
               $this->request->data['ACL']['user_access']['supplier_evaluation_reevaluations']['index'] = 1;
               $this->request->data['ACL']['user_access']['supplier_evaluation_reevaluations']['view'] = 1;
            }else{
               $this->request->data['ACL']['user_access']['supplier_evaluation_reevaluations']['get_supplier_list'] = 0;
            }
               $this->request->data['ACL']['user_access']['delivery_challans']['get_purchase_order'] = 1;
               $this->request->data['ACL']['user_access']['delivery_challans']['get_challan_details'] = 1;
               $this->request->data['ACL']['user_access']['delivery_challans']['get_challan_number'] = 1;
               $this->request->data['ACL']['user_access']['delivery_challans']['get_delivered_material_qc'] = 1;
            $data['User']['user_access'] = json_encode($this->request->data['ACL']);

            if ($this->User->save($data, false)) {
                $this->Session->setFlash(__('Saved', true));
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__('Not Saved', true));
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
            $newData = json_decode($this->request->data['User']['user_access'], true);
            $this->request->data['ACL'] = $newData;
        }
    }

    public function access_denied() {

    }

    /**
     * restore method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function _meeting_details_reminder() {
        $preMeetingAlert = null;
        $postMeetingAlert = null;
        $from = date('Y-m-d 00:00:00');
        $to = date("Y-m-d 00:00:00", strtotime("+5 days", strtotime($from)));

        $this->loadModel('MeetingEmployee');
        $this->MeetingEmployee->recursive = 0;
        $nearest_meeting = $this->MeetingEmployee->find('first', array(
            'conditions' => array(
                'MeetingEmployee.employee_id' => $this->Session->read('User.employee_id'),
                'Meeting.publish' => 1, 'Meeting.soft_delete' => 0,
                'Meeting.scheduled_meeting_from BETWEEN ? AND ? ' => array($from, $to)
            ),
            'fields' => array('Meeting.id', 'MeetingEmployee.employee_id', 'Meeting.scheduled_meeting_from', 'Meeting.publish', 'Meeting.soft_delete')
        ));
        if ($nearest_meeting) {
            $preMeetingAlert = __('You have a meeting scheduled on ') . $nearest_meeting['Meeting']['scheduled_meeting_from'];
            $this->set(array('meeting_id' => $nearest_meeting['Meeting']['id']));
        }

        $postMeeting = $this->MeetingEmployee->find('first', array(
            'conditions' => array('Meeting.publish' => 1, 'Meeting.soft_delete' => 0,
                'Meeting.scheduled_meeting_from >'=> $from,'Meeting.actual_meeting_from' => NULL,
                'MeetingEmployee.employee_id' => $this->Session->read('User.employee_id')
            ),
            'fields' => array('Meeting.id', 'MeetingEmployee.employee_id', 'Meeting.scheduled_meeting_from', 'Meeting.publish', 'Meeting.soft_delete')
        ));

        if ($postMeeting) {
            $postMeetingAlert = "Please add meeting details for the recent meeting";
            $this->set(array('meeting_id' => $postMeeting['Meeting']['id']));
        }

        $this->set(array('preMeetingAlert' => $preMeetingAlert, 'postMeetingAlert' => $postMeetingAlert));
    }

    public function terms_and_conditions() {

        if ($this->request->is('post')) {

            $this->Session->write('TANDC', 0);

            $data = $this->User->read(null, $this->Session->read('User.id'));
            $data['User']['agree'] = 0;
            $this->User->save($data, false);

            $this->loadModel('MasterListOfFormat');
            $checkForms = $this->MasterListOfFormat->find('count', array('conditions' => array('MasterListOfFormat.company_id' => $this->Session->read('User.company_id'))));

            if (isset($checkForms) && ($checkForms > 0))
                $this->redirect(array('action' => 'dashboard'));
            else
                $this->redirect(array('action' => 'welcome'));
        }
    }

    public function _get_data_entry() {
        $this->loadModel('Benchmark');
        $this->Benchmark->recursive = -1;

        $this->loadModel('History');
        $this->History->recursive = -1;

        $this->loadModel('Company');
        $this->Company->recursive = -1;

        // get daily benchmark
        $benchmarks = $this->Benchmark->find('all', array(
            'conditions' => array('Benchmark.benchmark >' => 0,'Benchmark.branch_id'=>  $this->Session->read('User.branch_id')),
            'fields' => array('sum(Benchmark.benchmark) as total_sum')
        ));
        $total = $this->History->find('count', array('conditions' =>
            array('History.company_id' => $this->Session->read('User.company_id'), $this->common_condition)
        ));
        $getStartDate = $this->Company->find('first', array('fields' => 'flinkiso_start_date'));
        $StartDate = new DateTime($getStartDate['Company']['flinkiso_start_date']);
        $endDate = new DateTime(date('Y-m-d'));
        $dateDiff = $StartDate->diff($endDate);
        $days = $dateDiff->format('%d');
        if ($days > 0  &&  (isset($benchmarks[0][0]['total_sum']))) {
            if($total > $benchmarks[0][0]['total_sum']){
                $avg = 100;    
            }else{
                $avg = ($total *100)/ ($dateDiff->days * $benchmarks[0][0]['total_sum']);
            }
        } else {
            $avg = 0;
        }
        $this->set(array('avg' => $avg, 'benchmark' => $benchmarks[0][0]['total_sum']));
    }

    public function change_password() {

        if ($this->request->is('post')) {
            $userData = $this->User->find('first', array('conditions' => array('id' => $this->Session->read('User.id')), 'recursive' => -1));
            if ($userData['User']['password'] == Security::hash($this->request->data['User']['current_password'],'md5',true)) {
                $newData = array();
                $newData['User']['id'] = $userData['User']['id'];
                $newData['User']['password'] = Security::hash($this->request->data['User']['new_password'],'md5',true);
                if ($this->User->save($newData, false)) {
                    $this->Session->setFlash(__('Your password has been change'));
                    $this->redirect(array('action' => 'dashboard'));
                }
            } else {
                $this->Session->setFlash(__('Your current password does not match with the password you have entered. please try again.'));
                $this->redirect(array('action' => 'change_password'));
            }
        }
    }

    public function register($downloadkey = NULL){
        if ($this->request->data) {
            //create Company
            $description = '<p>FlinkISO is a web based application (available as SAAS as well as On-site) which automates the entire ISO documentation process and facilitates customers to electronically store &amp;
					maintain all the relevant documents, quality &amp; procedure manuals and data at single source on cloud. From this extensive information,
					system can generate &ldquo;eye to detail reports&rdquo;, YOY performance analysis for the management to gauge, scale the organization growth and productivity,
					and move forward to take corrective actions. Product is divided into 3 categories viz. Standard, Enterprise &amp; SAAS and will be released over a period of 3 years.
					This categorization will help to serve needs of 3 types of enterprises Micro, Small and Medium.</p>';

            $welcomeMessage = '<p>TECHMENTIS GLOBAL SERVICES PVT. LTD offers an array of web business solutions through e-commerce, B2B, B2C and mobile applications.
			Our young and dynamic team not only thrives to create and innovate, but also focuses on building a sustainable business model which enables our clients to remain
			competitive and profitable in the versatile global market.</p>';

            $company['Company']['name'] = $this->request->data['User']['company'];
            $company['Company']['sample_data'] = $this->request->data['User']['sample_data'];
            $company['Company']['description'] = $description;
            $company['Company']['welcome_message'] = $welcomeMessage;
            $company['Company']['number_of_branches'] = 1;
            $company['Company']['limit_login_attempt'] = 100;
            $company['Company']['flinkiso_start_date'] = date('Y-m-d');
            $company['Company']['flinkiso_end_date'] = date('Y-m-d', strtotime('+5 years'));
            $company['Company']['publish'] = 1;
            $company['Company']['soft_delete'] = 0;
            $company['Company']['branchid'] = '0';
            $company['Company']['departmentid'] = '0';
            $company['Company']['created_by'] = '0';
            $company['Company']['modified_by'] = '0';
            $company['Company']['created'] = date('Y-m-d h:i:s');
            $company['Company']['created'] = date('Y-m-d h:i:s');
            $company['Company']['liscence_key'] = $this->request->data['User']['liscence_key_installed'];
            $this->loadModel('Company');
            $this->Company->create();

            //check if company exist
            $companyFind = $this->Company->find('first', array('conditions' => array('Company.name' => $this->request->data['User']['company']),'recursive'=>-1));
            if ($companyFind) {
                $companyId = $companyFind['Company']['id'];
                $alreadyExists = true;
            } else {
                if (($this->Company->save($company,false))) {
                    $companyId = $this->Company->id;
                    $alreadyExists = false;
                }
            }

            if ($companyId != null) {
                $branch_name = $this->request->data['User']['city'] ? $this->request->data['User']['city'] : 'Default' ;
                $branch['Branch']['name'] = $branch_name;
                $branch['Branch']['publish'] = 1;
                $branch['Branch']['soft_delete'] = 0;
				$branch['Branch']['branchid'] = '0';
				$branch['Branch']['departmentid'] = '0';
				$branch['Branch']['created_by'] = '0';
				$branch['Branch']['modified_by'] = '0';
				$branch['Branch']['created'] = date('Y-m-d h:i:s');
				$branch['Branch']['created'] = date('Y-m-d h:i:s');
                $this->loadModel('Branch');

                $findBranch = $this->Branch->find('first', array('conditions' => array('Branch.name' => $branch_name, 'Branch.company_id' => $companyId)));
                if ($findBranch) {
                    $branchId = $findBranch['Branch']['id'];
                } else {
                    $this->Branch->create();
                    if ($this->Branch->save($branch,false)) {
                        $branchId = $this->Branch->id;
                    }
                }

                if ($branchId != null) {

                    $defaultDepartment = Configure::read('department');
                    $department =  $this->User->Department->find('first', array('conditions'=>array('name'=>$defaultDepartment), 'fields'=>array('id'),'recursive'=>-1));

                    $this->loadModel('Designation');
                    $defaultDesignation = Configure::read('designation');
                    $designation =  $this->Designation->find('first', array('conditions'=>array('name'=>$defaultDesignation), 'fields'=>array('id'),'recursive'=>-1));

                    $defaultLanguage= Configure::read('language');
                    $language =  $this->User->Language->find('first', array('conditions'=>array('name'=>$defaultLanguage), 'fields'=>array('id'),'recursive'=>-1));





                    $this->loadModel('Employee');
                    $employeeCount = $this->Employee->find('count', array('conditions' => array('Employee.company_id' => $companyId)));


                    $employee['Employee']['name'] = $this->request->data['User']['name'];
                    $employee['Employee']['employee_number'] = substr(strtoupper($this->request->data['User']['company']), 0, 3) . '00' . ($employeeCount + 1);
                    $employee['Employee']['branch_id'] = $branchId;
                    $employee['Employee']['designation_id'] = $designation['Designation']['id'];
                    $employee['Employee']['company_id'] = $companyId;
                    $employee['Employee']['joining_date'] = date('Y-m-d');
                    $employee['Employee']['publish'] = 1;
                    $employee['Employee']['soft_delete'] = 0;
                    $employee['Employee']['personal_telephone'] = $this->request->data['User']['phone'];
                    $employee['Employee']['office_telephone'] = $this->request->data['User']['phone'];
                    $employee['Employee']['mobile'] = $this->request->data['User']['phone'];
                    $employee['Employee']['personal_email'] = $this->request->data['User']['email'];
                    $employee['Employee']['office_email'] = $this->request->data['User']['email'];
                    $employee['Employee']['branchid'] = '0';
                    $employee['Employee']['departmentid'] = '0';
                    $employee['Employee']['created_by'] = '0';
                    $employee['Employee']['modified_by'] = '0';
                    $employee['Employee']['created'] = date('Y-m-d h:i:s');
                    $employee['Employee']['created'] = date('Y-m-d h:i:s');

                    $employee['Employee']['system_table_id'] = '5297b2e7-959c-4892-b073-2d8f0a000005';
                    $employee['Employee']['master_list_of_format_id'] = '523ab4b6-cf7c-4de5-918b-6f22c6c3268c';


                    $this->Employee->create();
                    if ($this->Employee->save($employee,false)) {

                        //create User
                        $encrypt = $this->User->generateToken();
                        $user['User']['employee_id'] = $this->Employee->id;
                        $user['User']['company_id'] = $companyId;
                        $user['User']['name'] = $this->request->data['User']['name'];
                        $user['User']['username'] = $this->request->data['User']['email'];
                        $user['User']['password'] = Security::hash($this->request->data['User']['password'],'md5',true);
                        $user['User']['is_mr'] = true;
                        $user['User']['is_view_all'] = true;
                        $user['User']['is_approvar'] = true;
                        $user['User']['status'] = 1;
                        $user['User']['agree'] = 1;
                        $user['User']['department_id'] = $department['Department']['id'];
                        $user['User']['branch_id'] = $branchId;
                        $user['User']['language_id'] = $language['Language']['id'];
                        $user['User']['publish'] = 1;
                        $user['User']['soft_delete'] = 0;
                        $user['User']['master_list_of_format_id'] = '523ae34c-bcc0-4c7d-b7aa-75cec6c3268c';
                        $user['User']['system_table_id'] = '5297b2e7-0a9c-46e3-96a6-2d8f0a000005';
                        $user['User']['allow_multiple_login'] = 1;
                        $user['User']['password_token'] = $encrypt;
            			$user['User']['branchid'] = '0';
            			$user['User']['departmentid'] = '0';
            			$user['User']['created_by'] = '0';
            			$user['User']['modified_by'] = '0';
            			$user['User']['created'] = date('Y-m-d h:i:s');
            			$user['User']['created'] = date('Y-m-d h:i:s');
                                    $user['User']['last_login'] = date('Y-m-d H:i:s');
            			$user['User']['last_activity'] = date('Y-m-d H:i:s');
            			$user['User']['copy_acl_from'] = '';
            			$user['User']['user_access'] = $this->Ctrl->get_defaults();
                        $this->User->create();

                        if ($this->User->save($user, false)) {


                            $data = null;
                            $data['Employee']['id'] = $this->Employee->id;
                            $data['Employee']['branch_id'] = $branchId;
                            $data['Employee']['department_id'] = $department['Department']['id'];
                            $data['Employee']['created_by'] = $this->User->id;
                            $data['Employee']['company_id'] = $companyId;
                            $this->Employee->save($data, false);

                            $data = null;

                            $data['Branch']['id'] = $branchId;
                            $data['Branch']['branchid'] = $branchId;
                            $data['Branch']['created_by'] = $this->User->id;
                            $data['Branch']['company_id'] = $companyId;
                            $this->Branch->save($data, false);

                            $data = null;
                            $data['User']['id'] = $this->User->id;
                            $data['User']['created_by'] = $this->User->id;
                            $data['User']['company_id'] = $companyId;
                            $this->User->save($data, false);

                            $data = null;
                            $data['Company']['id'] = $companyId;
                            $data['Company']['created_by'] = $this->User->id;
                            $data['Company']['company_id'] = $companyId;
                            $this->Company->save($data, false);


                            $url = "https://www.flinkiso.com/user_registration.php";
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url );
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE );
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE );
                            curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE );
                            curl_setopt($ch, CURLOPT_HEADER, TRUE );
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array("User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:31.0) Gecko/20100101 Firefox/31.0"));
                            $postfields = array();
                            $postfields['name'] = urlencode($this->request->data['User']['name']);
                            $postfields['username'] = urlencode($this->request->data['User']['email']);
                            $postfields['company'] = urlencode($this->request->data['User']['company']);
                            $postfields['password'] = urlencode($this->request->data['User']['password']);
                            $postfields['email'] = urlencode($this->request->data['User']['email']);
                            $postfields['phone'] = urlencode($this->request->data['User']['phone']);
                            $postfields['city'] = urlencode($this->request->data['User']['city']);
                            $postfields['state'] = urlencode($this->request->data['User']['state']);
                            $postfields['country'] = urlencode($this->request->data['User']['country']);
			                $postfields['download_key'] = urlencode($this->request->data['User']['liscence_key_installed']);
                            $postfields['seccheck'] = urlencode(md5($this->request->data['User']['name'] . 'FlinkISO' . $this->request->data['User']['email']));

                            curl_setopt($ch, CURLOPT_POST, count($postfields));
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
                            $ret = curl_exec($ch);
                            
                            curl_close($ch);

                            if($ret){
                                    $data = null;
                                    $data['Employee']['id'] = $this->Employee->id;
                                    $data['Employee']['registered'] = 1;
                                    $this->Employee->save($data, false);
                            }
                            if($this->request->data['User']['sample_data'] == 1){
                                $this->insert_sample_data();
                                $this->_update_sql($companyId);
                            }
            			    $this->Session->setFlash(__('Account created'));
            			    file_put_contents(APP.'Config/installed.txt', date('Y-m-d, H:i:s'));
            			    unlink(APP.'Config/installed_db.txt');
                            $this->redirect(array('action' => 'activate',$encrypt));


                        } else {
                            $this->Session->setFlash(__('Failed to create account. Error while creating user'), 'default', array('class'=>'alert-danger'));
                            $this->redirect(array('action' => 'register'));
                        }
                    } else {
                        $this->Session->setFlash(__('Failed to create account. Error while creating employee'), 'default', array('class'=>'alert-danger'));
                        $this->redirect(array('action' => 'register'));
                    }
                } else {
                    $this->Session->setFlash(__('Failed to create account. Error while creating branch'), 'default', array('class'=>'alert-danger'));
                    $this->redirect(array('action' => 'register'));
                }
            } else {
                $this->Session->setFlash(__('Failed to create account. Error while creating company'), 'default', array('class'=>'alert-danger'));
                $this->redirect(array('action' => 'register'));
            }

        }
        $this->layout = 'login';
    }

    public function activate($encrypt = null) {
        $user = $this->User->find('first', array('conditions' => array('User.password_token' => $encrypt)));
        if ($user) {
            $this->User->read(null, $user['User']['id']);
            $data['User']['status'] = 1;
            $data['User']['publish'] = 1;
            $data['User']['soft_delete'] = 0;
            $data['User']['password_token'] = null;
            $this->User->save($data, false);

            //create company directory
            $dir = WWW_ROOT . DS . 'files' . DS . $user['User']['company_id'];
            mkdir($dir, 0777, true);

            $dir = WWW_ROOT . DS . 'files' . DS . $user['User']['company_id'] . DS . 'SavedReports';
            mkdir($dir, 0777, true);

            $dir = WWW_ROOT . DS . 'files' . DS . $user['User']['company_id'] . DS . 'uploads';
            mkdir($dir, 0777, true);
            $this->set('user',$user);
            $this->Session->setFlash(__('Congratulations, your account is activated'), 'default', array('class'=>'alert-success'));
            $this->redirect(array('action' => 'smtp_details',base64_encode($user['User']['username'])));
        } else {
            $this->Session->setFlash(__('Can not activate account. Please contact us at +91 9769 866 441 for help'), 'default', array('class'=>'alert-danger'));
            $this->redirect(array('action' => 'register'));
        }
    }

    public function check_email($email = null) {
        $this->layout = 'ajax';
        $resultEmployee = $this->User->Employee->find('count', array('recursive' => 0, 'fields' => array('Employee.office_email'), 'conditions' => array('Employee.office_email' => $email)));
        $resultUser = $this->User->find('count', array('conditions' => array('User.username' => $email)));
        if ($resultEmployee != 0 || $resultUser != 0)
            $this->set('email_response', 'Email / Username already exists. Please select different email');
        else
            return false;
    }

    public function check_username($username = null) {
        $this->layout = 'ajax';
        $resultUsername = $this->User->find('count', array('recursive' => -1, 'conditions' => array('User.username' => $username)));
        if ($resultUsername != 0)
            $this->set('username_response', 'Username already exists. Please enter a different username');
        else
            return false;
    }

    public function add_formats($timeline = null) {

        $this->loadModel('MasterListOfFormat');
        $this->loadModel('MasterListOfFormatDepartment');
        $this->loadModel('MasterListOfFormatBranch');
        $this->Session->write('show_all_formats', true);

        $allDepartments = $this->_get_department_list();
            foreach ($allDepartments as $key => $value):
                $formatDetails = $this->MasterListOfFormatDepartment->find('all', array(
                    'conditions' => array(
                        'MasterListOfFormatDepartment.department_id' => $key,
                        'MasterListOfFormatDepartment.company_id' => null
                    ),
                    'recursive' => 0,
                    'fields' => array(
                        'MasterListOfFormat.id',
                        'MasterListOfFormat.title',
                        'MasterListOfFormat.document_number',
                        'MasterListOfFormat.revision_number',
                        'MasterListOfFormat.issue_number',
                        'MasterListOfFormat.system_table_id',
                        'MasterListOfFormatDepartment.department_id',
                        'MasterListOfFormatDepartment.id'
                    )
                        )
                );
                $allFormats[$value] = $formatDetails;

            endforeach;
            $this->loadModel('Company');
            $companyDetails = $this->Company->find('first',array('conditions'=>array('Company.id'=>$this->Session->read('User.company_id')), 'fields'=>'name'));

            $date =  date('Y-m-d');
            $i = 0;
            $newFormats = array();
            foreach($allFormats as $key=>$value):
                $j = 1;
                foreach ($value as $allFormat):

                    $newFormats[$i]['MasterListOfFormat']['title'] = $allFormat['MasterListOfFormat']['title'];
                    $newFormats[$i]['MasterListOfFormat']['prepared_by'] = $this->Session->read('User.employee_id');
                    $newFormats[$i]['MasterListOfFormat']['approved_by'] = $this->Session->read('User.employee_id');
                    $newFormats[$i]['MasterListOfFormat']['document_number'] = substr(strtoupper($companyDetails['Company']['name']), 0, 2) . substr(strtoupper($key), 0, 2) . str_pad($j, 4, 0, STR_PAD_LEFT);//$allFormat['MasterListOfFormat']['document_number'];
                    $newFormats[$i]['MasterListOfFormat']['issue_number'] = str_pad($allFormat['MasterListOfFormat']['issue_number'],2,0, STR_PAD_LEFT);
                    $newFormats[$i]['MasterListOfFormat']['revision_number'] = str_pad($allFormat['MasterListOfFormat']['revision_number'],2,0, STR_PAD_LEFT);
                    $newFormats[$i]['MasterListOfFormat']['revision_date'] = $date;
                    $newFormats[$i]['MasterListOfFormat']['company_id'] = $this->Session->read('User.company_id');
                    $newFormats[$i]['MasterListOfFormat']['system_table_id'] = $allFormat['MasterListOfFormat']['system_table_id'];

                    $newFormats[$i]['MasterListOfFormatDepartment']['department_id'] = $allFormat['MasterListOfFormatDepartment']['department_id'];
                    $newFormats[$i]['MasterListOfFormatBranch']['branch_id'] = $this->Session->read('User.branch_id');
                    $i++; $j++;
                endforeach;
            endforeach;
            foreach ($newFormats as $newFormat):
                //add to masterlist of formats
                $newFormat['MasterListOfFormat']['publish'] = 1;
                $newFormat['MasterListOfFormat']['soft_delete'] = 0;
                $this->MasterListOfFormat->create();
                $this->MasterListOfFormat->save($newFormat['MasterListOfFormat'], false);
                foreach($newFormat['MasterListOfFormatDepartment'] as $department):
                    $newFormat['MasterListOfFormatDepartment']['department_id'] = $department;
                    $newFormat['MasterListOfFormatDepartment']['master_list_of_format_id'] = $this->MasterListOfFormat->id;
                    $newFormat['MasterListOfFormatDepartment']['prepared_by'] = $newFormat['MasterListOfFormat']['prepared_by'];
                    $newFormat['MasterListOfFormatDepartment']['approved_by'] = $newFormat['MasterListOfFormat']['approved_by'];
                    $newFormat['MasterListOfFormatDepartment']['publish'] = 1;
                    $newFormat['MasterListOfFormatDepartment']['soft_delete'] = 0;
                    $newFormat['MasterListOfFormatDepartment']['system_table_id'] = $newFormat['MasterListOfFormat']['system_table_id'];
                    $newFormat['MasterListOfFormatDepartment']['company_id'] = $this->Session->read('User.company_id');
                    $this->MasterListOfFormatDepartment->create();
                    $this->MasterListOfFormatDepartment->save($newFormat['MasterListOfFormatDepartment'], false);
                endforeach;

				foreach($newFormat['MasterListOfFormatBranch'] as $branch):
                    $newFormat['MasterListOfFormatBranch']['branch_id'] = $branch;
                    $newFormat['MasterListOfFormatBranch']['master_list_of_format_id'] = $this->MasterListOfFormat->id;
                    $newFormat['MasterListOfFormatBranch']['prepared_by'] = $newFormat['MasterListOfFormat']['prepared_by'];
					  $newFormat['MasterListOfFormatBranch']['approved_by'] = $newFormat['MasterListOfFormat']['approved_by'];
                    $newFormat['MasterListOfFormatBranch']['publish'] = 1;
                    $newFormat['MasterListOfFormatBranch']['soft_delete'] = 0;
                    $newFormat['MasterListOfFormatBranch']['system_table_id'] = $newFormat['MasterListOfFormat']['system_table_id'];
                    $newFormat['MasterListOfFormatBranch']['company_id'] = $this->Session->read('User.company_id');
                    $this->MasterListOfFormatBranch->create();
                    $this->MasterListOfFormatBranch->save($newFormat['MasterListOfFormatBranch'], false);
                endforeach;


            endforeach;

            $this->Session->write('show_all_formats', false);
            if ($timeline == 1)
                $this->_add_timeline();
            $this->_add_trainings();
            $this->Session->setFlash(__('Formats saved.'));
            $this->redirect(array('action' => 'dashboard'));
       }

    public function _add_timeline() {
        $this->Session->write('show_all_formats', false);
        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => 'timelines')));

        $this->loadModel('Timeline');
        $this->Timeline->create();
        $timeline = array();
        $timeline['title'] = 'FlinkISO Start Date';
        $timeline['message'] = 'Welcome to FlinkISO. You free subscribtion starts today !';
        $timeline['start_date'] = date('Y-m-d');
        $timeline['end_date'] = date('Y-m-d');
        $timeline['publish'] = 1;
        $timeline['soft_delete'] = 0;
        $timeline['company_id'] = $this->Session->read('User.company_id');
        $timeline['prepared_by'] = $this->Session->read('User.id');
        $timeline['approved_by'] = $this->Session->read('User.id');
        $timeline['system_table_id'] = $systemTableId['SystemTable']['id'];
        $this->Timeline->save($timeline);

	$systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => 'list_of_trained_internal_auditors')));
        $this->loadModel('ListOfTrainedInternalAuditor');
        $formatId = $this->ListOfTrainedInternalAuditor->MasterListOfFormat->find('first', array('conditions' => array('MasterListOfFormat.title' => 'LIST OF TRAINERS', 'MasterListOfFormat.company_id' => $this->Session->read('User.company_id'))));
        $this->ListOfTrainedInternalAuditor->create();
        $auditor['employee_id'] = $this->Session->read('User.employee_id');
        $auditor['training_id'] = 'A00000000-A000-A000-A000-A000000000123';
        $auditor['system_table_id'] = $systemTableId['SystemTable']['id'];
        $auditor['master_list_of_format_id'] = $formatId['MasterListOfFormat']['id'];
        $auditor['publish'] = 1;
        $auditor['soft_delete'] = 0;
        $this->ListOfTrainedInternalAuditor->save($auditor);
    }

    public function _add_trainings() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => 'training_types')));

        $this->loadModel('TrainingType');

        $trainingType = array();
        $trainingType['title'] = 'HR Trainings';
        $trainingType['training_description'] = 'All HR related trainings will be under this category';
        $trainingType['mandetory'] = 1;
        $trainingType['publish'] = 1;
        $trainingType['soft_delete'] = 0;
        $trainingType['company_id'] = $this->Session->read('User.company_id');
        $trainingType['system_table_id'] = $systemTableId['SystemTable']['id'];
        $this->TrainingType->create();
        $this->TrainingType->save($trainingType);

        $trainingType = array();
        $trainingType['title'] = 'MR Trainings';
        $trainingType['training_description'] = 'All MR related trainings will be under this category';
        $trainingType['mandetory'] = 1;
        $trainingType['publish'] = 1;
        $trainingType['soft_delete'] = 0;
        $trainingType['company_id'] = $this->Session->read('User.company_id');
        $trainingType['system_table_id'] = $systemTableId['SystemTable']['id'];
        $this->TrainingType->create();
        $this->TrainingType->save($trainingType);

        $trainingType = array();
        $trainingType['title'] = 'Technical Trainings';
        $trainingType['training_description'] = 'All Technical trainings will be under this category';
        $trainingType['mandetory'] = 1;
        $trainingType['publish'] = 1;
        $trainingType['soft_delete'] = 0;
        $trainingType['company_id'] = $this->Session->read('User.company_id');
        $trainingType['system_table_id'] = $systemTableId['SystemTable']['id'];
        $this->TrainingType->create();
        $this->TrainingType->save($trainingType);

        $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => 'course_types')));

        $this->loadModel('CourseType');

        $courseType = array();
        $courseType['title'] = 'HR Courses';
        $courseType['training_description'] = 'All HR related Courses will be under this category';
        $courseType['mandetory'] = 1;
        $courseType['publish'] = 1;
        $courseType['soft_delete'] = 0;
        $courseType['company_id'] = $this->Session->read('User.company_id');
        $courseType['system_table_id'] = $systemTableId['SystemTable']['id'];
        $this->CourseType->create();
        $this->CourseType->save($courseType);

        $hrCourseType = $this->CourseType->id;

        $courseType = array();
        $courseType['title'] = 'MR Courses';
        $courseType['training_description'] = 'All MR related courses will be under this category';
        $courseType['mandetory'] = 1;
        $courseType['publish'] = 1;
        $courseType['soft_delete'] = 0;
        $courseType['company_id'] = $this->Session->read('User.company_id');
        $courseType['system_table_id'] = $systemTableId['SystemTable']['id'];
        $this->CourseType->create();
        $this->CourseType->save($courseType);

        $mrCourseType = $this->Course->id;

        $courseType = array();
        $courseType['title'] = 'Technical Trainings';
        $courseType['training_description'] = 'All Technical courses will be under this category';
        $courseType['mandetory'] = 1;
        $courseType['publish'] = 1;
        $courseType['soft_delete'] = 0;
        $courseType['company_id'] = $this->Session->read('User.company_id');
        $courseType['system_table_id'] = $systemTableId['SystemTable']['id'];
        $this->CourseType->create();
        $this->CourseType->save($courseType);
        
        $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => 'trainer_types')));
        $this->loadModel('TrainerType');

        $internalType = array();
        $internalType['title'] = 'Internal Trainer';
        $internalType['mandetory'] = 1;
        $internalType['publish'] = 1;
        $internalType['soft_delete'] = 0;
        $internalType['company_id'] = $this->Session->read('User.company_id');
        $internalType['system_table_id'] = $systemTableId['SystemTable']['id'];
        $this->TrainerType->create();
        $this->TrainerType->save($internalType);

        $internalTrainer = $this->TrainerType->id;

        $externalType = array();
        $externalType['title'] = 'External Trainer';
        $externalType['mandetory'] = 1;
        $externalType['publish'] = 1;
        $externalType['soft_delete'] = 0;
        $externalType['company_id'] = $this->Session->read('User.company_id');
        $externalType['system_table_id'] = $systemTableId['SystemTable']['id'];
        $this->TrainerType->create();
        $this->TrainerType->save($externalType);
        
        $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => 'courses')));
        $this->loadModel('Course');

        $course = array();
        $course['title'] = 'HR Induction Courses';
        $course['description'] = 'As per ISO standards it is mandetory to under go induction';
        $course['course_type_id'] = $hrCourseType;
        $course['mandetory'] = 1;
        $course['publish'] = 1;
        $course['soft_delete'] = 0;
        $course['company_id'] = $this->Session->read('User.company_id');
        $course['system_table_id'] = $systemTableId['SystemTable']['id'];
        $this->Course->create();
        $this->Course->save($course);

        $course = array();
        $course['title'] = 'MR Internal Auditor Training';
        $course['description'] = 'Training / Course attainted related to MR';
        $course['course_type_id'] = $mrCourseType;
        $course['mandetory'] = 1;
        $course['publish'] = 1;
        $course['soft_delete'] = 0;
        $course['company_id'] = $this->Session->read('User.company_id');
        $course['system_table_id'] = $systemTableId['SystemTable']['id'];
        $this->Course->create();
        $this->Course->save($course);

        //Add Trainer
        $companyName = $this->_get_company();
        $this->loadModel('Trainer');
        $trainer['trainer_type_id'] = $internalTrainer;
        $trainer['name'] = $this->Session->read('User.name');
        $trainer['company'] = $companyName['Company']['name'];
        $trainer['publish'] = 1;
        $trainer['soft_delete'] = 0;
        $trainer['company_id'] = $this->Session->read('User.company_id');
        $trainer['system_table_id'] = $systemTableId['SystemTable']['id'];
        $this->Trainer->create();
        $this->Trainer->save($trainer);
    }

    /* cron job function -- */

    public function _send_email($officeEmailId, $personalEmailId, $template, $viewVars) {

        if ($officeEmailId != '') {
            $email = $officeEmailId;
        } else if ($personalEmailId != '') {
            $email = $personalEmailId;
        }
        if ($email) {
           try{
                App::uses('CakeEmail', 'Network/Email');
                if($this->Session->read('User.is_smtp') == 1)
                $EmailConfig = new CakeEmail("smtp");
                if($this->Session->read('User.is_smtp') == 0)
                    $EmailConfig = new CakeEmail("default");
                $EmailConfig->to($email);
                $EmailConfig->subject('FlinkISO: Demo Expiration Reminder');
                $EmailConfig->template($template);
                $EmailConfig->viewVars(array('view_vars' => $viewVars));
                $EmailConfig->emailFormat('html');
                $EmailConfig->send();
            } catch(Exception $e) {
                 $this->Session->setFlash(__('Can not notify user using email. Please check SMTP details and email address is correct.'));
            }

        }
    }

    public function expiry_reminder($diff) {
        $currentTime = date('Y-m-d');
        $this->loadModel('Company');
        $this->loadModel('Employee');
        $companies = $this->Company->find('all', array('conditions' => array('Company.publish' => 1, 'Company.soft_delete' => 0)));
        if ($companies) {
            foreach ($companies as $company) {
                $flinkisoEndDate = date('Y-m-d', strtotime($company['Company']['flinkiso_end_date']));
                $dateDiff = round(abs(strtotime($flinkisoEndDate) - strtotime($currentTime)) / 86400);
                $users = $this->User->find('all', array('conditions' => array('User.company_id' => $company['Company']['id'], 'User.is_mr' => 1, 'User.publish' => 1, 'User.soft_delete' => 0), 'recursive' => -1));

                foreach ($users as $user) {

                    $userName = $this->Employee->find('first', array('conditions' => array('Employee.id' => $user['User']['employee_id']), 'fields' => array('Employee.name', '	Employee.office_email', 'Employee.personal_email'), 'recursive' => -1));

                    if ($dateDiff >= $diff) {
                        $template = 'expiryReminder';
                        $viewVars = $flinkisoEndDate;

                        $this->_send_email($userName['Employee']['office_email'], $userName['Employee']['personal_email'], $template, $viewVars);
                    }
                }
            }
        }
        exit();
    }

    public function login_reminder() {
        $currentDate = date('Y-m-d');
        $this->loadModel('Company');
        $this->loadModel('Employee');
        $companies = $this->Company->find('all', array('conditions' => array('Company.	publish' => 1, 'Company.soft_delete' => 0)));
        if ($companies) {
            foreach ($companies as $company) {
                $companyEndDate = date('Y-m-d', strtotime('-3 days', strtotime($company['Company']['flinkiso_end_date'])));

                if ($companyEndDate == $currentDate) {

                    $users = $this->User->find('all', array('conditions' => array('User.company_id' => $company['Company']['id'], 'User.is_mr' => 1, 'User.publish' => 1, 'User.soft_delete' => 0), 'recursive' => -1));
                    foreach ($users as $user) {
                        $userName = $this->Employee->find('first', array('conditions' => array('Employee.id' => $user['User']['employee_id']), 'fields' => array('Employee.name', '	Employee.office_email', 'Employee.personal_email')));
                        $template = 'loginReminder';
                        $viewVars = $company['Company']['flinkiso_end_date'];
                        $this->_send_email($userName['Employee']['office_email'], $userName['Employee']['personal_email'], $template, $viewVars);
                    }
                }
            }
        }
        exit();
    }

    public function appraisal_answers($token = null) {

        if (empty($token) && !$this->request->is('post')) {
            $this->Session->setFlash(__('Invalid performance review token, try again.'), 'default', array('class'=>'alert-danger'));
            $this->redirect(array('action' => 'login'));
        }
        $this->layout = 'login';
        $this->loadModel('EmployeeAppraisalQuestion');
        $this->loadModel('Appraisal');
        $appraisal = $this->Appraisal->find('first', array('conditions' => array('appraisal_token' => $token, 'appraisal_token_expires >' => date('Y-m-d H:i:s')), 'recursive' => -1, 'fields' => 'Appraisal.id'));
        if (count($appraisal)) {

            $employeeAppraisals = $this->EmployeeAppraisalQuestion->find('all', array('conditions' => array('EmployeeAppraisalQuestion.appraisal_id' => $appraisal['Appraisal']['id']), 'fields' => array('id', 'appraisal_question_id', 'answer'), 'recursive' => -1));

            if (count($employeeAppraisals) > 0) {
                if ($this->request->is('post') || $this->request->is('put')) {

                    foreach ($this->request->data['EmployeeAppraisalQuestion'] as $appraisalQuestion):
                        $this->EmployeeAppraisalQuestion->save($appraisalQuestion);
                    endforeach;

                    $data['Appraisal']['id'] = $appraisal['Appraisal']['id'];
                    $data['Appraisal']['self_appraisal_status'] = 1;
                    $this->Appraisal->save($data['Appraisal'], false);

                    $this->Session->setFlash(__('Appraisal Answers Saved.'), 'default', array('class'=>'alert-success'));
                    $this->redirect(array('controller' => 'users', 'action' => 'login',));
                }
            } else {
                echo __('There are no appraisal questions.');
            }
            $appraisalQuestions = $this->EmployeeAppraisalQuestion->AppraisalQuestion->find('list', array('fields' => 'question'));

            $this->set(compact('employeeAppraisals', 'appraisalQuestions'));
        } else {
            $this->Session->setFlash(__('Invalid performance review token, try again.'), 'default', array('class'=>'alert-danger'));
            $this->redirect(array('action' => 'login'));
        }
    }

    function smtp_details($username = null){
        $this->loadModel('Company');
        if (!$this->Session->read('User.id')) {

        $record =  $this->Company->find('first', array('fields'=>'Company.smtp_setup', 'recursive'=>-1));
	    if($record['Company']['smtp_setup'] == 1){

		$this->Session->setFlash(__('Please login to setup SMTP details'), 'default', array('class'=>'alert-danger'));
		$this->redirect(array('action' => 'login',$username));

	    }
	    $this->layout = "login";
	}

        $isSmtp = 0;
        $transport = null;
        $SmtpDetail = $this->Company->find('first', array('fields'=>array('Company.is_smtp','Company.smtp_setup'), 'recursive'=>-1));
        if($SmtpDetail['Company']['smtp_setup'] == 1){
            $Email = new CakeEmail();
            $Email->config('smtp');
            $transport = $Email->transport('smtp')->config();
        }

        if($SmtpDetail['Company']['is_smtp'] == 1){
            $isSmtp = 1;
        }
        $this->set(compact('isSmtp','transport'));

        if ($this->request->is('post') || $this->request->is('put')) {
            if($this->request->data['User']['is_smtp'] == 0){
                $this->loadModel('Company');
                $id =  $this->Company->find('first', array('fields'=>'Company.id', 'recursive'=>-1));
                $this->Company->id = $id;
                $data['Company']['is_smtp'] = 0;
                $this->Company->id;
                $this->Company->save($data);
                $string =  '<?php
/**
 * This is email configuration file.
 *
 * Use it to configure email transports of Cake.
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
 * @package       app.Config
 * @since         CakePHP(tm) v 2.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 *
 * Email configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * transport => The name of a supported transport; valid options are as follows:
 *		Mail 		- Send using PHP mail function
 *		Smtp		- Send using SMTP
 *		Debug		- Do not send the email, just return the result
 *
 * You can add custom transports (or override existing transports) by adding the
 * appropriate file to app/Network/Email. Transports should be named "YourTransport.php",
 * where "Your" is the name of the transport.
 *
 * from =>
 * The origin email. See CakeEmail::from() about the valid values
 *
 */
class EmailConfig {

	public $default = array(
		"transport" => "Mail",
		"from" => array("'.$this->request->data['User']['default_user'].'" => "FlinkISO"),
		//"charset" => "utf-8",
		//"headerCharset" => "utf-8",
	);

	public $smtp = array(

        "transport" => "Smtp",
		"from" => array("noreply@yourdomain.com" => "FlinkISO"),
		"host" => "smtp.yourserver.com",
		"port" => 25,
		"timeout" => 30,
		"username" => "yourname@yourdomain.com",
		"password" => "secret",
		"client" => null,
		"log" => false,
	);

	public $fast = array(
		"from" => "you@localhost",
		"sender" => null,
		"to" => null,
		"cc" => null,
		"bcc" => null,
		"replyTo" => null,
		"readReceipt" => null,
		"returnPath" => null,
		"messageId" => true,
		"subject" => null,
		"message" => null,
		"headers" => null,
		"viewRender" => null,
		"template" => false,
		"layout" => false,
		"viewVars" => null,
		"attachments" => null,
		"emailFormat" => null,
		"transport" => "Smtp",
		"host" => "localhost",
		"port" => 25,
		"timeout" => 30,
		"username" => "user",
		"password" => "secret",
		"client" => null,
		"log" => true,
		//"charset" => "utf-8",
		//"headerCharset" => "utf-8",
	);



}';

                $fp = fopen(APP."Config/email.php", "w");
                fwrite($fp, $string);
                fclose($fp);

                $this->Session->setFlash(__('Default email setup done successfully.'), 'default', array('class'=>'alert-success'));
                $this->redirect(array('controller'=>'users','action' => 'login',$username));
            }else{

                $this->loadModel('Company');
                $id =  $this->Company->find('first', array('fields'=>'Company.id', 'recursive'=>-1));
                $this->Company->id = $id;
                $data['Company']['is_smtp'] = 1;
                $this->Company->id;
                $this->Company->save($data);
      $string =  '<?php
/**
 * This is email configuration file.
 *
 * Use it to configure email transports of Cake.
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
 * @package       app.Config
 * @since         CakePHP(tm) v 2.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 *
 * Email configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * transport => The name of a supported transport; valid options are as follows:
 *		Mail 		- Send using PHP mail function
 *		Smtp		- Send using SMTP
 *		Debug		- Do not send the email, just return the result
 *
 * You can add custom transports (or override existing transports) by adding the
 * appropriate file to app/Network/Email. Transports should be named "YourTransport.php",
 * where "Your" is the name of the transport.
 *
 * from =>
 * The origin email. See CakeEmail::from() about the valid values
 *
 */
class EmailConfig {

	public $default = array(
		"transport" => "Mail",
		"from" => array("noreply@flinkiso.com" => "FlinkISO"),
		//"charset" => "utf-8",
		//"headerCharset" => "utf-8",
	);

	public $smtp = array(

        "transport" => "Smtp",
		"from" => array("'.$this->request->data['User']['smtp_user'].'" => "FlinkISO"),
		"host" => "'.$this->request->data['User']['smtp_host'].'",
		"port" => '.$this->request->data['User']['port'].',
		"timeout" => 30,
		"username" => "'.$this->request->data['User']['smtp_user'].'",
		"password" => "'.$this->request->data['User']['smtp_password'].'",
		"client" => null,
		"log" => false,
	);

	public $fast = array(
		"from" => "you@localhost",
		"sender" => null,
		"to" => null,
		"cc" => null,
		"bcc" => null,
		"replyTo" => null,
		"readReceipt" => null,
		"returnPath" => null,
		"messageId" => true,
		"subject" => null,
		"message" => null,
		"headers" => null,
		"viewRender" => null,
		"template" => false,
		"layout" => false,
		"viewVars" => null,
		"attachments" => null,
		"emailFormat" => null,
		"transport" => "Smtp",
		"host" => "localhost",
		"port" => 25,
		"timeout" => 30,
		"username" => "user",
		"password" => "secret",
		"client" => null,
		"log" => true,
		//"charset" => "utf-8",
		//"headerCharset" => "utf-8",
	);



}';

                $fp = fopen(APP."Config/email.php", "w");
                fwrite($fp, $string);
                fclose($fp);

                $this->loadModel('Employee');
                $userData = $this->Employee->find('first', array('recursive' => -1));

                if ($userData['Employee']['office_email'] != '') {
                    $email = $userData['Employee']['office_email'];
                } else if ($userData['Employee']['personal_email'] != '') {
                    $email = $userData['Employee']['personal_email'];
                }
                if($email){


                    try{
                        App::uses('CakeEmail', 'Network/Email');
                        $EmailConfig = new CakeEmail("smtp");
                        $EmailConfig->to($email);
                        $EmailConfig->subject('FlinkISO: Smtp Setup details');
                        $EmailConfig->template('smtpSetup');
                        $EmailConfig->viewVars(array('name' => $userData['Employee']['name']));
                        $EmailConfig->emailFormat('html');

                        $EmailConfig->send();
                        $companyData = array();
                        $companyData['id'] = $userData['Employee']['company_id'];
                        $companyData['smtp_setup'] = 1;
                        $this->loadModel('Company');
                        $this->Company->save($companyData, false);
                        $this->Session->setFlash(__('SMTP setup done successfully.'), 'default', array('class'=>'alert-success'));

                        $this->redirect(array('controller'=>'users','action' => 'login', $username));

                    } catch(Exception $e) {
                        $exceptionMessage = $e->getMessage();
                        $invalidPass = substr($exceptionMessage,0,15);
                        $companyData = array();
                        $companyData['id'] = $userData['Employee']['company_id'];
                        $companyData['smtp_setup'] = 0;
                        $this->loadModel('Company');
                        $this->Company->save($companyData, false);
                        if(($invalidPass === 'SMTP Error: 535') == 1){
                            $this->Session->setFlash(__('Can not connect with SMTP server: Invalid password'), 'default', array('class'=>'alert-danger'));
                        }else{
                            $this->Session->setFlash(__('Can not connect with SMTP server: '.$e->getMessage()), 'default', array('class'=>'alert-danger'));
                        }

                    }
              }

        }
        }
         $isSmtp = 0;
        $transport = null;
        $default_transport = null;
        $SmtpDetail = $this->Company->find('first', array('fields'=>array('Company.is_smtp','Company.smtp_setup'), 'recursive'=>-1));
        $Email = new CakeEmail();
        if($SmtpDetail['Company']['is_smtp'] == 1){

            $Email->config('smtp');
            $transport = $Email->transport('smtp')->config();
        }else{
             $Email->config('default');
             $default_transport = $Email->transport('default')->config();

    }

if($SmtpDetail['Company']['is_smtp'] == 1){
            $isSmtp = 1;
        }
        $this->set(compact('isSmtp','transport',  'default_transport', 'username'));

    }

    public function dashboard_files(){

    }

    public function check_registration($userEmailID = null, $downloadKey = null){
        if (isset($userEmailID) && isset($downloadKey)) {
            $license_key = base64_decode($downloadKey);

            $this->loadModel('Company');
            $registrationCheck = $this->Company->find('count', array('recursive' => -1, 'conditions' => array('Company.liscence_key' => $license_key)));
            if ($registrationCheck) {
                $this->redirect(array('controller' => 'users', 'action' => 'login', $userEmailID));
            } else {
                $url = "www.flinkiso.com/checkLicenceKey.php";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url );
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE );
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE );
                curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE );
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:31.0) Gecko/20100101 Firefox/31.0"));
                $postfields = array();
                $postfields['liscence_key'] = urlencode($license_key);

                curl_setopt($ch, CURLOPT_POST, count($postfields));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
                $ret = curl_exec($ch);
                curl_close($ch);

                $regDetails = json_decode($ret, true);
                $this->loadModel('Employee');
                $emailExists = $this->Employee->find('count', array('conditions' => array('Employee.personal_email' => $regDetails['email'], 'OR' => array(array('Employee.office_email' => $regDetails['email']))), 'recursive' => -1));
                if ($emailExists) {
                    $this->redirect(array('controller' => 'users', 'action' => 'login', $userEmailID));
                } else {
                    $this->Session->setFlash(__('Email id already exists. Please login.'), 'default', array('class'=>'alert-danger'));
                    $this->redirect(array('controller' => 'users', 'action' => 'login', $userEmailID));

                }
            }
        }
        exit;
    }
    
    public function upgrade(){

    }
    



}
