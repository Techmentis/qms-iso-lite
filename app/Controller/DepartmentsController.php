<?php

App::uses('AppController', 'Controller');

/**
 * Departments Controller
 *
 * @property Department $Department
 */
class DepartmentsController extends AppController {

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
        $this->paginate = array('order' => array('Department.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->Department->recursive = 0;
        $this->set('departments', $this->paginate());

        $this->_get_count();
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Department->exists($id)) {
            throw new NotFoundException(__('Invalid department'));
        }
        $options = array('conditions' => array('Department.' . $this->Department->primaryKey => $id));
        $this->set('department', $this->Department->find('first', $options));
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
            $this->request->data['Department']['system_table_id'] = $this->_get_system_table_id();
            $this->Department->create();
            if ($this->Department->save($this->request->data)) {
                $this->Session->setFlash(__('The department has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->Department->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The department could not be saved. Please, try again.'));
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
        if (!$this->Department->exists($id)) {
            throw new NotFoundException(__('Invalid department'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if(!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1){
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['Department']['system_table_id'] = $this->_get_system_table_id();
            if ($this->Department->save($this->request->data)) {
                $this->Session->setFlash(__('The department has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The department could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Department.' . $this->Department->primaryKey => $id));
            $departmentData = $this->Department->find('first', $options);

            if($departmentData['Department']['sr_no'] < 10){
                $this->Session->setFlash(__('This department can not be edited'), 'default', array('class' => 'alert alert-danger'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->request->data = $departmentData;
            }
        }
    }

    
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
                        $searchArray[] = array('Department.' . $search => $SearchKey);
                    else
                        $searchArray[] = array('Department.' . $search . ' like ' => '%' . $SearchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }
        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('Department.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('Department.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'Department.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
	
	$conditions =  $this->advance_search_common($conditions);
        unset($this->request->query);
        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('Department.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Department.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->Department->recursive = -1;
        $this->paginate = array('order' => array('Department.sr_no' => 'DESC'), 'conditions' => $conditions, 'Department.soft_delete' => 0);
        $this->set('departments', $this->paginate());

        $this->render('index');
    }
    
    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->Department->exists($id)) {
            throw new NotFoundException(__('Invalid department'));
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
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            if ($this->Department->save($this->request->data)) {
                $this->Session->setFlash(__('The department has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The department could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Department.' . $this->Department->primaryKey => $id));
            $this->request->data = $this->Department->find('first', $options);
        }
    }

    public function delete($id = null) {

        $activeRecord = $this->Department->find('first', array('recursive' => -1, 'fields' => 'sr_no', 'conditions' => array('Department.id' => $id)));

        if ($activeRecord['Department']['sr_no'] < 10) {
            $this->Session->setFlash(__('This department can not be deleted.'), 'default', array('class' => 'alert alert-danger'));
            $this->redirect(array('action' => 'index'));
        } else {
            $this->loadModel('Approval');
            if (!empty($id)) {
                $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => 'Department')));
                foreach ($approves as $approve) {
                    $approve['Approval']['soft_delete'] = 1;
                    $this->Approval->save($approve, false);
                }
                $data['id'] = $id;
                $data['soft_delete'] = 1;
                $this->Department->save($data, false);
            }
            $this->Session->setFlash(__('Selected department deleted.'));
            $this->redirect(array('action' => 'index'));
        }
    }

    public function delete_all($ids = null) {
        $i = 0;
        $j = 0;
        $count = 0;
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);
        $this->loadModel('Approval');

        if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $count++;
                    $activeRecord = $this->Department->find('first', array('recursive' => -1, 'conditions' => array('Department.id' => $id)));
                    if ($activeRecord['Department']['sr_no'] < 10) {
                            $i++;
                            continue;
                    } elseif($activeRecord['Department']['record_status'] == 1){
                            $i++;
                            continue;
                    } elseif (!($activeRecord['Department']['sr_no'] < 10)) {
                        $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => 'Department')));
                        foreach ($approves as $approve) {
                            $approve['Approval']['soft_delete'] = 1;
                            $this->Approval->save($approve, false);
                        }
                        $data['id'] = $id;
                        $data['soft_delete'] = 1;
                        $this->Department->save($data, false);
                        $j++;
                    }

                }
            }
        }
        if ($i) {
            $this->Session->setFlash(__("Total {$j} of {$count} departments deleted."));
        } else {
            $this->Session->setFlash(__('All selected departments deleted.'));
        }
        $this->redirect(array('action' => 'index'));
    }

}
