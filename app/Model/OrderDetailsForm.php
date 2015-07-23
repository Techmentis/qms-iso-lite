<?php
App::uses('AppModel', 'Model');
/**
 * OrderDetailsForm Model
 *
 * @property PurchaseOrder $PurchaseOrder
 * @property Product $Product
 * @property Device $Device
 * @property DeliveryChallan $DeliveryChallan
 * @property SystemTable $SystemTable
 * @property MasterListOfFormat $MasterListOfFormat
 */
class OrderDetailsForm extends AppModel {

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
		'purchase_order_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
		'order_date' => array(
			'date' => array(
				'rule' => array('date'),
			),
		),
		'delivery_date' => array(
			'date' => array(
				'rule' => array('date'),
			),
		),
		'delivery_challan_id' => array(
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
		'PurchaseOrder' => array(
			'className' => 'PurchaseOrder',
			'foreignKey' => 'purchase_order_id',
			'conditions' => '',
			'fields' => array('id', 'title', 'name'),
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
		'DeliveryChallan' => array(
			'className' => 'DeliveryChallan',
			'foreignKey' => 'delivery_challan_id',
			'conditions' => '',
			'fields' => array('id', 'challan_number', 'name'),
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
