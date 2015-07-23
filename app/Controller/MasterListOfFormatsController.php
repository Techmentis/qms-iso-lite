<?php

App::uses('AppController', 'Controller');

/**
 * MasterListOfFormats Controller
 *
 * @property MasterListOfFormat $MasterListOfFormat
 */
class MasterListOfFormatsController extends AppController {

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
        $this->paginate = array('order' => array('MasterListOfFormat.sr_no' => 'DESC'),
            'conditions' => array($conditions));

        $this->MasterListOfFormat->recursive = 0;

        $master_list_of_formats = $this->paginate();
        foreach ($master_list_of_formats as $key => $master_list_of_format) {
            $masterListOfFormatBranches = array();
            $masterListOfFormatBranches = $this->MasterListOfFormat->MasterListOfFormatBranch->find('all', array('conditions' => array('MasterListOfFormatBranch.master_list_of_format_id' => $master_list_of_format['MasterListOfFormat']['id'], 'MasterListOfFormatBranch.soft_delete' => 0, 'MasterListOfFormatBranch.publish' => 1), 'fields' => 'Branch.name', 'order' => array('Branch.name' => 'DESC')));

            $branches = array();
            foreach ($masterListOfFormatBranches as $masterListOfFormatBranch)
                if ($masterListOfFormatBranch['Branch']['name'])
                    $branches[] = $masterListOfFormatBranch['Branch']['name'];
            $master_list_of_formats[$key]['MasterListOfFormat']['Branches'] = implode(', ', $branches);

            $depts = array();
            $masterListOfFormatDepartments = $this->MasterListOfFormat->MasterListOfFormatDepartment->find('all', array('conditions' => array('MasterListOfFormatDepartment.master_list_of_format_id' => $master_list_of_format['MasterListOfFormat']['id'], 'MasterListOfFormatDepartment.soft_delete' => 0, 'MasterListOfFormatDepartment.publish' => 1), 'fields' => 'Department.name',
                'order' => array('Department.name' => 'DESC')));
            foreach ($masterListOfFormatDepartments as $masterListOfFormatDepartment)
                if ($masterListOfFormatDepartment['Department']['name'])
                    $depts[] = $masterListOfFormatDepartment['Department']['name'];
            $master_list_of_formats[$key]['MasterListOfFormat']['Departments'] = implode(', ', $depts);
        }
        $this->set('masterListOfFormats', $master_list_of_formats);

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
            if ($this->request->query['strict_search'] == 0) {
                $search_keys[] = $this->request->query['keywords'];
            } else {
                $search_keys = explode(" ", $this->request->query['keywords']);
            }

            foreach ($search_keys as $search_key):
                foreach ($this->request->query['search_fields'] as $search):
                    if ($this->request->query['strict_search'] == 0)
                        $search_array[] = array('MasterListOfFormat.' . $search => $search_key);
                    else
                        $search_array[] = array('MasterListOfFormat.' . $search . ' like ' => '%' . $search_key . '%');
                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $search_array));
            else
                $conditions[] = array('or' => $search_array);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branch_conditions[] = array('MasterListOfFormat.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branch_conditions));
            else
                $conditions[] = array('or' => $branch_conditions);
        }

        if ($this->request->query['department_id'] != -1) {
            $department_conditions[] = array('MasterListOfFormat.departmentid' => $this->request->query['department_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $department_conditions);
            else
                $conditions[] = array('or' => $department_conditions);
        }

        if ($this->request->query['archived'] != '') {
            $archived_conditions[] = array('MasterListOfFormat.archived' => $this->request->query['archived']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $archived_conditions);
            else
                $conditions[] = array('or' => $archived_conditions);
        }

        if ($this->request->query['system_id'] != -1) {
            $system_conditions[] = array('MasterListOfFormat.system_table_id' => $this->request->query['system_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $system_conditions);
            else
                $conditions[] = array('or' => $system_conditions);
        }

        if ($this->request->query['prepared_by'] != -1) {
            $preparedby_conditions[] = array('MasterListOfFormat.prepared_by' => $this->request->query['prepared_by']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $preparedby_conditions);
            else
                $conditions[] = array('or' => $preparedby_conditions);
        }

        if ($this->request->query['approved_by'] != -1) {
            $approver_conditions[] = array('MasterListOfFormat.approved_by' => $this->request->query['approved_by']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $approver_conditions);
            else
                $conditions[] = array('or' => $approver_conditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('MasterListOfFormat.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'MasterListOfFormat.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);

        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('MasterListOfFormat.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('MasterListOfFormat.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->MasterListOfFormat->recursive = 0;
        $this->paginate = array('order' => array('MasterListOfFormat.sr_no' => 'DESC'), 'conditions' => $conditions, 'MasterListOfFormat.soft_delete' => 0);

        $master_list_of_formats = $this->paginate();
        foreach ($master_list_of_formats as $key => $master_list_of_format) {
            $masterListOfFormatBranches = array();
            $masterListOfFormatBranches = $this->MasterListOfFormat->MasterListOfFormatBranch->find('all', array('conditions' => array('MasterListOfFormatBranch.master_list_of_format_id' => $master_list_of_format['MasterListOfFormat']['id'], 'MasterListOfFormatBranch.soft_delete' => 0, 'MasterListOfFormatBranch.publish' => 1), 'fields' => 'Branch.name', 'order' => array('Branch.name' => 'DESC')));

            $branches = array();
            foreach ($masterListOfFormatBranches as $masterListOfFormatBranch)
                if ($masterListOfFormatBranch['Branch']['name'])
                    $branches[] = $masterListOfFormatBranch['Branch']['name'];
            $master_list_of_formats[$key]['MasterListOfFormat']['Branches'] = implode(', ', $branches);

            $depts = array();
            $masterListOfFormatDepartments = $this->MasterListOfFormat->MasterListOfFormatDepartment->find('all', array('conditions' => array('MasterListOfFormatDepartment.master_list_of_format_id' => $master_list_of_format['MasterListOfFormat']['id'], 'MasterListOfFormatDepartment.soft_delete' => 0, 'MasterListOfFormatDepartment.publish' => 1), 'fields' => 'Department.name',
                'order' => array('Department.name' => 'DESC')));
            foreach ($masterListOfFormatDepartments as $masterListOfFormatDepartment)
                if ($masterListOfFormatDepartment['Department']['name'])
                    $depts[] = $masterListOfFormatDepartment['Department']['name'];
            $master_list_of_formats[$key]['MasterListOfFormat']['Departments'] = implode(', ', $depts);
        }
        $this->set('masterListOfFormats', $master_list_of_formats);

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
        if (!$this->MasterListOfFormat->exists($id)) {
            throw new NotFoundException(__('Invalid master list of format'));
        }
        $options = array('conditions' => array('MasterListOfFormat.' . $this->MasterListOfFormat->primaryKey => $id));
        $this->set('masterListOfFormat', $this->MasterListOfFormat->find('first', $options));
        $this->getRevisions($id);
    }

    /**
     * Gettting list of revisions
     *
     */
    public function getRevisions($id = null){

        $revisions = $this->MasterListOfFormat->DocumentAmendmentRecordSheet->find('all',array('conditions'=>
            array('DocumentAmendmentRecordSheet.master_list_of_format'=>$id),
            'fields'=>array(
                'DocumentAmendmentRecordSheet.id',
                'DocumentAmendmentRecordSheet.master_list_of_format',
                'DocumentAmendmentRecordSheet.document_number',
                'DocumentAmendmentRecordSheet.issue_number',
                'DocumentAmendmentRecordSheet.revision_number',
                'DocumentAmendmentRecordSheet.amendment_details',
                'DocumentAmendmentRecordSheet.reason_for_change',				
                'PreparedBy.name',
                'ApprovedBy.name',
                'MasterListOfFormatID.title')
            ));
        $this->set(compact('revisions'));
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

            $this->MasterListOfFormat->create();
            $this->request->data['MasterListOfFormat']['created_by'] = $this->Session->read('User.id');
            $this->request->data['MasterListOfFormat']['modified_by'] = $this->Session->read('User.id');
            if ($this->MasterListOfFormat->save($this->request->data)) {
                $this->_add_branches_and_departments(
					$this->request->data['MasterListOfFormatBranch_branch_id'], 
					$this->request->data['MasterListOfFormatDepartment_department_id'], 
					$this->request->data['MasterListOfFormat']['system_table_id'], 
					$this->MasterListOfFormat->id, 
					1,
					$this->request->data['MasterListOfFormat']['prepared_by'], 
					$this->request->data['MasterListOfFormat']['approved_by'] 
					);

                $this->Session->setFlash(__('The master list of format has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->MasterListOfFormat->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The master list of format could not be saved. Please, try again.'));
            }
        }
        $systemTables = $this->MasterListOfFormat->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $this->set(compact('systemTables'));
        $count = $this->MasterListOfFormat->find('count');
        $published = $this->MasterListOfFormat->find('count', array('conditions' => array('MasterListOfFormat.publish' => 1)));
        $unpublished = $this->MasterListOfFormat->find('count', array('conditions' => array('MasterListOfFormat.publish' => 0)));

        $this->set(compact('count', 'published', 'unpublished'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {

	/*	$this->Session->setFlash(__('You can not edit these records with out reaising a change request'));
		$this->redirect(array('controller' => 'dashboards', 'action' => 'mr')); */
		
        if (!$this->MasterListOfFormat->exists($id)) {
            throw new NotFoundException(__('Invalid master list of format'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {

            $this->MasterListOfFormat->read(null, array($this->MasterListOfFormat->primaryKey => $id));
	
            $newdata = $this->request->data['MasterListOfFormat'];
	            if ($this->MasterListOfFormat->save($newdata)) {

                // add branches
                $this->MasterListOfFormat->MasterListOfFormatBranch->deleteAll(array('MasterListOfFormatBranch.master_list_of_format_id' => $id));
                $this->MasterListOfFormat->MasterListOfFormatDepartment->deleteAll(array('MasterListOfFormatDepartment.master_list_of_format_id' => $id));

                $this->_add_branches_and_departments(
					$this->request->data['MasterListOfFormatBranch_branch_id'], 
					$this->request->data['MasterListOfFormatDepartment_department_id'], 
					$this->request->data['MasterListOfFormat']['system_table_id'], 
					$this->MasterListOfFormat->id, 
					1,
					$this->request->data['MasterListOfFormat']['prepared_by'], 
					$this->request->data['MasterListOfFormat']['approved_by'] );

                $this->Session->setFlash(__('The master list of format has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->request->data['MasterListOfFormat']['evidence_required'] == true) {
                    $sys_data['SystemTable']['evidence_required'] = 1;
                } else {
                    $sys_data['SystemTable']['evidence_required'] = 0;
                }
                if ($this->request->data['MasterListOfFormat']['approvals_required'] == true) {
                    $sys_data['SystemTable']['approvals_required'] = 1;
                } else {
                    $sys_data['SystemTable']['approvals_required'] = 0;
                }

                $sys_data['SystemTable']['master_list_of_format_id'] = $id;
                $this->loadModel('SystemTable');
                $this->SystemTable->read(null, $this->request->data['MasterListOfFormat']['system_table_id']);
                $this->SystemTable->set($sys_data['SystemTable']);
                $this->SystemTable->save();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('controller' => 'dashboards', 'action' => 'mr'));
            } else {
                $this->Session->setFlash(__('The master list of format could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('MasterListOfFormat.' . $this->MasterListOfFormat->primaryKey => $id));
            $this->request->data = $this->MasterListOfFormat->find('first', $options);
        }
        $systemTables = $this->MasterListOfFormat->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $this->set(compact('systemTables'));
        $count = $this->MasterListOfFormat->find('count');
        $published = $this->MasterListOfFormat->find('count', array('conditions' => array('MasterListOfFormat.publish' => 1)));
        $unpublished = $this->MasterListOfFormat->find('count', array('conditions' => array('MasterListOfFormat.publish' => 0)));

        $this->set(compact('count', 'published', 'unpublished'));

        $bbranches = $this->MasterListOfFormat->MasterListOfFormatBranch->find('all', array('conditions' => array('MasterListOfFormatBranch.master_list_of_format_id' => $id)));
        $selected = array();
        foreach ($bbranches as $bb):
            $selected[] = $bb['Branch']['id'];
        endforeach;
        $this->set('selected_branches', $selected);

        $selected_depts = $this->MasterListOfFormat->MasterListOfFormatDepartment->find('all', array('conditions' => array('MasterListOfFormatDepartment.master_list_of_format_id' => $id)));
        $selected = array();
        foreach ($selected_depts as $dd):
            $selected[] = $dd['Department']['id'];
        endforeach;
        $this->set('selected_depts', $selected);

        $preparedBies = $this->MasterListOfFormat->PreparedBy->find('list');
        $approvedBies = $this->MasterListOfFormat->ApprovedBy->find('list');
        $this->set(compact('preparedBies', 'approvedBies'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approval_id = null) {
        if (!$this->MasterListOfFormat->exists($id)) {
            throw new NotFoundException(__('Invalid master list of format'));
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
            if ($this->MasterListOfFormat->save($this->request->data)) {

                $this->Session->setFlash(__('The master list of format has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The master list of format could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('MasterListOfFormat.' . $this->MasterListOfFormat->primaryKey => $id));
            $this->request->data = $this->MasterListOfFormat->find('first', $options);
        }
        $systemTables = $this->MasterListOfFormat->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $this->set(compact('systemTables'));
        $count = $this->MasterListOfFormat->find('count');
        $published = $this->MasterListOfFormat->find('count', array('conditions' => array('MasterListOfFormat.publish' => 1)));
        $unpublished = $this->MasterListOfFormat->find('count', array('conditions' => array('MasterListOfFormat.publish' => 0)));

        $this->set(compact('count', 'published', 'unpublished'));
    }

    /**
     * add_new_ajax method
     *
     * @return void
     */
    public function add_new_ajax() {

        if ($this->_show_approvals()) {
            $this->loadModel('User');
            $this->User->recursive = 0;
            $userids = $this->User->find('list', array('order' => array('User.name' => 'ASC'), 'conditions' => array('User.publish' => 1, 'User.soft_delete' => 0, 'User.is_approvar' => 1)));
            $this->set(array('userids' => $userids, 'showApprovals' => $this->_show_approvals()));
        }

        if ($this->request->is('post')) {

            $this->MasterListOfFormat->create();
            $this->request->data['MasterListOfFormat']['created_by'] = $this->Session->read('User.id');
            $this->request->data['MasterListOfFormat']['modified_by'] = $this->Session->read('User.id');
            //$this->request->data['MasterListOfFormat']['system_table_id'] = $this->_getSystemtableid(); // Please do not remove this line
            if ($this->MasterListOfFormat->save($this->request->data)) {
                $this->_add_branches_and_departments(
					$this->request->data['MasterListOfFormatBranch_branch_id'], 
					$this->request->data['MasterListOfFormatDepartment_department_id'], 
					$this->request->data['MasterListOfFormat']['system_table_id'], 
					$this->MasterListOfFormat->id, 
					1,
					$this->request->data['MasterListOfFormat']['prepared_by'], 
					$this->request->data['MasterListOfFormat']['approved_by'] 
					);				

                $this->Session->setFlash(__('The master list of format has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->MasterListOfFormat->id));
                else
                    $this->redirect(array('controller' => 'master_list_of_formats', 'action' => 'add_new_ajax'));
            } else {
                $this->Session->setFlash(__('The master list of format could not be saved. Please, try again.'));
            }
        }

        $systemTables = $this->MasterListOfFormat->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $this->set(compact('systemTables'));

        $count = $this->MasterListOfFormat->find('count');
        $published = $this->MasterListOfFormat->find('count', array('conditions' => array('MasterListOfFormat.publish' => 1)));
        $unpublished = $this->MasterListOfFormat->find('count', array('conditions' => array('MasterListOfFormat.publish' => 0)));

        $this->set(compact('count', 'published', 'unpublished'));
    }

    public function _add_branches_and_departments($branches, $departments, $system_table_id, $newid, $publish, $prepared_by, $approved_by) {

        $new_data = array();

        foreach ($branches as $branchids):
            $this->MasterListOfFormat->MasterListOfFormatBranch->create();
            $new_data['MasterListOfFormatBranch']['master_list_of_format_id'] = $newid;
            $new_data['MasterListOfFormatBranch']['prepared_by'] = $prepared_by;
			 $new_data['MasterListOfFormatBranch']['approved_by'] = $approved_by;	
            $new_data['MasterListOfFormatBranch']['branch_id'] = $branchids;
            $new_data['MasterListOfFormatBranch']['system_table_id'] = $system_table_id;
            $new_data['MasterListOfFormatBranch']['publish'] = $publish;
            $new_data['MasterListOfFormatBranch']['soft_delete'] = 0;
            $new_data['MasterListOfFormatBranch']['created_by'] = $this->Session->read('User.id');
            $new_data['MasterListOfFormatBranch']['modified_by'] = $this->Session->read('User.id');
            $new_data['MasterListOfFormatBranch']['branchid'] = $this->Session->read('User.branch_id');
            $new_data['MasterListOfFormatBranch']['departmentid'] = $this->Session->read('User.branch_id');

            $this->MasterListOfFormat->MasterListOfFormatBranch->save($new_data);
        endforeach;

        $new_data = array();
        foreach ($departments as $departmentids):
            $this->MasterListOfFormat->MasterListOfFormatDepartment->create();
            $new_data['MasterListOfFormatDepartment']['master_list_of_format_id'] = $newid;
            $new_data['MasterListOfFormatDepartment']['prepared_by'] = $prepared_by;
			 $new_data['MasterListOfFormatDepartment']['approved_by'] = $approved_by;			
            $new_data['MasterListOfFormatDepartment']['department_id'] = $departmentids;
            $new_data['MasterListOfFormatDepartment']['system_table_id'] = $system_table_id;
            $new_data['MasterListOfFormatDepartment']['publish'] = $publish;
            $new_data['MasterListOfFormatDepartment']['soft_delete'] = 0;
            $new_data['MasterListOfFormatDepartment']['created_by'] = $this->Session->read('User.id');
            $new_data['MasterListOfFormatDepartment']['modified_by'] = $this->Session->read('User.id');
            $new_data['MasterListOfFormatDepartment']['branchid'] = $this->Session->read('User.branch_id');
            $new_data['MasterListOfFormatDepartment']['departmentid'] = $this->Session->read('User.branch_id');
            $this->MasterListOfFormat->MasterListOfFormatDepartment->save($new_data);
        endforeach;
    }

}
