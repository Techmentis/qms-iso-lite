<?php
App::uses('Material', 'Model');

/**
 * Material Test Case
 *
 */
class MaterialTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.material',
		'app.system_table',
		'app.master_list_of_format',
		'app.branch',
		'app.department',
		'app.courier_register',
		'app.user',
		'app.employee',
		'app.designation',
		'app.customer_complaint',
		'app.customer',
		'app.delivery_challan',
		'app.purchase_order',
		'app.supplier_registration',
		'app.device',
		'app.daily_backup_detail',
		'app.data_back_up',
		'app.data_type',
		'app.schedule',
		'app.housekeeping_responsibility',
		'app.housekeeping_checklist',
		'app.housekeeping',
		'app.list_of_software',
		'app.software_type',
		'app.training_need_identification',
		'app.training',
		'app.course',
		'app.course_type',
		'app.trainer',
		'app.trainer_type',
		'app.training_type',
		'app.list_of_trained_internal_auditor',
		'app.internal_audit_plan_department',
		'app.internal_audit_plan',
		'app.internal_audit_plan_branch',
		'app.internal_audit',
		'app.corrective_preventive_action',
		'app.capa_source',
		'app.capa_category',
		'app.internal_audit_detail',
		'app.timeline',
		'app.meeting',
		'app.document_amendment_record_sheet',
		'app.suggesion_form',
		'app.meeting_branch',
		'app.meeting_department',
		'app.meeting_employee',
		'app.meeting_attendee',
		'app.meeting_topic',
		'app.notification',
		'app.notification_type',
		'app.notification_user',
		'app.training_evaluation',
		'app.training_schedule',
		'app.training_schedule_branch',
		'app.training_schedule_department',
		'app.training_schedule_employee',
		'app.list_of_computer',
		'app.list_of_computer_list_of_software',
		'app.username_password_detail',
		'app.databackup_logbook',
		'app.order_details_form',
		'app.product',
		'app.purchase_order_detail',
		'app.supplier_evaluation_reevaluation',
		'app.list_of_acceptable_supplier',
		'app.supplier_category',
		'app.order_register',
		'app.delivery_challan_detail',
		'app.employee_designation',
		'app.employee_induction_training',
		'app.employee_training',
		'app.user_session',
		'app.evidence',
		'app.file_upload',
		'app.history',
		'app.language',
		'app.help',
		'app.approval',
		'app.message_user_inbox',
		'app.message',
		'app.message_user_sent',
		'app.message_user_thrash',
		'app.task',
		'app.department_benchmark',
		'app.fire_safety_equipment_list',
		'app.fire_extinguisher',
		'app.fire_extinguisher_type',
		'app.fire_type',
		'app.master_list_of_format_distributor',
		'app.report',
		'app.branch_benchmark',
		'app.master_list_of_format_branch',
		'app.master_list_of_format_department',
		'app.change_addition_deletion_request',
		'app.company',
		'app.company_benchmark',
		'app.custom_template',
		'app.internet_usage_detail',
		'app.list_of_measuring_devices_for_calibration',
		'app.material_list_with_shelf_life'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Material = ClassRegistry::init('Material');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Material);

		parent::tearDown();
	}

}
