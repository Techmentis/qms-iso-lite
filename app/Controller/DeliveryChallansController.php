<?php

App::uses('AppController', 'Controller');

/**
 * DeliveryChallans Controller
 *
 * @property DeliveryChallan $DeliveryChallan
 */
class DeliveryChallansController extends AppController {

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
        $this->paginate = array('order' => array('DeliveryChallan.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->DeliveryChallan->recursive = 0;
        $this->set('deliveryChallans', $this->paginate());

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
                        $searchArray[] = array('DeliveryChallan.' . $search => $searchKey);
                    else
                        $searchArray[] = array('DeliveryChallan.' . $search . ' like ' => '%' . $searchKey . '%');

                endforeach;
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => array('OR' => $searchArray));
            else
                $conditions[] = array('or' => $searchArray);
        }

        if ($this->request->query['branch_list']) {
            foreach ($this->request->query['branch_list'] as $branches):
                $branchConditions[] = array('DeliveryChallan.branch_id' => $branches);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $branchConditions);
            else
                $conditions[] = array('or' => $branchConditions);
        }
        if (isset($this->request->query['department_id'])) {
            foreach ($this->request->query['department_id'] as $department):
                $departmentConditions[] = array('DeliveryChallan.department_id' => $department);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $departmentConditions);
            else
                $conditions[] = array('or' => $departmentConditions);
        }
        if ($this->request->query['purchase_order_id']) {
            foreach ($this->request->query['purchase_order_id'] as $purchaseOrder):
                $purchaseOrderConditions[] = array('DeliveryChallan.purchase_order_id' => $purchaseOrder);
            endforeach;
            if ($this->request->query['strict_search'] == 0)
                $conditions[] = array('and' => $purchaseOrderConditions);
            else
                $conditions[] = array('or' => $purchaseOrderConditions);
        }

        if (!$this->request->query['to-date'])
            $this->request->query['to-date'] = date('Y-m-d');
        if ($this->request->query['from-date']) {
            $conditions[] = array('DeliveryChallan.created >' => date('Y-m-d h:i:s', strtotime($this->request->query['from-date'])), 'DeliveryChallan.created <' => date('Y-m-d h:i:s', strtotime($this->request->query['to-date'])));
        }
        $conditions =  $this->advance_search_common($conditions);
unset($this->request->query);


        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('DeliveryChallan.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('DeliveryChallan.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->DeliveryChallan->recursive = 0;
        $this->paginate = array('order' => array('DeliveryChallan.sr_no' => 'DESC'), 'conditions' => $conditions, 'DeliveryChallan.soft_delete' => 0);
        $this->set('deliveryChallans', $this->paginate());

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
        if (!$this->DeliveryChallan->exists($id)) {
            throw new NotFoundException(__('Invalid delivery challan'));
        }
        $options = array('conditions' => array('DeliveryChallan.' . $this->DeliveryChallan->primaryKey => $id));
        $deliveryChallan = $this->DeliveryChallan->find('first', $options);
        unset($deliveryChallan['CreatedBy']);
        $this->set('deliveryChallan', $deliveryChallan);

        $deliveryChallanDetails = $this->DeliveryChallan->DeliveryChallanDetail->find('all', array('conditions' => array('DeliveryChallanDetail.delivery_challan_id' => $id)));
        $this->set('deliveryChallanDetails', $deliveryChallanDetails);
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
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['DeliveryChallan']['system_table_id'] = $this->_get_system_table_id();
            $this->request->data['DeliveryChallan']['created_by'] = $this->Session->read('User.id');
            $this->request->data['DeliveryChallan']['modified_by'] = $this->Session->read('User.id');
            $purchaseOrder = $this->DeliveryChallan->PurchaseOrder->read(null, $this->request->data['DeliveryChallan']['purchase_order_id']);
            $this->request->data['DeliveryChallan']['supplier_registration_id'] = $purchaseOrder['PurchaseOrder']['supplier_registration_id'];
           
            $this->DeliveryChallan->create();
            if ($this->DeliveryChallan->save($this->request->data)) {
                $this->loadModel('SupplierEvaluationReevaluation');
                $this->loadModel('DeliveryChallanDetail');
                $this->loadModel('PurchaseOrder');
                $this->loadModel('Stock');
                foreach ($this->request->data['delivery_challan_details'] as $value) {
                    $this->DeliveryChallanDetail->create();
                    $value['delivery_challan_id'] = $this->DeliveryChallan->id;
                    if ($value['material_id'] != '') {
                        $this->loadModel('Material');
                        $qc = $this->Material->find('first', array('conditions' => array('Material.id' => $value['material_id']), 'fields' => 'Material.qc_required', 'recursive' => -1));
                        $value['material_qc_required'] = $qc['Material']['qc_required'];
                    }
                    $value['publish'] = 1;
                    $value['branchid'] = $this->Session->read('User.branch_id');
                    $value['departmentid'] = $this->Session->read('User.department_id');
                    $value['created_by'] = $this->Session->read('User.id');
                    $value['modified_by'] = $this->Session->read('User.id');
                    $value['system_table_id'] = $this->_get_system_table_id();
                    $this->DeliveryChallanDetail->save($value, false);
                    if ($value['material_id'] != '') {
                        $this->SupplierEvaluationReevaluation->create();
                        $newData['supplier_registration_id'] = $purchaseOrder['PurchaseOrder']['supplier_registration_id'];
                        $newData['delivery_challan_id'] = $this->DeliveryChallan->id;
                        $newData['challan_date'] = $this->request->data['DeliveryChallan']['challan_date'];
                        $newData['material_id'] = $value['material_id'];
                        $newData['quantity_supplied'] = $value['quantity_received'];
                        $newData['required_delivery_date'] = $purchaseOrder['PurchaseOrder']['expected_delivery_date'];
                        $newData['actual_delivery_date'] = $this->request->data['DeliveryChallan']['acknowledgement_date'];
                        $newData['publish'] = 0;
                        $newData['soft_delete'] = 0;
                        $this->SupplierEvaluationReevaluation->save($newData, false);
                    }
                    
                    if (($value['material_id'] != '') && ($purchaseOrder['PurchaseOrder']['type'] == 1) && ($value['material_qc_required'] != 1)) {
                        $this->Stock->create();
                        $stockData = array();
                        $stockData['material_id'] = $value['material_id'];
                        $stockData['type'] = 1;
                        $stockData['purchase_order_id'] = $value['purchase_order_id'];
                        $stockData['delivery_challan_id'] = $this->DeliveryChallan->id;
                        $stockData['supplier_registration_id'] = $purchaseOrder['PurchaseOrder']['supplier_registration_id'];
                        $stockData['received_date'] = $this->request->data['DeliveryChallan']['challan_date'];
                        $stockData['quantity'] = $value['quantity_received'];
                        $stockData['branch_id'] = $this->request->data['DeliveryChallan']['branch_id'];
                        $stockData['publish'] = 1;
                        $stockData['branchid'] = $this->Session->read('User.branch_id');
                        $stockData['departmentid'] = $this->Session->read('User.department_id');
                        $stockData['created_by'] = $this->Session->read('User.id');
                        $stockData['modified_by'] = $this->Session->read('User.id');
                        $this->Stock->save($stockData, false);
                    }
                }
                $this->Session->setFlash(__('The delivery challan has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $this->DeliveryChallan->id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The delivery challan could not be saved. Please, try again.'));
            }
        }
        $customers = $this->DeliveryChallan->Customer->find('list', array('conditions' => array('Customer.publish' => 1, 'Customer.soft_delete' => 0)));
        $supplierRegistrations = $this->DeliveryChallan->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
        $purchaseOrders = $this->DeliveryChallan->PurchaseOrder->find('list', array('conditions' => array('PurchaseOrder.publish' => 1, 'PurchaseOrder.soft_delete' => 0)));
        $branches = $this->DeliveryChallan->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $departments = $this->DeliveryChallan->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0)));
        $this->set(compact('customers', 'supplierRegistrations', 'purchaseOrders', 'branches', 'departments'));
    }

    public function get_purchase_order($id = null) {
        if ($id != -1) {

            $this->DeliveryChallan->PurchaseOrder->recursive = 0;
            $purchaseOrder = $this->DeliveryChallan->PurchaseOrder->find('first', array('conditions' => array('PurchaseOrder.id' => $id)));
            $this->set('purchaseOrder', $purchaseOrder);
            $purchaseOrderDetails = $this->DeliveryChallan->PurchaseOrder->PurchaseOrderDetail->find('all', array('conditions' => array('PurchaseOrderDetail.purchase_order_id' => $purchaseOrder['PurchaseOrder']['id'])));
            $this->set('purchaseOrderDetails', $purchaseOrderDetails);
        }
    }

    public function get_challan_details($id = null) {
        $challanDetails = $this->DeliveryChallan->read(null, $id);

        $i = 0;
        foreach ($challanDetails['DeliveryChallanDetail'] as $orderDetails):
            $this->DeliveryChallan->PurchaseOrder->PurchaseOrderDetail->recursive = 1;
            $purchaseOrder = $this->DeliveryChallan->PurchaseOrder->PurchaseOrderDetail->read(null, $orderDetails['purchase_order_details_id']);
            $challanDetails['DeliveryChallanDetail'][$i]['PurchaseOrderDetail'] = array($purchaseOrder['PurchaseOrderDetail'], $purchaseOrder['Product'], $purchaseOrder['Device'], $purchaseOrder['Material']);
            $i++;
        endforeach;
        $this->set('challanDetails', $challanDetails);
    }

    public function get_challan_number($challanNumber = null) {
        if ($challanNumber) {
            $this->DeliveryChallan->recursive = 1;
            $purchaseOrder = $this->DeliveryChallan->find('all', array('conditions' => array('challan_number' => $challanNumber)));
            $this->set('purchaseOrder', $purchaseOrder);
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
        if (!$this->DeliveryChallan->exists($id)) {
            throw new NotFoundException(__('Invalid delivery challan'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!isset($this->request->data[$this->modelClass]['publish']) && $this->request->data['Approval']['user_id'] != -1) {
                $this->request->data[$this->modelClass]['publish'] = 0;
            }
            $this->request->data['DeliveryChallan']['system_table_id'] = $this->_get_system_table_id();
            if ($this->DeliveryChallan->save($this->request->data)) {

                $this->loadModel('SupplierEvaluationReevaluation');
                $this->loadModel('DeliveryChallanDetail');
                $this->loadModel('SupplierEvaluationReevaluation');
                $this->loadModel('Stock');
                $purchaseOrder = $this->DeliveryChallan->PurchaseOrder->read(null, $this->request->data['DeliveryChallan']['purchase_order_id']);
                $challans = $this->DeliveryChallanDetail->find('all', array('conditions' => array('DeliveryChallanDetail.delivery_challan_id' => $id)));
                foreach ($challans as $challan):
                    $this->DeliveryChallanDetail->delete($challan['DeliveryChallanDetail']['id']);
                endforeach;
                $evaluations = $this->SupplierEvaluationReevaluation->find('all', array('conditions' => array('SupplierEvaluationReevaluation.delivery_challan_id' => $id)));
                foreach ($evaluations as $evaluation):
                    $this->SupplierEvaluationReevaluation->delete($evaluation['SupplierEvaluationReevaluation']['id']);
                endforeach;
                $stockvalues = $this->Stock->find('all', array('conditions' => array('Stock.delivery_challan_id' => $id)));

                foreach ($stockvalues as $stockvalue):
                    $this->Stock->delete($stockvalue['Stock']['id']);
                endforeach;
                
                
                foreach ($this->request->data['delivery_challan_details'] as $value) {
                    $this->DeliveryChallanDetail->create();
                    $value['delivery_challan_id'] = $id;
                    if ($value['material_id'] != '' || $value['material_id'] != '-1') {
                        $this->loadModel('Material');
                        $qc = $this->Material->find('first', array('conditions' => array('Material.id' => $value['material_id']), 'fields' => 'Material.qc_required', 'recursive' => -1));
                        $value['material_qc_required'] = $qc['Material']['qc_required'];
                    }
                    $value['publish'] = 1;
                    $value['branchid'] = $this->Session->read('User.branch_id');
                    $value['departmentid'] = $this->Session->read('User.department_id');
                    $value['created_by'] = $this->Session->read('User.id');
                    $value['modified_by'] = $this->Session->read('User.id');
                    $value['system_table_id'] = $this->_get_system_table_id();
                    $this->DeliveryChallanDetail->save($value, false);
                    
                    if ($value['material_id'] != '' || $value['material_id'] != '-1') {
                        $this->SupplierEvaluationReevaluation->create();
                        $newData['supplier_registration_id'] = $purchaseOrder['PurchaseOrder']['supplier_registration_id'];
                        $newData['delivery_challan_id'] = $id;
                        $newData['challan_date'] = $this->request->data['DeliveryChallan']['challan_date'];
                        $newData['product_id'] = $value['product_id'];
                        $newData['device_id'] = $value['device_id'];
                        $newData['material_id'] = $value['material_id'];
                        $newData['quantity_supplied'] = $value['quantity_received'];
                        $newData['required_delivery_date'] = $purchaseOrder['PurchaseOrder']['expected_delivery_date'];
                        $newData['actual_delivery_date'] = $this->request->data['DeliveryChallan']['acknowledgement_date'];
                        $newData['publish'] = 0;
                        $newData['soft_delete'] = 0;
                        $this->SupplierEvaluationReevaluation->save($newData, false);
                    }
                    
                    if (($value['material_id'] != '') && ($purchaseOrder['PurchaseOrder']['type'] == 1) && ($value['material_qc_required'] != 1)) {
                        $stockData = array();
                        $this->Stock->create();
                        $stockData['material_id'] = $value['material_id'];
                        $stockData['type'] = 1;
                        $stockData['purchase_order_id'] = $value['purchase_order_id'];
                        $stockData['delivery_challan_id'] = $this->DeliveryChallan->id;
                        $stockData['supplier_registration_id'] = $purchaseOrder['PurchaseOrder']['supplier_registration_id'];
                        $stockData['received_date'] = $this->request->data['DeliveryChallan']['challan_date'];
                        $stockData['quantity'] = $value['quantity_received'];
                        $stockData['branch_id'] = $this->request->data['DeliveryChallan']['branch_id'];
                        $stockData['publish'] = 1;
                        $stockData['branchid'] = $this->Session->read('User.branch_id');
                        $stockData['departmentid'] = $this->Session->read('User.department_id');
                        $stockData['created_by'] = $this->Session->read('User.id');
                        $stockData['modified_by'] = $this->Session->read('User.id');
                        $this->Stock->save($stockData, false);
                    }
                }
                $this->Session->setFlash(__('The delivery challan has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The delivery challan could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('DeliveryChallan.' . $this->DeliveryChallan->primaryKey => $id));
            $this->request->data = $this->DeliveryChallan->find('first', $options);
        }
        $branches = $this->DeliveryChallan->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $departments = $this->DeliveryChallan->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0)));
        $customers = $this->DeliveryChallan->Customer->find('list', array('conditions' => array('Customer.publish' => 1, 'Customer.soft_delete' => 0)));
        $supplierRegistrations = $this->DeliveryChallan->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
        $purchaseOrders = $this->DeliveryChallan->PurchaseOrder->find('list', array('conditions' => array('PurchaseOrder.publish' => 1, 'PurchaseOrder.soft_delete' => 0)));
        $this->set(compact('branches', 'departments', 'customers', 'supplierRegistrations', 'purchaseOrders'));
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approvalId = null) {
        if (!$this->DeliveryChallan->exists($id)) {
            throw new NotFoundException(__('Invalid delivery challan'));
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
            $this->request->data['DeliveryChallan']['system_table_id'] = $this->_get_system_table_id();
            if ($this->DeliveryChallan->save($this->request->data)) {
                $this->loadModel('SupplierEvaluationReevaluation');
                $this->loadModel('DeliveryChallanDetail');
                $this->loadModel('SupplierEvaluationReevaluation');
                $this->loadModel('Stock');
                $purchaseOrder = $this->DeliveryChallan->PurchaseOrder->read(null, $this->request->data['DeliveryChallan']['purchase_order_id']);
                $challans = $this->DeliveryChallanDetail->find('all', array('conditions' => array('DeliveryChallanDetail.delivery_challan_id' => $id)));
                foreach ($challans as $challan):
                    $this->DeliveryChallanDetail->delete($challan['DeliveryChallanDetail']['id']);
                endforeach;
                $evaluations = $this->SupplierEvaluationReevaluation->find('all', array('conditions' => array('SupplierEvaluationReevaluation.delivery_challan_id' => $id)));
                foreach ($evaluations as $evaluation):
                    $this->SupplierEvaluationReevaluation->delete($evaluation['SupplierEvaluationReevaluation']['id']);
                endforeach;
                $stockValues = $this->Stock->find('all', array('conditions' => array('Stock.delivery_challan_id' => $id)));

                foreach ($stockValues as $stockValue):
                    $this->Stock->delete($stockValue['Stock']['id']);
                endforeach;

                foreach ($this->request->data['delivery_challan_details'] as $value) {
                    $this->DeliveryChallanDetail->create();
                    $value['delivery_challan_id'] = $id;
                    if ($value['material_id'] != '') {
                        $this->loadModel('Material');
                        $qc = $this->Material->find('first', array('conditions' => array('Material.id' => $value['material_id']), 'fields' => 'Material.qc_required', 'recursive' => -1));
                        $value['material_qc_required'] = $qc['Material']['qc_required'];
                    }
                    $value['publish'] = 1;
                    $value['branchid'] = $this->Session->read('User.branch_id');
                    $value['departmentid'] = $this->Session->read('User.department_id');
                    $value['created_by'] = $this->Session->read('User.id');
                    $value['modified_by'] = $this->Session->read('User.id');
                    $value['system_table_id'] = $this->_get_system_table_id();
                    $this->DeliveryChallanDetail->save($value, false);

                    $this->SupplierEvaluationReevaluation->create();
                    $newData['supplier_registration_id'] = $purchaseOrder['PurchaseOrder']['supplier_registration_id'];
                    $newData['delivery_challan_id'] = $id;
                    $newData['challan_date'] = $this->request->data['DeliveryChallan']['challan_date'];
                    $newData['product_id'] = $value['product_id'];
                    $newData['device_id'] = $value['device_id'];
                    $newData['material_id'] = $value['material_id'];
                    $newData['quantity_supplied'] = $value['quantity_received'];
                    $newData['required_delivery_date'] = $purchaseOrder['PurchaseOrder']['expected_delivery_date'];
                    $newData['actual_delivery_date'] = $this->request->data['DeliveryChallan']['acknowledgement_date'];
                    $newDatah['publish'] = 0;
                    $newData['soft_delete'] = 0;
                    $this->SupplierEvaluationReevaluation->save($newData, false);

                    if (($value['material_id'] != '') && ($purchaseOrder['PurchaseOrder']['type'] == 1) && ($value['material_qc_required'] != 1)) {
                        $stockData = array();
                        $this->Stock->create();
                        $stockData['material_id'] = $value['material_id'];
                        $stockData['type'] = 1;
                        $stockData['purchase_order_id'] = $value['purchase_order_id'];
                        $stockData['delivery_challan_id'] = $this->DeliveryChallan->id;
                        $stockData['supplier_registration_id'] = $purchaseOrder['PurchaseOrder']['supplier_registration_id'];
                        $stockData['received_date'] = $this->request->data['DeliveryChallan']['challan_date'];
                        $stockData['quantity'] = $value['quantity_received'];
                        $stockData['branch_id'] = $this->request->data['DeliveryChallan']['branch_id'];
                        $stockData['publish'] = 1;
                        $stockData['branchid'] = $this->Session->read('User.branch_id');
                        $stockData['departmentid'] = $this->Session->read('User.department_id');
                        $stockData['created_by'] = $this->Session->read('User.id');
                        $stockData['modified_by'] = $this->Session->read('User.id');
                        $this->Stock->save($stockData, false);
                    }
                }
                $this->Session->setFlash(__('The delivery challan has been saved'));

                if ($this->_show_approvals()) $this->_save_approvals ();

            } else {
                $this->Session->setFlash(__('The delivery challan could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('DeliveryChallan.' . $this->DeliveryChallan->primaryKey => $id));
            $this->request->data = $this->DeliveryChallan->find('first', $options);
        }
        $branches = $this->DeliveryChallan->Branch->find('list', array('conditions' => array('Branch.publish' => 1, 'Branch.soft_delete' => 0)));
        $departments = $this->DeliveryChallan->Department->find('list', array('conditions' => array('Department.publish' => 1, 'Department.soft_delete' => 0)));
        $customers = $this->DeliveryChallan->Customer->find('list', array('conditions' => array('Customer.publish' => 1, 'Customer.soft_delete' => 0)));
        $supplierRegistrations = $this->DeliveryChallan->SupplierRegistration->find('list', array('conditions' => array('SupplierRegistration.publish' => 1, 'SupplierRegistration.soft_delete' => 0)));
        $purchaseOrders = $this->DeliveryChallan->PurchaseOrder->find('list', array('conditions' => array('PurchaseOrder.publish' => 1, 'PurchaseOrder.soft_delete' => 0)));
        $this->set(compact('branches', 'departments', 'customers', 'supplierRegistrations', 'purchaseOrders'));
    }

    public function get_delivered_material_qc() {
        App::uses('ConnectionManager', 'Model');
        $dataSource = ConnectionManager::getDataSource('default');
        $prefix = $dataSource->config['prefix'];

        $this->loadModel('DeliveryChallanDetail');
        $this->paginate = array('limit' => 2,
            'fields' => array(
                'DeliveryChallanDetail.delivery_challan_id', 'DeliveryChallanDetail.material_id', 'DeliveryChallanDetail.material_qc_required', 'DeliveryChallanDetail.quantity_received', 'Material.name', 'PurchaseOrder.title', 'DeliveryChallan.challan_date', 'DeliveryChallan.challan_number'
                , 'MaterialQualityCheck.id as redirect'),
            'joins' => array(
                array(
                    'table' => 'material_quality_checks',
                    'alias' => 'MaterialQualityCheck',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'MaterialQualityCheck.material_id = DeliveryChallanDetail.material_id'
                    )
                )
            ),
            'conditions' => array('DeliveryChallanDetail.publish' => 1, 'DeliveryChallanDetail.soft_delete' => 0, 'DeliveryChallanDetail.material_qc_required' => 1, '(select count('.$prefix.'stocks.id) as total from '.$prefix.'stocks where '.$prefix.'stocks.material_id = DeliveryChallanDetail.material_id AND '.$prefix.'stocks.delivery_challan_id  = DeliveryChallanDetail.delivery_challan_id )<=0 '),
            'order' => array('DeliveryChallanDetail.modified DESC'),
            'group' => array('DeliveryChallanDetail.material_id, DeliveryChallanDetail.delivery_challan_id'),
            'recursive' => 0
        );
        $finalData = $this->paginate('DeliveryChallanDetail');
        $this->set('materialQCrequired', $finalData);
        $this->set('materialQCrequiredCount', $this->request->params['paging']['DeliveryChallanDetail']['count']);
        $this->render('/Elements/delivered_material_qc');
    }

}
