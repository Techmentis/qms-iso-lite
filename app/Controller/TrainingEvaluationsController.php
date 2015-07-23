<?php

App::uses('AppController', 'Controller');

/**
 * TrainingEvaluations Controller
 *
 * @property TrainingEvaluation $TrainingEvaluation
 */
class TrainingEvaluationsController extends AppController {

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
        $this->paginate = array('order' => array('TrainingEvaluation.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->TrainingEvaluation->recursive = 0;
        $this->set('trainingEvaluations', $this->paginate());

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
                        $searchArray[] = array('TrainingEvaluation.' . $search => $searchKey);
                    else
                        $searchArray[] = array('TrainingEvaluation.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('TrainingEvaluation.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['training_id'] != -1) {
            $trainingEvaluationConditions = array('TrainingEvaluation.training_id' => $this->request->query['training_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $trainingEvaluationConditions);
            else
                $conditions[] = array('or' => $trainingEvaluationConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('TrainingEvaluation.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'TrainingEvaluation.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('TrainingEvaluation.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('TrainingEvaluation.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->TrainingEvaluation->recursive = 0;
        $this->paginate = array('order' => array('TrainingEvaluation.sr_no' => 'DESC'), 'conditions' => $conditions, 'TrainingEvaluation.soft_delete' => 0);
        $this->set('trainingEvaluations', $this->paginate());

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
        if (!$this->TrainingEvaluation->exists($id)) {
            throw new NotFoundException(__('Invalid training evaluation'));
        }
        $options = array('conditions' => array('TrainingEvaluation.' . $this->TrainingEvaluation->primaryKey => $id));
        $this->set('trainingEvaluation', $this->TrainingEvaluation->find('first', $options));
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
            $this->request->data['TrainingEvaluation']['system_table_id'] = $this->_get_system_table_id();
            $this->TrainingEvaluation->create();
            if ($this->TrainingEvaluation->save($this->request->data)) {

                $this->Session->setFlash(__('The training evaluation has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->TrainingEvaluation->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The training evaluation could not be saved. Please, try again.'));
            }
        }
        $trainings = $this->TrainingEvaluation->Training->find('list', array('conditions' => array('Training.publish' => 1, 'Training.soft_delete' => 0)));
        $this->set(compact('trainings'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->TrainingEvaluation->exists($id)) {
            throw new NotFoundException(__('Invalid training evaluation'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['TrainingEvaluation']['system_table_id'] = $this->_get_system_table_id();
            if ($this->TrainingEvaluation->save($this->request->data)) {

                $this->Session->setFlash(__('The training evaluation has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The training evaluation could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('TrainingEvaluation.' . $this->TrainingEvaluation->primaryKey => $id));
            $this->request->data = $this->TrainingEvaluation->find('first', $options);
        }
        $trainings = $this->TrainingEvaluation->Training->find('list', array('conditions' => array('Training.publish' => 1, 'Training.soft_delete' => 0)));
        $this->set(compact('trainings'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approval_id = null) {
        if (!$this->TrainingEvaluation->exists($id)) {
            throw new NotFoundException(__('Invalid training evaluation'));
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
            $this->request->data['TrainingEvaluation']['system_table_id'] = $this->_get_system_table_id();
            if ($this->TrainingEvaluation->save($this->request->data)) {

                $this->Session->setFlash(__('The training evaluation has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The training evaluation could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('TrainingEvaluation.' . $this->TrainingEvaluation->primaryKey => $id));
            $this->request->data = $this->TrainingEvaluation->find('first', $options);
        }
        $trainings = $this->TrainingEvaluation->Training->find('list', array('conditions' => array('Training.publish' => 1, 'Training.soft_delete' => 0)));
        $this->set(compact('trainings'));
    }

}
