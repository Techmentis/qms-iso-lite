<?php
App::uses('AppModel', 'Model');
/**
 * Training Model
 *
 * @property Course $Course
 * @property Trainer $Trainer
 * @property TrainerType $TrainerType
 * @property TrainingType $TrainingType
 * @property SystemTable $SystemTable
 * @property MasterListOfFormat $MasterListOfFormat
 * @property ListOfTrainedInternalAuditor $ListOfTrainedInternalAuditor
 * @property TrainingEvaluation $TrainingEvaluation
 * @property TrainingNeedIdentification $TrainingNeedIdentification
 * @property TrainingSchedule $TrainingSchedule
 */
class Training extends AppModel {

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
		'description' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'course_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
		'trainer_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
		'trainer_type_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
		'course_type_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			),
		),
		'start_date_time' => array(
			'datetime' => array(
				'rule' => array('datetime'),
			),
		),
		'end_date_time' => array(
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
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => array('id', 'title'),
			'order' => ''
		),
		'Trainer' => array(
			'className' => 'Trainer',
			'foreignKey' => 'trainer_id',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'TrainerType' => array(
			'className' => 'TrainerType',
			'foreignKey' => 'trainer_type_id',
			'conditions' => '',
			'fields' => array('id', 'title'),
			'order' => ''
		),
		'CourseType' => array(
			'className' => 'CourseType',
			'foreignKey' => 'course_type_id',
			'conditions' => '',
			'fields' => array('id', 'title'),
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
