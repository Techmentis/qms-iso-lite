<?php

App::uses('AppController', 'Controller');

/**
 * Customers Controller
 *
 * @property Customer $Customer
 */
class CustomersController extends AppController {

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

        $this->paginate = array('order' => array('Customer.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->Customer->recursive = 0;
        $this->set('customers', $this->paginate());

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
                $searchKeys[] = $this->request->query['keywords'];
            } else {
                $searchKeys = explode(" ", $this->request->query['keywords']);
            }
            foreach ($searchKeys as $searchKey):
                foreach ($this->request->query['search_fields'] as $search):
                    if ($this->request->query['strict_search'] == 0)
                        $searchArray[] = array('Customer.' . $search => $searchKey);
                    else
                        $searchArray[] = array('Customer.' . $search . ' like ' => '%' . $searchKey . '%');
                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('Customer.branch_id' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['customer_type'] == 0) {
            $customerTypeConditions[] = array('Customer.customer_type' => $this->request->query['customer_type']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $customerTypeConditions);
            else
                $conditions[] = array('or' => $customerTypeConditions);
        }
        elseif ($this->request->query['customer_type'] == 1) {
            $customerTypeConditions[] = array('Customer.customer_type' => $this->request->query['customer_type']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $customerTypeConditions);
            else
                $conditions[] = array('or' => $customerTypeConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('Customer.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'Customer.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('Customer.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Customer.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->Customer->recursive = 0;
        $this->paginate = array('order' => array('Customer.sr_no' => 'DESC'), 'conditions' => $conditions, 'Customer.soft_delete' => 0);
        $this->set('customers', $this->paginate());

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
        if (!$this->Customer->exists($id)) {
            throw new NotFoundException(__('Invalid customer'));
        }
        $options = array('conditions' => array('Customer.' . $this->Customer->primaryKey => $id));
        $this->set('customer', $this->Customer->find('first', $options));
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
            if(!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1){
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['Customer']['system_table_id'] = $this->_get_system_table_id();
            $this->Customer->create();

            if ($this->request->data['Customer']['customer_type'] == 0) {
                unset($this->request->data['Customer']['maritial_status']);
                unset($this->request->data['Customer']['date_of_birth']);
            }
            if ($this->Customer->save($this->request->data)) {
                $this->Session->setFlash(__('The customer has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->Customer->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The customer could not be saved. Please, try again.'));
            }
        }
        $maritalStatus = array('Single' => 'Single', 'Married' => 'Married', 'Widowed' => 'Widowed', 'Separated' => 'Separated', 'Divorced' => 'Divorced', 'Other' => 'Other');
        $this->set(compact('branches', 'systemTables', 'masterListOfFormats', 'maritalStatus'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Customer->exists($id)) {
            throw new NotFoundException(__('Invalid customer'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if(!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1){
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['Customer']['system_table_id'] = $this->_get_system_table_id();

            if ($this->request->data['Customer']['customer_type'] == 0) {
                $this->request->data['Customer']['maritial_status'] = '';
                $this->request->data['Customer']['date_of_birth'] = '';
            }
            if ($this->Customer->save($this->request->data, false)) {
                $this->Session->setFlash(__('The customer has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The customer could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Customer.' . $this->Customer->primaryKey => $id));
            $this->request->data = $this->Customer->find('first', $options);
        }
        $maritalStatus = array('Single' => 'Single', 'Married' => 'Married', 'Widowed' => 'Widowed', 'Separated' => 'Separated', 'Divorced' => 'Divorced', 'Other' => 'Other');
        $this->set(compact('maritalStatus'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->Customer->exists($id)) {
            throw new NotFoundException(__('Invalid customer'));
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
            if(!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1){
                $this->request->data[$this->modelClass]['publish'] = 0;
            }

            if ($this->request->data['Customer']['customer_type'] == 0) {
                $this->request->data['Customer']['maritial_status'] = '';
                $this->request->data['Customer']['date_of_birth'] = '';
            }
            if ($this->Customer->save($this->request->data, false)) {
                $this->Session->setFlash(__('The customer has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals();

            } else {
                $this->Session->setFlash(__('The customer could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Customer.' . $this->Customer->primaryKey => $id));
            $this->request->data = $this->Customer->find('first', $options);
        }
        $maritalStatus = array('Single' => 'Single', 'Married' => 'Married', 'Widowed' => 'Widowed', 'Separated' => 'Separated', 'Divorced' => 'Divorced', 'Other' => 'Other');
        $this->set(compact('maritalStatus'));
    }

    public function get_unique_values($number = null, $type = null, $id = null) {

        $this->Customer->recursive = -1;

        if ($id) {
            if ($number) {
                if ($type == 'custCode') {
                    $customerCode = $this->Customer->find('all', array('conditions' => array('Customer.customer_code' => $number, 'Customer.id !=' => $id)));
                    $this->set('customerCode', $customerCode);
                } else {
                    $emailId = $this->Customer->find('all', array('conditions' => array('Customer.email' => $number, 'Customer.id !=' => $id)));
                    $this->set('emailId', $emailId);
                }
            }
        } else {
            if ($number) {
                if ($type == 'custCode') {
                    $customerCode = $this->Customer->find('all', array('conditions' => array('customer_code' => $number)));
                    $this->set('customerCode', $customerCode);
                } else {
                    $emailId = $this->Customer->find('all', array('conditions' => array('email' => $number)));
                    $this->set('emailId', $emailId);
                }
            }
        }
        $this->set('type', $type);
    }

}
