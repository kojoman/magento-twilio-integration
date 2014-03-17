<?php

/*
 * This is a quick way to programmatically create orders in Magento. 
 * References have been taken from Magento source code and blog posts
 * on this specific topic.  
 * The main goal is to quickly create orders for test purposes. 
 */

// Include common configurations
include 'common.php';

// Programmatically create shipment 
$order_id = "1000000";

//load order by increment id
$order = Mage::getModel("sales/order")->loadByIncrementId($order_id);
try {
    if ($order->canShip()) {
        //Create Shipment
        $shipmentId = Mage::getModel('sales/order_shipment_api')
            ->create($order->getIncrementId(), array());
        //Add tracking information
    }
} catch (Exception $e) {
    Mage::logException($e);
}

//$shipment = Mage::getModel('sales/service_order', $order)->prepareShipment($this->_getItemQtys($order));

?>