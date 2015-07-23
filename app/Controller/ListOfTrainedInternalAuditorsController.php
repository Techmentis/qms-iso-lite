<?php

App::uses('AppController', 'Controller');

/**
 * ListOfTrainedInternalAuditors Controller
 *
 * @property ListOfTrainedInternalAuditor $ListOfTrainedInternalAuditor
 */
class ListOfTrainedInternalAuditorsController extends AppController {

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
        $this->paginate = array('order' => array('ListOfTrainedInternalAuditor.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->ListOfTrainedInternalAuditor->recursive = 0;
        $this->set('listOfTrainedInternalAuditors', $this->paginate());

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
                        $searchArray[] = array('ListOfTrainedInternalAuditor.' . $search => $searchKey);
                    else
                        $searchArray[] = array('ListOfTrainedInternalAuditor.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('ListOfTrainedInternalAuditor.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('or' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['employee_id'] != -1) {
            $employeeConditions[] = array('ListOfTrainedInternalAuditor.employee_id' => $this->request->query['employee_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $employeeConditions);
            else
                $conditions[] = array('or' => $employeeConditions);
        }
        if ($this->request->query['training_type_id'] != -1) {
            $trainingTypeConditions[] = array('ListOfTrainedInternalAuditor.training_id' => $this->request->query['training_type_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $trainingTypeConditionss);
            else
                $conditions[] = array('or' => $trainingTypeConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('ListOfTrainedInternalAuditor.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'ListOfTrainedInternalAuditor.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('ListOfTrainedInternalAuditor.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('ListOfTrainedInternalAuditor.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->ListOfTrainedInternalAuditor->recursive = 0;
        $this->paginate = array('order' => array('ListOfTrainedInternalAuditor.sr_no' => 'DESC'), 'conditions' => $conditions, 'ListOfTrainedInternalAuditor.soft_delete' => 0);
        $this->set('listOfTrainedInternalAuditors', $this->paginate());

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
        if (!$this->ListOfTrainedInternalAuditor->exists($id)) {
            throw new NotFoundException(__('Invalid list of trained internal auditor'));
        }
        $options = array('conditions' => array('ListOfTrainedInternalAuditor.' . $this->ListOfTrainedInternalAuditor->primaryKey => $id));
        $this->set('listOfTrainedInternalAuditor', $this->ListOfTrainedInternalAuditor->find('first', $options));
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
            $this->request->data['ListOfTrainedInternalAuditor']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['ListOfTrainedInternalAuditor']['created_by'] = $this->Session->read('User.id');
            $this->request->data['ListOfTrainedInternalAuditor']['modified_by'] = $this->Session->read('User.id');
            $this->ListOfTrainedInternalAuditor->create();
            if ($this->ListOfTrainedInternalAuditor->save($this->request->data, false)) {

                $this->Session->setFlash(__('The list of trained internal auditor has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->ListOfTrainedInternalAuditor->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The list of trained internal auditor could not be saved. Please, try again.'));
            }
        }
        $trainings = $this->ListOfTrainedInternalAuditor->Training->find('list', array('conditions' => array('Training.publish' => 1, 'Training.soft_delete' => 0)));
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
        if (!$this->ListOfTrainedInternalAuditor->exists($id)) {
            throw new NotFoundException(__('Invalid list of trained internal auditor'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['ListOfTrainedInternalAuditor']['system_table_id'] = $this->_get_system_table_id();
            if ($this->ListOfTrainedInternalAuditor->save($this->request->data)) {

                $this->Session->setFlash(__('The list of trained internal auditor has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The list of trained internal auditor could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ListOfTrainedInternalAuditor.' . $this->ListOfTrainedInternalAuditor->primaryKey => $id));
            $this->request->data = $this->ListOfTrainedInternalAuditor->find('first', $options);
        }
        $trainings = $this->ListOfTrainedInternalAuditor->Training->find('list', array('conditions' => array('Training.publish' => 1, 'Training.soft_delete' => 0)));
        $this->set(compact('trainings'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->ListOfTrainedInternalAuditor->exists($id)) {
            throw new NotFoundException(__('Invalid list of trained internal auditor'));
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
            if ($this->ListOfTrainedInternalAuditor->save($this->request->data)) {

                $this->Session->setFlash(__('The list of trained internal auditor has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The list of trained internal auditor could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ListOfTrainedInternalAuditor.' . $this->ListOfTrainedInternalAuditor->primaryKey => $id));
            $this->request->data = $this->ListOfTrainedInternalAuditor->find('first', $options);
        }
        $trainings = $this->ListOfTrainedInternalAuditor->Training->find('list', array('conditions' => array('Training.publish' => 1, 'Training.soft_delete' => 0)));
        $this->set(compact('trainings'));
    }
}
