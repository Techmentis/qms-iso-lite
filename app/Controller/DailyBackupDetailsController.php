<?php

App::uses('AppController', 'Controller');

/**
 * DailyBackupDetails Controller
 *
 * @property DailyBackupDetail $DailyBackupDetail
 */
class DailyBackupDetailsController extends AppController {

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
        $this->paginate = array('order' => array('DailyBackupDetail.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->DailyBackupDetail->recursive = 0;
        $this->set('dailyBackupDetails', $this->paginate());

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
                        $searchArray[] = array('DailyBackupDetail.' . $search => $SearchKey);
                    else
                        $searchArray[] = array('DailyBackupDetail.' . $search . ' like ' => '%' . $SearchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('DailyBackupDetail.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $branchConditions);
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['data_back_up_id']) {
            foreach ($this->request->query['data_back_up_id'] as $dataBackup):
                $dataBackupConditions[] = array('DailyBackupDetail.data_back_up_id' => $dataBackup);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $dataBackupConditions);
            else
                $conditions[] = array('or' => $dataBackupConditions);
        }
        if ($this->request->query['device_id']) {
            foreach ($this->request->query['device_id'] as $deviceId):
                $deviceConditions[] = array('DailyBackupDetail.device_id' => $deviceId);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $deviceConditions);
            else
                $conditions[] = array('or' => $deviceConditions);
        }
        if ($this->request->query['list_of_computer_id']) {
            foreach ($this->request->query['list_of_computer_id'] as $listOfComputer):
                $listOfComputerConditions[] = array('DailyBackupDetail.list_of_computer_id' => $listOfComputer);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $listOfComputerConditions);
            else
                $conditions[] = array('or' => $listOfComputerConditions);
        }
        if ($this->request->query['employee_id']) {
            foreach ($this->request->query['employee_id'] as $employeeId):
                $employeeIdConditions[] = array('DailyBackupDetail.employee_id' => $employeeId);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $employeeIdConditions);
            else
                $conditions[] = array('or' => $employeeIdConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('DailyBackupDetail.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'DailyBackupDetail.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('DailyBackupDetail.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('DailyBackupDetail.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->DailyBackupDetail->recursive = 0;
        $this->paginate = array('order' => array('DailyBackupDetail.sr_no' => 'DESC'), 'conditions' => $conditions, 'DailyBackupDetail.soft_delete' => 0);
        $this->set('dailyBackupDetails', $this->paginate());

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
        if (!$this->DailyBackupDetail->exists($id)) {
            throw new NotFoundException(__('Invalid daily backup detail'));
        }
        $options = array('conditions' => array('DailyBackupDetail.' . $this->DailyBackupDetail->primaryKey => $id));
        $this->set('dailyBackupDetail', $this->DailyBackupDetail->find('first', $options));
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
	 $dataBackUps = $this->DailyBackupDetail->DataBackUp->find('list', array('conditions' => array('DataBackUp.publish' => 1, 'DataBackUp.soft_delete' => 0)));
        $devices = $this->DailyBackupDetail->Device->find('list', array('conditions' => array('Device.publish' => 1, 'Device.soft_delete' => 0)));
        if ($this->request->is('post')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['DailyBackupDetail']['system_table_id'] = $this->_get_system_table_id();
	    $this->request->data['DailyBackupDetail']['name'] = $dataBackUps[$this->request->data['DailyBackupDetail']['data_back_up_id']]."-".$devices[$this->request->data['DailyBackupDetail']['device_id']];
            $this->DailyBackupDetail->create();
            if ($this->DailyBackupDetail->save($this->request->data)) {
                $this->Session->setFlash(__('The daily backup detail has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->DailyBackupDetail->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The daily backup detail could not be saved. Please, try again.'));
            }
        }
               $employees = $this->DailyBackupDetail->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));

        $listOfComputers = $this->DailyBackupDetail->ListOfComputer->find('list', array('conditions' => array('ListOfComputer.publish' => 1, 'ListOfComputer.soft_delete' => 0)));
        $this->set(compact('dataBackUps', 'employees', 'devices', 'listOfComputers'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->DailyBackupDetail->exists($id)) {
            throw new NotFoundException(__('Invalid daily backup detail'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
	 $dataBackUps = $this->DailyBackupDetail->DataBackUp->find('list', array('conditions' => array('DataBackUp.publish' => 1, 'DataBackUp.soft_delete' => 0)));
	$devices = $this->DailyBackupDetail->Device->find('list', array('conditions' => array('Device.publish' => 1, 'Device.soft_delete' => 0)));

        if ($this->request->is('post') || $this->request->is('put')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['DailyBackupDetail']['system_table_id'] = $this->_get_system_table_id();
	    $this->request->data['DailyBackupDetail']['name'] = $dataBackUps[$this->request->data['DailyBackupDetail']['data_back_up_id']]."-".$devices[$this->request->data['DailyBackupDetail']['device_id']];
            if ($this->DailyBackupDetail->save($this->request->data)) {
                $this->Session->setFlash(__('The daily backup detail has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The daily backup detail could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('DailyBackupDetail.' . $this->DailyBackupDetail->primaryKey => $id));
            $this->request->data = $this->DailyBackupDetail->find('first', $options);
        }
       
        $employees = $this->DailyBackupDetail->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $listOfComputers = $this->DailyBackupDetail->ListOfComputer->find('list', array('conditions' => array('ListOfComputer.publish' => 1, 'ListOfComputer.soft_delete' => 0)));
        $this->set(compact('dataBackUps', 'employees', 'devices', 'listOfComputers'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->DailyBackupDetail->exists($id)) {
            throw new NotFoundException(__('Invalid daily backup detail'));
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
	    $this->request->data['DailyBackupDetail']['name'] = $dataBackUps[$this->request->data['DailyBackupDetail']['data_back_up_id']]."-".$devices[$this->request->data['DailyBackupDetail']['device_id']];
            if ($this->DailyBackupDetail->save($this->request->data)) {
                $this->Session->setFlash(__('The daily backup detail has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The daily backup detail could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('DailyBackupDetail.' . $this->DailyBackupDetail->primaryKey => $id));
            $this->request->data = $this->DailyBackupDetail->find('first', $options);
        }
        $dataBackUps = $this->DailyBackupDetail->DataBackUp->find('list', array('conditions' => array('DataBackUp.publish' => 1, 'DataBackUp.soft_delete' => 0)));
        $employees = $this->DailyBackupDetail->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $devices = $this->DailyBackupDetail->Device->find('list', array('conditions' => array('Device.publish' => 1, 'Device.soft_delete' => 0)));
        $listOfComputers = $this->DailyBackupDetail->ListOfComputer->find('list', array('conditions' => array('ListOfComputer.publish' => 1, 'ListOfComputer.soft_delete' => 0)));
        $this->set(compact('dataBackUps', 'employees', 'devices', 'listOfComputers'));
    }

}
