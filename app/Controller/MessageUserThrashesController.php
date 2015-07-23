<?php

App::uses('AppController', 'Controller');

/**
 * MessageUserThrashes Controller
 *
 * @property MessageUserThrash $MessageUserThrash
 */
class MessageUserThrashesController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->MessageUserThrash->recursive = 0;
        $this->set('messageUserTrashes', $this->paginate());
    }

    public function view($id = null) {
        $this->MessageUserThrash->message_id = $id;
        $msgTrash = $this->MessageUserThrash->find('first', array('conditions' => array('MessageUserThrash.message_id' => $id)));

        $this->set('MessageUserTrash', $msgTrash);
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

        if ($this->MessageUserThrash->delete($id)) {
            $this->Session->setFlash(__('Message deleted'));
            $this->redirect(array('controller' => 'messages', 'action' => 'index'));
        }
        $this->Session->setFlash(__('Message was not deleted'));
        $this->redirect(array('controller' => 'messages', 'action' => 'index'));
    }

    public function delete_all($ids = null) {
        if ($_POST['data'][$this->name]['recs_selected_trash'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected_trash']);
            if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $this->MessageUserThrash->delete($id);
                }
            }
        }
        $this->Session->setFlash(__('All selected value deleted'));
        $this->redirect(array('controller' => 'messages', 'action' => 'index'));
    }

}
