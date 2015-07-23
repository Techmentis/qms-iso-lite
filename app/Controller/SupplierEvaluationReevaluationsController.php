<?php

App::uses('AppController', 'Controller');

/**
 * SupplierEvaluationReevaluations Controller
 *
 * @property SupplierEvaluationReevaluation $SupplierEvaluationReevaluation
 */
class SupplierEvaluationReevaluationsController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {

        $conditions = $this->_check_request();
        $this->paginate = array('order' => array('SupplierEvaluationReevaluation.sr_no' => 'DESC'), 'conditions' => array($conditions));
        $this->SupplierEvaluationReevaluation->recursive = 0;
        $this->set('supplierEvaluationReevaluations', $this->paginate());
        $this->_get_count();
        $supplierRegistrations = $this->SupplierEvaluationReevaluation->SupplierRegistration->find('list');
        $this->set(compact('supplierRegistrations'));
    }

    public function evaluate($supplierRegistrationId = null) {

        if ($supplierRegistrationId && $supplierRegistrationId != -1) {
            $conditions = $this->_check_request();
            $this->SupplierEvaluationReevaluation->SupplierRegistration->recursive = -1;

            $supplier = $this->SupplierEvaluationReevaluation->SupplierRegistration->find('first', array('conditions' =>
                array('SupplierRegistration.id' => $supplierRegistrationId)));

            //Get number of POs raised
            $this->loadModel('PurchaseOrder');
            $purchaseOrders = $this->PurchaseOrder->find('list', array(
                'conditions' => array('PurchaseOrder.supplier_registration_id' => $supplierRegistrationId)));


            $hasData = false;
            $numberOfOrders = 0;
            $numberOfProdycts = 0;

            $this->loadModel('PurchaseOrderDetail');
            $this->loadModel('DeliveryChallan');
            $this->loadModel('DeliveryChallanDetail');

            foreach ($purchaseOrders as $pkey => $pvalue):
                $challans = $this->DeliveryChallan->find('all', array(
                    'conditions' => array('DeliveryChallan.purchase_order_id' => $pkey)));

                foreach ($challans as $challan):

                    $details = $this->DeliveryChallanDetail->find('all', array(
                        'conditions' => array('DeliveryChallanDetail.delivery_challan_id' => $challan['DeliveryChallan']['id']),
                        'fields' => array('DeliveryChallanDetail.quantity', 'DeliveryChallanDetail.quantity_received',
                            'DeliveryChallan.challan_date', 'PurchaseOrder.expected_delivery_date'
                    )));

                    $sups[] = $this->SupplierEvaluationReevaluation->find('all', array(
                        'conditions' => array('SupplierEvaluationReevaluation.delivery_challan_id' => $challan['DeliveryChallan']['id']),
                        'fields' => array('SupplierEvaluationReevaluation.quantity_supplied',
                            'SupplierEvaluationReevaluation.quantity_accepted',
                            'SupplierEvaluationReevaluation.required_delivery_date',
                            'SupplierEvaluationReevaluation.actual_delivery_date')
                    ));

                endforeach;

                $orderDetails = $this->PurchaseOrderDetail->find('all', array(
                    'conditions' => array('PurchaseOrderDetail.purchase_order_id' => $pkey),
                    'fields' => array('PurchaseOrderDetail.quantity')
                ));

                foreach ($orderDetails as $orderDetail):
                    $numberOfProducts = $orderDetail['PurchaseOrderDetail']['quantity'] + $numberOfProducts;
                endforeach;
                $numberOfOrders++;

            endforeach;

            $data = null;

            $supplied = 0;
            $accepted = 0;
            $data = "[['Delivery Date','Quantity Supplied','Quantity Accepted'],";
            foreach ($sups as $sup):
                foreach ($sup as $graphData):

                    $supplied = $supplied + $graphData['SupplierEvaluationReevaluation']['quantity_supplied'];
                    $accepted = $accepted + $graphData['SupplierEvaluationReevaluation']['quantity_accepted'];

                    $data .= "[" .
                            "'" . date('d-m-Y', strtotime($graphData['SupplierEvaluationReevaluation']['required_delivery_date'])) . "'," .
                            $graphData['SupplierEvaluationReevaluation']['quantity_supplied'] . "," .
                            $graphData['SupplierEvaluationReevaluation']['quantity_accepted'] .
                            "],";
                endforeach;
            endforeach;
            $data .= "]]";
            $data = str_replace("],]]", "]]", $data);

            $this->set('data', $data);

            $dc = 0;
            $dc = $this->SupplierEvaluationReevaluation->find('count', array(
                'conditions' => array('SupplierEvaluationReevaluation.supplier_registration_id' => $supplierRegistrationId,
                    'SupplierEvaluationReevaluation.required_delivery_date > SupplierEvaluationReevaluation.actual_delivery_date'
                ),
                'group' => array('SupplierEvaluationReevaluation.delivery_challan_id'),
                'fields' => array('SupplierEvaluationReevaluation.delivery_challan_id')
            ));
            if (!$dc)
                $dc = 0;

            $challanCount = $this->DeliveryChallan->find('count', array(
                'conditions' => array('DeliveryChallan.supplier_registration_id' => $supplierRegistrationId)));

            if ($sups)
                $hasData = true;

            $this->set(array('hasData' => $hasData, 'challanCount' => $challanCount, 'supplierRegistration' => $supplier, 'supplied' => $supplied, 'accepted' => $accepted, 'dateCount' => $dc));

            $this->_get_count();
        }
        $supplierRegistrations = $this->SupplierEvaluationReevaluation->SupplierRegistration->find('list');
        $this->set(compact('supplierRegistrations', 'supplier_registration_id'));

        $this->loadModel('SupplierCategory');
        $supplierCategories = $this->SupplierCategory->find('list', array('conditions' => array('SupplierCategory.publish' => 1, 'SupplierCategory.soft_delete' => 0)));
        $this->set(compact('supplierCategories'));
    }

    public function get_supplier_list($id = null) {

        $deliveryChallans = $this->SupplierEvaluationReevaluation->DeliveryChallan->find('list', array(
            'conditions' => array('DeliveryChallan.publish' => 1,
                'DeliveryChallan.soft_delete' => 0,
                'DeliveryChallan.supplier_registration_id' => $id
        )));
        return $deliveryChallans;
        exit;
    }

}
