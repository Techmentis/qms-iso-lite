<?php

App::uses('AppController', 'Controller');

/**
 * SystemTables Controller
 *
 * @property SystemTable $SystemTable
 */
class SystemTablesController extends AppController {

    public $components = array('Ctrl');

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
        $this->paginate = array('order' => array('SystemTable.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->SystemTable->recursive = 0;
        $this->set('systemTables', $this->paginate());

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
                        $searchArray[] = array('SystemTable.' . $search => $searchKey);
                    else
                        $searchArray[] = array('SystemTable.' . $search . ' like ' => '%' . $searchKey . '%');
                endforeach;
            endforeach;

            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('SystemTable.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['evidence_required'] != '') {
            $evidenceRequiredConditions = array('SystemTable.evidence_required' => $this->request->query['evidence_required']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $evidenceRequiredConditions);
            else
                $conditions[] = array('or' => $evidenceRequiredConditions);
        }

        if ($this->request->query['approvals_required'] != '') {
            $approvalsRequiredConditions = array('SystemTable.approvals_required' => $this->request->query['approvals_required']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $approvalsRequiredConditions);
            else
                $conditions[] = array('or' => $approvalsRequiredConditions);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('SystemTable.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('SystemTable.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'SystemTable.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);

        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('SystemTable.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('SystemTable.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->SystemTable->recursive = 0;
        $this->paginate = array('order' => array('SystemTable.sr_no' => 'DESC'), 'conditions' => $conditions, 'SystemTable.soft_delete' => 0);
        $this->set('systemTables', $this->paginate());

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
        if (!$this->SystemTable->exists($id)) {
            throw new NotFoundException(__('Invalid system table'));
        }
        $options = array('conditions' => array('SystemTable.' . $this->SystemTable->primaryKey => $id));
        $this->set('systemTable', $this->SystemTable->find('first', $options));
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
            $this->request->data['SystemTable']['system_table_id'] = $this->_get_system_table_id();
            $this->SystemTable->create();
            if ($this->SystemTable->save($this->request->data)) {

                $this->Session->setFlash(__('The system table has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->SystemTable->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The system table could not be saved. Please, try again.'));
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
    public function inplace_edit_evidence() {

        $this->layout = "ajax";
        $this->SystemTable->read(null, $this->request->data['pk']);
        $data['SystemTable']['evidence_required'] = $this->request->data['value'];
        $this->SystemTable->save($data, false);
        exit;
    }

    public function inplace_edit_approval() {

        $this->layout = "ajax";
        $this->SystemTable->read(null, $this->request->data['pk']);
        $data['SystemTable']['approvals_required'] = $this->request->data['value'];
        $this->SystemTable->save($data, false);
        exit;
    }

    public function edit($id = null) {
        if (!$this->SystemTable->exists($id)) {
            throw new NotFoundException(__('Invalid system table'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['SystemTable']['system_table_id'] = $this->_get_system_table_id();
            if ($this->SystemTable->save($this->request->data)) {

                $this->Session->setFlash(__('The system table has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The system table could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('SystemTable.' . $this->SystemTable->primaryKey => $id));
            $this->request->data = $this->SystemTable->find('first', $options);
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
        if (!$this->SystemTable->exists($id)) {
            throw new NotFoundException(__('Invalid system table'));
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
            if ($this->SystemTable->save($this->request->data)) {

                $this->Session->setFlash(__('The system table could not be saved. Please, try again.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The system table could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('SystemTable.' . $this->SystemTable->primaryKey => $id));
            $this->request->data = $this->SystemTable->find('first', $options);
        }
    }

    public function add_all_tables() {
        $allControllers = $this->Ctrl->get();

        foreach ($allControllers as $key => $value):
            $this->SystemTable->create();
            $getName = str_replace('Controller', '', $key);
            $newData['SystemTable']['system_name'] = Inflector::tableize($getName);
            $newData['SystemTable']['name'] = Inflector::humanize($newData['SystemTable']['system_name']);
            $newData['SystemTable']['evidence_required'] = 1;
            $newData['SystemTable']['approvals_required'] = 1;
            $newData['SystemTable']['publish'] = 1;
            $newData['SystemTable']['soft_delete'] = 0;
            $newData['SystemTable']['branchid'] = '0941b9a8-2990-11e3-a528-d919ee611857';
            $newData['SystemTable']['departmentid'] = '522e3da7-8e48-4be2-ab9d-8545c6c3268c';
            $newData['SystemTable']['created_by'] = '54e5d056-199b-11e3-9f46-c709d410d2ec';
            $newData['SystemTable']['created'] = date('Y-m-d h:i:s');
            $newData['SystemTable']['modified_by'] = '54e5d056-199b-11e3-9f46-c709d410d2ec';
            $newData['SystemTable']['modified'] = date('Y-m-d h:i:s');
            $this->SystemTable->save($newData['SystemTable']);

        endforeach;
    }

    public function add_help() {

        $allControllers = $this->Ctrl->get();
        $this->loadModel('Help');
        foreach ($allControllers as $key => $value):

            $getName = str_replace('Controller', '', $key);

            if (Inflector::tableize($getName) != 'dashboards' && Inflector::tableize($getName) != 'errors' && Inflector::tableize($getName) != 'notificaion_types' && Inflector::tableize($getName) != 'pages') {
                $model = Inflector::classify($getName);
                $this->loadModel($model);
                $rules = $this->$model->validate;
                $var = null;

                foreach ($rules as $ruleKey => $ruleValue):

                    if (
                            $ruleKey != 'system_table_id' &&
                            $ruleKey != 'master_list_of_format_id' &&
                            $ruleKey != 'branchid' &&
                            $ruleKey != 'departmentid' &&
                            $ruleKey != 'modified_by' &&
                            $ruleKey != 'created_by' &&
                            $ruleKey != 'created' &&
                            $ruleKey != 'modified'
                    ) {
                        foreach ($ruleValue as $rule => $details):

                            if ($rule == 'notempty') {
                                $text = " is mandetory";
                                $var = $var . "<li><b>" . Inflector::humanize($ruleKey) . "</b> " . $text . "</li>";
                            }

                            if ($rule == 'uuid') {
                                $text = " is mandetory <br />";
                                $var = $var . "<li><b>" . str_replace('Id', '', str_replace(' id', '', Inflector::humanize($ruleKey))) . "</b> " . $text . "</li>";
                            }

                            if ($rule == 'date') {
                                $text = " is mandetory (date format is 'YYYY-MM-DD') <br />";
                                $var = $var . "<li><b>" . Inflector::humanize($ruleKey) . "</b> " . $text . "</li>";
                            }

                        endforeach;
                    }
                endforeach;
                $this->Help->create();
                $data['Help']['language_id'] = "366ac1f4-199b-11e3-9f46-c709d410d2ec";
                $data['Help']['title'] = "Mandetory Fields";
                $data['Help']['table_name'] = Inflector::camelize($getName);
                $data['Help']['action_name'] = "add_ajax";
                $data['Help']['help_text'] = "<ul>" . $var . "</ul>";
                $data['Help']['sequence'] = 0;
                $data['Help']['publish'] = 1;
                $data['Help']['soft_delete'] = 0;
                $this->Help->save($data);
            }
        endforeach;
    }
}
