<?php

App::uses('AppController', 'Controller');

/**
 * FireExtinguishers Controller
 *
 * @property FireExtinguisher $FireExtinguisher
 */
class FireExtinguishersController extends AppController {

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
        $this->paginate = array('order' => array('FireExtinguisher.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->FireExtinguisher->recursive = 0;
        $this->set('fireExtinguishers', $this->paginate());

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
            foreach ($searchKeys as $search_key):
                foreach ($this->request->query['search_fields'] as $search):
                    if ($this->request->query['strict_search'] == 0)
                        $searchArray[] = array('FireExtinguisher.' . $search => $search_key);
                    else
                        $searchArray[] = array('FireExtinguisher.' . $search . ' like ' => '%' . $search_key . '%');
                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('FireExtinguisher.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $branchConditions);
            else
                $conditions[] = array('or' => $branchConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('FireExtinguisher.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'FireExtinguisher.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('FireExtinguisher.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('FireExtinguisher.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->FireExtinguisher->recursive = 0;
        $this->paginate = array('order' => array('FireExtinguisher.sr_no' => 'DESC'), 'conditions' => $conditions, 'FireExtinguisher.soft_delete' => 0);
        $this->set('fireExtinguishers', $this->paginate());

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
        if (!$this->FireExtinguisher->exists($id)) {
            throw new NotFoundException(__('Invalid fire extinguisher'));
        }
        $options = array('conditions' => array('FireExtinguisher.' . $this->FireExtinguisher->primaryKey => $id));
        $this->set('fireExtinguisher', $this->FireExtinguisher->find('first', $options));
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
            $this->request->data['FireExtinguisher']['system_table_id'] = $this->_get_system_table_id();
            $this->FireExtinguisher->create();
            if ($this->FireExtinguisher->save($this->request->data)) {
                $this->Session->setFlash(__('The fire extinguisher has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->FireExtinguisher->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The fire extinguisher could not be saved. Please, try again.'));
            }
        }
        $fireExtinguisherTypes = $this->FireExtinguisher->FireExtinguisherType->find('list', array('conditions' => array('FireExtinguisherType.publish' => 1, 'FireExtinguisherType.soft_delete' => 0)));
        $this->set(compact('fireExtinguisherTypes'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->FireExtinguisher->exists($id)) {
            throw new NotFoundException(__('Invalid fire extinguisher'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if(!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1){
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['FireExtinguisher']['system_table_id'] = $this->_get_system_table_id();
            if ($this->FireExtinguisher->save($this->request->data)) {
                $this->Session->setFlash(__('The fire extinguisher has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The fire extinguisher could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('FireExtinguisher.' . $this->FireExtinguisher->primaryKey => $id));
            $this->request->data = $this->FireExtinguisher->find('first', $options);
        }
        $fireExtinguisherTypes = $this->FireExtinguisher->FireExtinguisherType->find('list', array('conditions' => array('FireExtinguisherType.publish' => 1, 'FireExtinguisherType.soft_delete' => 0)));
        $this->set(compact('fireExtinguisherTypes'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->FireExtinguisher->exists($id)) {
            throw new NotFoundException(__('Invalid fire extinguisher'));
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
            $this->request->data['FireExtinguisher']['system_table_id'] = $this->_get_system_table_id();
            if ($this->FireExtinguisher->save($this->request->data)) {
                $this->Session->setFlash(__('The fire extinguisher has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The fire extinguisher could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('FireExtinguisher.' . $this->FireExtinguisher->primaryKey => $id));
            $this->request->data = $this->FireExtinguisher->find('first', $options);
        }
        $fireExtinguisherTypes = $this->FireExtinguisher->FireExtinguisherType->find('list', array('conditions' => array('FireExtinguisherType.publish' => 1, 'FireExtinguisherType.soft_delete' => 0)));
        $this->set(compact('fireExtinguisherTypes'));
    }
}