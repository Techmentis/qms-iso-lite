<?php
App::uses('AppModel', 'Model');
/**
 * Employee Model
 *
 * @property Branch $Branch
 * @property Designation $Designation
 * @property SystemTable $SystemTable
 * @property MasterListOfFormat $MasterListOfFormat
 * @property Company $Company
 * @property Appraisal $Appraisal
 * @property ChangeAdditionDeletionRequest $ChangeAdditionDeletionRequest
 * @property CompetencyMapping $CompetencyMapping
 * @property CustomerComplaint $CustomerComplaint
 * @property CustomerMeeting $CustomerMeeting
 * @property DailyBackupDetail $DailyBackupDetail
 * @property DatabackupLogbook $DatabackupLogbook
 * @property Device $Device
 * @property DocumentAmendmentRecordSheet $DocumentAmendmentRecordSheet
 * @property EmployeeDesignation $EmployeeDesignation
 * @property EmployeeInductionTraining $EmployeeInductionTraining
 * @property EmployeeKra $EmployeeKra
 * @property EmployeeTraining $EmployeeTraining
 * @property HousekeepingResponsibility $HousekeepingResponsibility
 * @property Housekeeping $Housekeeping
 * @property InternalAuditDetail $InternalAuditDetail
 * @property InternalAuditPlanDepartment $InternalAuditPlanDepartment
 * @property InternalAudit $InternalAudit
 * @property ListOfComputer $ListOfComputer
 * @property ListOfSoftware $ListOfSoftware
 * @property ListOfTrainedInternalAuditor $ListOfTrainedInternalAuditor
 * @property MaterialQualityCheckDetail $MaterialQualityCheckDetail
 * @property MeetingAttendee $MeetingAttendee
 * @property MeetingTopic $MeetingTopic
 * @property NotificationUser $NotificationUser
 * @property Production $Production
 * @property ProposalFollowup $ProposalFollowup
 * @property Proposal $Proposal
 * @property SuggestionForm $SuggestionForm
 * @property SummeryOfSupplierEvaluation $SummeryOfSupplierEvaluation
 * @property Task $Task
 * @property TrainingNeedIdentification $TrainingNeedIdentification
 * @property UserSession $UserSession
 * @property UsernamePasswordDetail $UsernamePasswordDetail
 * @property User $User
 */
class Employee extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(

		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'allowEmpty' => false,
				'required' => true,
			),
		),
		'employee_number' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),'office_email' =>  array(
                        'notEmpty' => array(
                            'rule' => array('notempty'),
                            'message' => 'Provide an email address'
                        ),
                        'validEmailRule' => array(
                            'rule' => 'email',
                            'message' => 'Invalid email address'
                        ),
                        'uniqueEmailRule' => array(
                            'rule' =>array('isUnique'),
                            'message' => 'Email already registered'
                        )

                 ),'designation_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
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
		'Branch' => array(
			'className' => 'Branch',
			'foreignKey' => 'branch_id',
			'conditions' => '',
			'fields' => array('id', 'name'),
			'order' => ''
		),
		'Designation' => array(
			'className' => 'Designation',
			'foreignKey' => 'designation_id',
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

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'EmployeeTraining' => array(
			'className' => 'EmployeeTraining',
			'foreignKey' => 'employee_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'TrainingNeedIdentification' => array(
			'className' => 'TrainingNeedIdentification',
			'foreignKey' => 'employee_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public $customArray = array('employment_status' => array(
			'0' => 'Resigned',
			'1' => 'Active'
	  	    )
	);

}
