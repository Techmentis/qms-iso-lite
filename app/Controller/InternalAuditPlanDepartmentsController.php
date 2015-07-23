<?php

App::uses('AppController', 'Controller');

/**
 * InternalAuditPlanDepartments Controller
 *
 * @property InternalAuditPlanDepartment $InternalAuditPlanDepartment
 */
class InternalAuditPlanDepartmentsController extends AppController {

    public function _get_system_table_id() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $sys_id = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $this->request->params['controller'])));
        return $sys_id['SystemTable']['id'];
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {

        $conditions = $this->_check_request();
        $this->paginate = array('order' => array('InternalAuditPlanDepartment.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->InternalAuditPlanDepartment->recursive = 0;
        $this->set('internalAuditPlanDepartments', $this->paginate());

        $this->_get_count();
    }

    /**
     * adcanced_search method
     * Advanced search by - TGS
     * @return void
     */
    public function advanced_search() {

        $conditions = array();
        if ($this->request->data['Search']['keywords']) {
            $search_array = array();
            $search_keys = explode(" ", $this->request->data['Search']['keywords']);

            foreach ($search_keys as $search_key):
                foreach ($this->request->data['Search']['search_fields'] as $search):
                    if ($this->request->data['Search']['strict_search'] == 0)
                        $search_array[] = array('InternalAuditPlanDepartment.' . $search => $search_key);
                    else
                        $search_array[] = array('InternalAuditPlanDepartment.' . $search . ' like ' => '%' . $search_key . '%');

                endforeach;
            endforeach;
            if ($this->request->data['Search']['strict_search'] == 0)
                $conditions[] = array('and' => $search_array);
            else
                $conditions[] = array('or' => $search_array);
        }

        if ($this->request->data['Search']['branch_list']) {
            foreach ($this->request->data['Search']['branch_list'] as $branches):
                $branch_conditions[] = array('InternalAuditPlanDepartment.branch_id' => $branches);
            endforeach;
            $conditions[] = array('or' => $branch_conditions);
        }

        if (!$this->request->data['Search']['to-date'])
            $this->request->data['Search']['to-date'] = date('Y-m-d');
        if ($this->request->data['Search']['from-date']) {
            $conditions[] = array('InternalAuditPlanDepartment.created >' => date('Y-m-d h:i:s', strtotime($this->request->data['Search']['from-date'])), 'InternalAuditPlanDepartment.created <' => date('Y-m-d h:i:s', strtotime($this->request->data['Search']['to-date'])));
        }
        unset($this->request->data['Search']);


        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('InternalAuditPlanDepartment.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('InternalAuditPlanDepartment.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->InternalAuditPlanDepartment->recursive = 0;
        $this->paginate = array('order' => array('InternalAuditPlanDepartment.sr_no' => 'DESC'), 'conditions' => $conditions, 'InternalAuditPlanDepartment.soft_delete' => 0);
        $this->set('internalAuditPlanDepartments', $this->paginate());

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
        if (!$this->InternalAuditPlanDepartment->exists($id)) {
            throw new NotFoundException(__('Invalid internal audit plan department'));
        }
        $options = array('conditions' => array('InternalAuditPlanDepartment.' . $this->InternalAuditPlanDepartment->primaryKey => $id));
        $this->set('internalAuditPlanDepartment', $this->InternalAuditPlanDepartment->find('first', $options));
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
    public function plan_add_ajax($plan_id) {

        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }

        if ($this->request->is('post')) {

            $this->request->data['InternalAuditPlanDepartment']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['InternalAuditPlanDepartment']['start_time'] = $this->request->data['InternalAuditPlanDepartment']['startTime'];
            $this->request->data['InternalAuditPlanDepartment']['end_time'] = $this->request->data['InternalAuditPlanDepartment']['endTime'];
            $this->request->data['InternalAuditPlanDepartment']['note'] = htmlentities($this->request->data['InternalAuditPlanDepartment']['note']);
            $this->request->data['InternalAuditPlanDepartment']['created_by'] = $this->Session->read('User.id');
            $this->request->data['InternalAuditPlanDepartment']['modified_by'] = $this->Session->read('User.id');
            $this->request->data['InternalAuditPlanDepartment']['publish'] = 1;

            $this->InternalAuditPlanDepartment->create();
            if ($this->InternalAuditPlanDepartment->save($this->request->data, false)) {
                $this->loadModel('InternalAuditPlanBranch');

                $this->InternalAuditPlanBranch->create();

                $branchData['internal_audit_plan_id'] = $this->request->data['InternalAuditPlanDepartment']['internal_audit_plan_id'];
                $branchData['branch_id'] = $this->request->data['InternalAuditPlanDepartment']['branch_id'];
                $branchData['publish'] = $this->request->data['InternalAuditPlanDepartment']['publish'];
                $branchData['branchid'] = $this->request->data['InternalAuditPlanDepartment']['branchid'];
                $branchData['departmentid'] = $this->request->data['InternalAuditPlanDepartment']['departmentid'];
                $branchData['publish'] = 1;
                $branchData['created_by'] = $this->Session->read('User.id');
                $branchData['modified_by'] = $this->Session->read('User.id');
                $branchData['system_table_id'] = $this->_get_system_table_id();

                $this->InternalAuditPlanBranch->save($branchData, false);

                $this->Session->setFlash(__('The internal audit plan department has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->InternalAuditPlanDepartment->id));
                else
                    $this->redirect(array('controller' => 'internal_audit_plans', 'action' => 'plan_add_ajax', $plan_id));
            } else {
                $this->Session->setFlash(__('The internal audit plan department could not be saved. Please, try again.'));
            }
        }
        $internalAuditPlans = $this->InternalAuditPlanDepartment->InternalAuditPlan->find('list', array('conditions' => array('InternalAuditPlan.publish' => 1, 'InternalAuditPlan.soft_delete' => 0)));
        $departments = $this->InternalAuditPlanDepartment->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0)));
        $employees = $this->InternalAuditPlanDepartment->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $listOfTrainedInternalAuditors = $this->InternalAuditPlanDepartment->ListOfTrainedInternalAuditor->find('list', array('fields' => array('ListOfTrainedInternalAuditor.id', 'Employee.name'), 'conditions' => array('ListOfTrainedInternalAuditor.publish' => 1, 'ListOfTrainedInternalAuditor.soft_delete' => 0), recursive => 0));
        $systemTables = $this->InternalAuditPlanDepartment->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $masterListOfFormats = $this->InternalAuditPlanDepartment->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0)));
        $this->set(compact('internalAuditPlans', 'departments', 'employees', 'listOfTrainedInternalAuditors', 'systemTables', 'masterListOfFormats'));
        $count = $this->InternalAuditPlanDepartment->find('count');
        $published = $this->InternalAuditPlanDepartment->find('count', array('conditions' => array('InternalAuditPlanDepartment.publish' => 1)));
        $unpublished = $this->InternalAuditPlanDepartment->find('count', array('conditions' => array('InternalAuditPlanDepartment.publish' => 0)));

        $this->set(compact('count', 'published', 'unpublished'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->InternalAuditPlanDepartment->exists($id)) {
            throw new NotFoundException(__('Invalid internal audit plan department'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['InternalAuditPlanDepartment']['system_table_id'] = $this->_get_system_table_id();

            if ($this->InternalAuditPlanDepartment->save($this->request->data)) {

                $this->Session->setFlash(__('The internal audit plan department has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('controller' => 'internal_audit_plans', 'action' => 'lists', $this->request->data['InternalAuditPlanDepartment']['internal_audit_plan_id']));
                else
                    $this->redirect(array('controller' => 'internal_audit_plans', 'action' => 'lists', $this->request->data['InternalAuditPlanDepartment']['internal_audit_plan_id']));
            } else {
                $this->Session->setFlash(__('The internal audit plan department could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('InternalAuditPlanDepartment.' . $this->InternalAuditPlanDepartment->primaryKey => $id));
            $this->request->data = $this->InternalAuditPlanDepartment->find('first', $options);
        }
        $internalAuditPlans = $this->InternalAuditPlanDepartment->InternalAuditPlan->find('list', array('conditions' => array('InternalAuditPlan.publish' => 1, 'InternalAuditPlan.soft_delete' => 0)));
        $departments = $this->InternalAuditPlanDepartment->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0)));
        $branches = $this->InternalAuditPlanDepartment->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));

        $employees = $this->InternalAuditPlanDepartment->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $listOfTrainedInternalAuditors = $this->InternalAuditPlanDepartment->ListOfTrainedInternalAuditor->find('list', array('fields' => array('ListOfTrainedInternalAuditor.id', 'Employee.name'), 'conditions' => array('ListOfTrainedInternalAuditor.publish' => 1, 'ListOfTrainedInternalAuditor.soft_delete' => 0), 'recursive' => 0));
        $systemTables = $this->InternalAuditPlanDepartment->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $masterListOfFormats = $this->InternalAuditPlanDepartment->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0)));
        $this->set(compact('internalAuditPlans', 'departments', 'branches', 'employees', 'listOfTrainedInternalAuditors', 'systemTables', 'masterListOfFormats'));
        $count = $this->InternalAuditPlanDepartment->find('count');
        $published = $this->InternalAuditPlanDepartment->find('count', array('conditions' => array('InternalAuditPlanDepartment.publish' => 1)));
        $unpublished = $this->InternalAuditPlanDepartment->find('count', array('conditions' => array('InternalAuditPlanDepartment.publish' => 0)));

        $this->set(compact('count', 'published', 'unpublished'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approval_id = null) {
        if (!$this->InternalAuditPlanDepartment->exists($id)) {
            throw new NotFoundException(__('Invalid internal audit plan department'));
        }

        $this->loadModel('Approval');
        if (!$this->Approval->exists($approval_id)) {
            throw new NotFoundException(__('Invalid approval id'));
        }

        $approval = $this->Approval->read(null, $approval_id);
        $this->set('same', $approval['Approval']['user_id']);

        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->InternalAuditPlanDepartment->save($this->request->data)) {

                $this->Session->setFlash(__('The internal audit plan department has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The internal audit plan department could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('InternalAuditPlanDepartment.' . $this->InternalAuditPlanDepartment->primaryKey => $id));
            $this->request->data = $this->InternalAuditPlanDepartment->find('first', $options);
        }
        $internalAuditPlans = $this->InternalAuditPlanDepartment->InternalAuditPlan->find('list', array('conditions' => array('InternalAuditPlan.publish' => 1, 'InternalAuditPlan.soft_delete' => 0)));
        $branches = $this->InternalAuditPlanDepartment->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $departments = $this->InternalAuditPlanDepartment->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0)));
        $employees = $this->InternalAuditPlanDepartment->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $listOfTrainedInternalAuditors = $this->InternalAuditPlanDepartment->ListOfTrainedInternalAuditor->find('list', array('fields' => array('ListOfTrainedInternalAuditor.id', 'Employee.name'), 'conditions' => array('ListOfTrainedInternalAuditor.publish' => 1, 'ListOfTrainedInternalAuditor.soft_delete' => 0), 'recursive' => 0));
        $systemTables = $this->InternalAuditPlanDepartment->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $masterListOfFormats = $this->InternalAuditPlanDepartment->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0)));
        $this->set(compact('internalAuditPlans', 'branches', 'departments', 'employees', 'listOfTrainedInternalAuditors', 'systemTables', 'masterListOfFormats'));
        $count = $this->InternalAuditPlanDepartment->find('count');
        $published = $this->InternalAuditPlanDepartment->find('count', array('conditions' => array('InternalAuditPlanDepartment.publish' => 1)));
        $unpublished = $this->InternalAuditPlanDepartment->find('count', array('conditions' => array('InternalAuditPlanDepartment.publish' => 0)));

        $this->set(compact('count', 'published', 'unpublished'));
    }

    public function edit_popup($id = null) {
        if (!$this->InternalAuditPlanDepartment->exists($id)) {
            throw new NotFoundException(__('Invalid internal audit plan department'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['InternalAuditPlanDepartment']['system_table_id'] = $this->_get_system_table_id();
            if ($this->InternalAuditPlanDepartment->save($this->request->data)) {

                $this->Session->setFlash(__('The internal audit plan department has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('controller' => 'internal_audit_plans', 'action' => 'lists', $this->request->data['InternalAuditPlanDepartment']['internal_audit_plan_id']));
                else
                    $this->redirect(array('controller' => 'internal_audit_plans', 'action' => 'lists', $this->request->data['InternalAuditPlanDepartment']['internal_audit_plan_id']));
            } else {
                $this->Session->setFlash(__('The internal audit plan department could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('InternalAuditPlanDepartment.' . $this->InternalAuditPlanDepartment->primaryKey => $id));
            $this->request->data = $this->InternalAuditPlanDepartment->find('first', $options);
        }
        $internalAuditPlans = $this->InternalAuditPlanDepartment->InternalAuditPlan->find('list', array('conditions' => array('InternalAuditPlan.publish' => 1, 'InternalAuditPlan.soft_delete' => 0)));
        $departments = $this->InternalAuditPlanDepartment->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0)));
        $branches = $this->InternalAuditPlanDepartment->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $employees = $this->InternalAuditPlanDepartment->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $listOfTrainedInternalAuditors = $this->InternalAuditPlanDepartment->ListOfTrainedInternalAuditor->find('list', array('fields' => array('ListOfTrainedInternalAuditor.id', 'Employee.name'), 'conditions' => array('ListOfTrainedInternalAuditor.publish' => 1, 'ListOfTrainedInternalAuditor.soft_delete' => 0), recursive => 0));
        $systemTables = $this->InternalAuditPlanDepartment->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $masterListOfFormats = $this->InternalAuditPlanDepartment->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0)));
        $this->set(compact('internalAuditPlans', 'departments', 'branches', 'employees', 'listOfTrainedInternalAuditors', 'systemTables', 'masterListOfFormats'));
        $count = $this->InternalAuditPlanDepartment->find('count');
        $published = $this->InternalAuditPlanDepartment->find('count', array('conditions' => array('InternalAuditPlanDepartment.publish' => 1)));
        $unpublished = $this->InternalAuditPlanDepartment->find('count', array('conditions' => array('InternalAuditPlanDepartment.publish' => 0)));
        $this->set(compact('count', 'published', 'unpublished'));
    }

}
