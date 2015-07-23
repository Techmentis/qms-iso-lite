<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Employee $Employee
 * @property Department $Department
 * @property Branch $Branch
 * @property Language $Language
 * @property SystemTable $SystemTable
 * @property MasterListOfFormat $MasterListOfFormat
 * @property Approval $Approval
 * @property CourierRegister $CourierRegister
 * @property DataBackUp $DataBackUp
 * @property DataType $DataType
 * @property FileUpload $FileUpload
 * @property MessageUserInbox $MessageUserInbox
 * @property MessageUserSent $MessageUserSent
 * @property MessageUserThrash $MessageUserThrash
 * @property Message $Message
 * @property Task $Task
 * @property UserSession $UserSession
 */
class User extends AppModel {

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
		'employee_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
		'username' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
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
		'last_login' => array(
			'datetime' => array(
				'rule' => array('datetime'),
			),
		),
		'last_activity' => array(
			'datetime' => array(
				'rule' => array('datetime'),
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
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'company' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'email' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),'email' => array(
				'rule' => array('email'),
			),
		),
		'phone' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),'phone' => array(
				'rule' => array('phone'),
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
                        'order' => ''
                ),
                'PreparedBy' => array(
                        'className' => 'Employee',
                        'foreignKey' => 'prepared_by',
                        'conditions' => '',
                        'fields' => array('id', 'name'),
                        'order' => ''
                ),
		'Employee' => array(
			'className' => 'Employee',
			'foreignKey' => 'employee_id',
			'conditions' => '',
			'fields' => array('id', 'name', 'personal_email', 'office_email'),
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
		'Language' => array(
			'className' => 'Language',
			'foreignKey' => 'language_id',
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
			'fields' => array('id', 'name','is_smtp'),
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

/*
 * Custom validation method to ensure that the two entered passwords match
 *
 * @param string $password Password
 * @return boolean Success
 */
	public function confirmPassword($password = null) {
           	if ((isset($this->data[$this->alias]['password']) && isset($password['temppassword']))
			&& !empty($password['temppassword'])
			&& ($this->data[$this->alias]['password'] === $password['temppassword'])) {
			return true;
		}
		return false;
	}
    public function passwordReset($email = null, $userName = null) {
		$user = $this->find('first', array(
			'conditions' => array(
				'User.status' => 1,
				'Employee.office_email' => $email,
    'User.username' => $userName
)));

		$sixtyMins = time() + 43000;
		$token = $this->generateToken();

		$user['User']['password_token'] = $token;
		$user['User']['email_token_expires'] = date('Y-m-d H:i:s', $sixtyMins);
		$user = $this->save($user, false);
		$this->data = $user;
		return $user;

}
    public function generateToken($length = 10) {
		$possible = '0123456789abcdefghijklmnopqrstuvwxyz';
		$token = "";
		$i = 0;
		while ($i < $length) {
			$char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
			if (!stristr($token, $char)) {
				$token .= $char;
				$i++;
			}
		}
		return $token;
}
    public function checkPasswordToken($params = null) {
		$user = $this->find('first', array(
			'contain' => array(),
			'conditions' => array(
				'User.status' => 1,
				'User.password_token' => $params,
                            	'User.email_token_expires >=' => date('Y-m-d H:i:s')
                                )));
		if (empty($user)) {
			return false;
		}
		return $user;
	}
    public function resetPassword($postData = array()) {
		$result = false;
                $user = $this->find('first', array(
			'conditions' => array(
				'User.status' => 1,
				'User.password_token' => $postData['User']['token'])));
		$user['User']['password_token'] = null;
                $user['User']['password'] = Security::hash($postData['User']['password'],'md5',true);
		$user = $this->save($user, false);
		return $user;
	}



}
