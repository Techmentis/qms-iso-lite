<?php

App::uses('AppController', 'Controller');

/**
 * DataTypes Controller
 *
 * @property DataType $DataType
 */
class DataTypesController extends AppController {

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
        $this->paginate = array('order' => array('DataType.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->DataType->recursive = 0;
        $this->set('dataTypes', $this->paginate());

        $this->_get_count();

        $usernames = $this->requestAction('App/get_usernames');
        $this->set('usernames', $usernames);
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
                $this->request->query['keywords'];
            } else {
                $searchKeys = explode(" ", $this->request->query['keywords']);
            }
            foreach ($searchKeys as $searchKey):
                foreach ($this->request->query['search_fields'] as $search):
                    if ($this->request->query['strict_search'] == 0)
                        $searchArray[] = array('DataType.' . $search => $searchKey);
                    else
                        $searchArray[] = array('DataType.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $searchArray);
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('DataType.branchid' => $branches);
            endforeach;
            $conditions[] = array('or' => $branchConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('DataType.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'DataType.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
		$conditions =  $this->advance_search_common($conditions);
        unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('DataType.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('DataType.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->DataType->recursive = 0;
        $this->paginate = array('order' => array('DataType.sr_no' => 'DESC'), 'conditions' => $conditions, 'DataType.soft_delete' => 0);
        $this->set('dataTypes', $this->paginate());

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
        if (!$this->DataType->exists($id)) {
            throw new NotFoundException(__('Invalid data type'));
        }
        $options = array('conditions' => array('DataType.' . $this->DataType->primaryKey => $id));
        $this->set('dataType', $this->DataType->find('first', $options));

        $userNames = $this->requestAction('App/get_usernames');
        $this->set('userNames', $userNames);
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
    public function add_ajax($redirect = NULL) {

        $conditions = $this->_check_request();
        $this->paginate = array('limit' => 5,'order' => array('DataType.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->DataType->recursive = 0;
        $this->set('dataTypes', $this->paginate());

        $userNames = $this->requestAction('App/get_usernames');
        $this->set('userNames', $userNames);

        if ($this->_show_approvals()) {
            $this->loadModel('User');
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }

        if ($this->request->is('post')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['DataType']['system_table_id'] = $this->_get_system_table_id();
            $this->DataType->create();
            if ($this->DataType->save($this->request->data)) {
                $this->Session->setFlash(__('The data type has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                $redirect = $this->request->data['DataType']['redirect'];
                if ($redirect != '') {
                    unset($this->request->data['DataType']);
                    unset($this->request->data['Approval']);
                } else {
                    if ($this->_show_evidence() == true) {
                        if (isset($this->request->data['DataType']['redirect']) && $this->request->data['DataType']['redirect'] != '') {
                            $this->redirect(array('controller' => $this->request->data['DataType']['redirect'], 'action' => 'add_ajax'));
                        } else {
                            $this->redirect(array('action' => 'view', $this->DataType->id));
                        }
                    } else {
                        if (isset($this->request->data['DataType']['redirect']) && $this->request->data['DataType']['redirect'] != '') {
                            $this->redirect(array('controller' => $this->request->data['DataType']['redirect'], 'action' => 'lists'));
                        } else {
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }
            } else {
                $this->Session->setFlash(__('The data type could not be saved. Please, try again.'));
            }
        }
        $users = $this->requestAction('App/get_usernames');
        $this->set(compact('users', 'redirect'));
        $this->index();
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->DataType->exists($id)) {
            throw new NotFoundException(__('Invalid data type'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['DataType']['system_table_id'] = $this->_get_system_table_id();
            if ($this->DataType->save($this->request->data)) {
                $this->Session->setFlash(__('The data type has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The data type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('DataType.' . $this->DataType->primaryKey => $id));
            $this->request->data = $this->DataType->find('first', $options);
        }
        $users = $this->requestAction('App/get_usernames');
        $this->set(compact('users'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->DataType->exists($id)) {
            throw new NotFoundException(__('Invalid data type'));
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
            if ($this->DataType->save($this->request->data)) {
                $this->Session->setFlash(__('The data type has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The data type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('DataType.' . $this->DataType->primaryKey => $id));
            $this->request->data = $this->DataType->find('first', $options);
        }
        $users = $this->requestAction('App/get_usernames');
        $this->set(compact('users'));
    }

}
