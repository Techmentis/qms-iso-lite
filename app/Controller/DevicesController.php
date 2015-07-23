<?php

App::uses('AppController', 'Controller');

/**
 * Devices Controller
 *
 * @property Device $Device
 */
class DevicesController extends AppController {

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
        $this->paginate = array('order' => array('Device.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->Device->recursive = 0;
        $this->set('devices', $this->paginate());

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
                        $searchArray[] = array('Device.' . $search => $SearchKey);
                    else
                        $searchArray[] = array('Device.' . $search . ' like ' => '%' . $SearchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }
        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('Device.branch_id' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }

        if ($this->request->query['department_id']) {
            foreach ($this->request->query['department_id'] as $department):
                $departmentConditions[] = array('Device.department_id' => $department);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $departmentConditions));
            else
                $conditions[] = array('or' => $departmentConditions);
        }
        if ($this->request->query['supplier_registration_id'] != -1) {
            $supplierConditions = array('Device.supplier_registration_id' => $this->request->query['supplier_registration_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $supplierConditions);
            else
                $conditions[] = array('or' => $supplierConditions);
        }
        if ($this->request->query['calibration_required'] != '') {
            $calibrationRequired = array('Device.calibration_required' => $this->request->query['calibration_required']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $calibrationRequired);
            else
                $conditions[] = array('or' => $calibrationRequired);
        }
        if ($this->request->query['manual'] != '') {
            $manualConditions = array('Device.manual' => $this->request->query['manual']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $manualConditions);
            else
                $conditions[] = array('or' => $manualConditions);
        }
        if ($this->request->query['calibration_frequency'] != -1) {
            $calibrationFrequency = array('Device.calibration_frequency' => $this->request->query['calibration_frequency']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $calibrationFrequency);
            else
                $conditions[] = array('or' => $calibrationFrequency);
        }
        if ($this->request->query['sparelist'] != '') {
            $sparelistConditions = array('Device.sparelist' => $this->request->query['sparelist']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' =>  $sparelistConditions);
            else
                $conditions[] = array('or' =>  $sparelistConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('Device.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'Device.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);
        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('Device.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Device.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->Device->recursive = 0;
        $this->paginate = array('order' => array('Device.sr_no' => 'DESC'), 'conditions' => $conditions, 'Device.soft_delete' => 0);
        $this->set('devices', $this->paginate());

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
        if (!$this->Device->exists($id)) {
            throw new NotFoundException(__('Invalid device'));
        }
        $options = array('conditions' => array('Device.' . $this->Device->primaryKey => $id));
        $this->set('device', $this->Device->find('first', $options));
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

            $this->request->data['Device']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['Device']['created_by'] = $this->Session->read('User.id');
            $this->request->data['Device']['modified_by'] = $this->Session->read('User.id');
            $this->request->data['Device']['created'] = date('Y-m-d H:i:s');
            $this->request->data['Device']['modified'] = date('Y-m-d H:i:s');
            $this->Device->create();
            if ($this->Device->save($this->request->data, false)) {
                $this->Session->setFlash(__('The device has been saved'));

                // Add details to measuing devices for calibrations table
                if ($this->request->data['Device']['calibration_required'] == 0) {
                    $this->loadModel('ListOfMeasuringDevicesForCalibration');
                    $data['device_id'] = $this->Device->id;
                    $data['least_count'] = $this->request->data['Device']['least_count'];
                    $data['required_accuracy'] = $this->request->data['Device']['required_accuracy'];
                    $data['range'] = $this->request->data['Device']['range'];
                    $data['default_calibration'] = $this->request->data['Device']['default_calibration'];
                    $data['required_calibration'] = $this->request->data['Device']['required_calibration'];
                    $data['actual_calibration'] = $this->request->data['Device']['actual_calibration'];
                    $data['calibration_frequency'] = $this->request->data['Device']['calibration_frequency'];
                    $data['publish'] = $this->request->data['Device']['publish'];
                    $this->ListOfMeasuringDevicesForCalibration->create();
                    $this->ListOfMeasuringDevicesForCalibration->save($data);
                }

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->Device->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The device could not be saved. Please, try again.'));
            }
        }
        $supplierRegistrations = $this->Device->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
	$schedule = $this->get_model_list('Schedule');
        $calibrationFrequencies = $schedule;
        $maintenanceFrequencies = $schedule; 
        $employees = $this->Device->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $branches = $this->Device->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $departments = $this->Device->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0)));
        $this->set(compact('supplierRegistrations', 'employees', 'calibrationFrequencies', 'maintenanceFrequencies', 'branches', 'departments'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Device->exists($id)) {
            throw new NotFoundException(__('Invalid device'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }

            $this->request->data['Device']['system_table_id'] = $this->_get_system_table_id();

            if ($this->Device->save($this->request->data)) {
                $this->Session->setFlash(__('The device has been saved'));

                if ($this->request->data['Device']['calibration_required'] == 0) {

                    $this->loadModel('ListOfMeasuringDevicesForCalibration');
                    $dev = $this->ListOfMeasuringDevicesForCalibration->find('first', array('conditions' => array('ListOfMeasuringDevicesForCalibration.device_id' => $id)));
                    if ($dev) {
                        $this->ListOfMeasuringDevicesForCalibration->create();
                        $this->ListOfMeasuringDevicesForCalibration->read(null, $dev['ListOfMeasuringDevicesForCalibration']['id']);
                        $this->loadModel('ListOfMeasuringDevicesForCalibration');
                        $data['device_id'] = $this->Device->id;
                        $data['least_count'] = $this->request->data['Device']['least_count'];
                        $data['required_accuracy'] = $this->request->data['Device']['required_accuracy'];
                        $data['range'] = $this->request->data['Device']['range'];
                        $data['default_calibration'] = $this->request->data['Device']['default_calibration'];
                        $data['required_calibration'] = $this->request->data['Device']['required_calibration'];
                        $data['actual_calibration'] = $this->request->data['Device']['actual_calibration'];
                        $data['calibration_frequency'] = $this->request->data['Device']['calibration_frequency'];
                        $data['publish'] = $this->request->data['Device']['publish'];
                        $this->ListOfMeasuringDevicesForCalibration->save($data, false);
                    } else {
                        $data['device_id'] = $this->Device->id;
                        $data['least_count'] = $this->request->data['Device']['least_count'];
                        $data['required_accuracy'] = $this->request->data['Device']['required_accuracy'];
                        $data['range'] = $this->request->data['Device']['range'];
                        $data['default_calibration'] = $this->request->data['Device']['default_calibration'];
                        $data['required_calibration'] = $this->request->data['Device']['required_calibration'];
                        $data['actual_calibration'] = $this->request->data['Device']['actual_calibration'];
                        $data['calibration_frequency'] = $this->request->data['Device']['calibration_frequency'];
                        $data['publish'] = $this->request->data['Device']['publish'];
                        $this->ListOfMeasuringDevicesForCalibration->create();
                        $this->ListOfMeasuringDevicesForCalibration->save($data);
                    }
                } else {
                    $this->loadModel('ListOfMeasuringDevicesForCalibration');
                    $dev = $this->ListOfMeasuringDevicesForCalibration->find('first', array('conditions' => array('ListOfMeasuringDevicesForCalibration.device_id' => $id)));
                    if ($dev) {
                        $this->ListOfMeasuringDevicesForCalibration->delete(array('ListOfMeasuringDevicesForCalibration.device_id' => $dev['ListOfMeasuringDevicesForCalibration']['id']));
                    }
                }

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The device could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Device.' . $this->Device->primaryKey => $id));
            $this->request->data = $this->Device->find('first', $options);
        }

        $supplierRegistrations = $this->Device->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
	$schedule = $this->get_model_list('Schedule');
        $calibrationFrequencies = $schedule;
        $maintenanceFrequencies = $schedule; 
      
        $employees = $this->Device->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $branches = $this->Device->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $departments = $this->Device->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0)));
        $this->set(compact('supplierRegistrations', 'employees', 'calibrationFrequencies', 'maintenanceFrequencies', 'branches', 'departments'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->Device->exists($id)) {
            throw new NotFoundException(__('Invalid device'));
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

            $this->request->data['Device']['system_table_id'] = $this->_get_system_table_id();
            if ($this->Device->save($this->request->data)) {
                $this->Session->setFlash(__('The device has been saved'));

                if ($this->request->data['Device']['calibration_required'] == 0) {
                    $this->loadModel('ListOfMeasuringDevicesForCalibration');
                    $dev = $this->ListOfMeasuringDevicesForCalibration->find('first', array('conditions' => array('ListOfMeasuringDevicesForCalibration.device_id' => $id)));
                    if ($dev) {
                        $this->ListOfMeasuringDevicesForCalibration->create();
                        $this->ListOfMeasuringDevicesForCalibration->read(null, $dev['ListOfMeasuringDevicesForCalibration']['id']);
                        $this->loadModel('ListOfMeasuringDevicesForCalibration');
                        $data['device_id'] = $this->Device->id;
                        $data['least_count'] = $this->request->data['Device']['least_count'];
                        $data['required_accuracy'] = $this->request->data['Device']['required_accuracy'];
                        $data['range'] = $this->request->data['Device']['range'];
                        $data['default_calibration'] = $this->request->data['Device']['default_calibration'];
                        $data['required_calibration'] = $this->request->data['Device']['required_calibration'];
                        $data['actual_calibration'] = $this->request->data['Device']['actual_calibration'];
                        $data['calibration_frequency'] = $this->request->data['Device']['calibration_frequency'];
                        $data['publish'] = $this->request->data['Device']['publish'];
                        $this->ListOfMeasuringDevicesForCalibration->save($data, false);
                    } else {
                        $data['device_id'] = $this->Device->id;
                        $data['least_count'] = $this->request->data['Device']['least_count'];
                        $data['required_accuracy'] = $this->request->data['Device']['required_accuracy'];
                        $data['range'] = $this->request->data['Device']['range'];
                        $data['default_calibration'] = $this->request->data['Device']['default_calibration'];
                        $data['required_calibration'] = $this->request->data['Device']['required_calibration'];
                        $data['actual_calibration'] = $this->request->data['Device']['actual_calibration'];
                        $data['calibration_frequency'] = $this->request->data['Device']['calibration_frequency'];
                        $data['publish'] = $this->request->data['Device']['publish'];
                        $this->ListOfMeasuringDevicesForCalibration->create();
                        $this->ListOfMeasuringDevicesForCalibration->save($data);
                    }
                } else {
                    $this->loadModel('ListOfMeasuringDevicesForCalibration');
                    $dev = $this->ListOfMeasuringDevicesForCalibration->find('first', array('conditions' => array('ListOfMeasuringDevicesForCalibration.device_id' => $id)));
                    if ($dev) {
                        $this->ListOfMeasuringDevicesForCalibration->delete(array('ListOfMeasuringDevicesForCalibration.device_id' => $dev['ListOfMeasuringDevicesForCalibration']['id']));
                    }
                }

                if ($this->_show_approvals()) $this->_save_approvals();

            } else {
                $this->Session->setFlash(__('The device could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Device.' . $this->Device->primaryKey => $id));
            $this->request->data = $this->Device->find('first', $options);
        }
        $supplierRegistrations = $this->Device->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
	$schedule = $this->get_model_list('Schedule');
        $calibrationFrequencies = $schedule;
        $maintenanceFrequencies = $schedule; 
	
      
        $employees = $this->Device->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $branches = $this->Device->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $departments = $this->Device->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0)));
        $this->set(compact('supplierRegistrations', 'employees', 'calibrationFrequencies', 'maintenanceFrequencies', 'branches', 'departments'));
    }

}