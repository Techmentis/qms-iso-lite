<?php

App::uses('AppController', 'Controller');

/**
 * Productions Controller
 *
 * @property Production $Production
 */
class ProductionsController extends AppController {

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
        $this->paginate = array('order' => array('Production.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->Production->recursive = 0;
        $this->set('productions', $this->paginate());

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
                        $searchArray[] = array('Production.' . $search => $searchKey);
                    else
                        $searchArray[] = array('Production.' . $search . ' like ' => '%' . $searchKey . '%');
                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('Production.branchid' => $branches);
            endforeach;

            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }

        if ($this->request->query['product_id'] != -1) {
            $productConditions = array('Production.product_id' => $this->request->query['product_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $productConditions);
            else
                $conditions[] = array('or' => $productConditions);
        }

        if ($this->request->query['employee_id'] != -1) {
            $employeeConditions = array('Production.employee_id' => $this->request->query['employee_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $employeeConditions);
            else
                $conditions[] = array('or' => $employeeConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('Production.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'Production.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('Production.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Production.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->Production->recursive = 0;
        $this->paginate = array('order' => array('Production.sr_no' => 'DESC'), 'conditions' => $conditions, 'Production.soft_delete' => 0);
        $this->set('productions', $this->paginate());

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
        if (!$this->Production->exists($id)) {
            throw new NotFoundException(__('Invalid production'));
        }
        $options = array('conditions' => array('Production.' . $this->Production->primaryKey => $id));
        $this->set('production', $this->Production->find('first', $options));
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
            $this->request->data['Production']['system_table_id'] = $this->_get_system_table_id();
            $this->Production->create();
            if ($this->Production->save($this->request->data)) {

                $this->Session->setFlash(__('The production has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->Production->id));
                else
                    $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
            } else {
                $this->Session->setFlash(__('The production could not be saved. Please, try again.'));
            }
        }
        $products = $this->Production->Product->find('list', array('conditions' => array('Product.publish' => 1, 'Product.soft_delete' => 0)));
        $this->set(compact('products'));
     }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Production->exists($id)) {
            throw new NotFoundException(__('Invalid production'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Production']['system_table_id'] = $this->_get_system_table_id();
            if ($this->Production->save($this->request->data)) {

                $this->Session->setFlash(__('The production has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The production could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Production.' . $this->Production->primaryKey => $id));
            $this->request->data = $this->Production->find('first', $options);
        }
        $products = $this->Production->Product->find('list', array('conditions' => array('Product.publish' => 1, 'Product.soft_delete' => 0)));
        $branches = $this->Production->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $employees = $this->Production->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $this->set(compact('products', 'branches', 'employees'));
     }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approval_id = null) {
        if (!$this->Production->exists($id)) {
            throw new NotFoundException(__('Invalid production'));
        }

        $this->loadModel('Approval');
        if (!$this->Approval->exists($approval_id)) {
            throw new NotFoundException(__('Invalid approval id'));
        }

        $approval = $this->Approval->read(null, $approval_id);
        $this->set('same', $approval['Approval']['user_id']);

        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Production->save($this->request->data)) {

                $this->Session->setFlash(__('The production has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The production could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Production.' . $this->Production->primaryKey => $id));
            $this->request->data = $this->Production->find('first', $options);
        }
        $products = $this->Production->Product->find('list', array('conditions' => array('Product.publish' => 1, 'Product.soft_delete' => 0)));
        $branches = $this->Production->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $employees = $this->Production->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $this->set(compact('products', 'branches', 'employees'));

    }
    public function get_batch($batchNumber = null, $id = null) {
        if ($batchNumber) {
            if ($id){
                $batchNumbers = $this->Production->find('all', array('conditions' => array('Production.batch_number' => $batchNumber, 'Production.id !=' => $id)));
            }else {
                $batchNumbers = $this->Production->find('all', array('conditions' => array('Production.batch_number' => $batchNumber)));
              }
           if(count($batchNumbers))
           {
            echo "Batch number already exists, please enter another batch number";
           }
         exit;
            }
        }

}
