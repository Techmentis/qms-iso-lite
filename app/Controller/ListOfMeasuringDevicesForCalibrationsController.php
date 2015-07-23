<?php

App::uses('AppController', 'Controller');

/**
 * ListOfMeasuringDevicesForCalibrations Controller
 *
 * @property ListOfMeasuringDevicesForCalibration $ListOfMeasuringDevicesForCalibration
 */
class ListOfMeasuringDevicesForCalibrationsController extends AppController {

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
        $this->loadModel('Schedule');
        $this->loadModel('Calibration');
        $this->loadModel('Device');
        $this->loadModel('Employee');
        $this->ListOfMeasuringDevicesForCalibration->recursive = 0;
        $listOfMeasuringDevicesForCalibrations = $this->ListOfMeasuringDevicesForCalibration->find('all', array(
            'conditions' => array('ListOfMeasuringDevicesForCalibration.publish' => 1, 'ListOfMeasuringDevicesForCalibration.soft_delete' => 0),
            'fields' => array('ListOfMeasuringDevicesForCalibration.id', 'ListOfMeasuringDevicesForCalibration.device_id', 'Device.name')
        ));
        $this->paginate = array('order' => array('ListOfMeasuringDevicesForCalibration.sr_no' => 'DESC'), 'conditions' => array($conditions));
        $details = $this->paginate();

        $i = 0;
        foreach ($details as $listOfMeasuringDevicesForCalibration):
            $device = $this->Device->find('first', array('recursive' => -1, 'fields' => array('id', 'name', 'calibration_frequency', 'employee_id'),'conditions' => array('Device.id' => $listOfMeasuringDevicesForCalibration['ListOfMeasuringDevicesForCalibration']['device_id'])));
            $calibration = $this->Calibration->find('first', array('recursive' => -1, 'fields' => array('id', 'calibration_date', 'next_calibration_date', 'prepared_by', 'approved_by'),'order' => array('Calibration.created' => 'DESC'), 'conditions' => array('Calibration.device_id' => $device['Device']['id'])));
            $schedule = $this->Schedule->find('first', array('recursive' => -1, 'fields' => array('Schedule.id', 'Schedule.name'), 'conditions' => array('Schedule.id' => $device['Device']['calibration_frequency'])));
            $employee = $this->Employee->find('first', array('recursive' => -1, 'fields' => array('Employee.id', 'Employee.name'), 'conditions' => array('Employee.id' => $device['Device']['employee_id'])));
            $details[$i]['Device'] = $device['Device'];
            $details[$i]['Calibration'] = $calibration['Calibration'];
            $details[$i]['Schedule'] = $schedule['Schedule'];
            $details[$i]['Employee'] = $employee['Employee'];
            $i++;
        endforeach;

        $this->set('listOfMeasuringDevicesForCalibrations', $details);
        $this->_get_count();
    }

    public function _index() {

        $conditions = $this->_check_request();
        $this->paginate = array('order' => array('ListOfMeasuringDevicesForCalibration.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->ListOfMeasuringDevicesForCalibration->recursive = 1;
        $this->set('listOfMeasuringDevicesForCalibrations', $this->paginate());
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
                        $searchArray[] = array('ListOfMeasuringDevicesForCalibration.' . $search => $searchKey);
                    else
                        $searchArray[] = array('ListOfMeasuringDevicesForCalibration.' . $search . ' like ' => '%' . $searchKey . '%');
                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('ListOfMeasuringDevicesForCalibration.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['device_id'] != '') {
            $deviceConditions[] = array('ListOfMeasuringDevicesForCalibration.device_id' => $this->request->query['device_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $deviceConditions);
            else
                $conditions[] = array('or' => $deviceConditions);
        }
        if ($this->request->query['calibration_frequency'] != -1) {
            $scheduleConditions[] = array('ListOfMeasuringDevicesForCalibration.calibration_frequency' => $this->request->query['calibration_frequency']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $scheduleConditions);
            else
                $conditions[] = array('or' => $scheduleConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('ListOfMeasuringDevicesForCalibration.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'ListOfMeasuringDevicesForCalibration.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);

        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('ListOfMeasuringDevicesForCalibration.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('ListOfMeasuringDevicesForCalibration.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->ListOfMeasuringDevicesForCalibration->recursive = 0;
        $this->paginate = array('order' => array('ListOfMeasuringDevicesForCalibration.sr_no' => 'DESC'), 'conditions' => $conditions, 'ListOfMeasuringDevicesForCalibration.soft_delete' => 0);
        $details = $this->paginate();
        $i = 0;
        $this->loadModel('Calibration');
        $this->loadModel('Schedule');
        $this->loadModel('Employee');
        $this->loadModel('Device');

        foreach ($details as $listOfMeasuringDevicesForCalibration):

            $device = $this->Device->find('first', array('recursive' => -1, 'conditions' => array('Device.id' => $listOfMeasuringDevicesForCalibration['ListOfMeasuringDevicesForCalibration']['device_id'])));
            $calibration = $this->Calibration->find('first', array('recursive' => -1, 'order' => array('Calibration.created' => 'DESC'), 'conditions' => array('Calibration.device_id' => $device['Device']['id'])));
            $schedule = $this->Schedule->find('first', array('recursive' => -1, 'fields' => array('Schedule.id', 'Schedule.name'), 'conditions' => array('Schedule.id' => $device['Device']['calibration_frequency'])));
            $employee = $this->Employee->find('first', array('recursive' => -1, 'fields' => array('Employee.id', 'Employee.name'), 'conditions' => array('Employee.id' => $device['Device']['employee_id'])));
            $details[$i]['Device'] = $device['Device'];
            $details[$i]['Calibration'] = $calibration['Calibration'];
            $details[$i]['Schedule'] = $schedule['Schedule'];
            $details[$i]['Employee'] = $employee['Employee'];
            $i++;
        endforeach;

        $this->set('listOfMeasuringDevicesForCalibrations', $details);
        $this->_get_count();
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
        if (!$this->ListOfMeasuringDevicesForCalibration->exists($id)) {
            throw new NotFoundException(__('Invalid list of measuring devices for calibration'));
        }
        $options = array('conditions' => array('ListOfMeasuringDevicesForCalibration.' . $this->ListOfMeasuringDevicesForCalibration->primaryKey => $id));
        $this->set('listOfMeasuringDevicesForCalibration', $this->ListOfMeasuringDevicesForCalibration->find('first', $options));
    }

    /**
     * list method
     *
     * @return void
     */
    public function lists() {

        $this->_get_count();
    }
}
