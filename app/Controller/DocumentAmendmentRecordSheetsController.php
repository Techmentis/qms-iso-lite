<?php

App::uses('AppController', 'Controller');

/**
 * DocumentAmendmentRecordSheets Controller
 *
 * @property DocumentAmendmentRecordSheet $DocumentAmendmentRecordSheet
 */
class DocumentAmendmentRecordSheetsController extends AppController {

    public function _get_system_table_id($controller = NULL) {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $controller)));
        return $systemTableId['SystemTable']['id'];
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {

        $conditions = $this->_check_request();
        $this->paginate = array('order' => array('DocumentAmendmentRecordSheet.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->DocumentAmendmentRecordSheet->recursive = 0;
        $this->set('documentAmendmentRecordSheets', $this->paginate());

        $this->_get_count();
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
                        $searchArray[] = array('DocumentAmendmentRecordSheet.' . $search => $SearchKey);
                    else
                        $searchArray[] = array('DocumentAmendmentRecordSheet.' . $search . ' like ' => '%' . $SearchKey . '%');
                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('DocumentAmendmentRecordSheet.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('or' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['customer_id'] != -1) {
            $customerConditions[] = array('DocumentAmendmentRecordSheet.customer_id' => $this->request->query['customer_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $customerConditions);
            else
                $conditions[] = array('or' => $customerConditions);
        }

        //Request From : Branch
        if ($this->request->query['branch_id'] != -1) {
            $branchConditions[] = array('DocumentAmendmentRecordSheet.branch_id' => $this->request->query['branch_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $branchConditions);
            else
                $conditions[] = array('or' => $branchConditions);
        }

        if ($this->request->query['department_id'] != -1) {
            $departmentConditions[] = array('DocumentAmendmentRecordSheet.department_id' => $this->request->query['department_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $departmentConditions);
            else
                $conditions[] = array('or' => $departmentConditions);
        }

        if ($this->request->query['employee_id'] != -1) {
            $employeeConditions[] = array('DocumentAmendmentRecordSheet.employee_id' => $this->request->query['employee_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $employeeConditions);
            else
                $conditions[] = array('or' => $employeeConditions);
        }

        if ($this->request->query['suggestion_form_id'] != -1) {
            $suggestionForm[] = array('DocumentAmendmentRecordSheet.suggestion_form_id' => $this->request->query['suggestion_form_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $suggestionForm);
            else
                $conditions[] = array('or' => $suggestionForm);
        }

        if ($this->request->query['others'] != '') {
            $othersConditions[] = array('DocumentAmendmentRecordSheet.others' => $this->request->query['others']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $othersConditions);
            else
                $conditions[] = array('or' => $othersConditions);
        }
        if ($this->request->query['master_list_of_format'] != -1) {

            $masterlistConditions[] = array('DocumentAmendmentRecordSheet.master_list_of_format' => $this->request->query['master_list_of_format']);

            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $masterlistConditions);
            else
                $conditions[] = array('or' => $masterlistConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('DocumentAmendmentRecordSheet.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'DocumentAmendmentRecordSheet.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('DocumentAmendmentRecordSheet.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('DocumentAmendmentRecordSheet.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->DocumentAmendmentRecordSheet->recursive = 0;
        $this->paginate = array('order' => array('DocumentAmendmentRecordSheet.sr_no' => 'DESC'), 'conditions' => $conditions, 'DocumentAmendmentRecordSheet.soft_delete' => 0);
        $this->set('documentAmendmentRecordSheets', $this->paginate());

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

        if (!$this->DocumentAmendmentRecordSheet->exists($id)) {
            throw new NotFoundException(__('Invalid document amendment record sheet'));
        }
        $this->DocumentAmendmentRecordSheet->recursive = 2;
        $options = array('conditions' => array('DocumentAmendmentRecordSheet.' . $this->DocumentAmendmentRecordSheet->primaryKey => $id));
        $documentAmendmentRecordSheet = $this->DocumentAmendmentRecordSheet->find('first', $options);
        unset($documentAmendmentRecordSheet['Customer']);
        unset($documentAmendmentRecordSheet['CreatedBy']);
        $this->set('documentAmendmentRecordSheet', $documentAmendmentRecordSheet);


        $firstDocument = $this->DocumentAmendmentRecordSheet->MasterListOfFormat->find('first', array('conditions' => array(
                'MasterListOfFormat.id' => $documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['master_list_of_format']),
            'recursive' => 1
        ));
        $revisionHistorys = $this->DocumentAmendmentRecordSheet->find('all', array(
			'conditions' => array(
                'DocumentAmendmentRecordSheet.master_list_of_format' => $documentAmendmentRecordSheet['DocumentAmendmentRecordSheet']['master_list_of_format'],
            ),
			'recursive' => 1,
			'order'=>array('DocumentAmendmentRecordSheet.created'=>'ASC')
			));

        $this->set(compact('revisionHistorys', 'firstDocument'));
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
            $this->request->data['DocumentAmendmentRecordSheet']['request_from'] = 0;
            $this->request->data['DocumentAmendmentRecordSheet']['system_table_id'] = $this->_get_system_table_id($this->request->params['controller']);
            $this->request->data['DocumentAmendmentRecordSheet']['created_by'] = $this->Session->read('User.id');
            $this->request->data['DocumentAmendmentRecordSheet']['created'] = date('Y-m-d H:i:s');
            $this->request->data['DocumentAmendmentRecordSheet']['modified_by'] = $this->Session->read('User.id');
            $this->request->data['DocumentAmendmentRecordSheet']['modified'] = date('Y-m-d H:i:s');

            $this->DocumentAmendmentRecordSheet->create();
            if ($this->DocumentAmendmentRecordSheet->save($this->request->data)) {
                $this->Session->setFlash(__('The document amendment record sheet has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->DocumentAmendmentRecordSheet->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The document amendment record sheet could not be saved. Please, try again.'));
            }
        }
        $branches = $this->DocumentAmendmentRecordSheet->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $departments = $this->DocumentAmendmentRecordSheet->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0)));
        $employees = $this->DocumentAmendmentRecordSheet->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $customers = $this->DocumentAmendmentRecordSheet->Customer->find('list', array('conditions' => array('Customer.publish' => 1, 'Customer.soft_delete' => 0)));
        $suggestionForms = $this->DocumentAmendmentRecordSheet->SuggestionForm->find('list', array('conditions' => array('SuggestionForm.publish' => 1, 'SuggestionForm.soft_delete' => 0)));

        $systemTables = $this->DocumentAmendmentRecordSheet->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $masterListOfFormats = $this->DocumentAmendmentRecordSheet->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0, 'MasterListOfFormat.archived' => 0)));
        $this->set(compact('branches', 'departments', 'employees', 'customers', 'suggestionForms', 'systemTables', 'masterListOfFormats'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {

        if (!$this->DocumentAmendmentRecordSheet->exists($id)) {
            throw new NotFoundException(__('Invalid document amendment record sheet'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['DocumentAmendmentRecordSheet']['system_table_id'] = $this->_get_system_table_id($this->request->params['controller']);
            $this->request->data['DocumentAmendmentRecordSheet']['request_from'] = 0;
            $this->request->data['DocumentAmendmentRecordSheet']['created_by'] = $this->Session->read('User.id');
            $this->request->data['DocumentAmendmentRecordSheet']['created'] = date('Y-m-d H:i:s');
            $this->request->data['DocumentAmendmentRecordSheet']['modified_by'] = $this->Session->read('User.id');
            $this->request->data['DocumentAmendmentRecordSheet']['modified'] = date('Y-m-d H:i:s');

            if ($this->DocumentAmendmentRecordSheet->save($this->request->data)) {
                $this->Session->setFlash(__('The document amendment record sheet has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The document amendment record sheet could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('DocumentAmendmentRecordSheet.' . $this->DocumentAmendmentRecordSheet->primaryKey => $id));
            $this->request->data = $this->DocumentAmendmentRecordSheet->find('first', $options);
        }
        $branches = $this->DocumentAmendmentRecordSheet->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $departments = $this->DocumentAmendmentRecordSheet->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0)));
        $employees = $this->DocumentAmendmentRecordSheet->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $customers = $this->DocumentAmendmentRecordSheet->Customer->find('list', array('conditions' => array('Customer.publish' => 1, 'Customer.soft_delete' => 0)));

        $SuggestionForms = $this->DocumentAmendmentRecordSheet->SuggestionForm->find('list', array('conditions' => array('SuggestionForm.publish' => 1, 'SuggestionForm.soft_delete' => 0)));
        $SuggestionForms = $this->DocumentAmendmentRecordSheet->SuggestionForm->find('list', array('conditions' => array('SuggestionForm.publish' => 1, 'SuggestionForm.soft_delete' => 0)));
        $systemTables = $this->DocumentAmendmentRecordSheet->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $masterListOfFormats = $this->DocumentAmendmentRecordSheet->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0, 'MasterListOfFormat.archived' => 0)));
        $this->set(compact('branches', 'departments', 'employees', 'customers', 'SuggestionForms', 'systemTables', 'masterListOfFormats'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->DocumentAmendmentRecordSheet->exists($id)) {
            throw new NotFoundException(__('Invalid document amendment record sheet'));
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
            $this->request->data['DocumentAmendmentRecordSheet']['system_table_id'] = $this->_get_system_table_id($this->request->params['controller']);
            $this->request->data['DocumentAmendmentRecordSheet']['request_from'] = 0;
            $this->request->data['DocumentAmendmentRecordSheet']['created_by'] = $this->Session->read('User.id');
            $this->request->data['DocumentAmendmentRecordSheet']['created'] = date('Y-m-d H:i:s');
            $this->request->data['DocumentAmendmentRecordSheet']['modified_by'] = $this->Session->read('User.id');
            $this->request->data['DocumentAmendmentRecordSheet']['modified'] = date('Y-m-d H:i:s');
            if ($this->DocumentAmendmentRecordSheet->save($this->request->data)) {
                $this->Session->setFlash(__('The document amendment record sheet has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The document amendment record sheet could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('DocumentAmendmentRecordSheet.' . $this->DocumentAmendmentRecordSheet->primaryKey => $id));
            $this->request->data = $this->DocumentAmendmentRecordSheet->find('first', $options);
        }
        $branches = $this->DocumentAmendmentRecordSheet->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $departments = $this->DocumentAmendmentRecordSheet->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0)));
        $employees = $this->DocumentAmendmentRecordSheet->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $customers = $this->DocumentAmendmentRecordSheet->Customer->find('list', array('conditions' => array('Customer.publish' => 1, 'Customer.soft_delete' => 0)));

        $suggestionForms = $this->DocumentAmendmentRecordSheet->SuggestionForm->find('list', array('conditions' => array('SuggestionForm.publish' => 1, 'SuggestionForm.soft_delete' => 0)));
        $masterListOfFormats = $this->DocumentAmendmentRecordSheet->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0, 'MasterListOfFormat.archived' => 0)));
        $this->set(compact('branches', 'departments', 'employees', 'customers', 'suggestionForms', 'masterListOfFormats'));
    }
}