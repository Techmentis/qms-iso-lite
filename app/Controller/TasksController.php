<?php

App::uses('AppController', 'Controller');

/**
 * Tasks Controller
 *
 * @property Task $Task
 */
class TasksController extends AppController {

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
        $this->paginate = array('order' => array('Task.sr_no' => 'DESC'), 'conditions' => array($conditions));
        $this->Task->recursive = 0;
	$this->set('tasks', $this->paginate());
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
                        $searchArray[] = array('Task.' . $search => $searchKey);
                    else
                        $searchArray[] = array('Task.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['user_name'] != -1) {
            $userConditions = array('Task.user_id' => $this->request->query['user_name']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $userConditions);
            else
                $conditions[] = array('or' => $userConditions);
        }
        if ($this->request->query['master_list_id'] != -1) {
            $masterListIdConditions = array('Task.master_list_of_format_id' => $this->request->query['master_list_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $masterListIdConditions);
            else
                $conditions[] = array('or' => $masterListIdConditions);
        }
        if ($this->request->query['schedule_id'] != '') {
            $scheduleIdConditions[] = array('Task.schedule_id' => $this->request->query['schedule_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('or'=>$scheduleIdConditions));
            else
                $conditions[] = array('or' => $scheduleIdConditions);
        }
        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('Task.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('or'=>$branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);;
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('Task.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'Task.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);

        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('Task.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Task.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->Task->recursive = 0;
        $this->paginate = array('order' => array('Task.sr_no' => 'DESC'), 'conditions' => $conditions, 'Task.soft_delete' => 0);
        $this->set('tasks', $this->paginate());
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
        if (!$this->Task->exists($id)) {
            throw new NotFoundException(__('Invalid task'));
        }
        $userNames = $this->requestAction('App/get_usernames');
	$this->set('userNames', $userNames);
        $options = array('conditions' => array('Task.' . $this->Task->primaryKey => $id));
        $task = $this->Task->find('first', $options);
        $this->set(compact('task', 'employees'));
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

        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post')) {
            $this->request->data['Task']['system_table_id'] = $this->_get_system_table_id();
            $this->Task->create();
            if ($this->Task->save($this->request->data, false)) {

                $this->Session->setFlash(__('The task has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->Task->id));
                else
                    $this->redirect(str_replace('/lists', '/add_ajax', $this->referer()));
            } else {
                $this->Session->setFlash(__('The task could not be saved. Please, try again.'));
            }
        }
        $masterListOfFormats = $this->Task->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0, 'MasterListOfFormat.archived' => 0)));
        $users = $this->requestAction('App/get_usernames');
        $schedules = $this->Task->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));
        $this->set(compact('masterListOfFormats','schedules','users'));
     }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Task->exists($id)) {
            throw new NotFoundException(__('Invalid task'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Task']['system_table_id'] = $this->_get_system_table_id();
            if ($this->Task->save($this->request->data, false)) {

                $this->Session->setFlash(__('The task has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The task could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Task.' . $this->Task->primaryKey => $id));
            $this->request->data = $this->Task->find('first', $options);
        }
        $masterListOfFormats = $this->Task->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0, 'MasterListOfFormat.archived' => 0)));
        $this->loadModel('Employee');
        $users = $this->requestAction('App/get_usernames');
        $schedules = $this->Task->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));
        $this->set(compact('masterListOfFormats', 'schedules', 'users'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->Task->exists($id)) {
            throw new NotFoundException(__('Invalid task'));
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
            $this->request->data['Task']['system_table_id'] = $this->_get_system_table_id();
            if ($this->Task->save($this->request->data, false)) {

                $this->Session->setFlash(__('The task has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The task could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Task.' . $this->Task->primaryKey => $id));
            $this->request->data = $this->Task->find('first', $options);
        }
        $masterListOfFormats = $this->Task->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0, 'MasterListOfFormat.archived' => 0)));
        $users = $this->requestAction('App/get_usernames');
        $schedules = $this->Task->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));
        $this->set(compact('masterListOfFormats', 'users', 'schedules'));
     }

    public function get_task($id = null) {
        $this->loadModel('Task');
        $this->loadModel('TaskStatus');
        if ($this->request->is('post')) {
            foreach ($this->request->data['TaskStatus'] as $taskStatus) {
                if (isset($taskStatus['task_performed']) && $taskStatus['task_performed'] > 0) {
                    if (!$taskStatus['id'])
                    $this->TaskStatus->create();
                    $taskStatus['publish'] = 1;
                    $taskStatus['task_date'] = date("Y-m-d");
                    $this->TaskStatus->save($taskStatus, false);
                }
            }
            $this->Session->setFlash(__('The task status has been saved'));
        }
        $onlyBranch = null;
        $onlyOwn = null;
        $condition1 = null;
        $condition2 = null;
        $condition3 = null;
        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('Task.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Task.created_by' => $this->Session->read('User.id'));
        if ($this->Session->read('User.is_mr') == 0) {
            $condition3 = array('Task.user_id' => $this->Session->read('User.id'));
        }
        $finalCond = array('OR' => array($onlyBranch, $onlyOwn, $condition3));
        if ($this->request->params['named']) {
            if ($this->request->params['named']['published'] == null)
                $condition1 = null;
            else
                $condition1 = array('Task.publish' => $this->request->params['named']['published']);
            if ($this->request->params['named']['soft_delete'] == null)
                $condition2 = null;
            else
                $condition2 = array('Task.soft_delete' => $this->request->params['named']['soft_delete']);
            if ($this->request->params['named']['soft_delete'] == null)
                $conditions = array($onlyBranch, $onlyOwn, $condition1, $condition3, 'Task.soft_delete' => 0);
            else
                $conditions = array($condition1, $condition2, $finalCond);
        }else {
            $conditions = array($finalCond, 'Task.soft_delete' => 0);
        }
        $count = 0;
        $options = array(
			'fields'=>array('Task.id','Task.sr_no','Task.name','Task.master_list_of_format_id','Task.user_id','Task.description','Task.task_type','Task.schedule_id','Task.publish','Task.record_status','Task.status_user_id',
				'Task.soft_delete','Task.branchid','Task.departmentid','Task.company_id','Task.system_table_id','User.id','User.name','Schedule.id','Schedule.name','Schedule.sr_no',
			),
			'order' => array('Task.sr_no' => 'DESC'),
			'conditions' => array($conditions));
        $tasks = $this->Task->find('all', $options);
	if($tasks){
	    foreach ($tasks as $key => $task) {
            $count++;
            $test = $this->TaskStatus->find('first', array('order' => array('TaskStatus.sr_no' => 'DESC'), 'conditions' => array('TaskStatus.task_id' => $task['Task']['id'])));
            if (count($test)) {
                if ($task['Schedule']['sr_no'] == 1) {
                    if (date('Y-m-d', strtotime($test['TaskStatus']['created'])) == date('Y-m-d')) {
                        $tasks[$key]['TaskStatus'] = $test['TaskStatus'];
                    } else {
                        $tasks[$key]['TaskStatus'] = array();
                    }
                } else if ($task['Schedule']['sr_no'] == 2) {

                    if (date('W', strtotime($test['TaskStatus']['created'])) == date('W')) {
                        $tasks[$key]['TaskStatus'] = $test['TaskStatus'];
                    } else {
                        $tasks[$key]['TaskStatus'] = array();
                    }
                } else if ($task['Schedule']['sr_no'] == 4) {

                    if (date('m', strtotime($test['TaskStatus']['created'])) == date('m')) {
                        $tasks[$key]['TaskStatus'] = $test['TaskStatus'];
                    } else {
                        $tasks[$key]['TaskStatus'] = array();
                    }
                } else if ($task['Schedule']['sr_no'] == 5) {

                    if (date('y', strtotime($test['TaskStatus']['created'])) == date('y')) {
                        $tasks[$key]['TaskStatus'] = $test['TaskStatus'];
                    } else {
                        $tasks[$key]['TaskStatus'] = array();
                    }
                }else if ($task['Schedule']['sr_no'] == 7) {

                    if (date('y', strtotime($test['TaskStatus']['created'])) == date('y')) {
                        $tasks[$key]['TaskStatus'] = $test['TaskStatus'];
                    } else {
                        $tasks[$key]['TaskStatus'] = array();
                    }
                }
            }
			}
        }
	$this->set('editId', $id);
        $this->set(compact('tasks', 'count'));
        $this->render('/Elements/task');
    }
    
        public function get_task_name($taskName = null, $id = null) {
            if ($taskName) {
                if ($id) {
                    $tasks = $this->Task->find('all', array('conditions' => array('Task.name' => $taskName, 'Task.id !=' => $id)));
                } else {
                    $tasks = $this->Task->find('all', array('conditions' => array('Task.name' => $taskName)));
                }
                if (count($tasks)) {
                    echo "Task name already exists, Task name should be unique";
                }
            }
            exit;
        }
    
}
