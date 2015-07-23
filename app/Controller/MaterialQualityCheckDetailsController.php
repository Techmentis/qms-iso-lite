<?php

App::uses('AppController', 'Controller');

/**
 * MaterialQualityCheckDetails Controller
 *
 * @property MaterialQualityCheckDetail $MaterialQualityCheckDetail
 */
class MaterialQualityCheckDetailsController extends AppController {

    public function _getSystemtableid() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $sys_id = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $this->request->params['controller'])));
        return $sys_id['SystemTable']['id'];
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {

        $conditions = $this->_check_request();
        $this->paginate = array('order' => array('MaterialQualityCheckDetail.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->MaterialQualityCheckDetail->recursive = 0;
        $this->set('materialQualityCheckDetails', $this->paginate());

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
            $search_array = array();
            $search_keys = explode(" ", $this->request->query['keywords']);

            foreach ($search_keys as $search_key):
                foreach ($this->request->query['search_fields'] as $search):
                    if ($this->request->query['strict_search'] == 0)
                        $search_array[] = array('MaterialQualityCheckDetail.' . $search => $search_key);
                    else
                        $search_array[] = array('MaterialQualityCheckDetail.' . $search . ' like ' => '%' . $search_key . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $search_array);
            else
                $conditions[] = array('or' => $search_array);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branch_conditions[] = array('MaterialQualityCheckDetail.branch_id' => $branches);
            endforeach;
            $conditions[] = array('or' => $branch_conditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('MaterialQualityCheckDetail.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'MaterialQualityCheckDetail.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('MaterialQualityCheckDetail.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('MaterialQualityCheckDetail.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->MaterialQualityCheckDetail->recursive = 0;
        $this->paginate = array('order' => array('MaterialQualityCheckDetail.sr_no' => 'DESC'), 'conditions' => $conditions, 'MaterialQualityCheckDetail.soft_delete' => 0);
        $this->set('materialQualityCheckDetails', $this->paginate());

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
        if (!$this->MaterialQualityCheckDetail->exists($id)) {
            throw new NotFoundException(__('Invalid material quality check detail'));
        }
        $options = array('conditions' => array('MaterialQualityCheckDetail.' . $this->MaterialQualityCheckDetail->primaryKey => $id));
        $this->set('materialQualityCheckDetail', $this->MaterialQualityCheckDetail->find('first', $options));
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
            $this->loadModel('User');
            $this->User->recursive = 0;
            $userids = $this->User->find('list', array('order' => array('User.name' => 'ASC'), 'conditions' => array('User.publish' => 1, 'User.soft_delete' => 0)));
            $this->set(array('userids' => $userids, 'show_approvals' => $this->_show_approvals()));
        }

        if ($this->request->is('post')) {
            $this->request->data['MaterialQualityCheckDetail']['system_table_id'] = $this->_getSystemtableid();
            $this->MaterialQualityCheckDetail->create();
            if ($this->MaterialQualityCheckDetail->save($this->request->data)) {

                if ($this->_show_approvals()) {
                    $this->loadModel('Approval');
                    $this->Approval->create();
                    $this->request->data['Approval']['model_name'] = 'MaterialQualityCheckDetail';
                    $this->request->data['Approval']['controller_name'] = $this->request->params['controller'];
                    $this->request->data['Approval']['user_id'] = $this->request->data['Approval']['user_id'];
                    $this->request->data['Approval']['from'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['created_by'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['modified_by'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['record'] = $this->MaterialQualityCheckDetail->id;
                    $this->Approval->save($this->request->data['Approval']);
                }
                $this->Session->setFlash(__('The material quality check detail has been saved'));
                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->MaterialQualityCheckDetail->id));
                else
                    $this->redirect(str_replace('/lists', '/add_ajax', $this->referer()));
            } else {
                $this->Session->setFlash(__('The material quality check detail could not be saved. Please, try again.'));
            }
        }
        $employees = $this->MaterialQualityCheckDetail->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $systemTables = $this->MaterialQualityCheckDetail->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $masterListOfFormats = $this->MaterialQualityCheckDetail->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0)));
        $companies = $this->MaterialQualityCheckDetail->Company->find('list', array('conditions' => array('Company.publish' => 1, 'Company.soft_delete' => 0)));
        $createdBies = $this->MaterialQualityCheckDetail->CreatedBy->find('list', array('conditions' => array('CreatedBy.publish' => 1, 'CreatedBy.soft_delete' => 0)));
        $modifiedBies = $this->MaterialQualityCheckDetail->ModifiedBy->find('list', array('conditions' => array('ModifiedBy.publish' => 1, 'ModifiedBy.soft_delete' => 0)));
        $this->set(compact('employees', 'systemTables', 'masterListOfFormats', 'companies', 'createdBies', 'modifiedBies'));
        $count = $this->MaterialQualityCheckDetail->find('count');
        $published = $this->MaterialQualityCheckDetail->find('count', array('conditions' => array('MaterialQualityCheckDetail.publish' => 1)));
        $unpublished = $this->MaterialQualityCheckDetail->find('count', array('conditions' => array('MaterialQualityCheckDetail.publish' => 0)));

        $this->set(compact('count', 'published', 'unpublished'));
    }

    /**
     *  *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->MaterialQualityCheckDetail->exists($id)) {
            throw new NotFoundException(__('Invalid material quality check detail'));
        }
        if ($this->_show_approvals()) {
            $this->loadModel('User');
            $this->User->recursive = 0;
            $userids = $this->User->find('list', array('order' => array('User.name' => 'ASC'), 'conditions' => array('User.publish' => 1, 'User.soft_delete' => 0)));
            $this->set(array('userids' => $userids, 'show_approvals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['MaterialQualityCheckDetail']['system_table_id'] = $this->_getSystemtableid();
            if ($this->MaterialQualityCheckDetail->save($this->request->data)) {
                if ($this->request->data['MaterialQualityCheckDetail']['publish'] == 0 && $this->_show_approvals()) {
                    $this->loadModel('Approval');
                    $approval_counts = $this->Approval->updateAll(array('Approval.status' => 1), array('AND' => array('Approval.model_name' => 'Branch', 'Approval.record' => $id, 'Approval.user_id' => $this->Session->read('User.id'), 'Approval.status' => 0)));

                    $this->Approval->create();
                    $this->request->data['Approval']['model_name'] = 'MaterialQualityCheckDetail';
                    $this->request->data['Approval']['controller_name'] = $this->request->params['controller'];
                    $this->request->data['Approval']['from'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['user_id'] = $this->request->data['Approval']['user_id'];
                    $this->request->data['Approval']['created_by'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['modified_by'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['branchid'] = $this->Session->read('User.branch_id');
                    $this->request->data['Approval']['departmentid'] = $this->Session->read('User.department_id');
                    $this->request->data['Approval']['record'] = $this->MaterialQualityCheckDetail->id;
                    $this->request->data['Approval']['status'] = 0;
                    $this->Approval->save($this->request->data['Approval']);

                    $this->Session->setFlash(__('The material quality check detail has been saved'));
                    if ($this->_show_evidence() == true)
                        $this->redirect(array('action' => 'view', $id));
                    else
                        $this->redirect(array('action' => 'index'));
                }else {
                    $this->loadModel('Approval');
                    if ($this->request->data['Approval']['user_id'] > -1 || !empty($this->request->data['Approval']['comments'])) {

                        $this->loadModel('Approval');
                        $this->Approval->create();
                        $this->request->data['Approval']['model_name'] = 'MaterialQualityCheckDetail';
                        $this->request->data['Approval']['controller_name'] = $this->request->params['controller'];
                        $this->request->data['Approval']['from'] = $this->Session->read('User.id');
                        $this->request->data['Approval']['user_id'] = $this->request->data['Approval']['user_id'];
                        $this->request->data['Approval']['created_by'] = $this->Session->read('User.id');
                        $this->request->data['Approval']['modified_by'] = $this->Session->read('User.id');
                        $this->request->data['Approval']['branchid'] = $this->Session->read('User.branch_id');
                        $this->request->data['Approval']['departmentid'] = $this->Session->read('User.department_id');
                        $this->request->data['Approval']['record'] = $this->MaterialQualityCheckDetail->id;
                        $this->request->data['Approval']['status'] = 2;
                        $this->Approval->save($this->request->data['Approval']);
                    } else {
                        $this->loadModel('Approval');
                        $approval_counts = $this->Approval->find(all, array('conditions' => array('Approval.model_name' => 'Branch', 'Approval.record' => $id, 'Approval.user_id' => $this->Session->read('User.id'), 'Approval.status !=' => 2)));
                        foreach ($approval_counts as $approval_count) {
                            $data['id'] = $approval_count['Approval']['id'];
                            $data['status'] = 2;
                            $this->Approval->save($data);
                        }
                    }
                    $this->Session->setFlash(__('The material quality check detail has been published'));
                    if ($this->_show_evidence() == true)
                        $this->redirect(array('action' => 'view', $id));
                    else
                        $this->redirect(array('action' => 'index'));
                }

                $this->Session->setFlash(__('The material quality check detail has been saved'));
                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The material quality check detail could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('MaterialQualityCheckDetail.' . $this->MaterialQualityCheckDetail->primaryKey => $id));
            $this->request->data = $this->MaterialQualityCheckDetail->find('first', $options);
        }
        $employees = $this->MaterialQualityCheckDetail->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $systemTables = $this->MaterialQualityCheckDetail->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $masterListOfFormats = $this->MaterialQualityCheckDetail->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0)));
        $companies = $this->MaterialQualityCheckDetail->Company->find('list', array('conditions' => array('Company.publish' => 1, 'Company.soft_delete' => 0)));
        $createdBies = $this->MaterialQualityCheckDetail->CreatedBy->find('list', array('conditions' => array('CreatedBy.publish' => 1, 'CreatedBy.soft_delete' => 0)));
        $modifiedBies = $this->MaterialQualityCheckDetail->ModifiedBy->find('list', array('conditions' => array('ModifiedBy.publish' => 1, 'ModifiedBy.soft_delete' => 0)));
        $this->set(compact('employees', 'systemTables', 'masterListOfFormats', 'companies', 'createdBies', 'modifiedBies'));
        $count = $this->MaterialQualityCheckDetail->find('count');
        $published = $this->MaterialQualityCheckDetail->find('count', array('conditions' => array('MaterialQualityCheckDetail.publish' => 1)));
        $unpublished = $this->MaterialQualityCheckDetail->find('count', array('conditions' => array('MaterialQualityCheckDetail.publish' => 0)));

        $this->set(compact('count', 'published', 'unpublished'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approval_id = null) {
        if (!$this->MaterialQualityCheckDetail->exists($id)) {
            throw new NotFoundException(__('Invalid material quality check detail'));
        }

        $this->loadModel('Approval');
        if (!$this->Approval->exists($approval_id)) {
            throw new NotFoundException(__('Invalid approval id'));
        }

        $approval = $this->Approval->read(null, $approval_id);
        $this->set('same', $approval['Approval']['user_id']);

        if ($this->_show_approvals()) {
            $this->loadModel('User');
            $this->User->recursive = 0;
            $userids = $this->User->find('list', array('order' => array('User.name' => 'ASC'), 'conditions' => array('User.publish' => 1, 'User.soft_delete' => 0)));
            $this->set(array('userids' => $userids, 'show_approvals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->MaterialQualityCheckDetail->save($this->request->data)) {
                if ($this->request->data['MaterialQualityCheckDetail']['publish'] == 0 && $this->_show_approvals()) {
                    $this->loadModel('Approval');
                    $this->Approval->create();
                    $this->request->data['Approval']['model_name'] = 'MaterialQualityCheckDetail';
                    $this->request->data['Approval']['controller_name'] = $this->request->params['controller'];
                    $this->request->data['Approval']['from'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['user_id'] = $this->request->data['Approval']['user_id'];
                    $this->request->data['Approval']['created_by'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['modified_by'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['record'] = $this->MaterialQualityCheckDetail->id;
                    $this->Approval->save($this->request->data['Approval']);

                    $this->Session->setFlash(__('The material quality check detail has been saved'));
                    if ($this->_show_evidence() == true)
                        $this->redirect(array('action' => 'view', $id));
                    else
                        $this->redirect(array('action' => 'index'));
                }else {
                    $this->Approval->read(null, $approval_id);
                    $data['Approval']['status'] = 'Approved';
                    $data['Approval']['modified_by'] = $this->Session->read('User.id');
                    $this->Approval->save($data);
                    $this->Session->setFlash(__('The branch has been published'));
                    if ($this->_show_evidence() == true)
                        $this->redirect(array('action' => 'view', $id));
                    else
                        $this->redirect(array('action' => 'index'));
                }
            } else {
                $this->Session->setFlash(__('The material quality check detail could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('MaterialQualityCheckDetail.' . $this->MaterialQualityCheckDetail->primaryKey => $id));
            $this->request->data = $this->MaterialQualityCheckDetail->find('first', $options);
        }
        $employees = $this->MaterialQualityCheckDetail->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $systemTables = $this->MaterialQualityCheckDetail->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $masterListOfFormats = $this->MaterialQualityCheckDetail->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0)));
        $companies = $this->MaterialQualityCheckDetail->Company->find('list', array('conditions' => array('Company.publish' => 1, 'Company.soft_delete' => 0)));
        $createdBies = $this->MaterialQualityCheckDetail->CreatedBy->find('list', array('conditions' => array('CreatedBy.publish' => 1, 'CreatedBy.soft_delete' => 0)));
        $modifiedBies = $this->MaterialQualityCheckDetail->ModifiedBy->find('list', array('conditions' => array('ModifiedBy.publish' => 1, 'ModifiedBy.soft_delete' => 0)));
        $this->set(compact('employees', 'systemTables', 'masterListOfFormats', 'companies', 'createdBies', 'modifiedBies'));
        $count = $this->MaterialQualityCheckDetail->find('count');
        $published = $this->MaterialQualityCheckDetail->find('count', array('conditions' => array('MaterialQualityCheckDetail.publish' => 1)));
        $unpublished = $this->MaterialQualityCheckDetail->find('count', array('conditions' => array('MaterialQualityCheckDetail.publish' => 0)));

        $this->set(compact('count', 'published', 'unpublished'));
    }

    public function add_quality_check($materialQCId = null, $deliveryChallanId = null, $materialId = null, $active_status = null) {

        if ($this->_show_approvals()) {
            $this->loadModel('User');
            $this->User->recursive = 0;
            $userids = $this->User->find('list', array('order' => array('User.name' => 'ASC'), 'conditions' => array('User.publish' => 1, 'User.soft_delete' => 0)));
            $this->set(array('userids' => $userids, 'show_approvals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data['MaterialQualityCheckDetail']['system_table_id'] = $this->_getSystemtableid();
            $this->request->data['MaterialQualityCheckDetail']['publish'] = 1;
            $this->MaterialQualityCheckDetail->create();

            if ($this->MaterialQualityCheckDetail->save($this->request->data, FALSE)) {

                $matID = $this->MaterialQualityCheckDetail->MaterialQualityCheck->find('first', array('conditions' => array('MaterialQualityCheck.soft_delete' => 0, 'MaterialQualityCheck.publish' => 1, 'MaterialQualityCheck.id' => $this->request->data['MaterialQualityCheckDetail']['material_quality_check_id']), 'fields' => array('MaterialQualityCheck.sr_no', 'MaterialQualityCheck.material_id'), 'recursive' => -1));

                $mcqIDs = $this->MaterialQualityCheckDetail->MaterialQualityCheck->find('list', array('conditions' => array('MaterialQualityCheck.soft_delete' => 0, 'MaterialQualityCheck.publish' => 1, 'MaterialQualityCheck.sr_no >' => $matID['MaterialQualityCheck']['sr_no'], 'MaterialQualityCheck.material_id' => $materialId), 'fields' => array('sr_no', 'MaterialQualityCheck.id'), 'recursive' => -1));

                //DELETE SUCCEEDING QC DETAIL RECORDS
                foreach ($mcqIDs as $mcqID):
                    $mcqDetailID = $this->MaterialQualityCheckDetail->find('first', array('conditions' => array('MaterialQualityCheckDetail.material_quality_check_id' => $mcqID, 'MaterialQualityCheckDetail.delivery_challan_id' => $deliveryChallanId), 'fields' => 'MaterialQualityCheckDetail.id', 'recursive' => -1));

                    if ($mcqDetailID['MaterialQualityCheckDetail']['id']) {
                        $this->MaterialQualityCheckDetail->delete($mcqDetailID['MaterialQualityCheckDetail']['id']);
                    }
                endforeach;

                if ($this->request->data['MaterialQualityCheckDetail']['publish'] == 0 && $this->_show_approvals()) {
                    $this->loadModel('Approval');
                    $approval_counts = $this->Approval->updateAll(array('Approval.status' => 1), array('AND' => array('Approval.model_name' => 'Branch', 'Approval.record' => $id, 'Approval.user_id' => $this->Session->read('User.id'), 'Approval.status' => 0)));

                    $this->Approval->create();
                    $this->request->data['Approval']['model_name'] = 'MaterialQualityCheckDetail';
                    $this->request->data['Approval']['controller_name'] = $this->request->params['controller'];
                    $this->request->data['Approval']['from'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['user_id'] = $this->request->data['Approval']['user_id'];
                    $this->request->data['Approval']['created_by'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['modified_by'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['branchid'] = $this->Session->read('User.branch_id');
                    $this->request->data['Approval']['departmentid'] = $this->Session->read('User.department_id');
                    $this->request->data['Approval']['record'] = $this->MaterialQualityCheckDetail->id;
                    $this->request->data['Approval']['status'] = 0;
                    $this->Approval->save($this->request->data['Approval']);

                    $this->Session->setFlash(__('The material quality check detail has been saved'));
                    if ($this->_show_evidence() == true)
                        $this->redirect(array('action' => 'view', $id));
                    else
                        $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
                }else {
                    $this->loadModel('Approval');
                    if ($this->request->data['Approval']['user_id'] > -1 || !empty($this->request->data['Approval']['comments'])) {

                        $this->loadModel('Approval');
                        $this->Approval->create();
                        $this->request->data['Approval']['model_name'] = 'MaterialQualityCheckDetail';
                        $this->request->data['Approval']['controller_name'] = $this->request->params['controller'];
                        $this->request->data['Approval']['from'] = $this->Session->read('User.id');
                        $this->request->data['Approval']['user_id'] = $this->request->data['Approval']['user_id'];
                        $this->request->data['Approval']['created_by'] = $this->Session->read('User.id');
                        $this->request->data['Approval']['modified_by'] = $this->Session->read('User.id');
                        $this->request->data['Approval']['branchid'] = $this->Session->read('User.branch_id');
                        $this->request->data['Approval']['departmentid'] = $this->Session->read('User.department_id');
                        $this->request->data['Approval']['record'] = $this->MaterialQualityCheckDetail->id;
                        $this->request->data['Approval']['status'] = 2;
                        $this->Approval->save($this->request->data['Approval']);
                    } else {
                        $this->loadModel('Approval');
                        $approval_counts = $this->Approval->find('all', array('conditions' => array('Approval.model_name' => 'Branch', 'Approval.record' => $id, 'Approval.user_id' => $this->Session->read('User.id'), 'Approval.status !=' => 2)));
                        foreach ($approval_counts as $approval_count) {
                            $data['id'] = $approval_count['Approval']['id'];
                            $data['status'] = 2;
                            $this->Approval->save($data);
                        }
                    }
                    $this->Session->setFlash(__('The material quality check detail has been saved.'));
                    $this->redirect(array('controller' => 'material_quality_checks', 'action' => 'quality_check', $deliveryChallanId, $materialId));
                }

                $this->Session->setFlash(__('The material quality check detail has been saved'));

                $this->redirect(array('controller' => 'material_quality_checks', 'action' => 'quality_check', $deliveryChallanId, $materialId));
            } else {
                $this->Session->setFlash(__('The material quality check detail could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('MaterialQualityCheckDetail.' . $this->MaterialQualityCheckDetail->primaryKey => $id));
            $this->request->data = $this->MaterialQualityCheckDetail->find('first', $options);
        }


        $materialQualityChecks = $this->MaterialQualityCheckDetail->MaterialQualityCheck->find('first', array('conditions' => array('MaterialQualityCheck.publish' => 1, 'MaterialQualityCheck.soft_delete' => 0, 'MaterialQualityCheck.id' => $materialQCId), 'fields' => array('MaterialQualityCheck.id', 'MaterialQualityCheck.name', 'MaterialQualityCheck.details', 'Material.id', 'Material.name')));
        $deliveryChallan = $this->MaterialQualityCheckDetail->DeliveryChallan->find('first', array('conditions' => array('DeliveryChallan.publish' => 1, 'DeliveryChallan.soft_delete' => 0, 'DeliveryChallan.id' => $deliveryChallanId), 'fields' => array('DeliveryChallan.id', 'DeliveryChallan.name'), 'recursive' => -1));
        $materialQualityCheckDetail = $this->MaterialQualityCheckDetail->find('first', array('conditions' => array('MaterialQualityCheckDetail.publish' => 1, 'MaterialQualityCheckDetail.soft_delete' => 0, 'MaterialQualityCheckDetail.material_quality_check_id' => $materialQCId, 'MaterialQualityCheckDetail.delivery_challan_id' => $deliveryChallanId), 'recursive' => -1));

        $this->loadModel('DeliveryChallanDetail');
        $deliveryChallanDetails = $this->DeliveryChallanDetail->find('all', array('conditions' => array('DeliveryChallanDetail.publish' => 1, 'DeliveryChallanDetail.soft_delete' => 0, 'DeliveryChallanDetail.delivery_challan_id' => $deliveryChallanId, 'DeliveryChallanDetail.material_id' => $materialId), 'fields' => array('DeliveryChallanDetail.quantity_received'), 'recursive' => -1));

        if (count($materialQualityCheckDetail))
            $qtyRecd = $materialQualityCheckDetail['MaterialQualityCheckDetail']['quantity_received'];
        else {
            $materialQualityCheckDetailLast = $this->MaterialQualityCheckDetail->find('first', array('conditions' => array('MaterialQualityCheckDetail.publish' => 1, 'MaterialQualityCheckDetail.soft_delete' => 0, 'MaterialQualityCheck.material_id' => $materialQualityChecks['Material']['id'], 'MaterialQualityCheckDetail.delivery_challan_id' => $deliveryChallanId), 'recursive' => 0, 'order' => array('MaterialQualityCheckDetail.sr_no' => 'DESC')));
            if (count($materialQualityCheckDetailLast)) {
                $qtyRecd = $materialQualityCheckDetailLast['MaterialQualityCheckDetail']['quantity_accepted'];
            } else {
                $qtyRecd = 0;
                foreach ($deliveryChallanDetails as $deliveryChallanDetail):
                    $qtyRecd += $deliveryChallanDetail['DeliveryChallanDetail']['quantity_received'];
                endforeach;
            }
        }

        $this->set(compact('materialQualityChecks', 'deliveryChallan', 'qtyRecd', 'materialQualityCheckDetail', 'active_status'));
    }

    public function add_to_stock($materialId = null, $deliveryChallanId = null) {

        if ($this->_show_approvals()) {
            $this->loadModel('User');
            $this->User->recursive = 0;
            $userids = $this->User->find('list', array('order' => array('User.name' => 'ASC'), 'conditions' => array('User.publish' => 1, 'User.soft_delete' => 0)));
            $this->set(array('userids' => $userids, 'show_approvals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $deliveryChallan = $this->MaterialQualityCheckDetail->DeliveryChallan->find('first', array('conditions' => array('DeliveryChallan.publish' => 1, 'DeliveryChallan.soft_delete' => 0, 'DeliveryChallan.id' => $this->request->data['MaterialQualityCheckDetail']['delivery_challan_id'])));

            $materialQualityCheckDetails = $this->MaterialQualityCheckDetail->find('first', array('conditions' => array('MaterialQualityCheckDetail.publish' => 1, 'MaterialQualityCheckDetail.soft_delete' => 0, 'MaterialQualityCheckDetail.delivery_challan_id' => $deliveryChallanId, 'MaterialQualityCheck.material_id' => $materialId), 'recursive' => 0, 'order' => array('MaterialQualityCheckDetail.sr_no' => 'desc')));

            $this->loadModel('Stock');
            $this->Stock->create();
            $data['type'] = 1;
            $data['material_id'] = $this->request->data['MaterialQualityCheckDetail']['material_id'];
            $data['supplier_registration_id'] = $materialQualityCheckDetails['DeliveryChallan']['supplier_registration_id'];
            $data['purchase_order_id'] = $materialQualityCheckDetails['DeliveryChallan']['purchase_order_id'];
            $data['delivery_challan_id'] = $this->request->data['MaterialQualityCheckDetail']['delivery_challan_id'];
            $data['received_date'] = $materialQualityCheckDetails['MaterialQualityCheckDetail']['check_performed_date'];
            $data['quantity'] = $materialQualityCheckDetails['MaterialQualityCheckDetail']['quantity_accepted'];
            $data['branch_id'] = $this->Session->read('User.branch_id');
            $data['remarks'] = $this->request->data['MaterialQualityCheckDetail']['remarks'];
            $data['publish'] = 1;
            if ($this->Stock->save($data)) {
                if($data['supplier_registration_id'] != ''){
                    $this->loadModel('SupplierEvaluationReevaluation');
                    $SupplierEvaluationId = $this->SupplierEvaluationReevaluation->find('first',array('fields'=>'id','conditions'=>array('SupplierEvaluationReevaluation.delivery_challan_id'=>$deliveryChallanId,'SupplierEvaluationReevaluation.material_id'=>$materialId)));
                    $quantityAccepted =$this->request->data['MaterialQualityCheckDetail']['totalAccepted'];
                    $remark =$this->request->data['MaterialQualityCheckDetail']['remarks'];
                    $this->SupplierEvaluationReevaluation->id = $SupplierEvaluationId['SupplierEvaluationReevaluation']['id'];
                    $this->SupplierEvaluationReevaluation->set(array('quantity_accepted'=>$quantityAccepted,'remarks'=>$remark,'publish'=>1));
                    $this->SupplierEvaluationReevaluation->save();
                    $this->Session->setFlash(__('Material has been added to stock and Supplier is Evaluated'));
                    $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
                }else{
                    $this->Session->setFlash(__('Material has been added to stock..'));
                    $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
                }
            } else {
                $this->Session->setFlash(__('Material could not be added to stock. Please try again.'));
            }
        } else {
            $options = array('conditions' => array('MaterialQualityCheckDetail.' . $this->MaterialQualityCheckDetail->primaryKey => $id));
            $this->request->data = $this->MaterialQualityCheckDetail->find('first', $options);
        }

        $deliveryChallan = $this->MaterialQualityCheckDetail->DeliveryChallan->find('first', array('conditions' => array('DeliveryChallan.publish' => 1, 'DeliveryChallan.soft_delete' => 0, 'DeliveryChallan.id' => $deliveryChallanId), 'fields' => array('DeliveryChallan.id', 'DeliveryChallan.name')));

        $this->loadModel('Material');
        $material = $this->Material->find('first', array('conditions' => array('Material.publish' => 1, 'Material.soft_delete' => 0, 'Material.id' => $materialId), 'fields' => array('Material.id', 'Material.name')));

        $materialQualityCheckDetails = $this->MaterialQualityCheckDetail->find('all', array('conditions' => array('MaterialQualityCheckDetail.publish' => 1, 'MaterialQualityCheckDetail.soft_delete' => 0, 'MaterialQualityCheckDetail.delivery_challan_id' => $deliveryChallanId, 'MaterialQualityCheck.material_id' => $materialId), 'recursive' => 0, 'order' => array('MaterialQualityCheckDetail.sr_no' => 'asc')));
        $materialQualityCheckCount = $this->MaterialQualityCheckDetail->MaterialQualityCheck->find('count', array('conditions' => array('MaterialQualityCheck.publish' => 1, 'MaterialQualityCheck.soft_delete' => 0, 'MaterialQualityCheck.material_id' => $materialId), 'recursive' => -1));
        $employees = $this->MaterialQualityCheckDetail->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));

        $this->set(compact('employees', 'material', 'deliveryChallan', 'materialQualityCheckDetails', 'materialQualityCheckCount'));
    }

}
