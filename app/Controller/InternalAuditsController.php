<?php

App::uses('AppController', 'Controller');

/**
 * InternalAudits Controller
 *
 * @property InternalAudit $InternalAudit
 */
class InternalAuditsController extends AppController {

    public function _get_system_table_id() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $this->request->params['controller'])));
        return $systemTableId['SystemTable']['id'];
    }


    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->InternalAudit->exists($id)) {
            throw new NotFoundException(__('Invalid internal audit'));
        }
        $options = array('conditions' => array('InternalAudit.' . $this->InternalAudit->primaryKey => $id));
        $this->set('internalAudit', $this->InternalAudit->find('first', $options));
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
     * add_ajax method
     *
     * @return void
     */
    public function add_ajax($planId = null) {
        if ($planId) {
            $this->loadModel('FileUpload');
            $this->FileUpload->recursive = 0;

            $branches = $this->_get_branch_list();
            foreach ($branches as $key => $value):
                $getInternalAudits = $this->InternalAudit->find('all', array('conditions' => array('InternalAudit.branch_id' => $key, 'InternalAudit.internal_audit_plan_id' => $planId, 'InternalAudit.soft_delete' => 0)));
                $i = 0;
                foreach ($getInternalAudits as $audits):
                    $files = $this->FileUpload->find('all', array('conditions' => array('FileUpload.record' => $audits['InternalAudit']['id'])));
                    $internalAudits[$key][$i] = $audits;
                    $internalAudits[$key][$i]['Files'] = $files;
                    $internalAudits[$key][$i]['FileCount'] = count($files);
                    $i++;
                endforeach;
            endforeach;

            $this->set(compact('internalAudits'));

            $this->loadModel('InternalAuditPlan');
            if (!$this->InternalAuditPlan->exists($planId)) {
                throw new NotFoundException(__('Invalid internal audit plan'));
            }
            $this->InternalAuditPlan->recursive = 0;
            $options = array('conditions' => array('InternalAuditPlan.' . $this->InternalAuditPlan->primaryKey => $planId));
            $this->set('internalAuditPlan', $this->InternalAuditPlan->find('first', $options));

            if (!$this->InternalAuditPlan->exists($planId)) {
                throw new NotFoundException(__('Invalid internal audit plan'));
            }

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
            $this->request->data['InternalAudit']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['InternalAudit']['created_by'] = $this->Session->read('User.id');
            $this->request->data['InternalAudit']['modified_by'] = $this->Session->read('User.id');

            $this->InternalAudit->create();
            if ($this->InternalAudit->save($this->request->data, false)) {

                $this->Session->setFlash(__('The internal audit has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->InternalAudit->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The internal audit could not be saved. Please, try again.'));
            }
        }

        $internalAuditPlans = $this->InternalAudit->InternalAuditPlan->find('list', array('conditions' => array('InternalAuditPlan.publish' => 1, 'InternalAuditPlan.soft_delete' => 0)));
        $this->loadModel('ListOfTrainedInternalAuditor');
        $listOfTrainedInternalAuditors = $this->ListOfTrainedInternalAuditor->find('list', array('fields' => array('ListOfTrainedInternalAuditor.id', 'Employee.name'), 'conditions' => array('ListOfTrainedInternalAuditor.publish' => 1, 'ListOfTrainedInternalAuditor.soft_delete' => 0), 'recursive' => 0));
        $this->loadModel('CapaSource');
        $capaSources = $this->CapaSource->find('list', array('conditions' => array('CapaSource.publish' => 1, 'CapaSource.soft_delete' => 0)));

        $this->set(compact('internalAuditPlans', 'listOfTrainedInternalAuditors', 'capaSources'));
    }

     public function get_ncs($i = 0) {
        $condition1 = null;
        $condition2 = null;
        $condition = $this->_check_request();
        if ($i == 0)
            $condition1 = array('InternalAudit.non_conformity_found' => 1);

        if ($i == 1)
            $condition2 = array('InternalAudit.non_conformity_found' => 1,'CorrectivePreventiveAction.current_status' => 1);
        $conditions = array($condition, $condition1, $condition2);
        $this->paginate = array('order' => array('InternalAudit.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->InternalAudit->recursive = 0;
        $internalAudits = $this->paginate();
        $this->loadModel('CapaSource');
        foreach ($internalAudits as $key => $internalAudit) {
            if ($internalAudit['InternalAudit']['corrective_preventive_action_id']) {
                $capaSource = $this->CapaSource->find('first', array('conditions' => array('CapaSource.id' => $internalAudit['CorrectivePreventiveAction']['capa_source_id']), 'fields' => 'CapaSource.name'));
                $internalAudits[$key]['InternalAudit']['capa_source_name'] = $capaSource['CapaSource']['name'];
            }
        }
        $this->set('internalAudits', $internalAudits);
        $this->_get_count();
    }


    /**
     * add_ajax method
     *
     * @return void
     */
    public function audit_details_add_ajax($planId = null) {

        if ($planId) {

            $internalAudits = $this->InternalAudit->find('all');
            $this->set(compact('internalAudits'));
        }

        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }

        if ($this->request->is('post')) {
            $this->request->data['InternalAudit']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['InternalAudit']['created_by'] = $this->Session->read('User.id');
            $this->request->data['InternalAudit']['modified_by'] = $this->Session->read('User.id');
            $this->request->data['InternalAudit']['list_of_trained_internal_auditor'] = $this->request->data['InternalAudit']['list_of_trained_internal_auditor_id'];
            $this->request->data['InternalAudit']['publish'] = 1;
            $this->InternalAudit->create();
            if ($this->InternalAudit->save($this->request->data, false)) {

                if ($this->request->data['InternalAudit']['non_conformity_found']) {
                    $this->loadModel('CorrectivePreventiveAction');
                    $this->CorrectivePreventiveAction->create();
                    $capa['number'] = '';
                    $capa['capa_category_id'] = '5245a8fc-8f4c-4ab5-ab27-41f2c6c3268c';
                    $capa['internal_audit_id'] = $this->InternalAudit->id;
                    $capa['capa_source_id'] = $this->request->data['InternalAudit']['capa_source_id'];
                    $capa['raised_by'] = json_encode(array('Soruce' => 'Internal Audits', 'id' => $this->InternalAudit->id));
                    $capa['assigned_to'] = $this->request->data['InternalAudit']['assignedTo'];
                    $capa['target_date'] = $this->request->data['InternalAudit']['target_date'];
                    $capa['initial_remarks'] = $this->request->data['InternalAudit']['finding'];
                    $capa['priority'] = $this->request->data['InternalAudit']['priority'];
                    $capa['current_status'] = $this->request->data['InternalAudit']['current_status'];
                    $capa['publish'] = 1;
                    $this->CorrectivePreventiveAction->save($capa, false);

                    $val['id'] = $this->InternalAudit->id;
                    $var['corrective_preventive_action_id'] = $this->CorrectivePreventiveAction->id;
                    $this->InternalAudit->save($var, false);
                }

                $this->Session->setFlash(__('The internal audit has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->InternalAudit->id));
                else
                    $this->redirect(array('action' => 'add_ajax', $planId));
            } else {
                $this->Session->setFlash(__('The internal audit could not be saved. Please, try again.'));
            }
        }
    }

    public function edit_popup($id = null) {
        if (!$this->InternalAudit->exists($id)) {
            throw new NotFoundException(__('Invalid internal audit'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['InternalAudit']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['InternalAudit']['modified_by'] = $this->Session->read('User.id');
            if ($this->request->data['InternalAudit']['non_conformity_found']) {
                $capa = array();
                $this->loadModel('CorrectivePreventiveAction');
                $checkCapa = $this->CorrectivePreventiveAction->find('count', array('conditions' => array('CorrectivePreventiveAction.id' => $this->request->data['InternalAudit']['corrective_preventive_action_id'])));
                if ($checkCapa != 0) {
                    $capa['id'] = $this->request->data['InternalAudit']['corrective_preventive_action_id'];
                } else {
                    $this->CorrectivePreventiveAction->create();
                }
                $capa['number'] = '';
                $capa['capa_category_id'] = '5245a8fc-8f4c-4ab5-ab27-41f2c6c3268c';
                $capa['capa_source_id'] = $this->request->data['InternalAudit']['capa_source_id'];
                $capa['raised_by'] = json_encode(array('Soruce' => 'Internal Audits', 'id' => $this->InternalAudit->id));
                $capa['assigned_to'] = $this->request->data['InternalAudit']['assignedTo'];
                $capa['target_date'] = $this->request->data['InternalAudit']['target_date'];
                $capa['initial_remarks'] = $this->request->data['InternalAudit']['finding'];
                $capa['priority'] = $this->request->data['InternalAudit']['priority'];
                $capa['current_status'] = $this->request->data['InternalAudit']['current_status'];
                $capa['publish'] = 1;
                $this->CorrectivePreventiveAction->save($capa, false);

                $this->request->data['InternalAudit']['corrective_preventive_action_id'] = $this->CorrectivePreventiveAction->id;
            } else {
                $existingCapa = $this->InternalAudit->find('first', array('conditions' => array('InternalAudit.id' => $id), 'fields' => 'InternalAudit.corrective_preventive_action_id', 'recursive' => -1));
                $this->loadModel('CorrectivePreventiveAction');
                $this->CorrectivePreventiveAction->delete($existingCapa['InternalAudit']['corrective_preventive_action_id']);
                $this->request->data['InternalAudit']['corrective_preventive_action_id'] = '';
                $this->request->data['InternalAudit']['current_status'] = '';
            }

            if ($this->InternalAudit->save($this->request->data, false)) {
                $this->Session->setFlash(__('The internal audit has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'lists', $this->request->data['InternalAudit']['internal_audit_plan_id']));
            } else {
                $this->Session->setFlash(__('The internal audit could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('InternalAudit.' . $this->InternalAudit->primaryKey => $id));
            $this->request->data = $this->InternalAudit->find('first', $options);
        }
        $internalAuditPlans = $this->InternalAudit->InternalAuditPlan->find('list', array('conditions' => array('InternalAuditPlan.publish' => 1, 'InternalAuditPlan.soft_delete' => 0)));
        $listOfTrainedInternalAuditors = $this->InternalAudit->ListOfTrainedInternalAuditor->find('list', array('fields' => array('ListOfTrainedInternalAuditor.id', 'Employee.name'), 'conditions' => array('ListOfTrainedInternalAuditor.publish' => 1, 'ListOfTrainedInternalAuditor.soft_delete' => 0), 'recursive' => 0));
        $this->loadModel('CapaSource');
        $this->request->data['InternalAudit']['capa_source_id'] = $this->request->data['CorrectivePreventiveAction']['capa_source_id'];
        $this->request->data['InternalAudit']['priority'] = $this->request->data['CorrectivePreventiveAction']['priority'];
        $capaSources = $this->CapaSource->find('list', array('conditions' => array('CapaSource.publish' => 1, 'CapaSource.soft_delete' => 0)));

        $this->set(compact('internalAuditPlans', 'listOfTrainedInternalAuditors', 'capaSources'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->InternalAudit->exists($id)) {
            throw new NotFoundException(__('Invalid internal audit'));
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
            $this->request->data['InternalAudit']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['InternalAudit']['modified_by'] = $this->Session->read('User.id');
            if ($this->InternalAudit->save($this->request->data, false)) {
                if ($this->request->data['InternalAudit']['non_conformity_found']) {
                    $this->loadModel('CorrectivePreventiveAction');
                    if (!$this->request->data['InternalAudit']['corrective_preventive_action_id'])
                        $this->CorrectivePreventiveAction->create();
                    $capa['number'] = '';
                    $capa['internal_audit_id'] = $this->InternalAudit->id;
                    $capa['capa_category_id'] = '5245a8fc-8f4c-4ab5-ab27-41f2c6c3268c';
                    $capa['capa_source_id'] = $this->request->data['InternalAudit']['capa_source_id'];
                    $capa['raised_by'] = json_encode(array('Soruce' => 'Internal Audits', 'id' => $this->InternalAudit->id));
                    $capa['assigned_to'] = $this->request->data['InternalAudit']['employeeId'];
                    $capa['target_date'] = $this->request->data['InternalAudit']['target_date'];
                    $capa['initial_remarks'] = $this->request->data['InternalAudit']['finding'];
                    $capa['priority'] = $this->request->data['InternalAudit']['priority'];
                    $capa['publish'] = 1;
                    $this->CorrectivePreventiveAction->save($capa);

                    $val['id'] = $this->InternalAudit->id;
                    $var['corrective_preventive_action_id'] = $this->CorrectivePreventiveAction->id;
                    $this->InternalAudit->save($var, false);
                }

                $this->Session->setFlash(__('The internal audit has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The internal audit could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('InternalAudit.' . $this->InternalAudit->primaryKey => $id));
            $this->request->data = $this->InternalAudit->find('first', $options);
        }
        $internalAuditPlans = $this->InternalAudit->InternalAuditPlan->find('list', array('conditions' => array('InternalAuditPlan.publish' => 1, 'InternalAuditPlan.soft_delete' => 0)));
        $listOfTrainedInternalAuditors = $this->InternalAudit->ListOfTrainedInternalAuditor->find('list', array('fields' => array('ListOfTrainedInternalAuditor.id', 'Employee.name'), 'conditions' => array('ListOfTrainedInternalAuditor.publish' => 1, 'ListOfTrainedInternalAuditor.soft_delete' => 0), 'recursive' => 0));
        $this->set(compact('internalAuditPlans', 'listOfTrainedInternalAuditors'));
    }


    public function send_email($id = null) {
        try{
            App::uses('CakeEmail', 'Network/Email');
                        if($this->Session->read('User.is_smtp') == '1')
                        {
                            $EmailConfig = new CakeEmail("smtp");	
                        }else if($this->Session->read('User.is_smtp') == '0'){
                            $EmailConfig = new CakeEmail("default");
                        }
            $EmailConfig->subject('FlinkISO: Internal Audit');
            $internalAudit = $this->InternalAudit->find('first', array('conditions' => array('InternalAudit.id' => $id, 'InternalAudit.publish' => 1, 'InternalAudit.soft_delete' => 0)));
            $this->loadModel('Employee');
            $this->Employee->recursive = -1;
            $emails = array();
            $auditorEmail = $this->Employee->find('first', array('conditions' => array('Employee.id' => $internalAudit['ListOfTrainedInternalAuditor']['employee_id']), 'fields' => array('Employee.office_email', 'Employee.name')));
            $EmailConfig->to($auditorEmail['Employee']['office_email']);
            $internalAudit['InternalAudit']['auditorName'] = $auditorEmail['Employee']['name'];
            $auditeeEmail = $this->Employee->find('first', array('conditions' => array('Employee.id' => $internalAudit['InternalAudit']['employee_id']), 'fields' => 'office_email'));
            if(!empty($auditeeEmail))
                $emails[] = $auditeeEmail['Employee']['office_email'];
            $moderatorEmail = $this->Employee->find('first', array('conditions' => array('Employee.id' => $internalAudit['InternalAudit']['employeeId']), 'fields' => 'office_email'));
            if(!empty($moderatorEmail))
                $emails[] = $moderatorEmail['Employee']['office_email'];
            $EmailConfig->bcc($emails);
            $EmailConfig->template('internalAudit');
            $EmailConfig->viewVars(array('internalAudit' => $internalAudit));
            $EmailConfig->emailFormat('html');
            $EmailConfig->send();
            $this->Session->setFlash('An email has been sent');
            $this->redirect(array('controller' => 'internalAuditPlans', 'action' => 'index'));
         } catch(Exception $e) {
            $this->Session->setFlash(__('Can not notify user using email. Please check SMTP details and email address are correct or not: '.$e->getMessage()));
            $this->redirect(array('controller' => 'internalAuditPlans', 'action' => 'index'));
            exit();
         }
         exit();
    }

    public function audit_report($planId = null) {

        if ($planId) {
            $this->loadModel('FileUpload');
            $this->FileUpload->recursive = 0;

            $branches = $this->_get_branch_list();
            foreach ($branches as $key => $value):
                $getInternalAudits = $this->InternalAudit->find('all', array('conditions' => array('InternalAudit.branch_id' => $key, 'InternalAudit.internal_audit_plan_id' => $planId, 'InternalAudit.soft_delete' => 0)));
                $i = 0;
                foreach ($getInternalAudits as $audits):
                    $files = $this->FileUpload->find('all', array('conditions' => array('FileUpload.record' => $audits['InternalAudit']['id'])));
                    $internalAudits[$value][$i] = $audits;
                    $internalAudits[$value][$i]['Files'] = $files;
                    $internalAudits[$value][$i]['FileCount'] = count($files);
                    $i++;
                endforeach;
                $auditCount = $auditCount + count($getInternalAudits);
            endforeach;
            $internalAudits['audit_counts'] = $auditCount;

            $this->set(compact('internalAudits'));
            $this->loadModel('InternalAuditPlan');
            if (!$this->InternalAuditPlan->exists($planId)) {
                throw new NotFoundException(__('Invalid internal audit plan'));
            }

            $this->InternalAuditPlan->recursive = 0;
            $options = array('conditions' => array('InternalAuditPlan.' . $this->InternalAuditPlan->primaryKey => $planId));
            $this->set('internalAuditPlan', $this->InternalAuditPlan->find('first', $options));

            if (!$this->InternalAuditPlan->exists($planId)) {
                throw new NotFoundException(__('Invalid internal audit plan'));
            }
        }
    }

    public function get_questions($id = null) {
        $this->layout = "ajax";
        $this->loadModel('InternalAuditQuestion');
        $internalAuditQuestions = $this->InternalAuditQuestion->find('all', array('conditions' => array('InternalAuditQuestion.department_id' => $id, 'InternalAuditQuestion.publish' => 1, 'InternalAuditQuestion.soft_delete' => 0)));
        $this->set(compact('internalAuditQuestions'));
    }
     public function get_dept_clauses($val) {
        $this->layout = "ajax";

        $this->loadModel('Department');
        $c = $this->Department->find('first', array('conditions' => array('Department.id' => $val), 'fields' => array('id', 'clauses')));
        echo $c['Department']['clauses'];
        exit;
    }

    public function internal_audit_uploads($record_id, $created_by){
        $this->layout = "ajax";
        $this->set(compact('record_id',  'created_by'));
    }
}
