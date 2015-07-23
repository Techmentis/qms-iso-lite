<?php

App::uses('AppController', 'Controller');

/**
 * ListOfSoftwares Controller
 *
 * @property ListOfSoftware $ListOfSoftware
 */
class ListOfSoftwaresController extends AppController {

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
        $this->paginate = array('order' => array('ListOfSoftware.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->ListOfSoftware->recursive = 0;
        $this->set('listOfSoftwares', $this->paginate());

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
                        $searchArray[] = array('ListOfSoftware.' . $search => $searchKey);
                    else
                        $searchArray[] = array('ListOfSoftware.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('ListOfSoftware.branchid' => $branches);
            endforeach;
            $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['employee_id'] != -1) {
            $employeeConditions[] = array('ListOfSoftware.employee_id' => $this->request->query['employee_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $employeeConditions);
            else
                $conditions[] = array('or' => $employeeConditions);
        }
        if ($this->request->query['software_type_id'] != -1) {
            $softwareTypeConditions[] = array('ListOfSoftware.software_type_id' => $this->request->query['software_type_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $softwareTypeConditions);
            else
                $conditions[] = array('or' => $softwareTypeConditions);
        }
        if ($this->request->query['backup_required'] != '') {
            $backupRequiredConditions[] = array('ListOfSoftware.backup_required' => $this->request->query['backup_required']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $backupRequiredConditions);
            else
                $conditions[] = array('or' => $backupRequiredConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('ListOfSoftware.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'ListOfSoftware.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);

        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('ListOfSoftware.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('ListOfSoftware.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->ListOfSoftware->recursive = 0;
        $this->paginate = array('order' => array('ListOfSoftware.sr_no' => 'DESC'), 'conditions' => $conditions, 'ListOfSoftware.soft_delete' => 0);
        $this->set('listOfSoftwares', $this->paginate());

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
        if (!$this->ListOfSoftware->exists($id)) {
            throw new NotFoundException(__('Invalid list of software'));
        }
        $options = array('conditions' => array('ListOfSoftware.' . $this->ListOfSoftware->primaryKey => $id));
        $this->set('listOfSoftware', $this->ListOfSoftware->find('first', $options));
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
            $this->request->data['ListOfSoftware']['system_table_id'] = $this->_get_system_table_id();
            $this->ListOfSoftware->create();
            if ($this->ListOfSoftware->save($this->request->data)) {

                $this->Session->setFlash(__('The list of software has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->ListOfSoftware->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The list of software could not be saved. Please, try again.'));
            }
        }
        $softwareTypes = $this->ListOfSoftware->SoftwareType->find('list', array('conditions' => array('SoftwareType.publish' => 1, 'SoftwareType.soft_delete' => 0)));
        $schedules = $this->ListOfSoftware->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));
        $this->set(compact('softwareTypes', 'schedules'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->ListOfSoftware->exists($id)) {
            throw new NotFoundException(__('Invalid list of software'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['ListOfSoftware']['system_table_id'] = $this->_get_system_table_id();
            if ($this->ListOfSoftware->save($this->request->data)) {

                $this->Session->setFlash(__('The list of software has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The list of software could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ListOfSoftware.' . $this->ListOfSoftware->primaryKey => $id));
            $this->request->data = $this->ListOfSoftware->find('first', $options);
        }
        $softwareTypes = $this->ListOfSoftware->SoftwareType->find('list', array('conditions' => array('SoftwareType.publish' => 1, 'SoftwareType.soft_delete' => 0)));
        $schedules = $this->ListOfSoftware->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));
        $this->set(compact('softwareTypes','schedules'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->ListOfSoftware->exists($id)) {
            throw new NotFoundException(__('Invalid list of software'));
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
            $this->request->data['ListOfSoftware']['system_table_id'] = $this->_get_system_table_id();
            if ($this->ListOfSoftware->save($this->request->data)) {

                $this->Session->setFlash(__('The list of software has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The list of software could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ListOfSoftware.' . $this->ListOfSoftware->primaryKey => $id));
            $this->request->data = $this->ListOfSoftware->find('first', $options);
        }
        $softwareTypes = $this->ListOfSoftware->SoftwareType->find('list', array('conditions' => array('SoftwareType.publish' => 1, 'SoftwareType.soft_delete' => 0)));
        $schedules = $this->ListOfSoftware->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));
        $this->set(compact('softwareTypes', 'schedules'));
    }
}
