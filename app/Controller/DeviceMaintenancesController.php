<?php

App::uses('AppController', 'Controller');

/**
 * DeviceMaintenances Controller
 *
 * @property DeviceMaintenance $DeviceMaintenance
 */
class DeviceMaintenancesController extends AppController {

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
        $this->paginate = array('order' => array('DeviceMaintenance.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->DeviceMaintenance->recursive = 0;
        $this->set('deviceMaintenances', $this->paginate());

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
                        $searchArray[] = array('DeviceMaintenance.' . $search => $searchKey);
                    else
                        $searchArray[] = array('DeviceMaintenance.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('DeviceMaintenance.branchid' => $branches);
            endforeach;
            $conditions[] = array('or' => $branchConditions);
        }

        if ($this->request->query['device_id'] != -1) {
            $branchConditions = array('DeviceMaintenance.device_id' => $this->request->query['device_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $branchConditions);
            else
                $conditions[] = array('or' => $branchConditions);
        }

        if ($this->request->query['employee_id'] != -1) {
            $employeeConditions = array('DeviceMaintenance.employee_id' => $this->request->query['employee_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $employeeConditions);
            else
                $conditions[] = array('or' => $employeeConditions);
        }

        if ($this->request->query['intimation_sent_to_employee_id'] != -1) {
            $intToEmp = array('DeviceMaintenance.intimation_sent_to_employee_id' => $this->request->query['intimation_sent_to_employee_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $intToEmp);
            else
                $conditions[] = array('or' => $intToEmp);
        }

        if ($this->request->query['intimation_sent_to_department_id'] != -1) {
            $intToDept = array('DeviceMaintenance.intimation_sent_to_department_id' => $this->request->query['intimation_sent_to_department_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $intToDept);
            else
                $conditions[] = array('or' => $intToDept);
        }

        if ($this->request->query['maintenance_performed_date'] != '') {
            $maintainanceDate = array('DeviceMaintenance.maintenance_performed_date' => $this->request->query['maintenance_performed_date']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $maintainanceDate);
            else
                $conditions[] = array('or' => $maintainanceDate);
        }

        if ($this->request->query['next_maintanence_date'] != '') {
            $nextmDate = array('DeviceMaintenance.next_maintanence_date' => $this->request->query['next_maintanence_date']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $nextmDate);
            else
                $conditions[] = array('or' => $nextmDate);
        }

        if ($this->request->query['status'] != '') {
            $statusConditions = array('DeviceMaintenance.status' => $this->request->query['status']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $statusConditions);
            else
                $conditions[] = array('or' => $statusConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('DeviceMaintenance.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'DeviceMaintenance.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('DeviceMaintenance.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('DeviceMaintenance.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->DeviceMaintenance->recursive = 0;
        $this->paginate = array('order' => array('DeviceMaintenance.sr_no' => 'DESC'), 'conditions' => $conditions, 'DeviceMaintenance.soft_delete' => 0);
        $this->set('deviceMaintenances', $this->paginate());

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
        if (!$this->DeviceMaintenance->exists($id)) {
            throw new NotFoundException(__('Invalid device maintenance'));
        }
        $options = array('conditions' => array('DeviceMaintenance.' . $this->DeviceMaintenance->primaryKey => $id));
        $this->set('deviceMaintenance', $this->DeviceMaintenance->find('first', $options));
    }

    /**
     * list method
     *
     * @return void
     */
    public function lists($previousId = null) {

        $this->_get_count();
        $this->set('previousId', $previousId);
    }

    //Device Maintainance Element
    public function get_device_maintainance() {
        $currentDate = date('Y-m-d');
        $nextDate = date("Y-m-d", strtotime("$currentDate +7 day"));
        $this->paginate = array('limit' => 2, 'fields' => array('DeviceMaintenance.id', 'DeviceMaintenance.maintenance_performed_date', 'DeviceMaintenance.next_maintanence_date', 'DeviceMaintenance.status', 'Device.id', 'Device.name'), 'conditions' => array('DeviceMaintenance.next_maintanence_date between ? and ?' => array($currentDate, $nextDate)), 'recursive' => 0,);
        $deviceMaintainancesCount = $this->DeviceMaintenance->find('count', array('conditions' => array('DeviceMaintenance.next_maintanence_date between ? and ?' => array($currentDate, $nextDate)), 'recursive' => 0));
        $deviceMaintainances = $this->paginate();
        $this->set('deviceMaintainances', $deviceMaintainances);
        $this->set('deviceMaintainancesCount', $deviceMaintainancesCount);
        $this->render('/Elements/device_maintainance');
    }

    /**
     *
     *
     * add_ajax method
     *
     * @return void
     */
    public function add_ajax($previousId = null) {

        if (isset($previousId)) {
            $maintenanceData = $this->DeviceMaintenance->find('first', array('conditions' => array('DeviceMaintenance.id' => $previousId), 'fields' => array('DeviceMaintenance.device_id', 'DeviceMaintenance.employee_id', 'DeviceMaintenance.status', 'DeviceMaintenance.next_maintanence_date', 'Device.maintenance_frequency'), 'recursive' => 0));

            $maintenanceDataNMD = $maintenanceData['DeviceMaintenance']['next_maintanence_date'];
            $maintenanceFrequency = $maintenanceData['Device']['maintenance_frequency'];
            switch ($maintenanceFrequency) {
                //Daily
                case '52487014-1448-45ae-82c3-4f1fc6c3268c' :
                    $nextMaintenanceDate = date('Y-m-d', strtotime($maintenanceDataNMD . ' + 1 day'));
                    break;
                //Weekly
                case '5248701d-1390-4782-9990-4f1fc6c3268c' :
                    $nextMaintenanceDate = date('Y-m-d', strtotime($maintenanceDataNMD . ' +1 week'));
                    break;
                //Forth-night
                case '52487027-260c-4196-8062-543vc6c3268c' :
                    $nextMaintenanceDate = date('Y-m-d', strtotime($maintenanceDataNMD . ' +15 days'));
                    break;
                //Monthly
                case '52487027-260c-4196-8062-543bn6c3268c' :
                    $nextMaintenanceDate = date('Y-m-d', strtotime($maintenanceDataNMD . ' +1 month'));
                    break;
                //Quarterly
                case '52487033-b1a8-436f-b0a9-53a7q6c3268c' :
                    $nextMaintenanceDate = date('Y-m-d', strtotime($maintenanceDataNMD . ' +4 months'));
                    break;
                //Twice a year
                case '52487033-b1a8-436f-b0a9-53a7c8c3268c' :
                    $nextMaintenanceDate = date('Y-m-d', strtotime($maintenanceDataNMD . ' +6 months'));
                    break;
                //Yearly
                case '530df9f4-fff8-454e-aa24-71f5b6329416' :
                    $nextMaintenanceDate = date('Y-m-d', strtotime($maintenanceDataNMD . ' +1 year'));
                    break;

                default :
                    $nextMaintenanceDate = date('Y-m-d');
            }
        }

        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }

        if ($this->request->is('post')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['DeviceMaintenance']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['DeviceMaintenance']['created_by'] = $this->Session->read('User.id');
            $this->request->data['DeviceMaintenance']['modified_by'] = $this->Session->read('User.id');
            $this->request->data['DeviceMaintenance']['created'] = date('Y-m-d H:i:s');
            $this->request->data['DeviceMaintenance']['modified'] = date('Y-m-d H:i:s');
            $this->DeviceMaintenance->create();

            if ($this->DeviceMaintenance->save($this->request->data)) {
                $this->Session->setFlash(__('The device maintenance has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->DeviceMaintenance->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The device maintenance could not be saved. Please, try again.'));
            }
        }

        $devices = $this->DeviceMaintenance->Device->find('list', array('conditions' => array('Device.publish' => 1, 'Device.soft_delete' => 0, 'Device.maintenance_required' => 1)));
        $employees = $this->DeviceMaintenance->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $intimationSentToEmployees = $this->DeviceMaintenance->IntimationSentToEmployee->find('list', array('conditions' => array('IntimationSentToEmployee.publish' => 1, 'IntimationSentToEmployee.soft_delete' => 0)));
        $intimationSentToDepartments = $this->DeviceMaintenance->IntimationSentToDepartment->find('list', array('conditions' => array('IntimationSentToDepartment.publish' => 1, 'IntimationSentToDepartment.soft_delete' => 0)));
        $companies = $this->DeviceMaintenance->Company->find('list', array('conditions' => array('Company.publish' => 1, 'Company.soft_delete' => 0)));
        $this->set(compact('devices', 'employees', 'intimationSentToEmployees', 'intimationSentToDepartments', 'companies', 'maintenanceData', 'nextMaintenanceDate'));
    }

    /**
     *  *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->DeviceMaintenance->exists($id)) {
            throw new NotFoundException(__('Invalid device maintenance'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['DeviceMaintenance']['system_table_id'] = $this->_get_system_table_id();
            if ($this->DeviceMaintenance->save($this->request->data)) {
                $this->Session->setFlash(__('The device maintenance has been published'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The device maintenance could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('DeviceMaintenance.' . $this->DeviceMaintenance->primaryKey => $id));
            $this->request->data = $this->DeviceMaintenance->find('first', $options);
        }
        $devices = $this->DeviceMaintenance->Device->find('list', array('conditions' => array('Device.publish' => 1, 'Device.soft_delete' => 0)));
        $employees = $this->DeviceMaintenance->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $intimationSentToEmployees = $this->DeviceMaintenance->IntimationSentToEmployee->find('list', array('conditions' => array('IntimationSentToEmployee.publish' => 1, 'IntimationSentToEmployee.soft_delete' => 0)));
        $intimationSentToDepartments = $this->DeviceMaintenance->IntimationSentToDepartment->find('list', array('conditions' => array('IntimationSentToDepartment.publish' => 1, 'IntimationSentToDepartment.soft_delete' => 0)));
        $this->set(compact('devices', 'employees', 'intimationSentToEmployees', 'intimationSentToDepartments'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->DeviceMaintenance->exists($id)) {
            throw new NotFoundException(__('Invalid device maintenance'));
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
            if ($this->DeviceMaintenance->save($this->request->data)) {
                $this->Session->setFlash(__('The device maintenance has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The device maintenance could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('DeviceMaintenance.' . $this->DeviceMaintenance->primaryKey => $id));
            $this->request->data = $this->DeviceMaintenance->find('first', $options);
        }
        $devices = $this->DeviceMaintenance->Device->find('list', array('conditions' => array('Device.publish' => 1, 'Device.soft_delete' => 0)));
        $employees = $this->DeviceMaintenance->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $intimationSentToEmployees = $this->DeviceMaintenance->IntimationSentToEmployee->find('list', array('conditions' => array('IntimationSentToEmployee.publish' => 1, 'IntimationSentToEmployee.soft_delete' => 0)));
        $intimationSentToDepartments = $this->DeviceMaintenance->IntimationSentToDepartment->find('list', array('conditions' => array('IntimationSentToDepartment.publish' => 1, 'IntimationSentToDepartment.soft_delete' => 0)));
        $this->set(compact('devices', 'employees', 'intimationSentToEmployees', 'intimationSentToDepartments'));
    }

}
