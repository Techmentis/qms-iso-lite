<?php

App::uses('AppController', 'Controller');

/**
 * MessageUserSents Controller
 *
 * @property MessageUserSent $MessageUserSent
 */
class MessageUserSentsController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->MessageUserSent->recursive = 0;
        $this->set('messageUserSents', $this->paginate());
    }

    public function _get_system_table_id() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $this->request->params['controller'])));
        return $systemTableId['SystemTable']['id'];
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->MessageUserSent->message_id = $id;
        $msgSent = $this->MessageUserSent->find('first', array('conditions' => array('MessageUserSent.message_id' => $id)));
        $this->set('messageUserSent', $msgSent);
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

        $userSentboxids = $this->MessageUserSent->find('all', array('conditions' => array('MessageUserSent.message_id' => $id, 'MessageUserSent.created_by' => $this->Session->read('User.id'))));

        foreach ($userSentboxids as $userSentboxid) {
            $delsuccess = $this->MessageUserSent->delete($userSentboxid['MessageUserSent']['id']);
        }

        $this->MessageUserSent->Message->MessageUserThrash->create();

        $newData['user_id'] = $userSentboxid['MessageUserSent']['user_id'];
        $newData['message_id'] = $id;
        $newData['status'] = 0;
        $newData['created_by'] = $this->Session->read('User.id');
        $newData['modified_by'] = $this->Session->read('User.id');
        $newData['system_table_id'] = $this->_get_system_table_id();
        $this->MessageUserSent->Message->MessageUserThrash->save($newData, false);

        if ($delsuccess) {
            $this->Session->setFlash(__('Message moved to Trash!'));
            $this->redirect(array('controller' => 'messages', 'action' => 'index'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function delete_all($ids = null) {
        if (isset($_POST['data'][$this->name]['recs_selected_sent']))
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected_sent']);
       if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $messageUserSentIDs = $this->MessageUserSent->find('all', array('conditions' => array('MessageUserSent.message_id' => $id, 'MessageUserSent.created_by' => $this->Session->read('User.id'))));

                    foreach ($messageUserSentIDs as $messageUserSentID) {
                        $delsuccess = $this->MessageUserSent->delete($messageUserSentID['MessageUserSent']['id']);
                    }

                    $this->MessageUserSent->Message->MessageUserThrash->create();

                    $newData['user_id'] = $messageUserSentID['MessageUserSent']['user_id'];
                    $newData['message_id'] = $id;
                    $newData['status'] = 0;
                    $newData['created_by'] = $this->Session->read('User.id');
                    $newData['modified_by'] = $this->Session->read('User.id');
                    $this->MessageUserSent->Message->MessageUserThrash->save($newData, false);
                }
            }
        }
        if($delsuccess){
            $this->Session->setFlash(__('All selected values moved to trash'));
        }
        else{
            $this->Session->setFlash(__('Problem occured during moved to trash'));
        }
        $this->redirect(array('controller' => 'messages', 'action' => 'index'));
    }

}
