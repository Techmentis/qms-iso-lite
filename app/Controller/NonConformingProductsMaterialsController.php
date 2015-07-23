<?php

App::uses('AppController', 'Controller');

/**
 * NonConformingProductsMaterials Controller
 *
 * @property NonConformingProductsMaterial $NonConformingProductsMaterial
 */
class NonConformingProductsMaterialsController extends AppController {

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
        $this->paginate = array('order' => array('NonConformingProductsMaterial.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->NonConformingProductsMaterial->recursive = 0;
        $this->set('nonConformingProductsMaterials', $this->paginate());

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
            foreach ($searchKeys as $search_key):
                foreach ($this->request->query['search_fields'] as $search):
                    if ($this->request->query['strict_search'] == 0)
                        $searchArray[] = array('NonConformingProductsMaterial.' . $search => $search_key);
                    else
                        $searchArray[] = array('NonConformingProductsMaterial.' . $search . ' like ' => '%' . $search_key . '%');
                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }
        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('NonConformingProductsMaterial.branchid' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $branchConditions));
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if ($this->request->query['product_id'] != '-1') {
            $productConditions[] = array('NonConformingProductsMaterial.product_id' => $this->request->query['product_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $productConditions);
            else
                $conditions[] = array('or' => $productConditions);
        }
        if ($this->request->query['material_id'] != '-1') {
            $materialConditions[] = array('NonConformingProductsMaterial.material_id' => $this->request->query['material_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $materialConditions);
            else
                $conditions[] = array('or' => $materialConditions);
        }
        if ($this->request->query['capa_source_id'] != '-1') {
            $capaSourceConditions[] = array('NonConformingProductsMaterial.capa_source_id' => $this->request->query['capa_source_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $capaSourceConditions);
            else
                $conditions[] = array('or' => $capaSourceConditions);
        }
        if ($this->request->query['corrective_preventive_action_id'] != '-1') {
            $capaConditions[] = array('NonConformingProductsMaterial.corrective_preventive_action_id' => $this->request->query['corrective_preventive_action_id']);
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $capaConditions);
            else
                $conditions[] = array('or' => $capaConditions);
        }
        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('NonConformingProductsMaterial.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'NonConformingProductsMaterial.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);

        if ($this->Session->read('User.is_mr') == 0)
            $onlyBranch = array('NonConformingProductsMaterial.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('NonConformingProductsMaterial.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);
        $this->NonConformingProductsMaterial->recursive = 0;
        $this->paginate = array('order' => array('NonConformingProductsMaterial.sr_no' => 'DESC'), 'conditions' => $conditions, 'NonConformingProductsMaterial.soft_delete' => 0);
        $this->set('nonConformingProductsMaterials', $this->paginate());
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
        if (!$this->NonConformingProductsMaterial->exists($id)) {
            throw new NotFoundException(__('Invalid non conforming products material'));
        }
        $options = array('conditions' => array('NonConformingProductsMaterial.' . $this->NonConformingProductsMaterial->primaryKey => $id));
        $this->set('nonConformingProductsMaterial', $this->NonConformingProductsMaterial->find('first', $options));
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
            $this->request->data['NonConformingProductsMaterial']['system_table_id'] = $this->_get_system_table_id();
            $this->NonConformingProductsMaterial->create();
            if ($this->NonConformingProductsMaterial->save($this->request->data)) {

                $this->Session->setFlash(__('The non conforming products material has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->NonConformingProductsMaterial->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The non conforming products material could not be saved. Please, try again.'));
            }
        }
        $materials = $this->NonConformingProductsMaterial->Material->find('list', array('conditions' => array('Material.publish' => 1, 'Material.soft_delete' => 0)));
        $products = $this->NonConformingProductsMaterial->Product->find('list', array('conditions' => array('Product.publish' => 1, 'Product.soft_delete' => 0)));
        $capaSources = $this->NonConformingProductsMaterial->CapaSource->find('list', array('conditions' => array('CapaSource.publish' => 1, 'CapaSource.soft_delete' => 0)));
        $correctivePreventiveActions = $this->NonConformingProductsMaterial->CorrectivePreventiveAction->find('list', array('conditions' => array('CorrectivePreventiveAction.publish' => 1, 'CorrectivePreventiveAction.soft_delete' => 0)));

        $this->set(compact('materials', 'products', 'capaSources', 'correctivePreventiveActions'));
    }

    /**
     *  *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->NonConformingProductsMaterial->exists($id)) {
            throw new NotFoundException(__('Invalid non conforming products material'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['NonConformingProductsMaterial']['system_table_id'] = $this->_get_system_table_id();
            if ($this->NonConformingProductsMaterial->save($this->request->data)) {

                $this->Session->setFlash(__('The non conforming products material has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The non conforming products material could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('NonConformingProductsMaterial.' . $this->NonConformingProductsMaterial->primaryKey => $id));
            $this->request->data = $this->NonConformingProductsMaterial->find('first', $options);
        }
        $materials = $this->NonConformingProductsMaterial->Material->find('list', array('conditions' => array('Material.publish' => 1, 'Material.soft_delete' => 0)));
        $products = $this->NonConformingProductsMaterial->Product->find('list', array('conditions' => array('Product.publish' => 1, 'Product.soft_delete' => 0)));
        $capaSources = $this->NonConformingProductsMaterial->CapaSource->find('list', array('conditions' => array('CapaSource.publish' => 1, 'CapaSource.soft_delete' => 0)));
        $correctivePreventiveActions = $this->NonConformingProductsMaterial->CorrectivePreventiveAction->find('list', array('conditions' => array('CorrectivePreventiveAction.publish' => 1, 'CorrectivePreventiveAction.soft_delete' => 0)));

        $this->set(compact('materials', 'products', 'capaSources', 'correctivePreventiveActions'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->NonConformingProductsMaterial->exists($id)) {
            throw new NotFoundException(__('Invalid non conforming products material'));
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
            if ($this->NonConformingProductsMaterial->save($this->request->data)) {

                $this->Session->setFlash(__('The non conforming products material has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The non conforming products material could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('NonConformingProductsMaterial.' . $this->NonConformingProductsMaterial->primaryKey => $id));
            $this->request->data = $this->NonConformingProductsMaterial->find('first', $options);
        }
        $materials = $this->NonConformingProductsMaterial->Material->find('list', array('conditions' => array('Material.publish' => 1, 'Material.soft_delete' => 0)));
        $products = $this->NonConformingProductsMaterial->Product->find('list', array('conditions' => array('Product.publish' => 1, 'Product.soft_delete' => 0)));
        $capaSources = $this->NonConformingProductsMaterial->CapaSource->find('list', array('conditions' => array('CapaSource.publish' => 1, 'CapaSource.soft_delete' => 0)));
        $correctivePreventiveActions = $this->NonConformingProductsMaterial->CorrectivePreventiveAction->find('list', array('conditions' => array('CorrectivePreventiveAction.publish' => 1, 'CorrectivePreventiveAction.soft_delete' => 0)));

        $this->set(compact('materials', 'products', 'capaSources', 'correctivePreventiveActions'));
    }
}
