<?php

App::uses('AppController', 'Controller');

/**
 * Timelines Controller
 *
 * @property Timeline $Timeline
 */
class TimelinesController extends AppController {

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
        $this->paginate = array('order' => array('Timeline.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->Timeline->recursive = 0;
        $this->set('timelines', $this->paginate());

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
                        $searchArray[] = array('Timeline.' . $search => $searchKey);
                    else
                        $searchArray[] = array('Timeline.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('or' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('Timeline.branch_id' => $branches);
            endforeach;
            $conditions[] = array('or' => $branchConditions);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['prepared_by'] != -1) {
            $preparedByConditions = array('Timeline.prepared_by' => $this->request->query['prepared_by']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $preparedByConditions);
            else
                $conditions[] = array('or' => $preparedByConditions);
        }
        if ($this->request->query['approved_by'] != -1) {
            $approverConditions = array('Timeline.approved_by' => $this->request->query['approved_by']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $approverConditions);
            else
                $conditions[] = array('or' => $approverConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('Timeline.start_date >=' => date('Y-m-d', strtotime($this->request->query['from-date'])), 'Timeline.end_date <=' => date('Y-m-d', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);

        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('Timeline.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Timeline.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->Timeline->recursive = 0;
        $this->paginate = array('order' => array('Timeline.sr_no' => 'DESC'), 'conditions' => $conditions, 'Timeline.soft_delete' => 0);
        $this->set('timelines', $this->paginate());
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
        if (!$this->Timeline->exists($id)) {
            throw new NotFoundException(__('Invalid timeline'));
        }
        $options = array('conditions' => array('Timeline.' . $this->Timeline->primaryKey => $id));
        $this->set('timeline', $this->Timeline->find('first', $options));
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
            $this->request->data['Timeline']['system_table_id'] = $this->_get_system_table_id();
            $this->Timeline->create();
            if ($this->Timeline->save($this->request->data)) {

                $this->Session->setFlash(__('The timeline has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->Timeline->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The timeline could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Timeline->exists($id)) {
            throw new NotFoundException(__('Invalid timeline'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Timeline']['system_table_id'] = $this->_get_system_table_id();
            if ($this->Timeline->save($this->request->data)) {

                $this->Session->setFlash(__('The timeline has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The timeline could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Timeline.' . $this->Timeline->primaryKey => $id));
            $this->request->data = $this->Timeline->find('first', $options);
        }
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->Timeline->exists($id)) {
            throw new NotFoundException(__('Invalid timeline'));
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
            if ($this->Timeline->save($this->request->data)) {

                $this->Session->setFlash(__('The timeline has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The timeline could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Timeline.' . $this->Timeline->primaryKey => $id));
            $this->request->data = $this->Timeline->find('first', $options);
        }
    }

    public function data_json() {
        $this->layout = "ajax";
        $timelines = $this->Timeline->find('all', array('conditions' => array('Timeline.publish' => 1, 'Timeline.soft_delete' => 0)));
        if ($timelines) {
            $i = 0;
            foreach ($timelines as $timelineData):
                // convert data into timeline.js pattern
                $date[$i]['startDate'] = date('Y,m,d', strtotime($timelineData['Timeline']['start_date']));
                $date[$i]['endDate'] = date('Y,n,d', strtotime($timelineData['Timeline']['end_date']));
                $date[$i]['headline'] = $timelineData['Timeline']['title'];
                $date[$i]['text'] = $timelineData['Timeline']['message'];
                $date[$i]['asset'] = null;
                $i++;
            endforeach;
            $timeline = null;
            $companyName = $this->_get_company();
            $timeline['headline'] = $companyName['Company']['name'];
            $timeline['type'] = "default";
            $timeline["text"] = 'FlinkISO Timeline for variouse ISO & Quality related activities';
            $timeline["startDate"] = date('Y,m,d');
            $timeline['date'] = $date;
            $this->set('timeline', array('timeline' => $timeline));
        }else {
            return false;
        }
    }

    public function timeline() {
        $start = 0;
        $start = $this->Timeline->find('count', array('fields' => array('Timeline.sr_no', 'Timeline.start_date'), 'conditions' => array('Timeline.publish' => 1, 'Timeline.soft_delete' => 0, 'Timeline.start_date <' => date('Y-m-d')), 'order' => array('Timeline.start_date' => 'DESC')));
        $start = $start+1;
        $isAny = $this->Timeline->find('count', array('conditions' => array('Timeline.publish' => 1, 'Timeline.soft_delete' => 0)));
        
        if($start > $isAny)
            $start=$isAny;
        
        $this->set('isAny', $isAny);
        $this->set('counter', $start);
        
    }

}
