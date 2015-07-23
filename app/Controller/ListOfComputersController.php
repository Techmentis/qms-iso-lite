<?php

App::uses('AppController', 'Controller');

/**
 * ListOfComputers Controller
 *
 * @property ListOfComputer $ListOfComputer
 */
class ListOfComputersController extends AppController {

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
        $this->paginate = array('order' => array('ListOfComputer.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->ListOfComputer->recursive = 0;
        $this->set('listOfComputers', $this->paginate());

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
                        $searchArray[] = array('ListOfComputer.' . $search => $searchKey);
                    else
                        $searchArray[] = array('ListOfComputer.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if (!empty($this->request->query['branch_list']) && $this->request->query['branch_list'] != -1) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('ListOfComputer.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }

        if (!empty($this->request->query['employee_id']) && $this->request->query['employee_id'] != -1) {
            $employeeConditions[] = array('ListOfComputer.employee_id' => $this->request->query['employee_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $employeeConditions);
            else
                $conditions[] = array('or' => $employeeConditions);
        }
        if ($this->request->query['supplier_registration_id'] != -1) {
            $supplierConditions[] = array('ListOfComputer.supplier_registration_id' => $this->request->query['supplier_registration_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $supplierConditions);
            else
                $conditions[] = array('or' => $supplierConditions);
        }
        if ($this->request->query['purchase_order_id'] != -1) {
            $purchaseOrderConditions[] = array('ListOfComputer.purchase_order_id' => $this->request->query['purchase_order_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $purchaseOrderConditions);
            else
                $conditions[] = array('or' => $purchaseOrderConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('ListOfComputer.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'ListOfComputer.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('ListOfComputer.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('ListOfComputer.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->ListOfComputer->recursive = 0;
        $this->paginate = array('order' => array('ListOfComputer.sr_no' => 'DESC'), 'conditions' => $conditions, 'ListOfComputer.soft_delete' => 0);
        $this->set('listOfComputers', $this->paginate());

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
        if (!$this->ListOfComputer->exists($id)) {
            throw new NotFoundException(__('Invalid list of computer'));
        }
        $options = array('conditions' => array('ListOfComputer.' . $this->ListOfComputer->primaryKey => $id));
        $this->set('listOfComputer', $this->ListOfComputer->find('first', $options));
        $this->set('listOfComputerSoftware', $this->ListOfComputer->ListOfComputerListOfSoftware->find('all', array('conditions'=>array('ListOfComputerListOfSoftware.list_of_computer_id'=>$id),'recursive'=>0)));
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

            $this->request->data['ListOfComputer']['system_table_id'] = $this->_get_system_table_id();
            $this->ListOfComputer->create();
            if ($this->ListOfComputer->save($this->request->data)) {
                $this->loadModel('ListOfComputerListOfSoftware');
                foreach ($this->request->data['ListOfComputerListOfSoftware'] as $val) {
                    $this->ListOfComputerListOfSoftware->create();
                    $val['list_of_computer_id'] = $this->ListOfComputer->id;
                    $val['publish'] = $this->request->data['ListOfComputer']['publish'];
                    $val['branchid'] = $this->request->data['ListOfComputer']['branchid'];
                    $val['departmentid'] = $this->request->data['ListOfComputer']['departmentid'];
                    $val['prepared_by'] = $this->request->data['ListOfComputer']['prepared_by'];
                    $val['approved_by'] = $this->request->data['ListOfComputer']['approved_by'];
                    $val['created_by'] = $this->Session->read('User.id');
                    $val['modified_by'] = $this->Session->read('User.id');
                    $val['system_table_id'] = $this->_get_system_table_id();
                    $this->ListOfComputerListOfSoftware->save($val, false);
                }

                $this->Session->setFlash(__('The computer has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->ListOfComputer->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The computer could not be saved. Please, try again.'));
            }
        }
        $this->loadModel('ListOfSoftware');
        $listOfSoftwares = $this->ListOfSoftware->find('list', array('conditions' => array('ListOfSoftware.publish' => 1, 'ListOfSoftware.soft_delete' => 0)));
        $supplierRegistrations = $this->ListOfComputer->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
        $purchaseOrders = $this->ListOfComputer->PurchaseOrder->find('list', array('conditions' => array('PurchaseOrder.publish' => 1, 'PurchaseOrder.soft_delete' => 0)));
        $this->set(compact('supplierRegistrations', 'purchaseOrders', 'listOfSoftwares'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->ListOfComputer->exists($id)) {
            throw new NotFoundException(__('Invalid list of computer'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['ListOfComputer']['system_table_id'] = $this->_get_system_table_id();
            if ($this->ListOfComputer->save($this->request->data)) {
                $this->loadModel('ListOfComputerListOfSoftware');
                $this->ListOfComputerListOfSoftware->deleteAll(array('list_of_computer_id' => $this->ListOfComputer->id), false);
                foreach ($this->request->data['ListOfComputerListOfSoftware'] as $val) {
                    $this->ListOfComputerListOfSoftware->create();
                    $val['list_of_computer_id'] = $this->ListOfComputer->id;
                    $val['publish'] = $this->request->data['ListOfComputer']['publish'];
                    $val['branchid'] = $this->request->data['ListOfComputer']['branchid'];
                    $val['departmentid'] = $this->request->data['ListOfComputer']['departmentid'];
                    $val['prepared_by'] = $this->request->data['ListOfComputer']['prepared_by'];
                    $val['approved_by'] = $this->request->data['ListOfComputer']['approved_by'];
                    $val['created_by'] = $this->Session->read('User.id');
                    $val['modified_by'] = $this->Session->read('User.id');
                    $val['system_table_id'] = $this->_get_system_table_id();
                    $this->ListOfComputerListOfSoftware->save($val, false);
                }

                $this->Session->setFlash(__('The computer has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The computer could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ListOfComputer.' . $this->ListOfComputer->primaryKey => $id));
            $this->request->data = $this->ListOfComputer->find('first', $options);
        }
        $this->loadModel('ListOfComputerListOfSoftware');
        $listOfComputerListOfSoftware = $this->ListOfComputerListOfSoftware->find('all', array('conditions' => array('ListOfComputerListOfSoftware.list_of_computer_id' => $id, 'ListOfComputerListOfSoftware.soft_delete' => 0), 'recursive' => -1 ));
        foreach ($listOfComputerListOfSoftware as $key => $val) {
            $this->request->data['ListOfComputerListOfSoftware'][$key] = $val['ListOfComputerListOfSoftware'];
        }
        $this->loadModel('ListOfSoftware');
        $listOfSoftwares = $this->ListOfSoftware->find('list', array('conditions' => array('ListOfSoftware.publish' => 1, 'ListOfSoftware.soft_delete' => 0)));
        $supplierRegistrations = $this->ListOfComputer->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
        $purchaseOrders = $this->ListOfComputer->PurchaseOrder->find('list', array('conditions' => array('PurchaseOrder.publish' => 1, 'PurchaseOrder.soft_delete' => 0)));
        $this->set(compact('listOfComputerListOfSoftware', 'listOfSoftwares', 'supplierRegistrations', 'purchaseOrders'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->ListOfComputer->exists($id)) {
            throw new NotFoundException(__('Invalid list of computer'));
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
            if ($this->ListOfComputer->save($this->request->data)) {
                $this->loadModel('ListOfComputerListOfSoftware');
                $this->ListOfComputerListOfSoftware->deleteAll(array('list_of_computer_id' => $this->ListOfComputer->id), false);
                foreach ($this->request->data['ListOfComputerListOfSoftware'] as $val) {
                    $this->ListOfComputerListOfSoftware->create();
                    $val['list_of_computer_id'] = $this->ListOfComputer->id;
                    $val['publish'] = $this->request->data['ListOfComputer']['publish'];
                    $val['branchid'] = $this->request->data['ListOfComputer']['branchid'];
                    $val['departmentid'] = $this->request->data['ListOfComputer']['departmentid'];
                    $val['prepared_by'] = $this->request->data['ListOfComputer']['prepared_by'];
                    $val['approved_by'] = $this->request->data['ListOfComputer']['approved_by'];
                    $val['created_by'] = $this->Session->read('User.id');
                    $val['modified_by'] = $this->Session->read('User.id');
                    $val['system_table_id'] = $this->_get_system_table_id();
                    $this->ListOfComputerListOfSoftware->save($val, false);
                }

                $this->Session->setFlash(__('The Computer has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The computer could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ListOfComputer.' . $this->ListOfComputer->primaryKey => $id));
            $this->request->data = $this->ListOfComputer->find('first', $options);
        }
        $this->loadModel('ListOfComputerListOfSoftware');
        $listOfComputerListOfSoftware = $this->ListOfComputerListOfSoftware->find('all', array('conditions' => array('ListOfComputerListOfSoftware.list_of_computer_id' => $id, 'ListOfComputerListOfSoftware.soft_delete' => 0)));
        foreach ($listOfComputerListOfSoftware as $key => $val) {
            $this->request->data['ListOfComputerListOfSoftware'][$key] = $val['ListOfComputerListOfSoftware'];
        }
        $this->loadModel('ListOfSoftware');
        $listOfSoftwares = $this->ListOfSoftware->find('list', array('conditions' => array('ListOfSoftware.publish' => 1, 'ListOfSoftware.soft_delete' => 0)));
        $supplierRegistrations = $this->ListOfComputer->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
        $purchaseOrders = $this->ListOfComputer->PurchaseOrder->find('list', array('conditions' => array('PurchaseOrder.publish' => 1, 'PurchaseOrder.soft_delete' => 0)));

        $this->set(compact('supplierRegistrations', 'purchaseOrders', 'listOfComputerListOfSoftware', 'listOfSoftwares'));
    }

    public function add_new_software($i = null) {
        $this->set('i', $i);
        $this->loadModel('ListOfSoftware');
        $listOfSoftwares = $this->ListOfSoftware->find('list', array('conditions' => array('ListOfSoftware.publish' => 1, 'ListOfSoftware.soft_delete' => 0)));
        $this->set('listOfSoftwares', $listOfSoftwares);
        $this->render('add_new_software');
    }

}
