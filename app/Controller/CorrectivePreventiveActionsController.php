<?php

App::uses('AppController', 'Controller');

/**
 * CorrectivePreventiveActions Controller
 *
 * @property CorrectivePreventiveAction $CorrectivePreventiveAction
 */
class CorrectivePreventiveActionsController extends AppController {

    public function _get_system_table_id() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $this->request->params['controller'])));
        return $systemTableId['SystemTable']['id'];
    }

    public function _get_count($type = null) {
        $onlyBranch = null;
        $onlyOwn = null;
        $conditions = null;
        $modelName = $this->modelClass;
        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array($modelName . '.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array($modelName . '.created_by' => $this->Session->read('User.id'));
        $conditions = array($onlyBranch, $onlyOwn);
        if (isset($type)) {
            $conditions = array('CorrectivePreventiveAction.capa_type' => $type);
        } else if (isset($this->request->params['named']['capa_type'])) {
            $conditions = array('CorrectivePreventiveAction.capa_type' => $this->request->params['named']['capa_type']);
        }
        $count = $this->$modelName->find('count', array('conditions' => $conditions));
        $published = $this->$modelName->find('count', array('conditions' => array($conditions, $modelName . '.publish' => 1, $modelName . '.soft_delete' => 0)));
        $unpublished = $this->$modelName->find('count', array('conditions' => array($conditions, $modelName . '.publish' => 0, $modelName . '.soft_delete' => 0)));
        $deleted = $this->$modelName->find('count', array('conditions' => array($conditions, $modelName . '.soft_delete' => 1)));
        $this->set(compact('count', 'published', 'unpublished', 'deleted','type'));
        $this->CorrectivePreventiveAction->recursive = 0;
        $this->set('correctivePreventiveActions', $this->paginate());
    }

    public function _check_request() {
        $onlyBranch = null;
        $onlyOwn = null;
        $con1 = null;
        $con2 = null;
        $modelName = $this->modelClass;
        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array($modelName . '.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array($modelName . '.created_by' => $this->Session->read('User.id'));
        if ($this->request->params['named']) {
            if (isset($this->request->params['named']['capa_type'])) {
                if ($this->request->params['named']['published'] == null)
                    $con1 = null;
                else
                    $con1 = array($modelName . '.publish' => $this->request->params['named']['published'], $modelName . '.capa_type' => $this->request->params['named']['capa_type']);
                if ($this->request->params['named']['soft_delete'] == null)
                    $con2 = null;
                else
                    $con2 = array($modelName . '.soft_delete' => $this->request->params['named']['soft_delete'], $modelName . '.capa_type' => $this->request->params['named']['capa_type']);
                if ($this->request->params['named']['soft_delete'] == null)
                    $conditions = array($onlyBranch, $onlyOwn, $con1, $modelName . '.soft_delete' => 0, $modelName . '.capa_type' => $this->request->params['named']['capa_type']);
                else
                    $conditions = array($onlyBranch, $onlyOwn, $con1, $con2);
            }
        }
        else {
            $conditions = array($onlyBranch, $onlyOwn, null, $modelName . '.soft_delete' => 0);
        }

        return $conditions;
    }

    public function capa_assigned() {
        $assigned = null;
        $employee = $this->Session->read('User.employee_id');

        $this->paginate = array('limit' => 2,
            'order' => array('CorrectivePreventiveAction.target_date' => 'ASC'),
            'fields' => array(
                'CapaSource.name', 'CapaCategory.name', 'CorrectivePreventiveAction.initial_remarks',
                'CorrectivePreventiveAction.id',
                'CorrectivePreventiveAction.target_date',
                'CorrectivePreventiveAction.number',
                'SuggestionForm.suggestion',
                'CustomerComplaint.details',
                'SupplierRegistration.title',
                'Product.name',
                'Device.name',
                'Material.name',
                'InternalAudit.clauses'
            ),
            'conditions' => array('OR' => array(
                    'CorrectivePreventiveAction.assigned_to' => $employee,
                    'CorrectivePreventiveAction.action_assigned_to' => $employee,
                ), 'CorrectivePreventiveAction.current_status' => 0,
                'CorrectivePreventiveAction.soft_delete' => 0),
            'recursive' => 0);

        $assignedCapas = $this->paginate();
	if($assignedCapas){
        $this->loadModel('MeetingTopic');
		$i = 0;
        foreach ($assignedCapas as $assignedCapa):
            $meeting = $this->MeetingTopic->find('count', array('conditions' => array('MeetingTopic.publish' => 1, 'MeetingTopic.soft_delete' => 0, 'MeetingTopic.corrective_preventive_action_id' => $assignedCapa['CorrectivePreventiveAction']['id'])));
            $assigned[$i] = $assignedCapa;
            if ($meeting > 0) {
                $assigned[$i]['added_in_meeting'] = 1;
            } else {
                $assigned[$i]['added_in_meeting'] = 0;
            }
            $i ++;
        endforeach;
        $i = 0;
	}
        $openCapa = $this->CorrectivePreventiveAction->find('count', array(
            'order' => array('CorrectivePreventiveAction.target_date' => 'DESC'),
            'conditions' => array('OR' => array(
                    'CorrectivePreventiveAction.assigned_to' => $employee,
                    'CorrectivePreventiveAction.action_assigned_to' => $employee,
                ), 'CorrectivePreventiveAction.current_status' => 0, 'CorrectivePreventiveAction.soft_delete' => 0, 'CorrectivePreventiveAction.publish' => 1)));

        $closeCapa = $this->CorrectivePreventiveAction->find('count', array(
            'order' => array('CorrectivePreventiveAction.target_date' => 'DESC'),
            'conditions' => array('OR' => array(
                    'CorrectivePreventiveAction.assigned_to' => $employee,
                    'CorrectivePreventiveAction.action_assigned_to' => $employee,
                ), 'CorrectivePreventiveAction.current_status' => 1, 'CorrectivePreventiveAction.soft_delete' => 0, 'CorrectivePreventiveAction.publish' => 1)));

        $from = date('Y-m-d');
        $to = date("Y-m-d", strtotime("+3 days", strtotime($from)));
        $forAlert = $this->CorrectivePreventiveAction->find('count', array(
            'conditions' => array('OR' => array(
                    'CorrectivePreventiveAction.assigned_to' => $employee,
                    'CorrectivePreventiveAction.action_assigned_to' => $employee,
                ),
                'CorrectivePreventiveAction.target_date between ? and ? ' => array($from, $to),
                'CorrectivePreventiveAction.current_status' => 0), 'CorrectivePreventiveAction.soft_delete' => 0));
        if ($forAlert) {
            $this->set('show_nc_alert', true);
        }
        $assignedCount = count($assigned);


        $this->set(array('assigned' => $assigned, 'assignedCount' => $assignedCount, 'openCapa' => $openCapa, 'closeCapa' => $closeCapa));
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {

    }

    public function get_ncs($i = 0) {
        $condition1 = null;
        $condition2 = null;
        $condition = $this->_check_request();
        $this->loadModel('InternalAudit');
        $modelName = $this->modelClass;
        $internalAuditId = array();
        $internalAudits = $this->InternalAudit->find('all', array('conditions' => array('InternalAudit.non_conformity_found' => 1)));
        foreach ($internalAudits as $key => $internalAudit) {
            $internalAuditId[$key] = $internalAudit['InternalAudit']['id'];
        }

        if ($i == 0) {
            $condition1 = array('CorrectivePreventiveAction.internal_audit_id' => $internalAuditId);
        }
        if ($i == 1) {
            $condition2 = array('CorrectivePreventiveAction.internal_audit_id' => $internalAuditId, 'CorrectivePreventiveAction.current_status' => 0, 'CorrectivePreventiveAction.soft_delete' => 0, 'CorrectivePreventiveAction.publish' => 1);
        }
        $conditions = array($condition1, $condition2);
        $this->paginate = array('order' => array('CorrectivePreventiveAction.sr_no' => 'DESC'), 'conditions' => array($conditions));
        $correctivePreventiveActions = $this->paginate();
        $count = $this->$modelName->find('count', array('conditions' => $conditions));
        $published = $this->$modelName->find('count', array('conditions' => array($conditions, $modelName . '.publish' => 1, $modelName . '.soft_delete' => 0)));
        $unpublished = $this->$modelName->find('count', array('conditions' => array($conditions, $modelName . '.publish' => 0, $modelName . '.soft_delete' => 0)));
        $deleted = $this->$modelName->find('count', array('conditions' => array($conditions, $modelName . '.soft_delete' => 1)));
        $this->set(compact('correctivePreventiveActions', 'count', 'published', 'unpublished', 'deleted'));
    }

    public function get_capa_index($type = null) {
        $conditions = $this->_check_request();
        if (isset($type)) {
            $conditions = array('CorrectivePreventiveAction.capa_type' => $type, 'CorrectivePreventiveAction.soft_delete' => 0);
        }
        $this->paginate = array('order' => array('CorrectivePreventiveAction.sr_no' => 'DESC'), 'conditions' => array($conditions));
        $this->set('type', $type);
        $this->_get_count($type);
    }

    /**
     * capa status
     * Dynamic by - TGS
     * @return void
     */
    public function capa_status($status = 0) {


        $this->CorrectivePreventiveAction->recursive = 0;
        $this->paginate = array('order' => array('CorrectivePreventiveAction.sr_no' => 'DESC'), 'conditions' => array('CorrectivePreventiveAction.current_status' => $status, 'CorrectivePreventiveAction.soft_delete' => 0, 'CorrectivePreventiveAction.publish' => 1));
        $count = $this->CorrectivePreventiveAction->find('count', array('conditions' => array('CorrectivePreventiveAction.current_status' => $status, 'CorrectivePreventiveAction.soft_delete' => 0, 'CorrectivePreventiveAction.publish' => 1)));
        $published = $this->CorrectivePreventiveAction->find('count', array('conditions' => array('CorrectivePreventiveAction.current_status' => $status, 'CorrectivePreventiveAction.publish' => 1)));
        $unpublished = $this->CorrectivePreventiveAction->find('count', array('conditions' => array('CorrectivePreventiveAction.current_status' => $status, 'CorrectivePreventiveAction.publish' => 0)));
        $deleted = $this->CorrectivePreventiveAction->find('count', array('conditions' => array('CorrectivePreventiveAction.current_status' => $status, 'CorrectivePreventiveAction.soft_delete' => 1)));
        $this->set(compact('count', 'published', 'unpublished', 'deleted'));
        $this->set('correctivePreventiveActions', $this->paginate());
    }

    /**
     * adcanced_search method
     * Advanced search by - TGS
     * @return void
     */
    public function capa_advanced_search() {
        $conditions = array();
        $capaType = $this->request->query['capa_type'];
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
                        $searchArray[] = array('CorrectivePreventiveAction.' . $search => $searchKey);
                    else
                        $searchArray[] = array('CorrectivePreventiveAction.' . $search . ' like ' => '%' . $searchKey . '%');
                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('CorrectivePreventiveAction.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if (($this->request->query['capa_type'] != '') && ($this->request->query['capa_type'] == 0) || ($this->request->query['capa_type'] == 1) || ($this->request->query['capa_type'] == 2)) {
            $capaTypeConditions[] = array('CorrectivePreventiveAction.capa_type' => $this->request->query['capa_type']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $capaTypeConditions));
            else
                $conditions[] = array('or' => $capaTypeConditions);
        }
        //employee type not in db
        if (($this->request->query['employee_type'] != -1) && ($this->request->query['employee_id'] != -1)) {
                $employeeTypeConditions[] = array('CorrectivePreventiveAction.' . $this->request->query['employee_type'] => $this->request->query['employee_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $employeeTypeConditions));
            else
                $conditions[] = array('or' => $employeeTypeConditions);
        }
        if ($this->request->query['capa_source_id'] != -1) {
            $capaSourceConditions[] = array('CorrectivePreventiveAction.capa_source_id' => $this->request->query['capa_source_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $capaSourceConditions);
            else
                $conditions[] = array('or' => $capaSourceConditions);
        }

        if ($this->request->query['capa_category_id'] != -1) {
            $capaCategoryConditions[] = array('CorrectivePreventiveAction.capa_category_id' => $this->request->query['capa_category_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $capaCategoryConditions);
            else
                $conditions[] = array('or' => $capaCategoryConditions);
        }

        if ($this->request->query['document_change_required'] > 0) {
            $documentChangeRequiredConditions[] = array('CorrectivePreventiveAction.document_changes_required' => $this->request->query['document_change_required']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $documentChangeRequiredConditions);
            else
                $conditions[] = array('or' => $documentChangeRequiredConditions);
        }
        if ($this->request->query['current_status'] != '') {
            $currentStatusConditions[] = array('CorrectivePreventiveAction.current_status' => $this->request->query['current_status']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $currentStatusConditions);
            else
                $conditions[] = array('or' => $currentStatusConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('CorrectivePreventiveAction.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'CorrectivePreventiveAction.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
        unset($this->request->query);
        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('CorrectivePreventiveAction.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('CorrectivePreventiveAction.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);
        $this->CorrectivePreventiveAction->recursive = 0;
        $this->paginate = array('order' => array('CorrectivePreventiveAction.sr_no' => 'DESC'), 'conditions' => $conditions, 'CorrectivePreventiveAction.soft_delete' => 0);
        $correctivePreventiveActions = $this->paginate();
        $this->set(compact('correctivePreventiveActions', 'capaType'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->CorrectivePreventiveAction->exists($id)) {
            throw new NotFoundException(__('Invalid corrective preventive action'));
        }
        $options = array('conditions' => array('CorrectivePreventiveAction.' . $this->CorrectivePreventiveAction->primaryKey => $id));

        $currentCapa = $this->CorrectivePreventiveAction->find('first', $options);
        $this->loadModel('ChangeAdditionDeletionRequest');
        $changeRequiredIn = $this->ChangeAdditionDeletionRequest->find('first', array('conditions' => array('ChangeAdditionDeletionRequest.id' => $currentCapa['CorrectivePreventiveAction']['change_addition_deletion_request_id']), 'fields' => array('MasterListOfFormat.id', 'MasterListOfFormat.title')));

        $this->set('correctivePreventiveAction', $currentCapa);
        $this->set('changeRequiredIn', $changeRequiredIn);
        $this->set(compact('customerComplaints'));
    }

    /**
     * list method
     *
     * @return void
     */
    public function lists($type = null) {
        $this->_get_count($type);
        $this->set($type);
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
            $this->request->data['CorrectivePreventiveAction']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['CorrectivePreventiveAction']['created_by'] = $this->Session->read('User.id');
            $this->request->data['CorrectivePreventiveAction']['modified_by'] = $this->Session->read('User.id');
            $this->request->data['CorrectivePreventiveAction']['created'] = date('Y-m-d H:i:s');
            $this->request->data['CorrectivePreventiveAction']['modified'] = date('Y-m-d H:i:s');

	      if(isset( $this->request->data['CorrectivePreventiveAction']['suggestion_form_id']) && $this->request->data['CorrectivePreventiveAction']['suggestion_form_id']!= -1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Employee', 'id' => $this->request->data['CorrectivePreventiveAction']['suggestion_form_id']));

	      }else  if(isset( $this->request->data['CorrectivePreventiveAction']['customer_complaint_id']) && $this->request->data['CorrectivePreventiveAction']['customer_complaint_id']!= -1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Customer Complaint', 'id' => $this->request->data['CorrectivePreventiveAction']['customer_complaint_id']));

	      }else if(isset( $this->request->data['CorrectivePreventiveAction']['supplier_registration_id']) && $this->request->data['CorrectivePreventiveAction']['supplier_registration_id']!=-1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Supplier Registration', 'id' => $this->request->data['CorrectivePreventiveAction']['supplier_registration_id']));

	      }else if(isset( $this->request->data['CorrectivePreventiveAction']['device_id']) && $this->request->data['CorrectivePreventiveAction']['device_id']!=-1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Device', 'id' => $this->request->data['CorrectivePreventiveAction']['device_id']));

	      }else if(isset( $this->request->data['CorrectivePreventiveAction']['material_id']) && $this->request->data['CorrectivePreventiveAction']['material_id']!=-1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Material', 'id' => $this->request->data['CorrectivePreventiveAction']['material_id']));

	      }else if(isset( $this->request->data['CorrectivePreventiveAction']['internal_audit_id']) && $this->request->data['CorrectivePreventiveAction']['internal_audit_id']!=-1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Internal Audit ', 'id' => $this->request->data['CorrectivePreventiveAction']['internal_audit_id']));

	      }else if(isset( $this->request->data['CorrectivePreventiveAction']['product_id']) && $this->request->data['CorrectivePreventiveAction']['product_id']!=-1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Product', 'id' => $this->request->data['CorrectivePreventiveAction']['product_id']));

	      }

            $this->CorrectivePreventiveAction->create();

            if ($this->CorrectivePreventiveAction->save($this->request->data, false)) {
                if ($this->request->data['CorrectivePreventiveAction']['material_id'] != '-1') {
                    //add this to new table called "list of non-confirming products / materials
                    $this->loadModel('NonConformingProductsMaterial');
                    $this->loadModel('SystemTable');
                    $this->SystemTable->recursive = 1;

                    $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => 'non_conforming_products_materials'), 'fields' => array('SystemTable.id', 'MasterListOfFormat.id')
                    ));
                    $this->NonConformingProductsMaterial->create();
                    $newData = array();
                    $newData['material_id'] = $this->request->data['CorrectivePreventiveAction']['material_id'];
                    $newData['title'] = $this->request->data['CorrectivePreventiveAction']['name'];
                    $newData['description'] = $this->request->data['CorrectivePreventiveAction']['initial_remarks'];
                    $newData['capa_source_id'] = $this->request->data['CorrectivePreventiveAction']['capa_source_id'];
                    $newData['corrective_preventive_action_id'] = $this->CorrectivePreventiveAction->id;
                    $newData['system_table_id'] = $systemTableId['SystemTable']['id'];
                    $newData['master_list_of_format_id'] = $systemTableId['MasterListOfFormat']['id'];
                    $newData['publish'] = $this->request->data['CorrectivePreventiveAction']['publish'];
                    $newData['soft_delete'] = 0;
                    $this->NonConformingProductsMaterial->save($newData, false);
                }

                if ($this->request->data['CorrectivePreventiveAction']['product_id'] != '-1') {
                    //add this to new table called "list of non-confirming products / materials
                    $this->loadModel('NonConformingProductsMaterial');
                    $this->loadModel('SystemTable');
                    $this->SystemTable->recursive = 1;
                    $systemTableId = $this->SystemTable->find('first', array(
                        'conditions' => array('SystemTable.system_name' => 'non_conforming_products_materials'),
                        'fields' => array('SystemTable.id', 'MasterListOfFormat.id')
                    ));
                    $this->NonConformingProductsMaterial->create();
                    $newData = array();
                    $newData['product_id'] = $this->request->data['CorrectivePreventiveAction']['product_id'];
                    $newData['title'] = $this->request->data['CorrectivePreventiveAction']['name'];
                    $newData['description'] = $this->request->data['CorrectivePreventiveAction']['initial_remarks'];
                    $newData['capa_source_id'] = $this->request->data['CorrectivePreventiveAction']['capa_source_id'];
                    $newData['corrective_preventive_action_id'] = $this->CorrectivePreventiveAction->id;
                    $newData['system_table_id'] = $systemTableId['SystemTable']['id'];
                    $newData['master_list_of_format_id'] = $systemTableId['MasterListOfFormat']['id'];
                    $newData['publish'] = $this->request->data['CorrectivePreventiveAction']['publish'];
                    $newData['soft_delete'] = 0;
                    $this->NonConformingProductsMaterial->save($newData, false);
                }

		if($this->request->data['CorrectivePreventiveAction']['document_changes_required'] == 1){
		    $this->loadModel('ChangeAdditionDeletionRequest');
		    $this->ChangeAdditionDeletionRequest->create();
		    $newData = array();
		    $newData['others'] = 'CAPA Number: ' . $this->request->data['CorrectivePreventiveAction']['number'];
		    $newData['master_list_of_format'] = $this->request->data['CorrectivePreventiveAction']['master_list_of_format'];
		    $newData['current_document_details'] = $this->request->data['CorrectivePreventiveAction']['current_document_details'];
		    $newData['request_details'] = $this->request->data['CorrectivePreventiveAction']['request_details'];
		    $newData['proposed_changes'] = $this->request->data['CorrectivePreventiveAction']['proposed_changes'];
		    $newData['reason_for_change'] = $this->request->data['CorrectivePreventiveAction']['reason_for_change'];
		    $this->ChangeAdditionDeletionRequest->save($newData, false);

		    $updateCapa['id'] = $this->CorrectivePreventiveAction->id;
		    $updateCapa['change_addition_deletion_request_id'] = $this->ChangeAdditionDeletionRequest->id;
		    $this->CorrectivePreventiveAction->save($updateCapa);
		}

                $this->Session->setFlash(__('The corrective preventive action has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->CorrectivePreventiveAction->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The corrective preventive action could not be saved. Please, try again.'));
            }
        }
        $capaSources = $this->CorrectivePreventiveAction->CapaSource->find('list', array('conditions' => array('CapaSource.publish' => 1, 'CapaSource.soft_delete' => 0)));
        $capaCategories = $this->CorrectivePreventiveAction->CapaCategory->find('list', array('conditions' => array('CapaCategory.publish' => 1, 'CapaCategory.soft_delete' => 0)));
        $internalAudits = $this->CorrectivePreventiveAction->InternalAudit->find('list', array('conditions' => array('InternalAudit.publish' => 1, 'InternalAudit.soft_delete' => 0)));
        $suggestionForms = $this->CorrectivePreventiveAction->SuggestionForm->find('list', array('conditions' => array('SuggestionForm.publish' => 1, 'SuggestionForm.soft_delete' => 0)));
        $customerComplaints = $this->CorrectivePreventiveAction->CustomerComplaint->find('list', array('conditions' => array('CustomerComplaint.publish' => 1, 'CustomerComplaint.soft_delete' => 0)));
        $supplierRegistrations = $this->CorrectivePreventiveAction->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
        $products = $this->CorrectivePreventiveAction->Product->find('list', array('conditions' => array('Product.publish' => 1, 'Product.soft_delete' => 0)));
        $devices = $this->CorrectivePreventiveAction->Device->find('list', array('conditions' => array('Device.publish' => 1, 'Device.soft_delete' => 0)));
        $materials = $this->CorrectivePreventiveAction->Material->find('list', array('conditions' => array('Material.publish' => 1, 'Material.soft_delete' => 0)));
        $masterListOfFormats = $this->CorrectivePreventiveAction->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0), 'recursive' => -1));
        $this->set(compact('capaSources', 'capaCategories', 'internalAudits', 'suggestionForms', 'customerComplaints', 'supplierRegistrations', 'products', 'devices', 'materials','masterListOfFormats'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->CorrectivePreventiveAction->exists($id)) {
            throw new NotFoundException(__('Invalid corrective preventive action'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            if ($this->request->data['CorrectivePreventiveAction']['material_id'] == '-1') {
                $this->loadModel('NonConformingProductsMaterial');
                $NonConformingMaterials = $this->NonConformingProductsMaterial->find('first', array('conditions' => array('NonConformingProductsMaterial.corrective_preventive_action_id' => $id)));
                if (isset($NonConformingMaterials['NonConformingProductsMaterial']['material_id'])) {
                    $this->NonConformingProductsMaterial->delete($NonConformingMaterials['NonConformingProductsMaterial']['id']);
                }
            }
            if ($this->request->data['CorrectivePreventiveAction']['product_id'] == '-1') {
                $this->loadModel('NonConformingProductsMaterial');
                $NonConformingProducts = $this->NonConformingProductsMaterial->find('first', array('conditions' => array('NonConformingProductsMaterial.corrective_preventive_action_id' => $id)));
                if (isset($NonConformingProducts['NonConformingProductsMaterial']['product_id'])) {
                    $this->NonConformingProductsMaterial->delete($NonConformingProducts['NonConformingProductsMaterial']['id']);
                }
            }
            $this->request->data['CorrectivePreventiveAction']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['CorrectivePreventiveAction']['modified_by'] = $this->Session->read('User.id');
            $this->request->data['CorrectivePreventiveAction']['modified'] = date('Y-m-d H:i:s');
            $this->request->data['CorrectivePreventiveAction']['created_by'] = $this->Session->read('User.id');



	      if(isset( $this->request->data['CorrectivePreventiveAction']['suggestion_form_id']) && $this->request->data['CorrectivePreventiveAction']['suggestion_form_id']!= -1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Employee', 'id' => $this->request->data['CorrectivePreventiveAction']['suggestion_form_id']));

	      }else  if(isset( $this->request->data['CorrectivePreventiveAction']['customer_complaint_id']) && $this->request->data['CorrectivePreventiveAction']['customer_complaint_id']!= -1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Customer Complaint', 'id' => $this->request->data['CorrectivePreventiveAction']['customer_complaint_id']));

	      }else if(isset( $this->request->data['CorrectivePreventiveAction']['supplier_registration_id']) && $this->request->data['CorrectivePreventiveAction']['supplier_registration_id']!=-1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Supplier Registration', 'id' => $this->request->data['CorrectivePreventiveAction']['supplier_registration_id']));

	      }else if(isset( $this->request->data['CorrectivePreventiveAction']['device_id']) && $this->request->data['CorrectivePreventiveAction']['device_id']!=-1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Device', 'id' => $this->request->data['CorrectivePreventiveAction']['device_id']));

	      }else if(isset( $this->request->data['CorrectivePreventiveAction']['material_id']) && $this->request->data['CorrectivePreventiveAction']['material_id']!=-1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Material', 'id' => $this->request->data['CorrectivePreventiveAction']['material_id']));

	      }else if(isset( $this->request->data['CorrectivePreventiveAction']['internal_audit_id']) && $this->request->data['CorrectivePreventiveAction']['internal_audit_id']!=-1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Internal Audit ', 'id' => $this->request->data['CorrectivePreventiveAction']['internal_audit_id']));

	      }  else if(isset( $this->request->data['CorrectivePreventiveAction']['product_id']) && $this->request->data['CorrectivePreventiveAction']['product_id']!=-1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Product', 'id' => $this->request->data['CorrectivePreventiveAction']['product_id']));

	      }

            if ($this->CorrectivePreventiveAction->save($this->request->data, false)) {
                if ($this->request->data['CorrectivePreventiveAction']['material_id'] != '-1') {
                    //add this to new table called "list of non-confirming products / materials
                    $this->loadModel('NonConformingProductsMaterial');
                    $this->loadModel('SystemTable');
                    $this->NonConformingProductsMaterial->deleteAll(array('NonConformingProductsMaterial.corrective_preventive_action_id'=>$id),false);
                    $this->SystemTable->recursive = 1;
                    $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => 'non_conforming_products_materials'), 'fields' => array('SystemTable.id', 'MasterListOfFormat.id')));
                    $this->NonConformingProductsMaterial->create();
                    $newData = array();
                    $newData['material_id'] = $this->request->data['CorrectivePreventiveAction']['material_id'];
                    $newData['title'] = $this->request->data['CorrectivePreventiveAction']['name'];
                    $newData['description'] = $this->request->data['CorrectivePreventiveAction']['initial_remarks'];
                    $newData['capa_source_id'] = $this->request->data['CorrectivePreventiveAction']['capa_source_id'];
                    $newData['corrective_preventive_action_id'] = $this->CorrectivePreventiveAction->id;
                    $newData['system_table_id'] = $systemTableId['SystemTable']['id'];
                    $newData['master_list_of_format_id'] = $systemTableId['MasterListOfFormat']['id'];
                    $newData['publish'] = $this->request->data['CorrectivePreventiveAction']['publish'];
                    $newData['soft_delete'] = 0;
                    $this->NonConformingProductsMaterial->save($newData, false);
                }

                if ($this->request->data['CorrectivePreventiveAction']['product_id'] != '-1') {
                    //add this to new table called "list of non-confirming products / materials
                    $this->loadModel('NonConformingProductsMaterial');
                    $this->loadModel('SystemTable');
                    $this->NonConformingProductsMaterial->deleteAll(array('NonConformingProductsMaterial.corrective_preventive_action_id'=>$id),false);
                    $this->SystemTable->recursive = 1;
                    $systemTableId = $this->SystemTable->find('first', array(
                        'conditions' => array('SystemTable.system_name' => 'non_conforming_products_materials'),
                        'fields' => array('SystemTable.id', 'MasterListOfFormat.id')
                    ));
                    $this->NonConformingProductsMaterial->create();
                    $newData = array();
                    $newData['product_id'] = $this->request->data['CorrectivePreventiveAction']['product_id'];
                    $newData['title'] = $this->request->data['CorrectivePreventiveAction']['name'];
                    $newData['description'] = $this->request->data['CorrectivePreventiveAction']['initial_remarks'];
                    $newData['capa_source_id'] = $this->request->data['CorrectivePreventiveAction']['capa_source_id'];
                    $newData['corrective_preventive_action_id'] = $this->CorrectivePreventiveAction->id;
                    $newData['system_table_id'] = $systemTableId['SystemTable']['id'];
                    $newData['master_list_of_format_id'] = $systemTableId['MasterListOfFormat']['id'];
                    $newData['publish'] = $this->request->data['CorrectivePreventiveAction']['publish'];
                    $newData['soft_delete'] = 0;
                    $this->NonConformingProductsMaterial->save($newData, false);
		}

		if($this->request->data['CorrectivePreventiveAction']['document_changes_required'] == 1){
		    if(!empty($this->request->data['CorrectivePreventiveAction']['change_addition_deletion_request_id'])){
			    $this->loadModel('ChangeAdditionDeletionRequest');
			    $newData = array();
			    $newData['id'] = $this->request->data['CorrectivePreventiveAction']['change_addition_deletion_request_id'];
			    $newData['others'] = 'CAPA Number: ' . $this->request->data['CorrectivePreventiveAction']['number'];
			    $newData['master_list_of_format'] = $this->request->data['CorrectivePreventiveAction']['master_list_of_format'];
			    $newData['current_document_details'] = $this->request->data['CorrectivePreventiveAction']['current_document_details'];
			    $newData['request_details'] = $this->request->data['CorrectivePreventiveAction']['request_details'];
			    $newData['proposed_changes'] = $this->request->data['CorrectivePreventiveAction']['proposed_changes'];
			    $newData['reason_for_change'] = $this->request->data['CorrectivePreventiveAction']['reason_for_change'];
			    $this->ChangeAdditionDeletionRequest->save($newData, false);

		    } else{
			    $this->loadModel('ChangeAdditionDeletionRequest');
			    $this->ChangeAdditionDeletionRequest->create();
			    $newData = array();
			    $newData['others'] = 'CAPA Number: ' . $this->request->data['CorrectivePreventiveAction']['number'];
			    $newData['master_list_of_format'] = $this->request->data['CorrectivePreventiveAction']['master_list_of_format'];
			    $newData['current_document_details'] = $this->request->data['CorrectivePreventiveAction']['current_document_details'];
			    $newData['request_details'] = $this->request->data['CorrectivePreventiveAction']['request_details'];
			    $newData['proposed_changes'] = $this->request->data['CorrectivePreventiveAction']['proposed_changes'];
			    $newData['reason_for_change'] = $this->request->data['CorrectivePreventiveAction']['reason_for_change'];
			    $this->ChangeAdditionDeletionRequest->save($newData, false);

			    $updateCapa['id'] = $this->CorrectivePreventiveAction->id;
			    $updateCapa['change_addition_deletion_request_id'] = $this->ChangeAdditionDeletionRequest->id;
			    $this->CorrectivePreventiveAction->save($updateCapa);
		    }
		} else {
		    if(!empty($this->request->data['CorrectivePreventiveAction']['change_addition_deletion_request_id'])){
			    $this->loadModel('ChangeAdditionDeletionRequest');
			    $this->ChangeAdditionDeletionRequest->deleteAll(array('ChangeAdditionDeletionRequest.id' => $this->request->data['CorrectivePreventiveAction']['change_addition_deletion_request_id']), false);

			    $updateCapa['id'] = $this->CorrectivePreventiveAction->id;
			    $updateCapa['change_addition_deletion_request_id'] = 'NULL';
			    $updateCapa['document_changes_required'] = 0;
			    $this->CorrectivePreventiveAction->save($updateCapa);
		    }
		}

                $this->Session->setFlash(__('The corrective preventive action has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The corrective preventive action could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CorrectivePreventiveAction.' . $this->CorrectivePreventiveAction->primaryKey => $id));
            $this->request->data = $this->CorrectivePreventiveAction->find('first', $options);
        }
        $capaSources = $this->CorrectivePreventiveAction->CapaSource->find('list', array('conditions' => array('CapaSource.publish' => 1, 'CapaSource.soft_delete' => 0)));
        $capaCategories = $this->CorrectivePreventiveAction->CapaCategory->find('list', array('conditions' => array('CapaCategory.publish' => 1, 'CapaCategory.soft_delete' => 0)));
        $internalAudits = $this->CorrectivePreventiveAction->InternalAudit->find('list', array('conditions' => array('InternalAudit.publish' => 1, 'InternalAudit.soft_delete' => 0)));
        $suggestionForms = $this->CorrectivePreventiveAction->SuggestionForm->find('list', array('conditions' => array('SuggestionForm.publish' => 1, 'SuggestionForm.soft_delete' => 0)));
        $customerComplaints = $this->CorrectivePreventiveAction->CustomerComplaint->find('list', array('conditions' => array('CustomerComplaint.publish' => 1, 'CustomerComplaint.soft_delete' => 0)));
        $supplierRegistrations = $this->CorrectivePreventiveAction->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
        $products = $this->CorrectivePreventiveAction->Product->find('list', array('conditions' => array('Product.publish' => 1, 'Product.soft_delete' => 0)));
        $devices = $this->CorrectivePreventiveAction->Device->find('list', array('conditions' => array('Device.publish' => 1, 'Device.soft_delete' => 0)));
        $materials = $this->CorrectivePreventiveAction->Material->find('list', array('conditions' => array('Material.publish' => 1, 'Material.soft_delete' => 0)));
        $masterListOfFormats = $this->CorrectivePreventiveAction->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0), 'recursive' => -1));
        $this->loadModel('ChangeAdditionDeletionRequest');
        $changeAdditionDeletionRequest = $this->ChangeAdditionDeletionRequest->find('first', array('conditions' => array('ChangeAdditionDeletionRequest.id' => $this->request->data['CorrectivePreventiveAction']['change_addition_deletion_request_id']), 'fields' => array('master_list_of_format', 'current_document_details', 'proposed_changes', 'reason_for_change', 'request_details'), 'recursive' => -1));
        $this->set(compact('capaSources', 'capaCategories', 'internalAudits', 'suggestionForms', 'customerComplaints', 'supplierRegistrations', 'products', 'devices', 'materials','masterListOfFormats', 'changeAdditionDeletionRequest'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->CorrectivePreventiveAction->exists($id)) {
            throw new NotFoundException(__('Invalid corrective preventive action'));
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

            if ($this->request->data['CorrectivePreventiveAction']['material_id'] == '-1') {
                $this->loadModel('NonConformingProductsMaterial');
                $NonConformingMaterials = $this->NonConformingProductsMaterial->find('first', array('conditions' => array('NonConformingProductsMaterial.corrective_preventive_action_id' => $id)));
                if (isset($NonConformingMaterials['NonConformingProductsMaterial']['material_id'])) {
                    $this->NonConformingProductsMaterial->delete($NonConformingMaterials['NonConformingProductsMaterial']['id']);
                }
            }
            if ($this->request->data['CorrectivePreventiveAction']['product_id'] == '-1') {
                $this->loadModel('NonConformingProductsMaterial');
                $NonConformingProducts = $this->NonConformingProductsMaterial->find('first', array('conditions' => array('NonConformingProductsMaterial.corrective_preventive_action_id' => $id)));
                if (isset($NonConformingProducts['NonConformingProductsMaterial']['product_id'])) {
                    $this->NonConformingProductsMaterial->delete($NonConformingProducts['NonConformingProductsMaterial']['id']);
                }
            }
            $this->request->data['CorrectivePreventiveAction']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['CorrectivePreventiveAction']['modified_by'] = $this->Session->read('User.id');
            $this->request->data['CorrectivePreventiveAction']['modified'] = date('Y-m-d H:i:s');
            $this->request->data['CorrectivePreventiveAction']['created_by'] = $this->Session->read('User.id');



	      if(isset( $this->request->data['CorrectivePreventiveAction']['suggestion_form_id']) && $this->request->data['CorrectivePreventiveAction']['suggestion_form_id']!= -1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Employee', 'id' => $this->request->data['CorrectivePreventiveAction']['suggestion_form_id']));

	      }else  if(isset( $this->request->data['CorrectivePreventiveAction']['customer_complaint_id']) && $this->request->data['CorrectivePreventiveAction']['customer_complaint_id']!= -1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Customer Complaint', 'id' => $this->request->data['CorrectivePreventiveAction']['customer_complaint_id']));

	      }else if(isset( $this->request->data['CorrectivePreventiveAction']['supplier_registration_id']) && $this->request->data['CorrectivePreventiveAction']['supplier_registration_id']!=-1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Supplier Registration', 'id' => $this->request->data['CorrectivePreventiveAction']['supplier_registration_id']));

	      }else if(isset( $this->request->data['CorrectivePreventiveAction']['device_id']) && $this->request->data['CorrectivePreventiveAction']['device_id']!=-1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Device', 'id' => $this->request->data['CorrectivePreventiveAction']['device_id']));

	      }else if(isset( $this->request->data['CorrectivePreventiveAction']['material_id']) && $this->request->data['CorrectivePreventiveAction']['material_id']!=-1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Material', 'id' => $this->request->data['CorrectivePreventiveAction']['material_id']));

	      }else if(isset( $this->request->data['CorrectivePreventiveAction']['internal_audit_id']) && $this->request->data['CorrectivePreventiveAction']['internal_audit_id']!=-1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Internal Audit ', 'id' => $this->request->data['CorrectivePreventiveAction']['internal_audit_id']));

	      } else if(isset( $this->request->data['CorrectivePreventiveAction']['product_id']) && $this->request->data['CorrectivePreventiveAction']['product_id']!=-1){

		      $this->request->data['CorrectivePreventiveAction']['raised_by'] = json_encode(array('Soruce' =>'Product', 'id' => $this->request->data['CorrectivePreventiveAction']['product_id']));

	      }
            if ($this->CorrectivePreventiveAction->save($this->request->data, false)) {
                if ($this->request->data['CorrectivePreventiveAction']['material_id'] != '-1') {
                    //add this to new table called "list of non-confirming products / materials
                    $this->loadModel('NonConformingProductsMaterial');
                    $this->loadModel('SystemTable');
                    $this->NonConformingProductsMaterial->deleteAll(array('NonConformingProductsMaterial.corrective_preventive_action_id'=>$id),false);
                    $this->SystemTable->recursive = 1;
                    $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => 'non_conforming_products_materials'), 'fields' => array('SystemTable.id', 'MasterListOfFormat.id')));
                    $this->NonConformingProductsMaterial->create();
                    $newData = array();
                    $newData['material_id'] = $this->request->data['CorrectivePreventiveAction']['material_id'];
                    $newData['title'] = $this->request->data['CorrectivePreventiveAction']['name'];
                    $newData['description'] = $this->request->data['CorrectivePreventiveAction']['initial_remarks'];
                    $newData['capa_source_id'] = $this->request->data['CorrectivePreventiveAction']['capa_source_id'];
                    $newData['corrective_preventive_action_id'] = $this->CorrectivePreventiveAction->id;
                    $newData['system_table_id'] = $systemTableId['SystemTable']['id'];
                    $newData['master_list_of_format_id'] = $systemTableId['MasterListOfFormat']['id'];
                    $newData['publish'] = $this->request->data['CorrectivePreventiveAction']['publish'];
                    $newData['soft_delete'] = 0;
                    $this->NonConformingProductsMaterial->save($newData, false);
                }

                if ($this->request->data['CorrectivePreventiveAction']['product_id'] != '-1') {
                    //add this to new table called "list of non-confirming products / materials
                    $this->loadModel('NonConformingProductsMaterial');
                    $this->loadModel('SystemTable');
                    $this->SystemTable->recursive = 1;
                    $systemTableId = $this->SystemTable->find('first', array(
                        'conditions' => array('SystemTable.system_name' => 'non_conforming_products_materials'),
                        'fields' => array('SystemTable.id', 'MasterListOfFormat.id')
                    ));
                    $this->NonConformingProductsMaterial->deleteAll(array('NonConformingProductsMaterial.corrective_preventive_action_id'=>$id),false);
                    $this->NonConformingProductsMaterial->create();
                    $newData = array();
                    $newData['product_id'] = $this->request->data['CorrectivePreventiveAction']['product_id'];
                    $newData['title'] = $this->request->data['CorrectivePreventiveAction']['name'];
                    $newData['description'] = $this->request->data['CorrectivePreventiveAction']['initial_remarks'];
                    $newData['capa_source_id'] = $this->request->data['CorrectivePreventiveAction']['capa_source_id'];
                    $newData['corrective_preventive_action_id'] = $this->CorrectivePreventiveAction->id;
                    $newData['system_table_id'] = $systemTableId['SystemTable']['id'];
                    $newData['master_list_of_format_id'] = $systemTableId['MasterListOfFormat']['id'];
                    $newData['publish'] = $this->request->data['CorrectivePreventiveAction']['publish'];
                    $newData['soft_delete'] = 0;
                    $this->NonConformingProductsMaterial->save($newData, false);
                }

		if($this->request->data['CorrectivePreventiveAction']['document_changes_required'] == 1){
		    if(!empty($this->request->data['CorrectivePreventiveAction']['change_addition_deletion_request_id'])){
			    $this->loadModel('ChangeAdditionDeletionRequest');
			    $newData = array();
			    $newData['id'] = $this->request->data['CorrectivePreventiveAction']['change_addition_deletion_request_id'];
			    $newData['others'] = 'CAPA Number: ' . $this->request->data['CorrectivePreventiveAction']['number'];
			    $newData['master_list_of_format'] = $this->request->data['CorrectivePreventiveAction']['master_list_of_format'];
			    $newData['current_document_details'] = $this->request->data['CorrectivePreventiveAction']['current_document_details'];
			    $newData['request_details'] = $this->request->data['CorrectivePreventiveAction']['request_details'];
			    $newData['proposed_changes'] = $this->request->data['CorrectivePreventiveAction']['proposed_changes'];
			    $newData['reason_for_change'] = $this->request->data['CorrectivePreventiveAction']['reason_for_change'];
			    $this->ChangeAdditionDeletionRequest->save($newData, false);

		    } else{
			    $this->loadModel('ChangeAdditionDeletionRequest');
			    $this->ChangeAdditionDeletionRequest->create();
			    $newData = array();
			    $newData['others'] = 'CAPA Number: ' . $this->request->data['CorrectivePreventiveAction']['number'];
			    $newData['master_list_of_format'] = $this->request->data['CorrectivePreventiveAction']['master_list_of_format'];
			    $newData['current_document_details'] = $this->request->data['CorrectivePreventiveAction']['current_document_details'];
			    $newData['request_details'] = $this->request->data['CorrectivePreventiveAction']['request_details'];
			    $newData['proposed_changes'] = $this->request->data['CorrectivePreventiveAction']['proposed_changes'];
			    $newData['reason_for_change'] = $this->request->data['CorrectivePreventiveAction']['reason_for_change'];
			    $this->ChangeAdditionDeletionRequest->save($newData, false);

			    $updateCapa['id'] = $this->CorrectivePreventiveAction->id;
			    $updateCapa['change_addition_deletion_request_id'] = $this->ChangeAdditionDeletionRequest->id;
			    $this->CorrectivePreventiveAction->save($updateCapa);
		    }
		} else {
		    if(!empty($this->request->data['CorrectivePreventiveAction']['change_addition_deletion_request_id'])){
			    $this->loadModel('ChangeAdditionDeletionRequest');
			    $this->ChangeAdditionDeletionRequest->deleteAll(array('ChangeAdditionDeletionRequest.id' => $this->request->data['CorrectivePreventiveAction']['change_addition_deletion_request_id']), false);

			    $updateCapa['id'] = $this->CorrectivePreventiveAction->id;
			    $updateCapa['change_addition_deletion_request_id'] = 'NULL';
			    $updateCapa['document_changes_required'] = 0;
			    $this->CorrectivePreventiveAction->save($updateCapa);
		    }
		}

                $this->Session->setFlash(__('The corrective preventive action has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

            } else {
                $this->Session->setFlash(__('The corrective preventive action could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CorrectivePreventiveAction.' . $this->CorrectivePreventiveAction->primaryKey => $id));
            $this->request->data = $this->CorrectivePreventiveAction->find('first', $options);
        }
        $capaSources = $this->CorrectivePreventiveAction->CapaSource->find('list', array('conditions' => array('CapaSource.publish' => 1, 'CapaSource.soft_delete' => 0)));
        $capaCategories = $this->CorrectivePreventiveAction->CapaCategory->find('list', array('conditions' => array('CapaCategory.publish' => 1, 'CapaCategory.soft_delete' => 0)));
        $internalAudits = $this->CorrectivePreventiveAction->InternalAudit->find('list', array('conditions' => array('InternalAudit.publish' => 1, 'InternalAudit.soft_delete' => 0)));
        $suggestionForms = $this->CorrectivePreventiveAction->SuggestionForm->find('list', array('conditions' => array('SuggestionForm.publish' => 1, 'SuggestionForm.soft_delete' => 0)));
        $customerComplaints = $this->CorrectivePreventiveAction->CustomerComplaint->find('list', array('conditions' => array('CustomerComplaint.publish' => 1, 'CustomerComplaint.soft_delete' => 0)));
        $supplierRegistrations = $this->CorrectivePreventiveAction->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
        $products = $this->CorrectivePreventiveAction->Product->find('list', array('conditions' => array('Product.publish' => 1, 'Product.soft_delete' => 0)));
        $devices = $this->CorrectivePreventiveAction->Device->find('list', array('conditions' => array('Device.publish' => 1, 'Device.soft_delete' => 0)));
        $materials = $this->CorrectivePreventiveAction->Material->find('list', array('conditions' => array('Material.publish' => 1, 'Material.soft_delete' => 0)));
        $masterListOfFormats = $this->CorrectivePreventiveAction->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0), 'recursive' => -1));
        $this->loadModel('ChangeAdditionDeletionRequest');
        $changeAdditionDeletionRequest = $this->ChangeAdditionDeletionRequest->find('first', array('conditions' => array('ChangeAdditionDeletionRequest.id' => $this->request->data['CorrectivePreventiveAction']['change_addition_deletion_request_id']), 'fields' => array('master_list_of_format', 'current_document_details', 'proposed_changes', 'reason_for_change', 'request_details'), 'recursive' => -1));
        $this->set(compact('capaSources', 'capaCategories', 'internalAudits', 'suggestionForms', 'customerComplaints', 'supplierRegistrations', 'products', 'devices', 'materials', 'masterListOfFormats', 'changeAdditionDeletionRequest'));
    }

    public function get_details($detail = null) {
        $category = $this->CorrectivePreventiveAction->CapaCategory->find('first', array('conditions' => array('CapaCategory.id' => $detail)));
        if ($category['CapaCategory']['name'] == 'Product') {
            $this->loadModel('Product');
            $this->Product->recursive = 0;
            $products = $this->Product->find('list', array('conditions' => array('Product.publish' => 1, 'Product.soft_delete' => 0)));
            $this->set(compact('products'));
        }
    }

}
