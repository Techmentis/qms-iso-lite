<?php

App::uses('AppController', 'Controller');

/**
 * CustomerMeetings Controller
 *
 * @property CustomerMeeting $CustomerMeeting
 */
class CustomerMeetingsController extends AppController {

    public function _get_system_table_id() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $this->request->params['controller'])));
        return $systemTableId['SystemTable']['id'];
    }

    public function _get_count() {

        $onlyBranch = null;
        $onlyOwn = null;
        $conditions = null;
        $count = $published = $unpublished = $deleted = 0;
        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('CustomerMeeting.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('CustomerMeeting.created_by' => $this->Session->read('User.id'));
        $conditions = array($onlyBranch, $onlyOwn);

        $count = $this->CustomerMeeting->find('count', array('conditions' => $conditions, 'group' => 'CustomerMeeting.followup_id'));
        $published = $this->CustomerMeeting->find('count', array('conditions' => array($conditions, 'CustomerMeeting.publish' => 1, 'CustomerMeeting.soft_delete' => 0), 'group' => 'CustomerMeeting.followup_id'));
        $unpublished = $this->CustomerMeeting->find('count', array('conditions' => array($conditions, 'CustomerMeeting.publish' => 0, 'CustomerMeeting.soft_delete' => 0), 'group' => 'CustomerMeeting.followup_id'));
        $deleted = $this->CustomerMeeting->find('count', array('conditions' => array($conditions, 'CustomerMeeting.soft_delete' => 1), 'group' => 'CustomerMeeting.followup_id'));
        $this->set(compact('count', 'published', 'unpublished', 'deleted'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function followup_count($id) {
        $followupCount = $this->CustomerMeeting->find('count', array('conditions' => array('CustomerMeeting.followup_id' => $id, 'CustomerMeeting.id !=' => $id, 'CustomerMeeting.publish' => 1, 'CustomerMeeting.soft_delete' => 0)));
        return $followupCount;
    }

    public function index() {

        $conditions = $this->_check_request();
        $this->paginate = array('order' => array('CustomerMeeting.sr_no' => 'DESC'), 'group' => 'CustomerMeeting.followup_id', 'conditions' => array($conditions));

        $this->CustomerMeeting->recursive = 0;
        $this->set('customerMeetings', $this->paginate());
        $this->set('followupid', $this->CustomerMeeting->id);
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
                        $searchArray[] = array('CustomerMeeting.' . $search => $searchKey);
                    else
                        $searchArray[] = array('CustomerMeeting.' . $search . ' like ' => '%' . $searchKey . '%');
                endforeach;
            endforeach;

            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }
        if ($this->request->query['status'] != -1) {
            $statusConditions = array('CustomerMeeting.status' => $this->request->query['status']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $statusConditions);
            else
                $conditions[] = array('or' => $statusConditions);
        }

        if ($this->request->query['meeting_date'] != '') {
            $MeetingDateConditions = array('CustomerMeeting.meeting_date' => $this->request->query['meeting_date']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $MeetingDateConditions);
            else
                $conditions[] = array('or' => $MeetingDateConditions);
        }

        if ($this->request->query['next_meeting_date'] != '') {
            $nextMeetingDateConditions = array('CustomerMeeting.next_meeting_date' => $this->request->query['next_meeting_date']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $nextMeetingDateConditions);
            else
                $conditions[] = array('or' => $nextMeetingDateConditions);
        }
        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('CustomerMeeting.branchid' => $branches);
            endforeach;

            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }

        if ($this->request->query['customer_id'] != -1) {
            $customerConditions = array('CustomerMeeting.customer_id' => $this->request->query['customer_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $customerConditions);
            else
                $conditions[] = array('or' => $customerConditions);
        }

        if ($this->request->query['employee_id'] != -1) {
            $employeeConditions = array('CustomerMeeting.employee_id' => $this->request->query['employee_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $employeeConditions);
            else
                $conditions[] = array('or' => $employeeConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('CustomerMeeting.created >=' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'CustomerMeeting.created <=' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
        unset($this->request->query);

        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('CustomerMeeting.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('CustomerMeeting.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->CustomerMeeting->recursive = 0;
        $this->paginate = array('order' => array('CustomerMeeting.sr_no' => 'DESC'), 'group' => 'CustomerMeeting.followup_id','conditions' => $conditions, 'CustomerMeeting.soft_delete' => 0);
        $this->set('customerMeetings', $this->paginate());
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
        if (!$this->CustomerMeeting->exists($id)) {
            throw new NotFoundException(__('Invalid customer meeting'));
        }
        $options = array('conditions' => array('CustomerMeeting.' . $this->CustomerMeeting->primaryKey => $id));
        $followup = $this->CustomerMeeting->find('all', array('conditions' => array('CustomerMeeting.followup_id' => $id, 'CustomerMeeting.id !=' => $id)));
        $this->set('customerMeeting', $this->CustomerMeeting->find('first', $options));
        $this->set('followups', $followup);
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
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['CustomerMeeting']['system_table_id'] = $this->_get_system_table_id();
            $this->CustomerMeeting->create();

            if ($this->CustomerMeeting->save($this->request->data)) {
                $this->CustomerMeeting->id = $this->CustomerMeeting->id;
                $this->CustomerMeeting->saveField('followup_id', $this->CustomerMeeting->id);
                $this->Session->setFlash(__('The customer meeting has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->CustomerMeeting->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The customer meeting could not be saved. Please, try again.'));
            }
        }
        $customers = $this->CustomerMeeting->Customer->find('list', array('conditions' => array('Customer.publish' => 1, 'Customer.soft_delete' => 0)));
        $this->set(compact('customers'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function add_followups($followupId) {

        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['CustomerMeeting']['system_table_id'] = $this->_get_system_table_id();
            if ($this->CustomerMeeting->save($this->request->data)) {
                $this->Session->setFlash(__('The Follow up has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The customer meeting could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CustomerMeeting.id' => $followupId), 'fields' => array('CustomerMeeting.id', 'CustomerMeeting.customer_id', 'CustomerMeeting.followup_id'));
            $this->request->data = $this->CustomerMeeting->find('first', $options);
        }
        $customers = $this->CustomerMeeting->Customer->find('list', array('conditions' => array('Customer.publish' => 1, 'Customer.soft_delete' => 0)));
        $this->set(compact('customers'));
        $this->set('followupId', $followupId);
    }

    public function edit($id = null) {
        if (!$this->CustomerMeeting->exists($id)) {
            throw new NotFoundException(__('Invalid customer meeting'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['CustomerMeeting']['system_table_id'] = $this->_get_system_table_id();
            if ($this->CustomerMeeting->save($this->request->data)) {
                $this->Session->setFlash(__('The customer meeting has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The customer meeting could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CustomerMeeting.' . $this->CustomerMeeting->primaryKey => $id));
            $this->request->data = $this->CustomerMeeting->find('first', $options);
            $followupCount = $this->CustomerMeeting->find('count', array('conditions' => array('CustomerMeeting.followup_id'=> $id)));
        }
        $customers = $this->CustomerMeeting->Customer->find('list', array('conditions' => array('Customer.publish' => 1, 'Customer.soft_delete' => 0)));
        $this->set(compact('customers', 'followupCount'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->CustomerMeeting->exists($id)) {
            throw new NotFoundException(__('Invalid customer meeting'));
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
            if ($this->CustomerMeeting->save($this->request->data)) {
                $this->Session->setFlash(__('The customer meeting has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals();

            } else {
                $this->Session->setFlash(__('The customer meeting could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CustomerMeeting.' . $this->CustomerMeeting->primaryKey => $id));
            $this->request->data = $this->CustomerMeeting->find('first', $options);
        }
        $customers = $this->CustomerMeeting->Customer->find('list', array('conditions' => array('Customer.publish' => 1, 'Customer.soft_delete' => 0)));
        $this->set(compact('customers'));
    }

    public function purge($id = null) {
        if (!empty($id)) {
            $this->loadModel('Approval');
            $options = array('conditions' => array('CustomerMeeting.id' => $id));
            $customerMeeting = $this->CustomerMeeting->find('first', $options);
            $customerFollowups = $this->CustomerMeeting->find('all', array('conditions' => array('CustomerMeeting.followup_id' => $customerMeeting['CustomerMeeting']['followup_id'])));
            $approve = $this->Approval->find('all');
            foreach ($customerFollowups as $data) {
                $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $data['CustomerMeeting']['id'], 'Approval.model_name' => 'CustomerMeeting')));
                foreach ($approves as $approve) {
                    if (!($this->Approval->delete($approve['Approval']['id'], true))) {
                        $this->Session->setFlash(__('All selected value was not deleted from Approve'));
                        $this->redirect(array('action' => 'index'));
                    }
                }
                if (!$this->CustomerMeeting->delete($data['CustomerMeeting']['id'], true)) {
                    $this->Session->setFlash(__('All selected value was not deleted'));
                    $this->redirect(array('action' => 'index'));
                }
            }
        }

        $this->redirect(array('action' => 'index'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $modelName = $this->modelClass;
        if (!empty($id)) {
            $options = array('conditions' => array('CustomerMeeting.id' => $id));
            $customerMeeting = $this->CustomerMeeting->find('first', $options);
            $customerFollowups = $this->CustomerMeeting->find('all', array('conditions' => array('CustomerMeeting.followup_id' => $customerMeeting['CustomerMeeting']['followup_id'])));
            $this->loadModel('Approval');
            foreach ($customerFollowups as $data) {
                $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $data['CustomerMeeting']['id'], 'Approval.model_name' => 'CustomerMeeting')));
                foreach ($approves as $approve) {
                    $approve['Approval']['soft_delete'] = 1;
                    $this->Approval->save($approve, false);
                }
                $data['CustomerMeeting']['soft_delete'] = 1;
                $this->CustomerMeeting->save($data, false);
            }
        }
        $this->redirect(array(
            'action' => 'index'
        ));
    }

    public function delete_all($id = null) {
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);
        $modelName = $this->modelClass;
        if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $options = array('conditions' => array('CustomerMeeting.id' => $id));
                    $customerMeeting = $this->CustomerMeeting->find('first', $options);
                    $customerFollowups = $this->CustomerMeeting->find('all', array('conditions' => array('CustomerMeeting.followup_id' => $customerMeeting['CustomerMeeting']['followup_id'])));
                    $this->loadModel('Approval');
                    foreach ($customerFollowups as $data) {
                        $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $data['CustomerMeeting']['id'], 'Approval.model_name' => 'CustomerMeeting')));
                        foreach ($approves as $approve) {
                            $approve['Approval']['soft_delete'] = 1;
                            $this->Approval->save($approve, false);
                        }
                        $data['CustomerMeeting']['soft_delete'] = 1;
                        $this->CustomerMeeting->save($data, false);
                    }
                }
            }
        }
        $this->redirect(array('action' => 'index'));
    }

    public function restore($id = null) {
        $modelName = $this->modelClass;
        if (!empty($id)) {
            $options = array('conditions' => array('CustomerMeeting.id' => $id));
            $customerMeeting = $this->CustomerMeeting->find('first', $options);
            $customerFollowups = $this->CustomerMeeting->find('all', array('conditions' => array('CustomerMeeting.followup_id' => $customerMeeting['CustomerMeeting']['followup_id'])));
            $this->loadModel('Approval');
            foreach ($customerFollowups as $data) {
                $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $data['CustomerMeeting']['id'], 'Approval.model_name' => 'CustomerMeeting')));
                foreach ($approves as $approve) {
                    $approve['Approval']['soft_delete'] = 0;
                    $this->Approval->save($approve, false);
                }
                $data['CustomerMeeting']['soft_delete'] = 0;
                $this->CustomerMeeting->save($data, false);
            }
        }
        $this->redirect(array('action' => 'index'));
    }

    public function restore_all($ids = null) {
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);
        $modelName = $this->modelClass;
        if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $options = array('conditions' => array('CustomerMeeting.id' => $id));
                    $customerMeeting = $this->CustomerMeeting->find('first', $options);
                    $customerFollowups = $this->CustomerMeeting->find('all', array('conditions' => array('CustomerMeeting.followup_id' => $customerMeeting['CustomerMeeting']['followup_id'])));
                    $this->loadModel('Approval');
                    foreach ($customerFollowups as $data) {
                        $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $data['CustomerMeeting']['id'], 'Approval.model_name' => 'CustomerMeeting')));
                        foreach ($approves as $approve) {
                            $approve['Approval']['soft_delete'] = 0;
                            $this->Approval->save($approve, false);
                        }
                        $data['CustomerMeeting']['soft_delete'] = 0;
                        $this->CustomerMeeting->save($data, false);
                    }
                }
            }
        }

        $this->Session->setFlash(__('All selected value restored'));
        $this->redirect(array(
            'action' => 'index'
        ));
    }

    public function purge_all($ids = null) {
        $flag = 0;
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);
        $modelName = $this->modelClass;
        if (!empty($ids)) {
            $this->loadModel('Approval');
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $options = array('conditions' => array('CustomerMeeting.id' => $id));
                    $customerMeeting = $this->CustomerMeeting->find('first', $options);
                    $customerFollowups = $this->CustomerMeeting->find('all', array('conditions' => array('CustomerMeeting.followup_id' => $customerMeeting['CustomerMeeting']['followup_id'])));
                    foreach ($customerFollowups as $data) {
                        $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $data['CustomerMeeting']['id'], 'Approval.model_name' => 'CustomerMeeting')));
                        foreach ($approves as $approve) {
                            if ($this->Approval->delete($approve['Approval']['id'], true)) {
                                $flag = 1;
                            } else {
                                $flag = 0;
                                $this->Session->setFlash(__('All selected value was not deleted from approve'));
                                $this->redirect(array('action' => 'index'));
                            }
                        }
                        if ($this->CustomerMeeting->delete($data['CustomerMeeting']['id'], true)) {
                            $flag = 1;
                        } else {
                            $flag = 0;
                            $this->Session->setFlash(__('All selected value was not deleted'));
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }
            }
            if ($flag) {
                $this->Session->setFlash(__('All selected values deleted'));
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    public function publish_record($id = null) {
        if (!empty($id)) {
            $options = array('conditions' => array('CustomerMeeting.id' => $id));
            $customerMeeting = $this->CustomerMeeting->find('first', $options);
            $customerFollowups = $this->CustomerMeeting->find('all', array('conditions' => array('CustomerMeeting.followup_id' => $customerMeeting['CustomerMeeting']['followup_id'])));
            $this->loadModel('Approval');
            foreach ($customerFollowups as $data) {
                $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $data['CustomerFeedback']['id'], 'Approval.model_name' => 'CustomerFeedback')));
                foreach ($approves as $approve) {
                    $approve['Approval']['status'] = 'Approved';
                    $this->Approval->save($approve, false);
                }
                $data['CustomerMeeting']['publish'] = 1;
                $this->CustomerMeeting->save($data, false);
            }
        }

        $this->redirect(array('action' => 'index'));
    }

}
