<?php

App::uses('AppController', 'Controller');

/**
 * Products Controller
 *
 * @property Product $Product
 */
class ProductsController extends AppController {

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
        $this->paginate = array('order' => array('Product.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->Product->recursive = 1;
        $this->set('products', $this->paginate());
        $materials = $this->get_model_list('Material');
        $this->set('materials',$materials);
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
                        $searchArray[] = array('Product.' . $search => $searchKey);
                    else
                        $searchArray[] = array('Product.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('Product.branch_id' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['department_id']) {
            foreach ($this->request->query['department_id'] as $department):
                $departmentConditions[] = array('Product.department_id' => $department);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $departmentConditions));
            else
                $conditions[] = array('or' => $departmentConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('Product.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'Product.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);
        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('Product.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('Product.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->Product->recursive = 0;
        $this->paginate = array('order' => array('Product.sr_no' => 'DESC'), 'conditions' => $conditions, 'Product.soft_delete' => 0, 'recursive' => 1);
        $materials = $this->get_model_list('Material');
        $this->set('materials', $materials);
        $this->set('products', $this->paginate());
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
        if (!$this->Product->exists($id)) {
            throw new NotFoundException(__('Invalid product'));
        }
        $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
        $product = $this->Product->find('first', $options);
        $materials = $this->get_model_list('Material');
        $materialNames = array();
        foreach ($product['ProductMaterial'] as $ProductMaterial):
            $materialNames[] = $materials[$ProductMaterial['material_id']];
        endforeach;
        
        $this->set(compact('product','materialNames'));
        $dir = new Folder(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/upload/' . $product['Product']['created_by'] . '/products/' . $product['Product']['id'] . '/ProductUpload');
        $folders = $dir->read();
        $count = count($folders[1]);
        $this->set('uploadCount', $count);
        $plans = array('ProductUpload', 'ProductPlan', 'ProductRequirment', 'ProductFeasibility', 'ProductDevelopment', 'ProductRealisation');
        foreach ($plans as $plan):
            $count = 0;

            $dir = new Folder(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/upload/' . $product['Product']['created_by'] . '/products/' . $product['Product']['id'] . '/' . $plan);
            $folders = $dir->read();
            $count = count($folders[1]);
            $this->set($plan, $count);
        endforeach;
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
            $this->request->data['Product']['system_table_id'] = $this->_get_system_table_id();
            $this->Product->create();

            if ($this->Product->save($this->request->data)) {

                $this->loadModel('ProductMaterial');
                foreach ($this->request->data['ProductMaterial_material_id'] as $val) {
                    $this->ProductMaterial->create();
                    $valData = array();
                    $valData['product_id'] = $this->Product->id;
                    $valData['material_id'] = $val;
                    $valData['publish'] = 1;
                    $valData['soft_delete'] = 0;
                    $valData['system_table_id'] = $this->_get_system_table_id();
                    $this->ProductMaterial->save($valData, false);
                }

                $this->Session->setFlash(__('The product has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->Product->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The product could not be saved. Please, try again.'));
            }
        }
        $this->loadModel('Material');
        $PublishedMaterialList = $this->Material->find('list', array('conditions' => array('Material.publish' => 1, 'Material.soft_delete' => 0)));
        $this->set(compact('PublishedMaterialList'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Product->exists($id)) {
            throw new NotFoundException(__('Invalid product'));
        }

        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Product']['system_table_id'] = $this->_get_system_table_id();
            if ($this->Product->save($this->request->data, false)) {
                $this->loadModel('ProductMaterial');
                $this->ProductMaterial->deleteAll(array('ProductMaterial.product_id' => $this->Product->id), false);
                foreach ($this->request->data['ProductMaterial_material_id'] as $val) {
                    $this->ProductMaterial->create();
                    $valData = array();
                    $valData['product_id'] = $this->Product->id;
                    $valData['material_id'] = $val;
                    $valData['publish'] = 1;
                    $valData['soft_delete'] = 0;
                    $valData['system_table_id'] = $this->_get_system_table_id();
                    $this->ProductMaterial->save($valData, false);
                }

                $this->Session->setFlash(__('The product has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The product could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
            $this->request->data = $this->Product->find('first', $options);
            $selectedMaterials = $this->Product->ProductMaterial->find('all', array(
                'conditions' => array('ProductMaterial.product_id' => $id),
                'fields' => array('Material.id', 'Material.name')
            ));
            foreach ($selectedMaterials as $selectedMaterial):
                $materials[] = $selectedMaterial['Material']['id'];
            endforeach;
            $this->set(compact('materials'));
        }
        $branches = $this->Product->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $departments = $this->Product->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0)));
        $this->loadModel('Material');
        $PublishedMaterialList = $this->Material->find('list', array('conditions' => array('Material.publish' => 1, 'Material.soft_delete' => 0)));
        $this->set(compact('branches', 'departments', 'PublishedMaterialList'));
     }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approval_id = null) {
        if (!$this->Product->exists($id)) {
            throw new NotFoundException(__('Invalid product'));
        }

        $this->loadModel('Approval');
        if (!$this->Approval->exists($approval_id)) {
            throw new NotFoundException(__('Invalid approval id'));
        }

        $approval = $this->Approval->read(null, $approval_id);
        $this->set('same', $approval['Approval']['user_id']);

        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Product->save($this->request->data)) {

                $this->loadModel('ProductMaterial');
                $this->ProductMaterial->deleteAll(array('ProductMaterial.product_id' => $this->Product->id), false);
                foreach ($this->request->data['ProductMaterial_material_id'] as $val) {
                    $this->ProductMaterial->create();
                    $valData = array();
                    $valData['product_id'] = $this->Product->id;
                    $valData['material_id'] = $val;
                    $valData['publish'] = 1;
                    $valData['soft_delete'] = 0;
                    $valData['system_table_id'] = $this->_get_system_table_id();
                    $this->ProductMaterial->save($valData, false);
                }

                $this->Session->setFlash(__('The product has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The product could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
            $this->request->data = $this->Product->find('first', $options);
            $selectedMaterials = $this->Product->ProductMaterial->find('all', array(
                'conditions' => array('ProductMaterial.product_id' => $id),
                'fields' => array('Material.id', 'Material.name')
            ));
            foreach ($selectedMaterials as $selectedMaterial):
                $materials[] = $selectedMaterial['Material']['id'];
            endforeach;
            $this->set(compact('materials'));
        }
        $branches = $this->Product->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $departments = $this->Product->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0)));
        $this->loadModel('Material');
        $PublishedMaterialList = $this->Material->find('list', array('conditions' => array('Material.publish' => 1, 'Material.soft_delete' => 0)));
        $this->set(compact('branches', 'departments', 'PublishedMaterialList'));
    }

    public function product_design() {
        $plans = array('ProductPlan', 'ProductRequirment', 'ProductFeasibility', 'ProductDevelopment', 'ProductRealisation');

        foreach ($plans as $plan):
            $count = 0;
            $dir = new Folder(WWW_ROOT . 'files/' . $this->Session->read('User.company_id') . '/upload/' . $this->request->params['pass'][2] . '/products/' . $this->request->params['pass'][1] . '/' . $plan);
            $folders = $dir->read();
            $count = count($folders[1]);
            $this->set($plan, $count);
        endforeach;
    }

    public function product_upload() {

    }

}
