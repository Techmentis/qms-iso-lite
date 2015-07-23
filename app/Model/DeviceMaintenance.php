<?php
App::uses('AppModel', 'Model');
/**
 * DeviceMaintenance Model
 *
 * @property Device $Device
 * @property Employee $Employee
 * @property IntimationSentToEmployee $IntimationSentToEmployee
 * @property IntimationSentToDepartment $IntimationSentToDepartment
 * @property SystemTable $SystemTable
 * @property MasterListOfFormat $MasterListOfFormat
 * @property Company $Company
 */
class DeviceMaintenance extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name

 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'device_id' => array(
                        'notempty' => array(
				'rule' => array('notempty'),
			),
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),'employee_id' => array(
                        'notempty' => array(
				'rule' => array('notempty'),
			),
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
		'maintenance__performed_date' => array(
			'date' => array(
				'rule' => array('date'),
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
		'Device' => array(
			'className' => 'Device',
			'foreignKey' => 'device_id',
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
		'IntimationSentToEmployee' => array(
			'className' => 'Employee',
			'foreignKey' => 'intimation_sent_to_employee_id',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'IntimationSentToDepartment' => array(
			'className' => 'Department',
			'foreignKey' => 'intimation_sent_to_department_id',
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

	public $customArray = array(


	    'status' => array(
			'0' => 'Not in use',
			'1' => 'In use'
		),
	);
}
