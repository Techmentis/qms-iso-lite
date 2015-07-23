<?php
App::uses('AppModel', 'Model');
/**
 * AppraisalQuestion Model
 *
 * @property SystemTable $SystemTable
 * @property MasterListOfFormat $MasterListOfFormat
 * @property Company $Company
 */
class AppraisalQuestion extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
        public $validate = array(
                'sr_no' => array(
                        'numeric' => array(
                        ),
                ),
                'question' => array(
                        'question' => array(
                                'required' => true,
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
}
