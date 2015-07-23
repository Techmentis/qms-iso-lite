<?php

App::uses('AppController', 'Controller');

/**
 * Messages Controller
 *
 * @property Message $Message
 */
class MessagesController extends AppController {

    var $paginate = array('order' => array('Message.created' => 'DESC'));

    public function index() {

        $this->loadModel('MessageUserInbox');
        $this->MessageUserInbox->recursive = -2;

        $unread = $this->MessageUserInbox->find('count', array('conditions' => array('MessageUserInbox.user_id' => $this->Session->read('User.id'), 'MessageUserInbox.status' => 0)));

        $this->set('unread', $unread);
    }

    /**
     * index method
     *
     * @return void
     */
    public function _get_system_table_id() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $sys_id = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $this->request->params['controller'])));
        return $sys_id['SystemTable']['id'];
    }

    public function inbox() {
        $this->loadModel('MessageUserInbox');
        $this->MessageUserInbox->recursive = 1;
        $this->paginate = array('MessageUserInbox' => array('order' => array('MessageUserInbox.id' => 'DESC'), 'group' => array('MessageUserInbox.trackingid'), 'conditions' => array('MessageUserInbox.status <>' => 2, 'MessageUserInbox.user_id' => $this->Session->read('User.id'))));
        $newData = array();
        $data = $this->paginate('MessageUserInbox');
        $i = 0;
        foreach ($data as $message) {
            $message_count = $this->Message->MessageUserInbox->find('count', array('conditions' => array('Message.trackingid' => $message['MessageUserInbox']['trackingid'], 'MessageUserInbox.user_id' => $this->Session->read('User.id'))));

            $message_unread = $this->Message->MessageUserInbox->find('count', array('conditions' => array('Message.trackingid' => $message['MessageUserInbox']['trackingid'], 'MessageUserInbox.user_id' => $this->Session->read('User.id'), 'MessageUserInbox.status' => 0)));
            $this->Message->User->recursive = 0;
            $message_from = $this->Message->User->find('all', array('conditions' => array('User.id' => $message['User']['id']), 'fields' => array('User.id', 'User.name', 'Branch.id', 'Branch.name')));

            $newdata[$i] = $message;
            $newdata[$i]['from'] = $message_from;
            $newdata[$i]['unread'] = $message_unread;
            $newdata[$i]['total'] = $message_count;
            $i++;
        }
        $this->set('messages', $newdata);
    }

    public function sent() {

        $this->Message->MessageUserSent->recursive = 1;
        $i = 0;
        $messages = $this->Message->MessageUserSent->find("all", array("conditions" => array(
                "MessageUserSent.created_by = '" . $this->Session->read('User.id') . "'")));

        $newData = array();
        foreach ($messages as $message) {

            $newData[$message['MessageUserSent']['trackingid']]['messageData'] = $message;

            $receiver = $this->Message->MessageUserSent->User->find('first', array("conditions" => array(
                    "User.id = '" . $message['MessageUserSent']['user_id'] . "'")));

            $newData[$message['MessageUserSent']['trackingid']]['username'][] = $receiver ['User']['name'];
        }
        $this->set('messages', $newData);
    }

    public function trash() {

        $this->Message->MessageUserThrash->recursive = 1;

        $trashed = $this->Message->MessageUserThrash->find("all", array("conditions" => array(
                "MessageUserThrash.created_by = '" . $this->Session->read('User.id') . "'")));

        $this->set('messageUserTrashes', $trashed);
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Message->id = $id;
        if (!$this->Message->exists()) {
            throw new NotFoundException(__('Invalid message'));
        }
        $this->set('message', $this->Message->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add($controller = null) {

        if ($this->request->is('post')) {
            if ($this->request->data['Message_to'] != 0) {
                $this->Message->create();
                if ($this->Message->save($this->request->data)) {

                    $this->Message->read(null, $this->Message->id);
                    $this->Message->set('trackingid', $this->Message->id);
                    $this->Message->save();

                    foreach ($this->request->data['Message_to'] as $uData) {
                        $this->Message->MessageUserInbox->create();
                        $newData = array();
                        if ($uData) {
                            $newData['user_id'] = $uData;
                            $newData['message_id'] = $this->Message->id;
                            $newData['trackingid'] = $this->Message->id;
                            $newData['status'] = 0;
                            $this->Message->MessageUserInbox->save($newData, false);
                        }
                    }

                    foreach ($this->request->data['Message_to'] as $uData) {

                        $this->Message->MessageUserSent->create();
                        if ($uData) {
                            $newData['user_id'] = $uData;
                            $newData['message_id'] = $this->Message->id;
                            $newData['trackingid'] = $this->Message->id;
                            $newData['status'] = 0;
                            $this->Message->MessageUserSent->save($newData, false);
                        }
                    }
                    $this->Session->setFlash(__('Message Sent Successfully'));
                    if($this->request->data['Message']['flag1'] == 'users'){
                        $this->redirect(array('action' => 'add'));   
                    }else{
                    $this->redirect(array('action' => 'index'));
                    }
                } else {
                    $this->Session->setFlash(__('The message could not be saved. Please, try again.'));
                }
            } else {
                $this->Session->setFlash(__('No recipient selected. Please, try again.'));
                $this->redirect(array('controller'=>'users','action' => 'dashboard'));
            }
            $this->Session->setFlash(__('You can not send any messages from demo edition!'));
            $this->redirect(array('action' => 'index'));
        }
        $users = $this->Message->User->find('list', array('conditions' => array('User.publish' => 1, 'User.soft_delete' => 0), 'fields' => array('User.username')));
        $this->set(compact('users','controller'));
    }
    /**
     * delete method
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Message->id = $id;
        if (!$this->Message->exists()) {
            throw new NotFoundException(__('Invalid message'));
        }

        $userInboxid = $this->Message->MessageUserInbox->find('first', array('conditions' => array('MessageUserInbox.message_id' => $id, 'MessageUserInbox.user_id' => $this->Session->read('User.id'))));

        $this->Message->MessageUserInbox->delete($userInboxid['MessageUserInbox']['id']);

        $this->Message->MessageUserThrash->create();

        $newData['user_id'] = $userInboxid['Message']['created_by'];
        $newData['message_id'] = $this->Message->id;
        $newData['status'] = 0;
        $newData['created_by'] = $this->Session->read('User.id');
        $newData['modified_by'] = $this->Session->read('User.id');
        $newData['system_table_id'] = $this->_get_system_table_id();
        $this->Message->MessageUserThrash->save($newData, false);
        $this->Session->setFlash(__('Message moved to Trash!'));
        $this->redirect(array('action' => 'index'));
    }

    public function reply($id = null) {

        if ($this->request->data) {
            if ($this->request->is('post')) {
                $this->Message->create();
                if ($this->Message->save($this->request->data, false)) {

                    $this->Message->read(null, $this->Message->id);
                    $this->Message->set('trackingid', $this->Message->id);
                    $this->Message->save();

                    foreach ($this->request->data['Message_to'] as $uData) {
                        $this->Message->MessageUserInbox->create();
                        $newData['user_id'] = $uData;
                        $newData['message_id'] = $this->Message->id;
                        $newData['status'] = 0;
                        $newData['trackingid'] = $this->Message->id;
                        $newData['created_by'] = $this->Session->read('User.id');
                        $newData['modified_by'] = $this->Session->read('User.id');
                        $this->Message->MessageUserInbox->save($newData, false);
                    }

                    $this->Message->MessageUserSent->create();
                    $newData['user_id'] = $this->request->data['Message']['user_id'];
                    $newData['message_id'] = $this->Message->id;
                    $newData['status'] = 0;
                    $newData['trackingid'] = $this->Message->id;
                    $newData['created_by'] = $this->Session->read('User.id');
                    $newData['modified_by'] = $this->Session->read('User.id');
                    $this->Message->MessageUserSent->save($newData, false);

                    $this->Session->setFlash(__('The message has been saved'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The message could not be saved. Please, try again.'));
                }
            }
        }

        $findMessage = $this->Message->read(null, $id);
        $messageThread = $this->Message->find('all', array('order' => array('Message.id ASC'), 'conditions' => array('Message.trackingid' => $findMessage['Message']['trackingid'])));
        $newMessageThread = array();
        foreach ($messageThread as $messages) {

            foreach ($messages['MessageUserInbox'] as $inbox) {
                if ($inbox['status'] < 2 && $inbox['user_id'] == $this->Session->read('User.id')) {
                    $newMessageThread[] = $messages;
                }
            }
            foreach ($messages['MessageUserSent'] as $sent) {
                if (($sent['status'] < 2) && ($sent['user_id'] == $this->Session->read('User.id'))) {
                    $newMessageThread[] = $messages;
                }
            }
        }

        $i = 0;

        foreach ($newMessageThread as $messages) {
            $j = 0;
            foreach ($messages['MessageUserInbox'] as $findusers) {
                $this->Message->User->recursive = 0;
                $users = $this->Message->User->find('first', array('conditions' => array('User.id' => $findusers['user_id'])));

                $newMessageThread[$i]['Userdetails'][$j] = $users['User'];
                $newMessageThread[$i]['Userdetails'][$j]['Branch'] = $users['Branch'];
                $j++;
            }
            $i++;
        }

        $this->set('messageThread', $newMessageThread);

        $this->Message->id = $id;

        $gettrackingid = $this->Message->read(null, $id);

        $userInboxid = $this->Message->find('all', array('conditions' => array('Message.trackingid ' => $gettrackingid['Message']['trackingid'])));

        foreach ($gettrackingid['MessageUserInbox'] as $inbox) {
            if ($inbox['user_id'] == $this->Session->read('User.id')) {
                $data['id'] = $inbox['id'];
                $data['status'] = 1;
                $this->Message->MessageUserInbox->save($data, false);
            }
        }

        $users = $this->Message->User->find('list', array('conditions' => array('User.publish' => 1, 'User.soft_delete' => 0), 'fields' => array('User.username')));
        $this->set(compact('users'));
    }

    public function delete_all($ids = null) {
        if ($_POST['data'][$this->name]['recs_selected_inbox'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected_inbox']);
        if (!empty($ids)) {

            foreach ($ids as $id) {
                if (!empty($id)) {
                    $this->Message->id = $id;
                    $userInboxid = $this->Message->MessageUserInbox->find('first', array('conditions' => array('MessageUserInbox.message_id' => $id, 'MessageUserInbox.user_id' => $this->Session->read('User.id'))));
                    $this->Message->MessageUserInbox->delete($userInboxid['MessageUserInbox']['id']);

                    $this->Message->MessageUserThrash->create();
                    $newData['user_id'] = $userInboxid['Message']['created_by'];
                    $newData['message_id'] = $this->Message->id;
                    $newData['status'] = 0;
                    $newData['created_by'] = $this->Session->read('User.id');
                    $newData['modified_by'] = $this->Session->read('User.id');
                    $this->Message->MessageUserThrash->save($newData, false);
                }
            }
        }
        $this->Session->setFlash(__('Message moved to Trash!'));
        $this->redirect(array('controller' => 'messages', 'action' => 'index'));
    }

}
