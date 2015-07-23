<?php

App::uses('AppController', 'Controller');

/**
 * SummeryOfSupplierEvaluations Controller
 *
 * @property SummeryOfSupplierEvaluation $SummeryOfSupplierEvaluation
 */
class SummeryOfSupplierEvaluationsController extends AppController {

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
        $this->paginate = array('order' => array('SummeryOfSupplierEvaluation.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->SummeryOfSupplierEvaluation->recursive = 0;
        $this->set('summeryOfSupplierEvaluations', $this->paginate());

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
                        $searchArray[] = array('SummeryOfSupplierEvaluation.' . $search => $searchKey);
                    else
                        $searchArray[] = array('SummeryOfSupplierEvaluation.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }
        if ($this->request->query['supplier_registration_id'] != -1) {
            $supplierConditions = array('SummeryOfSupplierEvaluation.supplier_registration_id' => $this->request->query['supplier_registration_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $supplierConditions);
            else
                $conditions[] = array('or' => $supplierConditions);
        }
        if ($this->request->query['suppCategory']) {
            foreach ($this->request->query['suppCategory'] as $suppCategory):
                $supplierCategoryConditions[] = array('SummeryOfSupplierEvaluation.supplier_category_id' => $suppCategory);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('or' => $supplierCategoryConditions));
            else
                $conditions[] = array('or' => $supplierCategoryConditions);
        }
        if ($this->request->query['employee_id']) {
            foreach ($this->request->query['employee_id'] as $employee_id):
                $employeeConditions[] = array('SummeryOfSupplierEvaluation.employee_id' => $employee_id);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('or' => $employeeConditions));
            else
                $conditions[] = array('or' => $employeeConditions);
        }
        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('SummeryOfSupplierEvaluation.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('or' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('SummeryOfSupplierEvaluation.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'SummeryOfSupplierEvaluation.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('SummeryOfSupplierEvaluation.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('SummeryOfSupplierEvaluation.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->SummeryOfSupplierEvaluation->recursive = 0;
        $this->paginate = array('order' => array('SummeryOfSupplierEvaluation.sr_no' => 'DESC'), 'conditions' => $conditions, 'SummeryOfSupplierEvaluation.soft_delete' => 0);
        $this->set('summeryOfSupplierEvaluations', $this->paginate());

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
        if (!$this->SummeryOfSupplierEvaluation->exists($id)) {
            throw new NotFoundException(__('Invalid summery of supplier evaluation'));
        }
        $options = array('conditions' => array('SummeryOfSupplierEvaluation.' . $this->SummeryOfSupplierEvaluation->primaryKey => $id));
        $this->set('summeryOfSupplierEvaluation', $this->SummeryOfSupplierEvaluation->find('first', $options));
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

            $this->request->data['SummeryOfSupplierEvaluation']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['SummeryOfSupplierEvaluation']['created_by'] = $this->Session->read('User.id');
            $this->request->data['SummeryOfSupplierEvaluation']['modified_by'] = $this->Session->read('User.id');
            $this->request->data['SummeryOfSupplierEvaluation']['created'] = date('Y-m-d H:i:s');
            $this->request->data['SummeryOfSupplierEvaluation']['modified'] = date('Y-m-d H:i:s');
            $this->SummeryOfSupplierEvaluation->create();
            if ($this->SummeryOfSupplierEvaluation->save($this->request->data, false)) {

                $this->Session->setFlash(__('The summary of supplier evaluation has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->SummeryOfSupplierEvaluation->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The summary of supplier evaluation could not be saved. Please, try again.'));
            }
        }
        $supplierRegistrations = $this->SummeryOfSupplierEvaluation->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
        $supplierCategories = $this->SummeryOfSupplierEvaluation->SupplierCategory->find('list', array('conditions' => array('SupplierCategory.publish' => 1, 'SupplierCategory.soft_delete' => 0)));

        $this->set(compact('supplierRegistrations', 'supplierCategories'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->SummeryOfSupplierEvaluation->exists($id)) {
            throw new NotFoundException(__('Invalid summery of supplier evaluation'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['SummeryOfSupplierEvaluation']['system_table_id'] = $this->_get_system_table_id();
            if ($this->SummeryOfSupplierEvaluation->save($this->request->data)) {

                $this->Session->setFlash(__('The summary of supplier evaluation has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The summary of supplier evaluation could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('SummeryOfSupplierEvaluation.' . $this->SummeryOfSupplierEvaluation->primaryKey => $id));
            $this->request->data = $this->SummeryOfSupplierEvaluation->find('first', $options);
        }
        $supplierRegistrations = $this->SummeryOfSupplierEvaluation->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
        $supplierCategories = $this->SummeryOfSupplierEvaluation->SupplierCategory->find('list', array('conditions' => array('SupplierCategory.publish' => 1, 'SupplierCategory.soft_delete' => 0)));

        $this->set(compact('supplierRegistrations', 'supplierCategories'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->SummeryOfSupplierEvaluation->exists($id)) {
            throw new NotFoundException(__('Invalid summery of supplier evaluation'));
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
            if ($this->SummeryOfSupplierEvaluation->save($this->request->data)) {

                $this->Session->setFlash(__('The summary of supplier evaluation has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                } else {
                $this->Session->setFlash(__('The summary of supplier evaluation could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('SummeryOfSupplierEvaluation.' . $this->SummeryOfSupplierEvaluation->primaryKey => $id));
            $this->request->data = $this->SummeryOfSupplierEvaluation->find('first', $options);
        }
        $supplierRegistrations = $this->SummeryOfSupplierEvaluation->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
        $supplierCategories = $this->SummeryOfSupplierEvaluation->SupplierCategory->find('list', array('conditions' => array('SupplierCategory.publish' => 1, 'SupplierCategory.soft_delete' => 0)));

        $this->set(compact('supplierRegistrations', 'supplierCategories'));
    }

}
