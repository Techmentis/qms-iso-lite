<?php

App::uses('AppController', 'Controller');

/**
 * TrainingNeedIdentifications Controller
 *
 * @property TrainingNeedIdentification $TrainingNeedIdentification
 */
class TrainingNeedIdentificationsController extends AppController {

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
        $this->paginate = array('order' => array('TrainingNeedIdentification.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->TrainingNeedIdentification->recursive = 0;
        $this->set('trainingNeedIdentifications', $this->paginate());

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
                        $searchArray[] = array('TrainingNeedIdentification.' . $search => $searchKey);
                    else
                        $searchArray[] = array('TrainingNeedIdentification.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('TrainingNeedIdentification.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['course_id']) {
            foreach ($this->request->query['course_id'] as $course):
                $courseConditions[] = array('TrainingNeedIdentification.course_id' => $course);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $courseConditions));
            else
                $conditions[] = array('or' => $courseConditions);
        }
        if ($this->request->query['employee_id'] != -1) {
            $employeeEonditions = array('TrainingNeedIdentification.employee_id' => $this->request->query['employee_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $employeeEonditions);
            else
                $conditions[] = array('or' => $employeeEonditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('TrainingNeedIdentification.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'TrainingNeedIdentification.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('TrainingNeedIdentification.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('TrainingNeedIdentification.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->TrainingNeedIdentification->recursive = 0;
        $this->paginate = array('order' => array('TrainingNeedIdentification.sr_no' => 'DESC'), 'conditions' => $conditions, 'TrainingNeedIdentification.soft_delete' => 0);
        $this->set('trainingNeedIdentifications', $this->paginate());

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
        if (!$this->TrainingNeedIdentification->exists($id)) {
            throw new NotFoundException(__('Invalid training need identification'));
        }
        $options = array('conditions' => array('TrainingNeedIdentification.' . $this->TrainingNeedIdentification->primaryKey => $id));

        $trainingNeedIdentification = $this->TrainingNeedIdentification->find('first', $options);

        $this->loadModel('Designation');
        $employeeDesignation = $this->Designation->find('first', array('conditions' => array('Designation.id' => $trainingNeedIdentification['Employee']['designation_id']), 'fields' => 'Designation.name','recursive' => -1));
        $trainingNeedIdentification['Designation']['name'] = $employeeDesignation['Designation']['name'];
        $this->set('trainingNeedIdentification', $trainingNeedIdentification);

        $this->loadModel('EmployeeTraining');
        $employeeTrainings = $this->EmployeeTraining->find('all', array(
            'conditions' => array('EmployeeTraining.employee_id' => $trainingNeedIdentification['TrainingNeedIdentification']['employee_id']),
            'fields' => array('EmployeeTraining.training_id'),
            'recursive' => -1
        ));
        $this->loadModel('Training');
        foreach ($employeeTrainings as $employeeTraining):
            $tranings[] = $this->Training->find('first', array('conditions' => array('Training.id' => $employeeTraining['EmployeeTraining']['training_id'])));
        endforeach;

        $this->set('trainings', $tranings);
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
            $this->request->data['TrainingNeedIdentification']['system_table_id'] = $this->_get_system_table_id();
            $this->TrainingNeedIdentification->create();
            if ($this->TrainingNeedIdentification->save($this->request->data)) {

                $this->Session->setFlash(__('The training need identification has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->TrainingNeedIdentification->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The training need identification could not be saved. Please, try again.'));
            }
        }
        $courses = $this->TrainingNeedIdentification->Course->find('list', array('conditions' => array('Course.publish' => 1, 'Course.soft_delete' => 0)));
        $schedules = $this->TrainingNeedIdentification->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));
        $this->set(compact('courses', 'schedules'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->TrainingNeedIdentification->exists($id)) {
            throw new NotFoundException(__('Invalid training need identification'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['TrainingNeedIdentification']['system_table_id'] = $this->_get_system_table_id();
            if ($this->TrainingNeedIdentification->save($this->request->data)) {

                $this->Session->setFlash(__('The training need identification has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The training need identification could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('TrainingNeedIdentification.' . $this->TrainingNeedIdentification->primaryKey => $id));
            $this->request->data = $this->TrainingNeedIdentification->find('first', $options);
        }
        $employees = $this->TrainingNeedIdentification->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $courses = $this->TrainingNeedIdentification->Course->find('list', array('conditions' => array('Course.publish' => 1, 'Course.soft_delete' => 0)));
        $schedules = $this->TrainingNeedIdentification->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));
        $this->set(compact('employees', 'courses','schedules'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->TrainingNeedIdentification->exists($id)) {
            throw new NotFoundException(__('Invalid training need identification'));
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
            $this->request->data['TrainingNeedIdentification']['system_table_id'] = $this->_get_system_table_id();
            if ($this->TrainingNeedIdentification->save($this->request->data)) {

                $this->Session->setFlash(__('The training need identification has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The training need identification could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('TrainingNeedIdentification.' . $this->TrainingNeedIdentification->primaryKey => $id));
            $this->request->data = $this->TrainingNeedIdentification->find('first', $options);
        }
        $employees = $this->TrainingNeedIdentification->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $courses = $this->TrainingNeedIdentification->Course->find('list', array('conditions' => array('Course.publish' => 1, 'Course.soft_delete' => 0)));
        $schedules = $this->TrainingNeedIdentification->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));
        $this->set(compact('employees', 'courses', 'schedules'));
    }

}
