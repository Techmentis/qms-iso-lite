<?php

App::uses('AppController', 'Controller');

/**
 * ListOfComputerListOfSoftwares Controller
 *
 * @property ListOfComputerListOfSoftware $ListOfComputerListOfSoftware
 */
class ListOfComputerListOfSoftwaresController extends AppController {

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
        $this->paginate = array('order' => array('ListOfComputerListOfSoftware.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->ListOfComputerListOfSoftware->recursive = 0;
        $this->set('listOfComputerListOfSoftwares', $this->paginate());

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
                        $searchArray[] = array('ListOfComputerListOfSoftware.' . $search => $searchKey);
                    else
                        $searchArray[] = array('ListOfComputerListOfSoftware.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }


        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('ListOfComputerListOfSoftware.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['list_of_computer'] != -1) {
            $computerConditions = array('ListOfComputerListOfSoftware.list_of_computer_id' => $this->request->query['list_of_computer']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $computerConditions);
            else
                $conditions[] = array('or' => $computerConditions);
        }
        if ($this->request->query['list_of_software'] != -1) {
                $softwareConditions = array('ListOfComputerListOfSoftware.list_of_software_id' => $this->request->query['list_of_software']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $softwareConditions);
            else
                $conditions[] = array('or' => $softwareConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('ListOfComputerListOfSoftware.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'ListOfComputerListOfSoftware.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);

        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('ListOfComputerListOfSoftware.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('ListOfComputerListOfSoftware.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->ListOfComputerListOfSoftware->recursive = 0;
        $this->paginate = array('order' => array('ListOfComputerListOfSoftware.sr_no' => 'DESC'), 'conditions' => $conditions, 'ListOfComputerListOfSoftware.soft_delete' => 0);
        $this->set('listOfComputerListOfSoftwares', $this->paginate());

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
        if (!$this->ListOfComputerListOfSoftware->exists($id)) {
            throw new NotFoundException(__('Invalid list of computer list of software'));
        }
        $options = array('conditions' => array('ListOfComputerListOfSoftware.' . $this->ListOfComputerListOfSoftware->primaryKey => $id));
        $this->set('listOfComputerListOfSoftware', $this->ListOfComputerListOfSoftware->find('first', $options));
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
            $time = $this->request->data['ListOfComputerListOfSoftware']['installation_date'];
            $this->request->data['ListOfComputerListOfSoftware']['installation_date'] = date('Y-m-d 00:00:00', strtotime($time));
            $this->request->data['ListOfComputerListOfSoftware']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['ListOfComputerListOfSoftware']['created_by'] = $this->Session->read('User.id');
            $this->request->data['ListOfComputerListOfSoftware']['modified_by'] = $this->Session->read('User.id');
            $this->request->data['ListOfComputerListOfSoftware']['created'] = date('Y-m-d H:i:s');
            $this->request->data['ListOfComputerListOfSoftware']['modified'] = date('Y-m-d H:i:s');
            $this->ListOfComputerListOfSoftware->create();
            if ($this->ListOfComputerListOfSoftware->save($this->request->data)) {

                $this->Session->setFlash(__('The list of computer list of software has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->ListOfComputerListOfSoftware->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The list of computer list of software could not be saved. Please, try again.'));
            }
        }
        $listOfComputers = $this->ListOfComputerListOfSoftware->ListOfComputer->find('list', array('conditions' => array('ListOfComputer.publish' => 1, 'ListOfComputer.soft_delete' => 0)));
        $listOfSoftwares = $this->ListOfComputerListOfSoftware->ListOfSoftware->find('list', array('conditions' => array('ListOfSoftware.publish' => 1, 'ListOfSoftware.soft_delete' => 0)));
        $this->set(compact('listOfComputers', 'listOfSoftwares'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->ListOfComputerListOfSoftware->exists($id)) {
            throw new NotFoundException(__('Invalid list of computer list of software'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $time = $this->request->data['ListOfComputerListOfSoftware']['installation_date'];
            $this->request->data['ListOfComputerListOfSoftware']['installation_date'] = date('Y-m-d 00:00:00', strtotime($time));
            $this->request->data['ListOfComputerListOfSoftware']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['ListOfComputerListOfSoftware']['modified_by'] = $this->Session->read('User.id');

            if ($this->ListOfComputerListOfSoftware->save($this->request->data)) {

                $this->Session->setFlash(__('The list of computer list of software has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The list of computer list of software could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ListOfComputerListOfSoftware.' . $this->ListOfComputerListOfSoftware->primaryKey => $id));
            $this->request->data = $this->ListOfComputerListOfSoftware->find('first', $options);
        }
        $listOfComputers = $this->ListOfComputerListOfSoftware->ListOfComputer->find('list', array('conditions' => array('ListOfComputer.publish' => 1, 'ListOfComputer.soft_delete' => 0)));
        $listOfSoftwares = $this->ListOfComputerListOfSoftware->ListOfSoftware->find('list', array('conditions' => array('ListOfSoftware.publish' => 1, 'ListOfSoftware.soft_delete' => 0)));
        $this->set(compact('listOfComputers', 'listOfSoftwares'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->ListOfComputerListOfSoftware->exists($id)) {
            throw new NotFoundException(__('Invalid list of computer list of software'));
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
            $time = $this->request->data['ListOfComputerListOfSoftware']['installation_date'];
            $this->request->data['ListOfComputerListOfSoftware']['installation_date'] = date('Y-m-d 00:00:00', strtotime($time));
            $this->request->data['ListOfComputerListOfSoftware']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['ListOfComputerListOfSoftware']['modified_by'] = $this->Session->read('User.id');

            if ($this->ListOfComputerListOfSoftware->save($this->request->data)) {

                $this->Session->setFlash(__('The list of computer list of software has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The list of computer list of software could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ListOfComputerListOfSoftware.' . $this->ListOfComputerListOfSoftware->primaryKey => $id));
            $this->request->data = $this->ListOfComputerListOfSoftware->find('first', $options);
        }
        $listOfComputers = $this->ListOfComputerListOfSoftware->ListOfComputer->find('list', array('conditions' => array('ListOfComputer.publish' => 1, 'ListOfComputer.soft_delete' => 0)));
        $listOfSoftwares = $this->ListOfComputerListOfSoftware->ListOfSoftware->find('list', array('conditions' => array('ListOfSoftware.publish' => 1, 'ListOfSoftware.soft_delete' => 0)));
        $this->set(compact('listOfComputers', 'listOfSoftwares'));
    }

}
