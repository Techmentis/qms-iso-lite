<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc.
  (http://cakefoundation.org)
 * @link http://cakephp.org CakePHP(tm) Project
 * @package app.Controller
 * @since CakePHP(tm) v 0.2.9
 * @license http://www.opensource.org/licenses/mit-license.php MIT License */
App::uses('Controller', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller */
App::import('Sanitize');


class AppController extends Controller {

    public $components = array(
		'RequestHandler',
		'Session',
		'AjaxMultiUpload.Upload',
		);
    public $helpers = array(
        'Js',
        'Session',
        'Paginator',
        'Tinymce'
    );


    public $user = null;
    public $userids = null;
    public $message_count = null;
    public $notification_count = null;
    public $branchIDYes = false;


    public function beforeFilter() {
	$_SESSION['show_all_formats'] = null;
	$lang = $this->Session->read('SessionLanguage');


	if(isset($lang))
	{
	    Configure::write('Config.language', $this->Session->read('SessionLanguage'));
	}else{
		$this->loadModel('User');
		$user_data = $this->User->find('first', array(
                                        'conditions' => array(
                                            'User.id' => $this->Session->read('User.id')  ),
                                        'recursive' => - 1
                                    ));

		$this->loadModel('Language');
		$language_data = array();
		if($user_data){
		$language_data = $this->Language->find('first', array(
                                        'conditions' => array(
                                            'Language.id' => $user_data['User']['language_id']  ),
                                        'recursive' => - 1
                                    ));
	    $this->Session->write('SessionLanguage',null);
		if($language_data){
			if($language_data['Language']['short_code']){
			Configure::write('Config.language', $language_data['Language']['short_code']);
			}else{
			Configure::write('Config.language', 'eng');
			}
		}
		}
	}

        $track = null;
        if (isset($user)) {
		if ($this->Session->read('TANDC') == 1 or $user['User']['agree'] == 1) {
                if ($this->action != 'terms_and_conditions' && $this->action != 'logout') {
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'terms_and_conditions'
                    ));
                }
            }
        } else {
            if ($this->Session->read('TANDC') == 1) {
                if ($this->action != 'terms_and_conditions' &&  $this->action != 'logout' &&  $this->action != 'language_details' ) {
			$this->redirect(array(
                        'controller' => 'users',
                        'action' => 'terms_and_conditions'
                    ));
                }
            }
        }


        if ($this->Session->read('User.is_mr') == 0)$this->_check_access();
        if (
	    $this->action != 'display_notifications' &&
	    $this->action != 'timeline' &&
	    $this->action != 'data_json' &&
	    Inflector::Classify($this->name) != 'App' &&
	    Inflector::Classify($this->name) != 'CakeError' &&
	    $this->action != 'capa_assigned' &&
	    $this->action != 'get_customer_complaints' &&
	    $this->action != 'get_next_calibration' &&
	    $this->action != 'get_material_qc_required' &&
	    $this->action != 'get_delivered_material_qc' &&
	    $this->action != 'get_device_maintainance' &&
	    $this->action != 'dashboard_files' &&
	    $this->action != 'get_task' &&
	    $this->action != 'dashboard_files' &&
	    $this->request->params['controller'] != 'user_sessions' &&
	    ($this->request->params['controller'] != 'master_list_of_format_departments' && $this->action != 'listing')
	)
	{
	    if($this->Session->read('User'))$this->_track_history();
	}


	$this->set('controllerName', $this->request['controller']);

         if ($this->request->is('post') || $this->request->is('put')) {            
            array_walk_recursive($this->request->data, function(&$val, $key) {
                $val = trim($val);
            });

            $this->request->data = $this->request->data;
			if($this->action != 'login'){
            if (!isset($this->request->data[$this->modelClass]['publish']) && isset($this->request->data['Approval']['user_id']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
			}
        }
        if ($this->action == 'publish_record' || $this->action == 'delete') {
            $model = Inflector::classify($this->request->params['controller']);
            $this->loadModel($model);
            if($model != 'MessageUserThrash' && $model != 'MessageUserSent' && $model != 'Message' && $model != 'MessageUserInbox' && $model != 'UserSession'){
            $recordStatus = $this->$model->find('first',array('fields'=>array($model.'.record_status'),'conditions'=>array($model.'.id'=>$this->request->params['pass'][0])));
            if($recordStatus[$model]['record_status'] == 1){
               $this->Session->setFlash(__('Access Denied'));
                        if ($this->params->action != 'access_denied')
                            $this->redirect(array(
                                'controller' => 'users',
                                'action' => 'access_denied'
                            ));
                    }
            }
        }

    }

    public function _check_access() {

        $newData = null;
        $userAccess = null;
        $this->loadModel('User');
        $this->User->recursive = 0;
        $userAccess = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Session->read('User.id')
            ),
            'fields' => array(
                'User.user_access'
            )
        ));
        if ($userAccess)
            $newData = json_decode($userAccess['User']['user_access'], true);
        if (!$newData) {

	    if (($this->params->controller != 'users') && (($this->action != 'terms_and_conditions') || ($this->action != 'register') || ($this->params->action != 'check_email') || ($this->params->action != 'login') || ($this->params->action != 'logout') || ($this->params->action != 'reset_password') || ($this->params->action != 'check_registration') ||($this->action != 'appraisal_answers') || ($this->action != 'smtp_details'))) {

		if ($this->params->action != 'access_denied' && $this->params->action != 'testemail' && $this->params->action != 'appraisal_answers' &&    $this->params->action != 'language_details')
		    {


			if($this->Session->read('User') == null){
			    $this->Session->setFlash(__('Please login to continue'), 'default', array('class'=>'alert-danger'));
			    $this->redirect(array('controller' => 'users','action' => 'login'));
			}else{
			    $this->Session->setFlash(__('Access Denied'), 'default', array('class'=>'alert-danger'));
			    $this->redirect(array('controller' => 'users','action' => 'access_denied'));
			}
		    }
            }

        }
        if ($newData) {

            foreach ($newData['user_access'] as $model => $actionValue):
                if (strtolower(str_replace("_", "", strtolower($model))) == strtolower(str_replace("_", "", $this->params->controller))) {
                    if ($this->params->action != '' || $this->params->action != 'timeline') {
                        if (isset($actionValue[$this->params->action]) != true || $actionValue[$this->params->action] != 1) {

		            if (($this->params->action != 'login') && ($this->params->action != 'register') && ($this->params->action != 'check_email') && ($this->params->action != 'logout') && ($this->params->action != 'dashboard') && ($this->params->action != 'smtp_details') && ($this->params->action != 'terms_and_conditions') && ($this->params->action != 'check_registration') && ($this->params->action != 'reset_password') && ($this->params->action != 'appraisal_answers') && ($this->params->action != 'edit') && ($this->params->action != 'view') && ($this->params->action != 'approve') && $this->params->action != 'meeting_view' && $this->params->action != 'get_material_qc_required' && $this->params->action != 'get_delivered_material_qc' && $this->params->action != 'capa_assigned' && $this->params->action != 'get_customer_complaints' && $this->params->action != 'get_next_calibration' && $this->params->action != 'get_device_maintainance' ) {
                                $this->Session->setFlash(__('Access Denied'));
                                if ($this->params->action != 'access_denied')
                                    $this->redirect(array(
                                        'controller' => 'users',
                                        'action' => 'access_denied'
                                    ));
                            }
                            else {
                                if ($this->params->controller == 'meetings' && $this->params->action == 'meeting_view') {
                                    $this->loadModel('MeetingEmployee');
                                    $invite = $this->MeetingEmployee->find('first', array(
                                        'conditions' => array(
                                            'MeetingEmployee.meeting_id' => $this->params['pass'][0],
                                            'MeetingEmployee.employee_id' => $this->Session->read('User.employee_id')
                                        ),
                                        'recursive' => - 1
                                    ));

                                    if ($invite == 0) {
                                        $this->Session->setFlash(__('Access Denied'));
                                        if ($this->params->action != 'access_denied')
                                            $this->redirect(array(
                                                'controller' => 'users',
                                                'action' => 'access_denied'
                                            ));
                                    }
                                    else {
                                        break;
                                    }
                                } else if ($this->params->controller == 'notifications') {
				                    $this->loadModel('NotificationUser');
                                    $invite = $this->NotificationUser->find('first', array(
                                        'conditions' => array(
                                            'NotificationUser.notification_id' => $this->params['pass'][0],
                                            'NotificationUser.employee_id' => $this->Session->read('User.employee_id')
                                        ),
                                        'recursive' => - 1
                                    ));

                                    if ($invite == 0) {
                                        $this->Session->setFlash(__('Access Denied'));
                                        if ($this->params->action != 'access_denied')
                                            $this->redirect(array(
                                                'controller' => 'users',
                                                'action' => 'access_denied'
                                            ));
                                    }
                                    else {
                                        break;
                                    }
                                }  else
                                if ($this->params->controller == 'corrective_preventive_actions') {
                                    $this->loadModel('CorrectivePreventiveAction');
                                    if($this->params->action == 'capa_assigned'){
                                        $condition =  array('CorrectivePreventiveAction.assigned_to' => $this->Session->read('User.employee_id'));
                                    }else{
                                        $condition = array( 'CorrectivePreventiveAction.id' => $this->params['pass'][0],
                                            'CorrectivePreventiveAction.assigned_to' => $this->Session->read('User.employee_id')
                                            );
                                    }
                                    $capa = $this->CorrectivePreventiveAction->find('first', array(
                                        'conditions' => array(
                                           $condition
                                        ),
                                        'recursive' => - 1
                                    ));
                                    if (count($capa) == 0) {
					               if($this->params->action == 'capa_assigned') exit();
                                        if($this->action = 'approve'){
                                         $this->loadModel('Approval');
                                         $count = $this->Approval->find('count',array('conditions'=>array( 'Approval.record' => $this->params['pass'][0],
                                         'Approval.user_id' => $this->Session->read('User.id'),
                                            'Approval.record_status' => 1
                                            )));
                                         if($count)
                                            break;
                                        }
                                       
                                        $this->Session->setFlash(__('Access Denied'));
                                        if ($this->params->action != 'access_denied')
                                            $this->redirect(array(
                                                'controller' => 'users',
                                                'action' => 'access_denied'
                                            ));
                                    }
                                    else {
                                        break;
                                    }
                                } else
                                if ($this->params->controller == 'customer_complaints') {
                                    $this->loadModel('CustomerComplaint');
                                      if($this->params->action == 'get_customer_complaints'){
                                            $condition =  array('CustomerComplaint.employee_id' => $this->Session->read('User.employee_id'));
                                        }else{
                                            $condition = array(
                                                'CustomerComplaint.id' => $this->params['pass'][0],
                                                'CustomerComplaint.employee_id' => $this->Session->read('User.employee_id'),
                                               
                                            );
                                        }
                                        $custComplaint = $this->CustomerComplaint->find('first', array(
                                            'conditions' => $condition,
                                            'recursive' => - 1
                                        ));
                                    if (count($custComplaint) == 0) {
                                          if($this->params->action == 'get_customer_complaints') break;
						          if($this->action = 'approve'){
				                         $this->loadModel('Approval');
				                         $count = $this->Approval->find('count',array('conditions'=>array( 'Approval.record' => $this->params['pass'][0],
				                          'Approval.user_id' => $this->Session->read('User.id'),
				                          'Approval.record_status' => 1
				                            )));
					                 if($count)
					                    break;
					                }
                                        $this->Session->setFlash(__('Access Denied'));
                                        if ($this->params->action != 'access_denied')
                                            $this->redirect(array(
                                                'controller' => 'users',
                                                'action' => 'access_denied'
                                            ));
                                    }
                                    else {
                                        break;
                                    }
                                } elseif ($this->params->controller == 'materials' && $this->params->action == 'get_material_qc_required') {
                                        break;
                                } elseif ($this->params->controller == 'delivery_challans' && $this->params->action == 'get_delivered_material_qc') {
                                        break;
                                } elseif ($this->params->controller == 'calibrations' && $this->params->action == 'get_next_calibration') {
                                        break;
                                } elseif ($this->params->controller == 'device_maintenances' && $this->params->action == 'get_device_maintainance') {
                                        break;
                                } elseif ($this->params->action == 'approve') {
                                    $this->loadModel('Approval');
                                    $approval = $this->Approval->find('first', array(
                                        'conditions' => array(
                                            'Approval.id' => $this->params['pass'][1],
                                            'Approval.user_id' => $this->Session->read('User.id'),
					                       'Approval.record_status' => 1
                                        ),
                                        'recursive' => - 1
                                    ));
                                    if (count($approval) == 0) {
                                        $this->Session->setFlash(__('Access Denied'));
                                        if ($this->params->action != 'access_denied')
                                            $this->redirect(array(
                                                'controller' => 'users',
                                                'action' => 'access_denied'
                                            ));
                                    }
                                    else {
                                        break;
                                    }
                                } else {
                                    if ($this->params->action != 'access_denied')
                                    $this->redirect(array(
                                        'controller' => 'users',
                                        'action' => 'access_denied'
                                    ));
                                }
                            }
                        }
                    }
                }

            endforeach;
        }

        }

public function get_department_employee($departmentId = null)
{
        $this->loadModel('Employee');
        $this->loadModel('User');
        $deptEmployees = $this->User->find('list', array('conditions' => array('User.soft_delete' => 0,'User.publish' => 1,'User.department_id' => $departmentId),'fields'=>array('Employee.id','Employee.name'),'recursive'=>0));
        $this->set('deptEmployees',$deptEmployees);
        $this->render('/Elements/department');
        $this->layout = 'ajax';

}


/**
 * _check_request method
 *
 * @return void
 */
        public function _check_request()
        {
            $onlyBranch = null;
            $onlyOwn = null;
            $con1 = null;
            $con2 = null;
            $modelName = $this->modelClass;
            if($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)$onlyBranch = array($modelName.'.branch_id'=>$this->Session->read('User.branch_id'));
            if($this->Session->read('User.is_view_all') == 0)$onlyOwn = array($modelName.'.created_by'=>$this->Session->read('User.id'));
            if($this->request->params['named'])
            {
                if($this->request->params['named']['published']==null)$con1 = null ; else $con1 = array($modelName.'.publish'=>$this->request->params['named']['published']);
                if($this->request->params['named']['soft_delete']==null)$con2 = null ; else $con2 = array($modelName.'.soft_delete'=>$this->request->params['named']['soft_delete']);
                if($this->request->params['named']['soft_delete']==null)$conditions=array($onlyBranch,$onlyOwn,$con1,$modelName.'.soft_delete'=>0);
                else $conditions=array($onlyBranch,$onlyOwn,$con1,$con2);
            }
            else
            {
                   $conditions=array($onlyBranch,$onlyOwn,null,$modelName.'.soft_delete'=>0);
            }

        return $conditions;
}

    public function beforeRender() {
	if($this->Session->read('User') != null){
	$this->loadModel('MasterListOfFormat');
	$formatCount = $this->MasterListOfFormat->find('count', array('conditions'=>array('MasterListOfFormat.company_id'=>$this->Session->read('User.company_id'))));
	if($formatCount == 0){
	    if(
	    $this->action != 'register'
	    && $this->action != 'terms_and_conditions'
	    && $this->action != 'liscence_key'
	    && $this->action != 'add_formats'
	    && $this->action != 'display_notifications'
	    && $this->action != 'logout'
	    && $this->action != 'welcome')
		{
			$this->redirect(array('controller' => 'users','action' => 'add_formats',1));
		}
	    }else if($this->action == 'add_formats'){
	          $this->Session->setFlash(__('Master list of formats already exist.'), 'default', array('class'=>'alert-danger'));
	          $this->redirect(array('controller' => 'users','action' => 'dashboard'));
	}
	}

        $this->set('branchIDYes',false);
	if($this->action == 'add_ajax'){
	    if($this->request->is('ajax') == false){
		$this->Session->setFlash('Invalid Request');
		$this->redirect(array('controller'=>'users','action'=>'dashboard'));
	    }
	}
        if (!$this->Session->read('User.id') && $this->action != 'login' && $this->action != 'reset_password' && $this->action != 'check_registration' && $this->action != 'self_appraisals' && $this->action != 'register'  && $this->action != 'activate' && $this->action != 'check_email' && ($this->action != 'smtp_details')) {

	    $this->Session->setFlash(__('Please sign in to access the application'), 'default', array('class'=>'alert-danger'));
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }        

        $this->_display_help();
        $this->_maker_checker();
        $this->_get_branch_list();
        $this->_get_department_list();
        $this->_get_employee_list();
        $this->_get_user_list();
        $this->set('approversList', $this->_get_approvers_list());
        $this->set('history', $this->_get_history());
        $this->_get_breadcrumbs_array();

        $this->set('prepared_by', $this->_get_employee_list());
        $this->set('approved_by', $this->_get_employee_list());
        $this->set('companyDetails', $this->_get_company());
        if ($this->request['controller'] != 'updates') {
            $this->_get_document_details();
        }
        $this->_get_notifications();
        $this->_get_suggestions();
        $this->_get_messages();

		if($this->action == 'view' || $this->action == 'internal_audit_uploads')
			{
				$this->_getRecordFiles($this->request->params['pass'][0],$this->_get_system_table_details(),NULL);
			}elseif($this->request['controller'] == 'dashboards'){
				$this->_getRecordFiles(NULL,NULL,NULL);
			}elseif($this->action == 'product_design' or $this->action == 'product_upload' ){
				$this->_getRecordFiles($this->request->params['pass'][1],$this->_get_system_table_details(),$this->request->params['pass'][0]);
			}elseif($this->action == 'dashboard_files'){
				$this->_getRecordFiles($this->request->params['pass'][0],'dashboards',NULL);
			}
      
		if($this->action == 'approve')$this->_getApprovalFiles();
	    
	    $this->_check_view_all();
        $this->set('templates', $this->_get_template());
        $this->set('controllerName', $this->request['controller']);

	if ($this->action != 'upload' && $this->modelClass != 'Dashboard' && $this->action != 'save_import_data') {
            $mClass = $this->modelClass;
            $this->set(array('tableFields' => $this->$mClass->schema(),'tableRelations' => $this->$mClass->belongsTo));
        }

        if ($this->request['controller'] == 'employees') {
            $this->loadModel('Education');
            $this->Education->recursive = - 1;
            $education = array();
            $educations = $this->Education->find('list');
            foreach ($educations as $edu):
                $education[$edu] = $edu;
            endforeach;
            $this->set('educations', $education);
	     $this->_get_designation_list();
	}else if($this->request['controller'] == 'competency_mappings')   {
	    $this->loadModel('Education');
            $this->Education->recursive = - 1;
	    $educations = $this->Education->find('list',array('conditions'=>array('Education.publish'=>1,'Education.soft_delete'=>0)));
	    $this->set('educations', $educations);

        }

        if($this->request->params['controller'] == 'appraisals' && $this->request->params['action'] == 'edit'){

            $currentDate = strtotime(date('Y-m-d'));
            $appraisalDate = strtotime($this->request->data['Appraisal']['appraisal_date']);

            if($currentDate > $appraisalDate || $this->data['Appraisal']['self_appraisal_status'] == 1){
                    $this->Session->setFlash(__('This appraisal can not be edited as the appraisal date has passed or it is being answered by Employee (Appraisee).'), 'default', array('class'=>'alert-danger'));
                    $this->redirect(array('action' => 'index'));
            }
        }
        if ($this->action == 'edit') {
            $model = $this->modelClass;
            $this->loadModel($model);
            $recordStatus = $this->request->data[$model]['record_status'];
            if($recordStatus == 1){
               $this->Session->setFlash(__('Access Denied'));
                        if ($this->params->action != 'access_denied')
                            $this->redirect(array(
                                'controller' => 'users',
                                'action' => 'access_denied'
                            ));
                    }
            }
     }


    public function _get_breadcrumbs_array() {

        // MR Department
        $breadcrumbs['reports'] = array();
        $breadcrumbs['reports']['dashboard'] = 'MR';
        $breadcrumbs['reports']['dashboard_action'] = 'mr';

        $breadcrumbs['change_addition_deletion_requests'] = array();
        $breadcrumbs['change_addition_deletion_requests']['dashboard'] = 'MR';
        $breadcrumbs['change_addition_deletion_requests']['dashboard_action'] = 'mr';

        $breadcrumbs['document_amendment_record_sheets'] = array();
        $breadcrumbs['document_amendment_record_sheets']['dashboard'] = 'MR';
        $breadcrumbs['document_amendment_record_sheets']['dashboard_action'] = 'mr';

        $breadcrumbs['meetings'] = array();
        $breadcrumbs['meetings']['dashboard'] = 'MR';
        $breadcrumbs['meetings']['dashboard_action'] = 'mr';

        $breadcrumbs['list_of_trained_internal_auditors'] = array();
        $breadcrumbs['list_of_trained_internal_auditors']['dashboard'] = 'MR';
        $breadcrumbs['list_of_trained_internal_auditors']['dashboard_action'] = 'mr';

        $breadcrumbs['internal_audits'] = array();
        $breadcrumbs['internal_audits']['dashboard'] = 'MR';
        $breadcrumbs['internal_audits']['dashboard_action'] = 'mr';

        $breadcrumbs['internal_audit_plans'] = array();
        $breadcrumbs['internal_audit_plans']['dashboard'] = 'MR';
        $breadcrumbs['internal_audit_plans']['dashboard_action'] = 'mr';

        $breadcrumbs['corrective_preventive_actions'] = array();
        $breadcrumbs['corrective_preventive_actions']['dashboard'] = 'MR';
        $breadcrumbs['corrective_preventive_actions']['dashboard_action'] = 'mr';

        $breadcrumbs['capa_sources'] = array();
        $breadcrumbs['capa_sources']['dashboard'] = 'MR';
        $breadcrumbs['capa_sources']['dashboard_action'] = 'mr';

        $breadcrumbs['capa_categories'] = array();
        $breadcrumbs['capa_categories']['dashboard'] = 'MR';
        $breadcrumbs['capa_categories']['dashboard_action'] = 'mr';

        $breadcrumbs['benchmarks'] = array();
        $breadcrumbs['benchmarks']['dashboard'] = 'MR';
        $breadcrumbs['benchmarks']['dashboard_action'] = 'mr';

        $breadcrumbs['tasks'] = array();
        $breadcrumbs['tasks']['dashboard'] = 'MR';
        $breadcrumbs['tasks']['dashboard_action'] = 'mr';

        $breadcrumbs['task_statuses'] = array();
        $breadcrumbs['task_statuses']['dashboard'] = 'MR';
        $breadcrumbs['task_statuses']['dashboard_action'] = 'mr';

        // HR

        $breadcrumbs['employees'] = array();
        $breadcrumbs['employees']['dashboard'] = 'HR';
        $breadcrumbs['employees']['dashboard_action'] = 'hr';

        $breadcrumbs['designations'] = array();
        $breadcrumbs['designations']['dashboard'] = 'HR';
        $breadcrumbs['designations']['dashboard_action'] = 'hr';

        $breadcrumbs['courses'] = array();
        $breadcrumbs['courses']['dashboard'] = 'HR';
        $breadcrumbs['courses']['dashboard_action'] = 'hr';

        $breadcrumbs['course_types'] = array();
        $breadcrumbs['course_types']['dashboard'] = 'HR';
        $breadcrumbs['course_types']['dashboard_action'] = 'hr';

        $breadcrumbs['trainers'] = array();
        $breadcrumbs['trainers']['dashboard'] = 'HR';
        $breadcrumbs['trainers']['dashboard_action'] = 'hr';

        $breadcrumbs['trainer_types'] = array();
        $breadcrumbs['trainer_types']['dashboard'] = 'HR';
        $breadcrumbs['trainer_types']['dashboard_action'] = 'hr';

        $breadcrumbs['training_need_identifications'] = array();
        $breadcrumbs['training_need_identifications']['dashboard'] = 'HR';
        $breadcrumbs['training_need_identifications']['dashboard_action'] = 'hr';

        $breadcrumbs['trainings'] = array();
        $breadcrumbs['trainings']['dashboard'] = 'HR';
        $breadcrumbs['trainings']['dashboard_action'] = 'hr';

        $breadcrumbs['training_types'] = array();
        $breadcrumbs['training_types']['dashboard'] = 'HR';
        $breadcrumbs['training_types']['dashboard_action'] = 'hr';

        $breadcrumbs['training_evaluations'] = array();
        $breadcrumbs['training_evaluations']['dashboard'] = 'HR';
        $breadcrumbs['training_evaluations']['dashboard_action'] = 'hr';

        $breadcrumbs['competency_mappings'] = array();
        $breadcrumbs['competency_mappings']['dashboard'] = 'HR';
        $breadcrumbs['competency_mappings']['dashboard_action'] = 'hr';

		$breadcrumbs['employee_kras'] = array();
        $breadcrumbs['employee_kras']['dashboard'] = 'HR';
        $breadcrumbs['employee_kras']['dashboard_action'] = 'hr';

		$breadcrumbs['kras'] = array();
        $breadcrumbs['kras']['dashboard'] = 'HR';
        $breadcrumbs['kras']['dashboard_action'] = 'hr';

		$breadcrumbs['appraisals'] = array();
        $breadcrumbs['appraisals']['dashboard'] = 'HR';
        $breadcrumbs['appraisals']['dashboard_action'] = 'hr';

		$breadcrumbs['employee_appraisal_questions'] = array();
        $breadcrumbs['employee_appraisal_questions']['dashboard'] = 'HR';
        $breadcrumbs['employee_appraisal_questions']['dashboard_action'] = 'hr';


		$breadcrumbs['appraisal_questions'] = array();
        $breadcrumbs['appraisal_questions']['dashboard'] = 'HR';
        $breadcrumbs['appraisal_questions']['dashboard_action'] = 'hr';


        // BD
        $breadcrumbs['customers'] = array();
        $breadcrumbs['customers']['dashboard'] = 'BD';
        $breadcrumbs['customers']['dashboard_action'] = 'bd';

        $breadcrumbs['customer_meetings'] = array();
        $breadcrumbs['customer_meetings']['dashboard'] = 'BD';
        $breadcrumbs['customer_meetings']['dashboard_action'] = 'bd';

        $breadcrumbs['proposals'] = array();
        $breadcrumbs['proposals']['dashboard'] = 'BD';
        $breadcrumbs['proposals']['dashboard_action'] = 'bd';

        $breadcrumbs['proposal_followups'] = array();
        $breadcrumbs['proposal_followups']['dashboard'] = 'BD';
        $breadcrumbs['proposal_followups']['dashboard_action'] = 'bd';

        // Admin
        $breadcrumbs['fire_extinguisher_types'] = array();
        $breadcrumbs['fire_extinguisher_types']['dashboard'] = 'Admin';
        $breadcrumbs['fire_extinguisher_types']['dashboard_action'] = 'personal_admin';

        $breadcrumbs['fire_extinguishers'] = array();
        $breadcrumbs['fire_extinguishers']['dashboard'] = 'Admin';
        $breadcrumbs['fire_extinguishers']['dashboard_action'] = 'personal_admin';

        $breadcrumbs['housekeeping_checklists'] = array();
        $breadcrumbs['housekeeping_checklists']['dashboard'] = 'Admin';
        $breadcrumbs['housekeeping_checklists']['dashboard_action'] = 'personal_admin';

        $breadcrumbs['housekeeping_responsibilities'] = array();
        $breadcrumbs['housekeeping_responsibilities']['dashboard'] = 'Admin';
        $breadcrumbs['housekeeping_responsibilities']['dashboard_action'] = 'personal_admin';

		$breadcrumbs['housekeepings'] = array();
        $breadcrumbs['housekeepings']['dashboard'] = 'Admin';
        $breadcrumbs['housekeepings']['dashboard_action'] = 'personal_admin';

        // Quality Control
        $breadcrumbs['material_quality_checks'] = array();
        $breadcrumbs['material_quality_checks']['dashboard'] = 'Quality Control';
        $breadcrumbs['material_quality_checks']['dashboard_action'] = 'quality_control';

        $breadcrumbs['customer_complaints'] = array();
        $breadcrumbs['customer_complaints']['dashboard'] = 'Quality Control';
        $breadcrumbs['customer_complaints']['dashboard_action'] = 'quality_control';

        $breadcrumbs['list_of_measuring_devices_for_calibrations'] = array();
        $breadcrumbs['list_of_measuring_devices_for_calibrations']['dashboard'] = 'Quality Control';
        $breadcrumbs['list_of_measuring_devices_for_calibrations']['dashboard_action'] = 'quality_control';

        $breadcrumbs['devices'] = array();
        $breadcrumbs['devices']['dashboard'] = 'Quality Control';
        $breadcrumbs['devices']['dashboard_action'] = 'quality_control';

        $breadcrumbs['device_maintenances'] = array();
        $breadcrumbs['device_maintenances']['dashboard'] = 'Quality Control';
        $breadcrumbs['device_maintenances']['dashboard_action'] = 'quality_control';

        $breadcrumbs['calibrations'] = array();
        $breadcrumbs['calibrations']['dashboard'] = 'Quality Control';
        $breadcrumbs['calibrations']['dashboard_action'] = 'quality_control';

        $breadcrumbs['customer_feedbacks'] = array();
        $breadcrumbs['customer_feedbacks']['dashboard'] = 'Quality Control';
        $breadcrumbs['customer_feedbacks']['dashboard_action'] = 'quality_control';

        $breadcrumbs['customer_feedback_questions'] = array();
        $breadcrumbs['customer_feedback_questions']['dashboard'] = 'Quality Control';
        $breadcrumbs['customer_feedback_questions']['dashboard_action'] = 'quality_control';

        // Purchase
        $breadcrumbs['supplier_registrations'] = array();
        $breadcrumbs['supplier_registrations']['dashboard'] = 'Purchase';
        $breadcrumbs['supplier_registrations']['dashboard_action'] = 'purchase';

        $breadcrumbs['purchase_orders'] = array();
        $breadcrumbs['purchase_orders']['dashboard'] = 'Purchase';
        $breadcrumbs['purchase_orders']['dashboard_action'] = 'purchase';

        $breadcrumbs['delivery_challans'] = array();
        $breadcrumbs['delivery_challans']['dashboard'] = 'Purchase';
        $breadcrumbs['delivery_challans']['dashboard_action'] = 'purchase';

        $breadcrumbs['supplier_evaluation_reevaluations'] = array();
        $breadcrumbs['supplier_evaluation_reevaluations']['dashboard'] = 'Purchase';
        $breadcrumbs['supplier_evaluation_reevaluations']['dashboard_action'] = 'purchase';

        $breadcrumbs['summery_of_supplier_evaluations'] = array();
        $breadcrumbs['summery_of_supplier_evaluations']['dashboard'] = 'Purchase';
        $breadcrumbs['summery_of_supplier_evaluations']['dashboard_action'] = 'purchase';

        $breadcrumbs['list_of_acceptable_suppliers'] = array();
        $breadcrumbs['list_of_acceptable_suppliers']['dashboard'] = 'Purchase';
        $breadcrumbs['list_of_acceptable_suppliers']['dashboard_action'] = 'purchase';

        $breadcrumbs['supplier_categories'] = array();
        $breadcrumbs['supplier_categories']['dashboard'] = 'Purchase';
        $breadcrumbs['supplier_categories']['dashboard_action'] = 'purchase';

        // EDP
        $breadcrumbs['list_of_softwares'] = array();
        $breadcrumbs['list_of_softwares']['dashboard'] = 'EDP';
        $breadcrumbs['list_of_softwares']['dashboard_action'] = 'edp';

        $breadcrumbs['list_of_computers'] = array();
        $breadcrumbs['list_of_computers']['dashboard'] = 'EDP';
        $breadcrumbs['list_of_computers']['dashboard_action'] = 'edp';

        $breadcrumbs['list_of_computer_list_of_softwares'] = array();
        $breadcrumbs['list_of_computer_list_of_softwares']['dashboard'] = 'EDP';
        $breadcrumbs['list_of_computer_list_of_softwares']['dashboard_action'] = 'edp';

        $breadcrumbs['data_types'] = array();
        $breadcrumbs['data_types']['dashboard'] = 'EDP';
        $breadcrumbs['data_types']['dashboard_action'] = 'edp';

        $breadcrumbs['data_back_ups'] = array();
        $breadcrumbs['data_back_ups']['dashboard'] = 'EDP';
        $breadcrumbs['data_back_ups']['dashboard_action'] = 'edp';

        $breadcrumbs['daily_backup_details'] = array();
        $breadcrumbs['daily_backup_details']['dashboard'] = 'EDP';
        $breadcrumbs['daily_backup_details']['dashboard_action'] = 'edp';

        $breadcrumbs['username_password_details'] = array();
        $breadcrumbs['username_password_details']['dashboard'] = 'EDP';
        $breadcrumbs['username_password_details']['dashboard_action'] = 'edp';

        $breadcrumbs['databackup_logbooks'] = array();
        $breadcrumbs['databackup_logbooks']['dashboard'] = 'EDP';
        $breadcrumbs['databackup_logbooks']['dashboard_action'] = 'edp';

        $breadcrumbs['software_types'] = array();
        $breadcrumbs['software_types']['dashboard'] = 'EDP';
        $breadcrumbs['software_types']['dashboard_action'] = 'edp';

        // Production
        $breadcrumbs['materials'] = array();
        $breadcrumbs['materials']['dashboard'] = 'Production';
        $breadcrumbs['materials']['dashboard_action'] = 'production';

        $breadcrumbs['products'] = array();
        $breadcrumbs['products']['dashboard'] = 'Production';
        $breadcrumbs['products']['dashboard_action'] = 'production';

        $breadcrumbs['productions'] = array();
        $breadcrumbs['productions']['dashboard'] = 'Production';
        $breadcrumbs['productions']['dashboard_action'] = 'production';

        $breadcrumbs['stocks'] = array();
        $breadcrumbs['stocks']['dashboard'] = 'Production';
        $breadcrumbs['stocks']['dashboard_action'] = 'production';

        $breadcrumbs['stock_status'] = array();
        $breadcrumbs['stock_status']['dashboard'] = 'Production';
        $breadcrumbs['stock_status']['dashboard_action'] = 'production';

        $this->set('breadcrumbs', $breadcrumbs);

    }

    public function _get_count(){

        $onlyBranch = null;
	$onlyOwn = null;
	$conditions = null;
        $modelName = $this->modelClass;
        $branchIDYes = false;
	if($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)$onlyBranch = array($modelName.'.branch_id'=>$this->Session->read('User.branch_id'));
	if($this->Session->read('User.is_view_all') == 0)$onlyOwn = array($modelName.'.created_by'=>$this->Session->read('User.id'));

        $conditions = array($onlyBranch,$onlyOwn);
      	$count = $this->$modelName->find('count',array('conditions'=>$conditions));
	$published = $this->$modelName->find('count',array('conditions'=>array($conditions,$modelName.'.publish'=>1,$modelName.'.soft_delete'=>0)));
	$unpublished = $this->$modelName->find('count',array('conditions'=>array($conditions,$modelName.'.publish'=>0,$modelName.'.soft_delete'=>0)));
	$deleted = $this->$modelName->find('count',array('conditions'=>array($conditions,$modelName.'.soft_delete'=>1)));
	$this->set(compact('count','published','unpublished','deleted'));
}


        public function _get_company() {
        $this->loadModel('Company');
        $this->Company->recursive = - 1;
        $company = $this->Company->find('first', array(
	    'conditions'=>array('Company.id'=>$this->Session->read('User.company_id')),
            'fields' => array(
                'Company.id',
                'Company.name'
            ),
            'recursive' => - 1
        ));
        return $company;
    }

    public function _get_branch_list() {
        $this->loadModel('Branch');
        $PublishedBranchList = $this->Branch->find('list', array(
            'conditions' => array(
                'Branch.soft_delete' => 0,
                'Branch.publish' => 1
            ),
            'recursive' => - 1
        ));
        $this->set(compact('PublishedBranchList'));
        return ($PublishedBranchList);
    }

    public function _get_department_list() {
        $this->loadModel('Department');
        $PublishedDepartmentList = $this->Department->find('list', array(
            'conditions' => array(
                'Department.soft_delete' => 0,
                'Department.publish' => 1
            ),
            'recursive' => - 1
        ));
        $this->set(compact('PublishedDepartmentList'));
        return ($PublishedDepartmentList);
    }

    public function _get_employee_list() {
        $this->loadModel('Employee');
        $PublishedEmployeeList = $this->Employee->find('list', array(
            'conditions' => array(
                'Employee.soft_delete' => 0,
                'Employee.publish' => 1
            ),
            'recursive' => - 1
        ));
        $this->set(compact('PublishedEmployeeList'));
	        return ($PublishedEmployeeList);
    }

    public function _get_designation_list() {
        $this->loadModel('Designation');
        $PublishedDesignationList = $this->Designation->find('list', array(
            'conditions' => array(
                'Designation.publish' => 1,
                'Designation.soft_delete' => 0
            ),
            'recursive' => - 1
        ));
        $this->set(compact('PublishedDesignationList'));
        return ($PublishedDesignationList);
    }

    
     public function get_model_list($model = null) {
	if($model){
		$this->loadModel($model);
		return $this->$model->find('list', array('conditions' => array($model.'.publish' => 1, $model.'.soft_delete' => 0),
		    'recursive' => -1));
	}
    }

     public function get_usernames() {
	$this->loadModel('User');
	$users = $this->User->find('all', array('conditions' => array('User.soft_delete'=> 0,'User.publish'=>1),'fields' => array('User.id','User.name','User.username')));
	foreach ($users as $user) {
	    $employeeUserNames[$user['User']['id']] = $user['User']['name'] . " (" . $user['User']['username'] . ")";
	}
	return($employeeUserNames);
    }

    public function _get_user_list() {
	$this->loadModel('User');
	$users = $this->User->find('list', array('conditions' => array('User.soft_delete'=> 0,'User.publish'=>1)));
	$this->set(compact('PublishedUserList'));
    return ($users);
    }

    public function get_device_calibration_list() {
        $this->loadModel('Device');
        $DeviceCalibrationList = $this->Device->find('list', array('conditions' => array('Device.publish' => 1, 'Device.soft_delete' => 0, 'Device.calibration_required' => 0),
            'recursive' => -1));
        return($DeviceCalibrationList);
    }

    public function _show_evidence() {
        $this->loadModel("SystemTable");
        $this->SystemTable->recursive = - 1;
        $tableDetails = $this->SystemTable->find('first', array(
            'conditions' => array(
                'SystemTable.system_name' => $this->name
            ),
            'fields' => array(
                'SystemTable.evidence_required'
            )
        ));
        if ($tableDetails && $tableDetails['SystemTable']['evidence_required'] != false)
            return true;
    }

    public function _get_approvers_list() {
		if($this->request->controller != 'file_uploads'){
	$userIds = array();
        $this->loadModel('User');
        $this->User->recursive = - 1;
        $userIdsAll = $this->User->find('all', array(
            'order' => array(
                'User.name' => 'ASC'
            ),
            'conditions' => array(
                'User.id <>' => $this->Session->read('User.id'),
                'User.publish' => 1,
                'User.soft_delete' => 0,
                'User.is_approvar' => 1
            )
        ));
	foreach ($userIdsAll as $userId) {
	    $userIds[$userId['User']['id']] = $userId['User']['name'] . " (" . $userId['User']['username'] . ")";
	}
	if($this->data && $this->Session->read('User.id') != $this->data['CreatedBy']['id'])$userIds[$this->data['CreatedBy']['id']] = $this->data['CreatedBy']['name'] . " (Creator)";
	return $userIds;
		}
    }

    public function _show_approvals() {
        $showApprovals['show_panel'] = true;
        $showApprovals['show_publish'] = true;
        $this->set('showApprovals',$showApprovals);
        
    }

    public function _track_history($track = null) {
	        $this->loadModel('History');
        $this->History->recursive = - 1;

        $this->History->create();
        $history = array();
        $history['History']['model_name'] = Inflector::Classify($this->name);
        $history['History']['controller_name'] = $this->request->params['controller'];
        $history['History']['action'] = $this->request->action;
        $history['History']['get_values'] = json_encode($this->request->params);
        $history['History']['post_values'] = json_encode(array(
            $this->data,
            $this->request->data
        ));
        $history['History']['branch_id'] = $this->Session->read('User.branch_id');
        $history['History']['department_id'] = $this->Session->read('User.department_id');
        $history['History']['branchid'] = $this->Session->read('User.branch_id');
        $history['History']['departmentid'] = $this->Session->read('User.department_id');
        $history['History']['publish'] = 1;
        $history['History']['soft_delete'] = 0;
        $history['History']['created_by'] = $this->Session->read('User.id');
        $history['History']['user_session_id'] = $this->Session->read('User.user_session_id');
        $this->History->save($history);

	//update usersession .. end time
	$this->History->UserSession->read(null,$this->Session->read('User.user_session_id'));
	$data['UserSession']['end_time'] = date('Y-m-d H:i:s');
	$this->History->UserSession->save($data['UserSession'], false);

    }

    public function _check_view_all() {

        $action = $this->request->action;
        $controller = $this->request->params['controller'];
        $model = Inflector::Classify($controller);
        $defaultCtrlAccess = array('Messages', 'MessageUserInboxes', 'MessageUserSents', 'MessageUserThrashes');
        if ($this->Session->read('User.is_view_all') == false && !in_array($this->params->controller, $defaultCtrlAccess)) {
            if (($action == 'edit' && $this->data[$model]['created_by'] != $this->Session->read('User.id')) || ($action == 'view' && $this->viewVars[Inflector::variable($model)][$model]['created_by'] != $this->Session->read('User.id')) || ($action == 'meeting_view') || ($action == 'get_material_qc_required' && $this->params->action != 'get_delivered_material_qc' && $this->params->action != 'capa_assigned' && $this->params->action != 'get_customer_complaints' && $this->params->action != 'get_next_calibration' && $this->params->action != 'get_device_maintainance')) {
                if ($this->params->controller == 'corrective_preventive_actions') {
                    $this->loadModel('CorrectivePreventiveAction');

                    if ($this->params->action == 'capa_assigned') {
                        $condition = array('CorrectivePreventiveAction.assigned_to' => $this->Session->read('User.employee_id'), 'CorrectivePreventiveAction.publish' => 1, 'CorrectivePreventiveAction.soft_delete' => 0,);
                    } else {
                        $condition = array('CorrectivePreventiveAction.id' => $this->params['pass'][0],
                            'CorrectivePreventiveAction.assigned_to' => $this->Session->read('User.employee_id'),
                            'CorrectivePreventiveAction.publish' => 1, 'CorrectivePreventiveAction.soft_delete' => 0,
                        );
                    }
                    $capa = $this->CorrectivePreventiveAction->find('first', array(
                        'conditions' => $condition,
                        'recursive' => - 1
                    ));
                    if (count($capa) == 0) {
                        $this->Session->setFlash(__('Access Denied'));
                        if ($this->params->action != 'access_denied')
                            $this->redirect(array(
                                'controller' => 'users',
                                'action' => 'access_denied'
                            ));
                    }
                }else if ($this->params->controller == 'users') {
                    $this->loadModel('User');
                    $users_count = $this->User->find('first', array(
                        'conditions' => array(
                            'User.id' => $this->Session->read('User.id')
                        ),
                        'recursive' => - 1
                    ));
                    if (count($users_count) == 0) {
                        $this->Session->setFlash(__('Access Denied'));
                        if ($this->params->action != 'access_denied')
                            $this->redirect(array(
                                'controller' => 'users',
                                'action' => 'access_denied'
                            ));
                    }
                }
                else if ($this->params->controller == 'customer_complaints') {
                    $this->loadModel('CustomerComplaint');
                    if ($this->params->action == 'get_customer_complaints') {
                        $condition = array('CustomerComplaint.employee_id' => $this->Session->read('User.employee_id'), 'CustomerComplaint.publish' => 1, 'CustomerComplaint.soft_delete' => 0);
                    } else {
                        $condition = array(
                            'CustomerComplaint.id' => $this->params['pass'][0],
                            'CustomerComplaint.employee_id' => $this->Session->read('User.employee_id'),
                            'CustomerComplaint.publish' => 1, 'CustomerComplaint.soft_delete' => 0,
                        );
                    }
                    $custComplaints = $this->CustomerComplaint->find('first', array(
                        'conditions' => $condition,
                        'recursive' => - 1
                    ));
                    if (count($custComplaints) == 0) {
                        $this->Session->setFlash(__('Access Denied'));
                        if ($this->params->action != 'access_denied')
                            $this->redirect(array(
                                'controller' => 'users',
                                'action' => 'access_denied'
                            ));
                    }
                }else if ($this->params->controller == 'meetings' && $this->params->action == 'meeting_view') {

                    $this->loadModel('MeetingEmployee');
                    $invities = $this->MeetingEmployee->find('first', array(
                        'conditions' => array(
                            'MeetingEmployee.meeting_id' => $this->params['pass'][0],
                            'MeetingEmployee.employee_id' => $this->Session->read('User.employee_id')
                        ),
                        'recursive' => - 1
                    ));
                    if ($invities == 0) {
                        $this->Session->setFlash(__('Access Denied'));
                        if ($this->params->action != 'access_denied')
                            $this->redirect(array('controller' => 'users', 'action' => 'access_denied'));
                    }
                } else if ($this->params->controller == 'notifications' && $this->params->action == 'view') {
                    $this->loadModel('NotificationUser');
                    $invities = $this->NotificationUser->find('first', array(
                        'conditions' => array('NotificationUser.notification_id' => $this->params['pass'][0], 'NotificationUser.employee_id' => $this->Session->read('User.employee_id')), 'recursive' => - 1));
                    if ($invities == 0) {
                        $this->Session->setFlash(__('Access Denied'));
                        if ($this->params->action != 'access_denied')
                            $this->redirect(array('controller' => 'users', 'action' => 'access_denied'));
                    }
                } else if ($this->params->controller == 'materials' && $this->params->action == 'get_material_qc_required') {
                    //exit();
                } else if ($this->params->controller == 'delivery_challans' && $this->params->action == 'get_delivered_material_qc') {
                    exit;
                } else if ($this->params->controller == 'calibrations' && $this->params->action == 'get_next_calibration') {
                    exit;
                } else if ($this->params->controller == 'device_maintenances' && $this->params->action == 'get_device_maintainance') {
                    exit;
                } else {
                    $this->loadModel('Approval');
                    $approvals = $this->Approval->find('all', array('conditions' => array('Approval.controller_name' => $this->params->controller, 'Approval.record' => $this->params['pass'][0], 'Approval.user_id' => $this->Session->read('User.id')), 'recursive' => - 1));
                    if (count($approvals) == 0) {
                        $this->Session->setFlash(__('Access Denied'));
                        if ($this->params->action != 'access_denied')
                            $this->redirect(array('controller' => 'users', 'action' => 'access_denied'));
                    }
                }
            }
        }
    }

    public function _get_history() {
          return false;
    }

    public function _display_help() {
        $this->loadModel('Help');
        $this->Help->recursive = - 1;
        $helps = $this->Help->find('all', array(
            'order' => array(
                'sequence' => 'asc'
            ),
            'conditions' =>
	    array('and'=>array(
                'table_name' => $this->name,
                'action_name like ' => "%".$this->request->params['action']."%"
            )),
            'recursive' => - 1
        ));
        $this->set('helps', $helps);
        if ($this->request->params['pass'])
            $this->set('approvalHistory', $this->_get_approval_history($this->request->params['pass'][0]));
    }

    public function _maker_checker() {
        $this->loadModel('Employee');
        $this->Employee->recursive = - 1;
        $employeesList = $this->Employee->find('list');
        $this->set(compact('employeesList'));
    }

    public function _get_document_details() {
        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = 0;
        $systemTableId = $this->SystemTable->find('first', array(
            'fields' => array(
                'SystemTable.id'
            ),
            'conditions' => array(
                'SystemTable.system_name' => $this->request->params['controller']
            )
        ));
        $this->SystemTable->MasterListOfFormat->recursive = - 1;
        $documentDetails = $this->SystemTable->MasterListOfFormat->find('first', array(
            'conditions' => array(
                'MasterListOfFormat.system_table_id' => $systemTableId['SystemTable']['id']
            )
        ));
        $this->set('documentDetails', $documentDetails);
		return $documentDetails;
    }

	public function _get_system_table_details() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = 0;
        $systemTable = $this->SystemTable->find('first', array(
            'fields' => array(
                'SystemTable.id'
            ),
            'conditions' => array(
                'SystemTable.system_name' => $this->request->params['controller']
            )
        ));

       $this->set('systemTable', $systemTable);
		return $systemTable;
    }

    public function _get_system_table($dir) {
        $this->loadModel("SystemTable");
        $this->SystemTable->recursive = 0;
        $tableDetails = $this->SystemTable->find('first', array(
            'conditions' => array(
                'SystemTable.system_name' => $dir
            ),
            'fields' => array(
                'SystemTable.id'
            )
        ));
        if ($tableDetails && $tableDetails['SystemTable']['id'] != false)
            return $tableDetails['SystemTable']['id'];
    }

    public function _get_approval_history($id = null) {
        
    }

    public function _prepare_menu() {
        $this->loadModel('MasterListOfFormatDepartment');
        $this->MasterListOfFormatDepartment->Department->recursive = - 1;
        $departments = $this->MasterListOfFormatDepartment->Department->find('all', array(
            'fields' => array(
                'Department.id',
                'Department.name'
            ),
            'conditions' => array(
                'Department.publish' => 1,
                'Department.soft_delete' => 0
            )
        ));
        $menu = array();
        $i = 0;
        foreach ($departments as $department):
            $this->MasterListOfFormatDepartment->recursive = 0;
            $forms = $this->MasterListOfFormatDepartment->find('all', array(
                'fields' => array(
                    'MasterListOfFormat.title',
                    'MasterListOfFormat.system_table_id'
                ),
                'conditions' => array(
                    'MasterListOfFormatDepartment.department_id' => $department['Department']['id']
                )
            ));
            $menu[$i]['Department'] = $department;
            foreach ($forms as $form):
                $this->MasterListOfFormatDepartment->MasterListOfFormat->SystemTable->recursive = - 1;
                $tableDetails = $this->MasterListOfFormatDepartment->MasterListOfFormat->SystemTable->find('first', array(
                    'fields' => array(
                        'SystemTable.id',
                        'SystemTable.system_name'
                    ),
                    'conditions' => array(
                        'SystemTable.id' => $form['MasterListOfFormat']['system_table_id']
                    )
                ));
                $menu[$i]['MasterListOfFormat'] = $form;
                $menu[$i]['MasterListOfFormat']['SystemTable'] = $tableDetails;
            endforeach;
            $i++;
        endforeach;
        $this->set('menu', $menu);
    }

    public function _missing_table($table = null) {
        $tableNotExist = array();
        $tables = array(
            'departments',
            'branches',
            'designations',
            'users',
            'employees',
            'supplier_registrations',
            'products',
            'benchmarks'
        );
        foreach ($tables as $table):
            $modelName = null;
            $modelName.= Inflector::Classify($table);
            $this->loadModel($modelName);
            $this->$modelName->recursive = - 1;
            $tableExist = $this->$modelName->find('first', array(
                'conditions' => array(
                    'publish' => 1
                )
            ));
            if (empty($tableExist)) {
                $tableNotExist[] = $table;
            }

        endforeach;
        if (empty($tableNotExist)) {
            return true;
        } else {
            $this->set('tableNotExist', $tableNotExist);
        }
        $this->set($tableNotExist);
        $this->set('install', true);
        if ($tableNotExist[0] == 'benchmarks')
            $getLink = Router::url('/', true) . $tableNotExist[0];
        else
            $getLink = Router::url('/', true) . $tableNotExist[0] . '/lists';
        $this->Session->setFlash('Please add details for <h4>' . Inflector::Humanize($tableNotExist[0]) . ' <a href="' . $getLink . '" class="btn btn-sm btn-success">Add new</a></h4>
					before you start using the application.You can also import these records if you have them ready. <br />
					<strong>Please not that you will have to publish records which you are importing before you can access those records.</strong>
					<br />List of required tables are  Departments, Branches, Designations, Users, Employees, Suppliers, Devices, Products, Benchmarks');
        if (!in_array($this->params->controller, $tables, true)) {
            if ($tableNotExist[0] == '/benchmarks')
                $this->redirect(array(
                    'controller' => $tableNotExist[0],
                    'action' => 'index'
                ));
            else
                $this->redirect(array(
                    'controller' => $tableNotExist[0],
                    'action' => 'index'
                ));
        }
    }

    public function delete_all($ids = null) {
        $i = 0;
        if ($_POST['data'][$this->name]['recs_selected'])
        $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);
        $modelName = $this->modelClass;
        $record = Inflector::underscore($modelName);
        $record = Inflector::pluralize(Inflector::humanize($record));
        $this->loadModel('Approval');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $activeRecord = $this->$modelName->find('first',array('conditions'=>array($modelName.'.id'=>$id)));
                    if($activeRecord[$modelName]['record_status'] == 1){
                        $i++;
                        continue;
                    }else{

                     $approves = $this->Approval->find('all',array('conditions'=>array('Approval.record'=>$id,'Approval.model_name'=>$modelName)));
                    foreach($approves as $approve)
                    {
                        $approve['Approval']['soft_delete']=1;
                        $this->Approval->save($approve, false);
                    }
                    $data['id'] = $id;
                    $data['soft_delete'] = 1;
                    $this->$modelName->save($data, false);
                    }
                }
            }
        }
        if($i){
            $this->Session->setFlash(__('Selected %s deleted <br> Except (%d) values due to their pending approvals',$record,$i));
        }else{
            $this->Session->setFlash(__('All selected %s deleted',$record));
        }
        if($this->request->params['controller'] == 'stocks'){
            $this->redirect($this->referer());

        }else{
            $this->redirect(array(
                'action' => 'index'
            ));
        }
    }

    public function purge_all($ids = null) {
        $flag = 0;
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);
        $modelName = $this->modelClass;
        $controller = Inflector::variable(Inflector::pluralize($modelName));
        $record = Inflector::underscore($modelName);
        $record = Inflector::pluralize(Inflector::humanize($record));
        $this->loadModel('Approval');
        $this->loadModel('FileUpload');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $this->$modelName->id = $id;
                    if (!$this->$modelName->exists()) {
                        throw new NotFoundException(__('Invalid detail'));
                    }

                    $this->request->onlyAllow('post', 'delete');
                    $approves = $this->Approval->find('all',array('conditions'=>array('Approval.record'=>$id,'Approval.model_name'=>$modelName)));
                    $fileUploads = $this->FileUpload->find('all',array('conditions'=>array('FileUpload.record'=>$id)));
                    foreach($approves as $approve)
                        {
                            if ($this->Approval->delete($approve['Approval']['id'], true))
                            {
                                $flag = 1;
                            }
                            else
                            {
                                $flag = 0;
                                $this->Session->setFlash(__('All selected value was not deleted'));
                                $this->redirect(array('action' => 'index'));
                            }
                        }

                        foreach($fileUploads as $fileUpload)
                        {
                            if(!($this->FileUpload->delete($fileUpload['FileUpload']['id'], true)))
                            {
                                $this->Session->setFlash(__('All selected value was not deleted from Upload'));
                                $this->redirect(array('action' => 'index'));
                            }
                        }
                        $this->_deleteFile($id,$controller);

                        if ($this->$modelName->delete($id, true)) {
                            $flag = 1;
                        }
                        else
                        {
                            $flag = 0;
                            $this->Session->setFlash(__('All %s was not deleted',$record));
                            $this->redirect(array('action' => 'index'));
                        }
                }
            }
            if ($flag) {
                $this->Session->setFlash(__('All selected %s deleted',$record));
                if($this->request->params['controller'] == 'stocks'){
                    $this->redirect($this->referer());

                }else{
                    $this->redirect(array(
                        'action' => 'index'
                    ));
                }
            }
        }
        if($this->request->params['controller'] == 'stocks'){
                    $this->redirect($this->referer());

                }else{
                    $this->redirect(array(
                        'action' => 'index'
                    ));
                }
    }

    public function restore_all($ids = null) {
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);
        $modelName = $this->modelClass;
        $record = Inflector::underscore($modelName);
        $record = Inflector::pluralize(Inflector::humanize($record));
        $this->loadModel('Approval');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                     $approves = $this->Approval->find('all',array('conditions'=>array('Approval.record'=>$id,'Approval.model_name'=>$modelName)));
                        foreach($approves as $approve)
                        {
                            $approve['Approval']['soft_delete']=0;
                            $this->Approval->save($approve, false);
                        }

                    $data['id'] = $id;
                    $data['soft_delete'] = 0;
                    $this->$modelName->save($data, false);
                }
            }
        }

        $this->Session->setFlash(__('All %s restored',$record));
        if($this->request->params['controller'] == 'stocks'){
            $this->redirect($this->referer());

        }else{
            $this->redirect(array(
                'action' => 'index'
            ));
        }
    }

    /**
     * restore method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function restore($id = null) {
        $modelName = $this->modelClass;
        $record = Inflector::underscore($modelName);
        $record = Inflector::humanize($record);
        $this->loadModel('Approval');
        if (!empty($id)) {
             $approves = $this->Approval->find('all',array('conditions'=>array('Approval.record'=>$id,'Approval.model_name'=>$modelName)));
                    foreach($approves as $approve)
                    {
                        $approve['Approval']['soft_delete']=0;
                        $this->Approval->save($approve, false);
                    }
            $data['id'] = $id;
            $data['soft_delete'] = 0;
            $modelName = $this->modelClass;
            $this->$modelName->save($data, false);
            $this->Session->setFlash(__('%s restored',$record));
        }

        if($this->request->params['controller'] == 'stocks'){
            $this->redirect($this->referer());

        }else{
            $this->redirect(array(
                'action' => 'index'
            ));
        }
    }

    public function delete($id = null) {
        $modelName = $this->modelClass;
        $record = Inflector::underscore($modelName);
        $record = Inflector::humanize($record);
        $this->loadModel('Approval');
        if (!empty($id)) {
             $approves = $this->Approval->find('all',array('conditions'=>array('Approval.record'=>$id,'Approval.model_name'=>$modelName)));
                    foreach($approves as $approve)
                    {
                        $approve['Approval']['soft_delete']=1;
                        $this->Approval->save($approve, false);
                    }
            $data['id'] = $id;
            $data['soft_delete'] = 1;
            $modelName = $this->modelClass;
            $this->$modelName->save($data, false);
        }
        if($this->modelClass == 'FileUpload' || $this->modelClass == 'Stock'){
	   		$this->redirect($this->referer());
        }elseif($this->request->params['controller'] != 'internal_audits') {
            $this->Session->setFlash(__('Selected %s Deleted',$record));
            $this->redirect(array('action' => 'index'));
        } else {
            exit();
        }
    }

    /**
     * purge method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function purge($id = null) {
        $modelName = $this->modelClass;
        $controller = Inflector::variable(Inflector::pluralize($modelName));
        $record = Inflector::underscore($modelName);
        $record = Inflector::humanize($record);
        $this->$modelName->id = $id;
        $this->loadModel('Approval');
        $this->loadModel('FileUpload');
        if (!$this->$modelName->exists()) {
            throw new NotFoundException(__('Invalid detail'));
        }

        $approves = $this->Approval->find('all',array('conditions'=>array('Approval.record'=>$id,'Approval.model_name'=>$modelName)));
        $fileUploads = $this->FileUpload->find('all',array('conditions'=>array('FileUpload.record'=>$id)));

        foreach($approves as $approve)
        {
            if(!($this->Approval->delete($approve['Approval']['id'], true)))
            {
		$this->Session->setFlash(__('All selected value was not deleted from Approve'));
		$this->redirect(array('action' => 'index'));
	    }
        }
        foreach($fileUploads as $fileUpload)
        {
            if(!($this->FileUpload->delete($fileUpload['FileUpload']['id'], true)))
            {
		$this->Session->setFlash(__('All selected value was not deleted from Upload'));
		$this->redirect(array('action' => 'index'));
	    }
        }

        $this->_deleteFile($id, $controller);

        if ($this->$modelName->delete($id, true)) {
            $this->Session->setFlash(__('Selected %s Deleted',$record));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $this->Session->setFlash(__('Selected %s was not deleted',$record));
        $this->redirect(array(
            'action' => 'index'
        ));
    }

    public function _deleteFile($record = null, $controller = null){
        $path = WWW_ROOT .  'files'. DS . $this->Session->read('User.company_id') . DS . "upload". DS . $this->Session->read('User.id') . DS . $controller . DS .$record;
        $folder = new Folder($path);
        if($folder->delete())
            return;
    }


    public function _get_notifications()
	 {
	    $notificationCount = 0;
	    $this->loadModel('Notification');
	    $this->Notification->recursive = 0;
	    $view_notifications = $this->Notification->NotificationUser->find('all',array('fields'=>array(''),
			'conditions'=>array('NotificationUser.employee_id'=>$this->Session->read('User.employee_id'))));
	    $date = date('Y-m-d');
	    $notificationCount = $this->Notification->NotificationUser->find('count',array('conditions'=>array('NotificationUser.employee_id'=>$this->Session->read('User.employee_id'), 'NotificationUser.status'=>0)));

            $this->set(compact('notificationCount'));

	}

      public function _get_suggestions(){
        $this->loadModel('SuggestionForm');
        $suggestionCount = 0;
        $suggestionCount = $this->SuggestionForm->find('count',array('conditions'=>array('SuggestionForm.publish'=>1, 'SuggestionForm.soft_delete'=>0,'SuggestionForm.status'=>0,'SuggestionForm.employee_id'=>$this->Session->read('User.employee_id')),'recursive'=>-1));
        if((isset($suggestionCount) && $suggestionCount > 0 )){
            $this->set(array('suggestionCount'=>$suggestionCount));
        }else{
			$this->set(array('suggestionCount'=>null));
	}

    }


    public function _get_messages() {
        $this->loadModel('MessageUserInbox');
        $messageCount = $this->MessageUserInbox->find('count', array(
            'conditions' => array(
                'MessageUserInbox.user_id' => $this->Session->read('User.id'),
                'MessageUserInbox.status' => 0
            ),
            'recursive' => - 1
        ));
        if ($messageCount && $messageCount > 0) {
            $this->set(array(
                'messageCount' => $messageCount
            ));
        } else {
            $this->set(array(
                'messageCount' => null
            ));
        }
    }

    public  function _format_file_size($data) {

        // Bytes

        if ($data < 1024) {
            return $data . " bytes";
        }

        // Kilobytes
        else
        if ($data < 1024000) {
            return round(($data / 1024), 1) . "k";
        }

        // Megabytes
        else {
            return round(($data / 1024000), 1) . "MB";
        }
    }

    public function _get_template() {
		return false;
        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = - 1;
        $system_tbl_id = $this->SystemTable->find('first', array(
            'conditions' => array(
                'SystemTable.system_name' => $this->request->params['controller']
            )
        ));
        $this->loadModel('CustomTemplate');
        $this->CustomTemplate->recursive = 0;
        $templates = $this->CustomTemplate->find('list', array(
            'conditions' => array(
                'CustomTemplate.system_table_id' => $system_tbl_id['SystemTable']['id']
            )
        ));
        return $templates;
    }

    public function get_header($header = null, $formats = null) {
        $this->loadModel('SystemTable');
        $system_table = $this->SystemTable->find('first', array(
            'conditions' => array(
                'SystemTable.id' => $formats
            )
        ));
        $master = $this->SystemTable->MasterListOfFormat->find('first', array(
            'conditions' => array(
                'MasterListOfFormat.system_table_id' => $system_table['SystemTable']['id']
            )
        ));
        $header = str_replace('&lt;FlinkISO&gt;', '<FlinkIso>', $header);
        $header = str_replace('&lt;/FlinkISO&gt;', '</FlinkIso>', $header);
        $header = str_replace('<a class="badge label-info add-margin" href=" ', '', $header);
        $header = str_replace('</a>', '', $header);
        $header = str_replace('&nbsp;', '', $header);
        $to_delete = $this->_get_between($head, '</FlinkIso>', '</a>');
        $header = str_replace($to_delete, '', $header);
        $company_name = $this->_get_company();
        $header = str_replace('Company Name', $company_name['Company']['name'], $header);
        $headers = explode('<td>', $header);
        foreach ($headers as $head):
            $header_fields = $this->_get_between($head, '<FlinkIso>', '</FlinkIso>');
            $split_fields = explode('-', $header_fields);
            $get_field = ltrim(rtrim($split_fields[1]));
            if ($get_field)
                  $get_value = $master['MasterListOfFormat'][$get_field];
            if ($get_value) {
                $add_value = $this->_get_between($head, '<FlinkIso>', '</td>');
                $field_values = str_replace('<FlinkIso>', '', str_replace($add_value, $get_value, $head));
                $header = str_replace($add_value, $get_value, $header);
            }
        endforeach;
        return $header;
    }

    public function _generate_report() {
        $this->loadModel('CustomTemplate');
        $template = $this->CustomTemplate->find('first', array(
            'conditions' => array(
                'CustomTemplate.id' => $this->request->data[$this->modelClass]['template_id']
            )
        ));
        $this->set('template', $template);
        $model = $this->modelClass;
        $result = explode('+', $this->request->data[$model]['rec_selected']);
        $reports = $this->$model->find('all', array(
            'conditions' => array(
                'or' => array(
                    $this->modelClass . '.id' => $result
                )
            )
        ));
        $getHeader = $this->get_header($template['CustomTemplate']['header'], $template['CustomTemplate']['system_table_id']);
        $tables = explode('<table', $template['CustomTemplate']['template_body']);
        unset($tables[0]);
        foreach ($tables as $table):
            $multiple = strstr($table, 'class=" multiple', true);
            $single = strstr($table, 'class=" single"');
            if ($single) {
                $fields = null;
                $firstRow = $this->_get_between($table, '<tbody>', '<td>');
                $i = 0;
                $x = explode('<td>', $table);
                foreach ($x as $y):
                    $z = explode('<br />', $y);
                    foreach ($z as $mix):
                        $fields[$i][] = $this->_get_between($mix, '%20%3CFlinkISO%3E%20', '%20%3C/FlinkISO%3E');
                    endforeach;
                    $i++;
                endforeach;
                unset($fields[0]);
                $i = 0;
                $drawSingle = null;
                foreach ($reports as $report):
                    $drawSingle.= "<tr>";
                    foreach ($fields as $final):
                        $drawSingle.= "<td>";
                        foreach ($final as $f):
                            $xxx = explode('-', $f);
                            $finalData[$i][$xxx[1]][$xxx[2]] = $report[$xxx[1]][$xxx[2]];
                            $drawSingle.= $finalData[$i][$xxx[1]][$xxx[2]] . " ";
                        endforeach;
                        $drawSingle.= "</td>";
                    endforeach;
                    $drawSingle.= "</tr>";
                    $i++;
                endforeach;
                $draw.= '<table width="100%" border="1"><tr>' . $firstRow . '</tr>' . $drawSingle . '</table><br />';
            }
            elseif ($multiple) {
                $firstRow = $this->_get_between($table, '<tbody>', '<td>');
                $i = 0;
                $x = explode('<td>', $table);
                $fields = null;
                foreach ($x as $y):
                    $z = explode('<br />', $y);
                    foreach ($z as $mix):
                        $fields[$i][] = $this->_get_between($mix, '%20%3CFlinkISO%3E%20', '%20%3C/FlinkISO%3E');
                    endforeach;
                    $i++;
                endforeach;
                unset($fields[0]);
                $result = explode('+', $this->request->data[Inflector::pluralize($this->modelClass)]['rec_selected']);
                $i = 0;
                $drawMultiple = null;
                foreach ($reports as $report):
                    $drawMultiple.= "<tr>";
                    foreach ($fields as $final):
                        $drawMultiple.= "<td>";
                        foreach ($final as $f):
                            $xxx = explode('-', $f);
                            $finalData[$i][$xxx[1]][$xxx[2]] = $report[$xxx[1]][$xxx[2]];
                            $drawMultiple.= $finalData[$i][$xxx[1]][$xxx[2]] . " ";
                        endforeach;
                        $drawMultiple.= "</td>";
                    endforeach;
                    $drawMultiple.= "</tr>";
                    $i++;
                endforeach;
                $draw.= '<table width="100%" border="1"><tr>' . $firstRow . '</tr>' . $drawMultiple . '</table><br />';
            }
            else {
                $this->Session->setFlash(__('Please make sure you have created the proper report. It looks like you have not defined the table class (single/multiple) '));
                $this->redirect(array(
                    'controller' => 'custom_templates',
                    'action' => 'edit',
                    $this->request->data[$this->modelClass]['template_id']
                ));
            }

        endforeach;
        $draw = $getHeader . $draw;
        $this->set('drawRecords', $draw);
    }

    public function _get_between($content, $start, $end) {
        $result = explode($start, $content);
        if (isset($result[1])) {
            $result = explode($end, $result[1]);
            return $result[0];
        }
        return '';
    }

    public function publish_record($id = null) {
        $modelName = $this->modelClass;
	if($modelName == 'Meeting'){
		$this->Session->setFlash(__("You can't publish meeting records."));
		$this->redirect(array(
		    'action' => 'index'
		));
	}
        if ($modelName == 'MaterialQualityCheck') {
            $allMQC = $this->MaterialQualityCheck->find('all', array('conditions' => array('MaterialQualityCheck.material_id' => $id), 'recursive' => -1));

            foreach ($allMQC as $mQC) {
                $data['id'] = $mQC['MaterialQualityCheck']['id'];
                $data['material_id'] = $mQC['MaterialQualityCheck']['material_id'];
                $data['publish'] = 1;
                $this->$modelName->save($data, false);
            }
            $this->Session->setFlash(__("Record published successfully."));

        } else {
            $data['id'] = $id;
            $data['publish'] = 1;
            $this->$modelName->save($data, false);
            $this->Session->setFlash(__("Record published successfully."));
	}
        $this->redirect(array(
            'action' => 'index'
        ));
    }

    public function language_details() {
	$this->loadModel('Language');
	$languageData = array();
	return $languageData = $this->Language->find('all', array('recursive'=>-1));
    }

    public function advance_search_common($conditions = array()) {
	$model = $this->modelClass;

	if ($this->request->query['prepared_by'] != -1) {
            $prepared_byConditions[] = array($model.'.prepared_by' => $this->request->query['prepared_by']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $prepared_byConditions);
            else
                $conditions[] = array('or' => $prepared_byConditions);
        }

	if ($this->request->query['approved_by'] != -1) {
            $approved_byConditions[] = array($model.'.approved_by' => $this->request->query['approved_by']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $approved_byConditions);
            else
                $conditions[] = array('or' => $approved_byConditions);
        }

	return $conditions;

    }

    public function _save_approvals()  {
        
    }

	public function _getRecordFiles($rec_id = null,$system_table_id = null, $product = NULL){



		if($rec_id && $product == NULL && $system_table_id != 'dashboards')$conditions = array('FileUpload.publish'=>1,'FileUpload.soft_delete'=>0,'FileUpload.record'=>$this->request->params['pass'][0],'FileUpload.system_table_id'=>$system_table_id['SystemTable']['id']);
		elseif($rec_id && $product)$conditions = array('FileUpload.publish'=>1,'FileUpload.soft_delete'=>0,'FileUpload.record'=>$this->request->params['pass'][1],'FileUpload.system_table_id'=>$system_table_id['SystemTable']['id'],'FileUpload.file_dir Like'=>'%'.$this->request->params['pass'][0].'%');
		elseif($rec_id && $product == NULL && $system_table_id == 'dashboards' )$conditions = array('FileUpload.publish'=>1,'FileUpload.soft_delete'=>0,'FileUpload.record'=>$this->request->params['pass'][0],'FileUpload.system_table_id'=>$system_table_id);
		else $conditions = array('FileUpload.publish'=>1,'FileUpload.soft_delete'=>0,'FileUpload.record'=>$this->request->action);
		$conditions = array($conditions,'FileUpload.archived'=>0);
		
		$this->loadModel('FileUpload');
		$this->FileUpload->recursive = 0;
		$files = $this->FileUpload->find('all',array(
			'order'=>array('FileUpload.result'=>'DESC'),
			'fields'=>array(
				'User.id','User.name',
				'CreatedBy.id','CreatedBy.name',
				'FileUpload.file_details',
				'FileUpload.record',
				'FileUpload.system_table_id',				
				'FileUpload.file_type',
				'FileUpload.file_dir',
				'FileUpload.version',
				'FileUpload.comment',
				'FileUpload.created',
				'FileUpload.created_by',
				'PreparedBy.name',
				'ApprovedBy.name',
				'FileUpload.modified',
				'FileUpload.modified_by',
				'FileUpload.file_status',
			),
			'conditions'=>$conditions));
	$this->set('files',$files);
	}

	public function _getApprovalFiles($rec_id = null,$system_table_id = null, $product = NULL){
		$conditions = array('FileUpload.publish'=>1,'FileUpload.soft_delete'=>0,'FileUpload.record'=>'approvals');
		$this->loadModel('FileUpload');
		$this->FileUpload->recursive = 0;
		$files = $this->FileUpload->find('all',array(
			'order'=>array('FileUpload.result'=>'DESC'),
			'fields'=>array(
				'User.id','User.name',
				'CreatedBy.id','CreatedBy.name',
				'FileUpload.file_details',
				'FileUpload.record',
				'FileUpload.file_type',
				'FileUpload.file_dir',
				'FileUpload.version',
				'FileUpload.comment',
				'FileUpload.created',
				'FileUpload.created_by',
				'PreparedBy.name',
				'ApprovedBy.name',
				'FileUpload.modified',
				'FileUpload.modified_by',
				'FileUpload.file_status',
			),
			'conditions'=>$conditions));
	$this->set('approvalfiles',$approvalfiles);
	
	//get system table id for approvals table
	$this->loadModel('SystemTable');
	$this->SystemTable->recursive = -1;
	
	$this->set('approvalSystemTableId',$this->SystemTable->find('first',array('fields'=>array('SystemTable.id'),'conditions'=>array('SystemTable.system_name'=>'approvals'))));
	
	}	

	public function _upload_add($filename, $ext, $message, $dir) {
		$path = $dir;
		$newpath = explode("/", $path);
		$this->loadModel('FileUpload');
       $this->FileUpload->create();
       $newFileUploadData = array();
		$filename=str_replace(' ','-',$filename);
		$filename=str_replace('.','-',$filename);

		$this->loadModel('MasterListOfFormat');
		$master = $this->MasterListOfFormat->find('first', array(
            'conditions' => array(
                'MasterListOfFormat.system_table_id' => $this->_get_system_table($newpath[2])
            ),
			'fields'=>array('MasterListOfFormat.id')

        ));

	   if($newpath[1]=='documents' && $newpath[2] == NULL){
			   $newFileUploadData['FileUpload']['system_table_id'] = $this->_get_system_table('users');
			   if(!$newpath[3])$newFileUploadData['FileUpload']['record'] = $newpath[2];
	   }elseif($newpath[1]=='documents' && $newpath[2] != NULL){
			   $newFileUploadData['FileUpload']['system_table_id'] = 'dashboards';
			   if(!$newpath[3])$newFileUploadData['FileUpload']['record'] = $newpath[2];
	   }else{
		   if(!$this->_get_system_table($newpath[2]))$newFileUploadData['FileUpload']['system_table_id'] = 'dashboards';
		   else $newFileUploadData['FileUpload']['system_table_id'] = $this->_get_system_table($newpath[2]);

		   if(!$newpath[3])$newFileUploadData['FileUpload']['record'] = $newpath[2];
			else $newFileUploadData['FileUpload']['record'] = $newpath[3];
	   }

		$newFileUploadData['FileUpload']['file_details'] = $filename;
		$newFile = explode('-ver-',$filename);
		$newFileUploadData['FileUpload']['version'] = $newFile[1];
		if($newFile[1] == 1)
			{
				$newFileUploadData['FileUpload']['comment'] = "First Upload";
			}else{
				$newFileUploadData['FileUpload']['comment'] = "Revision";
			}
        $newFileUploadData['FileUpload']['user_id'] = $this->Session->read('User.id');
        $newFileUploadData['FileUpload']['file_type'] = $ext;
        $newFileUploadData['FileUpload']['file_dir'] = str_replace('//','/',$dir .'/'.$filename .'.'.$ext);
        $newFileUploadData['FileUpload']['file_status'] = 1;
        $newFileUploadData['FileUpload']['result'] = $message;
        $newFileUploadData['FileUpload']['publish'] = 1;
        $newFileUploadData['FileUpload']['soft_delete'] = 0;
        $newFileUploadData['FileUpload']['user_session_id'] = $this->Session->read('User.user_session_id');
        $newFileUploadData['FileUpload']['created_by'] = $this->Session->read('User.id');
        $newFileUploadData['FileUpload']['prepared_by'] = $this->Session->read('User.employee_id');
        $newFileUploadData['FileUpload']['approved_by'] = $this->Session->read('User.employee_id');
        $newFileUploadData['FileUpload']['modified_by'] = $this->Session->read('User.id');
        $newFileUploadData['FileUpload']['master_list_of_format_id'] = $master['MasterListOfFormat']['id'];
        $this->FileUpload->save($newFileUploadData);
		
	if($newFile[1] > 1)
			{
				$this->_add_revs($newFileUploadData,$this->FileUpload->id);
    }
	}

	public function _add_revs($newFileUploadData = null, $id = null){
		$this->loadModel('FileUpload');
		$revs = $this->FileUpload->find('all',array(
			'conditions'=>array(
					'FileUpload.system_table_id'=>$newFileUploadData['FileUpload']['system_table_id'],
					'FileUpload.record'=>$newFileUploadData['FileUpload']['record'],
					'FileUpload.id <> ' => $id
			),
			'fields'=>array(
				'FileUpload.file_details',
				'FileUpload.id',
				)
			));
			
			foreach($revs as $rev):
				$this->FileUpload->read(null,$rev['FileUpload']['id']);
					$revData['FileUpload']['id'] = $rev['FileUpload']['id'];
					$revData['FileUpload']['archived'] = 1;
					$this->FileUpload->set($revData);
					$this->FileUpload->save();		
			endforeach;		
	}

    public function send_customise(){

        try{
            $url = "https://www.flinkiso.com/customization_requests.php";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:31.0) Gecko/20100101 Firefox/31.0"));
            $postfields = array();
            $postfields['customization_title'] = urlencode($this->request->data['customize']['customization_title']);
            $postfields['company'] = urlencode($this->request->data['customize']['company']);
            $postfields['branch_name'] = urlencode($this->request->data['customize']['branch_name']);
            $postfields['employee'] = urlencode($this->request->data['customize']['employee']);
            $postfields['request_for'] = urlencode($this->request->data['customize']['request_for']);
            $postfields['customization_details'] = urlencode($this->request->data['customize']['customization_details']);

            curl_setopt($ch, CURLOPT_POST, count($postfields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
            $ret = curl_exec($ch);
            curl_close($ch);

            echo '<div class="alert alert-success">Thank you for sending the request. <br/><br/>We will get back to you soon.<br /></div>';
        } catch(Exception $e){
            echo '<div class="alert alert-danger">We are unable to forward your reqest at this time. You can call us directly on +91 8451956565.<br />Thank You.</div>';
        }
	exit;
    }   
}
