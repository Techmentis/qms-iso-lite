<?php

App::uses('AppController', 'Controller');

/**
 * Appraisals Controller
 *
 * @property Appraisal $Appraisal
 */
class AppraisalsController extends AppController {

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
        $this->paginate = array('order' => array('Appraisal.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->Appraisal->recursive = 0;
        $this->set('appraisals', $this->paginate());

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
            if ($this->requset->query['strict_search'] == 0) {
                $searchKeys[] = $this->request->query['keywords'];
            } else {
                $searchKeys = explode(" ", $this->request->query['keywords']);
            }
            foreach ($searchKeys as $searchKey):
                foreach ($this->request->query['search_fields'] as $search):
                    if ($this->request->query['strict_search'] == 0)
                        $searchArray[] = array('Appraisal.' . $search => $searchKey);
                    else
                        $searchArray[] = array('Appraisal.' . $search . ' like ' => '%' . $searchKey . '%');
                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $searchArray);
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('Appraisal.branch_id' => $branches);
            endforeach;
            $conditions[] = array('or' => $branchConditions);
        }

        if ($this->request->query['employee_id'] != -1) {
            $employeeConditions[] = array('Appraisal.employee_id' => $this->request->query['employee_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $employeeConditions);
            else
                $conditions[] = array('or' => $employeeConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('Appraisal.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'Appraisal.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }

        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);

        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('Appraisal.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Appraisal.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->Appraisal->recursive = 0;
        $this->paginate = array('order' => array('Appraisal.sr_no' => 'DESC'), 'conditions' => $conditions, 'Appraisal.soft_delete' => 0);
        $this->set('appraisals', $this->paginate());

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
        if (!$this->Appraisal->exists($id)) {
            throw new NotFoundException(__('Invalid appraisal'));
        }
        $questions = array();
        $i = 0;
        $this->loadModel('EmployeeAppraisalQuestion');
        $this->loadModel('AppraisalQuestion');
        $this->loadModel('EmployeeKra');
        $options = array('conditions' => array('Appraisal.' . $this->Appraisal->primaryKey => $id));
        $questions = $this->AppraisalQuestion->find('list', array('fields' => 'question'));
        $appraisal = $this->Appraisal->find('first', $options);
        $kras = $this->EmployeeKra->find('all', array('conditions' => array('EmployeeKra.employee_id' => $appraisal['Appraisal']['employee_id'])));
        $PublishedDesignationList = $this->_get_designation_list();

        $this->set(compact('appraisal', 'questions', 'kras', 'PublishedDesignationList'));
    }

    /**
     * list method
     *
     * @return void
     */
    public function lists() {

        $this->_get_count();
    }

    public function add_questions($i = null) {
        $this->set('i', $i);
        $this->render('add_questions');
    }

    /**
     * add_ajax method
     *
     * @return void
     */
    public function add_ajax() {

        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }

        if ($this->request->is('post')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['Appraisal']['system_table_id'] = $this->_get_system_table_id();

            $this->Appraisal->create();
            if ($this->Appraisal->save($this->request->data, false)) {
                $this->Session->setFlash(__('The appraisal has been saved'));

                if (count($this->request->data['Appraisal']['appraisal_question_id']) > 0) {
                    
                    $this->loadModel('EmployeeAppraisalQuestion');
                    $this->loadModel('AppraisalQuestion');
                    if (isset($this->request->data['AppraisalQuestion']))
                        foreach ($this->request->data['AppraisalQuestion'] as $val) {
                            $data = array();
                            $this->AppraisalQuestion->create();
                            $data['AppraisalQuestion']['system_table_id'] = $this->_get_system_table_id();
                            $data['AppraisalQuestion']['question'] = $val['question'];
                            $data['AppraisalQuestion']['publish'] = 1;
                            $this->AppraisalQuestion->save($data, false);
                            $this->EmployeeAppraisalQuestion->create();
                            $data['EmployeeAppraisalQuestion']['system_table_id'] = $this->_get_system_table_id();
                            $data['EmployeeAppraisalQuestion']['appraisal_id'] = $this->Appraisal->id;
                            $data['EmployeeAppraisalQuestion']['appraisal_question_id'] = $this->AppraisalQuestion->id;
                            $data['EmployeeAppraisalQuestion']['publish'] = 1;
                            $this->EmployeeAppraisalQuestion->save($data, false);
                        }
                    foreach ($this->request->data['Appraisal']['appraisal_question_id'] as $val) {
                        $data = array();
                        $this->EmployeeAppraisalQuestion->create();
                        $data['EmployeeAppraisalQuestion']['system_table_id'] = $this->_get_system_table_id();
                        $data['EmployeeAppraisalQuestion']['appraisal_id'] = $this->Appraisal->id;
                        $data['EmployeeAppraisalQuestion']['appraisal_question_id'] = $val;
                        $data['EmployeeAppraisalQuestion']['publish'] = 1;

                        $this->EmployeeAppraisalQuestion->save($data, false);
                    }

                    $this->loadModel('User');
                    $this->request->data['Appraisal']['appraisal_token'] = $this->User->generateToken();
                    $this->request->data['Appraisal']['appraisal_token_expires'] = date('Y-m-d H:i:s', strtotime($this->request->data['Appraisal']['appraisal_date'] . '+ 1 day'));
                    $this->request->data['Appraisal']['id'] = $this->Appraisal->id;

                    if ($this->Appraisal->save($this->request->data, false)) {
                        if ($this->request->data['Appraisal']['self_appraisal_needed'] == 1 && ($this->request->data['Appraisal']['appraisal_question_id'] != '') && isset($this->request->data['Appraisal']['publish']) && $this->request->data['Appraisal']['publish'] == 1) {
                            $this->appraisal_notification_email($this->request->data['Appraisal']['employee_id'], $this->request->data['Appraisal']['appraisal_token']);
                        }
                    }
                }

                $this->Session->setFlash(__('The appraisal has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->Appraisal->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The appraisal could not be saved. Please, try again.'));
            }
        }
        $this->loadModel('AppraisalQuestion');
        $appraisalQuestions = $this->AppraisalQuestion->find('list', array('conditions' => array('AppraisalQuestion.publish' => 1, 'AppraisalQuestion.soft_delete' => 0), 'fields' => 'question', 'recursive' => -1));
        $this->set(compact('appraisalQuestions'));
    }

    /**
     *  *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Appraisal->exists($id)) {
            throw new NotFoundException(__('Invalid appraisal'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }

        $this->loadModel('EmployeeAppraisalQuestion');
        $this->loadModel('AppraisalQuestion');
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['Appraisal']['system_table_id'] = $this->_get_system_table_id();
            $currentAppraisalDetails = $this->Appraisal->find('first', array('conditions' => array('Appraisal.id' => $id), 'fields' => array('Appraisal.employee_id', 'Appraisal.appraisal_token')));

            if ($this->request->data['Appraisal']['self_appraisal_needed'] == 1) {
                if ($currentAppraisalDetails['Appraisal']['appraisal_token'] == NULL) {
                    $this->loadModel('User');
                    $this->request->data['Appraisal']['appraisal_token'] = $this->User->generateToken();
                }
                $this->request->data['Appraisal']['appraisal_token_expires'] = date('Y-m-d H:i:s', strtotime($this->request->data['Appraisal']['appraisal_date'] . '+ 1 day'));
            } else {
                $this->request->data['Appraisal']['appraisal_token'] = NULL;
            }

            if ($this->Appraisal->save($this->request->data, false)) {

                $selectedQuestions = $this->EmployeeAppraisalQuestion->find('all', array('conditions' => array('EmployeeAppraisalQuestion.publish' => 1, 'EmployeeAppraisalQuestion.soft_delete' => 0), 'recursive' => -1, 'EmployeeAppraisalQuestion.appraisal_id' => $id));
                foreach ($selectedQuestions as $selectedQuestion) {
                    $this->EmployeeAppraisalQuestion->delete($selectedQuestion['EmployeeAppraisalQuestion']['id']);
                }
                if (isset($this->request->data['AppraisalQuestion']))
                    foreach ($this->request->data['AppraisalQuestion'] as $val) {
                        $data = array();
                        $this->AppraisalQuestion->create();
                        $data['AppraisalQuestion']['system_table_id'] = $this->_get_system_table_id();
                        $data['AppraisalQuestion']['question'] = $val['question'];
                        $data['AppraisalQuestion']['publish'] = 1;
                        $this->AppraisalQuestion->save($data, false);

                        $this->EmployeeAppraisalQuestion->create();
                        $data['EmployeeAppraisalQuestion']['system_table_id'] = $this->_get_system_table_id();
                        $data['EmployeeAppraisalQuestion']['appraisal_id'] = $this->Appraisal->id;
                        $data['EmployeeAppraisalQuestion']['appraisal_question_id'] = $this->AppraisalQuestion->id;
                        $data['EmployeeAppraisalQuestion']['publish'] = 1;
                        $this->EmployeeAppraisalQuestion->save($data, false);
                    }
                foreach ($this->request->data['Appraisal']['appraisal_question_id'] as $val) {
                    $data = array();
                    $this->EmployeeAppraisalQuestion->create();
                    $this->request->data['EmployeeAppraisalQuestion']['system_table_id'] = $this->_get_system_table_id();
                    $this->request->data['EmployeeAppraisalQuestion']['appraisal_id'] = $this->Appraisal->id;
                    $this->request->data['EmployeeAppraisalQuestion']['appraisal_question_id'] = $val;
                    $this->request->data['EmployeeAppraisalQuestion']['publish'] = 1;
                    $this->EmployeeAppraisalQuestion->save($this->request->data, false);
                }

                if ($this->request->data['Appraisal']['self_appraisal_needed'] == 1 && ($this->request->data['Appraisal']['appraisal_question_id'] != '') && isset($this->request->data['Appraisal']['publish']) && $this->request->data['Appraisal']['publish'] == 1) {
		    $this->appraisal_notification_email($currentAppraisalDetails['Appraisal']['employee_id'], $currentAppraisalDetails['Appraisal']['appraisal_token']);
                }

                $this->Session->setFlash(__('The appraisal has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The appraisal could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Appraisal.' . $this->Appraisal->primaryKey => $id));
            $this->request->data = $this->Appraisal->find('first', $options);
        }
        $appraisalQuestions = $this->AppraisalQuestion->find('list', array('conditions' => array('AppraisalQuestion.publish' => 1, 'AppraisalQuestion.soft_delete' => 0), 'fields' => 'question', 'recursive' => -1));
        $selectedAppraisalQuestions = $this->EmployeeAppraisalQuestion->find('list', array('conditions' => array('EmployeeAppraisalQuestion.publish' => 1, 'EmployeeAppraisalQuestion.soft_delete' => 0), 'fields' => 'appraisal_question_id', 'recursive' => -1, 'EmployeeAppraisalQuestion.appraisal_id' => $id));
        $this->set(compact('appraisalQuestions', 'selectedAppraisalQuestions'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->Appraisal->exists($id)) {
            throw new NotFoundException(__('Invalid appraisal'));
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

        $this->loadModel('EmployeeAppraisalQuestion');
        $this->loadModel('AppraisalQuestion');

        if ($this->request->is('post') || $this->request->is('put')) {
            if(!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1){
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['Appraisal']['system_table_id'] = $this->_get_system_table_id();
            $curAppraisalDetails = $this->Appraisal->find('first', array('conditions' => array('Appraisal.id' => $id), 'fields' => array('Appraisal.employee_id', 'Appraisal.appraisal_token')));

            if ($this->request->data['Appraisal']['self_appraisal_needed'] == 1) {
                if ($curAppraisalDetails['Appraisal']['appraisal_token'] == NULL) {
                    $this->loadModel('User');
                    $this->request->data['Appraisal']['appraisal_token'] = $this->User->generateToken();
                }
                $this->request->data['Appraisal']['appraisal_token_expires'] = date('Y-m-d H:i:s', strtotime($this->request->data['Appraisal']['appraisal_date'] . '+ 1 day'));
            } else {
                $this->request->data['Appraisal']['appraisal_token'] = NULL;
            }

            if ($this->Appraisal->save($this->request->data, false)) {

                $selectedQuestions = $this->EmployeeAppraisalQuestion->find('all', array('conditions' => array('EmployeeAppraisalQuestion.publish' => 1, 'EmployeeAppraisalQuestion.soft_delete' => 0), 'recursive' => -1, 'EmployeeAppraisalQuestion.appraisal_id' => $id));
                foreach ($selectedQuestions as $selectedQuestion) {
                    $this->EmployeeAppraisalQuestion->delete($selectedQuestion['EmployeeAppraisalQuestion']['id']);
                }
                
                foreach ($this->request->data['AppraisalQuestion'] as $val) {
                    $data = array();
                    $this->AppraisalQuestion->create();
                    $data['AppraisalQuestion']['system_table_id'] = $this->_get_system_table_id();
                    $data['AppraisalQuestion']['question'] = $val['question'];
                    $data['AppraisalQuestion']['publish'] = 1;
                    $this->AppraisalQuestion->save($data, false);

                    $this->EmployeeAppraisalQuestion->create();
                    $data['EmployeeAppraisalQuestion']['system_table_id'] = $this->_get_system_table_id();
                    $data['EmployeeAppraisalQuestion']['appraisal_id'] = $this->Appraisal->id;
                    $data['EmployeeAppraisalQuestion']['appraisal_question_id'] = $this->AppraisalQuestion->id;
                    $data['EmployeeAppraisalQuestion']['publish'] = 1;
                    $this->EmployeeAppraisalQuestion->save($data, false);
                }
                foreach ($this->request->data['Appraisal']['appraisal_question_id'] as $val) {
                    $data = array();
                    $this->EmployeeAppraisalQuestion->create();
                    $this->request->data['EmployeeAppraisalQuestion']['system_table_id'] = $this->_get_system_table_id();
                    $this->request->data['EmployeeAppraisalQuestion']['appraisal_id'] = $this->Appraisal->id;
                    $this->request->data['EmployeeAppraisalQuestion']['appraisal_question_id'] = $val;
                    $this->request->data['EmployeeAppraisalQuestion']['publish'] = 1;
                    $this->EmployeeAppraisalQuestion->save($this->request->data);
                }

                if ($this->request->data['Appraisal']['self_appraisal_needed'] == 1 && ($this->request->data['Appraisal']['appraisal_question_id'] != '') && isset($this->request->data['Appraisal']['publish']) && $this->request->data['Appraisal']['publish'] == 1) {
                    $this->appraisal_notification_email($curAppraisalDetails['Appraisal']['employee_id'], $curAppraisalDetails['Appraisal']['appraisal_token']);
                }

                $this->Session->setFlash(__('The appraisal has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals();

            } else {
                $this->Session->setFlash(__('The appraisal could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Appraisal.' . $this->Appraisal->primaryKey => $id));
            $this->request->data = $this->Appraisal->find('first', $options);
        }
        $appraisalQuestions = $this->AppraisalQuestion->find('list', array('conditions' => array('AppraisalQuestion.publish' => 1, 'AppraisalQuestion.soft_delete' => 0), 'fields' => 'question', 'recursive' => -1));
        $selectedAppraisalQuestions = $this->EmployeeAppraisalQuestion->find('list', array('conditions' => array('EmployeeAppraisalQuestion.publish' => 1, 'EmployeeAppraisalQuestion.soft_delete' => 0), 'fields' => 'appraisal_question_id', 'recursive' => -1, 'EmployeeAppraisalQuestion.appraisal_id' => $id));
        $this->set(compact('appraisalQuestions', 'selectedAppraisalQuestions'));
    }

    public function delete_all($ids = null) {
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);
        $modelName = $this->modelClass;
        $this->loadModel('Approval');
        $this->loadModel('EmployeeAppraisalQuestion');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => $modelName)));
                    $employeeQuestions = $this->EmployeeAppraisalQuestion->find('all', array('conditions' => array('EmployeeAppraisalQuestion.appraisal_id' => $id)));
                    foreach ($approves as $approve) {
                        $approve['Approval']['soft_delete'] = 1;
                        $this->Approval->save($approve, false);
                    }
                    foreach ($employeeQuestions as $employeeQuestion) {
                        $employeeQuestion['EmployeeAppraisalQuestion']['soft_delete'] = 1;
                        $this->EmployeeAppraisalQuestion->save($employeeQuestion, false);
                    }
                    $data['id'] = $id;
                    $data['soft_delete'] = 1;
                    $this->$modelName->save($data, false);
                }
            }
        }

        $this->Session->setFlash(__('All selected value deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function purge_all($ids = null) {
        $flag = 0;
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);
        $modelName = $this->modelClass;
        $this->loadModel('EmployeeAppraisalQuestion');
        $this->loadModel('Approval');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $this->$modelName->id = $id;
                    if (!$this->$modelName->exists()) {
                        throw new NotFoundException(__('Invalid detail'));
                    }

                    $this->request->onlyAllow('post', 'delete');
                    $employeeQuestions = $this->EmployeeAppraisalQuestion->find('all', array('conditions' => array('EmployeeAppraisalQuestion.appraisal_id' => $id)));
                    $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => $modelName)));
                    foreach ($approves as $approve) {
                        if ($this->Approval->delete($approve['Approval']['id'], true)) {
                            $flag = 1;
                        } else {
                            $flag = 0;
                            $this->Session->setFlash(__('All selected value was not deleted'));
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                    foreach ($employeeQuestions as $employeeQuestion) {
                        if ($this->EmployeeAppraisalQuestion->delete($employeeQuestion['EmployeeAppraisalQuestion']['id'], true)) {
                            $flag = 1;
                        } else {
                            $flag = 0;
                            $this->Session->setFlash(__('All selected value was not deleted'));
                            $this->redirect(array('action' => 'index'));
                        }
                    }

                    if ($this->$modelName->delete($id, true)) {
                        $flag = 1;
                    } else {
                        $flag = 0;
                        $this->Session->setFlash(__('All selected value was not deleted'));
                        $this->redirect(array('action' => 'index'));
                    }
                }
            }

            if ($flag) {
                $this->Session->setFlash(__('All selected values deleted'));
                $this->redirect(array('action' => 'index'));
            }
        }
        $this->redirect(array('action' => 'index'));
    }

    public function restore_all($ids = null) {
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);
        $modelName = $this->modelClass;
        $this->loadModel('Approval');
        $this->loadModel('EmployeeAppraisalQuestion');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => $modelName)));
                    foreach ($approves as $approve) {
                        $approve['Approval']['soft_delete'] = 0;
                        $this->Approval->save($approve, false);
                    }
                    $employeeQuestions = $this->EmployeeAppraisalQuestion->find('all', array('conditions' => array('EmployeeAppraisalQuestion.appraisal_id' => $id)));
                    foreach ($employeeQuestions as $employeeQuestion) {
                        $employeeQuestions['EmployeeAppraisalQuestion']['soft_delete'] = 0;
                        $this->EmployeeAppraisalQuestion->save($employeeQuestion, false);
                    }
                    $data['id'] = $id;
                    $data['soft_delete'] = 0;
                    $this->$modelName->save($data, false);
                }
            }
        }

        $this->Session->setFlash(__('All selected value restored'));
        $this->redirect(array('action' => 'index'));
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
        $this->loadModel('Approval');
        $this->loadModel('EmployeeAppraisalQuestion');
        if (!empty($id)) {
            $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => $modelName)));
            foreach ($approves as $approve) {
                $approve['Approval']['soft_delete'] = 0;
                $this->Approval->save($approve, false);
            }
            $employeeQuestions = $this->EmployeeAppraisalQuestion->find('all', array('conditions' => array('EmployeeAppraisalQuestion.appraisal_id' => $id)));
            foreach ($employeeQuestions as $employeeQuestion) {
                $employeeQuestions['EmployeeAppraisalQuestion']['soft_delete'] = 0;
                $this->EmployeeAppraisalQuestion->save($employeeQuestion, false);
            }
            $data['id'] = $id;
            $data['soft_delete'] = 0;
            $modelName = $this->modelClass;
            $this->$modelName->save($data, false);
        }

        $this->redirect(array('action' => 'index'));
    }

    public function delete($id = null) {
        $modelName = $this->modelClass;
        $this->loadModel('Approval');
        $this->loadModel('EmployeeAppraisalQuestion');
        if (!empty($id)) {
            $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => $modelName)));
            foreach ($approves as $approve) {
                $approve['Approval']['soft_delete'] = 1;
                $this->Approval->save($approve, false);
            }
            $employeeQuestions = $this->EmployeeAppraisalQuestion->find('all', array('conditions' => array('EmployeeAppraisalQuestion.appraisal_id' => $id)));
            foreach ($employeeQuestions as $employeeQuestion) {
                $employeeQuestions['EmployeeAppraisalQuestion']['soft_delete'] = 1;
                $this->EmployeeAppraisalQuestion->save($employeeQuestion, false);
            }
            $data['id'] = $id;
            $data['soft_delete'] = 1;
            $modelName = $this->modelClass;
            $this->$modelName->save($data, false);
        }

        $this->redirect(array('action' => 'index'));
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
        $this->$modelName->id = $id;
        $this->loadModel('Approval');
        $this->loadModel('EmployeeAppraisalQuestion');
        if (!$this->$modelName->exists()) {
            throw new NotFoundException(__('Invalid detail'));
        }
        $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => $modelName)));
        foreach ($approves as $approve) {
            if (!($this->Approval->delete($approve['Approval']['id'], true))) {
                $this->Session->setFlash(__('All selected value was not deleted from Approve'));
                $this->redirect(array('action' => 'index'));
            }
        }
        $employeeQuestions = $this->EmployeeAppraisalQuestion->find('all', array('conditions' => array('EmployeeAppraisalQuestion.appraisal_id' => $id)));
        foreach ($employeeQuestions as $employeeQuestion) {
            if (!($this->EmployeeAppraisalQuestion->delete($employeeQuestion['EmployeeAppraisalQuestion']['id'], true))) {
                $this->Session->setFlash(__('All selected value was not deleted from Approve'));
                $this->redirect(array('action' => 'index'));
            }
        }
        if ($this->$modelName->delete($id, true)) {
            $this->Session->setFlash(__('Selected ' . $modelName . ' Deleted'));
            $this->redirect(array(
                'action' => 'index'
            ));
        }

        $this->Session->setFlash(__('Selected ' . $modelName . ' was not deleted'));
        $this->redirect(array(
            'action' => 'index'
        ));
    }

    public function self_appraisals($token = null) {

        if (empty($token) && !$this->request->is('post')) {
            $this->Session->setFlash(__('Invalid performance review token, try again.'), 'default', array('class'=>'alert-danger'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        $this->layout = 'login';
        $this->loadModel('EmployeeAppraisalQuestion');

        $appraisalDetails = $this->Appraisal->find('first', array('conditions' => array('appraisal_token' => $token, 'appraisal_token_expires >' => date('Y-m-d H:i:s')), 'recursive' => 0, 'fields' => array('Appraisal.id', 'Appraisal.appraisal_date', 'AppraiserBy.name', 'AppraiserBy.office_email', 'Employee.name')));

        if (count($appraisalDetails)) {

            $employeeAppraisals = $this->EmployeeAppraisalQuestion->find('all', array('conditions' => array('EmployeeAppraisalQuestion.appraisal_id' => $appraisalDetails['Appraisal']['id']), 'fields' => array('id', 'appraisal_question_id', 'answer'), 'recursive' => -1));

            if (count($employeeAppraisals) > 0) {
                if ($this->request->is('post') || $this->request->is('put')) {

                    foreach ($this->request->data['EmployeeAppraisalQuestion'] as $appraisalQuestion):
                        $this->EmployeeAppraisalQuestion->save($appraisalQuestion);
                    endforeach;

                    $data['Appraisal']['id'] = $appraisalDetails['Appraisal']['id'];
                    $data['Appraisal']['self_appraisal_status'] = 1;
                    $this->Appraisal->save($data['Appraisal'], false);

                    $this->Session->setFlash(__('Appraisal Answers Saved.'), 'default', array('class' => 'alert-success'));
                    $this->redirect(array('controller' => 'users', 'action' => 'login'));
                }
            } else {
                echo __('There are no appraisal questions.');
            }
            $appraisalQuestions = $this->EmployeeAppraisalQuestion->AppraisalQuestion->find('list', array('fields' => 'question'));

            $this->set(compact('employeeAppraisals', 'appraisalQuestions', 'appraisalDetails'));
        } else {
            $this->Session->setFlash(__('Invalid performance review token, try again.'), 'default', array('class'=>'alert-danger'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
            die;
        }
    }

    public function appraisal_review($id) {
         $this->loadModel('EmployeeKra');
        $appraisals = $this->Appraisal->find('first', array('conditions' => array('Appraisal.id' => $id)));
        $currentDate = strtotime(date('Y-m-d'));
        $appraisalDate = strtotime($appraisals['Appraisal']['appraisal_date']);

        if ($currentDate > $appraisalDate && isset($appraisals['Appraisal']['appraisal_token'])) {
            $deleteToken = array();
            $deleteToken['Appraisal']['id'] = $id;
            $deleteToken['Appraisal']['appraisal_token'] = NULL;

            $this->Appraisal->save($deleteToken, false);
        }

        if ($this->request->is('post') || $this->request->is('put')) {
           $employeeKraId = $this->EmployeeKra->find('all',array('conditions'=>array('EmployeeKra.employee_id'=>$employeeId['Appraisal']['employee_id'])));
            foreach($this->request->data['EmployeeKra'] as $employeeKra){
                if(!empty($employeeKra['id'])){
                    $this->EmployeeKra->id = $employeeKra['id'];
                    $this->EmployeeKra->set(array('target_achieved'=>$employeeKra['target_achieved']));
                    $this->EmployeeKra->save();
                    }
                }
                if ($this->Appraisal->save($this->request->data, false)) {
                $this->Session->setFlash(__('The appraisal has been saved'));
                $this->redirect(array('action' => 'index'));
                }

            }
        $this->loadModel('AppraisalQuestion');
        $this->loadModel('EmployeeAppraisalQuestion');
        $options = array('conditions' => array('Appraisal.' . $this->Appraisal->primaryKey => $id));
        $questions = $this->AppraisalQuestion->find('list', array('fields' => 'question'));
        $appraisal = $this->Appraisal->find('first', $options);
        $appraisalQuestions = $this->AppraisalQuestion->find('list', array('fields' => 'AppraisalQuestion.question', 'recursive' => -1));
        $PublishedDesignationList = $this->_get_designation_list();
        $PublishedDepartmentList = $this->_get_department_list();
        $kras = $this->EmployeeKra->find('all', array('conditions' => array('EmployeeKra.employee_id' => $appraisal['Appraisal']['employee_id'])));
        $this->set(compact('appraisals', 'PublishedDesignationList', 'PublishedDepartmentList', 'appraisalQuestions','kras'));

    }

    public function appraisal_notification_email($employeeId = null, $token = null) {
        if (isset($employeeId) && isset($token)) {

            $appraisalInfo = $this->Appraisal->find('first', array('conditions' => array('Appraisal.appraisal_token' => $token), 'fields' => array('Employee.name', 'Employee.personal_email', 'Employee.office_email', 'AppraiserBy.name', 'AppraiserBy.office_email', 'Appraisal.appraisal_date'), 'recursive' => 0));

            if ($appraisalInfo['Employee']['office_email'] != '') {
                $email = $appraisalInfo['Employee']['office_email'];
            } else if ($appraisalInfo['Employee']['personal_email'] != '') {
                $email = $appraisalInfo['Employee']['personal_email'];
            } else {
                $this->Session->setFlash(__('No email id available for this employee, try again.'));
                $this->redirect(array('action' => 'index'));
            }
            try{
                App::uses('CakeEmail', 'Network/Email');
                if($this->Session->read('User.is_smtp') == '1')
                {
                    $EmailConfig = new CakeEmail("smtp");	
                }else if($this->Session->read('User.is_smtp') == '0'){
                    $EmailConfig = new CakeEmail("default");
                }
                $EmailConfig->to($email);
                $baseurl = Router::url('/', true) . 'appraisals' . "/self_appraisals/" . $token;
                $EmailConfig->subject('FlinkISO: Performance Review Questions');
                $EmailConfig->template('appraisalQuestion');
                $EmailConfig->viewVars(array('baseurl' => $baseurl, 'recipientName' => $appraisalInfo['Employee']['name'], 'appraiserName' => $appraisalInfo['AppraiserBy']['name'], 'appraiserEmail' => $appraisalInfo['AppraiserBy']['office_email'], 'appraisalDate' => $appraisalInfo['Appraisal']['appraisal_date']));
                $EmailConfig->emailFormat('html');
                $EmailConfig->send();
            } catch(Exception $e) {
                $this->Session->setFlash(__('Can not send appraisal questions to user. Please check SMTP details, Email Id of employee.'));
            }
        }
    }

}
