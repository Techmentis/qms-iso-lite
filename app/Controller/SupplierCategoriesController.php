<?php

App::uses('AppController', 'Controller');

/**
 * SupplierCategories Controller
 *
 * @property SupplierCategory $SupplierCategory
 */
class SupplierCategoriesController extends AppController {

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
        $this->paginate = array('order' => array('SupplierCategory.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->SupplierCategory->recursive = 0;
        $this->set('supplierCategories', $this->paginate());

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
                 $SearchKeys[] = trim($this->request->query['keywords']);
                } else {
                $SearchKeys = explode(" ", $this->request->query['keywords']);
                }
            foreach ($SearchKeys as $SearchKey):
                    foreach ($this->request->query['search_fields'] as $search):
                        if ($this->request->query['strict_search'] == 0)
                            $searchArray[] = array('SupplierCategory.' . $search => $SearchKey);
                        else
                            $searchArray[] = array('SupplierCategory.' . $search . ' like ' => '%' . $SearchKey . '%');

                    endforeach;
                endforeach;
                if ($this->request->query['strict_search'] == 0)
                    $conditions[] = array('and' => array('OR' => $searchArray));
                else
                    $conditions[] = array('or' => $searchArray);
            }

            if ($this->request->query['branch_list']) {
                foreach ($this->request->query['branch_list'] as $branches):
                    $branchConditions[] = array('SupplierCategory.branchid' => $branches);
                endforeach;
                if ($this->request->query['strict_search'] == 0)
                    $conditions[] = array('and' => $branchConditions);
                else
                    $conditions[] = array('or' => $branchConditions);
            }

            if (!$this->request->query['to-date'])
                $this->request->query['to-date'] = date('Y-m-d');
            if ($this->request->query['from-date']) {
                $conditions[] = array('SupplierCategory.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'SupplierCategory.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
            }
            $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);
            if ($this->Session->read('User.is_mr') == 0)
                $onlyBranch = array('SupplierCategory.branch_id' => $this->Session->read('User.branch_id'));
            if ($this->Session->read('User.is_view_all') == 0)
                $onlyOwn = array('SupplierCategory.created_by' => $this->Session->read('User.id'));
            $conditions[] = array($onlyBranch, $onlyOwn);

            $this->SupplierCategory->recursive = 0;
            $this->paginate = array('order' => array('SupplierCategory.sr_no' => 'DESC'), 'conditions' => $conditions, 'SupplierCategory.soft_delete' => 0);
            $this->set('supplierCategories', $this->paginate());
        
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
        if (!$this->SupplierCategory->exists($id)) {
            throw new NotFoundException(__('Invalid supplier category'));
        }
        $options = array('conditions' => array('SupplierCategory.' . $this->SupplierCategory->primaryKey => $id));
        $this->set('supplierCategory', $this->SupplierCategory->find('first', $options));
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
            $this->request->data['SupplierCategory']['system_table_id'] = $this->_get_system_table_id();
            $this->SupplierCategory->create();
            if ($this->SupplierCategory->save($this->request->data)) {

                $this->Session->setFlash(__('The supplier category has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->SupplierCategory->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The supplier category could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->SupplierCategory->exists($id)) {
            throw new NotFoundException(__('Invalid supplier category'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['SupplierCategory']['system_table_id'] = $this->_get_system_table_id();
            if ($this->SupplierCategory->save($this->request->data)) {

                $this->Session->setFlash(__('The supplier category has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The supplier category could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('SupplierCategory.' . $this->SupplierCategory->primaryKey => $id));
            $this->request->data = $this->SupplierCategory->find('first', $options);
        }
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->SupplierCategory->exists($id)) {
            throw new NotFoundException(__('Invalid supplier category'));
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
            if ($this->SupplierCategory->save($this->request->data)) {

                $this->Session->setFlash(__('The supplier category has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The supplier category could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('SupplierCategory.' . $this->SupplierCategory->primaryKey => $id));
            $this->request->data = $this->SupplierCategory->find('first', $options);
        }
    }

}
