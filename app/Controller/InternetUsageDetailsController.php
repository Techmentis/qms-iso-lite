<?php

App::uses('AppController', 'Controller');

/**
 * InternetUsageDetails Controller
 *
 * @property InternetUsageDetail $InternetUsageDetail
 */
class InternetUsageDetailsController extends AppController {

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
        $this->paginate = array('order' => array('InternetUsageDetail.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->InternetUsageDetail->recursive = 0;
        $this->set('internetUsageDetails', $this->paginate());

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
                        $search_array[] = array('InternetUsageDetail.' . $search => $search_key);
                    else
                        $search_array[] = array('InternetUsageDetail.' . $search . ' like ' => '%' . $search_key . '%');

                endforeach;
            endforeach;
            if ($this->request->data['Search']['strict_search'] == 0)
                $conditions[] = array('and' => $search_array);
            else
                $conditions[] = array('or' => $search_array);
        }

        if ($this->request->data['Search']['branch_list']) {
            foreach ($this->request->data['Search']['branch_list'] as $branches):
                $branch_conditions[] = array('InternetUsageDetail.branch_id' => $branches);
            endforeach;
            $conditions[] = array('or' => $branch_conditions);
        }

        if (!$this->request->data['Search']['to-date'])
            $this->request->data['Search']['to-date'] = date('Y-m-d');
        if ($this->request->data['Search']['from-date']) {
            $conditions[] = array('InternetUsageDetail.created >' => date('Y-m-d h:i:s', strtotime($this->request->data['Search']['from-date'])), 'InternetUsageDetail.created <' => date('Y-m-d h:i:s', strtotime($this->request->data['Search']['to-date'])));
        }
        unset($this->request->data['Search']);


        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('InternetUsageDetail.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('InternetUsageDetail.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->InternetUsageDetail->recursive = 0;
        $this->paginate = array('order' => array('InternetUsageDetail.sr_no' => 'DESC'), 'conditions' => $conditions, 'InternetUsageDetail.soft_delete' => 0);
        $this->set('internetUsageDetails', $this->paginate());

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
        if (!$this->InternetUsageDetail->exists($id)) {
            throw new NotFoundException(__('Invalid internet usage detail'));
        }
        $options = array('conditions' => array('InternetUsageDetail.' . $this->InternetUsageDetail->primaryKey => $id));
        $this->set('internetUsageDetail', $this->InternetUsageDetail->find('first', $options));
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
            $this->loadModel('User');
            $this->User->recursive = 0;
            $userids = $this->User->find('list', array('order' => array('User.name' => 'ASC'), 'conditions' => array('User.publish' => 1, 'User.soft_delete' => 0)));
            $this->set(array('userids' => $userids, 'showApprovals' => $this->_show_approvals()));
        }

        if ($this->request->is('post')) {
            $this->request->data['InternetUsageDetail']['system_table_id'] = $this->_get_system_table_id();
            $this->InternetUsageDetail->create();
            if ($this->InternetUsageDetail->save($this->request->data)) {
                $this->Session->setFlash(__('The internet usage detail has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->InternetUsageDetail->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The internet usage detail could not be saved. Please, try again.'));
            }
        }
        $systemTables = $this->InternetUsageDetail->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $masterListOfFormats = $this->InternetUsageDetail->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0)));
        $this->set(compact('systemTables', 'masterListOfFormats'));
        $count = $this->InternetUsageDetail->find('count');
        $published = $this->InternetUsageDetail->find('count', array('conditions' => array('InternetUsageDetail.publish' => 1)));
        $unpublished = $this->InternetUsageDetail->find('count', array('conditions' => array('InternetUsageDetail.publish' => 0)));

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
        if (!$this->InternetUsageDetail->exists($id)) {
            throw new NotFoundException(__('Invalid internet usage detail'));
        }
        if ($this->_show_approvals()) {
            $this->loadModel('User');
            $this->User->recursive = 0;
            $userids = $this->User->find('list', array('order' => array('User.name' => 'ASC'), 'conditions' => array('User.publish' => 1, 'User.soft_delete' => 0)));
            $this->set(array('userids' => $userids, 'showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['InternetUsageDetail']['system_table_id'] = $this->_get_system_table_id();
            if ($this->InternetUsageDetail->save($this->request->data)) {
                $this->Session->setFlash(__('The internet usage detail has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The internet usage detail could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('InternetUsageDetail.' . $this->InternetUsageDetail->primaryKey => $id));
            $this->request->data = $this->InternetUsageDetail->find('first', $options);
        }
        $systemTables = $this->InternetUsageDetail->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $masterListOfFormats = $this->InternetUsageDetail->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0)));
        $this->set(compact('systemTables', 'masterListOfFormats'));
        $count = $this->InternetUsageDetail->find('count');
        $published = $this->InternetUsageDetail->find('count', array('conditions' => array('InternetUsageDetail.publish' => 1)));
        $unpublished = $this->InternetUsageDetail->find('count', array('conditions' => array('InternetUsageDetail.publish' => 0)));

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
        if (!$this->InternetUsageDetail->exists($id)) {
            throw new NotFoundException(__('Invalid internet usage detail'));
        }

        $this->loadModel('Approval');
        if (!$this->Approval->exists($approval_id)) {
            throw new NotFoundException(__('Invalid approval id'));
        }

        $approval = $this->Approval->read(null, $approval_id);
        $this->set('same', $approval['Approval']['user_id']);

        //$approval_history = $this->Approval->find('all',array('order'=>array('Approval.sr_no'=>'DESC'),'conditions'=>array('Approval.model_name'=>'InternetUsageDetail','Approval.record'=>$id)));
        //$this->set(compact('approval_history'));

        if ($this->_show_approvals()) {
            $this->loadModel('User');
            $this->User->recursive = 0;
            $userids = $this->User->find('list', array('order' => array('User.name' => 'ASC'), 'conditions' => array('User.publish' => 1, 'User.soft_delete' => 0)));
            $this->set(array('userids' => $userids, 'showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->InternetUsageDetail->save($this->request->data)) {
                $this->Session->setFlash(__('The internet usage detail has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();
            } else {
                $this->Session->setFlash(__('The internet usage detail could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('InternetUsageDetail.' . $this->InternetUsageDetail->primaryKey => $id));
            $this->request->data = $this->InternetUsageDetail->find('first', $options);
        }
        $systemTables = $this->InternetUsageDetail->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $masterListOfFormats = $this->InternetUsageDetail->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0)));
        $this->set(compact('systemTables', 'masterListOfFormats'));
        $count = $this->InternetUsageDetail->find('count');
        $published = $this->InternetUsageDetail->find('count', array('conditions' => array('InternetUsageDetail.publish' => 1)));
        $unpublished = $this->InternetUsageDetail->find('count', array('conditions' => array('InternetUsageDetail.publish' => 0)));

        $this->set(compact('count', 'published', 'unpublished'));
    }

}
