<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * UsernamePasswordDetails Controller
 *
 * @property UsernamePasswordDetail $UsernamePasswordDetail
 */
class UsernamePasswordDetailsController extends AppController {

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
        $this->paginate = array('order' => array('UsernamePasswordDetail.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->UsernamePasswordDetail->recursive = 0;
        $this->set('usernamePasswordDetails', $this->paginate());

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
                        $searchArray[] = array('UsernamePasswordDetail.' . $search => $searchKey);
                    else
                        $searchArray[] = array('UsernamePasswordDetail.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('UsernamePasswordDetail.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['computer_id'] != -1) {
            $computerConditions[] = array('UsernamePasswordDetail.list_of_computer_id' => $this->request->query['computer_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $computerConditions));
            else
                $conditions[] = array('or' => $computerConditions);
        }
        if ($this->request->query['employee_id'] != -1) {
            $employeeConditions[] = array('UsernamePasswordDetail.employee_id' => $this->request->query['employee_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $employeeConditions));
            else
                $conditions[] = array('or' => $employeeConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('UsernamePasswordDetail.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'UsernamePasswordDetail.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);
        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('UsernamePasswordDetail.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('UsernamePasswordDetail.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->UsernamePasswordDetail->recursive = 0;
        $this->paginate = array('order' => array('UsernamePasswordDetail.sr_no' => 'DESC'), 'conditions' => $conditions, 'UsernamePasswordDetail.soft_delete' => 0);
        $this->set('usernamePasswordDetails', $this->paginate());
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
        if (!$this->UsernamePasswordDetail->exists($id)) {
            throw new NotFoundException(__('Invalid username password detail'));
        }
        $options = array('conditions' => array('UsernamePasswordDetail.' . $this->UsernamePasswordDetail->primaryKey => $id));
        $this->set('usernamePasswordDetail', $this->UsernamePasswordDetail->find('first', $options));
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
            $this->request->data['UsernamePasswordDetail']['system_table_id'] = $this->_get_system_table_id();
            $this->UsernamePasswordDetail->create();
            if ($this->UsernamePasswordDetail->save($this->request->data)) {

                $this->Session->setFlash(__('The username password detail has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->UsernamePasswordDetail->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The username password detail could not be saved. Please, try again.'));
            }
        }
        $listOfComputers = $this->UsernamePasswordDetail->ListOfComputer->find('list', array('conditions' => array('ListOfComputer.publish' => 1, 'ListOfComputer.soft_delete' => 0)));
        $this->set(compact('listOfComputers'));
     }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->UsernamePasswordDetail->exists($id)) {
            throw new NotFoundException(__('Invalid username password detail'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['UsernamePasswordDetail']['system_table_id'] = $this->_get_system_table_id();
            if ($this->UsernamePasswordDetail->save($this->request->data)) {

                $this->Session->setFlash(__('The username password detail has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The username password detail could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('UsernamePasswordDetail.' . $this->UsernamePasswordDetail->primaryKey => $id));
            $this->request->data = $this->UsernamePasswordDetail->find('first', $options);
        }
        $listOfComputers = $this->UsernamePasswordDetail->ListOfComputer->find('list', array('conditions' => array('ListOfComputer.publish' => 1, 'ListOfComputer.soft_delete' => 0)));
        $employees = $this->UsernamePasswordDetail->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $this->set(compact('listOfComputers', 'employees'));
     }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->UsernamePasswordDetail->exists($id)) {
            throw new NotFoundException(__('Invalid username password detail'));
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
            $this->request->data['UsernamePasswordDetail']['system_table_id'] = $this->_get_system_table_id();
            if ($this->UsernamePasswordDetail->save($this->request->data)) {

                $this->Session->setFlash(__('The username password detail has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The username password detail could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('UsernamePasswordDetail.' . $this->UsernamePasswordDetail->primaryKey => $id));
            $this->request->data = $this->UsernamePasswordDetail->find('first', $options);
        }
        $listOfComputers = $this->UsernamePasswordDetail->ListOfComputer->find('list', array('conditions' => array('ListOfComputer.publish' => 1, 'ListOfComputer.soft_delete' => 0)));
        $employees = $this->UsernamePasswordDetail->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $this->set(compact('listOfComputers', 'employees'));
      }

}
