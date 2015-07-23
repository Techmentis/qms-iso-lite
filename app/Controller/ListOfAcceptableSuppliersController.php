<?php

App::uses('AppController', 'Controller');

/**
 * ListOfAcceptableSuppliers Controller
 *
 * @property ListOfAcceptableSupplier $ListOfAcceptableSupplier
 */
class ListOfAcceptableSuppliersController extends AppController {

    public function _get_system_table_id() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $sys_id = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $this->request->params['controller'])));
        return $sys_id['SystemTable']['id'];
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {

        $conditions = $this->_check_request();
        $this->paginate = array('order' => array('ListOfAcceptableSupplier.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->ListOfAcceptableSupplier->recursive = 0;
        $this->set('listOfAcceptableSuppliers', $this->paginate());

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
                        $searchArray[] = array('ListOfAcceptableSupplier.' . $search => $searchKey);
                    else
                        $searchArray[] = array('ListOfAcceptableSupplier.' . $search . ' like ' => '%' . $searchKey . '%');
                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('ListOfAcceptableSupplier.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $branchConditions);
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['suppCategory'] != -1) {
            $supplierCategoryConditions[] = array('ListOfAcceptableSupplier.supplier_category_id' => $this->request->query['suppCategory']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $supplierCategoryConditions);
            else
                $conditions[] = array('or' => $supplierCategoryConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('ListOfAcceptableSupplier.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'ListOfAcceptableSupplier.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);

        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('ListOfAcceptableSupplier.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('ListOfAcceptableSupplier.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->ListOfAcceptableSupplier->recursive = 0;
        $this->paginate = array('order' => array('ListOfAcceptableSupplier.sr_no' => 'DESC'), 'conditions' => $conditions, 'ListOfAcceptableSupplier.soft_delete' => 0);
        $this->set('listOfAcceptableSuppliers', $this->paginate());

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
        if (!$this->ListOfAcceptableSupplier->exists($id)) {
            throw new NotFoundException(__('Invalid list of acceptable supplier'));
        }
        $options = array('conditions' => array('ListOfAcceptableSupplier.' . $this->ListOfAcceptableSupplier->primaryKey => $id));
        $this->set('listOfAcceptableSupplier', $this->ListOfAcceptableSupplier->find('first', $options));
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
            $this->request->data['ListOfAcceptableSupplier']['system_table_id'] = $this->_get_system_table_id();
            $this->ListOfAcceptableSupplier->create();
            if ($this->ListOfAcceptableSupplier->save($this->request->data)) {

                $this->Session->setFlash(__('The list of acceptable supplier has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->ListOfAcceptableSupplier->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The list of acceptable supplier could not be saved. Please, try again.'));
            }
        }
        $supplierRegistrations = $this->ListOfAcceptableSupplier->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
        $supplierCategories = $this->ListOfAcceptableSupplier->SupplierCategory->find('list', array('conditions' => array('SupplierCategory.publish' => 1, 'SupplierCategory.soft_delete' => 0)));
        $this->set(compact('supplierRegistrations', 'supplierCategories'));
    }

    /*************************************************************************
     *
     *              THIS IS A REQUIRED FUNCTION. DO NOT DELETE.
     *
     *   add() IS BEING CALLED BY supplier_evaluation_reevaluations/evaluate.
     *
     *************************************************************************/

    public function add() {

        $supplier = $this->ListOfAcceptableSupplier->find('first', array('conditions' => array('ListOfAcceptableSupplier.supplier_registration_id' => $this->data['ListOfAcceptableSupplier']['supplier_registration_id'])));

        if ($supplier) {
            $this->ListOfAcceptableSupplier->id = $supplier['ListOfAcceptableSupplier']['id'];
            $this->request->data['ListOfAcceptableSupplier']['system_table_id'] = $this->_get_system_table_id();
            if ($this->ListOfAcceptableSupplier->save($this->data['ListOfAcceptableSupplier'], false)) {
                $this->loadModel('SummeryOfSupplierEvaluation');
                $this->SummeryOfSupplierEvaluation->create();
                $evaluationData['SummeryOfSupplierEvaluation'] = $this->data['ListOfAcceptableSupplier'];
                $evaluationData['SummeryOfSupplierEvaluation']['evaluation_date'] = date('Y-m-d');
                $this->SummeryOfSupplierEvaluation->save($evaluationData);

                $this->Session->setFlash(__('The list of acceptable supplier has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->ListOfAcceptableSupplier->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The list of acceptable supplier could not be saved. Please, try again.'));
            }
        } else {

            if ($this->_show_approvals()) {
                $this->set(array('showApprovals' => $this->_show_approvals()));
            }

            if ($this->request->is('post')) {
                $this->request->data['ListOfAcceptableSupplier']['system_table_id'] = $this->_get_system_table_id();
                $this->ListOfAcceptableSupplier->create();
                if ($this->ListOfAcceptableSupplier->save($this->request->data)) {

                    $this->loadModel('SummeryOfSupplierEvaluation');
                    $this->SummeryOfSupplierEvaluation->create();
                    $evaluationData['SummeryOfSupplierEvaluation'] = $this->data['ListOfAcceptableSupplier'];
                    $evaluationData['SummeryOfSupplierEvaluation']['evaluation_date'] = date('Y-m-d');
                    $this->SummeryOfSupplierEvaluation->save($evaluationData);

                    $this->Session->setFlash(__('The list of acceptable supplier has been saved'));

                    if ($this->_show_approvals()) $this->_save_approvals();

                    if ($this->_show_evidence() == true)
                        $this->redirect(array('action' => 'view', $this->ListOfAcceptableSupplier->id));
                    else
                        $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The list of acceptable supplier could not be saved. Please, try again.'));
                }
            }
        }
        $supplierRegistrations = $this->ListOfAcceptableSupplier->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
        $supplierCategories = $this->ListOfAcceptableSupplier->SupplierCategory->find('list', array('conditions' => array('SupplierCategory.publish' => 1, 'SupplierCategory.soft_delete' => 0)));
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
        if (!$this->ListOfAcceptableSupplier->exists($id)) {
            throw new NotFoundException(__('Invalid list of acceptable supplier'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['ListOfAcceptableSupplier']['system_table_id'] = $this->_get_system_table_id();
            if ($this->ListOfAcceptableSupplier->save($this->request->data)) {

                $this->Session->setFlash(__('The list of acceptable supplier has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The list of acceptable supplier could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ListOfAcceptableSupplier.' . $this->ListOfAcceptableSupplier->primaryKey => $id));
            $this->request->data = $this->ListOfAcceptableSupplier->find('first', $options);
        }
        $supplierRegistrations = $this->ListOfAcceptableSupplier->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
        $supplierCategories = $this->ListOfAcceptableSupplier->SupplierCategory->find('list', array('conditions' => array('SupplierCategory.publish' => 1, 'SupplierCategory.soft_delete' => 0)));
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
        if (!$this->ListOfAcceptableSupplier->exists($id)) {
            throw new NotFoundException(__('Invalid list of acceptable supplier'));
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
            $this->request->data['ListOfAcceptableSupplier']['system_table_id'] = $this->_get_system_table_id();
            if ($this->ListOfAcceptableSupplier->save($this->request->data)) {

                $this->Session->setFlash(__('The list of acceptable supplier has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The list of acceptable supplier could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ListOfAcceptableSupplier.' . $this->ListOfAcceptableSupplier->primaryKey => $id));
            $this->request->data = $this->ListOfAcceptableSupplier->find('first', $options);
        }
        $supplierRegistrations = $this->ListOfAcceptableSupplier->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
        $supplierCategories = $this->ListOfAcceptableSupplier->SupplierCategory->find('list', array('conditions' => array('SupplierCategory.publish' => 1, 'SupplierCategory.soft_delete' => 0)));
        $this->set(compact('supplierRegistrations', 'supplierCategories'));
    }

}
