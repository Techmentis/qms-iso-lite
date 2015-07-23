<?php

App::uses('AppController', 'Controller');

/**
 * SupplierRegistrations Controller
 *
 * @property SupplierRegistration $SupplierRegistration
 */
class SupplierRegistrationsController extends AppController {

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
        $this->paginate = array('order' => array('SupplierRegistration.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->SupplierRegistration->recursive = 0;
        $this->set('supplierRegistrations', $this->paginate());

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
                        $searchArray[] = array('SupplierRegistration.' . $search => $searchKey);
                    else
                        $searchArray[] = array('SupplierRegistration.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }
        if ($this->request->query['company_type']) {
            foreach ($this->request->query['company_type'] as $companyType):
                $companyTypeConditions[] = array('SupplierRegistration.type_of_company' => $companyType);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $companyTypeConditions);
            else
                $conditions[] = array('or' => $companyTypeConditions);
        }
        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('SupplierRegistration.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['office_weekly_off']) {

            $officeWeeklyOff = implode(", ", $this->request->query['office_weekly_off']);
            $officeWeeklyOffConditions[] = array('SupplierRegistration.office_weekly_off' => $officeWeeklyOff);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $officeWeeklyOffConditions));
            else
                $conditions[] = array('or' => $officeWeeklyOffConditions);
        }
        if ($this->request->query['work_weekly_off']) {

            $workWeeklyOff = implode(", ", $this->request->query['work_weekly_off']);
            $workWeeklyOffConditions[] = array('SupplierRegistration.work_weekly_off' => $workWeeklyOff);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $workWeeklyOffConditions));
            else
                $conditions[] = array('or' => $workWeeklyOffConditions);
        }
        if ($this->request->query['iso_certified'] != '') {
            $isoCertifiedConditions[] = array('SupplierRegistration.iso_certified' => $this->request->query['iso_certified']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $isoCertifiedConditions);
            else
                $conditions[] = array('or' => $isoCertifiedConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('SupplierRegistration.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'SupplierRegistration.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);

        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('SupplierRegistration.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('SupplierRegistration.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->SupplierRegistration->recursive = 0;
        $this->paginate = array('order' => array('SupplierRegistration.sr_no' => 'DESC'), 'conditions' => $conditions, 'SupplierRegistration.soft_delete' => 0);
        $this->set('supplierRegistrations', $this->paginate());

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
        if (!$this->SupplierRegistration->exists($id)) {
            throw new NotFoundException(__('Invalid supplier registration'));
        }
        $options = array('conditions' => array('SupplierRegistration.' . $this->SupplierRegistration->primaryKey => $id));
        $this->set('supplierRegistration', $this->SupplierRegistration->find('first', $options));
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
            $this->request->data['SupplierRegistration']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['SupplierRegistration']['office_weekly_off'] = implode(", ", $this->request->data['office_weekly_off']);
            if(isset($this->request->data['work_weekly_off']))
            $this->request->data['SupplierRegistration']['work_weekly_off'] = implode(", ", $this->request->data['work_weekly_off']);
            $this->SupplierRegistration->create();

            if ($this->SupplierRegistration->save($this->request->data)) {
                if ($this->request->data['SupplierRegistration']['supplier_selected'] == 1) {
                    $this->loadModel('ListOfAcceptableSupplier');
                    $this->ListOfAcceptableSupplier->create();
                    $newData['ListOfAcceptableSupplier']['supplier_registration_id'] = $this->SupplierRegistration->id;
                    $newData['ListOfAcceptableSupplier']['supplier_category_id'] = $this->request->data['SupplierRegistration']['supplier_category_id'];
                    $newData['ListOfAcceptableSupplier']['remarks'] = $this->request->data['SupplierRegistration']['remarks'];
                    $newData['ListOfAcceptableSupplier']['publish'] = $this->request->data['SupplierRegistration']['publish'];
                    $newData['ListOfAcceptableSupplier']['created_by'] = $this->Session->read('User.id');
                    $newData['ListOfAcceptableSupplier']['modified_by'] = $this->Session->read('User.id');
                    $newData['ListOfAcceptableSupplier']['prepared_by'] = $this->request->data['SupplierRegistration']['prepared_by'];
                    $newData['ListOfAcceptableSupplier']['approved_by'] = $this->request->data['SupplierRegistration']['approved_by'];
                    $newData['ListOfAcceptableSupplier']['soft_delete'] = 0;
                    $this->ListOfAcceptableSupplier->save($newData['ListOfAcceptableSupplier']);
                }

                $this->Session->setFlash(__('The supplier registration has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->SupplierRegistration->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The supplier registration could not be saved. Please, try again.'));
            }
        }

        $companyTypes = array('Sole Proprietorship' => 'Sole Proprietorship', 'HUF' => 'HUF', 'Chartered Company' => 'Chartered Company', 'Statutory Company' => 'Statutory Company', 'Registered Company' => 'Registered Company', 'Limited Liability Company' => 'Limited Liability Company', 'Unlimited Liability Company' => 'Unlimited Liability Company', 'Private Limited Company' => 'Private Limited Company', 'Private Limited Company' => 'Private Limited Company', 'Public Limited Company' => 'Public Limited Company', 'Holding Company' => 'Holding Company', 'Subsidiary Company' => 'Subsidiary Company', 'Government Company' => 'Government Company', 'Non-Government Company' => 'Non-Government Company', 'Foreign Company' => 'Foreign Company');
        $weekDays = array('Monday' => 'Monday', 'Tuesday' => 'Tuesday', 'Wednesday' => 'Wednesday', 'Thursday' => 'Thursday', 'Friday' => 'Friday', 'Saturday' => 'Saturday', 'Sunday' => 'Sunday');
        $this->loadModel('SupplierCategory');
        $supplierCategories = $this->SupplierCategory->find('list', array('SupplierCategory.publish' => 1, 'SupplierCategory.soft_delete' => 0));

        $this->set(compact('supplierCategories', 'weekDays', 'companyTypes'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->SupplierRegistration->exists($id)) {
            throw new NotFoundException(__('Invalid supplier registration'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['SupplierRegistration']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['SupplierRegistration']['office_weekly_off'] = implode(", ", $this->request->data['office_weekly_off']);
            if(isset($this->request->data['work_weekly_off']))
            $this->request->data['SupplierRegistration']['work_weekly_off'] = implode(", ", $this->request->data['work_weekly_off']);

            if ($this->SupplierRegistration->save($this->request->data)) {

                $this->loadModel('ListOfAcceptableSupplier');
                $supplier = $this->ListOfAcceptableSupplier->find('first', array('conditions' => array('ListOfAcceptableSupplier.supplier_registration_id' => $id)));
                if($this->request->data['SupplierRegistration']['supplier_selected'] == 0 || $this->request->data['SupplierRegistration']['supplier_selected'] == 2){
                    if(isset($supplier) && $supplier != null){
                        $this->ListOfAcceptableSupplier->delete($supplier['ListOfAcceptableSupplier']['id']);
                    }
                }
                if ($this->request->data['SupplierRegistration']['supplier_selected'] == 1) {
                    if(isset($supplier) && $supplier != null){
                        $this->ListOfAcceptableSupplier->delete($supplier['ListOfAcceptableSupplier']['id']);
                        $this->ListOfAcceptableSupplier->create();
                        $newData['ListOfAcceptableSupplier']['supplier_registration_id'] = $id;
                        $newData['ListOfAcceptableSupplier']['supplier_category_id'] = $this->request->data['SupplierRegistration']['supplier_category_id'];
                        $newData['ListOfAcceptableSupplier']['prepared_by'] = $this->request->data['SupplierRegistration']['prepared_by'];
                        $newData['ListOfAcceptableSupplier']['approved_by'] = $this->request->data['SupplierRegistration']['approved_by'];
                        $newData['ListOfAcceptableSupplier']['remarks'] = $this->request->data['SupplierRegistration']['remarks'];
                        $this->ListOfAcceptableSupplier->save($newData['ListOfAcceptableSupplier'], true);
                    }else{
                        $this->ListOfAcceptableSupplier->create();
                    $newData['ListOfAcceptableSupplier']['supplier_registration_id'] = $id;
                    $newData['ListOfAcceptableSupplier']['supplier_category_id'] = $this->request->data['SupplierRegistration']['supplier_category_id'];
                    $newData['ListOfAcceptableSupplier']['remarks'] = $this->request->data['SupplierRegistration']['remarks'];
                    $newData['ListOfAcceptableSupplier']['publish'] = $this->request->data['SupplierRegistration']['publish'];
                    $newData['ListOfAcceptableSupplier']['created_by'] = $this->Session->read('User.id');
                    $newData['ListOfAcceptableSupplier']['modified_by'] = $this->Session->read('User.id');
                    $newData['ListOfAcceptableSupplier']['prepared_by'] = $this->request->data['SupplierRegistration']['prepared_by'];
                    $newData['ListOfAcceptableSupplier']['approved_by'] = $this->request->data['SupplierRegistration']['approved_by'];
                    $newData['ListOfAcceptableSupplier']['soft_delete'] = 0;
                    $this->ListOfAcceptableSupplier->save($newData['ListOfAcceptableSupplier']);
                    }
                }
                $this->Session->setFlash(__('The supplier registration has been saved'));
                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The supplier registration could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('SupplierRegistration.' . $this->SupplierRegistration->primaryKey => $id));
            $this->request->data = $this->SupplierRegistration->find('first', $options);
       }

        $companyTypes = array('Sole Proprietorship' => 'Sole Proprietorship', 'HUF' => 'HUF', 'Chartered Company' => 'Chartered Company', 'Statutory Company' => 'Statutory Company', 'Registered Company' => 'Registered Company', 'Limited Liability Company' => 'Limited Liability Company', 'Unlimited Liability Company' => 'Unlimited Liability Company', 'Private Limited Company' => 'Private Limited Company', 'Private Limited Company' => 'Private Limited Company', 'Public Limited Company' => 'Public Limited Company', 'Holding Company' => 'Holding Company', 'Subsidiary Company' => 'Subsidiary Company', 'Government Company' => 'Government Company', 'Non-Government Company' => 'Non-Government Company', 'Foreign Company' => 'Foreign Company');
        $weekDays = array('Monday' => 'Monday', 'Tuesday' => 'Tuesday', 'Wednesday' => 'Wednesday', 'Thursday' => 'Thursday', 'Friday' => 'Friday', 'Saturday' => 'Saturday', 'Sunday' => 'Sunday');

        $selectedOfficeWeek = explode(", ", $this->request->data['SupplierRegistration']['office_weekly_off']);
        $selectedWorkWeek = explode(", ", $this->request->data['SupplierRegistration']['work_weekly_off']);
        $this->loadModel('SupplierCategory');
        $supplierCategories = $this->SupplierCategory->find('list', array('SupplierCategory.publish' => 1, 'SupplierCategory.soft_delete' => 0));
        $this->loadModel('ListOfAcceptableSupplier');
        $listOfAcceptableSupplier = $this->ListOfAcceptableSupplier->find('first', array('conditions' => array('ListOfAcceptableSupplier.publish' => 1, 'ListOfAcceptableSupplier.soft_delete' => 0, 'ListOfAcceptableSupplier.supplier_registration_id' => $id), 'recursive' => -1));
        if (count($listOfAcceptableSupplier['ListOfAcceptableSupplier'])) {
            $this->request->data['SupplierRegistration']['supplier_category_id'] = $listOfAcceptableSupplier['ListOfAcceptableSupplier']['supplier_category_id'];
            $this->request->data['SupplierRegistration']['remarks'] = $listOfAcceptableSupplier['ListOfAcceptableSupplier']['remarks'];
        }
        $this->set(compact('supplierCategories', 'weekDays', 'companyTypes', 'selectedOfficeWeek', 'selectedWorkWeek', 'listOfAcceptableSupplier'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {

        if (!$this->SupplierRegistration->exists($id)) {
            throw new NotFoundException(__('Invalid supplier registration'));
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
            $this->request->data['SupplierRegistration']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['SupplierRegistration']['office_weekly_off'] = implode(", ", $this->request->data['office_weekly_off']);
            if(isset($this->request->data['work_weekly_off']))
            $this->request->data['SupplierRegistration']['work_weekly_off'] = implode(", ", $this->request->data['work_weekly_off']);

            if ($this->SupplierRegistration->save($this->request->data)) {

                $this->loadModel('ListOfAcceptableSupplier');
                $supplier = $this->ListOfAcceptableSupplier->find('first', array('conditions' => array('ListOfAcceptableSupplier.supplier_registration_id' => $id)));
                if($this->request->data['SupplierRegistration']['supplier_selected'] == 0 || $this->request->data['SupplierRegistration']['supplier_selected'] == 2){
                    if(isset($supplier) && $supplier != null){
                        $this->ListOfAcceptableSupplier->delete($supplier['ListOfAcceptableSupplier']['id']);
                    }
                }
                if ($this->request->data['SupplierRegistration']['supplier_selected'] == 1) {
                    if(isset($supplier) && $supplier != null){
                        $this->ListOfAcceptableSupplier->delete($supplier['ListOfAcceptableSupplier']['id']);
                        $this->ListOfAcceptableSupplier->create();
                        $newData['ListOfAcceptableSupplier']['supplier_registration_id'] = $id;
                        $newData['ListOfAcceptableSupplier']['supplier_category_id'] = $this->request->data['SupplierRegistration']['supplier_category_id'];
                        $newData['ListOfAcceptableSupplier']['prepared_by'] = $this->request->data['SupplierRegistration']['prepared_by'];
                        $newData['ListOfAcceptableSupplier']['approved_by'] = $this->request->data['SupplierRegistration']['approved_by'];
                        $newData['ListOfAcceptableSupplier']['remarks'] = $this->request->data['SupplierRegistration']['remarks'];
                        $this->ListOfAcceptableSupplier->save($newData['ListOfAcceptableSupplier'], true);
                    }else{
                        $this->ListOfAcceptableSupplier->create();
                    $newData['ListOfAcceptableSupplier']['supplier_registration_id'] = $id;
                    $newData['ListOfAcceptableSupplier']['supplier_category_id'] = $this->request->data['SupplierRegistration']['supplier_category_id'];
                    $newData['ListOfAcceptableSupplier']['remarks'] = $this->request->data['SupplierRegistration']['remarks'];
                    $newData['ListOfAcceptableSupplier']['publish'] = $this->request->data['SupplierRegistration']['publish'];
                    $newData['ListOfAcceptableSupplier']['created_by'] = $this->Session->read('User.id');
                    $newData['ListOfAcceptableSupplier']['modified_by'] = $this->Session->read('User.id');
                    $newData['ListOfAcceptableSupplier']['prepared_by'] = $this->request->data['SupplierRegistration']['prepared_by'];
                    $newData['ListOfAcceptableSupplier']['approved_by'] = $this->request->data['SupplierRegistration']['approved_by'];
                    $newData['ListOfAcceptableSupplier']['soft_delete'] = 0;
                    $this->ListOfAcceptableSupplier->save($newData['ListOfAcceptableSupplier']);
                    }
                }

                $this->Session->setFlash(__('The supplier registration has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The supplier registration could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('SupplierRegistration.' . $this->SupplierRegistration->primaryKey => $id));
            $this->request->data = $this->SupplierRegistration->find('first', $options);
        }
        $companyTypes = array('Sole Proprietorship' => 'Sole Proprietorship', 'HUF' => 'HUF', 'Chartered Company' => 'Chartered Company', 'Statutory Company' => 'Statutory Company', 'Registered Company' => 'Registered Company', 'Limited Liability Company' => 'Limited Liability Company', 'Unlimited Liability Company' => 'Unlimited Liability Company', 'Private Limited Company' => 'Private Limited Company', 'Private Limited Company' => 'Private Limited Company', 'Public Limited Company' => 'Public Limited Company', 'Holding Company' => 'Holding Company', 'Subsidiary Company' => 'Subsidiary Company', 'Government Company' => 'Government Company', 'Non-Government Company' => 'Non-Government Company', 'Foreign Company' => 'Foreign Company');
        $weekDays = array('Monday' => 'Monday', 'Tuesday' => 'Tuesday', 'Wednesday' => 'Wednesday', 'Thursday' => 'Thursday', 'Friday' => 'Friday', 'Saturday' => 'Saturday', 'Sunday' => 'Sunday');
        $selectedOfficeWeek = explode(", ", $this->request->data['SupplierRegistration']['office_weekly_off']);
        $selectedWorkWeek = explode(", ", $this->request->data['SupplierRegistration']['work_weekly_off']);

        $this->loadModel('SupplierCategory');
        $supplierCategories = $this->SupplierCategory->find('list', array('SupplierCategory.publish' => 1, 'SupplierCategory.soft_delete' => 0));

        $this->loadModel('ListOfAcceptableSupplier');
        $listOfAcceptableSupplier = $this->ListOfAcceptableSupplier->find('first', array('conditions' => array('ListOfAcceptableSupplier.publish' => 1, 'ListOfAcceptableSupplier.soft_delete' => 0, 'ListOfAcceptableSupplier.supplier_registration_id' => $id), 'recursive' => -1));
        if (count($listOfAcceptableSupplier['ListOfAcceptableSupplier'])) {
            $this->request->data['SupplierRegistration']['supplier_selected'] = 0;
            $this->request->data['SupplierRegistration']['supplier_category_id'] = $listOfAcceptableSupplier['ListOfAcceptableSupplier']['supplier_category_id'];
            $this->request->data['SupplierRegistration']['remarks'] = $listOfAcceptableSupplier['ListOfAcceptableSupplier']['remarks'];
        }

        $this->set(compact('supplierCategories', 'weekDays', 'companyTypes', 'selectedOfficeWeek', 'selectedWorkWeek', 'listOfAcceptableSupplier'));
    }

    public function get_supplier_registration_title($type = null, $value = null, $id = null) {
        if ($value) {
            if ($id) {
                $supplierRegistrations = $this->SupplierRegistration->find('all', array('conditions' => array('SupplierRegistration.'.$type => $value, 'SupplierRegistration.id !=' => $id)));
            } else {
                $supplierRegistrations = $this->SupplierRegistration->find('all', array('conditions' => array('SupplierRegistration.'.$type => $value)));
            }
            $this->set(compact('type','supplierRegistrations'));
        }
    }
}
