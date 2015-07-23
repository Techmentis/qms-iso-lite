<?php
App::uses('AppModel', 'Model');
/**
 * InternalAuditPlanDepartment Model
 *
 * @property InternalAuditPlan $InternalAuditPlan
 * @property Department $Department
 * @property Employee $Employee
 * @property ListOfTrainedInternalAuditor $ListOfTrainedInternalAuditor
 * @property SystemTable $SystemTable
 * @property MasterListOfFormat $MasterListOfFormat
 */
class InternalAuditPlanDepartment extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(

                'clauses' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
                 'startTime' => array(
			'date' => array(
				'rule' => array('date'),
			),
		),
                  'endTime' => array(
			'date' => array(
				'rule' => array('date'),
			),
		),
		'internal_audit_plan_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
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
		'Employee' => array(
			'className' => 'Employee',
			'foreignKey' => 'employee_id',
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
