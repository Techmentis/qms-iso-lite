<?php

App::uses('AppController', 'Controller');

/**
 * CustomerFeedbacks Controller
 *
 * @property CustomerFeedback $CustomerFeedback
 */
class CustomerFeedbacksController extends AppController {

    public function _get_system_table_id() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $this->request->params['controller'])));
        return $systemTableId['SystemTable']['id'];
    }

    /**
     * request handling by - TGS
     * returns array of records created by user for branch , published / unpublished records & soft_deleted records
     */

    /**
     * _get_count method
     *
     * @return void
     */
    public function _get_count() {

        $onlyBranch = null;
        $onlyOwn = null;
        $conditions = null;
        $count = $published = $unpublished = $deleted = 0;
        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('CustomerFeedback.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('CustomerFeedback.created_by' => $this->Session->read('User.id'));
        $conditions = array($onlyBranch, $onlyOwn);

        $count = $this->CustomerFeedback->find('count', array('conditions' => $conditions, 'group' => 'CustomerFeedback.customer_id'));
        $published = $this->CustomerFeedback->find('count', array('conditions' => array($conditions, 'CustomerFeedback.publish' => 1, 'CustomerFeedback.soft_delete' => 0), 'group' => 'CustomerFeedback.customer_id'));
        $unpublished = $this->CustomerFeedback->find('count', array('conditions' => array($conditions, 'CustomerFeedback.publish' => 0, 'CustomerFeedback.soft_delete' => 0), 'group' => 'CustomerFeedback.customer_id'));
        $deleted = $this->CustomerFeedback->find('count', array('conditions' => array($conditions, 'CustomerFeedback.soft_delete' => 1), 'group' => 'CustomerFeedback.customer_id'));
        $this->set(compact('count', 'published', 'unpublished', 'deleted'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {

        $conditions = $this->_check_request();
        $this->paginate = array('conditions' => array($conditions), 'group' => array('CustomerFeedback.customer_id', 'CustomerFeedback.created'), 'order' => array('CustomerFeedback.created' => 'desc'));
        $this->CustomerFeedback->recursive = 0;

        $this->set('customerFeedbacks', $this->paginate());

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
            if ($this->request->query['strict_search'] == 0) {
                $searchKeys[] = $this->request->query['keywords'];
            } else {
                $searchKeys = explode(" ", $this->request->query['keywords']);
            }
            foreach ($searchKeys as $searchKey):
                foreach ($this->request->query['search_fields'] as $search):
                    if ($this->request->query['strict_search'] == 0)
                        $searchArray[] = array('CustomerFeedback.' . $search => $searchKey);
                    else
                        $searchArray[] = array('CustomerFeedback.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }
        if ($this->request->query['customer_id'] != -1) {
            $customerConditions[] = array('CustomerFeedback.customer_id' => $this->request->query['customer_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $customerConditions);
            $conditions[] = array('or' => $customerConditions);
        }
        if ($this->request->query['customer_feedback_question_id'] != -1) {
            $customerQuestionConditions[] = array('CustomerFeedback.customer_feedback_question_id' => $this->request->query['customer_feedback_question_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $customerQuestionConditions);
            $conditions[] = array('or' => $customerQuestionConditions);
        }
        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('CustomerFeedback.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            $conditions[] = array('or' => $branchConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('CustomerFeedback.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'CustomerFeedback.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('CustomerFeedback.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('CustomerFeedback.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->CustomerFeedback->recursive = 0;
        $this->paginate = array('order' => array('CustomerFeedback.created' => 'DESC'), 'group' => array('CustomerFeedback.customer_id', 'CustomerFeedback.created'), 'conditions' => $conditions, 'CustomerFeedback.soft_delete' => 0);

        $this->set('customerFeedbacks', $this->paginate());

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
        if (!$this->CustomerFeedback->exists($id)) {
            throw new NotFoundException(__('Invalid customer feedback'));
        }
        $options = array('conditions' => array('CustomerFeedback.' . $this->CustomerFeedback->primaryKey => $id));
        $customerFeedback = $this->CustomerFeedback->find('first', $options);
        $customerFeedbackAll = $this->CustomerFeedback->find('all', array('conditions' => array('CustomerFeedback.customer_id' => $customerFeedback['CustomerFeedback']['customer_id'], 'CustomerFeedback.created' => $customerFeedback['CustomerFeedback']['created'])));

        $this->set('customerFeedback', $customerFeedback);
        $this->set('customerFeedbackDetails', $customerFeedbackAll);
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
    public function add_ajax() {
        $flag = 0;
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }

        if ($this->request->is('post')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            foreach ($this->request->data['CustomerFeedback']['Questions'] as $feedback):
                $feedback['system_table_id'] = $this->_get_system_table_id();
                $feedback['customer_id'] = $this->request->data['CustomerFeedback']['customer_id'];
                $feedback['publish'] = $this->request->data['CustomerFeedback']['publish'];
                $feedback['prepared_by'] = $this->request->data['CustomerFeedback']['prepared_by'];
                $feedback['approved_by'] = $this->request->data['CustomerFeedback']['approved_by'];

                $this->CustomerFeedback->create();
                if ($this->CustomerFeedback->save($feedback)) {
                    $flag = 1;
                }
            endforeach;
            if ($flag == 1) {
                $this->Session->setFlash(__('The customer feedback has been saved'));
                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The customer feedback could not be saved. Please, try again.'));
            }

            $this->redirect(array('action' => 'index'));
        }
        $customers = $this->CustomerFeedback->Customer->find('list', array('conditions' => array('Customer.publish' => 1, 'Customer.soft_delete' => 0)));
        $customerFeedbackQuestions = $this->CustomerFeedback->CustomerFeedbackQuestion->find('all', array('conditions' => array('CustomerFeedbackQuestion.publish' => 1, 'CustomerFeedbackQuestion.soft_delete' => 0)));
        $this->set(compact('customers', 'customerFeedbackQuestions'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $flag = 0;
        if (!$this->CustomerFeedback->exists($id)) {
            throw new NotFoundException(__('Invalid customer feedback'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }

            foreach ($this->request->data['CustomerFeedback']['Questions'] as $newData) {
                $newData['customer_id'] = $this->request->data['CustomerFeedback']['customer_id'];
                $newData['system_table_id'] = $this->_get_system_table_id();
                $newData['publish'] = $this->request->data['CustomerFeedback']['publish'];
                $newData['prepared_by'] = $this->request->data['CustomerFeedback']['prepared_by'];
                $newData['approved_by'] = $this->request->data['CustomerFeedback']['approved_by'];
                if ($this->CustomerFeedback->save($newData))
                    $flag = 1;
            }
            if ($flag) {
                $this->Session->setFlash(__('The customer feedback has been saved'));
                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The customer feedback could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CustomerFeedback.' . $this->CustomerFeedback->primaryKey => $id));
            $this->request->data = $this->CustomerFeedback->find('first', $options);
        }
        $customers = $this->CustomerFeedback->Customer->find('list', array('conditions' => array('Customer.publish' => 1, 'Customer.soft_delete' => 0)));
        $customerFeedbackQuestions = $this->CustomerFeedback->CustomerFeedbackQuestion->find('all', array('conditions' => array('CustomerFeedbackQuestion.publish' => 1, 'CustomerFeedbackQuestion.soft_delete' => 0)));
        $options = array('conditions' => array('CustomerFeedback.' . $this->CustomerFeedback->primaryKey => $id));
        $customerFeedback = $this->CustomerFeedback->find('first', $options);
        $customerFeedbackAll = $this->CustomerFeedback->find('all', array('conditions' => array('CustomerFeedback.customer_id' => $customerFeedback['CustomerFeedback']['customer_id'], 'CustomerFeedback.created' => $customerFeedback['CustomerFeedback']['created'])));

        $customerFeedbackDetails = array();
        foreach ($customerFeedbackAll as $val) {
            $key = $val['CustomerFeedback']['customer_feedback_question_id'];
            $customerFeedbackDetails[$key]['id'] = $val['CustomerFeedback']['id'];
            $customerFeedbackDetails[$key]['answer'] = $val['CustomerFeedback']['answer'];
            $customerFeedbackDetails[$key]['comments'] = $val['CustomerFeedback']['comments'];
        }
        $this->set('customerFeedbackDetails', $customerFeedbackDetails);
        $this->set(compact('customers', 'customerFeedbackQuestions'));
    }


    /**
     * purge method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function purge($id = null) {
        if (!empty($id)) {
            $this->loadModel('Approval');
            $options = array('conditions' => array('CustomerFeedback.' . $this->CustomerFeedback->primaryKey => $id));
            $customerFeedback = $this->CustomerFeedback->find('first', $options);
            $customerFeedbackAll = $this->CustomerFeedback->find('all', array('conditions' => array('CustomerFeedback.customer_id' => $customerFeedback['CustomerFeedback']['customer_id'], 'CustomerFeedback.created' => $customerFeedback['CustomerFeedback']['created']), 'recursive' => 0));
            $approve = $this->Approval->find('all');
            $customerFeedbackDetails = array();
            foreach ($customerFeedbackAll as $data) {
                $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $data['CustomerFeedback']['id'], 'Approval.model_name' => 'CustomerFeedback')));
                foreach ($approves as $approve) {
                    if (!($this->Approval->delete($approve['Approval']['id'], true))) {
                        $this->Session->setFlash(__('All selected value was not deleted from Approve'));
                        $this->redirect(array('action' => 'index'));
                    }
                }
                if (!$this->CustomerFeedback->delete($data['CustomerFeedback']['id'], true)) {
                    $this->Session->setFlash(__('All selected value was not deleted'));
                    $this->redirect(array('action' => 'index'));
                }
            }
        }

        $this->redirect(array('action' => 'index'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $modelName = $this->modelClass;
        if (!empty($id)) {
            $options = array('conditions' => array('CustomerFeedback.' . $this->CustomerFeedback->primaryKey => $id));
            $customerFeedback = $this->CustomerFeedback->find('first', $options);
            $customerFeedbackAll = $this->CustomerFeedback->find('all', array('conditions' => array('CustomerFeedback.customer_id' => $customerFeedback['CustomerFeedback']['customer_id'], 'CustomerFeedback.created' => $customerFeedback['CustomerFeedback']['created'])));
            $customerFeedbackDetails = array();
            $this->loadModel('Approval');
            foreach ($customerFeedbackAll as $data) {
                $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $data['CustomerFeedback']['id'], 'Approval.model_name' => 'CustomerFeedback')));
                foreach ($approves as $approve) {
                    $approve['Approval']['soft_delete'] = 1;
                    $this->Approval->save($approve, false);
                }
                $data['CustomerFeedback']['soft_delete'] = 1;
                $this->$modelName->save($data, false);
            }
        }
        $this->redirect(array(
            'action' => 'index'
        ));
    }

    public function delete_all($id = null) {
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);
        $modelName = $this->modelClass;
        if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $options = array('conditions' => array('CustomerFeedback.' . $this->CustomerFeedback->primaryKey => $id));
                    $customerFeedback = $this->CustomerFeedback->find('first', $options);
                    $customerFeedbackAll = $this->CustomerFeedback->find('all', array('conditions' => array('CustomerFeedback.customer_id' => $customerFeedback['CustomerFeedback']['customer_id'], 'CustomerFeedback.created' => $customerFeedback['CustomerFeedback']['created'])));
                    $customerFeedbackDetails = array();
                    $this->loadModel('Approval');
                    foreach ($customerFeedbackAll as $data) {
                        $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $data['CustomerFeedback']['id'], 'Approval.model_name' => 'CustomerFeedback')));
                        foreach ($approves as $approve) {
                            $approve['Approval']['soft_delete'] = 1;
                            $this->Approval->save($approve, false);
                        }
                        $data['CustomerFeedback']['soft_delete'] = 1;
                        $this->$modelName->save($data, false);
                    }
                }
            }
        }
        $this->redirect(array('action' => 'index'));
    }

    public function restore_all($ids = null) {
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);
        $modelName = $this->modelClass;
        if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $options = array('conditions' => array('CustomerFeedback.' . $this->CustomerFeedback->primaryKey => $id));
                    $customerFeedback = $this->CustomerFeedback->find('first', $options);
                    $customerFeedbackAll = $this->CustomerFeedback->find('all', array('conditions' => array('CustomerFeedback.customer_id' => $customerFeedback['CustomerFeedback']['customer_id'], 'CustomerFeedback.created' => $customerFeedback['CustomerFeedback']['created'])));
                    $customerFeedbackDetails = array();
                    $this->loadModel('Approval');
                    foreach ($customerFeedbackAll as $data) {
                        $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $data['CustomerFeedback']['id'], 'Approval.model_name' => 'CustomerFeedback')));
                        foreach ($approves as $approve) {
                            $approve['Approval']['soft_delete'] = 0;
                            $this->Approval->save($approve, false);
                        }
                        $data['CustomerFeedback']['soft_delete'] = 0;
                        $this->$modelName->save($data, false);
                    }
                }
            }
        }

        $this->Session->setFlash(__('All selected value restored'));
        $this->redirect(array('action' => 'index'));
    }

    public function purge_all($ids = null) {
        $flag = 0;
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);
        $modelName = $this->modelClass;

        if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {

                    $this->request->onlyAllow('post', 'delete');
                    $options = array('conditions' => array('CustomerFeedback.' . $this->CustomerFeedback->primaryKey => $id));
                    $customerFeedback = $this->CustomerFeedback->find('first', $options);
                    $customerFeedbackAll = $this->CustomerFeedback->find('all', array('conditions' => array('CustomerFeedback.customer_id' => $customerFeedback['CustomerFeedback']['customer_id'], 'CustomerFeedback.created' => $customerFeedback['CustomerFeedback']['created'])));
                    $customerFeedbackDetails = array();
                    $this->loadModel('Approval');
                    foreach ($customerFeedbackAll as $data) {

                        $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $data['CustomerFeedback']['id'], 'Approval.model_name' => 'CustomerFeedback')));

                        foreach ($approves as $approve) {
                            if ($this->Approval->delete($approve['Approval']['id'], true)) {
                                $flag = 1;
                            } else {
                                $flag = 0;
                                $this->Session->setFlash(__('All selected value was not deleted from approve'));
                                $this->redirect(array('action' => 'index'));
                            }
                        }
                        if ($this->$modelName->delete($data['CustomerFeedback']['id'], true)) {
                            $flag = 1;
                        } else {
                            $flag = 0;
                            $this->Session->setFlash(__('All selected value was not deleted'));
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }
            }
            if ($flag) {
                $this->Session->setFlash(__('All selected values deleted'));
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    public function publish_record($id = null) {
        $modelName = $this->modelClass;
        if (!empty($id)) {
            $options = array('conditions' => array('CustomerFeedback.' . $this->CustomerFeedback->primaryKey => $id));
            $customerFeedback = $this->CustomerFeedback->find('first', $options);
            $customerFeedbackAll = $this->CustomerFeedback->find('all', array('conditions' => array('CustomerFeedback.customer_id' => $customerFeedback['CustomerFeedback']['customer_id'], 'CustomerFeedback.created' => $customerFeedback['CustomerFeedback']['created'])));

            $customerFeedbackDetails = array();
            $this->loadModel('Approval');

            foreach ($customerFeedbackAll as $data) {
                $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $data['CustomerFeedback']['id'], 'Approval.model_name' => 'CustomerFeedback')));
                foreach ($approves as $approve) {
                    $approve['Approval']['status'] = 'Approved';
                    $this->Approval->save($approve, false);
                }
                $data['CustomerFeedback']['publish'] = 1;
                $this->$modelName->save($data, false);
            }
        }
        $this->redirect(array('action' => 'index'));
    }

}
