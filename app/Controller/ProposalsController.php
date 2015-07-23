<?php

App::uses('AppController', 'Controller');

/**
 * Proposals Controller
 *
 * @property Proposal $Proposal
 */
class ProposalsController extends AppController {

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
        $this->paginate = array('order' => array('Proposal.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->Proposal->recursive = 0;
        $this->set('proposals', $this->paginate());

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
                        $searchArray[] = array('Proposal.' . $search => $searchKey);
                    else
                        $searchArray[] = array('Proposal.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('Proposal.branchid' => $branches);
            endforeach;

            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }

        if ($this->request->query['customer_id'] != -1) {
            $customerConditions = array('Proposal.customer_id' => $this->request->query['customer_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $customerConditions);
            else
                $conditions[] = array('or' => $customerConditions);
        }

        if ($this->request->query['employee_id'] != -1) {
            $employeeConditions = array('Proposal.employee_id' => $this->request->query['employee_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $employeeConditions);
            else
                $conditions[] = array('or' => $employeeConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('Proposal.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'Proposal.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('Proposal.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Proposal.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->Proposal->recursive = 0;
        $this->paginate = array('order' => array('Proposal.sr_no' => 'DESC'), 'conditions' => $conditions, 'Proposal.soft_delete' => 0);
        $this->set('proposals', $this->paginate());

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
        if (!$this->Proposal->exists($id)) {
            throw new NotFoundException(__('Invalid proposal'));
        }
        $this->loadModel('ProposalFollowup');
        $options = array('conditions' => array('Proposal.' . $this->Proposal->primaryKey => $id));
        $followups = $this->ProposalFollowup->find('all', array('conditions' => array('ProposalFollowup.proposal_id' => $id)));
        $this->set('proposal', $this->Proposal->find('first', $options));
        $this->set('followups', $followups);
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
            $this->request->data['Proposal']['system_table_id'] = $this->_get_system_table_id();
            $this->Proposal->create();
            if ($this->Proposal->save($this->request->data)) {

                $this->Session->setFlash(__('The proposal has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->Proposal->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The proposal could not be saved. Please, try again.'));
            }
        }
        $customers = $this->Proposal->Customer->find('list', array('conditions' => array('Customer.publish' => 1, 'Customer.soft_delete' => 0)));
        $this->set(compact('customers'));
     }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Proposal->exists($id)) {
            throw new NotFoundException(__('Invalid proposal'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Proposal']['system_table_id'] = $this->_get_system_table_id();
            if ($this->Proposal->save($this->request->data)) {

                $this->Session->setFlash(__('The proposal has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The proposal could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Proposal.' . $this->Proposal->primaryKey => $id));
            $this->request->data = $this->Proposal->find('first', $options);
        }
        $customers = $this->Proposal->Customer->find('list', array('conditions' => array('Customer.publish' => 1, 'Customer.soft_delete' => 0)));
        $employees = $this->Proposal->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $this->set(compact('customers', 'employees'));

    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->Proposal->exists($id)) {
            throw new NotFoundException(__('Invalid proposal'));
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
            if ($this->Proposal->save($this->request->data)) {

                $this->Session->setFlash(__('The proposal has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The proposal could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Proposal.' . $this->Proposal->primaryKey => $id));
            $this->request->data = $this->Proposal->find('first', $options);
        }
        $customers = $this->Proposal->Customer->find('list', array('conditions' => array('Customer.publish' => 1, 'Customer.soft_delete' => 0)));
        $employees = $this->Proposal->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $this->set(compact('customers', 'employees'));

    }

}
