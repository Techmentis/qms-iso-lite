<?php
/**
 * SupplierCategoryFixture
 *
 */
class SupplierCategoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sr_no' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 120, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'publish' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '0=Un 1=Pub'),
		'soft_delete' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '1=deleted'),
		'branchid' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'comment' => 'system defined automatically add', 'charset' => 'latin1'),
		'departmentid' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'comment' => 'system defined automatically add', 'charset' => 'latin1'),
		'created_by' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'comment' => 'system defined automatically add', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'system defined automatically add'),
		'modified_by' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'comment' => 'system defined automatically add', 'charset' => 'latin1'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'system defined automatically add'),
		'system_table_id' => array('type' => 'string', 'null' => true, 'default' => '0', 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'master_list_of_format_id' => array('type' => 'string', 'null' => true, 'default' => '0', 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'sr_no' => array('column' => 'sr_no', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '528c99d2-cd14-4a3b-ad4d-14c9c6c3268c',
			'sr_no' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'publish' => 1,
			'soft_delete' => 1,
			'branchid' => 'Lorem ipsum dolor sit amet',
			'departmentid' => 'Lorem ipsum dolor sit amet',
			'created_by' => 'Lorem ipsum dolor sit amet',
			'created' => '2013-11-20 16:45:30',
			'modified_by' => 'Lorem ipsum dolor sit amet',
			'modified' => '2013-11-20 16:45:30',
			'system_table_id' => 'Lorem ipsum dolor sit amet',
			'master_list_of_format_id' => 'Lorem ipsum dolor sit amet'
		),
	);

}
