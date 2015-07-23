<?php

App::uses('AppController', 'Controller');

/**
 * Trainings Controller
 *
 * @property Training $Training
 */
class TrainingsController extends AppController {

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
        $this->paginate = array('order' => array('Training.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->Training->recursive = 0;

        $trainings = $this->paginate();

        foreach ($trainings as $key => $training) {
            $emps = array();
            $this->loadModel('EmployeeTraining');
            $employeesTraining = $this->EmployeeTraining->find('all', array('conditions' => array('EmployeeTraining.training_id' => $training['Training']['id'], 'EmployeeTraining.soft_delete' => 0), 'fields' => 'Employee.name'));

            foreach ($employeesTraining as $employeeTraining)
                $emps[] = $employeeTraining['Employee']['name'];
            $trainings[$key]['Training']['Attendees'] = implode(', ', $emps);
        }

        $this->set('trainings', $trainings);
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
                        $searchArray[] = array('Training.' . $search => $searchKey);
                    else
                        $searchArray[] = array('Training.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['course_id']) {
            foreach ($this->request->query['course_id'] as $courseId):
                $courseIdConditions[] = array('Training.course_id' => $courseId);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $courseIdConditions));
            else
                $conditions[] = array('or' => $courseIdConditions);
        }
        if ($this->request->query['trainer_type_id']) {
            foreach ($this->request->query['trainer_type_id'] as $trainerTypeId):
                $trainer_conditions[] = array('Training.trainer_type_id' => $trainerTypeId);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $trainer_conditions));
            else
                $conditions[] = array('or' => $trainer_conditions);
        }
        if ($this->request->query['trainer_id']) {
            foreach ($this->request->query['trainer_id'] as $trainerId):
                $trainerIdConditions[] = array('Training.trainer_id' => $trainerId);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $trainerIdConditions));
            else
                $conditions[] = array('or' => $trainerIdConditions);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('Training.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('Training.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'Training.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('Training.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Training.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->Training->recursive = 0;
        $this->paginate = array('order' => array('Training.sr_no' => 'DESC'), 'conditions' => $conditions, 'Training.soft_delete' => 0);

        $trainings = $this->paginate();

        foreach ($trainings as $key => $training) {
            $emps = array();
            $this->loadModel('EmployeeTraining');
            $employeesTraining = $this->EmployeeTraining->find('all', array('conditions' => array('EmployeeTraining.training_id' => $training['Training']['id'], 'EmployeeTraining.soft_delete' => 0), 'fields' => 'Employee.name'));

            foreach ($employeesTraining as $employeeTraining)
                $emps[] = $employeeTraining['Employee']['name'];
            $trainings[$key]['Training']['Attendees'] = implode(', ', $emps);
        }

        $this->set('trainings', $trainings);


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
        if (!$this->Training->exists($id)) {
            throw new NotFoundException(__('Invalid training'));
        }
        $options = array('conditions' => array('Training.' . $this->Training->primaryKey => $id));
        $this->set('training', $this->Training->find('first', $options));


        $this->loadModel('EmployeeTraining');
        $employeesTrainings = $this->EmployeeTraining->find('all', array('conditions' => array('EmployeeTraining.training_id' => $options['conditions']['Training.id'], 'EmployeeTraining.soft_delete' => 0), 'fields' => 'Employee.name'));

        foreach ($employeesTrainings as $employeeTraining)
            $emps[] = $employeeTraining['Employee']['name'];
        $attendees = implode(', ', $emps);
        $this->set('attendees', $attendees);
        $this->_get_count();
    }

    /**
     * list method
     *
     * @return void
     */
    public function lists() {

        $this->_get_count();
    }

    public function get_details($id = null) {
        $this->layout = "ajax";
        $course = $this->Training->Course->find('first', array('conditions' => array('Course.id' => $id), 'recursive' => -1));
        $courseTypes = $this->Training->CourseType->find('list', array('conditions' => array('CourseType.publish' => 1, 'CourseType.soft_delete' => 0)));
        $this->set(compact('courseTypes'));
        $this->set('course', $course);
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
            $this->loadModel('Course');
            $this->Course->recursive = 0;
            $trainingCourseTitle = array();
            $trainingCourseTitle = $this->Course->find('first', array('conditions' => array('Course.id' => $this->request->data['Training']['course_id'], 'Course.soft_delete' => 0, 'Course.publish' => 1), 'fields' => 'Course.title'));
            $this->request->data['Training']['system_table_id'] = $this->_get_system_table_id();
            if ($this->request->data['Training']['trainer_id'] != '-1') {
                $trainer = $this->Training->Trainer->find('first', array(
                    'conditions' => array('Trainer.id' => $this->request->data['Training']['trainer_id']),
                    'recursive' => -1,
                    'fields' => array('Trainer.trainer_type_id')
                ));
                $trainerTypeId = $trainer['Trainer']['trainer_type_id'];
                $this->request->data['Training']['trainer_type_id'] = $trainerTypeId;
            } else {
                $this->request->data['Training']['trainer_type_id'] = '-1';
            }
            $this->Training->create();
            if ($this->Training->save($this->request->data)) {
                $this->loadModel('EmployeeTraining');
                foreach ($this->request->data['EmployeeTraining_employee_id'] as $val) {
                    $this->EmployeeTraining->create();
                    $valData = array();
                    $valData['training_id'] = $this->Training->id;
                    $valData['employee_id'] = $val;
                    $valData['publish'] = 1;
                    $valData['system_table_id'] = $this->_get_system_table_id();
                    $this->EmployeeTraining->save($valData, false);
                }

                $this->Session->setFlash(__('The training has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->Training->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The training could not be saved. Please, try again.'));
            }
        }
        $courses = $this->Training->Course->find('list', array('conditions' => array('Course.publish' => 1, 'Course.soft_delete' => 0)));
        $trainers = $this->Training->Trainer->find('list', array('conditions' => array('Trainer.publish' => 1, 'Trainer.soft_delete' => 0)));
        $trainerTypes = $this->Training->TrainerType->find('list', array('conditions' => array('TrainerType.publish' => 1, 'TrainerType.soft_delete' => 0)));
        $courseTypes = $this->Training->CourseType->find('list', array('conditions' => array('CourseType.publish' => 1, 'CourseType.soft_delete' => 0)));
        $this->set(compact('courses', 'trainers', 'trainerTypes', 'courseTypes'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Training->exists($id)) {
            throw new NotFoundException(__('Invalid training'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }

        if ($this->request->is('post') || $this->request->is('put')) {

            $this->loadModel('Course');
            $this->Course->recursive = 0;
            $trainingCourseTitle = array();
            $trainingCourseTitle = $this->Course->find('first', array('conditions' => array('Course.id' => $this->request->data['Training']['course_id'], 'Course.soft_delete' => 0, 'Course.publish' => 1), 'fields' => 'Course.title'));

            $this->request->data['Training']['system_table_id'] = $this->_get_system_table_id();

            if ($this->request->data['Training']['trainer_id'] != '-1') {
                $trainerTypeId = null;
                $trainerTypeId = $this->Training->Trainer->find('first', array(
                    'conditions' => array('Trainer.id' => $this->request->data['Training']['trainer_id']),
                    'recursive' => -1,
                    'fields' => array('Trainer.trainer_type_id')
                ));
                $trainerTypeId = $trainerTypeId['Trainer']['trainer_type_id'];
                $this->request->data['Training']['trainer_type_id'] = $trainerTypeId;
            } else {
                $this->request->data['Training']['trainer_type_id'] = '-1';
            }


            if ($this->Training->save($this->request->data)) {
                $this->loadModel('EmployeeTraining');
                $this->EmployeeTraining->deleteAll(array('EmployeeTraining.training_id' => $this->Training->id), false);
                foreach ($this->request->data['EmployeeTraining_employee_id'] as $val) {
                    $this->EmployeeTraining->create();
                    $valData = array();
                    $valData['training_id'] = $this->Training->id;
                    $valData['employee_id'] = $val;
                    $valData['publish'] = 1;
                    $valData['system_table_id'] = $this->_get_system_table_id();
                    $this->EmployeeTraining->save($valData, false);
                }

                $this->Session->setFlash(__('The training has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The training could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Training.' . $this->Training->primaryKey => $id));
            $this->request->data = $this->Training->find('first', $options);
        }


        $courses = $this->Training->Course->find('list', array('conditions' => array('Course.publish' => 1, 'Course.soft_delete' => 0)));
        $trainers = $this->Training->Trainer->find('list', array('conditions' => array('Trainer.publish' => 1, 'Trainer.soft_delete' => 0)));
        $trainerTypes = $this->Training->TrainerType->find('list', array('conditions' => array('TrainerType.publish' => 1, 'TrainerType.soft_delete' => 0)));
        $courseTypes = $this->Training->CourseType->find('list', array('conditions' => array('CourseType.publish' => 1, 'CourseType.soft_delete' => 0)));
        $this->loadModel('EmployeeTraining');
        $trainingEmployees = $this->EmployeeTraining->find('all', array('conditions' => array('EmployeeTraining.training_id' => $id, 'EmployeeTraining.soft_delete' => 0), 'fields' => 'EmployeeTraining.employee_id'));
        foreach ($trainingEmployees as $trainingEmployee) {
            $selectedEmp[] = $trainingEmployee['EmployeeTraining']['employee_id'];
        }
        $this->set('selectedEmp', $selectedEmp);
        $PublishedEmployeeList = $this->EmployeeTraining->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $this->set(compact('courses', 'trainers', 'trainerTypes', 'courseTypes', 'PublishedEmployeeList'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->Training->exists($id)) {
            throw new NotFoundException(__('Invalid training'));
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
            $this->loadModel('Course');
            $this->Course->recursive = 0;
            $trainingCourseTitle = array();
            $trainingCourseTitle = $this->Course->find('first', array('conditions' => array('Course.id' => $this->request->data['Training']['course_id'], 'Course.soft_delete' => 0, 'Course.publish' => 1), 'fields' => 'Course.title'));

            $this->request->data['Training']['system_table_id'] = $this->_get_system_table_id();

            if ($this->Training->save($this->request->data)) {
                $this->loadModel('EmployeeTraining');
                $this->EmployeeTraining->deleteAll(array('EmployeeTraining.training_id' => $this->Training->id), false);
                foreach ($this->request->data['EmployeeTraining_employee_id'] as $val) {
                    $this->EmployeeTraining->create();
                    $valData = array();
                    $valData['training_id'] = $this->Training->id;
                    $valData['employee_id'] = $val;
                    $valData['publish'] = 1;
                    $valData['system_table_id'] = $this->_get_system_table_id();
                    $this->EmployeeTraining->save($valData, false);
                }

                $this->Session->setFlash(__('The training has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The training could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Training.' . $this->Training->primaryKey => $id));
            $this->request->data = $this->Training->find('first', $options);
        }
        $courses = $this->Training->Course->find('list', array('conditions' => array('Course.publish' => 1, 'Course.soft_delete' => 0)));
        $trainers = $this->Training->Trainer->find('list', array('conditions' => array('Trainer.publish' => 1, 'Trainer.soft_delete' => 0)));
        $trainerTypes = $this->Training->TrainerType->find('list', array('conditions' => array('TrainerType.publish' => 1, 'TrainerType.soft_delete' => 0)));
        $courseTypes = $this->Training->CourseType->find('list', array('conditions' => array('CourseType.publish' => 1, 'CourseType.soft_delete' => 0)));
        $this->loadModel('EmployeeTraining');
        $trainingEmployees = $this->EmployeeTraining->find('all', array('conditions' => array('EmployeeTraining.training_id' => $id, 'EmployeeTraining.soft_delete' => 0), 'fields' => 'EmployeeTraining.employee_id'));
        foreach ($trainingEmployees as $trainingEmployee) {
            $selectedEmp[] = $trainingEmployee['EmployeeTraining']['employee_id'];
        }
        $this->set('selectedEmp', $selectedEmp);
        $PublishedEmployeeList = $this->EmployeeTraining->Employee->find('list', array('conditions' => array('Employee.publish' => 1, 'Employee.soft_delete' => 0)));
        $this->set(compact('courses', 'trainers', 'trainerTypes', 'courseTypes', 'PublishedEmployeeList'));
    }

}
