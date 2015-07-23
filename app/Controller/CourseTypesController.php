<?php

App::uses('AppController', 'Controller');

/**
 * CourseTypes Controller
 *
 * @property CourseType $CourseType
 */
class CourseTypesController extends AppController {

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
        $this->paginate = array('order' => array('CourseType.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->CourseType->recursive = 0;
        $this->set('courseTypes', $this->paginate());

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
                $SearchKeys[] = $this->request->query['keywords'];
            } else {
                $SearchKeys = explode(" ", $this->request->query['keywords']);
            }
            foreach ($SearchKeys as $SearchKey):
                foreach ($this->request->query['search_fields'] as $search):
                    if ($this->request->query['strict_search'] == 0)
                        $searchArray[] = array('CourseType.' . $search => $SearchKey);
                    else
                        $searchArray[] = array('CourseType.' . $search . ' like ' => '%' . $SearchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('CourseType.branchid' => $branches);
            endforeach;
            $conditions[] = array('or' => $branchConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('CourseType.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'CourseType.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);

        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('CourseType.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('CourseType.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->CourseType->recursive = 0;
        $this->paginate = array('order' => array('CourseType.sr_no' => 'DESC'), 'conditions' => $conditions, 'CourseType.soft_delete' => 0);
        $this->set('courseTypes', $this->paginate());
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
        if (!$this->CourseType->exists($id)) {
            throw new NotFoundException(__('Invalid course type'));
        }
        $this->CourseType->recursive = 0;
        $options = array('conditions' => array('CourseType.' . $this->CourseType->primaryKey => $id));
        $this->set('courseType', $this->CourseType->find('first', $options));
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

        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['CourseType']['system_table_id'] = $this->_get_system_table_id();
            $this->CourseType->create();
            if ($this->CourseType->save($this->request->data)) {
                $this->Session->setFlash(__('The course type has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                $redirect = $this->request->data['CourseType']['redirect'];
                if ($redirect != '') {
                    unset($this->request->data['CourseType']);
                    unset($this->request->data['Approval']);
                } else {
                    if ($this->_show_evidence() == true) {
                        if (isset($this->request->data['CourseType']['redirect']) && $this->request->data['CourseType']['redirect'] != '') {
                            $this->redirect(array('controller' => $this->request->data['CourseType']['redirect'], 'action' => 'lists'));
                        } else {
                            $this->redirect(array('action' => 'view', $this->CourseType->id));
                        }
                    } else {
                        if (isset($this->request->data['CourseType']['redirect']) && $this->request->data['CourseType']['redirect'] != '') {
                            $this->redirect(array('controller' => $this->request->data['CourseType']['redirect'], 'action' => 'lists'));
                        } else {
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }
            } else {
                $this->Session->setFlash(__('The course type could not be saved. Please, try again.'));
            }
        }
        $this->set('redirect', $redirect);
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
        if (!$this->CourseType->exists($id)) {
            throw new NotFoundException(__('Invalid course type'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['CourseType']['system_table_id'] = $this->_get_system_table_id();
            if ($this->CourseType->save($this->request->data)) {
                $this->Session->setFlash(__('The course type has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The course type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CourseType.' . $this->CourseType->primaryKey => $id));
            $this->request->data = $this->CourseType->find('first', $options);
        }
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->CourseType->exists($id)) {
            throw new NotFoundException(__('Invalid course type'));
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
            if ($this->CourseType->save($this->request->data)) {
                $this->Session->setFlash(__('The course type has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

            } else {
                $this->Session->setFlash(__('The course type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CourseType.' . $this->CourseType->primaryKey => $id));
            $this->request->data = $this->CourseType->find('first', $options);
        }
    }

}
