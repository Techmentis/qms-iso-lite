<?php

App::uses('AppController', 'Controller');

/**
 * DataBackUps Controller
 *
 * @property DataBackUp $DataBackUp
 */
class DataBackUpsController extends AppController {

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
        $this->paginate = array('order' => array('DataBackUp.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->DataBackUp->recursive = 0;
        $this->set('dataBackUps', $this->paginate());

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
                        $searchArray[] = array('DataBackUp.' . $search => $searchKey);
                    else
                        $searchArray[] = array('DataBackUp.' . $search . ' like ' => '%' . $search_key . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('DataBackUp.branch_id' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['data_type_id']) {
            foreach ($this->request->query['data_type_id'] as $dataType):
                $dataTypeConditions[] = array('DataBackUp.data_type_id' => $dataType);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $dataTypeConditions));
            else
                $conditions[] = array('or' => $dataTypeConditions);
        }
        if ($this->request->query['schedule_id']) {
            foreach ($this->request->query['schedule_id'] as $schedule):
                $scheduleConditions[] = array('DataBackUp.schedule_id' => $schedule);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $scheduleConditions));
            else
                $conditions[] = array('or' => $scheduleConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('DataBackUp.created >' => date('Y-m-d h:i:s', strtotime($this->request->data['Search']['from-date'])), 'DataBackUp.created <' => date('Y-m-d h:i:s', strtotime($this->request->data['Search']['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('DataBackUp.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('DataBackUp.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->DataBackUp->recursive = 0;
        $this->paginate = array('order' => array('DataBackUp.sr_no' => 'DESC'), 'conditions' => $conditions, 'DataBackUp.soft_delete' => 0);
        $this->set('dataBackUps', $this->paginate());

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
        if (!$this->DataBackUp->exists($id)) {
            throw new NotFoundException(__('Invalid data back up'));
        }
        $options = array('conditions' => array('DataBackUp.' . $this->DataBackUp->primaryKey => $id));
        $this->set('dataBackUp', $this->DataBackUp->find('first', $options));
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
    public function add_ajax($redirect = null) {
        $conditions = $this->_check_request();
        $this->paginate = array('limit' => 5,'order' => array('DataBackUp.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->DataBackUp->recursive = 0;
        $this->set('dataBackUps', $this->paginate());
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }

        if ($this->request->is('post')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['DataBackUp']['system_table_id'] = $this->_get_system_table_id();
            $this->DataBackUp->create();

            if ($this->DataBackUp->save($this->request->data,false)) {
                $this->Session->setFlash(__('The data back up has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

//                if ($this->_show_evidence() == true)
//                    $this->redirect(array('action' => 'view', $this->DataBackUp->id));
//                else
//                    $this->redirect(array('action' => 'index'));
                $redirect = $this->request->data['DataBackUp']['redirect'];
                if ($redirect != '') {
                    unset($this->request->data['DataBackUp']);
                    unset($this->request->data['Approval']);
                } else {
                    if ($this->_show_evidence() == true) {
                        if (isset($this->request->data['DataBackUp']['redirect']) && $this->request->data['DataBackUp']['redirect'] != '') {
                            $this->redirect(array('controller' => $this->request->data['DataBackUp']['redirect'], 'action' => 'lists'));
                        } else {
                            $this->redirect(array('action' => 'view', $this->CourseType->id));
                        }
                    } else {
                        if (isset($this->request->data['DataBackUp']['redirect']) && $this->request->data['DataBackUp']['redirect'] != '') {
                            $this->redirect(array('controller' => $this->request->data['DataBackUp']['redirect'], 'action' => 'lists'));
                        } else {
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }

            } else {
                $this->Session->setFlash(__('The data back up could not be saved. Please, try again.'));
            }
        }
        $uiTabId = $this->request->data['DataBackUp']['tabId'];
        $dataTypes = $this->DataBackUp->DataType->find('list', array('conditions' => array('DataType.publish' => 1, 'DataType.soft_delete' => 0)));
        $branches = $this->DataBackUp->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $schedules = $this->DataBackUp->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));
        $users = $this->DataBackUp->User->find('list', array('conditions' => array('User.publish' => 1, 'User.soft_delete' => 0)));
        $this->set(compact('dataTypes', 'branches', 'schedules', 'users','redirect','uiTabId'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->DataBackUp->exists($id)) {
            throw new NotFoundException(__('Invalid data back up'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['DataBackUp']['system_table_id'] = $this->_get_system_table_id();
            if ($this->DataBackUp->save($this->request->data)) {
                $this->Session->setFlash(__('The data back up has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The data back up could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('DataBackUp.' . $this->DataBackUp->primaryKey => $id));
            $this->request->data = $this->DataBackUp->find('first', $options);
        }
        $dataTypes = $this->DataBackUp->DataType->find('list', array('conditions' => array('DataType.publish' => 1, 'DataType.soft_delete' => 0)));
        $branches = $this->DataBackUp->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $schedules = $this->DataBackUp->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));
        $users = $this->DataBackUp->User->find('list', array('conditions' => array('User.publish' => 1, 'User.soft_delete' => 0)));
        $this->set(compact('dataTypes', 'branches', 'schedules', 'users'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {

        if (!$this->DataBackUp->exists($id)) {
            throw new NotFoundException(__('Invalid data back up'));
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
            if ($this->DataBackUp->save($this->request->data)) {
                $this->Session->setFlash(__('The data back up has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The data back up could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('DataBackUp.' . $this->DataBackUp->primaryKey => $id));
            $this->request->data = $this->DataBackUp->find('first', $options);
        }

        $dataTypes = $this->DataBackUp->DataType->find('list', array('conditions' => array('DataType.publish' => 1, 'DataType.soft_delete' => 0)));
        $branches = $this->DataBackUp->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $schedules = $this->DataBackUp->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));
        $users = $this->DataBackUp->User->find('list', array('conditions' => array('User.publish' => 1, 'User.soft_delete' => 0)));
        $this->set(compact('dataTypes', 'branches', 'schedules', 'users', 'backup_name', 'backup_branch'));
    }

}
