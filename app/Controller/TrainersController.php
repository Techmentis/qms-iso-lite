<?php

App::uses('AppController', 'Controller');

/**
 * Trainers Controller
 *
 * @property Trainer $Trainer
 */
class TrainersController extends AppController {

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
        $this->paginate = array('order' => array('Trainer.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->Trainer->recursive = 0;
        $this->set('trainers', $this->paginate());

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
                        $searchArray[] = array('Trainer.' . $search => $searchKey);
                    else
                        $searchArray[] = array('Trainer.' . $search . ' like ' => '%' . $searchKey . '%');
                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('Trainer.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['trainer_type_id']) {
            foreach ($this->request->query['trainer_type_id'] as $trainerTypeId):
                $trainerConditions[] = array('Trainer.trainer_type_id' => $trainerTypeId);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $trainerConditions));
            else
                $conditions[] = array('or' => $trainerConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('Trainer.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'Trainer.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('Trainer.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Trainer.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->Trainer->recursive = 0;
        $this->paginate = array('order' => array('Trainer.sr_no' => 'DESC'), 'conditions' => $conditions, 'Trainer.soft_delete' => 0);
        $this->set('trainers', $this->paginate());

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
        if (!$this->Trainer->exists($id)) {
            throw new NotFoundException(__('Invalid trainer'));
        }
        $options = array('conditions' => array('Trainer.' . $this->Trainer->primaryKey => $id));
        $this->set('trainer', $this->Trainer->find('first', $options));
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
            $this->request->data['Trainer']['system_table_id'] = $this->_get_system_table_id();
            $this->Trainer->create();
            if ($this->Trainer->save($this->request->data)) {

                $this->Session->setFlash(__('The trainer has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                {
                    if(isset($this->request->data['Trainer']['redirect']) && $this->request->data['Trainer']['redirect'] != '')
                    {
                        $this->redirect(array('controller'=>$this->request->data['Trainer']['redirect'],'action' => 'lists'));
                    }
                    else
                    {
                        $this->redirect(array('action' => 'view', $this->Trainer->id));
                    }
                }else{
                    if(isset($this->request->data['Trainer']['redirect']) && $this->request->data['Trainer']['redirect'] != ''){
                        $this->redirect(array('controller'=>$this->request->data['Trainer']['redirect'],'action' => 'lists'));
                    }else{
                        $this->redirect(array('action' => 'index'));
                    }

                }
            } else {
                $this->Session->setFlash(__('The trainer could not be saved. Please, try again.'));
            }
        }
        $trainerTypes = $this->Trainer->TrainerType->find('list', array('conditions' => array('TrainerType.publish' => 1, 'TrainerType.soft_delete' => 0)));
        $this->set(compact('trainerTypes','redirect'));
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
        if (!$this->Trainer->exists($id)) {
            throw new NotFoundException(__('Invalid trainer'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Trainer']['system_table_id'] = $this->_get_system_table_id();
            if ($this->Trainer->save($this->request->data)) {

                $this->Session->setFlash(__('The trainer has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The trainer could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Trainer.' . $this->Trainer->primaryKey => $id));
            $this->request->data = $this->Trainer->find('first', $options);
        }
        $trainerTypes = $this->Trainer->TrainerType->find('list', array('conditions' => array('TrainerType.publish' => 1, 'TrainerType.soft_delete' => 0)));
        $this->set(compact('trainerTypes'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->Trainer->exists($id)) {
            throw new NotFoundException(__('Invalid trainer'));
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
            $this->request->data['Trainer']['system_table_id'] = $this->_get_system_table_id();
            if ($this->Trainer->save($this->request->data)) {

                $this->Session->setFlash(__('The trainer has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The trainer could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Trainer.' . $this->Trainer->primaryKey => $id));
            $this->request->data = $this->Trainer->find('first', $options);
        }
        $trainerTypes = $this->Trainer->TrainerType->find('list', array('conditions' => array('TrainerType.publish' => 1, 'TrainerType.soft_delete' => 0)));
        $this->set(compact('trainerTypes'));
    }

}
