<?php

App::uses('AppController', 'Controller');

/**
 * Notifications Controller
 *
 * @property Notification $Notification
 */
class NotificationsController extends AppController {

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
        $this->paginate = array('order' => array('Notification.sr_no' => 'DESC'), 'conditions' => array($conditions),
            'joins' => array(array(
                    'table' => 'notification_users',
                    'alias' => 'notification_users',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('notification_users.notification_id = Notification.id'))),
            'group' => '`Notification`.`id`');

        $this->Notification->recursive = 0;
        $notifications = $this->paginate();
        foreach ($notifications as $key => $notification) {
            $notificationUsers = $this->Notification->NotificationUser->find('all', array('conditions' => array('NotificationUser.notification_id' => $notification['Notification']['id'], 'NotificationUser.soft_delete' => 0), 'fields' => array('Employee.name', 'NotificationUser.employee_id', 'NotificationUser.status'),
                'order' => array('Employee.name' => 'DESC'),
            ));
            $employees = array();
            foreach ($notificationUsers as $notificationUser) {
                $employees[] = $notificationUser['Employee']['name'];
                if ($notificationUser['NotificationUser']['employee_id'] == $this->Session->read('User.employee_id')) {
                    $notifications[$key]['Notification']['status'] = $notificationUser['NotificationUser']['status'];
                }
            }

            $notifications[$key]['Notification']['NotificationUser'] = implode(', ', $employees);
        }
        $this->set('notifications', $notifications);

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
                        $searchArray[] = array('Notification.' . $search => $searchKey);
                    else
                        $searchArray[] = array('Notification.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('Notification.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['notification_type_id'] != -1) {
            $notificationConditions = array('Notification.notification_type_id' => $this->request->query['notification_type_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $notificationConditions);
            else
                $conditions[] = array('or' => $notificationConditions);
        }
        if ($this->request->query['prepared_by'] != -1) {
            $preparedByConditions = array('Notification.prepared_by' => $this->request->query['prepared_by']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $preparedByConditions);
            else
                $conditions[] = array('or' => $preparedByConditions);
        }
        if ($this->request->query['approved_by'] != -1) {
            $approvedByConditions = array('Notification.approved_by' => $this->request->query['approved_by']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $approvedByConditions);
            else
                $conditions[] = array('or' => $approvedByConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('Notification.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'Notification.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
        unset($this->request->query);
        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('Notification.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Or' => array('Notification.created_by' => $this->Session->read('User.id'), 'notification_users.employee_id' => $this->Session->read('User.employee_id')));
        $result = $this->Notification->find('all', array('conditions' => $conditions));
        $conditions[] = array($onlyBranch, $onlyOwn, array('Notification.soft_delete' => 0));
        $this->Notification->recursive = 0;
        $this->paginate = array('order' => array('Notification.sr_no' => 'DESC'), 'conditions' => $conditions, 'joins' => array(array(
                    'table' => 'notification_users',
                    'alias' => 'notification_users',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('notification_users.notification_id = Notification.id'))),
            'group' => '`Notification`.`id`');

        $notifications = $this->paginate();

        foreach ($notifications as $key => $notification) {
            $notificationUsers = $this->Notification->NotificationUser->find('all', array('conditions' => array('NotificationUser.notification_id' => $notification['Notification']['id'], 'NotificationUser.soft_delete' => 0), 'fields' => 'Employee.name',
                'order' => array('Employee.name' => 'DESC')));
            $employees = array();
            foreach ($notificationUsers as $notificationUser)
                $employees[] = $notificationUser['Employee']['name'];
            $notifications[$key]['Notification']['NotificationUser'] = implode(', ', $employees);
        }
        $this->set('notifications', $notifications);

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
        $this->loadModel('NotificationUser');
        if (!$this->Notification->exists($id)) {
            throw new NotFoundException(__('Invalid notification'));
        }


        $options = array('conditions' => array('Notification.' . $this->Notification->primaryKey => $id));
        $notification = $this->Notification->find('first', $options);
        $this->set('notification', $notification);

        // From Unread to Read Status
        $status = $this->NotificationUser->find('first', array('conditions' => array('NotificationUser.notification_id' => $id, 'NotificationUser.employee_id' => $this->Session->read('User.employee_id'))));


        if ($status) {
            $status['NotificationUser']['status'] = 1;
            $this->NotificationUser->save($status['NotificationUser']);
        }
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
            $i = sizeof($this->request->data['NotificationUser_employee_id']);
            $this->request->data['Notification']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['Notification']['created_by'] = $this->Session->read('User.id');
            $this->request->data['Notification']['modified_by'] = $this->Session->read('User.id');
            $this->Notification->create();
            if ($this->Notification->save($this->request->data, false)) {

                $this->loadModel('NotificationUser');
                $this->loadModel('User');
                $MrEmployees = $this->User->find('all',array('conditions'=>array('User.is_mr'=>1),'fields'=>'User.employee_id'));
                foreach($MrEmployees as $MrEmployee){
                    $this->request->data['NotificationUser_employee_id'][$i++] = $MrEmployee['User']['employee_id'];
                }
                $this->request->data['NotificationUser_employee_id'][$i++] = $this->Session->read('User.id');
                $this->request->data['NotificationUser_employee_id'] = array_unique($this->request->data['NotificationUser_employee_id']);
                foreach ($this->request->data['NotificationUser_employee_id'] as $key=>$value) {
                    $this->NotificationUser->create();
                    $val = array();
                    $val['notification_id'] = $this->Notification->id;
                    $val['employee_id'] = $value;
                    $val['status'] = 0;
                    $val['publish'] = 1;
                    $val['branchid'] = $this->request->data['Notification']['branchid'];
                    $val['departmentid'] = $this->request->data['Notification']['departmentid'];
                    $val['created_by'] = $this->Session->read('User.id');
                    $val['modified_by'] = $this->Session->read('User.id');
                    $val['system_table_id'] = $this->_get_system_table_id();
                    $this->NotificationUser->save($val, false);
                }

                $this->Session->setFlash(__('The notification has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->Notification->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The notification could not be saved. Please, try again.'));
            }
        }
        $notificationTypes = $this->Notification->NotificationType->find('list', array('conditions' => array('NotificationType.publish' => 1, 'NotificationType.soft_delete' => 0)));
        $this->set(compact('notificationTypes'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Notification->exists($id)) {
            throw new NotFoundException(__('Invalid notification'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $i = sizeof($this->request->data['NotificationUser_employee_id']);
            $this->request->data['Notification']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['Notification']['modified_by'] = $this->Session->read('User.id');
            if ($this->Notification->save($this->request->data)) {

                $this->loadModel('NotificationUser');
                $this->NotificationUser->deleteAll(array('notification_id' => $this->request->data['Notification']['id']), false);
                $this->loadModel('User');
                $MrEmployees = $this->User->find('all',array('conditions'=>array('User.is_mr'=>1),'fields'=>'User.employee_id'));
                foreach($MrEmployees as $MrEmployee){
                    $this->request->data['NotificationUser_employee_id'][$i++] = $MrEmployee['User']['employee_id'];
                }
                $this->request->data['NotificationUser_employee_id'][$i++] = $this->Session->read('User.id');
                $this->request->data['NotificationUser_employee_id'] = array_unique($this->request->data['NotificationUser_employee_id']);
                foreach ($this->request->data['NotificationUser_employee_id'] as $key=>$value) {

                    $this->NotificationUser->create();
                    $val = array();
                    $val['notification_id'] = $this->request->data['Notification']['id'];
                    $val['employee_id'] = $value;
                    $val['status'] = 0;
                    $val['publish'] = 1;
                    $val['branchid'] = $this->request->data['Notification']['branchid'];
                    $val['departmentid'] = $this->request->data['Notification']['departmentid'];
                    $val['created_by'] = $this->Session->read('User.id');
                    $val['modified_by'] = $this->Session->read('User.id');
                    $val['system_table_id'] = $this->_get_system_table_id();
                    $this->NotificationUser->save($val, false);
                }

                $this->Session->setFlash(__('The notification has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The notification could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Notification.' . $this->Notification->primaryKey => $id));
            $this->request->data = $this->Notification->find('first', $options);
        }
        $notificationTypes = $this->Notification->NotificationType->find('list', array('conditions' => array('NotificationType.publish' => 1, 'NotificationType.soft_delete' => 0)));
        $notificationUsers = $this->Notification->NotificationUser->find('all', array('conditions' => array('NotificationUser.notification_id' => $id, 'NotificationUser.soft_delete' => 0, 'NotificationUser.publish' => 1), 'fields' => 'NotificationUser.employee_id'));
        foreach ($notificationUsers as $notificationUser) {
            $selectedUser[] = $notificationUser['NotificationUser']['employee_id'];
        }

        $this->set(compact('notificationTypes', 'selectedUser'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->Notification->exists($id)) {
            throw new NotFoundException(__('Invalid notification'));
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
            $i = sizeof($this->request->data['NotificationUser_employee_id']);
            $this->request->data['Notification']['modified_by'] = $this->Session->read('User.id');
            if ($this->Notification->save($this->request->data)) {

                $this->loadModel('NotificationUser');
                $this->NotificationUser->deleteAll(array('notification_id' => $this->request->data['Notification']['id']), false);
                $this->loadModel('User');
                $MrEmployees = $this->User->find('all',array('conditions'=>array('User.is_mr'=>1),'fields'=>'User.employee_id'));
                foreach($MrEmployees as $MrEmployee){
                    $this->request->data['NotificationUser_employee_id'][$i++] = $MrEmployee['User']['employee_id'];
                }
                $this->request->data['NotificationUser_employee_id'][$i++] = $this->Session->read('User.id');
                $this->request->data['NotificationUser_employee_id'] = array_unique($this->request->data['NotificationUser_employee_id']);
                foreach ($this->request->data['NotificationUser_employee_id'] as $key=>$value) {
                    $this->NotificationUser->create();
                    $val = array();
                    $val['notification_id'] = $this->request->data['Notification']['id'];
                    $val['employee_id'] = $value;
                    $val['status'] = 0;
                    $val['publish'] = 1;
                    $val['branchid'] = $this->request->data['Notification']['branchid'];
                    $val['departmentid'] = $this->request->data['Notification']['departmentid'];
                    $val['created_by'] = $this->Session->read('User.id');
                    $val['modified_by'] = $this->Session->read('User.id');
                    $val['system_table_id'] = $this->_get_system_table_id();
                    $this->NotificationUser->save($val, false);
                }

                $this->Session->setFlash(__('The notification has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The notification could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Notification.' . $this->Notification->primaryKey => $id));
            $this->request->data = $this->Notification->find('first', $options);
        }
        $notificationTypes = $this->Notification->NotificationType->find('list', array('conditions' => array('NotificationType.publish' => 1, 'NotificationType.soft_delete' => 0)));
        $notificationUsers = $this->Notification->NotificationUser->find('all', array('conditions' => array('NotificationUser.notification_id' => $id, 'NotificationUser.soft_delete' => 0, 'NotificationUser.publish' => 1), 'fields' => 'NotificationUser.employee_id'));

        foreach ($notificationUsers as $notificationUser) {
            $selectedUser[] = $notificationUser['NotificationUser']['employee_id'];
        }

        $this->set(compact('notificationTypes', 'selectedUser'));
    }

}
