<?php
App::uses('AppModel', 'Model');
/**
 * CorrectivePreventiveAction Model
 *
 * @property CapaSource $CapaSource
 * @property CapaCategory $CapaCategory
 * @property InternalAudit $InternalAudit
 * @property SuggestionForm $SuggestionForm
 * @property CustomerComplaint $CustomerComplaint
 * @property SupplierRegistration $SupplierRegistration
 * @property Product $Product
 * @property Device $Device
 * @property Material $Material
 * @property SystemTable $SystemTable
 * @property MasterListOfFormat $MasterListOfFormat
 * @property Company $Company
 * @property InternalAudit $InternalAudit
 * @property MeetingTopic $MeetingTopic
 * @property NonConformingProductsMaterial $NonConformingProductsMaterial
 */
class CorrectivePreventiveAction extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'sr_no' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'capa_category_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),

		'assigned_to' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
		'target_date' => array(
			'date' => array(
				'rule' => array('date'),
			),
		),
		'priority' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'branchid' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
		'departmentid' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
		'created_by' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
		'modified_by' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
	);
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
                'ApprovedBy' => array(
                        'className' => 'Employee',
                        'foreignKey' => 'approved_by',
                        'conditions' => '',
                        'fields' => array('id', 'name'),
                        'order' => '' ),
                'PreparedBy' => array(
                        'className' => 'Employee',
                        'foreignKey' => 'prepared_by',
                        'conditions' => '',
                        'fields' => array('id', 'name'),
                        'order' => ''
                    ),
		'CapaSource' => array(
			'className' => 'CapaSource',
			'foreignKey' => 'capa_source_id',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'CapaCategory' => array(
			'className' => 'CapaCategory',
			'foreignKey' => 'capa_category_id',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'InternalAudit' => array(
			'className' => 'InternalAudit',
			'foreignKey' => 'internal_audit_id',
			'conditions' => '',
			'fields' => array('id', 'internal_audit_plan_id', 'start_time'),
			'order' => ''
		),
		'SuggestionForm' => array(
			'className' => 'SuggestionForm',
			'foreignKey' => 'suggestion_form_id',
			'conditions' => '',
			'fields' => array('id', 'title'),
			'order' => ''
		),
		'CustomerComplaint' => array(
			'className' => 'CustomerComplaint',
			'foreignKey' => 'customer_complaint_id',
			'conditions' => '',
			'fields' => array('id', 'customer_id', 'complaint_number', 'name'),
			'order' => ''
		),
		'SupplierRegistration' => array(
			'className' => 'SupplierRegistration',
			'foreignKey' => 'supplier_registration_id',
			'conditions' => '',
			'fields' => array('id', 'title'),
			'order' => ''
		),
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'product_id',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'Device' => array(
			'className' => 'Device',
			'foreignKey' => 'device_id',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'Material' => array(
			'className' => 'Material',
			'foreignKey' => 'material_id',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'SystemTable' => array(
			'className' => 'SystemTable',
			'foreignKey' => 'system_table_id',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'MasterListOfFormat' => array(
			'className' => 'MasterListOfFormat',
			'foreignKey' => 'master_list_of_format_id',
			'conditions' => '',
			'fields' => array('id', 'title', 'system_table_id'),
			'order' => ''
		),
		'BranchIds' => array(
			'className' => 'Branch',
			'foreignKey' => 'branchid',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'DepartmentIds' => array(
			'className' => 'Department',
			'foreignKey' => 'departmentid',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'AssignedTo' => array(
			'className' => 'Employee',
			'foreignKey' => 'assigned_to',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'CompletedBy' => array(
			'className' => 'Employee',
			'foreignKey' => 'completed_by',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'DeterminedBy' => array(
			'className' => 'Employee',
			'foreignKey' => 'determined_by',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'ActionAssignedTo' => array(
			'className' => 'Employee',
			'foreignKey' => 'action_assigned_to',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'ClosedBy' => array(
			'className' => 'Employee',
			'foreignKey' => 'closed_by',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
                ),
                'StatusUserId' => array(
                    'className' => 'User',
                    'foreignKey' => 'status_user_id',
                    'conditions' => '',
                    'fields' => array('id', 'name'),
                    'order' => ''
                ),
                'ChangeAdditionDeletionRequest' => array(
                    'className' => 'ChangeAdditionDeletionRequest',
                    'foreignKey' => 'change_addition_deletion_request_id',
                    'conditions' => '',
                    'fields' => array('id', 'master_list_of_format_id'),
                    'order' => ''
                )
    );

	public $customArray = array(
		    'capa_type' => array(
			'0' => 'Corrective Action',
			'1' => 'Preventive Action',
			'2' => 'Corrective and Preventive Action'
		    ),

	    'current_status' => array(
			'0' => 'Open',
			'1' => 'Close'
		),

	     'priority' => array(
			'0' => 'Low',
			'1' => 'Medium',
			'2' => 'High'
		),

	     'root_cause_analysis_required' => array(
			'0' => 'No',
			'1' => 'Yes'

		)

	    );
}
