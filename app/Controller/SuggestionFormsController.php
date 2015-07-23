<?php

App::uses('AppController', 'Controller');

/**
 * SuggestionForms Controller
 *
 * @property SuggestionForm $SuggestionForm
 */
class SuggestionFormsController extends AppController {

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
        $this->paginate = array('order' => array('SuggestionForm.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->SuggestionForm->recursive = 0;
        $this->set('SuggestionForms', $this->paginate());

        $this->SuggestionForm->recursive = 0;
        $Suggestions = $this->paginate();
        foreach($Suggestions as $key => $Suggestion) {
            $SuggestionForms = $this->SuggestionForm->find('all', array('conditions' => array('SuggestionForm.soft_delete' => 0), 'fields' => array('Employee.name', 'SuggestionForm.employee_id', 'SuggestionForm.status'),
                'order' => array('Employee.name' => 'DESC')));
            $employees = array();
         
            foreach ($SuggestionForms as $key1=>$SuggestionForm) {
                $employees[] = $SuggestionForm['Employee']['name'];
                if ($SuggestionForm['SuggestionForm']['employee_id'] == $this->Session->read('User.employee_id')) {
                    $SuggestionForms[$key1]['SuggestionForm']['status'] = $SuggestionForm['SuggestionForm']['status'];
                }
            }

            $SuggestionForms[$key]['SuggestionForm']['SuggestionForms'] = implode(', ', $employees);
        }
        $this->set('suggestions', $SuggestionForms);

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
            if ($this->requset->query['strict_search'] == 0) {
                $searchKeys[] = $this->request->query['keywords'];
            } else {
                $searchKeys = explode(" ", $this->request->query['keywords']);
            }
            foreach ($searchKeys as $searchKey):
                foreach ($this->request->query['search_fields'] as $search):
                    if ($this->request->query['strict_search'] == 0)
                        $searchArray[] = array('SuggestionForm.' . $search => $searchKey);
                    else
                        $searchArray[] = array('SuggestionForm.' . $search . ' like ' => '%' . $searchKey . '%');
                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['employee_id'] != -1) {
            $employeeConditions[] = array('SuggestionForm.employee_id' => $this->request->query['employee_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $employeeConditions);
            else
                $conditions[] = array('or' => $employeeConditions);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('SuggestionForm.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('or' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('SuggestionForm.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'SuggestionForm.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['Search']['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('SuggestionForm.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('SuggestionForm.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->SuggestionForm->recursive = 0;
        $this->paginate = array('order' => array('SuggestionForm.sr_no' => 'DESC'), 'conditions' => $conditions, 'SuggestionForm.soft_delete' => 0);
        $this->set('SuggestionForms', $this->paginate());

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
        if (!$this->SuggestionForm->exists($id)) {
            throw new NotFoundException(__('Invalid Suggestion form'));
        }
        $options = array('conditions' => array('SuggestionForm.' . $this->SuggestionForm->primaryKey => $id));

        $this->set('SuggestionForm', $this->SuggestionForm->find('first', $options));

        $SuggestionStatus = $this->SuggestionForm->find('first', array('conditions' => array('SuggestionForm.id' => $id, 'SuggestionForm.employee_id' => $this->Session->read('User.employee_id'))));
        if ($SuggestionStatus) {
            $SuggestionStatus['SuggestionForm']['status'] = 1;
            $this->SuggestionForm->save($SuggestionStatus['SuggestionForm']);
        }
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
            $this->request->data['SuggestionForm']['system_table_id'] = $this->_get_system_table_id();
            $this->SuggestionForm->create();
            if ($this->SuggestionForm->save($this->request->data)) {

                if ($this->request->data['SuggestionForm']['add_to_capa'] == 0) {

                    $this->loadModel('Employee');
                    $employee = $this->Employee->find('first', array('conditions' => array('Employee.id' => $this->request->data['SuggestionForm']['employee_id']), 'fields' => array('Employee.name')));

                    $this->loadModel('CorrectivePreventiveAction');
                    $this->CorrectivePreventiveAction->create();
                    $capa['number'] = '';
                    $capa['capa_category_id'] = '5245a90d-1f4c-4693-9853-41ebc6c3268c';
                    $capa['raised_by'] = json_encode(array('Soruce' => 'Employee', 'id' => $this->SuggestionForm->id));
                    $capa['capa_source_id'] = NULL;
                    $capa['Suggestion_form_id'] = $this->SuggestionForm->id;
                    $capa['initial_remarks'] = "by - " . $employee['Employee']['name'] . $this->request->data['SuggestionForm']['activity'] . "<br/>" . $this->request->data['SuggestionForm']['suggestion'];
                    $capa['priority'] = 0;
                    $capa['publish'] = 1;
                    $this->CorrectivePreventiveAction->save($capa);
                }

                $this->Session->setFlash(__('The Suggestion form has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->SuggestionForm->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The Suggestion form could not be saved. Please, try again.'));
            }
        }
        $this->loadModel('Users');
        $users = $this->Users->find('all', array('conditions' => array('Users.is_mr' => 1, 'Users.soft_delete' => 0)));
        $employees = array();
        foreach ($users as $user) {
            $employees[$user['Users']['employee_id']] = $user['Users']['name'];
        }
        $this->set(compact('employees'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->SuggestionForm->exists($id)) {
            throw new NotFoundException(__('Invalid Suggestion form'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['SuggestionForm']['system_table_id'] = $this->_get_system_table_id();
            if ($this->SuggestionForm->save($this->request->data)) {

                $this->Session->setFlash(__('The Suggestion form has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The Suggestion form could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('SuggestionForm.' . $this->SuggestionForm->primaryKey => $id));
            $this->request->data = $this->SuggestionForm->find('first', $options);
        }
        $this->loadModel('Users');
        $users = $this->Users->find('all', array('conditions' => array('Users.is_mr' => 1, 'Users.soft_delete' => 0)));
        $employees = array();
        foreach ($users as $user) {
            $employees[$user['Users']['employee_id']] = $user['Users']['name'];
        }
        $this->set(compact('employees'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->SuggestionForm->exists($id)) {
            throw new NotFoundException(__('Invalid Suggestion form'));
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
            if ($this->SuggestionForm->save($this->request->data)) {

                $this->Session->setFlash(__('The Suggestion form has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The Suggestion form could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('SuggestionForm.' . $this->SuggestionForm->primaryKey => $id));
            $this->request->data = $this->SuggestionForm->find('first', $options);
        }
        $this->loadModel('Users');
        $users = $this->Users->find('all', array('conditions' => array('Users.is_mr' => 1, 'Users.soft_delete' => 0)));
        $employees = array();
        foreach ($users as $user) {
            $employees[$user['Users']['employee_id']] = $user['Users']['name'];
        }
        $this->set(compact('employees'));
    }

}
