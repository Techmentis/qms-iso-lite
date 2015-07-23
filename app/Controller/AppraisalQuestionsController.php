<?php

App::uses('AppController', 'Controller');

/**
 * AppraisalQuestions Controller
 *
 * @property AppraisalQuestion $AppraisalQuestion
 */
class AppraisalQuestionsController extends AppController {

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
        $this->paginate = array('order' => array('AppraisalQuestion.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->AppraisalQuestion->recursive = 0;
        $this->set('appraisalQuestions', $this->paginate());

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
                        $searchArray[] = array('AppraisalQuestion.' . $search => $searchKey);
                    else
                        $searchArray[] = array('AppraisalQuestion.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $searchArray);
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('AppraisalQuestion.branchid' => $branches);
            endforeach;
            $conditions[] = array('or' => $branchConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('AppraisalQuestion.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'AppraisalQuestion.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
	
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('AppraisalQuestion.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('AppraisalQuestion.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->AppraisalQuestion->recursive = 0;
        $this->paginate = array('order' => array('AppraisalQuestion.sr_no' => 'DESC'), 'conditions' => $conditions, 'AppraisalQuestion.soft_delete' => 0);
        $this->set('appraisalQuestions', $this->paginate());

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
        if (!$this->AppraisalQuestion->exists($id)) {
            throw new NotFoundException(__('Invalid appraisal question'));
        }
        $options = array('conditions' => array('AppraisalQuestion.' . $this->AppraisalQuestion->primaryKey => $id));
        $this->set('appraisalQuestion', $this->AppraisalQuestion->find('first', $options));
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

            if(!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1){
                $this->request->data[$this->modelClass]['publish'] = 0;
            }

            $this->request->data['AppraisalQuestion']['system_table_id'] = $this->_get_system_table_id();
            $this->AppraisalQuestion->create();
            if ($this->AppraisalQuestion->save($this->request->data, false)) {
                $this->Session->setFlash(__('The appraisal question has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->AppraisalQuestion->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The appraisal question could not be saved. Please, try again.'));
            }
        }
    }

    /**
     *  *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->AppraisalQuestion->exists($id)) {
            throw new NotFoundException(__('Invalid appraisal question'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {

            if(!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1){
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['AppraisalQuestion']['system_table_id'] = $this->_get_system_table_id();

            if ($this->AppraisalQuestion->save($this->request->data, false)) {
                $this->Session->setFlash(__('The appraisal question has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The appraisal question could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('AppraisalQuestion.' . $this->AppraisalQuestion->primaryKey => $id));
            $this->request->data = $this->AppraisalQuestion->find('first', $options);
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
        if (!$this->AppraisalQuestion->exists($id)) {
            throw new NotFoundException(__('Invalid appraisal question'));
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
            if ($this->AppraisalQuestion->save($this->request->data, false)) {
                $this->Session->setFlash(__('The appraisal question has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals();

            } else {
                $this->Session->setFlash(__('The appraisal question could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('AppraisalQuestion.' . $this->AppraisalQuestion->primaryKey => $id));
            $this->request->data = $this->AppraisalQuestion->find('first', $options);
        }
    }

}