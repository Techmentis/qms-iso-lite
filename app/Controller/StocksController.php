<?php

App::uses('AppController', 'Controller');

/**
 * Stocks Controller
 *
 * @property Stock $Stock
 */
class StocksController extends AppController {

    public function _get_system_table_id() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $this->request->params['controller'])));
        return $systemTableId['SystemTable']['id'];
    }


    public function _get_count($type = null){

        $onlyBranch = null;
	$onlyOwn = null;
	$conditions = null;
        $condition = null;
        $modelName = $this->modelClass;
        $branchIDYes = false;
	if($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)$onlyBranch = array($modelName.'.branch_id'=>$this->Session->read('User.branch_id'));
	if($this->Session->read('User.is_view_all') == 0)$onlyOwn = array($modelName.'.created_by'=>$this->Session->read('User.id'));
        if(isset($type))
            $condition = array($modelName.'.type'=>$type);
        $conditions = array($onlyBranch,$onlyOwn,$condition);
      	$count = $this->$modelName->find('count',array('conditions'=>$conditions));
	$published = $this->$modelName->find('count',array('conditions'=>array($conditions,$modelName.'.publish'=>1,$modelName.'.soft_delete'=>0)));
	$unpublished = $this->$modelName->find('count',array('conditions'=>array($conditions,$modelName.'.publish'=>0,$modelName.'.soft_delete'=>0)));
	$deleted = $this->$modelName->find('count',array('conditions'=>array($conditions,$modelName.'.soft_delete'=>1)));
	$this->set(compact('count','published','unpublished','deleted'));
}


    /**
     * index method
     *
     * @return void
     */
    public function index($type) {

        $conditions = $this->_check_request();
        $this->paginate = array('order' => array('Stock.sr_no' => 'DESC'), 'conditions' => array('Stock.type' => $type, $conditions));

        $this->Stock->recursive = 0;
        $this->set('stocks', $this->paginate());
        $this->_get_count($type);
        if ($type == 1) {
            $this->render('add_to_stock');
        } elseif ($type == 0) {
            $this->render('add_from_stock');
        }
    }

    /**
     * adcanced_search method
     * Advanced search by - TGS
     * @return void
     */
    public function advanced_search() {
        if ($this->request->is('post')) {
            $conditions = array();
            if ($this->request->data['Search']['keywords']) {
                $searchArray = array();
                $searchKeys = explode(" ", $this->request->data['Search']['keywords']);

                foreach ($searchKeys as $searchKey):
                    foreach ($this->request->data['Search']['search_fields'] as $search):
                        if ($this->request->data['Search']['strict_search'] == 0)
                            $searchArray[] = array('Stock.' . $search => $searchKey);
                        else
                            $searchArray[] = array('Stock.' . $search . ' like ' => '%' . $searchKey . '%');
                    endforeach;
                endforeach;
                if ($this->request->data['Search']['strict_search'] == 0)
                    $conditions[] = array('and' => $searchArray);
                else
                    $conditions[] = array('or' => $searchArray);
            }

            if ($this->request->data['Search']['branch_list']) {
                foreach ($this->request->data['Search']['branch_list'] as $branches):
                    $branchConditions[] = array('Stock.branch_id' => $branches);
                endforeach;
                $conditions[] = array('or' => $branchConditions);
            }

            if (!$this->request->data['Search']['to-date'])
                $this->request->data['Search']['to-date'] = date('Y-m-d');
            if ($this->request->data['Search']['from-date']) {
                $conditions[] = array('Stock.created >' => date('Y-m-d h:i:s', strtotime($this->request->data['Search']['from-date'])), 'Stock.created <' => date('Y-m-d h:i:s', strtotime($this->request->data['Search']['to-date'])));
            }
            unset($this->request->data['Search']);


            if ($this->Session->read('User.is_mr') == 0)
                $onlyBranch = array('Stock.branch_id' => $this->Session->read('User.branch_id'));
            if ($this->Session->read('User.is_view_all') == 0)
                $onlyOwn = array('Stock.created_by' => $this->Session->read('User.id'));
            $conditions[] = array($onlyBranch, $onlyOwn);

            $this->Stock->recursive = 0;
            $this->paginate = array('order' => array('Stock.sr_no' => 'DESC'), 'conditions' => $conditions, 'Stock.soft_delete' => 0);
            $this->set('stocks', $this->paginate());
        }
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Stock->exists($id)) {
            throw new NotFoundException(__('Invalid stock'));
        }
        $options = array('conditions' => array('Stock.' . $this->Stock->primaryKey => $id));
        $purchaseOrder = $this->get_model_list('PurchaseOrder');
        $this->set('stock', $this->Stock->find('first', $options));
        $this->set('purchaseOrder', $purchaseOrder);
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
            $this->request->data['Stock']['system_table_id'] = $this->_get_system_table_id();

            if($this->request->data['Stock']['type'] == 0){
                $this->Stock->create();
                $this->request->data['Stock']['soft_delete'] = 0;
                if($this->Stock->save($this->request->data['Stock']))
                    $this->Session->setFlash(__('The stock has been saved'));
            }

            //INCOMING STOCK CAN BE ADDED USING DELIVERY CHALLAN ADD_AJAX FUNCTION.
            /*
            elseif ($this->request->data['Stock']['type'] == 1) {
                foreach ($this->request->data['StockDetails'] as $stock):
                    $newStock = array();
                    $this->Stock->create();
                    $newStock['type'] = 1;
                    $newStock['supplier_registration_id'] = $stock['supplier_registration_id'];
                    $newStock['purchase_order_id'] = $stock['purchase_order_id'];
                    $newStock['delivery_challan_id'] = $this->request->data['Stock']['delivery_challan_id'];
                    $newStock['received_date'] = $stock['received_date'];
                    $newStock['material_id'] = $stock['materialid'];
                    $newStock['quantity'] = $stock['quantity'];
                    $newStock['remarks'] = $stock['remarks'];
                    $newStock['branchid'] = $this->request->data['Stock']['branchid'];
                    $newStock['departmentid'] = $this->request->data['Stock']['departmentid'];
                    $newStock['publish'] = $this->request->data['Stock']['publish'];
                    $newStock['soft_delete'] = 0;
                    $newStock['system_table_id'] = $this->request->data['Stock']['system_table_id'];
                    $this->Stock->save($newStock);
                endforeach;
            }
            */

            $this->Session->setFlash(__('The stock has been saved'));

            if ($this->_show_approvals()) $this->_save_approvals ();

            if ($this->_show_evidence() == true)
                $this->redirect(array('action' => 'view', $this->Stock->id));
            else
                $this->redirect(array('action' => 'index'));
        }
        $deliveryChallans = $this->Stock->DeliveryChallan->find('list', array('conditions' => array('DeliveryChallan.publish' => 1, 'DeliveryChallan.soft_delete' => 0)));
        $productions = $this->Stock->Production->find('list', array('conditions' => array('Production.publish' => 1, 'Production.soft_delete' => 0)));
        $this->set(compact('deliveryChallans', 'productions', 'materials'));
    }

    public function get_dc_details($id = null) {

        $challanDetails = $this->Stock->DeliveryChallan->DeliveryChallanDetail->find('all', array(
            'conditions' => array('DeliveryChallanDetail.delivery_challan_id' => $id, 'DeliveryChallanDetail.publish' => 1, 'DeliveryChallanDetail.soft_delete' => 0),
            'fields' => array(
                'DeliveryChallanDetail.material_id',
                'DeliveryChallanDetail.quantity_received',
                'DeliveryChallanDetail.description',
                'DeliveryChallan.acknowledgement_date',
                'DeliveryChallan.id',
                'DeliveryChallan.supplier_registration_id',
                'DeliveryChallan.purchase_order_id'),
        ));
        foreach ($challanDetails as $detail):
            $stocks = $this->Stock->find('all', array(
                'conditions' => array('Stock.delivery_challan_id' => $detail['DeliveryChallan']['id'], 'Stock.material_id' => $detail['DeliveryChallanDetail']['material_id']),
                'fields' => array('sum(Stock.quantity) as total_received'),
                'recursive' => -1
            ));
            $details[] = array_merge($detail, array('Stock' => $stocks[0][0]));

        endforeach;

        $materials = $this->Stock->Material->find('list', array('conditions' => array('Material.publish' => 1, 'Material.soft_delete' => 0)));
        $this->set(compact('details', 'materials'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Stock->exists($id)) {
            throw new NotFoundException(__('Invalid stock'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Stock']['system_table_id'] = $this->_get_system_table_id();
            if ($this->Stock->save($this->request->data)) {
                $this->Session->setFlash(__('The stock has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The stock could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Stock.' . $this->Stock->primaryKey => $id));
            $this->request->data = $this->Stock->find('first', $options);
        }
        $materials = $this->Stock->Material->find('list', array('conditions' => array('Material.publish' => 1, 'Material.soft_delete' => 0)));
        $deliveryChallans = $this->Stock->DeliveryChallan->find('list', array('conditions' => array('DeliveryChallan.publish' => 1, 'DeliveryChallan.soft_delete' => 0)));
        $productions = $this->Stock->Production->find('list', array('conditions' => array('Production.publish' => 1, 'Production.soft_delete' => 0)));
        $this->set(compact('materials', 'deliveryChallans', 'productions'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->Stock->exists($id)) {
            throw new NotFoundException(__('Invalid stock'));
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
            if ($this->Stock->save($this->request->data)) {

                $this->Session->setFlash(__('The stock has been saved.'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The stock could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Stock.' . $this->Stock->primaryKey => $id));
            $this->request->data = $this->Stock->find('first', $options);
        }
        $materials = $this->Stock->Material->find('list', array('conditions' => array('Material.publish' => 1, 'Material.soft_delete' => 0)));
        $deliveryChallans = $this->Stock->DeliveryChallan->find('list', array('conditions' => array('DeliveryChallan.publish' => 1, 'DeliveryChallan.soft_delete' => 0)));
        $productions = $this->Stock->Production->find('list', array('conditions' => array('Production.publish' => 1, 'Production.soft_delete' => 0)));
        $this->set(compact('materials','deliveryChallans', 'productions'));
    }

    public function stock_status() {
        $this->loadModel('Material');
        $materials = $this->Material->find('list', array('conditions' => array('Material.publish' => 1, 'Material.soft_delete' => 0)));
        $this->set(compact('materials'));
        
        if($this->request->is('post')){
            $materialCondition = null;
            if(isset($this->request->data['start_date']))
                $startDate = $this->request->data['start_date'];
            if(isset($this->request->data['end_date']))
                $endDate = $this->request->data['end_date'];
            $this->loadModel('Stock');
            if (isset($this->request->data['material_id'])) {
                $materialCondition = array('or' => array('Material.id' => $this->request->data['material_id']));
                $selectedMaterial = $this->Material->find('list', array('conditions' => array($materialCondition, 'Material.publish' => 1, 'Material.soft_delete' => 0)));
                foreach ($selectedMaterial as $key => $value):
                    $result['quantity'] = 0;
                    $result['quantity_consumed'] = 0;

                    $startDate = $this->request->data['start_date'];
                    $endDate = $this->request->data['end_date'];

                    if ($startDate == null)
                        $startDate = date('Y-m-d', strtotime('-7 days'));
                    if ($endDate == null)
                        $endDate = date('Y-m-d');

                    while (strtotime($startDate) <= strtotime($endDate)) {
                        $outStock = $this->Stock->find('first', array(
                            'conditions' => array('Stock.material_id' => $key, 'Stock.publish' => 1, 'Stock.soft_delete' => 0, 'Stock.type' => 0, 'Stock.production_date' => date('Y-m-d', strtotime($startDate))),
                            'fields' => array('Stock.quantity_consumed'),
                            'recursive' => 0
                        ));
                        $inStock = $this->Stock->find('first', array('conditions' => array('Stock.material_id' => $key, 'Stock.publish' => 1, 'Stock.soft_delete' => 0, 'Stock.type' => 1, 'Stock.received_date' => date('Y-m-d', strtotime($startDate))),
                            'fields' => array('Stock.quantity'),
                            'recursive' => 0
                        ));
                        $result['date'] = $startDate;
                        if (isset($inStock['Stock']) && $inStock['Stock']['quantity'] != null)
                            $result['quantity'] = $result['quantity'] + $inStock['Stock']['quantity'];
                        else
                            $result['quantity'] = $result['quantity'] + 0;

                        if (isset($outStock['Stock']) && $outStock['Stock']['quantity_consumed'] != null) {
                            $result['quantity_consumed'] = $outStock['Stock']['quantity_consumed'];
                            $result['quantity'] = $result['quantity'] + $inStock['Stock']['quantity'] - $result['quantity_consumed'];
                        } else {
                            $result['quantity_consumed'] = 0;
                            $result['quantity'] = $result['quantity'] + 0;
                        }

                        $results[$value][] = $result;
                        $startDate = date("Y-m-d", strtotime("+1 day", strtotime($startDate)));
                    }

                endforeach;
                $this->set(compact('selectedMaterial','materials'));
                $this->set(compact('results'));
                $this->render('/Elements/stock_status_update');
            }
        }
    }

    public function get_material($id = null) {
        $this->layout = "ajax";
        $productDetails = $this->Stock->Production->find('first', array('conditions' => array('Production.id' => $id),
            'recursive' => 0,
            'fields' => array('Product.id')
        ));

        foreach ($productDetails['Product'] as $productId):
            $productMaterials = $this->Stock->Production->Product->ProductMaterial->find('all', array(
                'conditions' => array('Product.id' => $productId),
                'fields' => array('Material.id', 'Material.name')
            ));
        endforeach;
        foreach ($productMaterials as $materialIds):
            $materials[$materialIds['Material']['id']] = $materialIds['Material']['name'];
        endforeach;
        $this->set(compact('materials'));
    }

    public function get_material_details($id = null, $curStockId = null) {

        $materialDetails = $this->Stock->Material->find('first', array(
            'conditions' => array('Material.id' => $id),
            'recursive' => -1
        ));


        $stocks = $this->Stock->find('all', array(
            'conditions' => array('Stock.material_id' => $id),
            'recursive' => -1
        ));
        $this->loadModel('ProductMaterial');
        $productDetails = $this->ProductMaterial->find('all', array(
            'conditions' => array('ProductMaterial.material_id' => $id),
            'recursive' => 0,
            'fields' => array('Product.name')
        ));


        $stockInHand = 0;
        $stockOut = 0;
        foreach ($stocks as $stock):
            $stockInHand += $stock['Stock']['quantity'];
            if($stock['Stock']['id'] != $curStockId)
                $stockOut += $stock['Stock']['quantity_consumed'];
        endforeach;

        $stock = $stockInHand - $stockOut;
        $this->set(compact('materialDetails', 'stock', 'productDetails'));
    }

    public function checkProdMatDate($prodID = null, $matID = null, $prodDate = null) {
        if (!empty($prodID) && !empty($matID) && !empty($prodDate)) {
            $checkStock = $this->Stock->find('first', array('conditions' => array('Stock.production_id' => $prodID, 'Stock.material_id' => $matID, 'Stock.production_date' => $prodDate), 'recursive' => -1, 'fields' => 'id'));
            if(count($checkStock) > 0)
                echo $checkStock['Stock']['id'];
        }
        exit;
    }

}
