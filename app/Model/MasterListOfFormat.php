<?php
App::uses('AppModel', 'Model');
/**
 * MasterListOfFormat Model
 *
 * @property SystemTable $SystemTable
 * @property BranchBenchmark $BranchBenchmark
 * @property Branch $Branch
 * @property CapaCategory $CapaCategory
 * @property CapaSource $CapaSource
 * @property ChangeAdditionDeletionRequest $ChangeAdditionDeletionRequest
 * @property Company $Company
 * @property CompanyBenchmark $CompanyBenchmark
 * @property CorrectivePreventiveAction $CorrectivePreventiveAction
 * @property CourierRegister $CourierRegister
 * @property CourseType $CourseType
 * @property Course $Course
 * @property CustomTemplate $CustomTemplate
 * @property CustomerComplaint $CustomerComplaint
 * @property Customer $Customer
 * @property DailyBackupDetail $DailyBackupDetail
 * @property DataBackUp $DataBackUp
 * @property DataType $DataType
 * @property DatabackupLogbook $DatabackupLogbook
 * @property DeliveryChallan $DeliveryChallan
 * @property DepartmentBenchmark $DepartmentBenchmark
 * @property Department $Department
 * @property Designation $Designation
 * @property Device $Device
 * @property DocumentAmendmentRecordSheet $DocumentAmendmentRecordSheet
 * @property EmployeeDesignation $EmployeeDesignation
 * @property EmployeeInductionTraining $EmployeeInductionTraining
 * @property EmployeeTraining $EmployeeTraining
 * @property Employee $Employee
 * @property Evidence $Evidence
 * @property FileUpload $FileUpload
 * @property FireExtinguisherType $FireExtinguisherType
 * @property FireExtinguisher $FireExtinguisher
 * @property FireSafetyEquipmentList $FireSafetyEquipmentList
 * @property FireType $FireType
 * @property Help $Help
 * @property History $History
 * @property HousekeepingChecklist $HousekeepingChecklist
 * @property HousekeepingResponsibility $HousekeepingResponsibility
 * @property Housekeeping $Housekeeping
 * @property InternalAuditDetail $InternalAuditDetail
 * @property InternalAuditPlanBranch $InternalAuditPlanBranch
 * @property InternalAuditPlanDepartment $InternalAuditPlanDepartment
 * @property InternalAuditPlan $InternalAuditPlan
 * @property InternalAudit $InternalAudit
 * @property InternetUsageDetail $InternetUsageDetail
 * @property Language $Language
 * @property ListOfAcceptableSupplier $ListOfAcceptableSupplier
 * @property ListOfComputerListOfSoftware $ListOfComputerListOfSoftware
 * @property ListOfComputer $ListOfComputer
 * @property ListOfMeasuringDevicesForCalibration $ListOfMeasuringDevicesForCalibration
 * @property ListOfSoftware $ListOfSoftware
 * @property ListOfTrainedInternalAuditor $ListOfTrainedInternalAuditor
 * @property MasterListOfFormatBranch $MasterListOfFormatBranch
 * @property MasterListOfFormatDepartment $MasterListOfFormatDepartment
 * @property MasterListOfFormatDistributor $MasterListOfFormatDistributor
 * @property MaterialListWithShelfLife $MaterialListWithShelfLife
 * @property Material $Material
 * @property MeetingBranch $MeetingBranch
 * @property MeetingDepartment $MeetingDepartment
 * @property MeetingEmployee $MeetingEmployee
 * @property MeetingTopic $MeetingTopic
 * @property Meeting $Meeting
 * @property MessageUserInbox $MessageUserInbox
 * @property MessageUserSent $MessageUserSent
 * @property MessageUserThrash $MessageUserThrash
 * @property Message $Message
 * @property NotificationType $NotificationType
 * @property OrderDetailsForm $OrderDetailsForm
 * @property OrderRegister $OrderRegister
 * @property Product $Product
 * @property PurchaseOrderDetail $PurchaseOrderDetail
 * @property PurchaseOrder $PurchaseOrder
 * @property Report $Report
 * @property Schedule $Schedule
 * @property SoftwareType $SoftwareType
 * @property SuggestionForm $SuggestionForm
 * @property SupplierCategory $SupplierCategory
 * @property SupplierEvaluationReevaluation $SupplierEvaluationReevaluation
 * @property SupplierRegistration $SupplierRegistration
 * @property SystemTable $SystemTable
 * @property Task $Task
 * @property TrainerType $TrainerType
 * @property Trainer $Trainer
 * @property TrainingEvaluation $TrainingEvaluation
 * @property TrainingNeedIdentification $TrainingNeedIdentification
 * @property TrainingScheduleBranch $TrainingScheduleBranch
 * @property TrainingScheduleDepartment $TrainingScheduleDepartment
 * @property TrainingScheduleEmployee $TrainingScheduleEmployee
 * @property TrainingSchedule $TrainingSchedule
 * @property TrainingType $TrainingType
 * @property Training $Training
 * @property UsernamePasswordDetail $UsernamePasswordDetail
 * @property User $User
 */
class MasterListOfFormat extends AppModel {

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
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'document_number' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'issue_number' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'revision_date' => array(
			'date' => array(
				'rule' => array('date'),
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
                'SystemTable' => array(
			'className' => 'SystemTable',
			'foreignKey' => 'system_table_id',
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
		'Department' => array(
			'className' => 'Department',
			'foreignKey' => 'departmentid',
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
		'ApprovedBy' => array(
			'className' => 'Employee',
			'foreignKey' => 'approved_by',
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
           'DocumentAmendmentRecordSheet' => array(
			'className' => 'DocumentAmendmentRecordSheet',
			'foreignKey' => 'master_list_of_format',
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
		'ChangeAdditionDeletionRequest' => array(
			'className' => 'ChangeAdditionDeletionRequest',
			'foreignKey' => 'master_list_of_format',
			'dependent' => true,
			'conditions' => array('ChangeAdditionDeletionRequest.document_change_accepted'=>0),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
}
