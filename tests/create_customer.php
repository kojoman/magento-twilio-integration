<?php

/*
 * This is a quick way to programmatically create a new customer in Magento. 
 * References have been taken from Magento source code and blog posts
 * on this specific topic.  
 */

// Include common configurations
include 'common.php';

// Magento customer object 
$customer = Mage::getModel('customer/customer');

// Customer Variables
$email = 'kojo+test@adepapa.com';
$password = 'password';

$customer->setWebsiteId(Mage::app()->getWebsite()->getId());
$customer->setStoreId(Mage::app()->getStore()->getId());
$customer->loadByEmail($email);

//We need to test when new customer signs up so delete existing one 
if ($customer->getId()) {
    $customerId = $customer->getId();
    //$customer = Mage::getModel('customer/customer')->loadById($customerId);

    Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
    try {
        $customer->delete();
        echo "Customer deleted.\n";
    } catch (Exception $e) {
        Zend_Debug::dump($e->getMessage());
    }
}

//Create new customer if customer with specified email does not exist. 
// if(!$customer->getId()) {
echo "Creating customer...\n";
$customer->setEmail($email);
$customer->setFirstName('FirstName'); //TODO: Customer First Name not appearing in admin
$customer->setLastName('LastName'); //TODO: Customer Last Name not appearing in admin
$customer->setPassword($password);

// Save new customer
try {
    $customer->save();
    $customer->setConfirmation(null);
    $customer->save();
    //$customer->sendNewAccountEmail();
    //Mage::Log($customer->getName)
} catch (Exception $e) {
    Zend_Debug::dump($e->getMessage());
    Mage::logException($e->getMessage());
}
// } else {
// 	Mage::log('Could not create new customer. Customer already exists.');
// }

?>