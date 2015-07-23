<?php
App::uses('AppModel', 'Model');
/**
 * InternalAudit Model
 *
 * @property InternalAuditPlan $InternalAuditPlan
 * @property InternalAuditPlanDepartment $InternalAuditPlanDepartment
 * @property Department $Department
 * @property Branch $Branch
 * @property ListOfTrainedInternalAuditor $ListOfTrainedInternalAuditor
 * @property Employee $Employee
 * @property CorrectivePreventiveAction $CorrectivePreventiveAction
 * @property SystemTable $SystemTable
 * @property MasterListOfFormat $MasterListOfFormat
 * @property CorrectivePreventiveAction $CorrectivePreventiveAction
 * @property InternalAuditDetail $InternalAuditDetail
 */
class InternalAudit extends AppModel {
 public $displayField = "start_time";
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
		'internal_audit_plan_department_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
		'department_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
		'branch_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
		'section' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'start_time' => array(
			'datetime' => array(
				'rule' => array('datetime'),
			),
		),
		'end_time' => array(
			'datetime' => array(
				'rule' => array('datetime'),
			),
		),
		'list_of_trained_internal_auditor_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
		'employee_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
		'clauses' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'question_asked' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'finding' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'non_conformity_found' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			),
		),
		'current_status' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'employeeId' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
		'target_date' => array(
			'date' => array(
				'rule' => array('date'),
			),
		),
		'notes' => array(
			'notempty' => array(
				'rule' => array('notempty'),
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
		'InternalAuditPlan' => array(
			'className' => 'InternalAuditPlan',
			'foreignKey' => 'internal_audit_plan_id',
			'conditions' => '',
			'fields' => array('id', 'title'),
			'order' => ''
		),
		'InternalAuditPlanDepartment' => array(
			'className' => 'InternalAuditPlanDepartment',
			'foreignKey' => 'internal_audit_plan_department_id',
			'conditions' => '',
			'fields' => array('id'),
			'order' => ''
		),
		'Department' => array(
			'className' => 'Department',
			'foreignKey' => 'department_id',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'Branch' => array(
			'className' => 'Branch',
			'foreignKey' => 'branch_id',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'ListOfTrainedInternalAuditor' => array(
			'className' => 'ListOfTrainedInternalAuditor',
			'foreignKey' => 'list_of_trained_internal_auditor_id',
			'conditions' => '',
			'fields' => array('id', 'employee_id'),
			'order' => ''
		),
		'Employee' => array(
			'className' => 'Employee',
			'foreignKey' => 'employee_id',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'CorrectivePreventiveAction' => array(
			'className' => 'CorrectivePreventiveAction',
			'foreignKey' => 'corrective_preventive_action_id',
			'conditions' => '',
			'fields' => array('id', 'name', 'capa_source_id', 'priority', 'current_status', 'assigned_to'),
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
		)
	);
}
