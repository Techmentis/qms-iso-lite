<?php
/**
 * UserFixture
 *
 */
class UserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sr_no' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'employee_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'username' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 24, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'password' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 24, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'is_mr' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'is_view_all' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'is_approvar' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'status' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 1),
		'department_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'branch_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'language_id' => array('type' => 'string', 'null' => true, 'default' => '1', 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'login_status' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 1),
		'last_login' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'last_activity' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_access' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'copy_acl_from' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'benchmark' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 5),
		'publish' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '0=Un 1=Pub'),
		'soft_delete' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '1=deleted'),
		'branchid' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'comment' => 'system defined automatically add', 'charset' => 'latin1'),
		'departmentid' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'comment' => 'system defined automatically add', 'charset' => 'latin1'),
		'password_token' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 225, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'email_token_expires' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created_by' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'comment' => 'system defined automatically add', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'system defined automatically add'),
		'modified_by' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'comment' => 'system defined automatically add', 'charset' => 'latin1'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'system defined automatically add'),
		'system_table_id' => array('type' => 'string', 'null' => true, 'default' => '0', 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'master_list_of_format_id' => array('type' => 'string', 'null' => true, 'default' => '0', 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'username' => array('column' => 'username', 'unique' => 1),
			'username_2' => array('column' => 'username', 'unique' => 1),
			'sr_no' => array('column' => 'sr_no', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_bin', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '528c9a0c-9260-4c70-8f51-14c9c6c3268c',
			'sr_no' => 1,
			'employee_id' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'username' => 'Lorem ipsum dolor sit ',
			'password' => 'Lorem ipsum dolor sit ',
			'is_mr' => 1,
			'is_view_all' => 1,
			'is_approvar' => 1,
			'status' => 1,
			'department_id' => 'Lorem ipsum dolor sit amet',
			'branch_id' => 'Lorem ipsum dolor sit amet',
			'language_id' => 'Lorem ipsum dolor sit amet',
			'login_status' => 1,
			'last_login' => '2013-11-20 16:46:28',
			'last_activity' => '2013-11-20 16:46:28',
			'user_access' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'copy_acl_from' => 'Lorem ipsum dolor sit amet',
			'benchmark' => 1,
			'publish' => 1,
			'soft_delete' => 1,
			'branchid' => 'Lorem ipsum dolor sit amet',
			'departmentid' => 'Lorem ipsum dolor sit amet',
			'password_token' => 'Lorem ipsum dolor sit amet',
			'email_token_expires' => '2013-11-20 16:46:28',
			'created_by' => 'Lorem ipsum dolor sit amet',
			'created' => '2013-11-20 16:46:28',
			'modified_by' => 'Lorem ipsum dolor sit amet',
			'modified' => '2013-11-20 16:46:28',
			'system_table_id' => 'Lorem ipsum dolor sit amet',
			'master_list_of_format_id' => 'Lorem ipsum dolor sit amet'
		),
	);

}
