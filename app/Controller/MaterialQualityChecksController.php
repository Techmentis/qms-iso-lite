<?php

App::uses('AppController', 'Controller');

/**
 * MaterialQualityChecks Controller
 *
 * @property MaterialQualityCheck $MaterialQualityCheck
 */
class MaterialQualityChecksController extends AppController {

    public function _get_system_table_id() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $this->request->params['controller'])));
        return $systemTableId['SystemTable']['id'];
    }

    public function _get_count() {

        $onlyBranch = null;
        $onlyOwn = null;
        $condition = null;

        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('MaterialQualityCheck.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('MaterialQualityCheck.created_by' => $this->Session->read('User.id'));
        $conditions = array($onlyBranch, $onlyOwn);

        $count = $this->MaterialQualityCheck->find('count', array('conditions' => $condition, 'group' => 'MaterialQualityCheck.material_id'));
        $published = $this->MaterialQualityCheck->find('count', array('conditions' => array($condition, 'MaterialQualityCheck.publish' => 1, 'MaterialQualityCheck.soft_delete' => 0), 'group' => 'MaterialQualityCheck.material_id'));
        $unpublished = $this->MaterialQualityCheck->find('count', array('conditions' => array($condition, 'MaterialQualityCheck.publish' => 0, 'MaterialQualityCheck.soft_delete' => 0), 'group' => 'MaterialQualityCheck.material_id'));
        $deleted = $this->MaterialQualityCheck->find('count', array('conditions' => array($condition, 'MaterialQualityCheck.soft_delete' => 1), 'group' => 'MaterialQualityCheck.material_id'));
        $this->set(compact('count', 'published', 'unpublished', 'deleted'));
    }

    public function material_count($count = null) {
        $materialCount = $this->MaterialQualityCheck->find('count', array('conditions' => array('MaterialQualityCheck.material_id' => $count)));
        return $materialCount;
    }

    public function get_process($i = null) {
        $this->set('i', $i);
    }

    public function get_material_check($id = null) {

        $materialQualityChecks = $this->MaterialQualityCheck->find('all', array('conditions' => array('MaterialQualityCheck.material_id' => $id, 'MaterialQualityCheck.publish' => 1, 'MaterialQualityCheck.soft_delete' => 0), 'order' => array('MaterialQualityCheck.sr_no' => 'ASC')));
        $this->set('materialQualityChecks', $materialQualityChecks);
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {

        $conditions = $this->_check_request();
        $this->paginate = array('order' => array('MaterialQualityCheck.sr_no' => 'DESC'), 'group' => 'MaterialQualityCheck.material_id', 'conditions' => array($conditions));
        $this->MaterialQualityCheck->recursive = 0;
        $this->set('materialQualityChecks', $this->paginate());

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
                        $searchArray[] = array('MaterialQualityCheck.' . $search => $searchKey);
                    else
                        $searchArray[] = array('MaterialQualityCheck.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $searchArray);
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('MaterialQualityCheck.branchid' => $branches);
            endforeach;
            $conditions[] = array('or' => $branchConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('MaterialQualityCheck.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'MaterialQualityCheck.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);
        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('MaterialQualityCheck.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('MaterialQualityCheck.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);
        $this->MaterialQualityCheck->recursive = 0;
        $this->paginate = array('order' => array('MaterialQualityCheck.sr_no' => 'DESC'), 'group' => 'MaterialQualityCheck.material_id','conditions' => $conditions, 'MaterialQualityCheck.soft_delete' => 0);
        $this->set('materialQualityChecks', $this->paginate());

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
        if (!$this->MaterialQualityCheck->Material->exists($id)) {
            throw new NotFoundException(__('Invalid material quality check'));
        }
        $options = array('conditions' => array('MaterialQualityCheck.material_id' => $id),'order' => array('MaterialQualityCheck.sr_no' => 'ASC'),'recursive'=>-1);
        $this->set('materialQualityChecks', $this->MaterialQualityCheck->find('all', $options));
        $this->set('materialName', $this->MaterialQualityCheck->Material->find('first', array('conditions' => array('Material.id' => $id), 'fields' => array('name','created_by'))));
    }

    /**
     * list method
     *
     * @return void
     */
    public function lists($materialId = null) {
        $this->_get_count();
        $this->set('materialId', $materialId);
    }

    /**
     * add_ajax method
     *
     * @return void
     */
    public function add_ajax($materialId = null) {
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post')) {
            $flag = 0;

                foreach ($this->request->data['MaterialQC'] as $val) {
                    $this->MaterialQualityCheck->create();
                    $data['MaterialQualityCheck']['material_id'] = $this->request->data['MaterialQualityCheck']['material_id'];
                    $data['MaterialQualityCheck']['name'] = $val['name'];
                    $data['MaterialQualityCheck']['details'] = $val['details'];
                    $data['MaterialQualityCheck']['active_status'] = $val['active_status'];
                    $data['MaterialQualityCheck']['is_last_step'] = 0;
                    $data['MaterialQualityCheck']['publish'] = 1;
                $data['MaterialQualityCheck']['system_table_id'] = $this->_get_system_table_id();
                    $this->MaterialQualityCheck->save($data['MaterialQualityCheck']);
                }

            // add 'is_last_step' to last record saved.
            if($this->MaterialQualityCheck->id){
                $data = array();
                $data['id'] = $this->MaterialQualityCheck->id;
                $data['is_last_step'] = 1;
                $this->MaterialQualityCheck->save($data);
                $flag = 1;
            }
            if ($this->MaterialQualityCheck->save($this->request->data)) {

                $this->Session->setFlash(__('The material quality check has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'index'));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The material quality check could not be saved. Please, try again.'));
            }
        }
        $materials = $this->MaterialQualityCheck->Material->find('list', array('conditions' => array('Material.publish' => 1, 'Material.soft_delete' => 0, 'Material.qc_required' => 1)));
        $this->set(compact('materials', 'materialId'));
    }

    /**
     *  *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->MaterialQualityCheck->Material->exists($id)) {
            throw new NotFoundException(__('Invalid material quality check'));
        }
        $flag = 0;
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $idsArray = array();
            $this->request->data['MaterialQualityCheck']['system_table_id'] = $this->_get_system_table_id();
            $allQualityChecks = $this->MaterialQualityCheck->find('list', array('conditions' => array('MaterialQualityCheck.material_id' => $this->request->data['MaterialQualityCheck']['material_used']), 'fields' => 'MaterialQualityCheck.id'));

            foreach ($this->request->data['MaterialQC'] as $key => $val) {
                if (isset($val['material_quality_check_id'])) {
                    $idsArray[] = $val['material_quality_check_id'];
                }
            }
            $idsToBeDeleted = array_diff($allQualityChecks, $idsArray);
            foreach ($idsToBeDeleted as $deleteID) {
                $this->MaterialQualityCheck->delete($deleteID, false);
                }

                foreach ($this->request->data['MaterialQC'] as $val) {
                    $data = array();
                    $data['MaterialQualityCheck']['system_table_id'] = $this->_get_system_table_id();
                    if (isset($val['material_quality_check_id'])) {
                        $data['MaterialQualityCheck']['id'] = $val['material_quality_check_id'];
                        $data['MaterialQualityCheck']['name'] = $val['name'];
                        $data['MaterialQualityCheck']['details'] = $val['details'];
                        $data['MaterialQualityCheck']['active_status'] = $val['active_status'];
                        $data['MaterialQualityCheck']['is_last_step'] = 0;
                        $data['MaterialQualityCheck']['publish'] = 1;
                        $this->MaterialQualityCheck->save($data['MaterialQualityCheck']);
                    } else {
                        $this->MaterialQualityCheck->create();
                        $data['MaterialQualityCheck']['material_id'] = $id;
                        $data['MaterialQualityCheck']['name'] = $val['name'];
                        $data['MaterialQualityCheck']['details'] = $val['details'];
                        $data['MaterialQualityCheck']['active_status'] = $val['active_status'];
                        $data['MaterialQualityCheck']['is_last_step'] = 0;
                        $data['MaterialQualityCheck']['publish'] = 1;
                        $this->MaterialQualityCheck->save($data['MaterialQualityCheck']);
                    }
                }

            // add 'is_last_step' to last record saved.
            if($this->MaterialQualityCheck->id){
                $data = array();
                $data['id'] = $this->MaterialQualityCheck->id;
                $data['is_last_step'] = 1;
                $this->MaterialQualityCheck->save($data);
                $flag = 1;
            }
            if ($flag) {

                $this->Session->setFlash(__('The material quality check has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The material quality check could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('MaterialQualityCheck.material_id' => $id));
            $this->request->data = $this->MaterialQualityCheck->find('first', $options);
        }
        $MaterialQualityChecks = $this->MaterialQualityCheck->find('all', array('conditions' => array('MaterialQualityCheck.material_id' => $id, 'MaterialQualityCheck.publish' => 1, 'MaterialQualityCheck.soft_delete' => 0), 'order' => array('MaterialQualityCheck.sr_no' => 'ASC')));

        $this->loadModel('MaterialQualityCheckDetails');
        foreach ($MaterialQualityChecks as $key => $value) {
            $mqcCount = $this->MaterialQualityCheckDetails->find('count', array('conditions' => array('MaterialQualityCheckDetails.material_quality_check_id' => $value['MaterialQualityCheck']['id'])));
            $value['MaterialQualityCheck']['check_performed'] = $mqcCount ?  1 : 0;
            $MaterialQualityChecks[$key] = $value;
        }

        $materials = $this->MaterialQualityCheck->Material->find('list', array('conditions' => array('Material.publish' => 1, 'Material.soft_delete' => 0)));
        $this->set(compact('materials', 'MaterialQualityChecks'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->MaterialQualityCheck->exists($id)) {
            throw new NotFoundException(__('Invalid material quality check'));
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
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $idsArray = array();
             foreach ($this->request->data['MaterialQC'] as $key => $val) {
                if (isset($val['material_quality_check_id'])) {
                    $idsArray[] = $val['material_quality_check_id'];
                }
            }
            if (!isset($idsArray) || empty($idsArray)) {
                $this->MaterialQualityCheck->create();
                foreach ($this->request->data['MaterialQC'] as $val) {
                    $this->MaterialQualityCheck->create();
                    $data['MaterialQualityCheck']['material_id'] = $id;
                    $data['MaterialQualityCheck']['name'] = $val['name'];
                    $data['MaterialQualityCheck']['details'] = $val['details'];
                    $data['MaterialQualityCheck']['active_status'] = $val['active_status'];
                    $data['MaterialQualityCheck']['is_last_step'] = 0;
                    $data['MaterialQualityCheck']['publish'] = 1;
                    $this->MaterialQualityCheck->save($data['MaterialQualityCheck']);
                }
                $this->MaterialQualityCheck->save($this->request->data);
            } else {
                foreach ($this->request->data['MaterialQC'] as $val) {
                    if (isset($val['material_quality_check_id'])) {
                        $this->request->data['MaterialQualityCheck']['id'] = $val['material_quality_check_id'];
                        $this->request->data['MaterialQualityCheck']['name'] = $val['name'];
                        $this->request->data['MaterialQualityCheck']['details'] = $val['details'];
                        $this->request->data['MaterialQualityCheck']['active_status'] = $val['active_status'];
                        $this->request->data['MaterialQualityCheck']['is_last_step'] = 0;
                        $this->request->data['MaterialQualityCheck']['publish'] = 1;
                        $this->MaterialQualityCheck->save($this->request->data['MaterialQualityCheck']);
                    } else {
                        $this->MaterialQualityCheck->create();
                        $data['MaterialQualityCheck']['material_id'] = $id;
                        $data['MaterialQualityCheck']['name'] = $val['name'];
                        $data['MaterialQualityCheck']['details'] = $val['details'];
                        $data['MaterialQualityCheck']['active_status'] = $val['active_status'];
                        $data['MaterialQualityCheck']['is_last_step'] = 0;
                        $data['MaterialQualityCheck']['publish'] = 1;
                        $this->MaterialQualityCheck->save($data['MaterialQualityCheck']);
                    }
                }
            }
            // add 'is_last_step' to last record saved.
            if($this->MaterialQualityCheck->id){
                $data = array();
                $data['id'] = $this->MaterialQualityCheck->id;
                $data['is_last_step'] = 1;
                $this->MaterialQualityCheck->save($data);
                $flag = 1;
            }
            if ($flag) {

                $this->Session->setFlash(__('The material quality check has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The material quality check could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('MaterialQualityCheck.' . $this->MaterialQualityCheck->primaryKey => $id));
            $this->request->data = $this->MaterialQualityCheck->find('first', $options);
        }
        $materials = $this->MaterialQualityCheck->Material->find('list', array('conditions' => array('Material.publish' => 1, 'Material.soft_delete' => 0)));
        $this->set(compact('materials'));
    }

    public function purge_all($ids = null) {
        $flag = 0;
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);
        $modelName = $this->modelClass;
        $this->loadModel('Approval');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $this->$modelName->id = $id;
                    $this->request->onlyAllow('post', 'delete');
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
                    $MaterialQualityChecks = $this->MaterialQualityCheck->find('all', array('conditions' => array('MaterialQualityCheck.material_id' => $id)));
                    foreach ($MaterialQualityChecks as $MaterialQualityCheck) {
                        if ($this->MaterialQualityCheck->delete($MaterialQualityCheck['MaterialQualityCheck']['id'], true)) {
                            $flag = 1;
                        } else {
                            $flag = 0;
                            $this->Session->setFlash(__('All selected value was not deleted'));
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }
            }
        }else{
            $this->Session->setFlash(__('Please select some values delete'));
            $this->redirect(array('action' => 'index'));
        }

        if ($flag) {
            $this->Session->setFlash(__('All selected values deleted'));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $this->redirect(array('action' => 'index'));
    }

    /****************************************************
     *
     *      REQUIRED FUNCTION. DO NOT DELETE.
     *
     *                  restore_all()
     *
     ****************************************************/

    public function restore_all($ids = null) {
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);
        $modelName = $this->modelClass;
        $this->loadModel('Approval');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => $modelName)));
                    foreach ($approves as $approve) {
                        $approve['Approval']['soft_delete'] = 0;
                        $this->Approval->save($approve, false);
                    }
                    $MaterialQualityChecks = $this->MaterialQualityCheck->find('all', array('conditions' => array('MaterialQualityCheck.material_id' => $id)));
                    foreach ($MaterialQualityChecks as $MaterialQualityCheck) {
                        $MaterialQualityCheck['MaterialQualityCheck']['soft_delete'] = 0;
                        if ($this->MaterialQualityCheck->save($MaterialQualityCheck, false)) {
                            $flag = 1;
                        } else {
                            $flag = 0;
                        }
                    }
                }
            }
        }

        $this->Session->setFlash(__('All selected value restored'));
        $this->redirect(array(
            'action' => 'index'
        ));
    }

    /****************************************************
     *
     *          REQUIRED FUNCTION. DO NOT DELETE.
     *
     *                      purge()
     *
     ****************************************************/

    public function purge($id = null) {
        $modelName = $this->modelClass;
        $this->loadModel('Approval');
        if (!empty($id)) {
            $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => $modelName)));
            foreach ($approves as $approve) {
                $approve['Approval']['soft_delete'] = 0;
                $this->Approval->save($approve, false);
            }
            $MaterialQualityChecks = $this->MaterialQualityCheck->find('all', array('conditions' => array('MaterialQualityCheck.material_id' => $id)));
            foreach ($MaterialQualityChecks as $MaterialQualityCheck) {
                if (!($this->MaterialQualityCheck->delete($MaterialQualityCheck['MaterialQualityCheck']['id'], true))) {
                    $this->Session->setFlash(__('All selected value was not deleted from Approve'));
                    $this->redirect(array('action' => 'index'));
                }
            }
        }
        $this->Session->setFlash(__('Material quality check deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /****************************************************
     *
     *      REQUIRED FUNCTIONS LIST. DO NOT DELETE.
     *
     *                  restore()
     *
     ****************************************************/

    public function restore($id = null) {
        $modelName = $this->modelClass;
        $this->loadModel('Approval');
        if (!empty($id)) {
            $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => $modelName)));
            foreach ($approves as $approve) {
                $approve['Approval']['soft_delete'] = 0;
                $this->Approval->save($approve, false);
            }
            $MaterialQualityChecks = $this->MaterialQualityCheck->find('all', array('conditions' => array('MaterialQualityCheck.material_id' => $id)));
            foreach ($MaterialQualityChecks as $MaterialQualityCheck) {
                $MaterialQualityCheck['MaterialQualityCheck']['soft_delete'] = 0;
                if ($this->MaterialQualityCheck->save($MaterialQualityCheck, false)) {
                    $flag = 1;
                } else {
                    $flag = 0;
                }
            }
        }
        if ($flag) {
            $this->Session->setFlash(__('Material quality check deleted'));
        } else {
            $this->Session->setFlash(__('Material quality check was not deleted'));
        }

        $this->redirect(array(
            'action' => 'index'
        ));
    }

    /****************************************************
     *
     *      REQUIRED FUNCTION. DO NOT DELETE.
     *
     *                  delete()
     *
     ****************************************************/

    public function delete($id = null) {
        $modelName = $this->modelClass;
        $this->loadModel('Approval');
        if (!empty($id)) {
            $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => $modelName)));
            foreach ($approves as $approve) {
                $approve['Approval']['soft_delete'] = 1;
                $this->Approval->save($approve, false);
            }
            $MaterialQualityChecks = $this->MaterialQualityCheck->find('all', array('conditions' => array('MaterialQualityCheck.material_id' => $id)));
            foreach ($MaterialQualityChecks as $MaterialQualityCheck) {
                $MaterialQualityCheck['MaterialQualityCheck']['soft_delete'] = 1;
                if ($this->MaterialQualityCheck->save($MaterialQualityCheck, false)) {
                    $flag = 1;
                } else {
                    $flag = 0;
                }
            }
        }
        if ($flag) {
            $this->Session->setFlash(__('Material quality check deleted'));
        } else {
            $this->Session->setFlash(__('Material quality check was not deleted'));
        }

        $this->redirect(array(
            'action' => 'index'
        ));
    }

    /****************************************************
     *
     *          REQUIRED FUNCTION. DO NOT DELETE.
     *
     *                  delete_all()
     *
     ****************************************************/

    public function delete_all($ids = null) {
        if ($_POST['data'][$this->name]['recs_selected'])
            $ids = explode('+', $_POST['data'][$this->name]['recs_selected']);
        $modelName = $this->modelClass;
        $this->loadModel('Approval');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $approves = $this->Approval->find('all', array('conditions' => array('Approval.record' => $id, 'Approval.model_name' => $modelName)));
                    foreach ($approves as $approve) {
                        $approve['Approval']['soft_delete'] = 1;
                        $this->Approval->save($approve, false);
                    }
                    $MaterialQualityChecks = $this->MaterialQualityCheck->find('all', array('conditions' => array('MaterialQualityCheck.material_id' => $id)));
                    foreach ($MaterialQualityChecks as $MaterialQualityCheck) {
                        $MaterialQualityCheck['MaterialQualityCheck']['soft_delete'] = 1;
                        $this->MaterialQualityCheck->save($MaterialQualityCheck, false);
                    }
                }
            }

            $this->Session->setFlash(__('All selected value deleted'));
            $this->redirect(array('action' => 'index'));
        }else{
            $this->Session->setFlash(__('Please select some values to delete'));
            $this->redirect(array('action' => 'index'));
        }
    }

    public function quality_check($deliveryChallanId = null, $materialId = null) {
        $flag = 0;
        $materialQualityChecks = $this->MaterialQualityCheck->find('all', array('conditions' => array('MaterialQualityCheck.publish' => 1, 'MaterialQualityCheck.soft_delete' => 0, 'MaterialQualityCheck.material_id' => $materialId), 'recursive' => -1, 'order' => 'sr_no'));
        $this->loadModel('MaterialQualityCheckDetail');
        foreach ($materialQualityChecks as $key => $materialQualityCheck) {
            $materialQualityCheckDetails = $this->MaterialQualityCheckDetail->find('first', array('conditions' => array('MaterialQualityCheckDetail.publish' => 1, 'MaterialQualityCheckDetail.material_quality_check_id' => $materialQualityCheck['MaterialQualityCheck']['id'], 'MaterialQualityCheckDetail.soft_delete' => 0, 'MaterialQualityCheckDetail.delivery_challan_id' => $deliveryChallanId), 'recursive' => -1));
            if (!count($materialQualityCheckDetails)) {
                $flag++;
                if ($flag > 1)
                    $materialQualityChecks[$key]['disable'] = true;
            }
        }
        $this->set(compact('materialQualityChecks', 'deliveryChallanId', 'materialId'));
    }

}
