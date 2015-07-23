<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
App::import('Sanitize');

class DashboardsController extends AppController {

    public $components = array('RequestHandler', 'Session', 'AjaxMultiUpload.Upload');
    public $helpers = array('Js', 'Session', 'Paginator', 'Tinymce');

    public function mr() {
        $this->loadModel('Department');
        $departments = $this->Department->find('all', array('orderby' => array('name' => 'ASC'), 'conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0), 'recursive' => -1));
        $this->set('departments', $departments);
        //Meeting
        $this->loadModel('Meeting');
        $meetings = $this->Meeting->find('count', array('conditions' => array('Meeting.publish' => 1, 'Meeting.soft_delete' => 0), 'recursive' => -1));
        $this->set('countMeetings', $meetings);

        //InternalAuditDetail
        $this->loadModel('InternalAudit');
        $internalAudits = $this->InternalAudit->find('count', array('conditions' => array('InternalAudit.publish' => 1, 'InternalAudit.soft_delete' => 0), 'recursive' => -1));
        $countNcs = $this->InternalAudit->find('count', array('conditions' => array('InternalAudit.non_conformity_found' => 1, 'InternalAudit.publish' => 1, 'InternalAudit.soft_delete' => 0), 'recursive' => -1));

        $this->set('countInternalAudits', $internalAudits);
        $this->set('countNcs', $countNcs);

        //CAPA
        $this->loadModel('CorrectivePreventiveAction');
        $capas = $this->CorrectivePreventiveAction->find('count', array('conditions' => array('CorrectivePreventiveAction.publish' => 1, 'CorrectivePreventiveAction.soft_delete' => 0), 'recursive' => -1));
        $this->set('countCapas', $capas);

        //CAPA
        $this->loadModel('Task');
        $tasks = $this->Task->find('count', array('conditions' => array('Task.publish' => 1, 'Task.soft_delete' => 0), 'recursive' => -1));
        $this->set('countTasks', $tasks);

        //CorrectivePreventiveAction
        $this->loadModel('ChangeAdditionDeletionRequest');
        $changeRequest = $this->ChangeAdditionDeletionRequest->find('count', array('conditions' => array('ChangeAdditionDeletionRequest.publish' => 1, 'ChangeAdditionDeletionRequest.soft_delete' => 0), 'recursive' => -1));
        $this->set('countChangeRequest', $changeRequest);

        $data = null;
        $benchmark = 0;
            $average = 0;
        if(file_exists(WWW_ROOT . "/files/".$this->Session->read('User.company_id')."/graphs/graph_data_branches_total.txt")){
	    $file = new File(WWW_ROOT . "/files/".$this->Session->read('User.company_id')."/graphs/graph_data_branches_total.txt");
            $data = $file->read();
            $data = json_decode($data, true);
            if(isset($data))
            foreach ($data as $branchAvg):
                $benchmark = $benchmark + $branchAvg['benchmark'];
                $average = $average + $branchAvg['count'];
            endforeach;
        }

        $this->loadModel('History');
        $startDate = $this->History->find('first', array('fields' => array('History.created'), 'order' => array('History.created' => 'asc'), 'recursive' => -1));
        $endDate = $this->History->find('first', array('fields' => array('History.created'), 'order' => array('History.created' => 'desc'), 'recursive' => -1));
        $startDate = date("Y-m-d H:i:s", strtotime($startDate['History']['created']));
        $endDate = date("Y-m-d H:i:s", strtotime($endDate['History']['created']));
        $diff = abs(strtotime($endDate) - strtotime($startDate));

        $diff = floor($diff / (60 * 60 * 24));
        if ($average > 0 && $diff > 0 && $benchmark > 0)
            $branchData = round((100 * ($average / $diff)) / $benchmark);
        else
            $branchData = 0;
        $this->set('branchData', $branchData);

        $data = null;
        if(file_exists(WWW_ROOT . "/files/".$this->Session->read('User.company_id')."/graphs/graph_data_departments_total.txt")){
	    $file = new File(WWW_ROOT . "/files/".$this->Session->read('User.company_id')."/graphs/graph_data_departments_total.txt");
            $data = $file->read();
            $data = json_decode($data, true);
            $benchmark = 0;
            $average = 0;
             if(isset($data))
            foreach ($data as $deptAvg):
                $benchmark = $benchmark + $deptAvg['benchmark'];
                $average = $average + $deptAvg['count'];
            endforeach;
        }

        if ($average > 0 && $diff > 0 && $benchmark > 0)
            $departmentData = round((100 * ($average / $diff)) / $benchmark);
        else
            $departmentData = 0;
        $this->set('departmentData', $departmentData);

        // get folders
        $dir = new Folder(WWW_ROOT . 'files');
        $folders = $dir->read(true);
        $this->set('folders', $folders);
        if (isset($this->request->params['pass'][0]))
            $p = $this->request->params['pass'][0];
        else
            $p = null;
        if (!$p)
            $p = "start";
        $this->set('mId', $p);
    }

    public function get_folders() {

        $paths = $this->request->params['pass'];
        foreach ($paths as $p):
            $path = $path . '/' . $p;
            $this->set('mId', $p);
        endforeach;
        $dir = new Folder(WWW_ROOT . 'files/' . $path . '/');
        $folders = $dir->read(true);

        if ($this->request->params['pass'][0] == 'upload' or $this->request->params['pass'][0] == 'import') {
            $this->loadModel('User');
            foreach ($folders[0] as $folder):
                $getUser = $this->User->find('first', array('conditions' => array('User.id' => $folder), 'fields' => array('User.id', 'User.username')));
                if ($getUser)
                    $getUsers[] = array($getUser['User']['username'], $getUser['User']['id']);
                else
                    $getUsers[] = array($folder, $folder);
            endforeach;
            $folders[0] = $getUsers;
        }else {
            foreach ($folders[0] as $folder):
                $getFolder[] = array($folder, $folder);
            endforeach;
            $folders[0] = $getFolder;
        }

        $this->set('folders', $folders);
        $this->set('path', $path);
    }

    public function get_file() {
        $paths = $this->request->params['pass'];
        foreach ($paths as $p):
            $path = $path . '/' . $p;
            $this->set('mId', $p);
        endforeach;
        $path = str_replace('<>', ' ', $path);
        $file = new File(WWW_ROOT . 'files/' . $path);
        $fileDetails = $file->info();
        $fileChange = $file->lastChange();
        $this->set('fileDetails', $fileDetails);
        $this->set('fileChange', $fileChange);
        //$c_file = WWW_ROOT . 'files/' . $path;
        $this->set('path', $path);
    }

    public function hr() {
        $this->loadModel('Employee');
        $employees = $this->Employee->find('count', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0), 'recursive' => -1));
        $this->set('countEmployees', $employees);

        $this->loadModel('Course');
        $courses = $this->Course->find('count', array('conditions' => array('Course.publish' => 1, 'Course.soft_delete' => 0), 'recursive' => -1));
        $this->set('countCourses', $courses);

        $this->loadModel('Training');
        $trainings = $this->Training->find('count', array('conditions' => array('Training.publish' => 1, 'Training.soft_delete' => 0), 'recursive' => -1));
        $this->set('countTrainings', $trainings);

        $this->loadModel('TrainingNeedIdentification');
        $tni = $this->TrainingNeedIdentification->find('count', array('conditions' => array('TrainingNeedIdentification.publish' => 1, 'TrainingNeedIdentification.soft_delete' => 0), 'recursive' => -1));
        $this->set('countTNI', $tni);

        $this->loadModel('TrainingEvaluation');
        $trainingEvaluation = $this->TrainingEvaluation->find('count', array('conditions' => array('TrainingEvaluation.publish' => 1, 'TrainingEvaluation.soft_delete' => 0), 'recursive' => -1));
        $this->set('countTrainingEvaluation', $trainingEvaluation);

        $this->loadModel('CompetencyMapping');
        $competencyMappings = $this->CompetencyMapping->find('count', array('conditions' => array('CompetencyMapping.publish' => 1, 'CompetencyMapping.soft_delete' => 0), 'recursive' => -1));
        $this->set('countCompetencyMappings', $competencyMappings);

        $this->loadModel('Appraisal');
        $countAppraisals = $this->Appraisal->find('count', array('conditions' => array('Appraisal.publish' => 1, 'Appraisal.soft_delete' => 0), 'recursive' => -1));
        $this->set('countAppraisals', $countAppraisals);
    }

    public function personal_admin($id = null) {

        $this->loadModel('FireExtinguisher');
        $FireExt = $this->FireExtinguisher->find('count', array('conditions' => array('FireExtinguisher.publish' => 1, 'FireExtinguisher.soft_delete' => 0), 'recursive' => -1));
        $this->set('countFirExt', $FireExt);

        $this->loadModel('HousekeepingChecklist');
        $houseKeeping = $this->HousekeepingChecklist->find('count', array('conditions' => array('HousekeepingChecklist.publish' => 1, 'HousekeepingChecklist.soft_delete' => 0), 'recursive' => -1));
        $this->set('countHouseKeeping', $houseKeeping);

        $this->loadModel('HousekeepingResponsibility');
        $houseKeepingResp = $this->HousekeepingResponsibility->find('count', array('conditions' => array('HousekeepingResponsibility.publish' => 1, 'HousekeepingResponsibility.soft_delete' => 0), 'recursive' => -1));
        $this->set('countHouseKeepingResp', $houseKeepingResp);

    //Code for house keeping responsibility
        $this->loadModel('Housekeeping');
        if ($this->request->is('post')) {
            foreach ($this->request->data['Housekeeping'] as $houseKeeping) {
                if (!empty($houseKeeping['id']) && (isset($houseKeeping['task_performed']) || isset($houseKeeping['comments']))) {
                    $houseKeeping['backup_date'] = date('Y-m-d');
                    $houseKeeping['publish'] = 1;
                    $houseKeeping['employee_id'] = $this->Session->read('User.employee_id');
                    $houseKeeping['branchid'] = $this->Session->read('User.branch_id');
                    $houseKeeping['departmentid'] = $this->Session->read('User.department_id');
                    $houseKeeping['modified_by'] = $this->Session->read('User.id');
                    $this->Housekeeping->save($houseKeeping, false);
                } else if (empty($houseKeeping['id']) && isset($houseKeeping['task_performed']) && $houseKeeping['task_performed'] > 0) {
                    $this->Housekeeping->create();
                    $houseKeeping['backup_date'] = date('Y-m-d');
                    $houseKeeping['publish'] = 1;
                    $houseKeeping['employee_id'] = $this->Session->read('User.employee_id');
                    $houseKeeping['branchid'] = $this->Session->read('User.branch_id');
                    $houseKeeping['departmentid'] = $this->Session->read('User.department_id');
                    $houseKeeping['created_by'] = $this->Session->read('User.id');
                    $houseKeeping['modified_by'] = $this->Session->read('User.id');
                    $this->Housekeeping->save($houseKeeping, false);
                }
            }
            $this->Session->setFlash(__('The housekeeping has been saved'));
            $this->redirect(array('action' => 'personal_admin'));
        }
        $onlyBranch = null;
        $onlyOwn = null;
        $condition1 = null;
        $condition2 = null;
        $condition3 = null;
        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('HousekeepingResponsibility.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('HousekeepingResponsibility.created_by' => $this->Session->read('User.id'));
        if ($this->Session->read('User.is_mr') == 0) {
            $condition3 = array('HousekeepingResponsibility.employee_id' => $this->Session->read('User.employee_id'));
        }
        $finalCond = array('OR' => array($onlyBranch, $onlyOwn, $condition3));
        if ($this->request->params['named']) {
            if ($this->request->params['named']['published'] == null)
                $condition1 = null;
            else
                $condition1 = array('HousekeepingResponsibility.publish' => $this->request->params['named']['published']);
            if ($this->request->params['named']['soft_delete'] == null)
                $condition2 = null;
            else
                $condition2 = array('HousekeepingResponsibility.soft_delete' => $this->request->params['named']['soft_delete']);
            if ($this->request->params['named']['soft_delete'] == null)
                $conditions = array($onlyBranch, $onlyOwn, $condition1, $condition3, 'HousekeepingResponsibility.soft_delete' => 0);
            else
                $conditions = array($condition1, $condition2, $finalCond);
        }else {
            $conditions = array($finalCond, 'HousekeepingResponsibility.soft_delete' => 0);
        }
        $options = array('order' => array('HousekeepingResponsibility.sr_no' => 'DESC'), 'conditions' => array($conditions));
        $this->HousekeepingResponsibility->recursive = 0;
        $houseKeepings = $this->HousekeepingResponsibility->find('all', $options);
        $this->loadModel('Schedule');
        $scheduleList = $this->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0), 'recursive' => -1));
        foreach ($houseKeepings as $key => $houseKeeping) {
            $test = $this->Housekeeping->find('first', array('order' => array('Housekeeping.sr_no' => 'DESC'), 'conditions' => array('Housekeeping.housekeeping_responsibility_id' => $houseKeeping['HousekeepingResponsibility']['id'], 'Housekeeping.employee_id' => $houseKeeping['HousekeepingResponsibility']['employee_id']), 'recursive' => -1));
            if (count($test)) {
                if ($scheduleList[$houseKeeping['HousekeepingResponsibility']['schedule_id']] == 'dailly' || $scheduleList[$houseKeeping['HousekeepingResponsibility']['schedule_id']] == 'Dailly' || $scheduleList[$houseKeeping['HousekeepingResponsibility']['schedule_id']] == 'daily' || $scheduleList[$houseKeeping['HousekeepingResponsibility']['schedule_id']] == 'Daily') {
                    if (date('Y-m-d', strtotime($test['Housekeeping']['created'])) == date('Y-m-d')) {
                        $houseKeepings[$key]['Housekeeping'] = $test['Housekeeping'];
                    } else {
                        $houseKeepings[$key]['Housekeeping'] = array();
                    }
                } else if ($scheduleList[$houseKeeping['HousekeepingResponsibility']['schedule_id']] == 'weekly' || $scheduleList[$houseKeeping['HousekeepingResponsibility']['schedule_id']] == 'Weekly') {

                    if (date('W', strtotime($test['Housekeeping']['created'])) == date('W')) {
                        $houseKeepings[$key]['Housekeeping'] = $test['Housekeeping'];
                    } else {
                        $houseKeepings[$key]['Housekeeping'] = array();
                    }
                } else if ($scheduleList[$houseKeeping['HousekeepingResponsibility']['schedule_id']] == 'monthly' || $scheduleList[$houseKeeping['HousekeepingResponsibility']['schedule_id']] == 'Monthly') {
                    if (date('m', strtotime($test['Housekeeping']['created'])) == date('m')) {
                        $houseKeepings[$key]['Housekeeping'] = $test['Housekeeping'];
                    } else {
                        $houseKeepings[$key]['Housekeeping'] = array();
                    }
                } else if ($scheduleList[$houseKeeping['HousekeepingResponsibility']['schedule_id']] == 'quarterly' || $scheduleList[$houseKeeping['HousekeepingResponsibility']['schedule_id']] == 'Quarterly') {
                    $created = date('Y-m-d', strtotime($houseKeeping['HousekeepingResponsibility']['created']));
                    $currentDate = date('Y-m-d', strtotime($houseKeeping['HousekeepingResponsibility']['created']));
                    $lastQuarter = date('Y-m-d');
                    $nextQuarter = date('Y-m-d');
                    $dateArray = array();
                    $i = 0;
                    while ($currentDate <= $lastQuarter) {
                        $nextQuarter = date('Y-m-d', strtotime('+3 month', strtotime($currentDate)));
                        $dateArray[$i]['currentDate'] = $currentDate;
                        $dateArray[$i]['nextQuarter'] = $nextQuarter;
                        $currentDate = $nextQuarter;
                        $i++;
                    }
                    $count = count($dateArray);

                    if (date('Y-m-d', strtotime($test['Housekeeping']['created'])) >= $dateArray[$count - 1]['currentDate'] && date('Y-m-d', strtotime($test['Housekeeping']['created'])) <= $dateArray[$count - 1]['nextQuarter']) {
                        $houseKeepings[$key]['Housekeeping'] = $test['Housekeeping'];
                    } else {
                        $houseKeepings[$key]['Housekeeping'] = array();
                    }
                } else if ($scheduleList[$houseKeeping['HousekeepingResponsibility']['schedule_id']] == 'yearly' || $scheduleList[$houseKeeping['HousekeepingResponsibility']['schedule_id']] == 'Yearly') {
                    if (date('y', strtotime($test['Housekeeping']['created'])) == date('y')) {
                        $houseKeepings[$key]['Housekeeping'] = $test['Housekeeping'];
                    } else {
                        $houseKeepings[$key]['Housekeeping'] = array();
                    }
                }
            }
        }
        $this->set('editId', $id);
        $this->set('houseKeepings', $houseKeepings);
    }

    public function quality_control() {

        $this->loadModel('CustomerComplaint');
        $openComplaints = $this->CustomerComplaint->find('count', array('conditions' => array('CustomerComplaint.current_status' => 0, 'CustomerComplaint.soft_delete' => 0, 'CustomerComplaint.publish' => 1), 'recursive' => -1));
        $this->set('openComplaints', $openComplaints);

        $complaintResolved = $this->CustomerComplaint->find('count', array('conditions' => array('CustomerComplaint.current_status <> ' => 0, 'CustomerComplaint.soft_delete' => 0, 'CustomerComplaint.publish' => 1), 'recursive' => -1));
        $this->set('complaintResolved', $complaintResolved);

        $this->loadModel('ListOfMeasuringDevicesForCalibration');
        $calibDevices = $this->ListOfMeasuringDevicesForCalibration->find('count', array('conditions' => array('ListOfMeasuringDevicesForCalibration.publish' => 1, 'ListOfMeasuringDevicesForCalibration.soft_delete' => 0), 'recursive' => -1));
        $this->set('countCalibdevices', $calibDevices);

        $this->loadModel('Calibration');
        $calibs = $this->Calibration->find('count', array('conditions' => array('Calibration.publish' => 1, 'Calibration.soft_delete' => 0), 'recursive' => -1));
        $this->set('countCalibs', $calibs);

        $this->loadModel('CustomerFeedback');
        $CustFeedbacks = $this->CustomerFeedback->find('all', array('conditions' => array('CustomerFeedback.publish' => 1, 'CustomerFeedback.soft_delete' => 0), 'group' => 'CustomerFeedback.customer_id', 'recursive' => -1));
        $count = count($CustFeedbacks);
        $this->set('countCustFeedbacks', $count);

        $this->loadModel('MaterialQualityCheck');
        $countMaterialQC = $this->MaterialQualityCheck->find('count', array('conditions' => array('MaterialQualityCheck.publish' => 1, 'MaterialQualityCheck.soft_delete' => 0), 'recursive' => -1, 'group' => 'MaterialQualityCheck.material_id'));
        if($countMaterialQC == false) $countMaterialQC = 0;
        $this->set('countMaterialQC', $countMaterialQC);

        $this->loadModel('DeviceMaintenance');
        $DeviceMaintenance = $this->DeviceMaintenance->find('count', array('conditions' => array('DeviceMaintenance.publish' => 1, 'DeviceMaintenance.soft_delete' => 0), 'recursive' => -1));
        $this->set('countDeviceMaintenance', $DeviceMaintenance);
    }

    public function edp($id = null) {

        $this->loadModel('User');
        $users = $this->User->find('count', array('conditions' => array('User.publish' => 1, 'User.soft_delete' => 0), 'recursive' => -1));
        $this->set('countUsers', $users);

        $this->loadModel('ListOfComputer');
        $listofcomps = $this->ListOfComputer->find('count', array('conditions' => array('ListOfComputer.publish' => 1, 'ListOfComputer.soft_delete' => 0), 'recursive' => -1));
        $this->set('countListofcomps', $listofcomps);

        $this->loadModel('DatabackupLogbook');
        $countDataBakupLogbk = $this->DatabackupLogbook->find('count', array('conditions' => array('DatabackupLogbook.publish' => 1, 'DatabackupLogbook.soft_delete' => 0), 'recursive' => -1));
        $this->set('countDataBakupLogbk', $countDataBakupLogbk);

        $this->loadModel('ListOfSoftware');
        $listOfSofts = $this->ListOfSoftware->find('count', array('conditions' => array('ListOfSoftware.publish' => 1, 'ListOfSoftware.soft_delete' => 0), 'recursive' => -1));
        $this->set('countListOfSofts', $listOfSofts);

        $this->loadModel('ListOfComputerListOfSoftware');
        $listOfCompSofts = $this->ListOfComputerListOfSoftware->find('count', array('conditions' => array('ListOfComputerListOfSoftware.publish' => 1, 'ListOfComputerListOfSoftware.soft_delete' => 0), 'recursive' => -1));
        $this->set('countListOfCompSofts', $listOfCompSofts);

        $this->loadModel('UsernamePasswordDetail');
        $usrPassDetails = $this->UsernamePasswordDetail->find('count', array('conditions' => array('UsernamePasswordDetail.publish' => 1, 'UsernamePasswordDetail.soft_delete' => 0), 'recursive' => -1));
        $this->set('countUsrPassDetails', $usrPassDetails);

        $this->loadModel('DailyBackupDetail');
        $this->loadModel('DatabackupLogbook');
        if ($this->request->is('post')) {
            foreach ($this->request->data['DatabackupLogbook'] as $databackupLogbook) {
                if (!empty($databackupLogbook['id']) && (isset($databackupLogbook['task_performed']) || isset($databackupLogbook['comments']))) {
                    $databackupLogbook['backup_date'] = date('Y-m-d');
                    $databackupLogbook['employee_id'] = $this->Session->read('User.employee_id');
                    $databackupLogbook['branchid'] = $this->Session->read('User.branch_id');
                    $databackupLogbook['publish'] = 1;
                    $databackupLogbook['departmentid'] = $this->Session->read('User.department_id');
                    $databackupLogbook['modified_by'] = $this->Session->read('User.id');

                    $this->DatabackupLogbook->save($databackupLogbook, false);
                } else if (empty($databackupLogbook['id']) && isset($databackupLogbook['task_performed']) && $databackupLogbook['task_performed'] > 0) {
                    $this->DatabackupLogbook->create();
                    $databackupLogbook['backup_date'] = date('Y-m-d');
                    $databackupLogbook['employee_id'] = $this->Session->read('User.employee_id');
                    $databackupLogbook['branchid'] = $this->Session->read('User.branch_id');
                    $databackupLogbook['departmentid'] = $this->Session->read('User.department_id');
                    $databackupLogbook['created_by'] = $this->Session->read('User.id');
                    $databackupLogbook['modified_by'] = $this->Session->read('User.id');
                    $databackupLogbook['publish'] = 1;
                    $this->DatabackupLogbook->save($databackupLogbook, false);
                }
            }
            $this->Session->setFlash(__('The Backup Details has been saved'));
            $this->redirect(array('action' => 'edp'));
        }
        $onlyBranch = null;
        $onlyOwn = null;
        $condition1 = null;
        $condition2 = null;
        $condition3 = null;
        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('DailyBackupDetail.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('DailyBackupDetail.created_by' => $this->Session->read('User.id'));
        if ($this->Session->read('User.is_mr') == 0) {
            $condition3 = array('DailyBackupDetail.employee_id' => $this->Session->read('User.employee_id'));
        }
        $finalCond = array('OR' => array($onlyBranch, $onlyOwn, $condition3));
        if ($this->request->params['named']) {
            if ($this->request->params['named']['published'] == null)
                $condition1 = null;
            else
                $condition1 = array('DailyBackupDetail.publish' => $this->request->params['named']['published']);
            if ($this->request->params['named']['soft_delete'] == null)
                $condition2 = null;
            else
                $condition2 = array('DailyBackupDetail.soft_delete' => $this->request->params['named']['soft_delete']);
            if ($this->request->params['named']['soft_delete'] == null)
                $conditions = array($onlyBranch, $onlyOwn, $condition1, $condition3, 'DailyBackupDetail.soft_delete' => 0);
            else
                $conditions = array($condition1, $condition2, $finalCond);
        }else {
            $conditions = array($finalCond, 'DailyBackupDetail.soft_delete' => 0);
        }
        $options = array('order' => array('DailyBackupDetail.sr_no' => 'DESC'), 'conditions' => array($conditions));
        $this->DailyBackupDetail->recursive = 0;

        $dailyBackupDetails = $this->DailyBackupDetail->find('all', $options);
        $this->loadModel('Schedule');
        $scheduleList = $this->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0), 'recursive' => -1));

        foreach ($dailyBackupDetails as $key => $dailyBackupDetail) {

            $test = $this->DatabackupLogbook->find('first', array('order' => array('DatabackupLogbook.sr_no' => 'DESC'), 'conditions' => array('DatabackupLogbook.daily_backup_detail_id' => $dailyBackupDetail['DailyBackupDetail']['id'], 'DatabackupLogbook.employee_id' => $dailyBackupDetail['DailyBackupDetail']['employee_id']), 'recursive' => -1));
            $listOfComp = $this->ListOfComputer->find('first', array('conditions' => array('ListOfComputer.id' => $dailyBackupDetail['DailyBackupDetail']['list_of_computer_id']), 'fields' => array('make'), 'recursive' => -1));

            $dailyBackupDetails[$key]['DataBackUp']['ScheduleName'] = $scheduleList[$dailyBackupDetail['DataBackUp']['schedule_id']];

            if (count($test)) {
                if ($scheduleList[$dailyBackupDetail['DataBackUp']['schedule_id']] == 'dailly' || $scheduleList[$dailyBackupDetail['DataBackUp']['schedule_id']] == 'Dailly' || $scheduleList[$dailyBackupDetail['DataBackUp']['schedule_id']] == 'daily' || $scheduleList[$dailyBackupDetail['DataBackUp']['schedule_id']] == 'Daily') {

                    if (date('Y-m-d', strtotime($test['DatabackupLogbook']['created'])) == date('Y-m-d')) {
                        $dailyBackupDetails[$key]['DatabackupLogbook'] = $test['DatabackupLogbook'];
                    } else {
                        $dailyBackupDetails[$key]['DatabackupLogbook'] = array();
                    }
                } else if ($scheduleList[$dailyBackupDetail['DataBackUp']['schedule_id']] == 'weekly' || $scheduleList[$dailyBackupDetail['DataBackUp']['schedule_id']] == 'Weekly') {
                    if (date('W', strtotime($test['DatabackupLogbook']['created'])) == date('W')) {
                        $dailyBackupDetails[$key]['DatabackupLogbook'] = $test['DatabackupLogbook'];
                    } else {
                        $dailyBackupDetails[$key]['DatabackupLogbook'] = array();
                    }
                } else if ($scheduleList[$dailyBackupDetail['DataBackUp']['schedule_id']] == 'monthly' || $scheduleList[$dailyBackupDetail['DataBackUp']['schedule_id']] == 'Monthly') {

                    if (date('m', strtotime($test['DatabackupLogbook']['created'])) == date('m')) {
                        $dailyBackupDetails[$key]['DatabackupLogbook'] = $test['DatabackupLogbook'];
                    } else {
                        $dailyBackupDetails[$key]['DatabackupLogbook'] = array();
                    }
                } else if ($scheduleList[$dailyBackupDetail['DataBackUp']['schedule_id']] == 'quarterly' || $scheduleList[$dailyBackupDetail['DataBackUp']['schedule_id']] == 'Quarterly') {
                    $created = date('Y-m-d', strtotime($dailyBackupDetail['DailyBackupDetail']['created']));
                    $currentDate = date('Y-m-d', strtotime($dailyBackupDetail['DailyBackupDetail']['created']));
                    $lastQuarter = date('Y-m-d');
                    $nextQuarter = date('Y-m-d');
                    $dateArray = array();
                    $i = 0;
                    while ($currentDate <= $lastQuarter) {
                        $nextQuarter = date('Y-m-d', strtotime('+3 month', strtotime($currentDate)));
                        $dateArray[$i]['currentDate'] = $currentDate;
                        $dateArray[$i]['nextQuarter'] = $nextQuarter;
                        $currentDate = $nextQuarter;
                        $i++;
                    }
                    $count = count($dateArray);
                    if (date('Y-m-d', strtotime($test['DatabackupLogbook']['created'])) >= $dateArray[$count - 1]['currentDate'] && date('Y-m-d', strtotime($test['DatabackupLogbook']['created'])) <= $dateArray[$count - 1]['nextQuarter']) {
                        $dailyBackupDetails[$key]['DatabackupLogbook'] = $test['DatabackupLogbook'];
                    } else {
                        $dailyBackupDetails[$key]['DatabackupLogbook'] = array();
                    }
                } else if ($scheduleList[$dailyBackupDetail['DataBackUp']['schedule_id']] == 'yearly' || $scheduleList[$dailyBackupDetail['DataBackUp']['schedule_id']] == 'Yearly') {

                    if (date('y', strtotime($test['DatabackupLogbook']['created'])) == date('y')) {
                        $dailyBackupDetails[$key]['DatabackupLogbook'] = $test['DatabackupLogbook'];
                    } else {
                        $dailyBackupDetails[$key]['DatabackupLogbook'] = array();
                    }
                }
            } if (count($listOfComp))
                $dailyBackupDetails[$key]['DatabackupLogbook']['make'] = $listOfComp['ListOfComputer']['make'];
        }

        $this->set('dailyBackupDetails', $dailyBackupDetails);
        $this->set('editId', $id);


        //get folder details :
        $folder = new Folder(APP . DS . 'webroot/files/');
        $folderSize = $folder->dirsize();
        $dbSize = $this->_getDbSize();
        $this->set(array('dbSize' => $this->_format_file_size($dbSize), 'folderSize' => $this->_format_file_size($folderSize), 'totalSize' => $this->_format_file_size($dbSize + $folderSize)));
    }

    public function _getDbSize() {

        $src = get_class_vars('DATABASE_CONFIG');
        $link = mysql_connect($src['default']['host'], $src['default']['login'], $src['default']['password']);
        mysql_select_db($src['default']['database']);
        $result = mysql_query("SHOW TABLE STATUS");
        $dbSize = 0;

        while ($row = mysql_fetch_array($result)) {

            $dbSize += $row["Data_length"] + $row["Index_length"];
        }
        return $dbSize;
    }

    public function purchase() {

        $this->loadModel('ListOfAcceptableSupplier');
        $acptSupp = $this->ListOfAcceptableSupplier->find('count', array('conditions' => array('ListOfAcceptableSupplier.soft_delete' => 0), 'recursive' => -1));
        $this->set('countAcptSupp', $acptSupp);

        $this->loadModel('SupplierRegistration');
        $supplierReg = $this->SupplierRegistration->find('count', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0), 'recursive' => -1));
        $this->set('countSuppreg', $supplierReg);

        $this->loadModel('SupplierEvaluationReevaluation');
        $supplierEval = $this->SupplierEvaluationReevaluation->find('count', array('conditions' => array('SupplierEvaluationReevaluation.publish' => 1, 'SupplierEvaluationReevaluation.soft_delete' => 0), 'recursive' => -1));
        $this->set('countSupplierEval', $supplierEval);

        $this->loadModel('DeliveryChallan');
        $delChallan = $this->DeliveryChallan->find('count', array('conditions' => array('DeliveryChallan.publish' => 1, 'DeliveryChallan.soft_delete' => 0), 'recursive' => -1));
        $this->set('countDelChallan', $delChallan);

        $this->loadModel('PurchaseOrder');
        $purchaseOrder = $this->PurchaseOrder->find('count', array('conditions' => array('PurchaseOrder.publish' => 1, 'PurchaseOrder.soft_delete' => 0), 'recursive' => -1));
        $this->set('countPurchaseOrder', $purchaseOrder);

        $this->loadModel('SummeryOfSupplierEvaluation');
        $SumOfSuppEvals = $this->SummeryOfSupplierEvaluation->find('count', array('conditions' => array('SummeryOfSupplierEvaluation.publish' => 1, 'SummeryOfSupplierEvaluation.soft_delete' => 0), 'recursive' => -1));
        $this->set('countSumOfSuppEvals', $SumOfSuppEvals);
    }

    public function bd() {

        $customers = $this->requestAction('App/get_model_list/Customer/');
        $countCustomers = count($customers);
        $customerMeetings = $this->requestAction('App/get_model_list/CustomerMeeting/');
        $conditions = null;
        $onlyBranch = null;
        $onlyOwn = null;
        $startDate = null;
        $endDate = null;
        $this->loadModel('CustomerMeeting');
        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('CustomerMeeting.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('CustomerMeeting.created_by' => $this->Session->read('User.id'));
        $conditions = array($onlyBranch, $onlyOwn);

        $countCustomerMeetings = $this->CustomerMeeting->find('count', array('conditions' => $conditions, 'group' => 'CustomerMeeting.followup_id'));
            if(!$countCustomerMeetings) $countCustomerMeetings = 0;
        $clientProposals = $this->requestAction('App/get_model_list/Proposal/');
        $countClientProposals = count($clientProposals);
        $proposalFollowups = $this->requestAction('App/get_model_list/ProposalFollowup/');
        $countProposalFollowups = count($proposalFollowups);
        $this->set(compact('countCustomers', 'countClients', 'countCustomerMeetings', 'countClientProposals', 'countProposalFollowups'));
        $this->set(array('resultMappings' => $this->result_mapping($startDate, $endDate)));
    }

    public function result_mapping($startDate = null, $endDate = null) {

        if (!$startDate && !$endDate) {
            $startDate = date('Y-m-1');
            $endDate = date('Y-m-31');
        } else {
            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));
        }
        $orderDateRange = array('PurchaseOrder.order_date between ? and ?' => array(date('Y-m-d', strtotime($startDate)), date('Y-m-d', strtotime($endDate))));
        $proposalfollowupDateRange = array('ProposalFollowup.followup_date between ? and ? ' => array($startDate,$endDate));
        $proposalDateRange = array('Proposal.proposal_date between ? and ? ' => array($startDate, $endDate));
        $customerDateRange = array('CustomerMeeting.meeting_date between ? and ? ' => array(date('Y-m-d', strtotime($startDate)), date('Y-m-d', strtotime($endDate))));

        $this->loadModel('Customer');
        $this->loadModel('CustomerMeeting');
        $this->loadModel('PurchaseOrder');
        $this->loadModel('Proposal');
        $this->loadModel('ProposalFollowup');

        $allCustomers = $this->Customer->find('list', array('recursive' => 0, 'conditions' => array('Customer.publish' => 1, 'Customer.soft_delete' => 0)));
        foreach ($allCustomers as $key => $value):
            $i=0;
            $result['CustomerDetails']['name'] = $value;
            $CustomerMeetings = $this->CustomerMeeting->find('all', array('recursive' => 0,
                'conditions' => array($customerDateRange, 'CustomerMeeting.customer_id' => $key, 'CustomerMeeting.publish' => 1, 'CustomerMeeting.soft_delete' => 0),
                'fields' => array('CustomerMeeting.meeting_date', 'Employee.name'),'group' => 'CustomerMeeting.followup_id'
            ));
            $result['Number_of_meetings'] = count($CustomerMeetings);

            $proposals = $this->Proposal->find('list', array('recursive' => 0, 'conditions' => array($proposalDateRange, 'Proposal.customer_id' => $key, 'Proposal.publish' => 1, 'Proposal.soft_delete' => 0)));
            $result['Number_of_proposals'] = count($proposals);
            $proposalFollowUps = 0;
            foreach ($proposals as $pKey => $pValue):
                $proposalFollowUps = $this->ProposalFollowup->find('count', array('recursive' => 0, 'conditions' => array($proposalfollowupDateRange, 'ProposalFollowup.proposal_id' => $pKey, 'ProposalFollowup.publish' => 1, 'ProposalFollowup.soft_delete' => 0)));
            if($proposalFollowUps){
                $i+=$proposalFollowUps;
            }
            endforeach;
            $result['Number_of_proposal_followups'] = $i;
            $purchaseOrders = $this->PurchaseOrder->find('count', array('conditions' => array($orderDateRange, 'PurchaseOrder.customer_id' => $key, 'PurchaseOrder.publish' => 1, 'PurchaseOrder.soft_delete' => 0)));
            $result['Number_of_purchase_orders'] = $purchaseOrders;
            $results[] = $result;
        endforeach;
        $this->set(array('resultMappings' => $results));
        return $results;
    }

    public function readiness() {

        $this->loadModel('MasterListOfFormatDepartment');
        $departments = $this->_get_department_list();

        $this->loadModel('User');
        $users = $this->User->find('list');
        $files = 0;
        $count = 0;
        foreach ($departments as $dKey => $dVal):
            $dresults = null;
            $masterListOfFormats = $this->MasterListOfFormatDepartment->find('all', array(
                'conditions' => array('MasterListOfFormatDepartment.publish' => 1, 'MasterListOfFormatDepartment.department_id' => $dKey, 'MasterListOfFormat.company_id' => $this->Session->read('User.company_id')),
                'fields' => array('MasterListOfFormat.id', 'MasterListOfFormat.title', 'SystemTable.system_name'),
                'recursive' => 0,
                    )
            );
            $dResults = array();
            foreach ($masterListOfFormats as $formats):
              $result = 0;
				$file = 0;
                foreach ($users as $key => $value):
                    $dir = new Folder(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/upload/' . $key . '/master_list_of_formats/' . $formats['MasterListOfFormat']['id']);
                    $folders = $dir->read();
                    if (count($folders[1]) > 0) {
                        $result = 1;
                        $file = $file + 1;
                        $files = $files + 1;
                    } else {
                        $result = 0;
                    }
                    $srcResult['id'] = $formats['MasterListOfFormat']['id'];
                    $srcResult['title'] = $formats['MasterListOfFormat']['title'];
                    $srcResult['file'] = $file;
                    $count = $count + 1;
                endforeach;
                $dResults[] = $srcResult;
            endforeach;
            $results[$dVal] = $dResults;
        endforeach;
	        $rediness = round(($files * 100) / $count);
        $this->set(compact('results', 'rediness'));

        $file = fopen(WWW_ROOT . "/files/" . $this->Session->read('User.company_id') . "/rediness.txt", "w") or die('can not open file');
        fwrite($file, $rediness);
        fclose($file);
    }

    public function production() {

        $materials = $this->requestAction('App/get_model_list/Material/');
        $countMaterials = count($materials);

        $products = $this->requestAction('App/get_model_list/Product/');
        $countProducts = count($products);

        $productions = $this->requestAction('App/get_model_list/Production/');
        $countProductions = count($productions);

        $this->loadModel('Stock');
        $addToStocks = $this->Stock->find('count', array('conditions' => array('Stock.publish' => 1, 'Stock.soft_delete' => 0, 'Stock.type' => 0)));
        $addFromStocks = $this->Stock->find('count', array('conditions' => array('Stock.publish' => 1, 'Stock.soft_delete' => 0, 'Stock.type' => 1)));

        $this->set(compact('countMaterials', 'countProducts', 'countProductions', 'countStocks', 'addToStocks', 'addFromStocks'));

    }

}

