<?php

App::uses('AppController', 'Controller');

/**
 * Materials Controller
 *
 * @property Material $Material
 */
class MaterialsController extends AppController {

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
        $this->paginate = array('order' => array('Material.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->Material->recursive = 1;
        $this->set('materials', $this->paginate());

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
                        $searchArray[] = array('Material.' . $search => $searchKey);
                    else
                        $searchArray[] = array('Material.' . $search . ' like ' => '%' . $searchKey . '%');
                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }
        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('Material.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('Material.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'Material.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);
        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('Material.branchid' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Material.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->Material->recursive = 1;
        $this->paginate = array('order' => array('Material.sr_no' => 'DESC'), 'conditions' => $conditions, 'Material.soft_delete' => 0);
        $this->set('materials', $this->paginate());

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
        if (!$this->Material->exists($id)) {
            throw new NotFoundException(__('Invalid material'));
        }
        $options = array('conditions' => array('Material.' . $this->Material->primaryKey => $id));
        $this->set('material', $this->Material->find('first', $options));
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
            $this->request->data['Material']['system_table_id'] = $this->_get_system_table_id();
            $this->Material->create();
            $this->request->data['MaterialListWithShelfLife']['publish'] = isset($this->request->data['Material']['publish']) ? $this->request->data['Material']['publish'] : 0;
            $this->request->data['MaterialListWithShelfLife']['soft_delete'] = 0;
            $systemTableIdM = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => 'material_list_with_shelf_lives')));
            $this->request->data['MaterialListWithShelfLife']['system_table_id'] = $systemTableIdM['SystemTable']['id'];

            //get Master List of format_id
            $masterListShelfId = $this->Material->MaterialListWithShelfLife->MasterListOfFormat->find('first', array(
                'conditions' => array('MasterListOfFormat.system_table_id' => $systemTableIdM['SystemTable']['id']),
                'recursive' => 0,
                'fields' => array('MasterListOfFormat.id'),
                    )
            );
            $this->request->data['MaterialListWithShelfLife']['master_list_of_format_id'] = $masterListShelfId['MasterListOfFormat']['id'];

            if ($this->Material->save($this->request->data, false)) {

                $this->Material->MaterialListWithShelfLife->create();
                $this->request->data['MaterialListWithShelfLife']['material_id'] = $this->Material->id;
                $this->Material->MaterialListWithShelfLife->save($this->request->data['MaterialListWithShelfLife']);

                $this->Session->setFlash(__('The material has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->Material->id));
                else
                    $this->redirect(str_replace('/lists', '/add_ajax', $this->referer()));
            } else {
                $this->Session->setFlash(__('The material could not be saved. Please, try again.'));
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
        if (!$this->Material->exists($id)) {
            throw new NotFoundException(__('Invalid material'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Material']['system_table_id'] = $this->_get_system_table_id();
            if ($this->Material->save($this->request->data, false)) {

                //edit MaterialListWithShelfLife
                $shelfLife = $this->Material->MaterialListWithShelfLife->find('first', array('conditions' => array('MaterialListWithShelfLife.material_id' => $this->request->data['Material']['id']), 'recursive' => -1));

                $newData['MaterialListWithShelfLife']['id'] = $shelfLife['MaterialListWithShelfLife']['id'];
                $newData['MaterialListWithShelfLife']['material_id'] = $id;
                $newData['MaterialListWithShelfLife']['shelflife_by_manufacturer'] = $this->request->data['MaterialListWithShelfLife']['shelflife_by_manufacturer'];
                $newData['MaterialListWithShelfLife']['shelflife_by_company'] = $this->request->data['MaterialListWithShelfLife']['shelflife_by_company'];
                $newData['MaterialListWithShelfLife']['remarks'] = $this->request->data['MaterialListWithShelfLife']['remarks'];
                $newData['MaterialListWithShelfLife']['publish'] = 1;
                $this->Material->MaterialListWithShelfLife->save($newData, false);
                $this->Material->MaterialQualityCheck->deleteAll(array('MaterialQualityCheck.material_id' => $this->Material->id), false);

                $this->Session->setFlash(__('The material has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The material could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Material.' . $this->Material->primaryKey => $id));
            $this->request->data = $this->Material->find('first', $options);
        }
        $materialShelfLife = $this->Material->MaterialListWithShelfLife->find('all', array('conditions' => array('MaterialListWithShelfLife.material_id' => $id), 'fields' => array('MaterialListWithShelfLife.shelflife_by_manufacturer', 'MaterialListWithShelfLife.shelflife_by_company', 'MaterialListWithShelfLife.remarks')));
        $materialShelfLifeMfg = $materialShelfLife[0]['MaterialListWithShelfLife']['shelflife_by_manufacturer'];
        $materialShelfLifeCo = $materialShelfLife[0]['MaterialListWithShelfLife']['shelflife_by_company'];
        $materialShelfLifeRem = $materialShelfLife[0]['MaterialListWithShelfLife']['remarks'];
        $this->set(compact('materialShelfLifeMfg', 'materialShelfLifeCo', 'materialShelfLifeRem'));
       $materialQualityCheck = $this->Material->MaterialQualityCheck->find('all', array('conditions' => array('MaterialQualityCheck.publish' => 1, 'MaterialQualityCheck.soft_delete' => 0)));
        $this->set(compact('materialQualityCheck'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->Material->exists($id)) {
            throw new NotFoundException(__('Invalid material'));
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
            if ($this->Material->save($this->request->data, false)) {

                //approve MaterialListWithShelfLife
                $shelfLife = $this->Material->MaterialListWithShelfLife->find('first', array('conditions' => array('MaterialListWithShelfLife.material_id' => $this->request->data['Material']['id']), 'recursive' => -1));

                $newData['MaterialListWithShelfLife']['id'] = $shelfLife['MaterialListWithShelfLife']['id'];
                $newData['MaterialListWithShelfLife']['shelflife_by_manufacturer'] = $this->request->data['MaterialListWithShelfLife']['shelflife_by_manufacturer'];
                $newData['MaterialListWithShelfLife']['shelflife_by_company'] = $this->request->data['MaterialListWithShelfLife']['shelflife_by_company'];
                $newData['MaterialListWithShelfLife']['remarks'] = $this->request->data['MaterialListWithShelfLife']['remarks'];
                $newData['MaterialListWithShelfLife']['publish'] = 1;
                $this->Material->MaterialListWithShelfLife->save($newData, false);

                $this->Session->setFlash(__('The material has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The material could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Material.' . $this->Material->primaryKey => $id));
            $this->request->data = $this->Material->find('first', $options);
        }
        $materialShelfLife = $this->Material->MaterialListWithShelfLife->find('all', array('conditions' => array('MaterialListWithShelfLife.material_id' => $id), 'fields' => array('MaterialListWithShelfLife.shelflife_by_manufacturer', 'MaterialListWithShelfLife.shelflife_by_company', 'MaterialListWithShelfLife.remarks')));
        $materialShelfLifeMfg = $materialShelfLife[0]['MaterialListWithShelfLife']['shelflife_by_manufacturer'];
        $materialShelfLifeCo = $materialShelfLife[0]['MaterialListWithShelfLife']['shelflife_by_company'];
        $materialShelfLifeRem = $materialShelfLife[0]['MaterialListWithShelfLife']['remarks'];
        $this->set(compact('materialShelfLifeMfg', 'materialShelfLifeCo', 'materialShelfLifeRem'));

    }

    public function get_material_name($materialName = null, $id = null) {
        if ($materialName) {
            if ($id) {
                $materials = $this->Material->find('all', array('conditions' => array('Material.name' => $materialName, 'Material.id !=' => $id)));
            } else {
                $materials = $this->Material->find('all', array('conditions' => array('Material.name' => $materialName)));
            }
            $this->set('materials', $materials);
        }
    }

    public function get_process($i = null) {
        $this->set('i', $i);
    }

    public function get_material_qc_required() {
	App::uses('ConnectionManager', 'Model');
        $dataSource = ConnectionManager::getDataSource('default');
        $prefix = $dataSource->config['prefix'];
        $this->paginate = array('limit' => 2,
            'fields' => array(
                'Material.id', 'Material.name'
            ),
            'conditions' => array('Material.soft_delete' => 0, 'Material.publish' => 1, 'Material.qc_required' => 1, 'Material.id NOT IN (select material_id from '.$prefix.'material_quality_checks)'),
            'recursive' => -1);

        $qcStepsPending = $this->paginate();



        $this->set('qcStepsPending', $qcStepsPending);
        $this->set('qcStepsCount', $this->request->params['paging']['Material']['count']);
        $this->render('/Elements/material_qc_steps');
    }

}
