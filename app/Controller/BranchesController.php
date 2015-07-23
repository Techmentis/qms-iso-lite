<?php

App::uses('AppController', 'Controller');

/**
 * Branches Controller
 *
 * @property Branch $Branch
 */
class BranchesController extends AppController {

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
        $this->paginate = array('order' => array('Branch.sr_no' => 'DESC'), 'conditions' => array($conditions), 'recursive' => -1);

        $this->set('branches', $this->paginate());
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
                        $searchArray[] = array('Branch.' . $search => $SearchKey);
                    else
                        $searchArray[] = array('Branch.' . $search . ' like ' => '%' . $SearchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('Branch.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('Branch.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'Branch.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
	
	$conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('Branch.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Branch.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->Branch->recursive = -1;
        $this->paginate = array('order' => array('Branch.sr_no' => 'DESC'), 'conditions' => $conditions, 'Branch.soft_delete' => 0);
        $this->set('branches', $this->paginate());

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
        if (!$this->Branch->exists($id)) {
            throw new NotFoundException(__('Invalid branch'));
        }
        $options = array('conditions' => array('Branch.' . $this->Branch->primaryKey => $id));
        $this->set('branch', $this->Branch->find('first', $options));
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
            $this->request->data['Branch']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['Branch']['created_by'] = $this->Session->read('User.id');
            $this->request->data['Branch']['modified_by'] = $this->Session->read('User.id');
            $this->request->data['Branch']['created'] = date('Y-m-d H:i:s');
            $this->request->data['Branch']['modified'] = date('Y-m-d H:i:s');
            $this->Branch->create();
            if ($this->Branch->save($this->request->data)) {
                $this->Session->setFlash(__('The branch has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->Branch->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The branch could not be saved. Please, try again.'));
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
        if (!$this->Branch->exists($id)) {
            throw new NotFoundException(__('Invalid branch'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {

            if(!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1){
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['Branch']['system_table_id'] = $this->_get_system_table_id();
            if ($this->Branch->save($this->request->data)) {
                $this->Session->setFlash(__('The branch has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The branch could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Branch.' . $this->Branch->primaryKey => $id));
            $this->request->data = $this->Branch->find('first', $options);
        }
    }

    public function approve($id = null, $approvalId = null) {
        if (!$this->Branch->exists($id)) {
            throw new NotFoundException(__('Invalid branch'));
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
            if ($this->Branch->save($this->request->data)) {
                $this->Session->setFlash(__('The branch has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals();

            } else {
                $this->Session->setFlash(__('The branch could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Branch.' . $this->Branch->primaryKey => $id));
            $this->request->data = $this->Branch->find('first', $options);
        }
    }

    public function get_branch_name($branchName = null, $id = null) {
        if ($branchName) {
            if ($id) {
                $branches = $this->Branch->find('all', array('conditions' => array('Branch.name' => $branchName, 'Branch.id !=' => $id)));
            } else {
                $branches = $this->Branch->find('all', array('conditions' => array('Branch.name' => $branchName)));
            }
            $this->set('branches', $branches);
        }
    }

}
