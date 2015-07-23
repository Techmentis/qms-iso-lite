<?php

App::uses('AppController', 'Controller');

/**
 * InternalAuditPlans Controller
 *
 * @property InternalAuditPlan $InternalAuditPlan
 */
class InternalAuditPlansController extends AppController {

    public function _get_system_table_id() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $this->request->params['controller'])));
        return $systemTableId['SystemTable']['id'];
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {

        $conditions = $this->_check_request();
        $this->paginate = array('order' => array('InternalAuditPlan.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->InternalAuditPlan->recursive = 2;
        $this->set('internalAuditPlans', $this->paginate());

        $this->_get_count();
    }

    /**
     * adcanced_search method
     * Advanced search by - TGS
     * @return void
     */
    public function advanced_search() {

        $conditions = array();
        if ($this->request->query['keywords']) {
            $searchArray = array();
            $searchKeys = explode(" ", $this->request->query['keywords']);

            foreach ($searchKeys as $searchKey):
                foreach ($this->request->query['search_fields'] as $search):
                    if ($this->request->query['strict_search'] == 0)
                        $searchArray[] = array('InternalAuditPlan.' . $search => $searchKey);
                    else
                        $searchArray[] = array('InternalAuditPlan.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('InternalAuditPlan.branchid' => $branches);
            endforeach;
            $conditions[] = array('or' => $branchConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('InternalAuditPlan.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'InternalAuditPlan.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('InternalAuditPlan.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('InternalAuditPlan.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->InternalAuditPlan->recursive = 0;
        $this->paginate = array('order' => array('InternalAuditPlan.sr_no' => 'DESC'), 'conditions' => $conditions, 'InternalAuditPlan.soft_delete' => 0);
        $this->set('internalAuditPlans', $this->paginate());

        $this->render('index');
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->InternalAuditPlan->exists($id)) {
            throw new NotFoundException(__('Invalid internal audit plan'));
        }

        $options = array('conditions' => array('InternalAuditPlan.' . $this->InternalAuditPlan->primaryKey => $id));
        $internalAuditPlan = $this->InternalAuditPlan->find('first', $options);
        $this->set('internalAuditPlan', $internalAuditPlan);
        if ($internalAuditPlan['InternalAuditPlan']['publish'] == 1 && !$this->request->is('post'))
            $this->request->data['InternalAuditPlan']['publish'] = $internalAuditPlan['InternalAuditPlan']['publish'];

        $branches = $this->_get_branch_list();
        foreach ($branches as $key => $value):
            $plan[$key] = $this->InternalAuditPlan->InternalAuditPlanDepartment->find('all', array('conditions' => array('InternalAuditPlanDepartment.soft_delete' => 0, 'InternalAuditPlanDepartment.branch_id' => $key, 'InternalAuditPlanDepartment.internal_audit_plan_id' => $id)));
        endforeach;

        $this->set(array('plan' => $plan));
        $this->loadModel('User');
        $this->User->recursive = 0;
        $userids = $this->User->find('list', array('order' => array('User.name' => 'ASC'), 'conditions' => array('User.publish' => 1, 'User.soft_delete' => 0, 'User.is_approvar' => 1)));
        $this->set(array('userids' => $userids, 'showApprovals' => $this->_show_approvals()));


        if ($this->request->is('post')) {
            $this->request->data['InternalAuditPlan']['note'] = htmlentities($this->request->data['InternalAuditPlan']['note']);
            if ($this->InternalAuditPlan->save($this->request->data)) {
                $internalAuditPlanDepartments = $this->InternalAuditPlan->InternalAuditPlanDepartment->find('all', array('conditions' => array('internal_audit_plan_id' => $this->InternalAuditPlan->id)));
                $internalAuditPlanBranches = $this->InternalAuditPlan->InternalAuditPlanBranch->find('all', array('conditions' => array('internal_audit_plan_id' => $this->InternalAuditPlan->id)));

                $auditDepartmentUsers = array();
                if (count($internalAuditPlanBranches) && count($internalAuditPlanDepartments))
                    foreach ($internalAuditPlanBranches as $branches) {
                        foreach ($internalAuditPlanDepartments as $val) {
                            $auditDepartmentUsers[$val['InternalAuditPlanDepartment']['employee_id']] = $val['InternalAuditPlanDepartment']['employee_id'];
                            $auditDepartmentUsers[$val['ListOfTrainedInternalAuditor']['employee_id']] = $val['ListOfTrainedInternalAuditor']['employee_id'];
                        }
                    }
                if ($this->request->data['InternalAuditPlan']['notify_users']) {

                    //Edit internal audit plan on notification

		       $this->loadModel('NotificationType');
                $notificationType = $this->NotificationType->find('first', array('conditions' => array('NotificationType.name' => 'Internal Audits', 'NotificationType.soft_delete' => 0)));

                    $this->loadModel('Notification');
                    $notifications = $this->Notification->find('first', array('conditions' => array('internal_audit_plan_id' => $this->InternalAuditPlan->id)), false);
                    $notificationsId = $notifications['Notification']['id'];
                    $val = array();
                    if ($notificationsId) {
                        $this->Notification->id = $notificationsId;
                        $val['id'] = $notificationsId;
                    } else
                        $this->Notification->create();
		    $val['notification_type_id'] = isset($notificationType['NotificationType']['id'])? $notificationType['NotificationType']['id'] :'';
                    $val['title'] = $this->request->data['InternalAuditPlan']['title'];
                    $val['message'] = $this->request->data['InternalAuditPlan']['notify_note'];
                    $val['start_date'] = $this->request->data['InternalAuditPlan']['schedule_date_from'];
                    $val['end_date'] = $this->request->data['InternalAuditPlan']['schedule_date_to'];
                    $val['internal_audit_plan_id'] = $this->InternalAuditPlan->id;
                    $val['prepared_by'] = $this->Session->read('User.employee_id');
                    $val['approved_by'] = $this->Session->read('User.employee_id');
                    $val['publish'] = $this->request->data['InternalAuditPlan']['publish'];
                    $val['branchid'] = $this->Session->read('User.branch_id');
                    $val['departmentid'] = $this->Session->read('User.department_id');
                    $val['created_by'] = $this->Session->read('User.id');
                    $val['modified_by'] = $this->Session->read('User.id');
                    $val['system_table_id'] = $this->_get_system_table_id();

                    $this->Notification->save($val, false);


                    //Edit internal audit plan on notification User
                    $this->loadModel('NotificationUser');
                    $this->NotificationUser->deleteAll(array('notification_id' => $this->Notification->id), false);
                    $this->loadModel('User');

                    foreach ($auditDepartmentUsers as $employeeId) {
                        $this->NotificationUser->create();
                        $val = array();
                        $val['notification_id'] = $this->Notification->id;
                        $val['employee_id'] = $employeeId;
                        $val['publish'] = 1;
                        $val['branchid'] = $this->Session->read('User.branch_id');
                        $val['departmentid'] = $this->Session->read('User.department_id');
                        $val['created_by'] = $this->Session->read('User.id');
                        $val['modified_by'] = $this->Session->read('User.id');
                        $val['system_table_id'] = $this->_get_system_table_id();
                        $this->NotificationUser->save($val, false);
                    }
                } else {
                    $this->loadModel('Notification');
                    $this->Notification->deleteAll(array('internal_audit_plan_id' => $this->InternalAuditPlan->id), false);
                }

                //Edit internal audit on timeline
                if ($this->request->data['InternalAuditPlan']['show_on_timeline']) {
                    $this->loadModel('Timeline');
                    $this->Timeline->deleteAll(array('internal_audit_plan_id' => $this->InternalAuditPlan->id), false);
                    $this->Timeline->create();
                    $val = array();
                    $val['title'] = $this->request->data['InternalAuditPlan']['title'];
                    $val['message'] = $this->request->data['InternalAuditPlan']['notify_note'];
                    $val['start_date'] = $this->request->data['InternalAuditPlan']['schedule_date_from'];
                    $val['end_date'] = $this->request->data['InternalAuditPlan']['schedule_date_to'];
                    $val['internal_audit_plan_id'] = $this->InternalAuditPlan->id;
                    $val['prepared_by'] = $this->Session->read('User.id');
                    $val['approved_by'] = $this->Session->read('User.id');
                    $val['publish'] = $this->request->data['InternalAuditPlan']['publish'];
                    $val['branchid'] = $this->Session->read('User.branch_id');
                    $val['departmentid'] = $this->Session->read('User.department_id');
                    $val['created_by'] = $this->Session->read('User.id');
                    $val['modified_by'] = $this->Session->read('User.id');
                    $val['system_table_id'] = $this->_get_system_table_id();
                    $this->Timeline->save($val, false);
                } else {
                    $this->loadModel('Timeline');
                    $this->Timeline->deleteAll(array('internal_audit_plan_id' => $this->InternalAuditPlan->id), false);
                }

                if ($this->request->data['InternalAuditPlan']['notify_users_emails']) {
                    try{
                        App::uses('CakeEmail', 'Network/Email');
                        if($this->Session->read('User.is_smtp') == '1')
                        {
                            $EmailConfig = new CakeEmail("smtp");	
                        }else if($this->Session->read('User.is_smtp') == '0'){
                            $EmailConfig = new CakeEmail("default");
                        }
                        $EmailConfig->subject('FlinkISO: Internal Audit Plan');
                        $internalAuditPlan = $this->InternalAuditPlan->find('first', array('conditions' => array('InternalAuditPlan.id' => $id, 'InternalAuditPlan.publish' => 1, 'InternalAuditPlan.soft_delete' => 0)));
                        $this->loadModel('Employee');
                        $this->Employee->recursive = -1;
                        $emails = array();
                        $k=0;
                        foreach ($auditDepartmentUsers as $employeeId) {
                            $auditorEmail = $this->Employee->find('first', array('conditions' => array('Employee.id' => $employeeId), 'fields' => array('Employee.office_email', 'Employee.name')));
			    if(isset($auditorEmail['Employee']['office_email']) && $auditorEmail['Employee']['office_email']!='')
                                if($k==0){
                                     $EmailConfig->to($auditorEmail['Employee']['office_email']);
                                }else{
                                    $emails[] = $auditorEmail['Employee']['office_email'];
                                }
                                $k++;
                        }
                        $EmailConfig->bcc($emails);
                        $EmailConfig->template('internalAuditPlan');
                        $EmailConfig->viewVars(array('internalAuditPlan' => $internalAuditPlan));
                        $EmailConfig->emailFormat('html');
                        $EmailConfig->send();
                        $this->Session->setFlash('An email has been sent');
                     } catch(Exception $e) {
                         $this->Session->setFlash(__('Can not notify user using email. Please check SMTP details and email address is correct.'));
			  $this->redirect(array('action' => 'view', $this->InternalAuditPlan->id));

                    }
                }

                $this->redirect(array('action' => 'view', $this->InternalAuditPlan->id));
            }
        }
    }

    public function view_plan($id = null) {
        $this->layout = "ajax";
        if (!$this->InternalAuditPlan->exists($id)) {
            throw new NotFoundException(__('Invalid internal audit plan'));
        }
        $this->InternalAuditPlan->recursive = 0;
        $options = array('conditions' => array('InternalAuditPlan.' . $this->InternalAuditPlan->primaryKey => $id));
        $this->set('internalAuditPlan', $this->InternalAuditPlan->find('first', $options));

        $this->loadModel('InternalAuditPlanDepartment');
        $branches = $this->_get_branch_list();
        foreach ($branches as $key => $value):
            $plan[$key] = $this->InternalAuditPlanDepartment->find('all', array('conditions' => array('InternalAuditPlanDepartment.soft_delete' => 0, 'InternalAuditPlanDepartment.branch_id' => $key, 'InternalAuditPlanDepartment.internal_audit_plan_id' => $id
            )));
        endforeach;
        $this->set(array('plan' => $plan));
    }

    public function plan_report($id = null) {
        $this->layout = "ajax";
        if (!$this->InternalAuditPlan->exists($id)) {
            throw new NotFoundException(__('Invalid internal audit plan'));
        }
        $this->InternalAuditPlan->recursive = 0;
        $options = array('conditions' => array('InternalAuditPlan.' . $this->InternalAuditPlan->primaryKey => $id));
        $this->set('internalAuditPlan', $this->InternalAuditPlan->find('first', $options));

        $this->loadModel('InternalAuditPlanDepartment');
        $branches = $this->_get_branch_list();
        foreach ($branches as $key => $value):
            $plan[$key] = $this->InternalAuditPlanDepartment->find('all', array('conditions' => array('InternalAuditPlanDepartment.soft_delete' => 0, 'InternalAuditPlanDepartment.branch_id' => $key, 'InternalAuditPlanDepartment.internal_audit_plan_id' => $id)));
        endforeach;
        $this->set(array('plan' => $plan));
    }

    /**
     * list method
     *
     * @return void
     */
    public function lists() {

        $this->_get_count();
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->InternalAuditPlan->exists($id)) {
            throw new NotFoundException(__('Invalid internal audit plan'));
        }
        $this->loadModel('Approval');
        if (!$this->Approval->exists($approvalId)) {
            throw new NotFoundException(__('Invalid approval id'));
        }
        $approval = $this->Approval->read(null, $approvalId);
        $this->set('same', $approval['Approval']['user_id']);
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['InternalAuditPlan']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['InternalAuditPlan']['note'] = htmlentities($this->request->data['InternalAuditPlan']['note']);

            if ($this->InternalAuditPlan->save($this->request->data, false)) {

                //Edit internal audit on timeline
                if ($this->request->data['InternalAuditPlan']['show_on_timeline']) {
                    $this->loadModel('Timeline');
                    $this->Timeline->deleteAll(array('internal_audit_plan_id' => $this->InternalAuditPlan->id), false);
                    $this->Timeline->create();
                    $val = array();
                    $val['title'] = $this->request->data['InternalAuditPlan']['title'];
                    $val['message'] = htmlentities($this->request->data['InternalAuditPlan']['note']);
                    $val['start_date'] = $this->request->data['InternalAuditPlan']['schedule_date_from'];
                    $val['end_date'] = $this->request->data['InternalAuditPlan']['schedule_date_to'];
                    $val['internal_audit_plan_id'] = $this->InternalAuditPlan->id;
                    $val['prepared_by'] = $this->Session->read('User.id');
                    $val['approved_by'] = $this->Session->read('User.id');
                    $val['publish'] = $this->request->data['InternalAuditPlan']['publish'];
                    $val['branchid'] = $this->request->data['InternalAuditPlan']['branchid'];
                    $val['departmentid'] = $this->request->data['InternalAuditPlan']['departmentid'];
                    $val['modified_by'] = $this->Session->read('User.id');
                    $val['system_table_id'] = $this->_get_system_table_id();
                    $this->Timeline->save($val, false);
                } else {
                    $this->loadModel('Timeline');
                    $this->Timeline->deleteAll(array('internal_audit_plan_id' => $this->InternalAuditPlan->id), false);
                }

                $internalAuditPlanDepartments = $this->InternalAuditPlan->InternalAuditPlanDepartment->find('all', array('conditions' => array('internal_audit_plan_id' => $this->InternalAuditPlan->id)));
                $internalAuditPlanBranches = $this->InternalAuditPlan->InternalAuditPlanBranch->find('all', array('conditions' => array('internal_audit_plan_id' => $this->InternalAuditPlan->id)));

                $auditDepartmentUsers = array();
                if (count($internalAuditPlanBranches) && count($internalAuditPlanDepartments))
                    foreach ($internalAuditPlanBranches as $branches) {
                        foreach ($internalAuditPlanDepartments as $val) {
                            $auditDepartmentUsers[$val['InternalAuditPlanDepartment']['employee_id']] = $val['InternalAuditPlanDepartment']['employee_id'];
                            $auditDepartmentUsers[$val['ListOfTrainedInternalAuditor']['employee_id']] = $val['ListOfTrainedInternalAuditor']['employee_id'];
                        }
                    }
                if ($this->request->data['InternalAuditPlan']['notify_users']) {
                    //Edit internal audit plan on notification
                    $this->loadModel('Notification');
                    $notifications = $this->Notification->find('first', array('conditions' => array('internal_audit_plan_id' => $this->InternalAuditPlan->id)), false);
                    $notificationsId = $notifications['Notification']['id'];
                    $val = array();
                    $val['id'] = $notificationsId;
                    $val['title'] = $this->request->data['InternalAuditPlan']['title'];
                    $val['message'] = htmlentities($this->request->data['InternalAuditPlan']['note']);
                    $val['start_date'] = $this->request->data['InternalAuditPlan']['schedule_date_from'];
                    $val['end_date'] = $this->request->data['InternalAuditPlan']['schedule_date_to'];
                    $val['internal_audit_plan_id'] = $this->InternalAuditPlan->id;
                    $val['prepared_by'] = $this->Session->read('User.id');
                    $val['approved_by'] = $this->Session->read('User.id');
                    $val['publish'] = $this->request->data['InternalAuditPlan']['publish'];
                    $val['branchid'] = $this->request->data['InternalAuditPlan']['branchid'];
                    $val['departmentid'] = $this->request->data['InternalAuditPlan']['departmentid'];
                    $val['modified_by'] = $this->Session->read('User.id');
                    $val['system_table_id'] = $this->_get_system_table_id();
                    $this->Notification->save($val, false);

                    //Edit internal audit plan on notification User
                    $this->loadModel('NotificationUser');
                    $this->NotificationUser->deleteAll(array('notification_id' => $this->Notification->id), false);
                    $this->loadModel('User');

                    foreach ($auditDepartmentUsers as $employeeId) {
                        $this->NotificationUser->create();
                        $val = array();
                        $val['notification_id'] = $this->Notification->id;
                        $val['employee_id'] = $employeeId;
                        $val['publish'] = $this->request->data['InternalAuditPlan']['publish'];
                        $val['branchid'] = $this->Session->read('User.branch_id');
                        $val['departmentid'] = $this->Session->read('User.department_id');
                        $val['created_by'] = $this->Session->read('User.id');
                        $val['modified_by'] = $this->Session->read('User.id');
                        $val['system_table_id'] = $this->_get_system_table_id();
                        $this->NotificationUser->save($val, false);
                    }
                } else {
                    $this->loadModel('Notification');
                    $this->Notification->deleteAll(array('internal_audit_plan_id' => $this->InternalAuditPlan->id), false);
                }
                if ($this->request->data['InternalAuditPlan']['notify_users_emails']) {
                    try{
                        App::uses('CakeEmail', 'Network/Email');
                        if($this->Session->read('User.is_smtp') == '1')
                        {
                            $EmailConfig = new CakeEmail("smtp");	
                        }else if($this->Session->read('User.is_smtp') == '0'){
                            $EmailConfig = new CakeEmail("default");
                        }
                        $EmailConfig->subject('FlinkISO: Internal Audit Plan');
                        $internalAuditPlan = $this->InternalAuditPlan->find('first', array('conditions' => array('InternalAuditPlan.id' => $id, 'InternalAuditPlan.publish' => 1, 'InternalAuditPlan.soft_delete' => 0)));
                        $this->loadModel('Employee');
                        $this->Employee->recursive = -1;
                        $emails = array();
                        $k=0;
                        foreach ($auditDepartmentUsers as $employeeId) {
                            $auditorEmail = $this->Employee->find('first', array('conditions' => array('Employee.id' => $employeeId), 'fields' => array('Employee.office_email', 'Employee.name')));

                              if($k==0){
                                    $EmailConfig->to($auditorEmail['Employee']['office_email']);
                                }else{
                                    $emails[] = $auditorEmail['Employee']['office_email'];
                                }
                                $k++;
                        }
                        $EmailConfig->bcc($emails);
                        $EmailConfig->template('internalAuditPlan');
                        $EmailConfig->viewVars(array('internalAudit' => $internalAuditPlan));
                        $EmailConfig->emailFormat('html');
                        $EmailConfig->send();
                        $this->Session->setFlash('An email has been sent');
                        $this->redirect(array('controller' => 'internalAuditPlans', 'action' => 'index'));
                     } catch(Exception $e) {
                         $this->Session->setFlash(__('Can not notify user using email. Please check SMTP details and email address is correct.'));

                    }
                }
                if($this->_show_approvals()){
                if ($this->request->data['InternalAuditPlan']['publish'] == 0 && ($this->request->data['Approval']['user_id'] != -1 )) {
                    $this->loadModel('Approval');
                    $this->Approval->create();
                    $this->request->data['Approval']['model_name'] = 'InternalAuditPlan';
                    $this->request->data['Approval']['controller_name'] = $this->request->params['controller'];
                    $this->request->data['Approval']['from'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['user_id'] = $this->request->data['Approval']['user_id'];
                    $this->request->data['Approval']['created_by'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['modified_by'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['record'] = $this->InternalAuditPlan->id;
                    $this->Approval->save($this->request->data['Approval']);

                    $this->Session->setFlash(__('The internal audit plan has been saved'));
                } elseif ($this->request->data['InternalAuditPlan']['publish'] == 1) {
                        $this->Approval->read(null, $approvalId);
                        $data['Approval']['status'] = 'Approved';
                        $data['Approval']['modified_by'] = $this->Session->read('User.id');
                        $this->Approval->save($data);
                        $this->Session->setFlash(__('The internal audit plan has been published'));
                    }
                }
                $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
            } else {
                $this->Session->setFlash(__('The internal audit plan could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('InternalAuditPlan.' . $this->InternalAuditPlan->primaryKey => $id));
            $this->request->data = $this->InternalAuditPlan->find('first', $options);
        }
        $systemTables = $this->InternalAuditPlan->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $masterListOfFormats = $this->InternalAuditPlan->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0)));
        $count = $this->InternalAuditPlan->find('count');
        $published = $this->InternalAuditPlan->find('count', array('conditions' => array('InternalAuditPlan.publish' => 1)));
        $unpublished = $this->InternalAuditPlan->find('count', array('conditions' => array('InternalAuditPlan.publish' => 0)));
        $this->set(compact('count', 'published', 'unpublished', 'systemTables', 'masterListOfFormats'));
    }

    public function plan_add_ajax($planId = null) {

        if ($planId) {

            if (!$this->InternalAuditPlan->exists($planId)) {
                throw new NotFoundException(__('Invalid internal audit plan'));
            }
            $this->InternalAuditPlan->recursive = 0;
            $options = array('conditions' => array('InternalAuditPlan.' . $this->InternalAuditPlan->primaryKey => $planId));
            $this->set('internalAuditPlan', $this->InternalAuditPlan->find('first', $options));

            $this->loadModel('InternalAuditPlanDepartment');

            $branches = $this->_get_branch_list();
            foreach ($branches as $key => $value):

                $plan[$key] = $this->InternalAuditPlanDepartment->find('all', array('conditions' => array(
                        'InternalAuditPlanDepartment.soft_delete' => 0,
                        'InternalAuditPlanDepartment.branch_id' => $key,
                        'InternalAuditPlanDepartment.internal_audit_plan_id' => $planId
                )));

            endforeach;
            foreach ($plan as $key => $value):
                foreach ($value as $key1 => $department):
                    $ListOfTrainedInternalAuditor = $this->InternalAuditPlanDepartment->ListOfTrainedInternalAuditor->find('first', array('conditions' => array('ListOfTrainedInternalAuditor.id' => $department['InternalAuditPlanDepartment']['list_of_trained_internal_auditor_id']), 'fields' => 'Employee.name', 'recursive' => 0));
                    $plan[$key][$key1]['TrainedInternalAuditor'] = $ListOfTrainedInternalAuditor['Employee']['name'];
                endforeach;
            endforeach;
            $this->set(array('plan' => $plan));
        }


        if ($this->_show_approvals()) {
           $this->set(array('showApprovals' => $this->_show_approvals()));
        }

        if ($this->request->is('post')) {

            $this->request->data['InternalAuditPlan']['system_table_id'] = $this->_get_system_table_id();
            $this->InternalAuditPlan->create();
            $this->request->data['InternalAuditPlan']['note'] = htmlentities($this->request->data['InternalAuditPlan']['note']);

            if ($this->InternalAuditPlan->save($this->request->data['InternalAuditPlan'], false)) {

                if ($planId) {

                    //save internal audit branch
                    $this->loadModel('InternalAuditPlanBranch');
                    $this->InternalAuditPlanBranch->create();
                    $branchData['InternalAuditPlanBranch']['internal_audit_plan_id'] = $this->InternalAuditPlan->id;
                    $branchData['InternalAuditPlanBranch']['branch_id'] = $this->request->data['InternalAuditPlanDepartment']['branch_id'];
                    $branchData['InternalAuditPlanBranch']['publish'] = $this->request->data['InternalAuditPlan']['publish'];
                    $branchData['InternalAuditPlanBranch']['branchid'] = $this->request->data['InternalAuditPlan']['branchid'];
                    $branchData['InternalAuditPlanBranch']['departmentid'] = $this->request->data['InternalAuditPlan']['departmentid'];
                    $branchData['InternalAuditPlanBranch']['created_by'] = $this->Session->read('User.id');
                    $branchData['InternalAuditPlanBranch']['modified_by'] = $this->Session->read('User.id');
                    $branchData['InternalAuditPlanBranch']['system_table_id'] = $this->_get_system_table_id();
                    $this->InternalAuditPlanBranch->save($branchData['InternalAuditPlanBranch'], false);

                    //save internal audit departments
                    $this->loadModel('InternalAuditPlanDepartment');
                    foreach ($this->request->data['InternalAuditPlanDepartment_department_id'] as $val) {
                        $this->InternalAuditPlanDepartment->create();
                        $valData = array();
                        $valData['internal_audit_plan_id'] = $this->InternalAuditPlan->id;
                        $valData['department_id'] = $val;
                        $valData['publish'] = $this->request->data['InternalAuditPlan']['publish'];
                        $valData['branchid'] = $this->request->data['InternalAuditPlan']['branchid'];
                        $valData['departmentid'] = $this->request->data['InternalAuditPlan']['departmentid'];

                        $valData['created_by'] = $this->Session->read('User.id');
                        $valData['modified_by'] = $this->Session->read('User.id');
                        $valData['system_table_id'] = $this->_get_system_table_id();
                        $this->InternalAuditPlanDepartment->save($valData, false);
                    }
                }


                if ($this->_show_approvals()) {
                    if ((isset($this->request->data['Approval'])) && ($this->request->data['InternalAuditPlan']['publish'] == 0 ) && ($this->request->data['Approval']['user_id'] != -1)) {
                        $this->loadModel('Approval');
                        $this->Approval->create();
                        $this->request->data['Approval']['model_name'] = 'InternalAuditPlan';
                        $this->request->data['Approval']['controller_name'] = $this->request->params['controller'];
                        $this->request->data['Approval']['user_id'] = $this->request->data['Approval']['user_id'];
                        $this->request->data['Approval']['from'] = $this->Session->read('User.id');
                        $this->request->data['Approval']['record'] = $this->InternalAuditPlan->id;
                        $this->Approval->save($this->request->data['Approval']);
                    }
                }
                $this->Session->setFlash(__('The internal audit plan has been saved'));
                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->InternalAuditPlan->id));
                else
                    $this->redirect(array('action' => 'plan_add_ajax', $this->InternalAuditPlan->id));
            } else {
                $this->Session->setFlash(__('The internal audit plan could not be saved. Please, try again.'));
            }
        }
        $systemTables = $this->InternalAuditPlan->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $masterListOfFormats = $this->InternalAuditPlan->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0)));
        $listOfTrainedInternalAuditors = $this->InternalAuditPlan->ListOfTrainedInternalAuditor->find('list', array('fields' => array('ListOfTrainedInternalAuditor.id', 'Employee.name'), 'conditions' => array('ListOfTrainedInternalAuditor.publish' => 1, 'ListOfTrainedInternalAuditor.soft_delete' => 0), 'recursive' => 0));
        $this->set(compact('systemTables', 'masterListOfFormats', 'listOfTrainedInternalAuditors'));
    }

    public function get_dept_clauses($val) {
        $this->layout = "ajax";

        $this->loadModel('Department');
        $department = $this->Department->find('first', array('conditions' => array('Department.id' => $val), 'fields' => array('id', 'clauses')));
        echo $department['Department']['clauses'];
        exit;
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {

        if (!$this->InternalAuditPlan->exists($id)) {
            throw new NotFoundException(__('Invalid internal audit plan'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['InternalAuditPlan']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['InternalAuditPlan']['note'] = htmlentities($this->request->data['InternalAuditPlan']['note']);

            if ($this->InternalAuditPlan->save($this->request->data, false)) {



                //Edit internal audit on timeline
                if ($this->request->data['InternalAuditPlan']['show_on_timeline']) {
                    $this->loadModel('Timeline');
                    $this->Timeline->deleteAll(array('internal_audit_plan_id' => $this->InternalAuditPlan->id), false);
                    $this->Timeline->create();
                    $val = array();
                    $val['title'] = $this->request->data['InternalAuditPlan']['title'];
                    $val['message'] = htmlentities($this->request->data['InternalAuditPlan']['note']);
                    $val['start_date'] = $this->request->data['InternalAuditPlan']['schedule_date_from'];
                    $val['end_date'] = $this->request->data['InternalAuditPlan']['schedule_date_to'];
                    $val['internal_audit_plan_id'] = $this->InternalAuditPlan->id;
                    $val['prepared_by'] = $this->Session->read('User.id');
                    $val['approved_by'] = $this->Session->read('User.id');
                    $val['publish'] = $this->request->data['InternalAuditPlan']['publish'];
                    $val['branchid'] = $this->request->data['InternalAuditPlan']['branchid'];
                    $val['departmentid'] = $this->request->data['InternalAuditPlan']['departmentid'];
                    $val['modified_by'] = $this->Session->read('User.id');
                    $val['system_table_id'] = $this->_get_system_table_id();
                    $this->Timeline->save($val, false);
                } else {
                    $this->loadModel('Timeline');
                    $this->Timeline->deleteAll(array('internal_audit_plan_id' => $this->InternalAuditPlan->id), false);
                }
                if ($this->request->data['InternalAuditPlan']['notify_users']) {
                    //Edit internal audit plan on notification
                    $this->loadModel('Notification');
                    $notifications = $this->Notification->find('first', array('conditions' => array('internal_audit_plan_id' => $this->InternalAuditPlan->id)), false);
                    $notificationsId = $notifications['Notification']['id'];
                    $val = array();
                    $val['id'] = $notificationsId;
                    $val['title'] = $this->request->data['InternalAuditPlan']['title'];
                    $val['message'] = htmlentities($this->request->data['InternalAuditPlan']['note']);
                    $val['start_date'] = $this->request->data['InternalAuditPlan']['schedule_date_from'];
                    $val['end_date'] = $this->request->data['InternalAuditPlan']['schedule_date_to'];
                    $val['internal_audit_plan_id'] = $this->InternalAuditPlan->id;
                    $val['prepared_by'] = $this->Session->read('User.id');
                    $val['approved_by'] = $this->Session->read('User.id');
                    $val['publish'] = $this->request->data['InternalAuditPlan']['publish'];
                    $val['branchid'] = $this->request->data['InternalAuditPlan']['branchid'];
                    $val['departmentid'] = $this->request->data['InternalAuditPlan']['departmentid'];
                    $val['modified_by'] = $this->Session->read('User.id');
                    $val['system_table_id'] = $this->_get_system_table_id();
                    $this->Notification->save($val, false);
                } else {
                    $this->loadModel('Notification');
                    $this->Notification->deleteAll(array('internal_audit_plan_id' => $this->InternalAuditPlan->id), false);
                }
                if ($this->_show_approvals()) {
                    if ((isset($this->request->data['Approval'])) && ($this->request->data['InternalAuditPlan']['publish'] == 0 ) && ($this->request->data['Approval']['user_id'] != -1))
                    {
                        $this->loadModel('Approval');
                        $this->Approval->create();
                        $this->request->data['Approval']['model_name'] = 'InternalAuditPlan';
                        $this->request->data['Approval']['controller_name'] = $this->request->params['controller'];
                        $this->request->data['Approval']['from'] = $this->Session->read('User.id');
                        $this->request->data['Approval']['user_id'] = $this->request->data['Approval']['user_id'];
                        $this->request->data['Approval']['created_by'] = $this->Session->read('User.id');
                        $this->request->data['Approval']['modified_by'] = $this->Session->read('User.id');
                        $this->request->data['Approval']['record'] = $this->InternalAuditPlan->id;
                        $this->Approval->save($this->request->data['Approval']);
                    }
                }
                $this->Session->setFlash(__('The internal audit plan has been saved'));
                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The internal audit plan could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('InternalAuditPlan.' . $this->InternalAuditPlan->primaryKey => $id));
            $this->request->data = $this->InternalAuditPlan->find('first', $options);
        }
        $systemTables = $this->InternalAuditPlan->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $masterListOfFormats = $this->InternalAuditPlan->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0)));
        $count = $this->InternalAuditPlan->find('count');
        $published = $this->InternalAuditPlan->find('count', array('conditions' => array('InternalAuditPlan.publish' => 1)));
        $unpublished = $this->InternalAuditPlan->find('count', array('conditions' => array('InternalAuditPlan.publish' => 0)));

        $this->set(compact('count', 'published', 'unpublished', 'systemTables', 'masterListOfFormats'));
    }

    public function add_branches() {

        $this->set('branches', $this->InternalAuditPlan->InternalAuditPlanBranch->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0))));
        $this->set('employees', $this->InternalAuditPlan->InternalAuditPlanBranch->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0))));
        $listOfTrainedInternalAuditors = $this->InternalAuditPlan->ListOfTrainedInternalAuditor->find("list", array(
            "joins" => array(
                array(
                    "table" => "employees",
                    "alias" => "Employees",
                    "type" => "LEFT",
                    "conditions" => array(
                        "ListOfTrainedInternalAuditor.employee_id = Employees.id"
                    )
                )
            ), 'fields' => array('ListOfTrainedInternalAuditor.id', 'Employees.name'),
            'conditions' => array(
                'ListOfTrainedInternalAuditor.publish' => 1, 'ListOfTrainedInternalAuditor.soft_delete' => 0
            )
        ));
        $this->set('listOfTrainedInternalAuditors', $listOfTrainedInternalAuditors);

        $this->render('add_branches');
    }

    public function add_departments($i = null) {

        $this->set('branches', $this->InternalAuditPlan->InternalAuditPlanBranch->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0))));
        $this->set('employees', $this->InternalAuditPlan->InternalAuditPlanBranch->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0))));
        $this->set('departments', $this->InternalAuditPlan->InternalAuditPlanDepartment->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0))));
        $listOfTrainedInternalAuditors = $this->InternalAuditPlan->ListOfTrainedInternalAuditor->find("list", array(
            "joins" => array(
                array(
                    "table" => "employees",
                    "alias" => "Employees",
                    "type" => "LEFT",
                    "conditions" => array(
                        "ListOfTrainedInternalAuditor.employee_id = Employees.id"
                    )
                )
            ), 'fields' => array('ListOfTrainedInternalAuditor.id', 'Employees.name'),
            'conditions' => array('ListOfTrainedInternalAuditor.publish' => 1, 'ListOfTrainedInternalAuditor.soft_delete' => 0
            )
        ));
        $this->set('listOfTrainedInternalAuditors', $listOfTrainedInternalAuditors);
        $this->set('i', $i);
        $this->render('add_departments');
    }

}
