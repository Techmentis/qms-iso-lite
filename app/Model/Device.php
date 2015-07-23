<?php
App::uses('AppModel', 'Model');
/**
 * Device Model
 *
 * @property SupplierRegistration $SupplierRegistration
 * @property Employee $Employee
 * @property Branch $Branch
 * @property Department $Department
 * @property SystemTable $SystemTable
 * @property MasterListOfFormat $MasterListOfFormat
 * @property Company $Company
 * @property Calibration $Calibration
 * @property CorrectivePreventiveAction $CorrectivePreventiveAction
 * @property DailyBackupDetail $DailyBackupDetail
 * @property DeliveryChallanDetail $DeliveryChallanDetail
 * @property OrderDetailsForm $OrderDetailsForm
 * @property PurchaseOrderDetail $PurchaseOrderDetail
 * @property SupplierEvaluationReevaluation $SupplierEvaluationReevaluation
 */
class Device extends AppModel {

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
		'number' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'serial' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'manual' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'sparelist' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'description' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'make_type' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'purchase_date' => array(
			'date' => array(
				'rule' => array('date'),
			),
		),
		'employee_id' => array(
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
		'SupplierRegistration' => array(
			'className' => 'SupplierRegistration',
			'foreignKey' => 'supplier_registration_id',
			'conditions' => '',
			'fields' => array('id', 'title'),
			'order' => ''
		),
		'Employee' => array(
			'className' => 'Employee',
			'foreignKey' => 'employee_id',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'CalibrationFrequency' => array(
			'className' => 'Schedule',
			'foreignKey' => 'calibration_frequency',
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
		'Department' => array(
			'className' => 'Department',
			'foreignKey' => 'department_id',
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
	    'MaintenanceFrequency' => array(
			'className' => 'Schedule',
			'foreignKey' => 'maintenance_frequency',
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

	public $customArray = array('sparelist' => array(
			'0' => 'Available',
			'1' => 'Not Available',
	                '2' => 'Not Required'
	  	    ),
		    'manual' => array(
			'0' => 'Available',
			'1' => 'Not Available',
			'2' => 'Not Required'
		    ),
		    'calibration_required' => array(
			'0' => 'Yes',
			'1' => 'No',
		    ),
		    'maintenance_required' => array(
			'0' => 'No',
			'1' => 'Yes',
		    )
	    );
}
