<?php
App::uses('AppModel', 'Model');
/**
 * MeetingTopic Model
 *
 * @property Meeting $Meeting
 * @property SystemTable $SystemTable
 * @property MasterListOfFormat $MasterListOfFormat
 */
class MeetingTopic extends AppModel {

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
		'meeting_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
		'title' => array(
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
		'Meeting' => array(
			'className' => 'Meeting',
			'foreignKey' => 'meeting_id',
			'conditions' => '',
			'fields' => array('id', 'title'),
			'order' => ''
		),'Employee' => array(
			'className' => 'Employee',
			'foreignKey' => 'employee_id',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'ChangeAdditionDeletionRequest' => array(
			'className' => 'ChangeAdditionDeletionRequest',
			'foreignKey' => 'change_addition_deletion_request_id',
			'conditions' => '',
			'fields' => array('id', 'master_list_of_format'),
			'order' => ''
		),
		'CorrectivePreventiveAction' => array(
			'className' => 'CorrectivePreventiveAction',
			'foreignKey' => 'corrective_preventive_action_id',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'CustomerComplaint' => array(
			'className' => 'CustomerComplaint',
			'foreignKey' => 'customer_complaint_id',
			'conditions' => '',
			'fields' => array('id', 'customer_id', 'name'),
			'order' => ''
		),
		'CustomerFeedback' => array(
			'className' => 'CustomerFeedback',
			'foreignKey' => 'customer_feedback_id',
			'conditions' => '',
			'fields' => array('id', 'customer_id', 'customer_feedback_question_id'),
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
