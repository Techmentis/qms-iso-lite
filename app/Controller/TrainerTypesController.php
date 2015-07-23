<?php

App::uses('AppController', 'Controller');

/**
 * TrainerTypes Controller
 *
 * @property TrainerType $TrainerType
 */
class TrainerTypesController extends AppController {

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
        $this->paginate = array('order' => array('TrainerType.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->TrainerType->recursive = 0;
        $this->set('trainerTypes', $this->paginate());

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
                        $searchArray[] = array('TrainerType.' . $search => $searchKey);
                    else
                        $searchArray[] = array('TrainerType.' . $search . ' like ' => '%' . $searchKey . '%');
                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }
        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('TrainerType.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('TrainerType.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'TrainerType.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);
        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('TrainerType.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('TrainerType.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->TrainerType->recursive = 0;
        $this->paginate = array('order' => array('TrainerType.sr_no' => 'DESC'), 'conditions' => $conditions, 'TrainerType.soft_delete' => 0);
        $this->set('trainerTypes', $this->paginate());

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
        if (!$this->TrainerType->exists($id)) {
            throw new NotFoundException(__('Invalid trainer type'));
        }
        $options = array('conditions' => array('TrainerType.' . $this->TrainerType->primaryKey => $id));
        $this->set('trainerType', $this->TrainerType->find('first', $options));
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
            $this->request->data['TrainerType']['system_table_id'] = $this->_get_system_table_id();
            $this->TrainerType->create();
            if ($this->TrainerType->save($this->request->data)) {

                $this->Session->setFlash(__('The trainer type has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                $redirect = $this->request->data['TrainerType']['redirect'];
                if($redirect != ''){
                    unset($this->request->data['TrainerType']);
                    unset($this->request->data['Approval']);
               }
               else{
                    if ($this->_show_evidence() == true){
                        if(isset($this->request->data['TrainerType']['redirect']) && $this->request->data['TrainerType']['redirect'] != ''){
                            $this->redirect(array('controller'=>$this->request->data['TrainerType']['redirect'],'action' => 'lists'));
                        }else{
                            $this->redirect(array('action' => 'view', $this->TrainerType->id));
                        }
                    }
                else{
                    if(isset($this->request->data['TrainerType']['redirect']) && $this->request->data['TrainerType']['redirect'] != ''){
                        $this->redirect(array('controller'=>$this->request->data['TrainerType']['redirect'],'action' => 'lists'));
                    }else{
                        $this->redirect(array('action' => 'index'));
                    }
                }
             }
           } else {
                $this->Session->setFlash(__('The trainer type could not be saved. Please, try again.'));
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
        if (!$this->TrainerType->exists($id)) {
            throw new NotFoundException(__('Invalid trainer type'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['TrainerType']['system_table_id'] = $this->_get_system_table_id();
            if ($this->TrainerType->save($this->request->data)) {

                $this->Session->setFlash(__('The trainer type has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The trainer type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('TrainerType.' . $this->TrainerType->primaryKey => $id));
            $this->request->data = $this->TrainerType->find('first', $options);
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
        if (!$this->TrainerType->exists($id)) {
            throw new NotFoundException(__('Invalid trainer type'));
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
            if ($this->TrainerType->save($this->request->data)) {

                $this->Session->setFlash(__('The trainer type has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The trainer type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('TrainerType.' . $this->TrainerType->primaryKey => $id));
            $this->request->data = $this->TrainerType->find('first', $options);
        }
    }

}
