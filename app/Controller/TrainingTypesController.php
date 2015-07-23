<?php

App::uses('AppController', 'Controller');

/**
 * TrainingTypes Controller
 *
 * @property TrainingType $TrainingType
 */
class TrainingTypesController extends AppController {

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
        $this->paginate = array('order' => array('TrainingType.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->TrainingType->recursive = 0;
        $this->set('trainingTypes', $this->paginate());

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
                        $searchArray[] = array('TrainingType.' . $search => $searchKey);
                    else
                        $searchArray[] = array('TrainingType.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('TrainingType.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['mandetory'] != '') {
            $mandetoryConditions[] = array('TrainingType.mandetory' => $this->request->query['mandetory']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $mandetoryConditions);
            else
                $conditions[] = array('or' => $mandetoryConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('TrainingType.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'TrainingType.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('TrainingType.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('TrainingType.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->TrainingType->recursive = 0;
        $this->paginate = array('order' => array('TrainingType.sr_no' => 'DESC'), 'conditions' => $conditions, 'TrainingType.soft_delete' => 0);
        $this->set('trainingTypes', $this->paginate());

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
        if (!$this->TrainingType->exists($id)) {
            throw new NotFoundException(__('Invalid training type'));
        }
        $options = array('conditions' => array('TrainingType.' . $this->TrainingType->primaryKey => $id));
        $this->set('trainingType', $this->TrainingType->find('first', $options));
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
            $this->request->data['TrainingType']['system_table_id'] = $this->_get_system_table_id();
            $this->TrainingType->create();
            if ($this->TrainingType->save($this->request->data)) {

                $this->Session->setFlash(__('The training type has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                {
                    if(isset($this->request->data['TrainingType']['redirect']) && $this->request->data['TrainingType']['redirect'] != '')
                    {
                        $this->redirect(array('controller'=>$this->request->data['TrainingType']['redirect'],'action' => 'lists'));
                    }
                    else
                    {
                        $this->redirect(array('action' => 'view', $this->TrainingType->id));
                    }
                }else{
                    if(isset($this->request->data['TrainingType']['redirect']) && $this->request->data['TrainingType']['redirect'] != ''){
                        $this->redirect(array('controller'=>$this->request->data['TrainingType']['redirect'],'action' => 'lists'));
                    }else{
                        $this->redirect(array('action' => 'index'));
                    }

                }
            } else {
                $this->Session->setFlash(__('The training type could not be saved. Please, try again.'));
            }
        }
         $this->set(compact('redirect'));
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
        if (!$this->TrainingType->exists($id)) {
            throw new NotFoundException(__('Invalid training type'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['TrainingType']['system_table_id'] = $this->_get_system_table_id();
            if ($this->TrainingType->save($this->request->data)) {

                $this->Session->setFlash(__('The training type has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The training type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('TrainingType.' . $this->TrainingType->primaryKey => $id));
            $this->request->data = $this->TrainingType->find('first',   $options);
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
        if (!$this->TrainingType->exists($id)) {
            throw new NotFoundException(__('Invalid training type'));
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
            $this->request->data['TrainingType']['system_table_id'] = $this->_get_system_table_id();
            if ($this->TrainingType->save($this->request->data)) {

                $this->Session->setFlash(__('The training type has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The training type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('TrainingType.' . $this->TrainingType->primaryKey => $id));
            $this->request->data = $this->TrainingType->find('first', $options);
        }
    }

}
