<?php

App::uses('AppController', 'Controller');

/**
 * Schedules Controller
 *
 * @property Schedule $Schedule
 */
class SchedulesController extends AppController {

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
        $this->paginate = array('order' => array('Schedule.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->Schedule->recursive = 0;
        $this->set('schedules', $this->paginate());

        $this->_get_count();
    }

    /**
     * adcanced_search method
     * Advanced search by - TGS
     * @return void
     */
    public function advanced_search() {
        if ($this->request->is('post')) {
            $conditions = array();
            if ($this->request->data['Search']['keywords']) {
                $searchArray = array();
                $searchKeys = explode(" ", $this->request->data['Search']['keywords']);

                foreach ($searchKeys as $searchKey):
                    foreach ($this->request->data['Search']['search_fields'] as $search):
                        if ($this->request->data['Search']['strict_search'] == 0)
                            $searchArray[] = array('Schedule.' . $search => $searchKey);
                        else
                            $searchArray[] = array('Schedule.' . $search . ' like ' => '%' . $searchKey . '%');
                    endforeach;
                endforeach;
                if ($this->request->data['Search']['strict_search'] == 0)
                    $conditions[] = array('and' => $searchArray);
                else
                    $conditions[] = array('or' => $searchArray);
            }

            if ($this->request->data['Search']['branch_list']) {
                foreach ($this->request->data['Search']['branch_list'] as $branches):
                    $branchConditions[] = array('Schedule.branch_id' => $branches);
                endforeach;
                $conditions[] = array('or' => $branchConditions);
            }

            if (!$this->request->data['Search']['to-date'])
                $this->request->data['Search']['to-date'] = date('Y-m-d');
            if ($this->request->data['Search']['from-date']) {
                $conditions[] = array('Schedule.created >' => date('Y-m-d h:i:s', strtotime($this->request->data['Search']['from-date'])), 'Schedule.created <' => date('Y-m-d h:i:s', strtotime($this->request->data['Search']['to-date'])));
            }
            unset($this->request->data['Search']);


            if ($this->Session->read('User.is_mr') == 0)
                $onlyBranch = array('Schedule.branch_id' => $this->Session->read('User.branch_id'));
            if ($this->Session->read('User.is_view_all') == 0)
                $onlyOwn = array('Schedule.created_by' => $this->Session->read('User.id'));
            $conditions[] = array($onlyBranch, $onlyOwn);

            $this->Schedule->recursive = 0;
            $this->paginate = array('order' => array('Schedule.sr_no' => 'DESC'), 'conditions' => $conditions, 'Schedule.soft_delete' => 0);
            $this->set('schedules', $this->paginate());
        }

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
        if (!$this->Schedule->exists($id)) {
            throw new NotFoundException(__('Invalid schedule'));
        }
        $options = array('conditions' => array('Schedule.' . $this->Schedule->primaryKey => $id));
        $this->set('schedule', $this->Schedule->find('first', $options));
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
            $this->request->data['Schedule']['system_table_id'] = $this->_get_system_table_id();
            $this->Schedule->create();
            if ($this->Schedule->save($this->request->data)) {

                $this->Session->setFlash(__('The schedule has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->Schedule->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The schedule could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Schedule->exists($id)) {
            throw new NotFoundException(__('Invalid schedule'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Schedule']['system_table_id'] = $this->_get_system_table_id();
            if ($this->Schedule->save($this->request->data)) {

                $this->Session->setFlash(__('The schedule has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The schedule could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Schedule.' . $this->Schedule->primaryKey => $id));
            $this->request->data = $this->Schedule->find('first', $options);
        }
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approval_id = null) {
        if (!$this->Schedule->exists($id)) {
            throw new NotFoundException(__('Invalid schedule'));
        }

        $this->loadModel('Approval');
        if (!$this->Approval->exists($approval_id)) {
            throw new NotFoundException(__('Invalid approval id'));
        }

        $approval = $this->Approval->read(null, $approval_id);
        $this->set('same', $approval['Approval']['user_id']);

        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Schedule->save($this->request->data)) {

                $this->Session->setFlash(__('The schedule has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The schedule could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Schedule.' . $this->Schedule->primaryKey => $id));
            $this->request->data = $this->Schedule->find('first', $options);
        }
    }
}
