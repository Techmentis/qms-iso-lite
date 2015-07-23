<?php

App::uses('AppController', 'Controller');
App::import('Controller', 'HistoriesController');
App::uses('HistoriesController', 'Controller');
App::import('Vendor', 'Spreadsheet_Excel_Reader', array(
    'file' => 'Excel/reader.php'
));
App::import('Vendor', 'PHPExcel', array(
    'file' => 'Excel/PHPExcel.php'
));
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Reports Controller
 *
 * @property Report $Report
 */
class ReportsController extends AppController {

    public $styleHeader = array(
        'font' => array('size' => 16, 'bold' => false, 'color' => array('rgb' => '428BCA'), 'name' => 'Arial'),
        'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffffff')),
        'alignment' => array('wrapText' => true));
    public $styleNil = array(
        'font' => array('bold' => true, 'color' => array('rgb' => 'FFFFFF'), 'name' => 'Arial'),
        'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '428BCA')),
        'alignment' => array('wrapText' => true));
    public $styleBorder = array(
        'borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'),),));

    public function _get_system_table_id() {
        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = - 1;
        $sys_id = $this->SystemTable->find('first', array(
            'conditions' => array(
                'SystemTable.system_name' => $this->request->params['controller']
            )
        ));
        return $sys_id['SystemTable']['id'];
    }

    public function _check_request() {

        $onlyBranch = null;
        $onlyOwn = null;
        $con1 = null;
        $con2 = null;

        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('Report.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Report.created_by' => $this->Session->read('User.id'));

        if ($this->request->params['named']) {
            if ($this->request->params['named']['published'] == null)
                $con1 = null;
            else
                $con1 = array('Report.publish' => $this->request->params['named']['published']);
            if ($this->request->params['named']['soft_delete'] == null)
                $con2 = null;
            else
                $con2 = array('Report.soft_delete' => $this->request->params['named']['soft_delete']);
            if ($this->request->params['named']['soft_delete'] == null)
                $conditions = array($onlyBranch, $onlyOwn, $con1, 'Report.soft_delete' => 0);
            else
                $conditions = array($onlyBranch, $onlyOwn, $con1, $con2);
        }else {
            $conditions = array($onlyBranch, $onlyOwn, null, 'Report.soft_delete' => 0);
        }

        return $conditions;
    }

    public function report() {
        $result = explode('+', $this->request->data['reports']['rec_selected']);
        $this->Report->recursive = 1;
        $reports = $this->Report->find('all', array(
            'Report.publish' => 1,
            'Report.soft_delete' => 1,
            'conditions' => array(
                'or' => array(
                    'Report.id' => $result
                )
            )
        ));
        $this->set('reports', $reports);
        $branches = $this->Report->Branch->find('list', array(
            'conditions' => array(
                'Branch.publish' => 1,
                'Branch.soft_delete' => 0
            )
        ));
        $departments = $this->Report->Department->find('list', array(
            'conditions' => array(
                'Department.publish' => 1,
                'Department.soft_delete' => 0
            )
        ));
        $masterListOfFormats = $this->Report->MasterListOfFormat->find('list', array(
            'conditions' => array(
                'MasterListOfFormat.publish' => 1,
                'MasterListOfFormat.soft_delete' => 0
            )
        ));
        $systemTables = $this->Report->SystemTable->find('list', array(
            'conditions' => array(
                'SystemTable.publish' => 1,
                'SystemTable.soft_delete' => 0
            )
        ));
        $this->set(compact('branches', 'departments', 'masterListOfFormats', 'systemTables', 'branches', 'departments', 'masterListOfFormats', 'systemTables'));
    }

    /**
     * restore method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function restore($id = null) {
        $model_name = $this->modelClass;
        if (!empty($id)) {
            $data['id'] = $id;
            $data['soft_delete'] = 0;
            $model_name = $this->modelClass;
            $this->$model_name->save($data);
        }

        $this->redirect(array(
            'action' => 'index'
        ));
    }

    public function add() {
        if ($this->_show_approvals()) {
            $this->loadModel('User');
            $this->User->recursive = 0;
            $userids = $this->User->find('list', array(
                'order' => array(
                    'User.name' => 'ASC'
                ),
                'conditions' => array(
                    'User.publish' => 1,
                    'User.soft_delete' => 0,
                    'User.is_approvar' => 1
                )
            ));
            $this->set(array(
                'userids' => $userids,
                'show_approvals' => $this->_show_approvals()
            ));
        }

        if ($this->request->is('post')) {
            $this->request->data['Report']['system_table_id'] = $this->_get_system_table_id();
            $this->Report->create();

            $this->loadModel('MasterListOfFormat');
            $m_id = $this->MasterListOfFormat->find('first', array(
                'conditions' => array(
                    'MasterListOfFormat.system_table_id' => $this->_get_system_table_id()
                )
            ));
            if ($this->Report->save($this->request->data)) {

                $this->Session->setFlash(__('The report has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->Report->id));
                else
                    $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('The report could not be saved. Please, try again.'));
            }
        }

        $branches = $this->Report->Branch->find('list', array(
            'conditions' => array(
                'Branch.publish' => 1,
                'Branch.soft_delete' => 0
            )
        ));
        $departments = $this->Report->Department->find('list', array(
            'conditions' => array(
                'Department.publish' => 1,
                'Department.soft_delete' => 0
            )
        ));
        $masterListOfFormats = $this->Report->MasterListOfFormat->find('list', array(
            'conditions' => array(
                'MasterListOfFormat.publish' => 1,
                'MasterListOfFormat.soft_delete' => 0
            )
        ));
        $systemTables = $this->Report->SystemTable->find('list', array(
            'conditions' => array(
                'SystemTable.publish' => 1,
                'SystemTable.soft_delete' => 0
            )
        ));
        $this->set(compact('branches', 'departments', 'masterListOfFormats', 'systemTables'));
        $count = $this->Report->find('count');
        $published = $this->Report->find('count', array(
            'conditions' => array(
                'Report.publish' => 1
            )
        ));
        $unpublished = $this->Report->find('count', array(
            'conditions' => array(
                'Report.publish' => 0
            )
        ));
        $this->set(compact('count', 'published', 'unpublished'));
    }

    public function get_folders() {
        $paths = $this->request->params['pass'];

        foreach ($paths as $p):
            $path = $path . DS . $p;
            $this->set('mId', $p);
        endforeach;
        $dir = new Folder(WWW_ROOT . 'files' . DS . $this->Session->read('User.company_id') . DS . 'SavedReports' . DS . $path . DS);

        $folders = $dir->read(true);
        if ($this->request->params['pass'][0] == 'upload' or $this->request->params['pass'][0] == 'import') {
            $this->loadModel('User');
            foreach ($folders[0] as $folder):
                $getUser = $this->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $folder
                    ),
                    'fields' => array(
                        'User.id',
                        'User.username'
                    )
                ));
                if ($getUser)
                    $getUsers[] = array(
                        $getUser['User']['username'],
                        $getUser['User']['id']
                    );
                else
                    $getUsers[] = array(
                        $folder,
                        $folder
                    );
            endforeach;
            $folders[0] = $getUsers;
        }
        else {
            foreach ($folders[0] as $folder):
                $getfolder[] = array(
                    $folder,
                    $folder
                );
            endforeach;
            $folders[0] = $getfolder;
        }

        $this->set('folders', $folders);
        $this->set('path', $path);
    }

    public function get_file() {
        $path = null;

        $paths = $this->request->params['pass'];

        foreach ($paths as $p):
            $path = $path . DS . $p;
            $this->set('mId', $p);
        endforeach;
        $path = str_replace('<>', ' ', $path);

        $file = new File(WWW_ROOT . 'files' . DS . $this->Session->read('User.company_id') . DS . 'SavedReports' . $path);

        $fileDetails = $file->info();
        $fileChange = $file->lastChange();

        $this->set('fileDetails', $fileDetails);
        $this->set('fileChange', $fileChange);
        $c_file = WWW_ROOT . 'files' . DS . $this->Session->read('User.company_id') . DS . 'SavedReports' . $path;
        $this->set('path', $path);
    }

    public function saved_reports() {
        // get folders
        $dir = new Folder(WWW_ROOT . 'files' . DS . $this->Session->read('User.company_id') . DS . 'SavedReports' . DS);
        $folders = $dir->read(true);
        $this->set('folders', $folders);
        $p = $this->request->params['pass'][0];
        if (!$p)
            $p = "start";
        $this->set('mId', str_replace(" ", "", $p));
    }

    public function report_center() {

        $model_list = array('CorrectivePreventiveAction', 'Meeting', 'ChangeAdditionDeletionRequest', 'Training', 'TrainingNeedIdentification', 'TrainingEvaluation', 'CompetencyMapping', 'CustomerComplaint', 'Calibration', 'CustomerFeedback', 'SupplierRegistration', 'PurchaseOrder', 'DeliveryChallan', 'ListOfAcceptableSupplier', 'ListOfSoftware', 'Housekeeping', 'TaskStatus', 'DatabackupLogbook');
        $weekly_model_list = array('CorrectivePreventiveAction', 'CustomerComplaint', 'Calibration', 'CustomerFeedback', 'PurchaseOrder', 'DeliveryChallan', 'Housekeeping', 'TaskStatus', 'DatabackupLogbook');
        $this->set(compact('model_list', 'weekly_model_list'));
    }

    public function view($id = null) {
        if (!$this->Report->exists($id)) {
            throw new NotFoundException(__('Invalid Report'));
        }
        $options = array('conditions' => array('Report.id' => $id));
        $report = $this->Report->find('first', $options);
        $file = new File($report['Report']['details']);
        $fileDetails = $file->info();

        $this->set(compact('report', 'fileDetails', 'file'));
    }

    public function _get_count() {
        $onlyBranch = null;
        $onlyOwn = null;
        $condition = null;

        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('Report.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Report.created_by' => $this->Session->read('User.id'));
        $conditions = array($onlyBranch, $onlyOwn);

        $count = $this->Report->find('count', array('conditions' => $condition));
        $published = $this->Report->find('count', array('conditions' => array($condition, 'Report.publish' => 1, 'Report.soft_delete' => 0)));
        $unpublished = $this->Report->find('count', array('conditions' => array($condition, 'Report.publish' => 0, 'Report.soft_delete' => 0)));
        $deleted = $this->Report->find('count', array('conditions' => array($condition, 'Report.soft_delete' => 1)));
        $this->set(compact('count', 'published', 'unpublished', 'deleted'));
    }

    public function data_entry_report() {
        $date = date("Y-m-d 00:00:00", strtotime($this->data['reports']['from']));
        $end_date = date("Y-m-d 00:00:00", strtotime($this->data['reports']['to']));

        $this->loadModel('User');
        $this->User->recursive = - 1;
        $users = $this->User->find('all', array(
            'conditions' => array(
                'User.publish' => 1,
                'User.soft_delete' => 0
            ),
            'fields' => array(
                'User.id',
                'User.username',
                'User.name',
                'User.benchmark'
            )
        ));
        $this->loadModel('History');
        $i = 0;
        $total = 0;
        $recs = 0;
        foreach ($users as $user):
            $histories = $this->History->find('count', array(
                'conditions' => array(
                    'History.created_by' => $user['User']['id'],
                    'History.post_values <> ' => '[[],[]]',
                    'Or' => array('History.action' => array('add', 'add_ajax', 'add_new_ajax', 'audit_details_add_ajax')),
                    'History.created BETWEEN ? AND ? ' => array($date, $end_date)
                )
            ));
            $userDetails[$i]['User'] = $user;
            $userDetails[$i]['Data'] = $histories;
            $total = $total + $user['User']['benchmark'];
            $recs = $recs + $histories;
            $i++;
        endforeach;
        $this->set(compact('userDetails', 'total', 'recs'));

        $this->loadModel('Branch');
        $this->Branch->recursive = - 1;
        $branches = $this->Branch->find('all', array(
            'conditions' => array(
                'Branch.publish' => 1,
                'Branch.soft_delete' => 0
            )
        ));
        $this->loadModel('Department');
        $this->Department->recursive = - 1;
        $departments = $this->Department->find('all', array(
            'conditions' => array(
                'Department.publish' => 1,
                'Department.soft_delete' => 0
            )
        ));
        $this->loadModel('Benchmark');
        $this->Benchmark->recursive = - 1;
        $i = 0;
        $j = 0;
        foreach ($branches as $branch):
            $bd = 0;
            $branchDetails[$i]['Branch'] = $branch;
            $b = 0;
            $j = 0;
            foreach ($departments as $department):
                $histories = $this->History->find('count', array(
                    'conditions' => array(
                        'History.branchid' => $branch['Branch']['id'],
                        'History.departmentid' => $department['Department']['id'],
                        'Or' => array('History.action' => array('add', 'add_ajax', 'add_new_ajax', 'audit_details_add_ajax')),
                        'History.post_values <> ' => '[[],[]]',
                        'History.created between ? and ? ' => array($date, $end_date))
                ));
                $benchmack = $this->Benchmark->find('first', array(
                    'conditions' => array(
                        'Benchmark.branch_id' => $branch['Branch']['id'],
                        'Benchmark.department_id' => $department['Department']['id']
                    )
                ));
                $b = $b + $benchmack['Benchmark']['benchmark'];
                $d[$j]['Department'] = $department;
                $d[$j]['Benchmark'] = $benchmack;
                $d[$j]['Data'] = $histories;
                $bd = $bd + $histories;
                $j++;
            endforeach;
            $branchDetails[$i]['Branch']['Department'] = $d;
            $branchDetails[$i]['Branch']['Benchmark'] = $b;
            $branchDetails[$i]['Branch']['Data'] = $bd;
            $j = 0;
            $i++;
        endforeach;
        $this->set(compact('branchDetails'));
    }

    public function nc_report() {
        if($this->request->data['reports']['from']== null && $this->request->data['reports']['to'] == null){
                $from = date('Y-m-d 00:00:00');
                $to = date("Y-m-d 00:00:00", strtotime("+1 day", strtotime($from)));
                $this->request->data['reports']['from'] = date('m/d/Y',  strtotime($from));
                $this->request->data['reports']['to'] = date('m/d/Y',  strtotime($to));;
        }else{
        $from = date('Y-m-d h:i:s', strtotime($this->request->data['reports']['from']));
        $to = date('Y-m-d h:i:s', strtotime($this->request->data['reports']['to']));
         }   
        $this->loadModel('CorrectivePreventiveAction');
        $this->CorrectivePreventiveAction->recursive = 1;
        $capas = $this->CorrectivePreventiveAction->find('all', array(
            'conditions' => array(
                'CorrectivePreventiveAction.publish' => 1,
                'CorrectivePreventiveAction.soft_delete' => 0,
                'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            ),
            'order' => array(
                'CorrectivePreventiveAction.created' => 'DESC'
            )
        ));
        $this->set('correctivePreventiveActions', $capas);

        // CAPA by source
        $capaSources = $this->CorrectivePreventiveAction->CapaSource->find('list');
        foreach ($capaSources as $key => $value):
            $capa_source_wise[$value] = $this->CorrectivePreventiveAction->find('count', array(
                'conditions' => array(
                    'CorrectivePreventiveAction.publish' => 1,
                    'CorrectivePreventiveAction.soft_delete' => 0,
                    'CorrectivePreventiveAction.capa_source_id' => $key,
                    'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                        $from,
                        $to
                    )
                ),
                'order' => array(
                    'CorrectivePreventiveAction.created' => 'DESC'
                )
            ));
        endforeach;
        $this->set('capa_source_wise', $capa_source_wise);

        // CAPA by category
        $capaCategories = $this->CorrectivePreventiveAction->CapaCategory->find('list');
        foreach ($capaCategories as $key => $value):
            $capa_category_wise[$value] = $this->CorrectivePreventiveAction->find('count', array(
                'conditions' => array(
                    'CorrectivePreventiveAction.publish' => 1,
                    'CorrectivePreventiveAction.soft_delete' => 0,
                    'CorrectivePreventiveAction.capa_category_id' => $key,
                    'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                        $from,
                        $to
                    )
                ),
                'order' => array(
                    'CorrectivePreventiveAction.created' => 'DESC'
                )
            ));
        endforeach;
        $this->set('capa_category_wise', $capa_category_wise);

        $capa_closed = $this->CorrectivePreventiveAction->find('count', array(
            'conditions' => array(
                'CorrectivePreventiveAction.publish' => 1,
                'CorrectivePreventiveAction.soft_delete' => 0,
                'CorrectivePreventiveAction.current_status' => '1',
                'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            )
        ));
        $capa_open = $this->CorrectivePreventiveAction->find('count', array(
            'conditions' => array(
                'CorrectivePreventiveAction.publish' => 1,
                'CorrectivePreventiveAction.soft_delete' => 0,
                'CorrectivePreventiveAction.current_status <> ' => '1',
                'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            )
        ));
        $capa_root = $this->CorrectivePreventiveAction->find('count', array(
            'conditions' => array(
                'CorrectivePreventiveAction.publish' => 1,
                'CorrectivePreventiveAction.soft_delete' => 0,
                'CorrectivePreventiveAction.root_cause_analysis_required' => 1,
                'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            )
        ));
        $this->set(compact('capa_closed', 'capa_open', 'capa_root'));
    }

    function advanced_search() {

        $conditions = array();
        if ($this->request->query['keywords']) {
            $search_array = array();
            if ($this->request->query['strict_search'] == 0) {
                $search_keys[] = $this->request->query['keywords'];
            } else {
                $search_keys = explode(" ", $this->request->query['keywords']);
            }

            foreach ($search_keys as $search_key):
                foreach ($this->request->query['search_fields'] as $search):
                    if ($this->request->query['strict_search'] == 0)
                        $search_array[] = array(
                            'Report.' . $search => $search_key
                        );
                    else
                        $search_array[] = array(
                            'Report.' . $search . ' like ' => '%' . $search_key . '%'
                        );
                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array(
                    'and' => array('or' => $search_array)
                );
            else
                $conditions[] = array(
                    'or' => $search_array
                );
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branch_conditions[] = array(
                    'Report.branch_id' => $branches
                );
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('or' => $branch_conditions));
            else
                $conditions[] = array('or' => $branch_conditions);
        }
        if ($this->request->query['master_list_id'] != -1) {

            $master_list_conditions = array('Report.master_list_of_format_id' => $this->request->query['master_list_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $master_list_conditions);
            else
                $conditions[] = array('or' => $master_list_conditions);
            echo'true' . $this->request->query['master_list_id'] . '==';
        }
        if ($this->request->query['department_id'] != -1) {
            $department_id_conditions = array('Report.department_id' => $this->request->query['department_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $department_id_conditions);
            else
                $conditions[] = array('or' => $department_id_conditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array(
                'Report.report_date >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])),
                'Report.report_date <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date']))
            );
        }

        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);
        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array(
                'Report.branch_id' => $this->Session->read('User.branch_id')
            );
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array(
                'Report.created_by' => $this->Session->read('User.id')
            );
        $conditions[] = array(
            $onlyBranch,
            $onlyOwn
        );
        $this->Report->recursive = 0;
        $this->paginate = array(
            'order' => array(
                'Report.sr_no' => 'DESC'
            ),
            'conditions' => $conditions,
            'Report.soft_delete' => 0
        );
        $this->set('reports', $this->paginate());
        $this->render('index');
    }

    public function nc_report_history() {
        $this->loadModel('CorrectivePreventiveAction');
        $this->CorrectivePreventiveAction->recursive = 1;
        $from = date('Y-1-1 h:i:s');
        $to = date('Y-12-31 h:i:s');
        $this->loadModel('CustomerComplaint');
        while ($from <= $to) {
            $capas = $this->CorrectivePreventiveAction->find('count', array(
                'conditions' => array(
                    'CorrectivePreventiveAction.publish' => 1,
                    'CorrectivePreventiveAction.soft_delete' => 0,
                    'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                        $from,
                        date('Y-m-31', strtotime($from))
                    )
                ),
                'order' => array(
                    'CorrectivePreventiveAction.created' => 'DESC'
                )
            ));
            $capa_closed = $this->CorrectivePreventiveAction->find('count', array(
                'conditions' => array(
                    'CorrectivePreventiveAction.publish' => 1,
                    'CorrectivePreventiveAction.soft_delete' => 0,
                    'CorrectivePreventiveAction.current_status' => '1',
                    'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                        $from,
                        date('Y-m-31', strtotime($from))
                    )
                )
            ));
            $capa_open = $this->CorrectivePreventiveAction->find('count', array(
                'conditions' => array(
                    'CorrectivePreventiveAction.publish' => 1,
                    'CorrectivePreventiveAction.soft_delete' => 0,
                    'CorrectivePreventiveAction.current_status <> ' => '1',
                    'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                        $from,
                        date('Y-m-31', strtotime($from))
                    )
                )
            ));
            $capa_root = $this->CorrectivePreventiveAction->find('count', array(
                'conditions' => array(
                    'CorrectivePreventiveAction.publish' => 1,
                    'CorrectivePreventiveAction.soft_delete' => 0,
                    'CorrectivePreventiveAction.root_cause_analysis_required' => 1,
                    'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                        $from,
                        date('Y-m-31', strtotime($from))
                    )
                )
            ));
            $output[] = array(
                $from,
                $capas,
                $capa_closed,
                $capa_open,
                $capa_root
            );
            $from = date("Y-m-d", strtotime("+1 month", strtotime($from)));
        }

        $data = "[['Date','Total','Close','Open','Root Cause'],";
        foreach ($output as $graph_data):
            $data.= "['" . date('M-y', strtotime($graph_data[0])) . "'," . $graph_data[1] . "," . $graph_data[2] . "," . $graph_data[3] . "," . $graph_data[4] . "],";
        endforeach;
        $data.= "]]";
        $data = str_replace("],]]", "]]", $data);
        $this->set(array(
            'data' => $data
        ));
    }

    public function customer_complaint_report() {
        if($this->request->data['reports']['from']== null && $this->request->data['reports']['to'] == null){
            $from = date('Y-m-d 00:00:00');
            $to = date("Y-m-d 00:00:00", strtotime("+1 day", strtotime($from)));
            $this->request->data['reports']['from'] = date('m/d/Y',  strtotime($from));
            $this->request->data['reports']['to'] = date('m/d/Y',  strtotime($to));;
        }else{
            $from = date('Y-m-d h:i:s', strtotime($this->request->data['reports']['from']));
            $to = date('Y-m-d h:i:s', strtotime($this->request->data['reports']['to']));
         }  

        $this->loadModel('CustomerComplaint');
        $customerComplaints = $this->CustomerComplaint->find('all', array(
            'conditions' => array(
                'CustomerComplaint.publish' => 1,
                'CustomerComplaint.soft_delete' => 0,
                'CustomerComplaint.complaint_date BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            )
        ));
        $this->set(compact('customerComplaints'));
        $open = $this->CustomerComplaint->find('count', array(
            'conditions' => array(
                'CustomerComplaint.publish' => 1,
                'CustomerComplaint.soft_delete' => 0,
                'CustomerComplaint.current_status' => 0,
                'CustomerComplaint.complaint_date BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            ),
            'order' => array(
                'CustomerComplaint.complaint_date' => 'DESC'
            )
        ));
        $closed = $this->CustomerComplaint->find('count', array(
            'conditions' => array(
                'CustomerComplaint.publish' => 1,
                'CustomerComplaint.soft_delete' => 0,
                'CustomerComplaint.current_status <> ' => 0,
                'CustomerComplaint.complaint_date BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            )
        ));
        $setteled = $this->CustomerComplaint->find('count', array(
            'conditions' => array(
                'CustomerComplaint.publish' => 1,
                'CustomerComplaint.soft_delete' => 0,
                'CustomerComplaint.current_status <> ' => 0,
                'CustomerComplaint.complaint_date BETWEEN ? AND ? ' => array(
                    $from,
                    date('Y-m-31', strtotime($from)),
                    'CustomerComplaint.settled_date <= CustomerComplaint.target_date '
                )
            )
        ));
        $all_complaints = count($customerComplaints);
        $this->set(compact('all_complaints', 'open', 'closed', 'setteled'));
    }

    public function customer_complaint_history() {
        $from = date('Y-1-1 h:i:s');
        $to = date('Y-12-31 h:i:s');
        $this->loadModel('CustomerComplaint');

        while ($from <= $to) {

            $customerComplaints = $this->CustomerComplaint->find('count', array(
                'conditions' => array(
                    'CustomerComplaint.publish' => 1,
                    'CustomerComplaint.soft_delete' => 0,
                    'CustomerComplaint.complaint_date BETWEEN ? AND ? ' => array(
                        $from,
                        date('Y-m-31', strtotime($from))
                    )
                )
            ));
            $this->set(compact('customerComplaints'));
            $open = $this->CustomerComplaint->find('count', array(
                'conditions' => array(
                    'CustomerComplaint.publish' => 1,
                    'CustomerComplaint.soft_delete' => 0,
                    'CustomerComplaint.current_status' => 0,
                    'CustomerComplaint.complaint_date BETWEEN ? AND ? ' => array(
                        $from,
                        date('Y-m-31', strtotime($from))
                    )
                ),
                'order' => array(
                    'CustomerComplaint.complaint_date' => 'DESC'
                )
            ));
            $closed = $this->CustomerComplaint->find('count', array(
                'conditions' => array(
                    'CustomerComplaint.publish' => 1,
                    'CustomerComplaint.soft_delete' => 0,
                    'CustomerComplaint.current_status <> ' => 0,
                    'CustomerComplaint.complaint_date BETWEEN ? AND ? ' => array(
                        $from,
                        date('Y-m-31', strtotime($from))
                    )
                )
            ));
            $setteled = $this->CustomerComplaint->find('count', array(
                'conditions' => array(
                    'CustomerComplaint.publish' => 1,
                    'CustomerComplaint.soft_delete' => 0,
                    'CustomerComplaint.current_status <> ' => 0,
                    'CustomerComplaint.complaint_date BETWEEN ? AND ? ' => array(
                        $from,
                        date('Y-m-31', strtotime($from)),
                        'CustomerComplaint.settled_date <= CustomerComplaint.target_date '
                    )
                )
            ));
            $output[] = array(
                $from,
                $customerComplaints,
                $open,
                $closed,
                $setteled
            );
            $from = date("Y-m-d", strtotime("+1 month", strtotime($from)));
        }

        $data = "[['Date','Total','Open','Close','Setteled In Time'],";
        foreach ($output as $graph_data):
            $data.= "['" . date('M-y', strtotime($graph_data[0])) . "'," . $graph_data[1] . "," . $graph_data[2] . "," . $graph_data[3] . "," . $graph_data[4] . "],";
        endforeach;
        $data.= "]]";
        $data = str_replace("],]]", "]]", $data);
        $this->set(array(
            'data' => $data
        ));
    }

    public function create_header($newModelName = null, $recs = null) {
        $this->loadModel('SystemTable');
        $system_table_ids = $this->SystemTable->find('first', array(
            'conditions' => array(
                'SystemTable.system_name' => Inflector::tableize($newModelName)
            ),
            'fields' => array(
                'SystemTable.id'
            ),
            'recursive' => - 1
        ));

        if (isset($system_table_ids)) {
            if (isset($system_table_ids['SystemTable']['id']) && $system_table_ids['SystemTable']['id'] != null) {
                $this->loadModel('MasterListOfFormat');
                $format_header = $this->MasterListOfFormat->find('first', array(
                    'conditions' => array(
                        'MasterListOfFormat.system_table_id' => $system_table_ids['SystemTable']['id']
                    ),
                    'fields' => array(
                        'MasterListOfFormat.title',
                        'MasterListOfFormat.document_number',
                        'MasterListOfFormat.issue_number',
                        'MasterListOfFormat.revision_number',
                        'MasterListOfFormat.revision_date',
                        'PreparedBy.name',
                        'ApprovedBy.name',
                        'Department.name'
                    ),
                    'recursive' => 0
                ));
                if (isset($format_header) && $format_header != null) {
                    return $format_header;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function create_xls_file($filename = null, $path = null, $objPHPExcel = null, $type = null) {
        if($type){
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; ; charset=utf8-bin');
            header('Content-Disposition: attachment;filename="' . $filename . '');
            header('Cache-Control: max-age=10');
            header("Pragma: public");
            header("Expires: 0");
            header("Content-Type: application/vnd.ms-excel; charset=utf8-bin");
            header("Content-Type: application/force-download");
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $folder = new Folder();
        if (isset($_ENV['company_id']) && $_ENV['company_id'] != null) {
            $folder->create(WWW_ROOT . "files" . DS . $_ENV['company_id'] . DS . "Reports" . DS . $path, 0777);
            if ($type)
                $objWriter->save('php://output');
            else
                $objWriter->save(WWW_ROOT . 'files' . DS. $_ENV['company_id'] . DS .'Reports' . DS . $path . DS . $filename);
        }else {
            $folder->create(WWW_ROOT . "files" . DS . $this->Session->read('User.company_id') . DS . "Reports" . DS . $path, 0777);
            if ($type)
                $objWriter->save('php://output');
            else
                $objWriter->save(WWW_ROOT . 'files' . DS . $this->Session->read('User.company_id') . DS . 'Reports' . DS . $path . DS . $filename);
        }
        return 1;
    }

    public function daily_data_entry_export() {
        $this->_generate_daily_data_entry_report($this->request->data['Report']['from'], $this->request->data['Report']['to'], true);
        return 1;
        
    }

    public function _generate_daily_data_entry_report($from = null, $to = null, $type = null, $Data = null, $recs = null, $data = null) {
        if ($from == null && $to == null) {
            $from = date('Y-m-d 00:00:00');
            $filename = date('Y-m-d') . "-FlinkISO_DailyDataEntryReport.xls";
            $to = date("Y-m-d 00:00:00", strtotime("+1 day", strtotime($from)));
        } else {
            $from = date("Y-m-d 00:00:00", strtotime($from));
            $filename = date('Y-m-d',strtotime($from)) . "-FlinkISO_DailyDataEntryReport.xls";
            $to = date("Y-m-d 00:00:00", strtotime("+1 day", strtotime($from)));
        }

        $this->loadModel('User');
        $this->User->recursive = - 1;
        $users = $this->User->find('all', array(
            'conditions' => array(
                'User.publish' => 1,
                'User.soft_delete' => 0
            ),
            'fields' => array(
                'User.id',
                'User.username',
                'User.name',
                'User.benchmark'
            )
        ));
        $this->loadModel('History');
        $i = 0;
        $total = 0;
        foreach ($users as $user):
            $histories = $this->History->find('count', array(
                'conditions' => array(
                    'History.created_by' => $user['User']['id'],
                    'Or' => array('History.action' => array('add', 'add_ajax', 'add_new_ajax', 'audit_details_add_ajax')),
                    'History.post_values <> ' => '[[],[]]',
                    'History.created BETWEEN ? AND ? ' => array(
                        $from,
                        $to
                    )
                )
            ));

            $userDetails[$i]['User'] = $user;
            $userDetails[$i]['Data'] = $histories;
            $total = $total + $user['User']['benchmark'];
            $recs = $recs + $histories;
            $i++;
        endforeach;

        $this->loadModel('Branch');
        $this->Branch->recursive = - 1;
        $branches = $this->Branch->find('all', array(
            'conditions' => array(
                'Branch.publish' => 1,
                'Branch.soft_delete' => 0
            )
        ));
        $this->loadModel('Department');
        $this->Department->recursive = - 1;
        $departments = $this->Department->find('all', array(
            'conditions' => array(
                'Department.publish' => 1,
                'Department.soft_delete' => 0
            )
        ));
        $this->loadModel('Benchmark');
        $this->Benchmark->recursive = - 1;
        $i = 0;
        $j = 0;
        foreach ($branches as $branch):
            $bd = 0;
            $branchDetails[$i]['Branch'] = $branch;
            $b = 0;
            $j = 0;
            foreach ($departments as $department):
                $histories = $this->History->find('count', array(
                    'conditions' => array(
                        'History.branchid' => $branch['Branch']['id'],
                        'History.departmentid' => $department['Department']['id'],
                        'Or' => array('History.action' => array('add', 'add_ajax', 'add_new_ajax', 'audit_details_add_ajax')),
                        'History.post_values <> ' => '[[],[]]',
                        'History.created BETWEEN ? AND ? ' => array(
                            $from,
                            $to
                        )
                    )
                ));
                $benchmack = $this->Benchmark->find('first', array(
                    'conditions' => array(
                        'Benchmark.branch_id' => $branch['Branch']['id'],
                        'Benchmark.department_id' => $department['Department']['id']
                    )
                ));
                if (!isset($benchmack['Benchmark']['benchmark']))
                    $benchmack['Benchmark']['benchmark'] = "0";
                $b = $b + $benchmack['Benchmark']['benchmark'];
                $d[$j]['Department'] = $department;
                $d[$j]['Benchmark'] = $benchmack;
                $d[$j]['Data'] = $histories;
                $bd = $bd + $histories;
                $j++;
            endforeach;
            $branchDetails[$i]['Branch']['Department'] = $d;
            $branchDetails[$i]['Branch']['Benchmark'] = $b;
            $branchDetails[$i]['Branch']['Data'] = $bd;
            $j = 0;
            $i++;
        endforeach;

        $i = 0;
        $j = 0;
        $users_header = array(
            'Date',
            'Employee',
            'User Name',
            'Benchmark',
            'Data Added'
        );

        foreach ($userDetails as $user):

            if ($user['Data'] == null or $user['Data'] == 0)
                $user['Data'] = "0";
            $users_data[] = array(
                date('Y-m-d'),
                $user['User']['User']['username'],
                $user['User']['User']['name'],
                $user['User']['User']['benchmark'],
                $user['Data']
            );
            $j++;
        endforeach;

        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("FlinkISO")->setLastModifiedBy("FlinkISO")->setTitle("FlinkISO Daily Data Entry Report")->setSubject("Office 2007 XLSX Test Document")->setDescription("These are standard import formats for data to be importaed to flinkISO application")->setKeywords("office 2007 openxml php")->setCategory("FlinkISO");

        $objPHPExcel->setActiveSheetIndex(0)->setTitle("DailyDataEntry");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'FlinkISO Daily Data Entry Report');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:D1')->applyFromArray($this->styleHeader);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(25);

        $objPHPExcel->setActiveSheetIndex(0)->fromArray($users_header, NULL, 'A2');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:D1')->applyFromArray($this->styleNil);
        $x = 4;
        foreach ($users_data as $data):
            $objPHPExcel->setActiveSheetIndex(0)->fromArray($users_data, NULL, 'A' . $x);
            $x++;
        endforeach;
        $x = $x + 2;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x, 'Branch Wise');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $x . ':D' . $x);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $x . ':D' . $x)->applyFromArray($this->styleHeader);
        $x = $x + 2;
        foreach ($branchDetails as $data):
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $x . ':D' . $x);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x, $data['Branch']['Branch']['name']);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $x . ':D' . $x)->applyFromArray($this->styleHeader);
            $x = $x + 2;
            $branch_headers = array(
                'Department',
                'Benchmark',
                'Department Data',
                'Total'
            );
            $objPHPExcel->setActiveSheetIndex(0)->fromArray($branch_headers, NULL, 'A' . $x);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $x . ':D' . $x)->applyFromArray($this->styleNil);
            $x = $x + 2;

            foreach ($data['Branch']['Department'] as $departments):

                if (isset($data['Data'])) {
                    if ($data['Data'] == null or $data['Data'] == 0)
                        $data['Data'] = "0";
                } else
                    $data['Data'] = 0;

                if ($departments['Data'] == null or $departments['Data'] == 0)
                    $departments['Data'] = "0";
                if (!isset($departments['Benchmark']['Benchmark']) && !isset($departments['Benchmark']['Benchmark']['benchmark']))
                    $departments['Benchmark']['Benchmark']['benchmark'] = "0";
                if (!isset($departments['Department']['Department']) && !isset($departments['Department']['Department']['name']))
                    $departments['Benchmark']['Benchmark']['name'] = "";
                $branch_data = array(
                    $departments['Department']['Department']['name'],
                    $departments['Benchmark']['Benchmark']['benchmark'],
                    $departments['Data'],
                    $data['Data']
                );
                $objPHPExcel->setActiveSheetIndex(0)->fromArray($branch_data, NULL, 'A' . $x);
                $x++;
            endforeach;
            $x++;
        endforeach;
        
        $path = 'DailyDataEntry' . DS .str_replace(" 00:00:00","",$from);
        $this->create_xls_file($filename, $path, $objPHPExcel, $type);
        return 1;
    }

    public function _weekly_nc_report($from = null,$to = null) {
        if($from == null && $to == null){
            $from = date('Y-m-d 00:00:00');
            $to = date("Y-m-d 00:00:00", strtotime("-7 days", strtotime($from)));
            $filename = date('Y-m-d') . "-FlinkISO_WeeklyNCReport.xls";
        }else{
            $from = $from;
            $to = $to;
            $filename = date('Y-m-d',  strtotime($from)) . "-FlinkISO_WeeklyNCReport.xls";
        }
        $this->loadModel('CorrectivePreventiveAction');
        $this->CorrectivePreventiveAction->recursive = 1;
        $capas = $this->CorrectivePreventiveAction->find('all', array(
            'conditions' => array(
                'CorrectivePreventiveAction.publish' => 1,
                'CorrectivePreventiveAction.soft_delete' => 0,
                'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            ),
            'order' => array(
                'CorrectivePreventiveAction.created' => 'DESC'
            )
        ));

        // CAPA by source
        $capaSources = $this->CorrectivePreventiveAction->CapaSource->find('list');
        foreach ($capaSources as $key => $value):
            $capa_source_wise[$value] = $this->CorrectivePreventiveAction->find('count', array(
                'conditions' => array(
                    'CorrectivePreventiveAction.publish' => 1,
                    'CorrectivePreventiveAction.soft_delete' => 0,
                    'CorrectivePreventiveAction.capa_source_id' => $key,
                    'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                        $from,
                        $to
                    )
                ),
                'order' => array(
                    'CorrectivePreventiveAction.created' => 'DESC'
                )
            ));
        endforeach;
        $capaCategories = $this->CorrectivePreventiveAction->CapaCategory->find('list');
        foreach ($capaCategories as $key => $value):
            $capa_category_wise[$value] = $this->CorrectivePreventiveAction->find('count', array(
                'conditions' => array(
                    'CorrectivePreventiveAction.publish' => 1,
                    'CorrectivePreventiveAction.soft_delete' => 0,
                    'CorrectivePreventiveAction.capa_category_id' => $key,
                    'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                        $from,
                        $to
                    )
                ),
                'order' => array(
                    'CorrectivePreventiveAction.created' => 'DESC'
                )
            ));
        endforeach;
        $capa_closed = $this->CorrectivePreventiveAction->find('count', array(
            'conditions' => array(
                'CorrectivePreventiveAction.publish' => 1,
                'CorrectivePreventiveAction.soft_delete' => 0,
                'CorrectivePreventiveAction.current_status' => '1',
                'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            )
        ));
        $capa_open = $this->CorrectivePreventiveAction->find('count', array(
            'conditions' => array(
                'CorrectivePreventiveAction.publish' => 1,
                'CorrectivePreventiveAction.soft_delete' => 0,
                'CorrectivePreventiveAction.current_status <> ' => '1',
                'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            )
        ));
        $capa_root = $this->CorrectivePreventiveAction->find('count', array(
            'conditions' => array(
                'CorrectivePreventiveAction.publish' => 1,
                'CorrectivePreventiveAction.soft_delete' => 0,
                'CorrectivePreventiveAction.root_cause_analysis_required' => 1,
                'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            )
        ));

        // writing to file
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("FlinkISO")->setLastModifiedBy("FlinkISO")->setTitle("FlinkISO Daily Data Entry Report")->setSubject("Office 2007 XLSX Test Document")->setDescription("These are standard import formats for data to be importaed to flinkISO application")->setKeywords("office 2007 openxml php")->setCategory("FlinkISO");
        $main_header = array(
            'CAPA Number',
            'Source',
            'Category',
            'Target Date',
            'Completed Date',
            'Current Status',
            'Document Change Required',
            'Root Cause Analysis Required'
        );
        $objPHPExcel->setActiveSheetIndex(0)->setTitle("WeeklyNCReport");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'FlinkISO Weekly NC Report');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:J1')->applyFromArray($this->styleHeader);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(25);
        $format_header = $this->create_header('CorrectivePreventiveAction');
        if ($format_header) {
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:J3');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A3", $format_header['MasterListOfFormat']['title'])->getStyle("A3:J3")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:C4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A4", "Document Number")->getStyle("A4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D4", $format_header['MasterListOfFormat']['document_number'])->getStyle("D4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:C5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A5", "Revision Number")->getStyle("A5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D5", $format_header['MasterListOfFormat']['revision_number'])->getStyle("D5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:C6');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A6", "Revision Date")->getStyle("A6")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D6", $format_header['MasterListOfFormat']['revision_date'])->getStyle("D6")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:G4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F4", "Prepared By")->getStyle("F4:F4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F5:G5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F5", "Approved By")->getStyle("F5:G5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H4:J4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H4", $format_header['PreparedBy']['name'])->getStyle("H4:J4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H5:J5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H5", $format_header['PreparedBy']['name'])->getStyle("H5:J5")->applyFromArray($this->styleBorder);

            $objPHPExcel->setActiveSheetIndex(0)->fromArray($main_header, NULL, 'A8');
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A8:J8')->applyFromArray($this->styleNil);
            $x = 9;
        } else {
            $objPHPExcel->setActiveSheetIndex(0)->fromArray($main_header, NULL, 'A3');
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A3:J3')->applyFromArray($this->styleNil);
            $x = 4;
        }

        // Adding CAPA Details
        foreach ($capas as $capa):
            $capa_details = array(
                $capa['CorrectivePreventiveAction']['number'],
                $capa['CapaSource']['name'],
                $capa['CapaCategory']['name'],
                $capa['CorrectivePreventiveAction']['target_date'],
                $capa['CorrectivePreventiveAction']['completed_on_date'],
                $capa['CorrectivePreventiveAction']['current_status'],
                $capa['CorrectivePreventiveAction']['document_changes_required'],
                $capa['CorrectivePreventiveAction']['root_cause_analisys_required']
            );
            $objPHPExcel->setActiveSheetIndex(0)->fromArray($capa_details, NULL, 'A' . $x);
            $x++;
        endforeach;
        $capa_details;

        $x = $x + 2;
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $x . ':' . 'C' . $x);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x, 'OPEN CAPAS : ' . $capa_open);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $x . ':' . 'C' . $x)->applyFromArray($this->styleHeader);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(45);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E' . $x . ':' . 'G' . $x);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $x, 'CLOSE CAPAS : ' . $capa_closed);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('E' . $x . ':' . 'G' . $x)->applyFromArray($this->styleHeader);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(45);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I' . $x . ':' . 'O' . $x);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $x, 'ROOT CAUSE ANALYSIS REQUIRED : ' . $capa_root);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I' . $x . ':' . 'O' . $x)->applyFromArray($this->styleHeader);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(45);
        $x = $x + 3;
        $ct = $x;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x, 'CAPA SOURCE WISE');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $x . ':D' . $x);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $x . ':D' . $x)->applyFromArray($this->styleHeader);
        $x = $x + 1;
        $capa_source_array = array(
            'CAPA Source',
            'Count'
        );
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $x . ':' . 'B' . $x);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x, 'CAPA Source');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $x . ':' . 'B' . $x)->applyFromArray($this->styleNil);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $x, 'Count');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C' . $x)->applyFromArray($this->styleNil);
        $x = $x + 1;
        $total = 0;
        foreach ($capa_source_wise as $key => $value):
            $capa_source_details = array(
                $key,
                $value
            );
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $x . ':' . 'B' . $x);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x, $key);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $x, $value);
            $total = $total + $value;
            $x++;
        endforeach;
        $x = $x + 1;
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $x . ':B' . $x);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x, 'Total');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $x, $total);
        $x = $x + 1;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $ct, 'CAPA CATEGORY WISE');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F' . $ct . ':I' . $ct);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F' . $ct . ':I' . $ct)->applyFromArray($this->styleHeader);
        $ct = $ct + 1;
        $capa_source_array = array(
            'CAPA Category',
            'Count'
        );
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F' . $ct . ':H' . $ct);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $ct, 'CAPA Category');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F' . $ct . ':H' . $ct)->applyFromArray($this->styleNil);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $ct, 'Count');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I' . $ct)->applyFromArray($this->styleNil);
        $ct = $ct + 1;
        $total = 0;
        if (isset($capa_category_wise))
            foreach ($capa_category_wise as $key => $value):
                $capa_source_details = array(
                    $key,
                    $value
                );
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F' . $ct . ':H' . $ct);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $ct, $key);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $ct, $value);
                $total = $total + $value;
                $ct++;
            endforeach;
        $ct = $ct + 1;
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F' . $ct . ':H' . $ct);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $ct, 'Total');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $ct, $total);
        $ct = $ct + 1;

        $path = 'WeeklyNCReport' . DS .str_replace(" 00:00:00", "", $from);
        $this->create_xls_file($filename, $path, $objPHPExcel);
        return 1;
    }

    public function daily_data_backups_export($from=null, $to = null) {
        $this->_daily_data_backups($from, $to, true);
        
    }

    public function _daily_data_backups($from = null, $to = null, $type = null, $backups = null) {
        if ($from == null && $to == null) {
            $from = date('Y-m-d');
            $to = date("Y-m-d", strtotime("+1 days", strtotime($from)));
            $filename = date('Y-m-d') . "-FlinkISO_DatabackupLogbookReport.xls";
        } else {
            $from = date("Y-m-d",  strtotime($from));
            $to = date("Y-m-d", strtotime("+1 days", strtotime($from)));
            $filename = date('Y-m-d',  strtotime($from)) . "-FlinkISO_DatabackupLogbookReport.xls";
        }

        $this->loadModel('DailyBackupDetail');
        $this->loadModel('DatabackupLogbook');
        $this->DatabackupLogbook->recursive = 0;
        $this->DailyBackupDetail->recursive = 0;
        $databackups = $this->DailyBackupDetail->find('all', array(
            'conditions' => array(
                'DailyBackupDetail.publish' => 1,
                'DailyBackupDetail.soft_delete' => 0,
                'DataBackUp.schedule_id' => '52487014-1448-45ae-82c3-4f1fc6c3268c'
            )
        ));
        $i = 0;
        foreach ($databackups as $backup):

            $backups[$i]['Details'] = $backup;
            $backups[$i]['Actual'] = $this->DatabackupLogbook->find('first', array(
                'conditions' => array(
                    'DatabackupLogbook.publish' => 1,
                    'DatabackupLogbook.soft_delete' => 0,
                    'DatabackupLogbook.backup_date BETWEEN ? AND ? ' => array(
                        $from,
                        $to
                    ),
                    'DatabackupLogbook.daily_backup_detail_id' => $backup['DailyBackupDetail']['id']
                )
            ));
            $i++;
        endforeach;

        $objPHPExcel = new PHPExcel();

        // Set document properties

        $objPHPExcel->getProperties()->setCreator("FlinkISO")->setLastModifiedBy("FlinkISO")->setTitle("FlinkISO Daily Backup Report")->setSubject("Office 2007 XLSX Test Document")->setDescription("These are standard import formats for data to be importaed to flinkISO application")->setKeywords("office 2007 openxml php")->setCategory("FlinkISO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'FlinkISO Databackup Logbook');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:E1')->applyFromArray($this->styleHeader);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(25);
        $main_header = array(
            'Backup Details',
            'Employee',
            'Task Performed ?',
            'Date',
            'Comments'
        );
        $format_header = $this->create_header('DatabackupLogbook');
        if ($format_header) {
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:J3');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A3", $format_header['MasterListOfFormat']['title'])->getStyle("A3:J3")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:C4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A4", "Document Number")->getStyle("A4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D4", $format_header['MasterListOfFormat']['document_number'])->getStyle("D4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:C5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A5", "Revision Number")->getStyle("A5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D5", $format_header['MasterListOfFormat']['revision_number'])->getStyle("D5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:C6');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A6", "Revision Date")->getStyle("A6")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D6", $format_header['MasterListOfFormat']['revision_date'])->getStyle("D6")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:G4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F4", "Prepared By")->getStyle("F4:F4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F5:G5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F5", "Approved By")->getStyle("F5:G5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H4:J4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H4", $format_header['PreparedBy']['name'])->getStyle("H4:J4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H5:J5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H5", $format_header['PreparedBy']['name'])->getStyle("H5:J5")->applyFromArray($this->styleBorder);

            $objPHPExcel->setActiveSheetIndex(0)->fromArray($main_header, NULL, 'A8');
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A8:J8')->applyFromArray($this->styleNil);
            $x = 9;
        } else {
            $objPHPExcel->setActiveSheetIndex(0)->fromArray($main_header, NULL, 'A3');
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A3:J3')->applyFromArray($this->styleNil);
            $x = 4;
        }

        $x = 4;

        if (isset($backups)) {
            foreach ($backups as $backup):
               $backup['Details']['DataBackUp']['name'] = isset($backup['Details']['DataBackUp']['name']) ? $backup['Details']['DataBackUp']['name'] : '';
               $backup['Details']['Employee']['name'] = isset($backup['Details']['Employee']['name']) ? $backup['Details']['Employee']['name'] : '';
               $backup['Actual']['DatabackupLogbook']['name'] = isset($backup['Actual']['DatabackupLogbook']['name']) ? $backup['Actual']['DatabackupLogbook']['name'] : '';
               $backup['Actual']['DatabackupLogbook']['name'] = isset($backup['Actual']['DatabackupLogbook']['name']) ? $backup['Actual']['DatabackupLogbook']['name'] : '';
               $backup['Actual']['DatabackupLogbook']['name'] = isset($backup['Actual']['DatabackupLogbook']['name']) ? $backup['Actual']['DatabackupLogbook']['name'] : '';
                $backup_details = array($backup['Details']['DataBackUp']['name']
                   ,
                    $backup['Details']['Employee']['name'],
                    $backup['Actual']['DatabackupLogbook']['task_performed'],
                    $backup['Actual']['DatabackupLogbook']['backup_date'],
                    $backup['Actual']['DatabackupLogbook']['comments']
                );
                $objPHPExcel->setActiveSheetIndex(0)->fromArray($backup_details, NULL, 'A' . $x);
                $x++;
            endforeach;
        }else {
            $backups = array();
        }
        
        $path = 'DatabackupLogbook' .DS . $from;
        $this->create_xls_file($filename, $path, $objPHPExcel, $type);
        return 1;
    }

    public function _list_of_acceptable_suppliers() {
        $from = date('Y-m-1 h:i:s');
        
        $to = date("Y-m-d h:i:s", strtotime("+1 month", strtotime($from)));

        $this->loadModel('ListOfAcceptableSupplier');
        $supplier_lists = $this->ListOfAcceptableSupplier->find('all', array(
            'Order' => array(
                'ListOfAcceptableSupplier.evaluation_date' => 'DESC'
            ),
            'conditions' => array(
                'ListOfAcceptableSupplier.publish' => 1,
                'ListOfAcceptableSupplier.soft_delete' => 0,
                'ListOfAcceptableSupplier.created BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            )
        ));

        // writing to file
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("FlinkISO")->setLastModifiedBy("FlinkISO")->setTitle("FlinkISO Summery Of Supplier Evaluations")->setSubject("Office 2007 XLSX Test Document")->setDescription("These are standard import formats for data to be importaed to flinkISO application")->setKeywords("office 2007 openxml php")->setCategory("FlinkISO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'FlinkISO List of Acceptable Suppliers as of : ' . $from);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:E1')->applyFromArray($this->styleHeader);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(25);
        $main_header = array(
            'Supplier Name',
            'Supplier Category',
            'Remarks'
        );
        $format_header = $this->create_header('ListOfAcceptableSupplier');
        if ($format_header) {
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:J3');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A3", $format_header['MasterListOfFormat']['title'])->getStyle("A3:J3")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:C4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A4", "Document Number")->getStyle("A4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D4", $format_header['MasterListOfFormat']['document_number'])->getStyle("D4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:C5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A5", "Revision Number")->getStyle("A5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D5", $format_header['MasterListOfFormat']['revision_number'])->getStyle("D5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:C6');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A6", "Revision Date")->getStyle("A6")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D6", $format_header['MasterListOfFormat']['revision_date'])->getStyle("D6")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:G4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F4", "Prepared By")->getStyle("F4:F4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F5:G5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F5", "Approved By")->getStyle("F5:G5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H4:J4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H4", $format_header['PreparedBy']['name'])->getStyle("H4:J4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H5:J5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H5", $format_header['PreparedBy']['name'])->getStyle("H5:J5")->applyFromArray($this->styleBorder);

            $objPHPExcel->setActiveSheetIndex(0)->fromArray($main_header, NULL, 'A8');
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A8:J8')->applyFromArray($this->styleNil);
            $x = 9;
        } else {
            $objPHPExcel->setActiveSheetIndex(0)->fromArray($main_header, NULL, 'A3');
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A3:J3')->applyFromArray($this->styleNil);
            $x = 4;
        }

        foreach ($supplier_lists as $supplier):
            $supplier_details = array(
                $supplier['SupplierRegistration']['title'],
                $supplier['SupplierCategory']['name'],
                $supplier['ListOfAcceptableSupplier']['remarks']
            );

            $objPHPExcel->setActiveSheetIndex(0)->fromArray($supplier_details, NULL, 'A' . $x);
            $x++;
        endforeach;
        $filename = date('Y-m-d') . "-FlinkISO_ListOfAcceptableSupplierReport.xls";
        $path = 'ListOfAcceptableSuppliers';
        $this->create_xls_file($filename, $path, $objPHPExcel);
    }

    public function _summery_of_supplier_evaluations() {
        $from = date('Y-m-1');
        $to = date("Y-m-d", strtotime("+1 month", strtotime($from)));

        $this->loadModel('SummeryOfSupplierEvaluation');
        $supplier_lists = $this->SummeryOfSupplierEvaluation->find('all', array(
            'conditions' => array(
                'SummeryOfSupplierEvaluation.publish' => 1,
                'SummeryOfSupplierEvaluation.soft_delete' => 0,
                'SummeryOfSupplierEvaluation.evaluation_date BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            )
        ));

        // writing to file
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("FlinkISO")->setLastModifiedBy("FlinkISO")->setTitle("FlinkISO Summery Of Supplier Evaluations")->setSubject("Office 2007 XLSX Test Document")->setDescription("These are standard import formats for data to be importaed to flinkISO application")->setKeywords("office 2007 openxml php")->setCategory("FlinkISO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'FlinkISO Summery Of Supplier Evaluations : ' . $from);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:E1')->applyFromArray($this->styleHeader);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(25);
        $main_header = array(
            'Supplier Name',
            'Supplier Category',
            'Remarks',
            'Evaluation By',
            'Evaluation Date'
        );
        $format_header = $this->create_header('SummeryOfSupplierEvaluation');
        if ($format_header) {
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:J3');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A3", $format_header['MasterListOfFormat']['title'])->getStyle("A3:J3")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:C4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A4", "Document Number")->getStyle("A4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D4", $format_header['MasterListOfFormat']['document_number'])->getStyle("D4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:C5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A5", "Revision Number")->getStyle("A5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D5", $format_header['MasterListOfFormat']['revision_number'])->getStyle("D5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:C6');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A6", "Revision Date")->getStyle("A6")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D6", $format_header['MasterListOfFormat']['revision_date'])->getStyle("D6")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:G4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F4", "Prepared By")->getStyle("F4:F4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F5:G5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F5", "Approved By")->getStyle("F5:G5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H4:J4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H4", $format_header['PreparedBy']['name'])->getStyle("H4:J4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H5:J5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H5", $format_header['PreparedBy']['name'])->getStyle("H5:J5")->applyFromArray($this->styleBorder);

            $objPHPExcel->setActiveSheetIndex(0)->fromArray($main_header, NULL, 'A8');
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A8:J8')->applyFromArray($this->styleNil);
            $x = 9;
        } else {
            $objPHPExcel->setActiveSheetIndex(0)->fromArray($main_header, NULL, 'A3');
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A3:J3')->applyFromArray($this->styleNil);
            $x = 4;
        }

        foreach ($supplier_lists as $supplier):
            $supplier_details = array(
                $supplier['SupplierRegistration']['title'],
                $supplier['SupplierCategory']['name'],
                $supplier['SummeryOfSupplierEvaluation']['remarks'],
                $supplier['Employee']['name'],
                $supplier['SummeryOfSupplierEvaluation']['evaluation_date']
            );
            $objPHPExcel->setActiveSheetIndex(0)->fromArray($supplier_details, NULL, 'A' . $x);
            $x++;
        endforeach;
        $filename = date('Y-m-d') . "-FlinkISO_SummeryOfSupplierEvaluation.xls";
        $path = 'SummeryOfSupplierEvaluation';
        $this->create_xls_file($filename, $path, $objPHPExcel);
    }

    public function delete($id = null) {
        if (!empty($id)) {
            $data['id'] = $id;
            $data['soft_delete'] = 1;

            $this->Report->save($data);
        }
        $this->redirect(array('action' => 'index'));
    }

    public function delete_all($ids = null) {
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);
        $model_name = $this->modelClass;
        $this->loadModel('Approval');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => $model_name)));
                    foreach ($approves as $approve) {
                        $approve['Approval']['soft_delete'] = 1;
                        $this->Approval->save($approve, false);
                    }
                    $data['id'] = $id;
                    $data['soft_delete'] = 1;
                    $this->$model_name->save($data, false);
                }
            }
        }

        $this->Session->setFlash(__('All selected value deleted'));
        $this->redirect(array(
            'action' => 'index'
        ));
    }

    public function purge($id = null) {
        $model_name = $this->modelClass;
        $this->$model_name->id = $id;
        $this->loadModel('Approval');
        if (!$this->$model_name->exists()) {
            throw new NotFoundException(__('Invalid detail'));
        }
        $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => $model_name)));
        foreach ($approves as $approve) {
            if (!($this->Approval->delete($approve['Approval']['id'], true))) {
                $this->Session->setFlash(__('All selected value was not deleted from Approve'));
                $this->redirect(array('action' => 'index'));
            }
        }
        $filepath = $this->Report->find('first', array('conditions' => array('Report.id' => $id), 'fields' => 'details'));
        $file = new File($filepath['Report']['details']);
        $file->delete();
        if ($this->Report->delete($id, true)) {
            $this->Session->setFlash(__('Selected Report Deleted'));
            $this->redirect(array(
                'action' => 'index'
            ));
        }

        $this->Session->setFlash(__('Selected Report was not deleted'));
        $this->redirect(array(
            'action' => 'index'
        ));
    }

    public function purge_all($ids = null) {
        $flag = 0;
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);
        $model_name = $this->modelClass;
        $this->loadModel('Approval');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $this->$model_name->id = $id;
                    if (!$this->$model_name->exists()) {
                        throw new NotFoundException(__('Invalid detail'));
                    }

                    $this->request->onlyAllow('post', 'delete');
                    $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => $model_name)));
                    foreach ($approves as $approve) {
                        if ($this->Approval->delete($approve['Approval']['id'], true)) {
                            $flag = 1;
                        } else {
                            $flag = 0;
                            $this->Session->setFlash(__('All selected value was not deleted'));
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                    $filepath = $this->Report->find('first', array('conditions' => array('Report.id' => $id), 'fields' => 'details'));
                    $file = new File($filepath['Report']['details']);
                    $file->delete();
                    if ($this->Report->delete($id, true)) {
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
                $this->redirect(array(
                    'action' => 'index'
                ));
            }
        }

        $this->redirect(array('action' => 'index'));
    }

    public function _trainings() {
        $from = date('Y-m-1 h:i:s');
        $to = date("Y-m-d h:i:s", strtotime("+1 month", strtotime($from)));

        $this->loadModel('Training');
        $trainings = $this->Training->find('all', array(
            'conditions' => array(
                'Training.publish' => 1,
                'Training.soft_delete' => 0,
                'Training.start_date_time BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            )
        ));

        // writing to file
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("FlinkISO")->setLastModifiedBy("FlinkISO")->setTitle("FlinkISO Trainings")->setSubject("Office 2007 XLSX Test Document")->setDescription("These are standard import formats for data to be importaed to flinkISO application")->setKeywords("office 2007 openxml php")->setCategory("FlinkISO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'FlinkISO Trainings : ' . $from);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:H1')->applyFromArray($this->styleHeader);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(25);
        $main_header = array(
            'Training / Course Title ',
            'Description',
            'Trainer',
            'Trainer Type',
            'Training Type',
            'Attendees',
            'Training Start Time',
            'Training End Time'
        );
        $format_header = $this->create_header('Training');
        if ($format_header) {
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:J3');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A3", $format_header['MasterListOfFormat']['title'])->getStyle("A3:J3")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:C4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A4", "Document Number")->getStyle("A4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D4", $format_header['MasterListOfFormat']['document_number'])->getStyle("D4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:C5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A5", "Revision Number")->getStyle("A5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D5", $format_header['MasterListOfFormat']['revision_number'])->getStyle("D5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:C6');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A6", "Revision Date")->getStyle("A6")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D6", $format_header['MasterListOfFormat']['revision_date'])->getStyle("D6")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:G4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F4", "Prepared By")->getStyle("F4:F4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F5:G5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F5", "Approved By")->getStyle("F5:G5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H4:J4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H4", $format_header['PreparedBy']['name'])->getStyle("H4:J4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H5:J5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H5", $format_header['PreparedBy']['name'])->getStyle("H5:J5")->applyFromArray($this->styleBorder);

            $objPHPExcel->setActiveSheetIndex(0)->fromArray($main_header, NULL, 'A8');
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A8:J8')->applyFromArray($this->styleNil);
            $x = 9;
        } else {
            $objPHPExcel->setActiveSheetIndex(0)->fromArray($main_header, NULL, 'A3');
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A3:J3')->applyFromArray($this->styleNil);
            $x = 4;
        }

        foreach ($trainings as $training):
            $training_details = array(
                $training['Training']['title'],
                $training['Training']['description'],
                $training['Course']['title'],
                $training['Trainer']['name'],
                $training['TrainerType']['title'],
                'NIL',
                $training['Training']['start_date_time'],
                $training['Training']['end_date_time']
            );
            $objPHPExcel->setActiveSheetIndex(0)->fromArray($training_details, NULL, 'A' . $x);
            $x++;
        endforeach;
        $filename = date('Y-m-d') . "-FlinkISO_Training.xls";
        $path = 'Training';
        $this->create_xls_file($filename, $path, $objPHPExcel);
    }

    public function _tni() {

        $from = date('Y-m-1 h:i:s');
        $to = date("Y-m-d h:i:s", strtotime("+1 month", strtotime($from)));

        $this->loadModel('TrainingNeedIdentification');
        $trainings = $this->TrainingNeedIdentification->find('all', array(
            'conditions' => array(
                'TrainingNeedIdentification.publish' => 1,
                'TrainingNeedIdentification.soft_delete' => 0,
                'TrainingNeedIdentification.created BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            )
        ));

        // writing to file
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("FlinkISO")->setLastModifiedBy("FlinkISO")->setTitle("FlinkISO Training Need Identification")->setSubject("Office 2007 XLSX Test Document")->setDescription("These are standard import formats for data to be importaed to flinkISO application")->setKeywords("office 2007 openxml php")->setCategory("FlinkISO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'FlinkISO Training Need Identification : ' . $from);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:C1');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:C1')->applyFromArray($this->styleHeader);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(25);
        $main_header = array(
            'Employee',
            'Requires Training',
            'Remarks'
        );
        $format_header = $this->create_header('TrainingNeedIdentification');
        if ($format_header) {
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:J3');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A3", $format_header['MasterListOfFormat']['title'])->getStyle("A3:J3")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:C4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A4", "Document Number")->getStyle("A4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D4", $format_header['MasterListOfFormat']['document_number'])->getStyle("D4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:C5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A5", "Revision Number")->getStyle("A5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D5", $format_header['MasterListOfFormat']['revision_number'])->getStyle("D5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:C6');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A6", "Revision Date")->getStyle("A6")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D6", $format_header['MasterListOfFormat']['revision_date'])->getStyle("D6")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:G4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F4", "Prepared By")->getStyle("F4:F4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F5:G5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F5", "Approved By")->getStyle("F5:G5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H4:J4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H4", $format_header['PreparedBy']['name'])->getStyle("H4:J4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H5:J5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H5", $format_header['PreparedBy']['name'])->getStyle("H5:J5")->applyFromArray($this->styleBorder);

            $objPHPExcel->setActiveSheetIndex(0)->fromArray($main_header, NULL, 'A8');
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A8:J8')->applyFromArray($this->styleNil);
            $x = 9;
        } else {
            $objPHPExcel->setActiveSheetIndex(0)->fromArray($main_header, NULL, 'A3');
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A3:J3')->applyFromArray($this->styleNil);
            $x = 4;
        }

        foreach ($trainings as $training):
            $training_details = array(
                $training['Employee']['name'],
                $training['Course']['title'],
                $training['TrainingNeedIdentification']['remarks']
            );
            $objPHPExcel->setActiveSheetIndex(0)->fromArray($training_details, NULL, 'A' . $x);
            $x++;
        endforeach;

        $filename = date('Y-m-d') . "-FlinkISO_TrainingNeedIdentification.xls";
        $path = 'TrainingNeedIdentification';
        $this->create_xls_file($filename, $path, $objPHPExcel);
    }

    public function nc_report_excel() {
        if ($this->data['Report']['from'] == null && $this->data['Report']['to'] == null) {
            $from = date('Y-m-d 00:00:00');
            $to = date("Y-m-d 00:00:00", strtotime("+1 day", strtotime($this->data['Report']['from'])));
            $type = true;
        } else {
            $type = true;
            $from = date("Y-m-d 00:00:00", strtotime($this->data['Report']['from']));
            $to = date("Y-m-d 00:00:00", strtotime($this->data['Report']['to']));
        }

        $this->loadModel('CorrectivePreventiveAction');
        $this->CorrectivePreventiveAction->recursive = 1;
        $capas = $this->CorrectivePreventiveAction->find('all', array(
            'conditions' => array(
                'CorrectivePreventiveAction.publish' => 1,
                'CorrectivePreventiveAction.soft_delete' => 0,
                'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            ),
            'order' => array(
                'CorrectivePreventiveAction.created' => 'DESC'
            )
        ));

        // CAPA by source
        $capaSources = $this->CorrectivePreventiveAction->CapaSource->find('list');
        foreach ($capaSources as $key => $value):
            $capa_source_wise[$value] = $this->CorrectivePreventiveAction->find('count', array(
                'conditions' => array(
                    'CorrectivePreventiveAction.publish' => 1,
                    'CorrectivePreventiveAction.soft_delete' => 0,
                    'CorrectivePreventiveAction.capa_source_id' => $key,
                    'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                        $from,
                        $to
                    )
                ),
                'order' => array(
                    'CorrectivePreventiveAction.created' => 'DESC'
                )
            ));
        endforeach;
        $capaCategories = $this->CorrectivePreventiveAction->CapaCategory->find('list');
        foreach ($capaCategories as $key => $value):
            $capa_category_wise[$value] = $this->CorrectivePreventiveAction->find('count', array(
                'conditions' => array(
                    'CorrectivePreventiveAction.publish' => 1,
                    'CorrectivePreventiveAction.soft_delete' => 0,
                    'CorrectivePreventiveAction.capa_category_id' => $key,
                    'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                        $from,
                        $to
                    )
                ),
                'order' => array(
                    'CorrectivePreventiveAction.created' => 'DESC'
                )
            ));
        endforeach;
        $capa_closed = $this->CorrectivePreventiveAction->find('count', array(
            'conditions' => array(
                'CorrectivePreventiveAction.publish' => 1,
                'CorrectivePreventiveAction.soft_delete' => 0,
                'CorrectivePreventiveAction.current_status' => '1',
                'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            )
        ));
        $capa_open = $this->CorrectivePreventiveAction->find('count', array(
            'conditions' => array(
                'CorrectivePreventiveAction.publish' => 1,
                'CorrectivePreventiveAction.soft_delete' => 0,
                'CorrectivePreventiveAction.current_status <> ' => '1',
                'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            )
        ));
        $capa_root = $this->CorrectivePreventiveAction->find('count', array(
            'conditions' => array(
                'CorrectivePreventiveAction.publish' => 1,
                'CorrectivePreventiveAction.soft_delete' => 0,
                'CorrectivePreventiveAction.root_cause_analysis_required' => 1,
                'CorrectivePreventiveAction.created BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            )
        ));

        // writing to file
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("FlinkISO")->setLastModifiedBy("FlinkISO")->setTitle("FlinkISO Daily Data Entry Report")->setSubject("Office 2007 XLSX Test Document")->setDescription("These are standard import formats for data to be importaed to flinkISO application")->setKeywords("office 2007 openxml php")->setCategory("FlinkISO");
        $main_header = array(
            'CAPA Number',
            'CAPA Source',
            'CAPA Category',
            'Raised By',
            'Target Date',
            'Completed Date',
            'Current Status',
            'Document Change Required',
            'Root Cause Analysis Required'
        );
        $title = "NC Report " . date("Y-m-d", strtotime($this->data['Report']['from'])) . "_" . date("Y-m-d", strtotime($this->data['Report']['to']));
        $objPHPExcel->setActiveSheetIndex(0)->setTitle($title);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'FlinkISO NC Report');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:J1')->applyFromArray($this->styleHeader);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(25);
        $format_header = $this->create_header('CorrectivePreventiveAction');
        if ($format_header) {
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:J3');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A3", $format_header['MasterListOfFormat']['title'])->getStyle("A3:J3")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:C4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A4", "Document Number")->getStyle("A4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D4", $format_header['MasterListOfFormat']['document_number'])->getStyle("D4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:C5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A5", "Revision Number")->getStyle("A5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D5", $format_header['MasterListOfFormat']['revision_number'])->getStyle("D5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:C6');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A6", "Revision Date")->getStyle("A6")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D6", $format_header['MasterListOfFormat']['revision_date'])->getStyle("D6")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:G4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F4", "Prepared By")->getStyle("F4:F4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F5:G5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F5", "Approved By")->getStyle("F5:G5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H4:J4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H4", $format_header['PreparedBy']['name'])->getStyle("H4:J4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H5:J5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H5", $format_header['PreparedBy']['name'])->getStyle("H5:J5")->applyFromArray($this->styleBorder);

            $x = 7;
        } else {
            $objPHPExcel->setActiveSheetIndex(0)->fromArray($main_header, NULL, 'A3');
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A3:J3')->applyFromArray($this->styleNil);
            $x = 2;
        }

        $x = $x + 2;
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $x . ':' . 'C' . $x);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x, 'OPEN CAPAS : ' . $capa_open);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $x . ':' . 'C' . $x)->applyFromArray($this->styleHeader);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(45);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E' . $x . ':' . 'G' . $x);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $x, 'CLOSE CAPAS : ' . $capa_closed);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('E' . $x . ':' . 'G' . $x)->applyFromArray($this->styleHeader);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(45);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I' . $x . ':' . 'O' . $x);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $x, 'ROOT CAUSE ANALYSIS REQUIRED : ' . $capa_root);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I' . $x . ':' . 'O' . $x)->applyFromArray($this->styleHeader);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(45);
        $x = $x + 3;
        $ct = $x;

        // capa source-wise
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x, 'CAPA SOURCE WISE');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $x . ':D' . $x);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $x . ':D' . $x)->applyFromArray($this->styleHeader);
        $x = $x + 1;
        $capa_source_array = array(
            'CAPA Source',
            'Count'
        );
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $x . ':' . 'B' . $x);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x, 'CAPA Source');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $x . ':' . 'B' . $x)->applyFromArray($this->styleNil);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $x, 'Count');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C' . $x)->applyFromArray($this->styleNil);
        $x = $x + 1;
        $total = 0;
        foreach ($capa_source_wise as $key => $value):
            $capa_source_details = array(
                $key,
                $value
            );
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $x . ':' . 'B' . $x);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x, $key);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $x, $value);
            $total = $total + $value;
            $x++;
        endforeach;
        $x = $x + 1;
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $x . ':B' . $x);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x, 'Total');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $x, $total);
        $x = $x + 1;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $ct, 'CAPA CATEGORY WISE');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F' . $ct . ':I' . $ct);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F' . $ct . ':I' . $ct)->applyFromArray($this->styleHeader);
        $ct = $ct + 1;
        $capa_source_array = array(
            'CAPA Category',
            'Count'
        );
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F' . $ct . ':H' . $ct);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $ct, 'CAPA Category');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F' . $ct . ':H' . $ct)->applyFromArray($this->styleNil);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $ct, 'Count');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I' . $ct)->applyFromArray($this->styleNil);
        $ct = $ct + 1;
        $total = 0;
        foreach ($capa_category_wise as $key => $value):
            $capa_source_details = array(
                $key,
                $value
            );
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F' . $ct . ':H' . $ct);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $ct, $key);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $ct, $value);
            $total = $total + $value;
            $ct++;
        endforeach;
        $ct = $ct + 1;
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F' . $ct . ':H' . $ct);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $ct, 'Total');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $ct, $total);
        $ct = $ct + 1;

        $x = $x + 2;
        $objPHPExcel->setActiveSheetIndex(0)->fromArray($main_header, NULL, 'A' . $x);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $x . ':J' . $x)->applyFromArray($this->styleNil);
        $x = $x + 2;
        foreach ($capas as $capa):
            $source = json_decode($capa['CorrectivePreventiveAction']['raised_by'], true);
            $capa_source = $source['Soruce'];
            $capa_details = array(
                $capa['CorrectivePreventiveAction']['number'],
                $capa['CapaSource']['name'],
                $capa['CapaCategory']['name'],
                $capa_source,
                $capa['CorrectivePreventiveAction']['target_date'],
                $capa['CorrectivePreventiveAction']['completed_on_date'],
                $capa['CorrectivePreventiveAction']['current_status'] ? __('Close') : __('Open'),
                $capa['CorrectivePreventiveAction']['document_changes_required'] ? __('Yes') : __('No'),
                $capa['CorrectivePreventiveAction']['root_cause_analisys_required'] ? __('Yes') : __('No')
            );
            $objPHPExcel->setActiveSheetIndex(0)->fromArray($capa_details, NULL, 'A' . $x);
            $x++;
        endforeach;
        $filename = str_replace(' ', '_', $title) . ".xls";
        $path = 'NCReport';
        $this->create_xls_file($filename, $path, $objPHPExcel, $type);
        return 1;
    }

    public function cc_report_excel() {
        if ($this->data['Report']['from'] == null && $this->data['Report']['to'] == null) {
            $from = date('Y-m-d 00:00:00');
            $to = date("Y-m-d 00:00:00", strtotime("+1 day", strtotime($this->data['Report']['from'])));
            $type = false;
        } else {
            $type = true;
            $from = date("Y-m-d 00:00:00", strtotime($this->data['Report']['from']));
            $to = date("Y-m-d 00:00:00", strtotime($this->data['Report']['to']));
        }

        $this->loadModel('CustomerComplaint');
        $customerComplaints = $this->CustomerComplaint->find('all', array(
            'conditions' => array(
                'CustomerComplaint.publish' => 1,
                'CustomerComplaint.soft_delete' => 0,
                'CustomerComplaint.complaint_date BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            )
        ));
        $open = $this->CustomerComplaint->find('count', array(
            'conditions' => array(
                'CustomerComplaint.publish' => 1,
                'CustomerComplaint.soft_delete' => 0,
                'CustomerComplaint.current_status' => 0,
                'CustomerComplaint.complaint_date BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            ),
            'order' => array(
                'CustomerComplaint.complaint_date' => 'DESC'
            )
        ));
        $closed = $this->CustomerComplaint->find('count', array(
            'conditions' => array(
                'CustomerComplaint.publish' => 1,
                'CustomerComplaint.soft_delete' => 0,
                'CustomerComplaint.current_status <> ' => 0,
                'CustomerComplaint.complaint_date BETWEEN ? AND ? ' => array(
                    $from,
                    $to
                )
            )
        ));
        $setteled = $this->CustomerComplaint->find('count', array(
            'conditions' => array(
                'CustomerComplaint.publish' => 1,
                'CustomerComplaint.soft_delete' => 0,
                'CustomerComplaint.current_status <> ' => 0,
                'CustomerComplaint.complaint_date BETWEEN ? AND ? ' => array(
                    $from,
                    date('Y-m-31', strtotime($from)),
                    'CustomerComplaint.settled_date <= CustomerComplaint.target_date '
                )
            )
        ));
        $all_complaints = count($customerComplaints);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("FlinkISO")->setLastModifiedBy("FlinkISO")->setTitle("FlinkISO Daily Data Entry Report")->setSubject("Office 2007 XLSX Test Document")->setDescription("These are standard import formats for data to be imported to flinkISO application")->setKeywords("office 2007 openxml php")->setCategory("FlinkISO");
        $main_header = array(
            'Type',
            'Customer Id',
            'Complaint Number',
            'Source',
            'Complaint Date',
            'Employee Id',
            'Action Taken',
            'Action Taken Date',
            'Current Status',
            'Settled Date',
            'Authorized By'
        );
        $title = "CC Report" . date("Y-m-d", strtotime($this->data['Report']['from'])) . "_" . date("Y-m-d", strtotime($this->data['Report']['to']));
        $objPHPExcel->setActiveSheetIndex(0)->setTitle($title);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'FlinkISO CC Report');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:J1')->applyFromArray($this->styleHeader);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(30);
        $x = 4;
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $x . ':' . 'C' . $x);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $x, 'OPEN  : ' . $open);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $x . ':' . 'C' . $x)->applyFromArray($this->styleHeader);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(50);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E' . $x . ':' . 'G' . $x);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $x, 'CLOSED : ' . $closed);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('E' . $x . ':' . 'G' . $x)->applyFromArray($this->styleHeader);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(50);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I' . $x . ':' . 'O' . $x);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $x, 'CLOSED IN TIME : ' . $setteled);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('I' . $x . ':' . 'O' . $x)->applyFromArray($this->styleHeader);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(50);

        $x = $x + 2;
        $objPHPExcel->setActiveSheetIndex(0)->fromArray($main_header, NULL, 'A' . $x);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $x . ':K' . $x)->applyFromArray($this->styleNil);
        $x = $x + 2;
        foreach ($customerComplaints as $customerComplaint):

            $complaint_details = array(
                $customerComplaint['CustomerComplaint']['type'] ? __('Customer Feedback') : __('Customer Complaint'),
                $customerComplaint['Customer']['name'],
                $customerComplaint['CustomerComplaint']['complaint_number'],
                $customerComplaint['Product']['name'],
                $customerComplaint['CustomerComplaint']['complaint_date'],
                $customerComplaint['Employee']['name'],
                $customerComplaint['CustomerComplaint']['action_taken'],
                $customerComplaint['CustomerComplaint']['action_taken_date'],
                $customerComplaint['CustomerComplaint']['current_status'] ? __('Close') : __('Open'),
                $customerComplaint['CustomerComplaint']['settled_date'],
                $customerComplaint['CustomerComplaint']['authorized_by'],
            );
            $objPHPExcel->setActiveSheetIndex(0)->fromArray($complaint_details, NULL, 'A' . $x);
            $x++;
        endforeach;
        $filename = str_replace(' ', '_', $title) . ".xls";
        $path = 'CCReport';
        $this->create_xls_file($filename, $path, $objPHPExcel, $type);
        return 1;
    }

    public function saved_report_list() {
        $conditions = $this->_check_request();
        $this->paginate = array('order' => array('Report.sr_no' => 'DESC'), 'conditions' => array($conditions), 'recursive' => 0);
        $this->set('reports', $this->paginate());
    }

    public function index() {
        $conditions = $this->_check_request();
        $this->paginate = array('order' => array('Report.sr_no' => 'DESC'), 'conditions' => array($conditions), 'recursive' => 0);
        $this->set('reports', $this->paginate());
        $this->_get_count();
    }

    public function generate_table_report($scheduleType = 'Monthly',$from_date = null, $to_date = null) {
        if ($scheduleType == 'Weekly') {
            $model_list = array('CorrectivePreventiveAction', 'CustomerComplaint', 'NonConformingProductsMaterial', 'Calibration', 'CustomerFeedback', 'PurchaseOrder', 'DeliveryChallan');
            if($from_date == null && $to_date == null){
                $from_date = date('Y-m-d', strtotime('last monday'));
                $to_date = date('Y-m-d', strtotime('last sunday'));
                $filedate = date('Y-m-d');
            }else{
                $from_date = $from_date;
                $to_date = $to_date;
                $filedate = date('Y-m-d',  strtotime($from_date));
            }
            
        } else {
            $model_list = array('CorrectivePreventiveAction', 'Meeting', 'ChangeAdditionDeletionRequest', 'NonConformingProductsMaterial','Training', 'TrainingNeedIdentification', 'TrainingEvaluation', 'CompetencyMapping', 'CustomerComplaint', 'Calibration', 'CustomerFeedback', 'SupplierRegistration', 'PurchaseOrder', 'DeliveryChallan', 'ListOfAcceptableSupplier', 'ListOfSoftware');
            if($from_date == null && $to_date == null){
                $from_date = date('Y-m-d', strtotime('first day of -1 month'));
                $to_date = date('Y-m-d', strtotime('last day of -1 month'));
                $filedate = date('Y-m-d');
            }else{
                $from_date = $from_date;
                $to_date = $to_date;
                $filedate = date('Y-m-d',  strtotime($from_date));
            }
        }
        
        foreach ($model_list as $open_model) {
            $this->loadModel($open_model);
            $schema = $this->$open_model->schema();

            unset($schema['id']);
            unset($schema['sr_no']);
            unset($schema['publish']);
            unset($schema['soft_delete']);
            unset($schema['branchid']);
            unset($schema['departmentid']);
            unset($schema['modified_by']);
            unset($schema['created_by']);
            unset($schema['created']);
            unset($schema['modified']);
            unset($schema['modified_by']);
            unset($schema['system_table_id']);
            unset($schema['master_list_of_format_id']);
            unset($schema['raised_by']);
            unset($schema['ship_by']);
            unset($schema['status_user_id']);
            unset($schema['record_status']);
            unset($schema['header']);
            unset($schema['footer']);




            $get_fields = array();
            $get_titles = array();
            foreach ($schema as $value => $attrs):
                $newModel = $open_model;

                if (strpos($value, "_id") || $value == 'assigned_to' || strpos($value, "_by") || $value == "action_assigned_to" || $value == 'calibration_frequency' || $value == 'maintenance_frequency' || $value == "actual_education" || $value == "master_list_of_format") {
                   foreach($this->$newModel->belongsTo as $belongToKey=>$belongToVal){
                        $this->loadModel($belongToVal['className']);
                        if($belongToVal['foreignKey'] == $value){
                            if($this->$belongToVal['className']->isVirtualField($this->$belongToVal['className']->displayField)){
                                $displayField = $this->$belongToVal['className']->getVirtualField($this->$belongToVal['className']->displayField) . ' as '.$belongToVal['className'] . '_' .$this->$belongToVal['className']->displayField;

                            }else{
                                $displayField = $belongToKey . '.' . $this->$belongToVal['className']->displayField;
                            }
                             $get_fields[] = $displayField;
                             $get_titles[] = Inflector::humanize(str_replace('_id', '', $value));
                        }
                   }

               } else {

                       $get_fields[] = $newModel . '.' . $value;
                       $get_titles[] = Inflector::humanize($value);

               }

            endforeach;

            $this->loadModel($open_model);
            $this->$open_model->recursive = 1;
            $records = $this->$open_model->find('all', array(
                'fields' => $get_fields,
                'conditions' => array(
                    "AND" => array(
                        "$open_model.created >=" => $from_date,
                        "$open_model.created <=" => $to_date)
                )
            ));

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator("FlinkISO")->setLastModifiedBy("FlinkISO")->setTitle("FlinkISO Daily Data Entry Report")->setSubject("Office 2007 XLSX Test Document")->setDescription("These are standard import formats for data to be importaed to flinkISO application")->setKeywords("office 2007 openxml php")->setCategory("FlinkISO");
            $styleHeader = array(
                'font' => array(
                    'size' => 16,
                    'bold' => false,
                    'color' => array(
                        'rgb' => '428BCA'
                    ),
                    'name' => 'Arial'
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array(
                        'rgb' => 'ffffff'
                    )
                ),
                'alignment' => array(
                    'wrapText' => true
                )
            );
            $styleNil = array(
                'font' => array(
                    'bold' => true,
                    'color' => array(
                        'rgb' => 'FFFFFF'
                    ),
                    'name' => 'Arial'
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array(
                        'rgb' => '428BCA'
                    )
                ),
                'alignment' => array(
                    'wrapText' => true
                )
            );

            $objPHPExcel->setActiveSheetIndex(0)->setTitle(substr($open_model, 0, 30));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'FlinkISO : ' . $open_model . ' data');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1');
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:H1')->applyFromArray($styleHeader);
            $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
            $i = 3;


          $format_header = $this->create_header($open_model);

        if ($format_header) {
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:J3');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A3", $format_header['MasterListOfFormat']['title'])->getStyle("A3:J3")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:C4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A4", "Document Number")->getStyle("A4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D4", $format_header['MasterListOfFormat']['document_number'])->getStyle("D4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:C5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A5", "Revision Number")->getStyle("A5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D5", $format_header['MasterListOfFormat']['revision_number'])->getStyle("D5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:C6');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A6", "Revision Date")->getStyle("A6")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D6", $format_header['MasterListOfFormat']['revision_date'])->getStyle("D6")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:G4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F4", "Prepared By")->getStyle("F4:F4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F5:G5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F5", "Approved By")->getStyle("F5:G5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H4:J4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H4", $format_header['PreparedBy']['name'])->getStyle("H4:J4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H5:J5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H5", $format_header['PreparedBy']['name'])->getStyle("H5:J5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->fromArray($get_titles, NULL, 'A8');
            $colIndex  =  PHPExcel_Cell::stringFromColumnIndex(count($get_titles)).'8' ;

            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A8:'.$colIndex)->applyFromArray($this->styleNil);
            $x = 9;
        } else {
            $objPHPExcel->setActiveSheetIndex(0)->fromArray($get_titles, NULL, 'A3');
           // $totalTitle = count($get_titles);
            $colIndex  =  PHPExcel_Cell::stringFromColumnIndex(count($get_titles)).'3' ;
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A3:'.$colIndex)->applyFromArray($this->styleNil);
            $x = 4;
        }

        foreach ($records as $record):
               $a = array();
               foreach ($schema as $value => $attrs):

                    $newModel = $open_model;
                    $newVal = '';

                      if (strpos($value, "_id") || strpos($value, "_by") || $value == 'assigned_to' || $value == "action_assigned_to" || $value == "actual_education" || $value == 'calibration_frequency' || $value == 'maintenance_frequency' ||  $value == "master_list_of_format") {

		         foreach($this->$open_model->belongsTo as $belongToKey=>$belongToVal){
			     if($belongToVal['foreignKey'] == $value){
				if($this->$belongToVal['className']->isVirtualField($this->$belongToVal['className']->displayField)){

				       $a[$open_model][$value]  = $record[0][$belongToKey.'_'.$this->$belongToVal['className']->displayField];
			        }else{

				    $a[$open_model][$value]  = $record[$belongToKey][$this->$belongToVal['className']->displayField];
                                }
			     }

			 }

                } else {

		        if(isset($this->$newModel->customArray) && array_key_exists($value, $this->$newModel->customArray)){
			    $a[$open_model][$value] = $this->$newModel->customArray[$value][$record[$open_model][$value]];
			}else
			    $a[$open_model][$value] = $record[$open_model][$value];

	        }
                 endforeach;

                $objPHPExcel->setActiveSheetIndex(0)->fromArray($a, NULL, 'A' . $x);

                $x++;

            endforeach;
            
            $filename = $filedate . "_" . $open_model . "_Report.xls";
//            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; ; charset=utf8-bin');
//            header('Content-Disposition: attachment;filename="' . $filename . '');
//            header('Cache-Control: max-age=10');
//            header("Pragma: public");
//            header("Expires: 0");
//            header("Content-Type: application/vnd.ms-excel; charset=utf8-bin");
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            if (isset($_ENV['company_id']) && $_ENV['company_id'] != null) {

                if (!file_exists(WWW_ROOT . 'files' . DS . $_ENV['company_id'] . DS . 'Reports' . DS . $scheduleType . DS . $open_model. DS .$filedate)) {

                    $folder = new Folder();
                    $folder->create(WWW_ROOT . 'files' . DS . $_ENV['company_id'] . DS .  'Reports' . DS . $scheduleType . DS . $open_model . DS .$filedate, 0777);
                }

                $objWriter->save(WWW_ROOT . 'files' . DS . $_ENV['company_id'] . DS . 'Reports' . DS . $scheduleType . DS . $open_model . DS .$filedate . DS . $filename);
            } else {

                if (!file_exists(WWW_ROOT . 'files' . DS . $this->Session->read('User.company_id') . DS . 'Reports' . DS . $scheduleType . DS . $open_model. DS .$filedate)) {
                    $folder = new Folder();
                    $folder->create(WWW_ROOT . 'files' . DS . $this->Session->read('User.company_id') . DS . 'Reports' . DS . $scheduleType . DS . $open_model . DS .$filedate, 0777);
                }
                $objWriter->save(WWW_ROOT . 'files' . DS . $this->Session->read('User.company_id') . DS . 'Reports' . DS . $scheduleType . DS . $open_model . DS .$filedate . DS . $filename);
            }
        } 
        return 1;
    }

    public function generate_task_report($scheduleType = 'Monthly', $from_date = null, $to_date = null) {

        $model_list = array('Housekeeping' => array('Date', 'Task', 'Details', 'Assigned To', 'Status', 'Comments'),
            'TaskStatus' => array('Date', 'Task', 'Format', 'Assigned To', 'Status', 'Comments'),
            'DatabackupLogbook' => array('Date', 'Task', 'Backup Details', 'Assigned To', 'Status', 'Comments'));

        if ($scheduleType == 'Weekly') {
            if($from_date == null && $to_date == NULL){
                $from_date = date('Y-m-d', strtotime('first day of -1 month'));
                $to_date = date('Y-m-d', strtotime('last day of -1 month'));
                $filedate = date('Y-m-d');
            }else{
                $filedate = date('Y-m-d',  strtotime($from_date));
                
            }
        } else {
            if($from_date == null && $to_date == NULL){
                $from_date = date('Y-m-d', strtotime('monday last week'));
                $to_date = date('Y-m-d', strtotime('sunday last week'));
                $filedate = date('Y-m-d');
            }else{
                
                $filedate = date('Y-m-d',  strtotime($from_date));
                
            }
        }

        foreach ($model_list as $open_model => $get_titles) {
	     $a = array();
            $this->loadModel($open_model);

            if ($open_model == 'Housekeeping') {
                App::import('Controller', 'Housekeepings');
                $this->Housekeepings = new HousekeepingsController();
                $schedules = $this->Housekeepings->index(true, $from_date, $to_date);
            } else if ($open_model == 'TaskStatus') {
                App::import('Controller', 'TaskStatuses');
                $this->TaskStatuses = new TaskStatusesController();
                $schedules = $this->TaskStatuses->index(null, true, $from_date, $to_date);
            } else if ($open_model == 'DatabackupLogbook') {
                App::import('Controller', 'DatabackupLogbooks');
                $this->DatabackupLogbooks = new DatabackupLogbooksController();
                $schedules = $this->DatabackupLogbooks->index(null, true, $from_date, $to_date);
            }
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator("FlinkISO")->setLastModifiedBy("FlinkISO")->setTitle("FlinkISO Daily Data Entry Report")->setSubject("Office 2007 XLSX Test Document")->setDescription("These are standard import formats for data to be importaed to flinkISO application")->setKeywords("office 2007 openxml php")->setCategory("FlinkISO");
            $styleHeader = array(
                'font' => array(
                    'size' => 16,
                    'bold' => false,
                    'color' => array(
                        'rgb' => '428BCA'
                    ),
                    'name' => 'Arial'
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array(
                        'rgb' => 'ffffff'
                    )
                ),
                'alignment' => array(
                    'wrapText' => true
                )
            );
            $styleNil = array(
                'font' => array(
                    'bold' => true,
                    'color' => array(
                        'rgb' => 'FFFFFF'
                    ),
                    'name' => 'Arial'
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array(
                        'rgb' => '428BCA'
                    )
                ),
                'alignment' => array(
                    'wrapText' => true
                )
            );

            $objPHPExcel->setActiveSheetIndex(0)->setTitle(substr($open_model, 0, 30));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'FlinkISO : ' . $open_model . ' data');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1');
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:H1')->applyFromArray($styleHeader);
            $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
            $i = 2;
            $format_header = $this->create_header($open_model);

        if ($format_header) {
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:J3');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A3", $format_header['MasterListOfFormat']['title'])->getStyle("A3:J3")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:C4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A4", "Document Number")->getStyle("A4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D4", $format_header['MasterListOfFormat']['document_number'])->getStyle("D4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:C5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A5", "Revision Number")->getStyle("A5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D5", $format_header['MasterListOfFormat']['revision_number'])->getStyle("D5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:C6');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A6", "Revision Date")->getStyle("A6")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D6", $format_header['MasterListOfFormat']['revision_date'])->getStyle("D6")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:G4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F4", "Prepared By")->getStyle("F4:F4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F5:G5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F5", "Approved By")->getStyle("F5:G5")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H4:J4');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H4", $format_header['PreparedBy']['name'])->getStyle("H4:J4")->applyFromArray($this->styleBorder);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H5:J5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H5", $format_header['PreparedBy']['name'])->getStyle("H5:J5")->applyFromArray($this->styleBorder);

            $i = 9;
        }
            if (isset($schedules) && $schedules) {
                foreach ($schedules as $key => $schedule_days) {
                    $x = "A";
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $key . ' Task');
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $i . ':H' . $i);
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $i . ':H' . $i)->applyFromArray($styleHeader);
                    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(25);

                    $i++;
                    $a = array();
                    foreach ($get_titles as $y) {
                        $objPHPExcel->setActiveSheetIndex(0)->getStyle($x . $i)->applyFromArray($styleNil);
                        $x++;
                    }
                    $objPHPExcel->setActiveSheetIndex(0)->fromArray($get_titles, NULL, 'A' . $i);
                    $i++;
                    foreach ($schedule_days as $taskKey => $tasks) {
                        foreach ($tasks as $task) {

                            if ($open_model == 'Housekeeping' && isset($task['Housekeeping'])) {
                                if (isset($task['Housekeeping']['task_performed']) && $task['Housekeeping']['task_performed'] == 1)
                                    $task_performed = 'Yes';
                                else
                                    $task_performed = 'No';

                                $task['Housekeeping']['comments'] =  isset($task['Housekeeping']['comments']) ? $task['Housekeeping']['comments'] : '';


                                $a = array($taskKey, $task['HousekeepingChecklist']['title'], $task['HousekeepingResponsibility']['description'], $task['Employee']['name'], $task_performed, $task['Housekeeping']['comments']);
                            }
                            else if ($open_model == 'TaskStatus' && isset($task['TaskStatus'])) {
                                if (isset($task['TaskStatus']['task_performed']) && $task['TaskStatus']['task_performed'] == 1)
                                    $task_performed = 'Yes';
                                else
                                    $task_performed = 'No';

                                $task['TaskStatus']['comments'] =  isset($task['TaskStatus']['comments']) ? $task['TaskStatus']['comments'] : '';

                                $a = array($taskKey, $task['Task']['name'], $task['MasterListOfFormat']['title'], $task['User']['name'], $task_performed, $task['TaskStatus']['comments']);
                            }else if ($open_model == 'DatabackupLogbook' && isset($task['DatabackupLogbook'])) {
                                if (isset($task['DatabackupLogbook']['task_performed'] ) && $task['DatabackupLogbook']['task_performed'] == 1)
                                    $task_performed = 'Yes';
                                else
                                    $task_performed = 'No';

                                 $task['DatabackupLogbook']['comments'] =  isset($task['DatabackupLogbook']['comments']) ? $task['DatabackupLogbook']['comments'] : '';

                                $a = array($taskKey, $task['DailyBackupDetail']['name'], $task['DataBackUp']['name'], $task['Employee']['name'], $task_performed, $task['DatabackupLogbook']['comments']);
                            }
                            $objPHPExcel->setActiveSheetIndex(0)->fromArray($a, NULL, 'A' . $i);

                            $i++;
                        }
                    }
                }
            }
            $filename = $filedate . "_" . $open_model . "_Report.xls";
//            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; ; charset=utf8-bin');
//            header('Content-Disposition: attachment;filename="' . $filename . '');
//            header('Cache-Control: max-age=10');
//            header("Pragma: public");
//            header("Expires: 0");
//            header("Content-Type: application/vnd.ms-excel; charset=utf8-bin");
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            if (isset($_ENV['company_id']) && $_ENV['company_id'] != null) {
                if (!file_exists(WWW_ROOT . 'files' . DS . $_ENV['company_id'] . DS . 'Reports' . DS . $scheduleType . DS . $open_model . DS . $filedate)) {
                    $folder = new Folder();
                    $folder->create(WWW_ROOT . 'files' . DS . $_ENV['company_id'] . DS . 'Reports' . DS . $scheduleType . DS . $open_model . DS . $filedate, 0777);
                }
                $objWriter->save(WWW_ROOT . 'files' . DS . $_ENV['company_id'] . DS . 'Reports' . DS . $scheduleType . DS . $open_model . DS . $filedate . DS . $filename);
            } else {
                if (!file_exists(WWW_ROOT . 'files' . DS . $this->Session->read('User.company_id') . DS . 'Reports' . DS . $scheduleType . DS . $open_model . DS .$filedate)) {
                    $folder = new Folder();
                    $folder->create(WWW_ROOT . 'files' . DS . $this->Session->read('User.company_id') . DS . 'Reports' . DS . $scheduleType . DS . $open_model . DS . $filedate, 0777);
                }
                $objWriter->save(WWW_ROOT . 'files' . DS . $this->Session->read('User.company_id') . DS . 'Reports' . DS . $scheduleType . DS . $open_model . DS . $filedate . DS . $filename);
            }
        }
        return 1;
    }
    
    public function manual_reports($Date = null){
        if($Date != null){
            ini_set('max_execution_time', 300);
            ini_set('memory_limit', '64M');
            $this->layout = FALSE;
            $date = date('Y-m-d', strtotime($Date));
            $enddate = date('Y-m-t', strtotime($Date));
            $begin = new DateTime( $date);
            $end = new DateTime($enddate);
            $end = $end->modify( '+1 day' );
            $Daillyinterval = new DateInterval('P1D');
            $dailyRange = new DatePeriod($begin, $Daillyinterval ,$end);
           
            $Weeklyinterval = new DateInterval('P1W');
            $WeeklyRange = new DatePeriod($begin, $Weeklyinterval ,$end);
            
            $Monthlyinterval = new DateInterval('P1M');
            $MonthlyRange = new DatePeriod($begin, $Monthlyinterval ,$end);
            
            $Histories = new HistoriesController();
            
            // Generate Daily Report;
            
            foreach($dailyRange as $dailydate){
                $from = $dailydate->format("Y-m-d");
                if($from <= date('Y-m-d')){
                    $this->_generate_daily_data_entry_report($from);
                    $this->_daily_data_backups($from);
                    $this->requestAction('/histories/prepare_graph_data/'.$from.'/'.$from);
                    $this->requestAction('/histories/prepare_graph_data_departments/'.$from.'/'.$from);
                    $this->requestAction('/histories/prepare_graph_data_branches/'.$from.'/'.$from);
                    $this->requestAction('/histories/prepare_graph_data_departmentwise/'.$from.'/'.$from);
                    $this->requestAction('/histories/prepare_graph_data_branchwise/'.$from.'/'.$from);
                    
                }
            }
            // Generate Weekly Report;
            foreach($WeeklyRange as $Weeklydate){
                $from_date = $Weeklydate->format("Y-m-d");
                
                $from_date = date('Y-m-d', strtotime('last monday',  strtotime($from_date)));
                $to_date = date('Y-m-d', strtotime('next sunday',strtotime($from_date)));
                $date = date('Y-m-d');
                if($from_date <= $date && $to_date <= $date){
                    $this->generate_table_report('Weekly', $from_date,$to_date);
                    $this->generate_task_report('Weekly',$from_date, $to_date);
                    $this->_weekly_nc_report($from_date,$to_date);
                }
            }
            //Generate Monthly Report;
          
            foreach($MonthlyRange as $Monthlydate){
                $from_date = date('Y-m-1', strtotime($Monthlydate->format("Y-m-d")));
                $to_date = date('Y-m-t',  strtotime($from_date));
                $date = date('Y-m-d');
                if($from_date <= $date && $to_date <= $date){
                    $this->generate_table_report('Monthly', $from_date, $to_date);
                    $this->generate_task_report('Monthly',$from_date, $to_date);
                }
            }
            return 1;
        }
        $this->loadModel('Company');
        $startDate = $this->Company->find('first',array('fields'=>'flinkiso_start_date'));
        $startDate = date('Y-m-d',  strtotime($startDate['Company']['flinkiso_start_date']));
        $dateDiff = strtotime(date("M d Y ")) - (strtotime($startDate));
        $dateDiff = floor($dateDiff/3600/24/30);
        $this->set(compact('dateDiff'));
    }
    
    public function send_email($reportType = null) {
        try{
            $this->loadModel('Company');
            $smtpSetup = $this->Company->find('first', array('fields'=> array('smtp_setup','is_smtp'),'recursive'=>-1));
            $this->loadModel('User');
            $this->User->recursive = 0;
            $emails = array();
            $MrUsers = $this->User->find('all', array('conditions' => array('User.is_mr' => 1),'fields'=>array('Employee.office_email','Employee.personal_email','Employee.name')));
            foreach ($MrUsers as $key=>$MrUser):
                if($MrUser['Employee']['office_email'] != ''){
                    $emails[$key]['mail'] = $MrUser['Employee']['office_email'];
                    $emails[$key]['name'] = $MrUser['Employee']['name'];
                }else   if($MrUser['Employee']['personal_email'] != ''){
                    $emails[$key]['mail'] = $MrUser['Employee']['personal_email'];
                    $emails[$key]['name'] = $MrUser['Employee']['name'];
                }
            endforeach;
            $baseurl = Router::url('/', true) . 'reports' . "/report_center/";
            App::uses('CakeEmail', 'Network/Email');
            if($smtpSetup['Company']['is_smtp'] == '1')
            {
                $EmailConfig = new CakeEmail("smtp");	
            }else if($smtpSetup['Company']['is_smtp'] == '0'){
                $EmailConfig = new CakeEmail("default");
            }
            foreach ($emails as $email){
                $EmailConfig->subject('FlinkISO: '.$reportType .' Report');
                $EmailConfig->to($email['mail']);
                $EmailConfig->template('ReportEmail');
                $EmailConfig->viewVars(array('baseUrl'=>$baseurl,'reportType' => $reportType,'user'=>$email['name']));
                $EmailConfig->emailFormat('html');
                $EmailConfig->send();
            }
            
            
         } catch(Exception $e) {
             exit();
         }
         exit();
    }

}
