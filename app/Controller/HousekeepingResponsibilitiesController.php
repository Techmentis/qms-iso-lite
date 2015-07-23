<?php

App::uses('AppController', 'Controller');

/**
 * HousekeepingResponsibilities Controller
 *
 * @property HousekeepingResponsibility $HousekeepingResponsibility
 */
class HousekeepingResponsibilitiesController extends AppController {

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
        $this->paginate = array('order' => array('HousekeepingResponsibility.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->HousekeepingResponsibility->recursive = 0;
        $this->set('housekeepingResponsibilities', $this->paginate());

        $this->_get_count();
    }

    /**
     * adcanced_search method
     * Advanced search by Mayuresh Vaidya - TECHMENTIS GLOBAL SERVICES PVT LTD
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
                        $searchArray[] = array('HousekeepingResponsibility.' . $search => $searchKey);
                    else
                        $searchArray[] = array('HousekeepingResponsibility.' . $search . ' like ' => '%' . $searchKey. '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['housekeeping_checklist']) {
            foreach ($this->request->query['housekeeping_checklist'] as $housekeepingChecklist):
                $housekeepingChecklistCondition[] = array('HousekeepingResponsibility.housekeeping_checklist_id' => $housekeepingChecklist);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('or' => $housekeepingChecklistCondition));
            else
                $conditions[] = array('or' => $housekeepingChecklistCondition);
        }
        if ($this->request->query['employee_id']) {
            foreach ($this->request->query['employee_id'] as $employeeId):
                $employeeConditions[] = array('HousekeepingResponsibility.employee_id' => $employeeId);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('or' => $employeeConditions));
            else
                $conditions[] = array('or' => $employeeConditions);
        }
        if ($this->request->query['schedule_id'] != -1) {
            $scheduleConditions = array('HousekeepingResponsibility.schedule_id' => $this->request->query['schedule_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('or' => $scheduleConditions));
            else
                $conditions[] = array('or' => $scheduleConditions);
        }
        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('HousekeepingResponsibility.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('or' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);;
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('HousekeepingResponsibility.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'HousekeepingResponsibility.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('HousekeepingResponsibility.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('HousekeepingResponsibility.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->HousekeepingResponsibility->recursive = 0;
        $this->paginate = array('order' => array('HousekeepingResponsibility.sr_no' => 'DESC'), 'conditions' => $conditions, 'HousekeepingResponsibility.soft_delete' => 0);
        $this->set('housekeepingResponsibilities', $this->paginate());

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
        if (!$this->HousekeepingResponsibility->exists($id)) {
            throw new NotFoundException(__('Invalid housekeeping responsibility'));
        }
        $options = array('conditions' => array('HousekeepingResponsibility.' . $this->HousekeepingResponsibility->primaryKey => $id));
        $this->set('housekeepingResponsibility', $this->HousekeepingResponsibility->find('first', $options));
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
            $this->request->data['HousekeepingResponsibility']['system_table_id'] = $this->_get_system_table_id();
            $this->HousekeepingResponsibility->create();
            if ($this->HousekeepingResponsibility->save($this->request->data,false)) {

                $this->Session->setFlash(__('The housekeeping responsibility has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->HousekeepingResponsibility->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The housekeeping responsibility could not be saved. Please, try again.'));
            }
        }
        $housekeepingChecklists = $this->HousekeepingResponsibility->HousekeepingChecklist->find('list', array('conditions' => array('HousekeepingChecklist.publish' => 1, 'HousekeepingChecklist.soft_delete' => 0)));
        $schedules = $this->HousekeepingResponsibility->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));
        $this->set(compact('housekeepingChecklists','schedules'));
     }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->HousekeepingResponsibility->exists($id)) {
            throw new NotFoundException(__('Invalid housekeeping responsibility'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['HousekeepingResponsibility']['system_table_id'] = $this->_get_system_table_id();
            if ($this->HousekeepingResponsibility->save($this->request->data,false)) {

                $this->Session->setFlash(__('The housekeeping responsibility has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The housekeeping responsibility could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('HousekeepingResponsibility.' . $this->HousekeepingResponsibility->primaryKey => $id));
            $this->request->data = $this->HousekeepingResponsibility->find('first', $options);
        }
        $housekeepingChecklists = $this->HousekeepingResponsibility->HousekeepingChecklist->find('list', array('conditions' => array('HousekeepingChecklist.publish' => 1, 'HousekeepingChecklist.soft_delete' => 0)));
        $employees = $this->HousekeepingResponsibility->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $schedules = $this->HousekeepingResponsibility->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));
        $this->set(compact('housekeepingChecklists', 'employees', 'schedules'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->HousekeepingResponsibility->exists($id)) {
            throw new NotFoundException(__('Invalid housekeeping responsibility'));
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
            $this->request->data['HousekeepingResponsibility']['system_table_id'] = $this->_get_system_table_id();
            if ($this->HousekeepingResponsibility->save($this->request->data,false)) {

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The housekeeping responsibility could not be Approved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('HousekeepingResponsibility.' . $this->HousekeepingResponsibility->primaryKey => $id));
            $this->request->data = $this->HousekeepingResponsibility->find('first', $options);
        }
        $housekeepingChecklists = $this->HousekeepingResponsibility->HousekeepingChecklist->find('list', array('conditions' => array('HousekeepingChecklist.publish' => 1, 'HousekeepingChecklist.soft_delete' => 0)));
        $employees = $this->HousekeepingResponsibility->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $schedules = $this->HousekeepingResponsibility->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));
        $this->set(compact('housekeepingChecklists', 'employees', 'schedules'));
     }

}
