<?php

App::uses('AppController', 'Controller');

/**
 * FireExtinguisherTypes Controller
 *
 * @property FireExtinguisherType $FireExtinguisherType
 */
class FireExtinguisherTypesController extends AppController {

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
        $this->paginate = array('order' => array('FireExtinguisherType.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->FireExtinguisherType->recursive = 0;
        $this->set('fireExtinguisherTypes', $this->paginate());

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
                        $searchArray[] = array('FireExtinguisherType.' . $search => $searchKey);
                    else
                        $searchArray[] = array('FireExtinguisherType.' . $search . ' like ' => '%' . $searchKey . '%');
                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }
        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('FireExtinguisherType.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $branchConditions);
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('FireExtinguisherType.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'FireExtinguisherType.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);

        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('FireExtinguisherType.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('FireExtinguisherType.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);
        $this->FireExtinguisherType->recursive = 0;
        $this->paginate = array('order' => array('FireExtinguisherType.sr_no' => 'DESC'), 'conditions' => $conditions, 'FireExtinguisherType.soft_delete' => 0);
        $this->set('fireExtinguisherTypes', $this->paginate());
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
        if (!$this->FireExtinguisherType->exists($id)) {
            throw new NotFoundException(__('Invalid fire extinguisher type'));
        }
        $options = array('conditions' => array('FireExtinguisherType.' . $this->FireExtinguisherType->primaryKey => $id));
        $this->set('fireExtinguisherType', $this->FireExtinguisherType->find('first', $options));
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
            $this->request->data['FireExtinguisherType']['system_table_id'] = $this->_get_system_table_id();
            $this->FireExtinguisherType->create();
            if ($this->FireExtinguisherType->save($this->request->data)) {
                $this->Session->setFlash(__('The fire extinguisher type has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->FireExtinguisherType->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The fire extinguisher type could not be saved. Please, try again.'));
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
        if (!$this->FireExtinguisherType->exists($id)) {
            throw new NotFoundException(__('Invalid fire extinguisher type'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if(!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1){
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['FireExtinguisherType']['system_table_id'] = $this->_get_system_table_id();
            if ($this->FireExtinguisherType->save($this->request->data)) {
                $this->Session->setFlash(__('The fire extinguisher type has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The fire extinguisher type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('FireExtinguisherType.' . $this->FireExtinguisherType->primaryKey => $id));
            $this->request->data = $this->FireExtinguisherType->find('first', $options);
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
        if (!$this->FireExtinguisherType->exists($id)) {
            throw new NotFoundException(__('Invalid fire extinguisher type'));
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
            if ($this->FireExtinguisherType->save($this->request->data)) {
                $this->Session->setFlash(__('The fire extinguisher type has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The fire extinguisher type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('FireExtinguisherType.' . $this->FireExtinguisherType->primaryKey => $id));
            $this->request->data = $this->FireExtinguisherType->find('first', $options);
        }
    }
}
