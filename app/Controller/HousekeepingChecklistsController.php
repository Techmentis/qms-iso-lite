<?php

App::uses('AppController', 'Controller');

/**
 * HousekeepingChecklists Controller
 *
 * @property HousekeepingChecklist $HousekeepingChecklist
 */
class HousekeepingChecklistsController extends AppController {

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
        $this->paginate = array('order' => array('HousekeepingChecklist.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->HousekeepingChecklist->recursive = 0;
        $this->set('housekeepingChecklists', $this->paginate());

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
                       $searchArray[] = array('HousekeepingChecklist.' . $search => $searchKey);
                    else
                        $searchArray[] = array('HousekeepingChecklist.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' =>$searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }
        if ($this->request->query['department_id']) {
            foreach ($this->request->query['department_id'] as $departmentId):
                $departmentConditions[] = array('HousekeepingChecklist.department_id' => $departmentId);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $departmentConditions);
            else
                $conditions[] = array('or' => $departmentConditions);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('HousekeepingChecklist.branch_id' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $branchConditions);
            else
                $conditions[] = array('or' => $branchConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('HousekeepingChecklist.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'HousekeepingChecklist.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('HousekeepingChecklist.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('HousekeepingChecklist.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->HousekeepingChecklist->recursive = 0;
        $this->paginate = array('order' => array('HousekeepingChecklist.sr_no' => 'DESC'), 'conditions' => $conditions, 'HousekeepingChecklist.soft_delete' => 0);
        $this->set('housekeepingChecklists', $this->paginate());

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
        if (!$this->HousekeepingChecklist->exists($id)) {
            throw new NotFoundException(__('Invalid housekeeping checklist'));
        }
        $options = array('conditions' => array('HousekeepingChecklist.' . $this->HousekeepingChecklist->primaryKey => $id));
        $this->set('housekeepingChecklist', $this->HousekeepingChecklist->find('first', $options));
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
            $this->request->data['HousekeepingChecklist']['system_table_id'] = $this->_get_system_table_id();
            $this->HousekeepingChecklist->create();
            if ($this->HousekeepingChecklist->save($this->request->data)) {

                $this->Session->setFlash(__('The housekeeping checklist has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->HousekeepingChecklist->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The housekeeping checklist could not be saved. Please, try again.'));
            }
        }
        $branches = $this->HousekeepingChecklist->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $departments = $this->HousekeepingChecklist->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0)));
        $this->set(compact('branches', 'departments'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->HousekeepingChecklist->exists($id)) {
            throw new NotFoundException(__('Invalid housekeeping checklist'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['HousekeepingChecklist']['system_table_id'] = $this->_get_system_table_id();
            if ($this->HousekeepingChecklist->save($this->request->data)) {

                $this->Session->setFlash(__('The housekeeping checklist has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The housekeeping checklist could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('HousekeepingChecklist.' . $this->HousekeepingChecklist->primaryKey => $id));
            $this->request->data = $this->HousekeepingChecklist->find('first', $options);
        }
        $branches = $this->HousekeepingChecklist->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $departments = $this->HousekeepingChecklist->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0)));
        $this->set(compact('branches', 'departments'));
        }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->HousekeepingChecklist->exists($id)) {
            throw new NotFoundException(__('Invalid housekeeping checklist'));
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
            $this->request->data['HousekeepingChecklist']['system_table_id'] = $this->_get_system_table_id();
            if ($this->HousekeepingChecklist->save($this->request->data)) {

                $this->Session->setFlash(__('The housekeeping checklist has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The housekeeping checklist could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('HousekeepingChecklist.' . $this->HousekeepingChecklist->primaryKey => $id));
            $this->request->data = $this->HousekeepingChecklist->find('first', $options);
        }
        $branches = $this->HousekeepingChecklist->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $departments = $this->HousekeepingChecklist->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0)));
        $this->set(compact('branches', 'departments'));
    }

}