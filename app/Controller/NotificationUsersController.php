<?php

App::uses('AppController', 'Controller');

/**
 * NotificationUsers Controller
 *
 * @property NotificationUser $NotificationUser
 */
class NotificationUsersController extends AppController {

    public function _get_system_table_id() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $sys_id = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $this->request->params['controller'])));
        return $sys_id['SystemTable']['id'];
    }
    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->NotificationUser->exists($id)) {
            throw new NotFoundException(__('Invalid notification user'));
        }
        $options = array('conditions' => array('NotificationUser.' . $this->NotificationUser->primaryKey => $id));
        $this->set('notificationUser', $this->NotificationUser->find('first', $options));
    }
    public function display_notifications() {
        $date = date('Y-m-d');
        $this->loadModel('NotificationType');
        $this->NotificationUser->recursive = 0;
        $conditions = array('NotificationUser.employee_id' => $this->Session->read('User.employee_id'), 'Notification.end_date >=' => $date, 'Notification.soft_delete' => 0, 'Notification.publish' => 1);
        $this->paginate = array('limit' => 1, 'order' => array('NotificationUser.sr_no' => 'DESC'), 'conditions' => array($conditions, 'NotificationUser.soft_delete' => 0),'fields'=>array('Notification.notification_type_id','Notification.title','Notification.message','Notification.start_date'));
        $this->set('notificationUsers', $this->paginate());
        $notificationType = $this->NotificationType->find('list',array('conditions'=>array('NotificationType.publish'=>1,'NotificationType.soft_delete'=>0)));
        $this->set('notificationType',$notificationType);
        $this->_get_count();
    }

}
