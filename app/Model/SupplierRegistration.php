<?php
App::uses('AppModel', 'Model');
/**
 * SupplierRegistration Model
 *
 * @property SupplierCategory $SupplierCategory
 * @property SystemTable $SystemTable
 * @property MasterListOfFormat $MasterListOfFormat
 * @property CorrectivePreventiveAction $CorrectivePreventiveAction
 * @property DeliveryChallan $DeliveryChallan
 * @property Device $Device
 * @property ListOfAcceptableSupplier $ListOfAcceptableSupplier
 * @property ListOfComputer $ListOfComputer
 * @property OrderRegister $OrderRegister
 * @property PurchaseOrder $PurchaseOrder
 * @property SummeryOfSupplierEvaluation $SummeryOfSupplierEvaluation
 * @property SupplierEvaluationReevaluation $SupplierEvaluationReevaluation
 */
class SupplierRegistration extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
    public $displayField = 'title';
	public $validate = array(
		'sr_no' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'number' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'type_of_company' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'contact_person_office' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'designition_in_office' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'office_address' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'office_telephone' => array(
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
		'SupplierCategory' => array(
			'className' => 'SupplierCategory',
			'foreignKey' => 'supplier_category_id',
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
		    'iso_certified' => array(
			'0' => 'No',
			'1' => 'Yes',
		    ),
                    'supplier_selected'=>array(
                        '0' => 'Yes',
			'1' => 'No',
                        '2' =>'On hold'
                    )
	    );
}
