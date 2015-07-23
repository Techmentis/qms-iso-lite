<?php

App::uses('AppModel', 'Model');

class Stock extends AppModel {
	var $name = 'Stock';
	var $validate = array(
		'quantity' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Quantity cant be empty',
				'allowEmpty' => false,
				'required' => true
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Quantity entered is not numeric',
				'allowEmpty' => false,
				'required' => true
			),
			'comparison' => array(
				'rule' => array('comparison','>=',0),
				'message' => 'Quantity entered cant be nagative',
				'allowEmpty' => false,
				'required' => true
			)

		),
		'consumed' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Consumed entered is not numeric',
				'allowEmpty' => true,
			),
			'ConsumedCompare' => array(
				'rule' => array('ConsumedCompare'),
				'message' => 'Consumed cant be greater then production quantity',
			)
		)
	);

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
		'Material' => array(
			'className' => 'Material',
			'foreignKey' => 'material_id',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'MaterialType' => array(
			'className' => 'MaterialType',
			'foreignKey' => 'material_type_id',
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
		'PurchaseOrder' => array(
			'className' => 'PurchaseOrder',
			'foreignKey' => 'purchase_order_id',
			'conditions' => '',
			'fields' => array('id', 'title'),
			'order' => ''
		),
		'DeliveryChallan' => array(
			'className' => 'DeliveryChallan',
			'foreignKey' => 'delivery_challan_id',
			'conditions' => '',
			'fields' => array('id', 'challan_number','purchase_order_id','name'),
			'order' => ''
		),
		'Production' => array(
			'className' => 'Production',
			'foreignKey' => 'production_id',
			'conditions' => '',
			'fields' => array('id', 'product_id', 'batch_number'),
			'order' => ''
		),
		'Branch' => array(
			'className' => 'Branch',
			'foreignKey' => 'branch_id',
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
		'StatusUserId' => array(
			'className' => 'User',
			'foreignKey' => 'status_user_id',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		)
	);

	function ConsumedCompare() {
		if (($this->data['Stock']['type'] == 1) && ($this->data['Stock']['consumed'] > $this->data['Stock']['quantity']) ) {
			return false;
		}
		return true;
	}

	function get_status($raw, $toDate, $fromDate = '0000-00-00') {

		$stockStatus = array(
			'Openstock' => 0,
			'fromdate' => $fromDate,
			'todate' => $toDate,
			'Totalin' => 0,
			'Totalinprod' => 0,
			'Totalconsumed' => 0,
			'Totalcurrent' => 0,
			'Totalwaste' => 0
		);

		//fetch opening stock
		$options = array(
			'fields' => array('sum(Stock.quantity) AS OTstock'),
			'conditions' => array(
				'Rawmaterial.name' => $raw,
				'Stock.type' => 0,
				'Stock.date <' => $fromDate ),
			'recursive' => 0
		);
		$inStock = $this->find('all',$options);
		$openingStock = $inStock[0][0]['OTstock'];

		//fetch opening production
		$options = array(
			'fields' => array('sum(Stock.quantity) AS OPstock'),
			'conditions' => array(
				'Rawmaterial.name' => $raw,
				'Stock.type' => 1,
				'Stock.date <' => $fromDate ),
			'recursive' => 0
		);
		$inStock = $this->find('all',$options);
		$stockStatus['Openstock'] = $openingStock - $inStock[0][0]['OPstock'];

		//fetch in stock
		$options = array(
			'fields' => array('sum(Stock.quantity) AS Tstock'),
			'conditions' => array(
				'Rawmaterial.name' => $raw,
				'Stock.type' => 0,
				'Stock.date BETWEEN ? AND ?' => array($fromDate,$toDate)
			),
			'recursive' => 0
		);
		$inStock = $this->find('all',$options);
		$stockStatus['Totalin'] = $inStock[0][0]['Tstock'];

		//fetch stock moved to production
				$options = array(
			'fields' => array('sum(Stock.quantity) AS Pstock','sum(Stock.consumed) AS Cstock'),
			'conditions' => array(
				'Rawmaterial.name' => $raw,
				'Stock.type' => 1,
				'Stock.date BETWEEN ? AND ?' => array($fromDate,$toDate)
			),
			'recursive' => 0
		);
		$inProduction = $this->find('all',$options);

		$stockStatus['Totalinprod'] = $inProduction[0][0]['Pstock'];
		$stockStatus['Totalconsumed'] = $inProduction[0][0]['Cstock'];

		$stockStatus['Totalcurrent'] = $stockStatus['Openstock'] + $stockStatus['Totalin'] - $stockStatus['Totalinprod'];
		$stockStatus['Totalwaste'] = $stockStatus['Totalinprod'] - $stockStatus['Totalconsumed'];

		return $stockStatus;
	}
}

