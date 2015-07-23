<?php

App::uses('AppController', 'Controller');

/**
 * Benchmarks Controller
 *
 * @property Benchmark $Benchmark
 */
class BenchmarksController extends AppController {

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
        $this->paginate = array('order' => array('Benchmark.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->Benchmark->recursive = 0;
        if ($this->request->is('post')) {
            $benchMarks = array();
            $this->Benchmark->deleteAll(array('Benchmark.branch_id' => $this->request->data['branch']['id']));
            foreach ($this->request->data['department'] as $key => $val) {
                $benchMarks['branch_id'] = $this->request->data['branch']['id'];
                $benchMarks['department_id'] = $val['id'];
                $benchMarks['benchmark'] = $this->request->data['benchmark'][$key]['val'];
                $benchMarks['branchid'] = $this->Session->read('User.branch_id');
                $benchMarks['departmentid'] = $this->Session->read('User.department_id');
                $benchMarks['created_by'] = $this->Session->read('User.id');
                $benchMarks['modified_by'] = $this->Session->read('User.id');
                $benchMarks['created'] = date('Y-m-d H:i:s');
                $benchMarks['modified'] = date('Y-m-d H:i:s');
                $benchMarks['publish'] = 1;
                $benchMarks['system_table_id'] = $this->_get_system_table_id();
                if ($this->request->data['benchmark'][$key]['id'])
                    $benchMarks['id'] = $this->request->data['benchmark'][$key]['id'];
                else
                    $this->Benchmark->create();
                $this->Benchmark->save($benchMarks, false);
                $this->Session->setFlash(__('The Benchmarks has been saved..'));
            }
        }
        $PublishedBranchList = $this->Benchmark->Branch->find('list', array('conditions' => array('Branch.soft_delete' => 0, 'Branch.publish' => 1)));
        $PublishedDepartmentList = $this->Benchmark->Department->find('list', array('conditions' => array('Department.soft_delete' => 0, 'Department.publish' => 1)));

        $benchMarks = array();
        $i = 0;
        foreach ($PublishedBranchList as $branchKey => $branchValue) {
            $benchMarks[$i]['branch']['id'] = $branchKey;
            $benchMarks[$i]['branch']['name'] = $branchValue;
            $j = 0;
            foreach ($PublishedDepartmentList as $key => $value) {
                $benchmark = $this->Benchmark->find('first', array('conditions' => array('Benchmark.branch_id' => $branchKey, 'Benchmark.department_id' => $key)));
                $benchMarks[$i]['branch']['department'][$j]['id'] = $key;
                $benchMarks[$i]['branch']['department'][$j]['id'] = $key;
                $benchMarks[$i]['branch']['department'][$j]['id'] = $key;
                $benchMarks[$i]['branch']['department'][$j]['name'] = $value;
                if (!$benchmark)
                    $benchMarks[$i]['branch']['department'][$j]['benchmark'] = 0;
                else {
                    $benchMarks[$i]['branch']['department'][$j]['benchmark'] = $benchmark['Benchmark']['benchmark'];
                    $benchMarks[$i]['branch']['department'][$j]['benchmark_id'] = $benchmark['Benchmark']['id'];
                }
                $j++;
            }

            $i++;
        }

        $this->set('benchMarks', $benchMarks);
    }

}
