<?php

App::uses('AppController', 'Controller');

/**
 * CompetencyMappings Controller
 *
 * @property CompetencyMapping $CompetencyMapping
 */
class CompetencyMappingsController extends AppController {

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
        $this->paginate = array('order' => array('CompetencyMapping.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->CompetencyMapping->recursive = 0;
        $this->set('competencyMappings', $this->paginate());

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
                        $searchArray[] = array('CompetencyMapping.' . $search => $SearchKey);
                    else
                        $searchArray[] = array('CompetencyMapping.' . $search . ' like ' => '%' . $SearchKey . '%');
                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('CompetencyMapping.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['employee_id'] != -1) {
            $employeeConditions = array('CompetencyMapping.employee_id' => $this->request->query['employee_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $employeeConditions);
            else
                $conditions[] = array('or' => $employeeConditions);
        }
        if ($this->request->query['education_id'] != -1) {
            $educationConditions = array('CompetencyMapping.education_id' => $this->request->query['education_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $educationConditions);
            else
                $conditions[] = array('or' => $educationConditions);
        }

        if ($this->request->query['actual_education'] != -1) {
            $actualEducationConditions = array('CompetencyMapping.actual_education' => $this->request->query['actual_education']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $actualEducationConditions);
            else
                $conditions[] = array('or' => $actualEducationConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('CompetencyMapping.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'CompetencyMapping.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);

        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('CompetencyMapping.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('CompetencyMapping.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->CompetencyMapping->recursive = 0;
        $this->paginate = array('order' => array('CompetencyMapping.sr_no' => 'DESC'), 'conditions' => $conditions, 'CompetencyMapping.soft_delete' => 0);
        $this->set('competencyMappings', $this->paginate());

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
        if (!$this->CompetencyMapping->exists($id)) {
            throw new NotFoundException(__('Invalid competency mapping'));
        }
        $options = array('conditions' => array('CompetencyMapping.' . $this->CompetencyMapping->primaryKey => $id));
        $this->set('competencyMapping', $this->CompetencyMapping->find('first', $options));
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
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['CompetencyMapping']['system_table_id'] = $this->_get_system_table_id();
            $this->CompetencyMapping->create();
            if ($this->CompetencyMapping->save($this->request->data)) {
                $this->Session->setFlash(__('The competency mapping has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->CompetencyMapping->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The competency mapping could not be saved. Please, try again.'));
            }
        }
        $educations = $this->CompetencyMapping->Education->find('list', array('conditions' => array('Education.publish' => 1, 'Education.soft_delete' => 0)));
        $this->set(compact('educations'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->CompetencyMapping->exists($id)) {
            throw new NotFoundException(__('Invalid competency mapping'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['CompetencyMapping']['system_table_id'] = $this->_get_system_table_id();
            if ($this->CompetencyMapping->save($this->request->data)) {
                $this->Session->setFlash(__('The competency mapping has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The competency mapping could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CompetencyMapping.' . $this->CompetencyMapping->primaryKey => $id));
            $this->request->data = $this->CompetencyMapping->find('first', $options);
        }
        $educations = $this->CompetencyMapping->Education->find('list', array('conditions' => array('Education.publish' => 1, 'Education.soft_delete' => 0)));
        $this->set(compact('educations'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->CompetencyMapping->exists($id)) {
            throw new NotFoundException(__('Invalid competency mapping'));
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
            if ($this->CompetencyMapping->save($this->request->data)) {
                $this->Session->setFlash(__('The competency mapping has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

            } else {
                $this->Session->setFlash(__('The competency mapping could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CompetencyMapping.' . $this->CompetencyMapping->primaryKey => $id));
            $this->request->data = $this->CompetencyMapping->find('first', $options);
        }
        $educations = $this->CompetencyMapping->Education->find('list', array('conditions' => array('Education.publish' => 1, 'Education.soft_delete' => 0)));
        $this->set(compact('educations'));
    }

}
