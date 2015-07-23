<?php

App::uses('AppController', 'Controller');

/**
 * Employees Controller
 *
 * @property Employee $Employee
 */
class EmployeesController extends AppController {

    public function _get_system_table_id() {
        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $this->request->params['controller'])));
        return $systemTableId['SystemTable']['id'];
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {

        $conditions = $this->_check_request();
        $this->paginate = array('order' => array('Employee.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->Employee->recursive = 0;
        $this->set('employees', $this->paginate());

        $this->_get_count();
    }

    public function employee_kra($id = null, $employeeKra = null, $edit = null) {
        if (!isset($id)){
            $id = $this->request->data['Employee']['id'];
         }
         $this->loadModel('EmployeeKra');
         if($edit == 2){
            if (isset($employeeKra)){
            $this->loadModel('EmployeeKra');
            $this->EmployeeKra->delete($employeeKra,true);
         }
         $edit =1;
        }
        $this->set(compact('employeeKra','edit'));
        if ($this->request->is('post') || $this->request->is('put')) {
        foreach ($this->request->data['Employee'] as $value) {
                $data = array();
                $data['EmployeeKra']['title'] = $value['title'];
                $data['EmployeeKra']['target'] = $value['target'];
                $data['EmployeeKra']['description'] = $value['description'];
                if (isset($value['edit']) && $value['edit'] == 1 && $value['edit'] != 2) {
                    if ((!empty($value['title'])) || (!empty($value['target'])) || (!empty($value['description']))) {
                        $this->EmployeeKra->id = $this->request->data['Employee']['Kraid'];
                        $this->EmployeeKra->save($data['EmployeeKra'], false);
                    }
                }

                else if ($value['edit'] != 1 && $value['edit'] != 2) {
                    $data['EmployeeKra']['branchid'] = $value['branchid'];
                    $data['EmployeeKra']['departmentid'] = $value['departmentid'];
                    $data['EmployeeKra']['master_list_of_format_id'] = $value['master_list_of_format_id'];
                    $data['EmployeeKra']['system_table_id'] = $this->_get_system_table_id();
                    $data['EmployeeKra']['employee_id'] = $this->request->data['Employee']['id'];
                    if ((!empty($value['title'])) || (!empty($value['target'])) || (!empty($value['description']))) {
                        $this->EmployeeKra->create();
                        $this->EmployeeKra->save($data['EmployeeKra'], false);
                    }


                }
            }
        }
        $options = array('conditions' => array('Employee.id' => $id));
        $this->loadModel('EmployeeKra');
        $kraLists = $this->EmployeeKra->find('all', array('conditions' => array('EmployeeKra.employee_id' => $id)));
        $this->set('employee', $this->Employee->find('first', $options));
        $this->set('kraLists', $kraLists);
        $this->render('/Elements/add_kra');
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
            if ($this->request->query['strict_search'] == 0) {
                $SearchKeys[] = $this->request->query['keywords'];
            } else {
                $SearchKeys = explode(" ", $this->request->query['keywords']);
            }

            foreach ($SearchKeys as $SearchKey):
                foreach ($this->request->query['search_fields'] as $search):
                    if ($this->request->query['strict_search'] == 0)
                        $searchArray[] = array('Employee.' . $search => $SearchKey);
                    else
                        $searchArray[] = array('Employee.' . $search . ' like ' => '%' . $SearchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('Employee.branch_id' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }

        if ($this->request->query['designation_id']) {
            foreach ($this->request->query['designation_id'] as $designation):
                $designationConditions[] = array('Employee.designation_id' => $designation);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $designationConditions));
            else
                $conditions[] = array('or' => $designationConditions);
        }
        if ($this->request->query['qualification'] != -1) {
            foreach ($this->request->query['qualification'] as $qualification):
                $qualificationConditions = array('Employee.qualification like' => '%' . $qualification . '%');
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $qualificationConditions));
            else
                $conditions[] = array('or' => $qualificationConditions);
        }
        if ($this->request->query['maritial_status'] != -1) {
            $maritalStatus[] = array('Employee.maritial_status' => $this->request->query['maritial_status']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $maritalStatus);
            else
                $conditions[] = array('or' => $maritalStatus);
        }
        if ($this->request->query['employment_status'] != -1) {
            $employmentStatus[] = array('Employee.employment_status' => $this->request->query['employment_status']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $employmentStatus);
            else
                $conditions[] = array('or' => $employmentStatus);
        }
        if ($this->request->query['joining_date'] != '') {
            $joiningDate_conditions[] = array('Employee.joining_date' => $this->request->query['joining_date']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $joiningDate_conditions);
            else
                $conditions[] = array('or' => $joiningDate_conditions);
        }
        if ($this->request->query['date_of_birth'] != '') {
            $customer_type_conditions[] = array('Employee.date_of_birth' => $this->request->query['date_of_birth']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $customer_type_conditions);
            else
                $conditions[] = array('or' => $customer_type_conditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('Employee.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'Employee.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('Employee.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Employee.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->Employee->recursive = 0;
        $this->paginate = array('order' => array('Employee.sr_no' => 'DESC'), 'conditions' => $conditions, 'Employee.soft_delete' => 0);
        $this->set('employees', $this->paginate());

        $this->render('index');
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null, $employee_kra = null) {
        if (!$this->Employee->exists($id)) {
            throw new NotFoundException(__('Invalid employee'));
        }
        $options = array('conditions' => array('Employee.' . $this->Employee->primaryKey => $id));
        $this->loadModel('EmployeeKra');
        $kraLists = $this->EmployeeKra->find('all', array('conditions' => array('EmployeeKra.employee_id' => $id)));
        $this->set('employee', $this->Employee->find('first', $options));
        $this->set('kraLists', $kraLists);
        $this->set('employee_kra', $employee_kra);
        $this->_etni($id);
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
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }

            $this->request->data['Employee']['qualification'] = implode(",", $this->request->data['qualification']);
            $this->request->data['Employee']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['Employee']['created_by'] = $this->Session->read('User.id');
            $this->request->data['Employee']['modified_by'] = $this->Session->read('User.id');
            $this->request->data['Employee']['created'] = date('Y-m-d H:i:s');
            $this->request->data['Employee']['modified_by'] = date('Y-m-d H:i:s');

            $this->Employee->create();
            if ($this->Employee->save($this->request->data, false)) {
                $this->Session->setFlash(__('The employee has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->Employee->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The employee could not be saved. Please, try again.'));
            }
        }
        $maritalStatus = array('Single' => 'Single', 'Married' => 'Married', 'Widowed' => 'Widowed', 'Separated' => 'Separated', 'Divorced' => 'Divorced', 'Other' => 'Other');
        $branches = $this->Employee->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $designations = $this->Employee->Designation->find('list', array('conditions' => array('Designation.publish' => 1, 'Designation.soft_delete' => 0)));
        $this->set(compact('branches', 'designations', 'maritalStatus'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Employee->exists($id)) {
            throw new NotFoundException(__('Invalid employee'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['Employee']['qualification'] = implode(",", $this->request->data['qualification']);
            $this->request->data['Employee']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['Employee']['modified_by'] = $this->Session->read('User.id');
            $this->request->data['Employee']['modified_by'] = date('Y-m-d H:i:s');

            if ($this->Employee->save($this->request->data)) {
                $this->Session->setFlash(__('The employee has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The employee could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Employee.' . $this->Employee->primaryKey => $id));
            $this->request->data = $this->Employee->find('first', $options);
        }
        $maritalStatus = array('Single' => 'Single', 'Married' => 'Married', 'Widowed' => 'Widowed', 'Separated' => 'Separated', 'Divorced' => 'Divorced', 'Other' => 'Other');
        $branches = $this->Employee->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $designations = $this->Employee->Designation->find('list', array('conditions' => array('Designation.publish' => 1, 'Designation.soft_delete' => 0)));
        $this->set(compact('branches', 'designations', 'maritalStatus'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->Employee->exists($id)) {
            throw new NotFoundException(__('Invalid employee'));
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
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['Employee']['qualification'] = implode(",", $this->request->data['qualification']);
            $this->request->data['Employee']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['Employee']['modified_by'] = $this->Session->read('User.id');
            $this->request->data['Employee']['modified_by'] = date('Y-m-d H:i:s');

	    if ($this->Employee->save($this->request->data)) {
                $this->Session->setFlash(__('The employee has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The employee could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Employee.' . $this->Employee->primaryKey => $id));
            $this->request->data = $this->Employee->find('first', $options);
        }
        $maritalStatus = array('Single' => 'Single', 'Married' => 'Married', 'Widowed' => 'Widowed', 'Separated' => 'Separated', 'Divorced' => 'Divorced', 'Other' => 'Other');
        $branches = $this->Employee->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $designations = $this->Employee->Designation->find('list', array('conditions' => array('Designation.publish' => 1, 'Designation.soft_delete' => 0)));
        $this->set(compact('branches', 'designations', 'maritalStatus'));
    }

    public function get_employee_email($employeeEmail = null, $id = null) {
        if ($employeeEmail) {
            if ($id) {
                $employeeEmails = $this->Employee->find('all', array('conditions' => array('Employee.office_email' => $employeeEmail, 'Employee.id !=' => $id)));
            } else {
                $employeeEmails = $this->Employee->find('all', array('conditions' => array('Employee.office_email' => $employeeEmail)));
            }
            $this->set('employeeEmails', $employeeEmails);
        }
    }

    public function _etni($id = null) {
        $trainings = $this->Employee->TrainingNeedIdentification->find('all', array('conditions' => array('TrainingNeedIdentification.employee_id' => $id)));
        $employeeTrainings = $this->Employee->EmployeeTraining->find('all', array('conditions' => array('EmployeeTraining.employee_id' => $id)));
        $this->set(compact('trainings', 'employeeTrainings'));
    }

    public function delete($id = null) {
        $modelName = $this->modelClass;
        $record = Inflector::underscore($modelName);
        $record = Inflector::humanize($record);
        $this->loadModel('Approval');
        if (!empty($id)) {
	    if($id == $this->Session->read('User.employee_id')){
		$this->Session->setFlash(__('Logged-in user can not delete his own \'Employee Record\'.', 'default', array('class'=>'alert alert-danger')));
	    } else {
		$approves = $this->Approval->find('all',array('conditions'=>array('Approval.record'=>$id,'Approval.model_name'=>$modelName)));
			foreach($approves as $approve)
			{
			    $approve['Approval']['soft_delete']=1;
			    $this->Approval->save($approve, false);
			}
		$data['id'] = $id;
		$data['soft_delete'] = 1;
		$modelName = $this->modelClass;
		$this->$modelName->save($data, false);
		$this->Session->setFlash(__('Selected %s deleted',$record));
	    }
        }
        $this->redirect(array('action' => 'index'));
    }

    public function delete_all($ids = null) {
	$flag = 1;
	$count=0;
	if ($_POST['data'][$this->name]['recs_selected'])
	    $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);

	$modelName = $this->modelClass;
	$this->loadModel('Approval');
	if (!empty($ids)) {

	    foreach ($ids as $id) {
		if (!empty($id)) {
		    if ($id == $this->Session->read('User.employee_id')) {
			$flag = 0;
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
			$count++;
		    }
		}
	    }
	}
	if ($flag) {
	    $this->Session->setFlash(__('All selected employees deleted'));
	} else {
	    $this->Session->setFlash(__('Selected %s employees deleted.<br />Logged-in users can not delete their own \'Employee record\'.', $count));
	}
	$this->redirect(array('action' => 'index'));
    }

}
