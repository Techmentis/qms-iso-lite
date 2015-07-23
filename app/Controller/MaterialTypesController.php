<?php

App::uses('AppController', 'Controller');

/**
 * MaterialTypes Controller
 *
 * @property MaterialType $MaterialType
 */
class MaterialTypesController extends AppController {

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
        $this->paginate = array('order' => array('MaterialType.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->MaterialType->recursive = 0;
        $this->set('materialTypes', $this->paginate());

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
                            $searchArray[] = array('MaterialType.' . $search => $searchKey);
                        else
                            $searchArray[] = array('MaterialType.' . $search . ' like ' => '%' . $searchKey . '%');

                    endforeach;
                endforeach;
                if ($this->request->data['Search']['strict_search'] == 0)
                    $conditions[] = array('and' => $searchArray);
                else
                    $conditions[] = array('or' => $searchArray);
            }

            if ($this->request->data['Search']['branch_list']) {
                foreach ($this->request->data['Search']['branch_list'] as $branches):
                    $branchConditions[] = array('MaterialType.branch_id' => $branches);
                endforeach;
                $conditions[] = array('or' => $branchConditions);
            }

            if (!$this->request->data['Search']['to-date'])
                $this->request->data['Search']['to-date'] = date('Y-m-d');
            if ($this->request->data['Search']['from-date']) {
                $conditions[] = array('MaterialType.created >' => date('Y-m-d h:i:s', strtotime($this->request->data['Search']['from-date'])), 'MaterialType.created <' => date('Y-m-d h:i:s', strtotime($this->request->data['Search']['to-date'])));
            }
            unset($this->request->data['Search']);


            if ($this->Session->read('User.is_mr') == 0)
                $onlyBranch = array('MaterialType.branch_id' => $this->Session->read('User.branch_id'));
            if ($this->Session->read('User.is_view_all') == 0)
                $onlyOwn = array('MaterialType.created_by' => $this->Session->read('User.id'));
            $conditions[] = array($onlyBranch, $onlyOwn);

            $this->MaterialType->recursive = 0;
            $this->paginate = array('order' => array('MaterialType.sr_no' => 'DESC'), 'conditions' => $conditions, 'MaterialType.soft_delete' => 0);
            $this->set('materialTypes', $this->paginate());
        }
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->MaterialType->exists($id)) {
            throw new NotFoundException(__('Invalid material type'));
        }
        $options = array('conditions' => array('MaterialType.' . $this->MaterialType->primaryKey => $id));
        $this->set('materialType', $this->MaterialType->find('first', $options));
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
            $this->request->data['MaterialType']['system_table_id'] = $this->_get_system_table_id();
            $this->MaterialType->create();
            if ($this->MaterialType->save($this->request->data)) {

                $this->Session->setFlash(__('The material type has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->MaterialType->id));
                else
                    $this->redirect(str_replace('/lists', '/add_ajax', $this->referer()));
            } else {
                $this->Session->setFlash(__('The material type could not be saved. Please, try again.'));
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
        if (!$this->MaterialType->exists($id)) {
            throw new NotFoundException(__('Invalid material type'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['MaterialType']['system_table_id'] = $this->_get_system_table_id();
            if ($this->MaterialType->save($this->request->data)) {

                $this->Session->setFlash(__('The material type has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The material type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('MaterialType.' . $this->MaterialType->primaryKey => $id));
            $this->request->data = $this->MaterialType->find('first', $options);
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
        if (!$this->MaterialType->exists($id)) {
            throw new NotFoundException(__('Invalid material type'));
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
            if ($this->MaterialType->save($this->request->data)) {

                $this->Session->setFlash(__('The branch has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The material type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('MaterialType.' . $this->MaterialType->primaryKey => $id));
            $this->request->data = $this->MaterialType->find('first', $options);
        }
    }

}
