<?php

App::uses('AppController', 'Controller');

/**
 * Meetings Controller
 *
 * @property Meeting $Meeting
 */
class MeetingsController extends AppController {

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
        $this->paginate = array('order' => array('Meeting.sr_no' => 'DESC'), 'conditions' => array($conditions),
            'joins' => array(array(
                    'table' => 'meeting_employees',
                    'alias' => 'meeting_employees',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('meeting_employees.meeting_id = Meeting.id'))),
            'group' => '`Meeting`.`id`');

        $this->Meeting->recursive = 0;
        $meetings = $this->paginate();
        foreach ($meetings as $key => $meeting) {

            $meetingBranch = $this->Meeting->MeetingBranch->find('first', array('conditions' => array('MeetingBranch.meeting_id' => $meeting['Meeting']['id'], 'MeetingBranch.soft_delete' => 0), 'fields' => 'Branch.name', 'order' => array('Branch.name' => 'DESC')));
            $meetings[$key]['Meeting']['Branches'] = $meetingBranch['Branch']['name'];

            $meetingDepartments = $this->Meeting->MeetingDepartment->find('all', array('conditions' => array('MeetingDepartment.meeting_id' => $meeting['Meeting']['id'], 'MeetingDepartment.soft_delete' => 0), 'fields' => 'Department.name', 'order' => array('Department.name' => 'DESC')));
            $depts = array();
            foreach ($meetingDepartments as $meetingDepartment)
                $depts[] = $meetingDepartment['Department']['name'];
            $meetings[$key]['Meeting']['Departments'] = implode(', ', $depts);

            $meetingTopics = $this->Meeting->MeetingTopic->find('all', array('conditions' => array('MeetingTopic.meeting_id' => $meeting['Meeting']['id'])));
            $topics = array();
            foreach ($meetingTopics as $meetingTopic)
                $topics[] = $meetingTopic['MeetingTopic']['title'];
            $meetings[$key]['Meeting']['Topics'] = implode(', ', $topics);

            $meetingEmployees = $this->Meeting->MeetingEmployee->find('all', array('conditions' => array('MeetingEmployee.meeting_id' => $meeting['Meeting']['id'], 'MeetingEmployee.soft_delete' => 0), 'fields' => 'Employee.name', 'order' => array('Employee.name' => 'DESC')));
            $emps = array();
            foreach ($meetingEmployees as $meetingEmployee)
                $emps[] = $meetingEmployee['Employee']['name'];
            $meetings[$key]['Meeting']['Attendees'] = implode(', ', $emps);

            $this->loadModel('Employee');
            $meetingEmp = $this->Employee->find('first', array('conditions' => array('Employee.id' => $meeting['Meeting']['employee_by'], 'Employee.soft_delete' => 0, 'Employee.publish' => 1), 'fields' => 'Employee.name'));

            $meetings[$key]['Meeting']['employee_by'] = $meetingEmp['Employee']['name'];
        }

        $this->set('meetings', $meetings);
        $this->_get_count();
    }

    public function get_department_employee($departmentId = null) {
        $departmentsId = array();
        $departmentsId = split(',', $departmentId);
        $this->loadModel('Employee');
        $this->loadModel('User');
        $deptEmployees = $this->User->find('list', array('conditions' => array('User.soft_delete' => 0, 'User.publish' => 1, 'User.department_id' => $departmentsId), 'fields' => array('Employee.id', 'Employee.name'), 'recursive' => 0));

        $this->set('deptEmployees', $deptEmployees);
        $this->render('/Elements/department');
     }

    public function meeting_detail_index() {

        $conditions = $this->_check_request();
        $this->paginate = array('order' => array('Meeting.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->Meeting->recursive = 0;
        $meetings = $this->paginate();
        foreach ($meetings as $key => $meeting) {

            $meetingBranch = $this->Meeting->MeetingBranch->find('first', array('conditions' => array('MeetingBranch.meeting_id' => $meeting['Meeting']['id'], 'MeetingBranch.soft_delete' => 0, 'MeetingBranch.publish' => 1), 'fields' => 'Branch.name', 'order' => array('Branch.name' => 'DESC')));
            $meetings[$key]['Meeting']['Branches'] = $meetingBranch['Branch']['name'];

            $meetingDepartments = $this->Meeting->MeetingDepartment->find('all', array('conditions' => array('MeetingDepartment.meeting_id' => $meeting['Meeting']['id'], 'MeetingDepartment.soft_delete' => 0), 'fields' => 'Department.name', 'order' => array('Department.name' => 'DESC')));
            $depts = array();
            foreach ($meetingDepartments as $meetingDepartment)
                $depts[] = $meetingDepartment['Department']['name'];
            $meetings[$key]['Meeting']['Departments'] = implode(', ', $depts);

            $meetingTopics = $this->Meeting->MeetingTopic->find('all', array('conditions' => array('MeetingTopic.meeting_id' => $meeting['Meeting']['id'])));
            $topics = array();
            foreach ($meetingTopics as $meetingTopic)
                $topics[] = $meetingTopic['MeetingTopic']['title'];
            $meetings[$key]['Meeting']['Topics'] = implode(', ', $topics);

            $meetingEmployees = $this->Meeting->MeetingAttendee->find('all', array('conditions' => array('MeetingAttendee.meeting_id' => $meeting['Meeting']['id'], 'MeetingAttendee.soft_delete' => 0), 'fields' => 'Employee.name', 'order' => array('Employee.name' => 'DESC')));
            $emps = array();
            foreach ($meetingEmployees as $meetingEmployee)
                $emps[] = $meetingEmployee['Employee']['name'];
            $meetings[$key]['Meeting']['Attendees'] = implode(', ', $emps);

            $this->loadModel('Employee');
            $meetingEmp = $this->Employee->find('first', array('conditions' => array('Employee.id' => $meeting['Meeting']['employee_by'], 'Employee.soft_delete' => 0, 'Employee.publish' => 1), 'fields' => 'Employee.name'));

            $meetings[$key]['Meeting']['employee_by'] = $meetingEmp['Employee']['name'];
        }

        $this->set('meetings', $meetings);
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
                        $searchArray[] = array('Meeting.' . $search => $search_key);
                    else
                        $searchArray[] = array('Meeting.' . $search . ' like ' => '%' . $search_key . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('Meeting.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('or' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['employee_id'] != -1) {

            $chairpersonConditions[] = array('Meeting.employee_by' => $this->request->query['employee_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $chairpersonConditions);
            else
                $conditions[] = array('or' => $chairpersonConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('Meeting.scheduled_meeting_from >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'Meeting.scheduled_meeting_from <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);
        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('Meeting.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0) {
            $onlyOwn = array('Or' => array('Meeting.created_by' => $this->Session->read('User.id'), 'Meeting.employee_by' => $this->Session->read('User.employee_id'), 'meeting_employees.employee_id' => $this->Session->read('User.employee_id')));
        }
        $conditions[] = array($onlyBranch, $onlyOwn, array('Meeting.soft_delete' => 0));
        $this->Meeting->recursive = 0;
        $this->paginate = array('order' => array('Meeting.sr_no' => 'DESC'),
            'conditions' => $conditions, 'joins' => array(array(
                    'table' => 'meeting_employees',
                    'alias' => 'meeting_employees',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('meeting_employees.meeting_id = Meeting.id'))),
            'group' => '`Meeting`.`id`');
        $meetings = $this->paginate();
        foreach ($meetings as $key => $meeting) {
            $meetingBranch = $this->Meeting->MeetingBranch->find('first', array('conditions' => array('MeetingBranch.meeting_id' => $meeting['Meeting']['id'], 'MeetingBranch.soft_delete' => 0, 'MeetingBranch.publish' => 1), 'fields' => 'Branch.name', 'order' => array('Branch.name' => 'DESC')));
            $meetings[$key]['Meeting']['Branches'] = $meetingBranch['Branch']['name'];

            $meetingDepartments = $this->Meeting->MeetingDepartment->find('all', array('conditions' => array('MeetingDepartment.meeting_id' => $meeting['Meeting']['id'], 'MeetingDepartment.soft_delete' => 0), 'fields' => 'Department.name', 'order' => array('Department.name' => 'DESC')));
            $depts = array();
            foreach ($meetingDepartments as $meetingDepartment)
                $depts[] = $meetingDepartment['Department']['name'];
            $meetings[$key]['Meeting']['Departments'] = implode(', ', $depts);

            $meetingTopics = $this->Meeting->MeetingTopic->find('all', array('conditions' => array('MeetingTopic.meeting_id' => $meeting['Meeting']['id'])));
            $topics = array();
            foreach ($meetingTopics as $meetingTopic)
                $topics[] = $meetingTopic['MeetingTopic']['title'];
            $meetings[$key]['Meeting']['Topics'] = implode(', ', $topics);
            $meetingEmployees = $this->Meeting->MeetingEmployee->find('all', array('conditions' => array('MeetingEmployee.meeting_id' => $meeting['Meeting']['id'], 'MeetingEmployee.soft_delete' => 0), 'fields' => 'Employee.name', 'order' => array('Employee.name' => 'DESC')));
            $emps = array();
            foreach ($meetingEmployees as $meetingEmployee)
                $emps[] = $meetingEmployee['Employee']['name'];
            $meetings[$key]['Meeting']['Attendees'] = implode(', ', $emps);

            $this->loadModel('Employee');
            $meetingEmp = $this->Employee->find('first', array('conditions' => array('Employee.id' => $meeting['Meeting']['employee_by'], 'Employee.soft_delete' => 0, 'Employee.publish' => 1), 'fields' => 'Employee.name'));

            $meetings[$key]['Meeting']['employee_by'] = $meetingEmp['Employee']['name'];
        }
        $this->set('meetings', $meetings);


        $this->render('index');
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function meeting_view($id = null) {
        if (!$this->Meeting->exists($id)) {
            throw new NotFoundException(__('Invalid meeting'));
        }
        $options = array('conditions' => array('Meeting.' . $this->Meeting->primaryKey => $id));
        $meeting = $this->Meeting->find('first', $options);
        $meetingBranch = $this->Meeting->MeetingBranch->find('first', array('conditions' => array('MeetingBranch.meeting_id' => $meeting['Meeting']['id'], 'MeetingBranch.soft_delete' => 0), 'fields' => 'Branch.name', 'order' => array('Branch.name' => 'DESC')));
        $meeting['Meeting']['Branches'] = $meetingBranch['Branch']['name'];

        $meetingDepartments = $this->Meeting->MeetingDepartment->find('all', array('conditions' => array('MeetingDepartment.meeting_id' => $meeting['Meeting']['id'], 'MeetingDepartment.soft_delete' => 0), 'fields' => 'Department.name', 'order' => array('Department.name' => 'DESC')));
        $depts = array();
        foreach ($meetingDepartments as $meetingDepartment)
            $depts[] = $meetingDepartment['Department']['name'];
        $meeting['Meeting']['Departments'] = implode(', ', $depts);

        $meetingEmployees = $this->Meeting->MeetingEmployee->find('all', array('conditions' => array('MeetingEmployee.meeting_id' => $meeting['Meeting']['id'], 'MeetingEmployee.soft_delete' => 0), 'fields' => 'Employee.name', 'order' => array('Employee.name' => 'DESC')));
        $emps = array();
        foreach ($meetingEmployees as $meetingEmployee)
            $emps[] = $meetingEmployee['Employee']['name'];
        $meeting['Meeting']['Invitees'] = implode(', ', $emps);

        $meetingAttendees = $this->Meeting->MeetingAttendee->find('all', array('conditions' => array('MeetingAttendee.meeting_id' => $meeting['Meeting']['id'], 'MeetingAttendee.soft_delete' => 0), 'fields' => 'Employee.name', 'order' => array('Employee.name' => 'DESC')));
        $emps = array();
        foreach ($meetingAttendees as $meetingAttendee)
            $atts[] = $meetingAttendee['Employee']['name'];
        $meeting['Meeting']['Attendees'] = implode(', ', $atts);

        $this->loadModel('Employee');
        $meetingEmp = $this->Employee->find('first', array('conditions' => array('Employee.id' => $meeting['Meeting']['employee_by'], 'Employee.soft_delete' => 0, 'Employee.publish' => 1), 'fields' => 'Employee.name'));

        $meeting['Meeting']['employee_by'] = $meetingEmp['Employee']['name'];
        $this->set('meeting', $meeting);

        $meetingTopics = $this->Meeting->MeetingTopic->find('all', array('conditions' => array('MeetingTopic.meeting_id' => $meeting['Meeting']['id']), 'recursive' => 1));
        $this->set('meetingTopics', $meetingTopics);
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Meeting->exists($id)) {
            throw new NotFoundException(__('Invalid meeting'));
        }
        $options = array('conditions' => array('Meeting.' . $this->Meeting->primaryKey => $id));
        $meeting = $this->Meeting->find('first', $options);
        $meetingBranch = $this->Meeting->MeetingBranch->find('first', array('conditions' => array('MeetingBranch.meeting_id' => $meeting['Meeting']['id'], 'MeetingBranch.soft_delete' => 0), 'fields' => 'Branch.name', 'order' => array('Branch.name' => 'DESC')));
        $meeting['Meeting']['Branches'] = $meetingBranch['Branch']['name'];

        $meetingDepartments = $this->Meeting->MeetingDepartment->find('all', array('conditions' => array('MeetingDepartment.meeting_id' => $meeting['Meeting']['id'], 'MeetingDepartment.soft_delete' => 0), 'fields' => 'Department.name', 'order' => array('Department.name' => 'DESC')));
        $depts = array();
        foreach ($meetingDepartments as $meetingDepartment)
            $depts[] = $meetingDepartment['Department']['name'];
        $meeting['Meeting']['Departments'] = implode(', ', $depts);

        $meetingEmployees = $this->Meeting->MeetingEmployee->find('all', array('conditions' => array('MeetingEmployee.meeting_id' => $meeting['Meeting']['id'], 'MeetingEmployee.soft_delete' => 0), 'fields' => 'Employee.name', 'order' => array('Employee.name' => 'DESC')));
        $emps = array();
        foreach ($meetingEmployees as $meetingEmployee)
            $emps[] = $meetingEmployee['Employee']['name'];
        $meeting['Meeting']['Invitees'] = implode(', ', $emps);

        $meetingAttendees = $this->Meeting->MeetingAttendee->find('all', array('conditions' => array('MeetingAttendee.meeting_id' => $meeting['Meeting']['id'], 'MeetingAttendee.soft_delete' => 0), 'fields' => 'Employee.name', 'order' => array('Employee.name' => 'DESC')));
        $emps = array();
        $atts = array();
        foreach ($meetingAttendees as $meetingAttendee)
            $atts[] = $meetingAttendee['Employee']['name'];
        $meeting['Meeting']['Attendees'] = implode(', ', $atts);

        $this->loadModel('Employee');
        $meetingEmp = $this->Employee->find('first', array('conditions' => array('Employee.id' => $meeting['Meeting']['employee_by'], 'Employee.soft_delete' => 0, 'Employee.publish' => 1), 'fields' => 'Employee.name'));

        $meeting['Meeting']['employee_by'] = $meetingEmp['Employee']['name'];
        $this->set('meeting', $meeting);

        $meetingTopics = $this->Meeting->MeetingTopic->find('all', array('order'=>array('MeetingTopic.sr_no'=>'ASC'),'conditions' => array('MeetingTopic.meeting_id' => $meeting['Meeting']['id']), 'recursive' => 1));
        $this->set('meetingTopics', $meetingTopics);
    }

    public function before_meeting_view($id = null) {
        if (!$this->Meeting->exists($id)) {
            throw new NotFoundException(__('Invalid meeting'));
        }
        $options = array('conditions' => array('Meeting.' . $this->Meeting->primaryKey => $id));
        $meeting = $this->Meeting->find('first', $options);

        $meetingBranch = $this->Meeting->MeetingBranch->find('first', array('conditions' => array('MeetingBranch.meeting_id' => $meeting['Meeting']['id'], 'MeetingBranch.soft_delete' => 0, 'MeetingBranch.publish' => 1), 'fields' => 'Branch.name', 'order' => array('Branch.name' => 'DESC')));
        $meeting['Meeting']['Branches'] = $meetingBranch['Branch']['name'];

        $meetingDepartments = $this->Meeting->MeetingDepartment->find('all', array('conditions' => array('MeetingDepartment.meeting_id' => $meeting['Meeting']['id'], 'MeetingDepartment.soft_delete' => 0), 'fields' => 'Department.name', 'order' => array('Department.name' => 'DESC')));
        $depts = array();
        foreach ($meetingDepartments as $meetingDepartment)
            $depts[] = $meetingDepartment['Department']['name'];
        $meeting['Meeting']['Departments'] = implode(', ', $depts);

        $meetingEmployees = $this->Meeting->MeetingEmployee->find('all', array('conditions' => array('MeetingEmployee.meeting_id' => $meeting['Meeting']['id'], 'MeetingEmployee.soft_delete' => 0), 'fields' => 'Employee.name', 'order' => array('Employee.name' => 'DESC')));
        $emps = array();
        foreach ($meetingEmployees as $meetingEmployee)
            $emps[] = $meetingEmployee['Employee']['name'];
        $meeting['Meeting']['Attendees'] = implode(', ', $emps);

        $this->loadModel('Employee');
        $meetingEmp = $this->Employee->find('first', array('conditions' => array('Employee.id' => $meeting['Meeting']['employee_by'], 'Employee.soft_delete' => 0, 'Employee.publish' => 1), 'fields' => 'Employee.name'));

        $meeting['Meeting']['employee_by'] = $meetingEmp['Employee']['name'];
        $this->set('meeting', $meeting);

        $meetingTopics = $this->Meeting->MeetingTopic->find('all', array('order'=>'MeetingTopic.sr_no','conditions' => array('MeetingTopic.meeting_id' => $meeting['Meeting']['id'])));
        $this->set('meetingTopics', $meetingTopics);

        $meetingEmployees = $this->Meeting->MeetingEmployee->find('all', array('conditions' => array('MeetingEmployee.meeting_id' => $id, 'MeetingEmployee.soft_delete' => 0), 'fields' => 'MeetingEmployee.employee_id'));
        foreach ($meetingEmployees as $meetingEmployee) {
            $selectedEmp[] = $meetingEmployee['MeetingEmployee']['employee_id'];
        }
        $this->set(compact('selectedEmp'));



        // get other details like customer complaints / change request / document amendment etc
        $this->loadModel('ChangeAdditionDeletionRequest');
        $changeAdditionDeletionRequests = $this->ChangeAdditionDeletionRequest->find('list', array('ChangeAdditionDeletionRequest.publish' => 1, 'ChangeAdditionDeletionRequest.soft_delete' => 0));

        $this->loadModel('CorrectivePreventiveAction');
        $correctivePreventiveActions = $this->CorrectivePreventiveAction->find('list', array('CorrectivePreventiveAction.publish' => 1, 'CorrectivePreventiveAction.soft_delete' => 0));

        $this->loadModel('CustomerFeedback');
        $customerFeedbacks = $this->CustomerFeedback->find('list', array('CustomerFeedback.publish' => 1, 'CustomerFeedback.soft_delete' => 0));

        $this->loadModel('CustomerComplaint');
        $customerComplaints = $this->CustomerComplaint->find('list', array('CustomerComplaint.publish' => 1, 'CustomerComplaint.soft_delete' => 0));

        $this->loadModel('InternalAuditPlan');
        $internalAuditPlans = $this->InternalAuditPlan->find('list', array('InternalAuditPlan.publish' => 1, 'InternalAuditPlan.soft_delete' => 0));

        $this->loadModel('SupplierEvaluationReevaluation');
        $supplierEvaluationReevaluations = $this->SupplierEvaluationReevaluation->find('list', array('SupplierEvaluationReevaluation.publish' => 1, 'SupplierEvaluationReevaluation.soft_delete' => 0));

        $this->set(compact('changeAdditionDeletionRequests', 'correctivePreventiveActions', 'customerFeedbacks', 'customerComplaints', 'internalAuditPlans', 'supplierEvaluationReevaluations'));
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
     * list method
     *
     * @return void
     */
    public function meeting_detail_lists() {

        $this->_get_count();
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Meeting->exists($id)) {
            throw new NotFoundException(__('Invalid meeting'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Meeting']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['Meeting']['modified_by'] = $this->Session->read('User.id');
            if ($this->Meeting->save($this->request->data, false)) {
                $this->loadModel('MeetingEmployee');
                $this->MeetingEmployee->deleteAll(array('MeetingEmployee.meeting_id' => $this->Meeting->id), false);
                foreach ($this->request->data['MeetingEmployee_employee_id'] as $val) {
                    $this->MeetingEmployee->create();
                    $valData = array();
                    $valData['meeting_id'] = $this->Meeting->id;
                    $valData['employee_id'] = $val;
                    $valData['publish'] = $this->request->data['Meeting']['publish'];
                    $valData['system_table_id'] = $this->_get_system_table_id();
                    $this->MeetingEmployee->save($valData, false);
                }

                $this->loadModel('MeetingDepartment');
                $this->MeetingDepartment->deleteAll(array('MeetingDepartment.meeting_id' => $this->Meeting->id), false);

                foreach ($this->request->data['MeetingDepartment_department_id'] as $val) {
                    $this->MeetingDepartment->create();
                    $valData = array();
                    $valData['meeting_id'] = $this->Meeting->id;
                    $valData['department_id'] = $val;
                    $valData['publish'] = $this->request->data['Meeting']['publish'];
                    $valData['system_table_id'] = $this->_get_system_table_id();
                    $this->MeetingDepartment->save($valData, false);
                }
                $this->loadModel('MeetingBranch');
                $this->MeetingBranch->deleteAll(array('MeetingBranch.meeting_id' => $this->Meeting->id), false);
                $this->MeetingBranch->create();
                $valData = array();
                $valData['meeting_id'] = $this->Meeting->id;
                $valData['branch_id'] = $this->request->data['MeetingBranch']['branch_id'];
                $valData['publish'] = $this->request->data['Meeting']['publish'];
                $valData['system_table_id'] = $this->_get_system_table_id();
                $this->MeetingBranch->save($valData, false);


                $this->loadModel('MeetingTopic');
                $this->MeetingTopic->deleteAll(array('MeetingTopic.meeting_id' => $this->Meeting->id), false);
                foreach ($this->request->data['MeetingTopic'] as $val) {
                    if ($val['topic'] != '') {
                        $this->MeetingTopic->create();
                        $val['meeting_id'] = $this->Meeting->id;
                        $val['title'] = $val['topic'];
                        $val['publish'] = $this->request->data['Meeting']['publish'];
                        $val['system_table_id'] = $this->_get_system_table_id();
                        if ($val['topic'] != '')
                            $this->MeetingTopic->save($val, false);
                    }
                }
                foreach ($this->request->data['AdditionalTopics']['CustomerComplaint'] as $val) {
                    if (isset($val['customer_complaint_id']) && $val['customer_complaint_id'] != 0) {
                        $this->MeetingTopic->create();
                        $val['meeting_id'] = $this->Meeting->id;
                        $val['title'] = 'Customer Complaint';
                        $val['publish'] = $this->request->data['Meeting']['publish'];
                        $val['system_table_id'] = $this->_get_system_table_id();
                        $this->loadModel('CustomerComplaint');
                        $ccDetails = $this->CustomerComplaint->find('first', array('conditions' => array('CustomerComplaint.publish' => 1, 'CustomerComplaint.soft_delete' => 0, 'CustomerComplaint.id' => $val['customer_complaint_id']), 'recursive' => -1));

                        $val['current_status'] = $ccDetails['CustomerComplaint']['details'];
                        $val['employee_id'] = $ccDetails['CustomerComplaint']['employee_id'];
                        $val['target_date'] = $ccDetails['CustomerComplaint']['target_date'];
                        $val['action_plan'] = $ccDetails['CustomerComplaint']['action_taken'];
                        $this->MeetingTopic->save($val, false);
                    }
                }
                foreach ($this->request->data['AdditionalTopics']['CorrectivePreventiveAction'] as $val) {
                    if (isset($val['corrective_preventive_action_id']) && $val['corrective_preventive_action_id'] != 0) {
                        $this->MeetingTopic->create();
                        $val['meeting_id'] = $this->Meeting->id;

                        $val['publish'] = $this->request->data['Meeting']['publish'];
                        $val['system_table_id'] = $this->_get_system_table_id();

                        $this->loadModel('CorrectivePreventiveAction');
                        $capaDetails = $this->CorrectivePreventiveAction->find('first', array('conditions' => array('CorrectivePreventiveAction.publish' => 1, 'CorrectivePreventiveAction.soft_delete' => 0, 'CorrectivePreventiveAction.id' => $val['corrective_preventive_action_id']), 'recursive' => -1));
                        $val['title'] = "Corrective Preventive Action : " . $capaDetails['CorrectivePreventiveAction']['name'];
                        $val['current_status'] = $capaDetails['CorrectivePreventiveAction']['initial_remarks'];
                        $val['employee_id'] = $capaDetails['CorrectivePreventiveAction']['assigned_to'];
                        $val['target_date'] = $capaDetails['CorrectivePreventiveAction']['target_date'];
                        $val['action_plan'] = $capaDetails['CorrectivePreventiveAction']['proposed_immidiate_action'];

                        $this->MeetingTopic->save($val, false);
                    }
                }
                foreach ($this->request->data['AdditionalTopics']['ChangeAdditionDeletionRequest'] as $val) {
                    if (isset($val['change_addition_deletion_request_id']) && $val['change_addition_deletion_request_id'] != 0) {
                        $this->MeetingTopic->create();
                        $val['meeting_id'] = $this->Meeting->id;

                        $val['publish'] = $this->request->data['Meeting']['publish'];
                        $val['system_table_id'] = $this->_get_system_table_id();

                        $this->loadModel('ChangeAdditionDeletionRequest');
                        $docRequestDetails = $this->ChangeAdditionDeletionRequest->find('first', array('conditions' => array('ChangeAdditionDeletionRequest.publish' => 1, 'ChangeAdditionDeletionRequest.soft_delete' => 0, 'ChangeAdditionDeletionRequest.id' => $val['change_addition_deletion_request_id']), 'recursive' => -1));
                        if(count($docRequestDetails)){
                            $this->loadModel('MasterListOfFormat');
                            $masterListOfFormats = $this->MasterListOfFormat->find('all', array('conditions' => array('MasterListOfFormat.id'=>$docRequestDetails['ChangeAdditionDeletionRequest']['master_list_of_format'] )));
                            if(isset($masterListOfFormats['MasterListOfFormat']['title'])){
                                  $val['title'] = "Change Addition Deletion Request : " . $masterListOfFormats['MasterListOfFormat']['title'];
                            }

                            $val['current_status'] = $docRequestDetails['ChangeAdditionDeletionRequest']['current_document_details'];
                            $val['action_plan'] = $docRequestDetails['ChangeAdditionDeletionRequest']['proposed_changes'];
                            $this->MeetingTopic->save($val, false);
                        }
                    }
                }

                foreach ($this->request->data['AdditionalTopics']['SummeryOfSupplierEvaluation'] as $val) {
                    if (isset($val['summery_of_supplier_evaluation_id']) && $val['summery_of_supplier_evaluation_id'] != 0) {
                        $this->MeetingTopic->create();
                        $val['meeting_id'] = $this->Meeting->id;

                        $val['publish'] = $this->request->data['Meeting']['publish'];
                        $val['system_table_id'] = $this->_get_system_table_id();

                        $this->loadModel('SummeryOfSupplierEvaluation');
                        $supplierDetails = $this->SummeryOfSupplierEvaluation->find('first', array('conditions' => array('SummeryOfSupplierEvaluation.publish' => 1, 'SummeryOfSupplierEvaluation.soft_delete' => 0, 'SummeryOfSupplierEvaluation.id' => $val['summery_of_supplier_evaluation_id']), 'recursive' => -1));
                        $val['title'] = "Summery Of Supplier Evaluation ";
                        $val['current_status'] = $supplierDetails['SummeryOfSupplierEvaluation']['remarks'];
                        $val['employee_id'] = $supplierDetails['SummeryOfSupplierEvaluation']['employee_id'];
                        $val['target_date'] = $supplierDetails['SummeryOfSupplierEvaluation']['evaluation_date'];
                        $val['action_plan'] = '';

                        $this->MeetingTopic->save($val, false);
                    }
                }

                //Edit show meeting on timeline
                if ($this->request->data['Meeting']['show_on_timeline'] && $this->request->data['Meeting']['publish']) {

                    $this->loadModel('Timeline');
                    $this->Timeline->deleteAll(array('meeting_id' => $this->Meeting->id), false);

                    $this->Timeline->create();

                    $val = array();
                    $val['title'] = $this->request->data['Meeting']['title'];
                    $val['message'] = $this->request->data['Meeting']['meeting_details'];
                    $val['start_date'] = $this->request->data['Meeting']['scheduled_meeting_from'];
                    $val['end_date'] = $this->request->data['Meeting']['scheduled_meeting_to'];
                    $val['meeting_id'] = $this->Meeting->id;
                    $val['prepared_by'] = $this->Session->read('User.id');
                    $val['approved_by'] = $this->Session->read('User.id');
                    $val['publish'] = $this->request->data['Meeting']['publish'];
                    $val['system_table_id'] = $this->_get_system_table_id();
                    $this->Timeline->save($val, false);
                } else {
                    $this->loadModel('Timeline');
                    $this->Timeline->deleteAll(array('meeting_id' => $this->Meeting->id), false);
                }



                //edit meeting on notification table
                $this->loadModel('Notification');
                $notifications = $this->Notification->find('first', array('conditions' => array('meeting_id' => $this->Meeting->id)), false);

                if ($notifications) {
                     $notifications_id = $notifications['Notification']['id'];
                    $val = array();
                    $val['id'] = $notifications_id;
                    $val['title'] = $this->request->data['Meeting']['title'];
                    $val['message'] = $this->request->data['Meeting']['meeting_details'];
                    $val['start_date'] = $this->request->data['Meeting']['scheduled_meeting_from'];
                    $val['end_date'] = $this->request->data['Meeting']['scheduled_meeting_to'];
                    $val['prepared_by'] = $this->Session->read('User.employee_id');
                    $val['approved_by'] = $this->Session->read('User.employee_id');
                    $val['meeting_id'] = $this->Meeting->id;
                    $val['publish'] = $this->request->data['Meeting']['publish'];
                    $val['system_table_id'] = $this->_get_system_table_id();
                    $this->Notification->save($val, false);

                    //Edit meeting notification user
                    $this->loadModel('NotificationUser');
                    $this->NotificationUser->deleteAll(array('notification_id' => $notifications_id), false);
                    if (!in_array($this->request->data['Meeting']['employee_by'], $this->request->data['MeetingEmployee_employee_id'])) {
                        $this->request->data['MeetingEmployee_employee_id'][] = $this->request->data['Meeting']['employee_by'];
                    }
                    foreach ($this->request->data['MeetingEmployee_employee_id'] as $employee_id) { {
                            $this->NotificationUser->create();
                            $val = array();
                            $val['notification_id'] = $this->Notification->id;
                            $val['employee_id'] = $employee_id;
                            $val['publish'] = 1;
                            $val['system_table_id'] = $this->_get_system_table_id();
                            $this->NotificationUser->save($val, false);
                        }
                    }
                }

                $this->Session->setFlash(__('The meeting has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The meeting could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Meeting.' . $this->Meeting->primaryKey => $id));
            $this->request->data = $this->Meeting->find('first', $options);
        }
        $masterListOfFormats = $this->Meeting->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0)));
        $meetingBranch = $this->Meeting->MeetingBranch->find('first', array('conditions' => array('MeetingBranch.meeting_id' => $id, 'MeetingBranch.soft_delete' => 0)));
        $this->request->data['MeetingBranch']['branch_id'] = $meetingBranch['MeetingBranch']['branch_id'];
        $meetingDepartments = $this->Meeting->MeetingDepartment->find('all', array('conditions' => array('MeetingDepartment.meeting_id' => $id, 'MeetingDepartment.soft_delete' => 0), 'fields' => 'MeetingDepartment.department_id'));
        foreach ($meetingDepartments as $meetingDepartment) {
            $selectedDept[] = $meetingDepartment['MeetingDepartment']['department_id'];
        }
        $this->set('selectedDept', $selectedDept);
        $meetingEmployees = $this->Meeting->MeetingEmployee->find('all', array('conditions' => array('MeetingEmployee.meeting_id' => $id, 'MeetingEmployee.soft_delete' => 0), 'fields' => 'MeetingEmployee.employee_id'));
        foreach ($meetingEmployees as $meetingEmployee) {
            $selectedEmp[] = $meetingEmployee['MeetingEmployee']['employee_id'];
        }
        $this->set('selectedEmp', $selectedEmp);
        $PublishedEmployeeList = $this->Meeting->MeetingEmployee->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $this->set(compact('PublishedEmployeeList', 'systemTables', 'masterListOfFormats'));
        $meetingTopic = $this->Meeting->MeetingTopic->find('all', array('conditions' => array('MeetingTopic.meeting_id ' => $id, 'MeetingTopic.soft_delete' => 0)));
        $j = 0;
        $additionalTopics = array();
        $defaultTopics = array();

        foreach ($meetingTopic as $key => $val) {
            if ($val['MeetingTopic']['change_addition_deletion_request_id'] != NULL) {
                $additionalTopics['ChangeAdditionDeletionRequest'][] = $val['MeetingTopic']['change_addition_deletion_request_id'];
            } else
            if ($val['MeetingTopic']['corrective_preventive_action_id'] != NULL) {
                $additionalTopics['CorrectivePreventiveAction'][] = $val['MeetingTopic']['corrective_preventive_action_id'];
            } else
            if ($val['MeetingTopic']['customer_complaint_id'] != NULL) {
                $additionalTopics['CustomerComplaint'][] = $val['MeetingTopic']['customer_complaint_id'];
            } else
            if ($val['MeetingTopic']['summery_of_supplier_evaluation_id'] != NULL) {
                $additionalTopics['SummeryOfSupplierEvaluation'][] = $val['MeetingTopic']['summery_of_supplier_evaluation_id'];
            } else {
                $defaultTopics[$j] = $val['MeetingTopic'];
                $defaultTopics[$j]['topic'] = $val['MeetingTopic']['title'];
                $j++;
            }
        }
        unset($this->request->data['MeetingTopic']);
        $this->request->data['MeetingTopic'] = $defaultTopics;
        $this->loadModel('ChangeAdditionDeletionRequest');
        $this->loadModel('CorrectivePreventiveAction');
        $this->loadModel('CustomerFeedback');
        $this->loadModel('CustomerComplaint');
        $this->loadModel('InternalAuditPlan');
        $this->loadModel('SummeryOfSupplierEvaluation');


        $this->ChangeAdditionDeletionRequest->recursive = 0;
        $allChangeAdditionDeletionRequests = $this->ChangeAdditionDeletionRequest->find('all', array('conditions' =>array('ChangeAdditionDeletionRequest.publish' => 1, 'ChangeAdditionDeletionRequest.soft_delete' => 0)));
        $this->CorrectivePreventiveAction->recursive = 0;
        $allCorrectivePreventiveActions = $this->CorrectivePreventiveAction->find('all', array('conditions' =>array('CorrectivePreventiveAction.publish' => 1, 'CorrectivePreventiveAction.soft_delete' => 0)));
        $allCustomerFeedbacks = $this->CustomerFeedback->find('all', array('conditions' =>array('CustomerFeedback.publish' => 1, 'CustomerFeedback.soft_delete' => 0)));
        $allCustomerComplaints = $this->CustomerComplaint->find('all', array('conditions' =>array('CustomerComplaint.publish' => 1, 'CustomerComplaint.soft_delete' => 0)));
        $allInternalAuditPlans = $this->InternalAuditPlan->find('all', array('conditions' =>array('InternalAuditPlan.publish' => 1, 'InternalAuditPlan.soft_delete' => 0)));
        $allSummeryOfSupplierEvaluations = $this->SummeryOfSupplierEvaluation->find('all', array('conditions' =>array('SummeryOfSupplierEvaluation.publish' => 1, 'SummeryOfSupplierEvaluation.soft_delete' => 0)));

        $this->set(compact('allChangeAdditionDeletionRequests', 'allCorrectivePreventiveActions', 'allCustomerFeedbacks', 'allCustomerComplaints', 'allInternalAuditPlans', 'allSummeryOfSupplierEvaluations', 'additionalTopics'));
    }

    public function after_meeting() {
        $date = date('Y-m-d');
        $meetings = $this->Meeting->find('list', array('conditions' => array('Meeting.publish' => 1, 'Meeting.soft_delete' => 0, 'DATE(Meeting.scheduled_meeting_from) <' => $date)));
        $this->set('meetings', $meetings);

        if ($this->request->is('post')) {
            $data = array();
            $data['id'] = $this->request->data['AfterMeeting']['id'];
            $data['system_table_id'] = $this->_get_system_table_id();
            $data['modified_by'] = $this->Session->read('User.id');
            $data['actual_meeting_from'] = $this->request->data['AfterMeeting']['actual_meeting_from'];
            $data['actual_meeting_to'] = $this->request->data['AfterMeeting']['actual_meeting_to'];

            if ($this->Meeting->save($data, false)) {
                $this->loadModel('MeetingAttendee');
                $this->MeetingAttendee->deleteAll(array('MeetingAttendee.meeting_id' => $this->Meeting->id), false);
                foreach ($this->request->data['MeetingEmployee_employee_id'] as $val) {
                    $this->MeetingAttendee->create();
                    $valData = array();
                    $valData['meeting_id'] = $this->Meeting->id;
                    $valData['employee_id'] = $val;
                    $valData['publish'] = 1;
                    $valData['branchid'] = $this->Session->read('User.branch_id');
                    $valData['departmentid'] = $this->Session->read('User.department_id');
                    $valData['created_by'] = $this->Session->read('User.id');
                    $valData['modified_by'] = $this->Session->read('User.id');
                    $valData['system_table_id'] = $this->_get_system_table_id();
                    $this->MeetingAttendee->save($valData, false);
                }

                $this->loadModel('MeetingTopic');
                $this->MeetingTopic->deleteAll(array('MeetingTopic.meeting_id' => $this->Meeting->id), false);
                $meeting_actions = array();
                $i = 0;
                foreach ($this->request->data['MeetingTopic'] as $val) {
                        $this->MeetingTopic->create();
                        $val['meeting_id'] = $this->Meeting->id;
                        $val['title'] = $val['topic'];
                        $val['target_date'] = $val['t_date'];
                        $val['current_status'] = $val['current_status'];
                        $val['publish'] = 1;
                        $val['branchid'] = $this->Session->read('User.branch_id');
                        $val['departmentid'] = $this->Session->read('User.department_id');
                        $val['created_by'] = $this->Session->read('User.id');
                        $val['modified_by'] = $this->Session->read('User.id');
                        $val['system_table_id'] = $this->_get_system_table_id();
                        if ($val['topic'] != ''){
                        $this->MeetingTopic->save($val, false);
                    }

                    if ($val['change_addition_deletion_request_id'] > 0 || $val['corrective_preventive_action_id'] > 0 || $val['customer_feedback_id'] > 0 || $val['customer_complaint_id'] > 0 || $val['internal_audit_plan_id'] > 0 || $val['supplier_evaluation_reevaluation_id'] > 0) {

                        if ($val['corrective_preventive_action_id'] > 0) {
                            $meeting_actions[$i]['title'] = $val['topic'];
                            $meeting_actions[$i]['type'] = 'Corrective Preventive Action';
                            $meeting_actions[$i]['controller'] = 'corrective_preventive_actions';
                            $meeting_actions[$i]['action_id'] = $val['corrective_preventive_action_id'];
                        } else if ($val['customer_feedback_id'] > 0) {
                            $meeting_actions[$i]['title'] = $val['topic'];
                            $meeting_actions[$i]['type'] = 'Customer Feedback';
                            $meeting_actions[$i]['controller'] = 'customer_feedbacks';
                            $meeting_actions[$i]['action_id'] = $val['customer_feedback_id'];
                        } else if ($val['customer_complaint_id'] > 0) {
                            $meeting_actions[$i]['title'] = $val['topic'];
                            $meeting_actions[$i]['type'] = 'Customer Complaint';
                            $meeting_actions[$i]['controller'] = 'customer_complaints';
                            $meeting_actions[$i]['action_id'] = $val['customer_complaint_id'];
                        } else if ($val['internal_audit_plan_id'] > 0) {
                            $meeting_actions[$i]['title'] = $val['topic'];
                            $meeting_actions[$i]['type'] = 'Internal Audit Plan';
                            $meeting_actions[$i]['controller'] = 'internal_audit_plans';
                            $meeting_actions[$i]['action_id'] = $val['internal_audit_plan_id'];
                        } else if ($val['supplier_evaluation_reevaluation_id'] > 0) {
                            $meeting_actions[$i]['title'] = $val['topic'];
                            $meeting_actions[$i]['type'] = 'Supplier Evaluation Reevaluation';
                            $meeting_actions[$i]['controller'] = 'supplier_evaluation_reevaluations';
                            $meeting_actions[$i]['action_id'] = $val['supplier_evaluation_reevaluation_id'];
                        } else if ($val['change_addition_deletion_request_id'] > 0) {
                            $meeting_actions[$i]['title'] = $val['topic'];
                            $meeting_actions[$i]['type'] = 'Change Addition Deletion Request';
                            $meeting_actions[$i]['controller'] = 'change_addition_deletion_requests';
                            $meeting_actions[$i]['action_id'] = $val['change_addition_deletion_request_id'];
                        }
                        $i++;
                    }
                }

                if ($i > 0) {
                    $this->set('meeting_actions', $meeting_actions);
                    $this->Session->setFlash(__('The meeting details has been saved'));
                    $this->redirect(array('action'=>'view'));
                } else {
                    $this->Session->setFlash(__('The meeting details has been saved'));
                    $this->redirect(array('action'=>'view',  $this->Meeting->id));
                }
            }
        }
    }

   
    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null, $flag = true) {

        $modelName = $this->modelClass;
        $this->loadModel('Approval');
        if (!empty($id)) {

            $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => $modelName), 'recursive' => -1));
            foreach ($approves as $approve) {
                $approve['Approval']['soft_delete'] = 1;
                $this->Approval->save($approve, false);
            }
            $data = array();
            $data['id'] = $id;
            $data['soft_delete'] = 1;
            $this->$modelName->save($data, false);

            $this->loadModel('Timeline');
            $timelineMeeting = $this->Timeline->find('first', array('conditions' => array('meeting_id' => $id)), false);
            if ($timelineMeeting['Timeline']['id']) {
                $data = array();
                $data['id'] = $timelineMeeting['Timeline']['id'];
                $data['soft_delete'] = 1;
                $this->Timeline->save($data, false);
            }

            $this->loadModel('Notification');
            $notificationMeeting = $this->Notification->find('first', array('conditions' => array('meeting_id' => $id)), false);
            if ($notificationMeeting['Notification']['id']) {
                $data = array();
                $data['id'] = $notificationMeeting['Notification']['id'];
                $data['soft_delete'] = 1;
                $this->Notification->save($data, false);
            }
        }
        if ($flag)
            $this->redirect(array('action' => 'index'));
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
            $this->request->data['Meeting']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['Meeting']['created_by'] = $this->Session->read('User.id');
            $this->request->data['Meeting']['modified_by'] = $this->Session->read('User.id');
            $this->Meeting->create();

            if ($this->Meeting->save($this->request->data, false)) {

                $this->loadModel('MeetingEmployee');
                foreach ($this->request->data['MeetingEmployee_employee_id'] as $val) {
                    $this->MeetingEmployee->create();
                    $valData = array();
                    $valData['meeting_id'] = $this->Meeting->id;
                    $valData['employee_id'] = $val;
                    $valData['publish'] = $this->request->data['Meeting']['publish'];
                    $valData['branchid'] = $this->request->data['Meeting']['branchid'];
                    $valData['departmentid'] = $this->request->data['Meeting']['departmentid'];
                    $valData['created_by'] = $this->Session->read('User.id');
                    $valData['modified_by'] = $this->Session->read('User.id');
                    $valData['system_table_id'] = $this->_get_system_table_id();
                    $this->MeetingEmployee->save($valData, false);
                }

                $this->loadModel('MeetingDepartment');
                foreach ($this->request->data['MeetingDepartment_department_id'] as $val) {
                    $this->MeetingDepartment->create();
                    $valData = array();
                    $valData['meeting_id'] = $this->Meeting->id;
                    $valData['department_id'] = $val;
                    $valData['publish'] = $this->request->data['Meeting']['publish'];
                    $valData['branchid'] = $this->request->data['Meeting']['branchid'];
                    $valData['departmentid'] = $this->request->data['Meeting']['departmentid'];
                    $valData['created_by'] = $this->Session->read('User.id');
                    $valData['modified_by'] = $this->Session->read('User.id');
                    $valData['system_table_id'] = $this->_get_system_table_id();
                    $this->MeetingDepartment->save($valData, false);
                }
                $this->loadModel('MeetingBranch');
                $this->MeetingBranch->create();
                $valData = array();
                $valData['meeting_id'] = $this->Meeting->id;
                $valData['branch_id'] = $this->request->data['MeetingBranch']['branch_id'];
                $valData['publish'] = $this->request->data['Meeting']['publish'];
                $valData['branchid'] = $this->request->data['Meeting']['branchid'];
                $valData['departmentid'] = $this->request->data['Meeting']['departmentid'];
                $valData['created_by'] = $this->Session->read('User.id');
                $valData['modified_by'] = $this->Session->read('User.id');
                $valData['system_table_id'] = $this->_get_system_table_id();
                $this->MeetingBranch->save($valData, false);


                $this->loadModel('MeetingTopic');
                foreach ($this->request->data['MeetingTopic'] as $val) {
                    if ($val['topic'] != '') {
                        $this->MeetingTopic->create();
                        $val['meeting_id'] = $this->Meeting->id;
                        $val['title'] = $val['topic'];
                        $val['publish'] = $this->request->data['Meeting']['publish'];
                        $val['branchid'] = $this->request->data['Meeting']['branchid'];
                        $val['departmentid'] = $this->request->data['Meeting']['departmentid'];
                        $val['created_by'] = $this->Session->read('User.id');
                        $val['modified_by'] = $this->Session->read('User.id');
                        $val['system_table_id'] = $this->_get_system_table_id();
                        $this->MeetingTopic->save($val, false);
                    }
                }
                if(isset($this->request->data['AdditionalTopics']['CustomerComplaint'])){
                    foreach ($this->request->data['AdditionalTopics']['CustomerComplaint'] as $val) {
                        if (isset($val['customer_complaint_id']) && $val['customer_complaint_id'] != 0) {
                            $this->MeetingTopic->create();
                            $val['meeting_id'] = $this->Meeting->id;
                            $val['title'] = 'Customer Complaint';
                            $val['publish'] = $this->request->data['Meeting']['publish'];
                            $val['branchid'] = $this->request->data['Meeting']['branchid'];
                            $val['departmentid'] = $this->request->data['Meeting']['departmentid'];
                            $val['created_by'] = $this->Session->read('User.id');
                            $val['modified_by'] = $this->Session->read('User.id');
                            $val['system_table_id'] = $this->_get_system_table_id();
                            $this->loadModel('CustomerComplaint');
                            $ccDetails = $this->CustomerComplaint->find('first', array('conditions' => array('CustomerComplaint.publish' => 1, 'CustomerComplaint.soft_delete' => 0, 'CustomerComplaint.id' => $val['customer_complaint_id']), 'recursive' => -1));
                            $val['current_status'] = $ccDetails['CustomerComplaint']['details'];
                            $val['employee_id'] = $ccDetails['CustomerComplaint']['employee_id'];
                            $val['target_date'] = $ccDetails['CustomerComplaint']['target_date'];
                            $val['action_plan'] = $ccDetails['CustomerComplaint']['action_taken'];
                            $this->MeetingTopic->save($val, false);
                        }
                    }
                }
                if(isset($this->request->data['AdditionalTopics']['CorrectivePreventiveAction'])){
                    foreach ($this->request->data['AdditionalTopics']['CorrectivePreventiveAction'] as $val) {
                        if (isset($val['corrective_preventive_action_id']) && $val['corrective_preventive_action_id'] != 0) {
                            $this->MeetingTopic->create();
                            $val['meeting_id'] = $this->Meeting->id;
                            $val['publish'] = $this->request->data['Meeting']['publish'];
                            $val['branchid'] = $this->request->data['Meeting']['branchid'];
                            $val['departmentid'] = $this->request->data['Meeting']['departmentid'];
                            $val['created_by'] = $this->Session->read('User.id');
                            $val['modified_by'] = $this->Session->read('User.id');
                            $val['system_table_id'] = $this->_get_system_table_id();
                            $this->loadModel('CorrectivePreventiveAction');
                            $capaDetails = $this->CorrectivePreventiveAction->find('first', array('conditions' => array('CorrectivePreventiveAction.publish' => 1, 'CorrectivePreventiveAction.soft_delete' => 0, 'CorrectivePreventiveAction.id' => $val['corrective_preventive_action_id']), 'recursive' => -1));
                            $val['title'] = "Corrective Preventive Action : " . $capaDetails['CorrectivePreventiveAction']['name'];
                            $val['current_status'] = $capaDetails['CorrectivePreventiveAction']['initial_remarks'];
                            $val['employee_id'] = $capaDetails['CorrectivePreventiveAction']['assigned_to'];
                            $val['target_date'] = $capaDetails['CorrectivePreventiveAction']['target_date'];
                            $val['action_plan'] = $capaDetails['CorrectivePreventiveAction']['proposed_immidiate_action'];
                            $this->MeetingTopic->save($val, false);
                        }
                    }
                }

                if(isset($this->request->data['AdditionalTopics']['ChangeAdditionDeletionRequest'])){
                    foreach ($this->request->data['AdditionalTopics']['ChangeAdditionDeletionRequest'] as $val) {
                        if (isset($val['change_addition_deletion_request_id']) && $val['change_addition_deletion_request_id'] != 0) {
                            $this->MeetingTopic->create();
                            $val['meeting_id'] = $this->Meeting->id;
                            $val['publish'] = $this->request->data['Meeting']['publish'];
                            $val['branchid'] = $this->request->data['Meeting']['branchid'];
                            $val['departmentid'] = $this->request->data['Meeting']['departmentid'];
                            $val['created_by'] = $this->Session->read('User.id');
                            $val['modified_by'] = $this->Session->read('User.id');
                            $val['system_table_id'] = $this->_get_system_table_id();
                            $this->loadModel('ChangeAdditionDeletionRequest');
                            $docRequestDetails = $this->ChangeAdditionDeletionRequest->find('first', array('conditions' => array('ChangeAdditionDeletionRequest.publish' => 1, 'ChangeAdditionDeletionRequest.soft_delete' => 0, 'ChangeAdditionDeletionRequest.id' => $val['change_addition_deletion_request_id']), 'recursive' => -1));
                            $val['title'] = "Change Addition Deletion Request : " . $val['name'];
                            $val['current_status'] = $docRequestDetails['ChangeAdditionDeletionRequest']['current_document_details'];
                            $val['action_plan'] = $docRequestDetails['ChangeAdditionDeletionRequest']['proposed_changes'];
                            $this->MeetingTopic->save($val, false);
                        }
                    }
                }

                if(isset($this->request->data['AdditionalTopics']['SummeryOfSupplierEvaluation'])){
                    foreach ($this->request->data['AdditionalTopics']['SummeryOfSupplierEvaluation'] as $val) {
                        if (isset($val['summery_of_supplier_evaluation_id']) && $val['summery_of_supplier_evaluation_id'] != 0) {
                            $this->MeetingTopic->create();
                            $val['meeting_id'] = $this->Meeting->id;
                            $val['publish'] = $this->request->data['Meeting']['publish'];
                            $val['branchid'] = $this->request->data['Meeting']['branchid'];
                            $val['departmentid'] = $this->request->data['Meeting']['departmentid'];
                            $val['created_by'] = $this->Session->read('User.id');
                            $val['modified_by'] = $this->Session->read('User.id');
                            $val['system_table_id'] = $this->_get_system_table_id();
                            $this->loadModel('SummeryOfSupplierEvaluation');
                            $supplierDetails = $this->SummeryOfSupplierEvaluation->find('first', array('conditions' => array('SummeryOfSupplierEvaluation.publish' => 1, 'SummeryOfSupplierEvaluation.soft_delete' => 0, 'SummeryOfSupplierEvaluation.id' => $val['summery_of_supplier_evaluation_id']), 'recursive' => -1));
                            $val['title'] = "Summery Of Supplier Evaluation ";
                            $val['current_status'] = $supplierDetails['SummeryOfSupplierEvaluation']['remarks'];
                            $val['employee_id'] = $supplierDetails['SummeryOfSupplierEvaluation']['employee_id'];
                            $val['target_date'] = $supplierDetails['SummeryOfSupplierEvaluation']['evaluation_date'];
                            $val['action_plan'] = '';
                            $this->MeetingTopic->save($val, false);
                        }
                    }
                }
                $this->loadModel('SummeryOfSupplierEvaluation');
                $allSummeryOfSupplierEvaluations = $this->SummeryOfSupplierEvaluation->find('all', array('SummeryOfSupplierEvaluation.publish' => 1, 'SummeryOfSupplierEvaluation.soft_delete' => 0));
                if ($this->request->data['Meeting']['show_on_timeline']) {
                    $this->loadModel('Timeline');
                    $this->Timeline->create();
                    $var = array();
                    $val['title'] = $this->request->data['Meeting']['title'];
                    $val['message'] = $this->request->data['Meeting']['meeting_details'];
                    $val['start_date'] = $this->request->data['Meeting']['scheduled_meeting_from'];
                    $val['end_date'] = $this->request->data['Meeting']['scheduled_meeting_to'];
                    $val['prepared_by'] = $this->Session->read('User.id');
                    $val['approved_by'] = $this->Session->read('User.id');
                    $val['meeting_id'] = $this->Meeting->id;
                    $val['publish'] = $this->request->data['Meeting']['publish'];
                    $val['branchid'] = $this->request->data['Meeting']['branchid'];
                    $val['departmentid'] = $this->request->data['Meeting']['departmentid'];
                    $val['created_by'] = $this->Session->read('User.id');
                    $val['modified_by'] = $this->Session->read('User.id');
                    $val['system_table_id'] = $this->_get_system_table_id();
                    $this->Timeline->save($val, false);
                }

                //save internal audit plan on notification
                $this->loadModel('NotificationType');
                $notificationType = $this->NotificationType->find('first', array('conditions' => array('NotificationType.name' => 'Meetings', 'NotificationType.soft_delete' => 0)));
                if (count($notificationType)) {
                    $this->loadModel('Notification');
                    $this->Notification->create();
                    $val = array();
                    $val['notification_type_id'] = $notificationType['NotificationType']['id'];
                    $val['title'] = $this->request->data['Meeting']['title'];
                    $val['message'] = $this->request->data['Meeting']['meeting_details'];
                    $val['start_date'] = $this->request->data['Meeting']['scheduled_meeting_from'];
                    $val['end_date'] = $this->request->data['Meeting']['scheduled_meeting_to'];
                    $val['prepared_by'] = $this->Session->read('User.employee_id');
                    $val['approved_by'] = $this->Session->read('User.employee_id');
                    $val['meeting_id'] = $this->Meeting->id;
                    $val['publish'] = $this->request->data['Meeting']['publish'];
                    $val['branchid'] = $this->request->data['Meeting']['branchid'];
                    $val['departmentid'] = $this->request->data['Meeting']['departmentid'];
                    $val['created_by'] = $this->Session->read('User.id');
                    $val['modified_by'] = $this->Session->read('User.id');
                    $val['system_table_id'] = $this->_get_system_table_id();
                    $this->Notification->save($val, false);

                    $this->loadModel('NotificationUser');
                    if (!in_array($this->request->data['Meeting']['employee_by'], $this->request->data['MeetingEmployee_employee_id'])) {
                        $this->request->data['MeetingEmployee_employee_id'][] = $this->request->data['Meeting']['employee_by'];
                    }
                    foreach ($this->request->data['MeetingEmployee_employee_id'] as $employee_id) { {
                            $this->NotificationUser->create();
                            $val = array();
                            $val['notification_id'] = $this->Notification->id;
                            ;
                            $val['employee_id'] = $employee_id;
                            $val['publish'] = $this->request->data['Meeting']['publish'];
                            $val['branchid'] = $this->request->data['Meeting']['branchid'];
                            $val['departmentid'] = $this->request->data['Meeting']['departmentid'];
                            $val['created_by'] = $this->Session->read('User.id');
                            $val['modified_by'] = $this->Session->read('User.id');
                            $val['system_table_id'] = $this->_get_system_table_id();
                            $this->NotificationUser->save($val, false);
                        }
                    }
                }

                $this->Session->setFlash(__('The meeting has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->Meeting->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The meeting could not be saved. Please, try again.'));
            }
        }
        $systemTables = $this->Meeting->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $masterListOfFormats = $this->Meeting->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0)));
        $this->set(compact('systemTables', 'masterListOfFormats'));
        $PublishedEmployeeList = $this->Meeting->MeetingEmployee->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $this->set(compact('PublishedEmployeeList','count', 'published', 'unpublished'));
                // get other details like customer complaints / change request / document amendment etc
        $this->loadModel('ChangeAdditionDeletionRequest');

        $this->loadModel('CorrectivePreventiveAction');

        $this->loadModel('CustomerFeedback');

        $this->loadModel('CustomerComplaint');

        $this->loadModel('InternalAuditPlan');

        $this->loadModel('SummeryOfSupplierEvaluation');

        $this->ChangeAdditionDeletionRequest->recursive = 0;
        $allChangeAdditionDeletionRequests = $this->ChangeAdditionDeletionRequest->find('all', array('conditions' =>array('ChangeAdditionDeletionRequest.publish' => 1, 'ChangeAdditionDeletionRequest.soft_delete' => 0)));
        $this->CorrectivePreventiveAction->recursive = 0;
        $allCorrectivePreventiveActions = $this->CorrectivePreventiveAction->find('all', array('conditions' =>array('CorrectivePreventiveAction.publish' => 1, 'CorrectivePreventiveAction.soft_delete' => 0)));
        $allCustomerFeedbacks = $this->CustomerFeedback->find('all', array('conditions' =>array('CustomerFeedback.publish' => 1, 'CustomerFeedback.soft_delete' => 0)));
        $allCustomerComplaints = $this->CustomerComplaint->find('all', array('conditions' =>array('CustomerComplaint.publish' => 1, 'CustomerComplaint.soft_delete' => 0)));
        $allInternalAuditPlans = $this->InternalAuditPlan->find('all', array('conditions' =>array('InternalAuditPlan.publish' => 1, 'InternalAuditPlan.soft_delete' => 0)));
        $allSummeryOfSupplierEvaluations = $this->SummeryOfSupplierEvaluation->find('all', array('conditions' =>array('SummeryOfSupplierEvaluation.publish' => 1, 'SummeryOfSupplierEvaluation.soft_delete' => 0)));

        
        
        $this->set(compact('allChangeAdditionDeletionRequests', 'allCorrectivePreventiveActions', 'allCustomerFeedbacks', 'allCustomerComplaints', 'allInternalAuditPlans', 'allSummeryOfSupplierEvaluations'));
    }

    public function add_meeting_topics($i = null) {
        $this->set('i', $i);
        // get other details like customer complaints / change request / document amendment etc
        $this->loadModel('ChangeAdditionDeletionRequest');
        $changeAdditionDeletionRequests = $this->ChangeAdditionDeletionRequest->find('list', array('ChangeAdditionDeletionRequest.publish' => 1, 'ChangeAdditionDeletionRequest.soft_delete' => 0));

        $this->loadModel('CorrectivePreventiveAction');
        $correctivePreventiveActions = $this->CorrectivePreventiveAction->find('list', array('CorrectivePreventiveAction.publish' => 1, 'CorrectivePreventiveAction.soft_delete' => 0));

        $this->loadModel('CustomerFeedback');
        $customerFeedbacks = $this->CustomerFeedback->find('list', array('CustomerFeedback.publish' => 1, 'CustomerFeedback.soft_delete' => 0));

        $this->loadModel('CustomerComplaint');
        $customerComplaints = $this->CustomerComplaint->find('list', array('CustomerComplaint.publish' => 1, 'CustomerComplaint.soft_delete' => 0));

        $this->loadModel('InternalAuditPlan');
        $internalAuditPlans = $this->InternalAuditPlan->find('list', array('InternalAuditPlan.publish' => 1, 'InternalAuditPlan.soft_delete' => 0));

        $this->loadModel('SupplierEvaluationReevaluation');
        $supplierEvaluationReevaluations = $this->SupplierEvaluationReevaluation->find('list', array('SupplierEvaluationReevaluation.publish' => 1, 'SupplierEvaluationReevaluation.soft_delete' => 0));

        $this->set(compact('changeAdditionDeletionRequests', 'correctivePreventiveActions', 'customerFeedbacks', 'customerComplaints', 'internalAuditPlans', 'supplierEvaluationReevaluations'));


        $this->render('add_meeting_topics');
    }

    public function add_after_meeting_topics() {

        $this->set('i', $this->request->data['i']);
        $starttime = strtotime($this->request->data['time']);
        $this->set('starttime',date('Y-m-d',$starttime));

        $this->loadModel('ChangeAdditionDeletionRequest');
        $changeAdditionDeletionRequests = $this->ChangeAdditionDeletionRequest->find('list', array('ChangeAdditionDeletionRequest.publish' => 1, 'ChangeAdditionDeletionRequest.soft_delete' => 0));

        $this->loadModel('CorrectivePreventiveAction');
        $correctivePreventiveActions = $this->CorrectivePreventiveAction->find('list', array('CorrectivePreventiveAction.publish' => 1, 'CorrectivePreventiveAction.soft_delete' => 0));

        $this->loadModel('CustomerFeedback');
        $customerFeedbacks = $this->CustomerFeedback->find('list', array('CustomerFeedback.publish' => 1, 'CustomerFeedback.soft_delete' => 0));

        $this->loadModel('CustomerComplaint');
        $customerComplaints = $this->CustomerComplaint->find('list', array('CustomerComplaint.publish' => 1, 'CustomerComplaint.soft_delete' => 0));

        $this->loadModel('InternalAuditPlan');
        $internalAuditPlans = $this->InternalAuditPlan->find('list', array('InternalAuditPlan.publish' => 1, 'InternalAuditPlan.soft_delete' => 0));

        $this->loadModel('SupplierEvaluationReevaluation');
        $supplierEvaluationReevaluations = $this->SupplierEvaluationReevaluation->find('list', array('SupplierEvaluationReevaluation.publish' => 1, 'SupplierEvaluationReevaluation.soft_delete' => 0));

       $this->set(compact('changeAdditionDeletionRequests', 'correctivePreventiveActions', 'customerFeedbacks', 'customerComplaints', 'internalAuditPlans', 'supplierEvaluationReevaluations'));

        $this->render('add_after_meeting_topics');
    }

    /**
     * restore method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function restore($id = null, $flag = true) {

        $modelName = $this->modelClass;
        if (!empty($id)) {

            $data['id'] = $id;
            $data['soft_delete'] = 0;
            $modelName = $this->modelClass;
            $this->$modelName->save($data, false);

            $this->loadModel('Timeline');
            $timelineMeeting = $this->Timeline->find('first', array('conditions' => array('meeting_id' => $id)), false);
            if ($timelineMeeting['Timeline']['id']) {
                $data = array();
                $data['id'] = $timelineMeeting['Timeline']['id'];
                $data['soft_delete'] = 0;
                $this->Timeline->save($data);
            }
            $this->loadModel('Approval');
            $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => $modelName), 'recursive' => -1));
            foreach ($approves as $approve) {
                $approve['Approval']['soft_delete'] = 0;
                $this->Approval->save($approve, false);
            }

            $this->loadModel('Notification');
            $notificationMeeting = $this->Notification->find('first', array('conditions' => array('meeting_id' => $id)), false);
            if ($notificationMeeting['Notification']['id']) {
                $data = array();
                $data['id'] = $notificationMeeting['Notification']['id'];
                $data['soft_delete'] = 0;
                $this->Notification->save($data);
            }
        }
        if ($flag)
            $this->redirect(array('action' => 'index'));
    }

    public function delete_all($ids = null) {

        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);

        $modelName = $this->modelClass;
        $this->loadModel('Approval');
        if (!empty($ids)) {

            foreach ($ids as $id) {
                if (!empty($id)) {
                    $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => $modelName)));
                    foreach ($approves as $approve) {
                        $this->delete($approve['Approval']['id'], false);
                    }
                    $this->delete($id, false);
                }
            }
        }
        $this->Session->setFlash(__('All selected value deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function restore_all($ids = null) {
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);

        $modelName = $this->modelClass;
        $this->loadModel('Approval');
        if (!empty($ids)) {

            foreach ($ids as $id) {
                if (!empty($id)) {
                    $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => $modelName)));
                    foreach ($approves as $approve) {
                        $this->restore($approve['Approval']['id'], false);
                    }
                    $this->restore($id, false);
                }
            }
        }
        $this->Session->setFlash(__('All selected value restored'));
        $this->redirect(array('action' => 'index'));
    }

}
 
