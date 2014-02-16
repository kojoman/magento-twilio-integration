<?php 

/*
 * This is a quick way to programmatically create orders in Magento. 
 * References have been taken from Magento source code and blog posts
 * on this specific topic.  
 * The main goal is to quickly create orders for test purposes. 
 */ 

// Include common configurations
include 'common.php';

/*
 1. Check if customer exists
 2. Create customer if does not exist
 3. Start session for customer
 4. Add products to customers cart
 5. Create order
 6. Checkout 
 */

// Magento customer object 
$customer = Mage::getModel('customer/customer');

// Customer Variables
$email 			= 'kojo+test@adepapa.com';
$password 		= 'password';

$customer->setWebsiteId(Mage::app()->getWebsite()->getId());
$customer->setStoreId(Mage::app()->getStore()->getId());
$customer->loadByEmail($email);

//Delete customer
// if($customer->getId()) {
// 	$customerId = $customer->getId();
// 	//$customer = Mage::getModel('customer/customer')->loadById($customerId);

// 	Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
// 	try {
// 		$customer->delete();
// 		echo "Customer deleted.\n";
// 	} catch (Exception $e) {
// 		Zend_Debug::dump($e->getMessage());
// 	}
// }

//Create new customer if customer with specified email does not exist. 
if(!$customer->getId()) {
	echo "Customer does not exist.\n";
	$customer->setEmail($email);
	$customer->setFirstName('FirstName');  	//TODO: Customer First Name not appearing in admin
	$customer->setLastName('LastName'); 	//TODO: Customer Last Name not appearing in admin
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
}

// Login customer
Mage::getSingleton('customer/session')->loginById($customer->getId());


// Create shipping and billing address for customer. Needed for checkout 
$address = array(
	'firstname' => 'FirstName',
	'lastname'  => 'LastName', 
	'street'	=> array (
		'0' => 'Street Address part 1',
		'1' => 'Street Address part 2',
	),
	'city'		=> 'New York',
	'region_id' => '15',
	'region' 	=> 'NY',
	'postcode' 	=> '10000',
	'country_id' => 'US', 
	'telephone'	=> '1-234-567-8912', 
);

$customerAddress = Mage::getModel('customer/address');

$customerAddress->setData($address)
				->setCustomerId($customer->getId())
				->setIsDefaultBilling('1')
				->setIsDefaultShipping('1')
				->setSaveInAddressBook('1');

try {
	$customerAddress->save();
} catch (Exception $e) {
	Mage::logException($e->getMessage());
	Zend_Debug::dump($e->getMessage());
}

$x = Mage::getSingleton('checkout/session')->getQuote()->setBillingAddress(Mage::getSingleton('sales/quote_address')->importCustomerAddress($customerAddress));

//Zend_Debug::dump($x);

// We now have a logged in customer
// Next step is to add products to his/her cart
// 1112 is the sku for 'Chair' if you use Magento's default data set
$sku = '1112';

$product = Mage::getModel('catalog/product')->getCollection()
			->addAttributeToFilter('sku', $sku)
			->addAttributeToSelect('*')
			->getFirstItem();

echo "product object has been created.\n";
Zend_Debug::dump($product);

// Load full product
$product->load($product->getId());
$cart = Mage::getSingleton('checkout/cart');
//$cart = Mage::getModel('sales/quote')->loadByCustomer($customer->getId());
// Clear cart before adding products
$cart->truncate();
$cart->save();
$cart->getItems()->clear()->save();

try {
	$cart->init();
	$cart->addProduct($product);
	$cart->save();
	Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
	echo "Product added to cart\n";
} catch (Exception $e) {
	Mage::logException($e->getMessage());
	Zend_Debug::dump($e->getMessage());
}
//unset($product);

// Now let's make the purchase 
$storeId = Mage::app()->getStore()->getId();
$checkout = Mage::getSingleton('checkout/type_onepage');
echo "Checkout Object created.\n";
//Zend_Debug::dump($checkout);
$checkout->initCheckout();
$checkout->saveCheckoutMethod('register');
//$checkout->getQuote()->getShippingAddress()->setShippingMethod('flatrate_flatrate');
// $checkout->getQuote()->getShippingAddress()->unsGrandTotal(); // clear the values so they don't take part in calculation
// $checkout->getQuote()->getShippingAddress()->unsBaseGrandTotal();
// $checkout->getQuote()->getShippingAddress()->setCollectShippingRates(true)->save();

//             $checkout->getQuote()->getShippingAddress()->collectTotals();    //collect totals and ensure the initialization of the shipping methods

//             $checkout->getQuote()->collectTotals();
$shippingMethod = $checkout->saveShippingMethod('flatrate');
Zend_Debug::dump($shippingMethod);
$checkout->savePayment(array('method' => 'checkmo'));
try {
	$checkout->saveOrder();
} catch (Exception $e) {
	Zend_Debug::dump($e->getMessage());
}

// //Zend_Debug::dump($checkout);

// //Clear the cart
// $cart->truncate();
// $cart->save();
// $cart->getItems()->clear()->save();


// // Mage::getSingleton('core/session', array('name' => 'frontend')); 
// // $_customer = Mage::getSingleton('customer/session')->getCustomer();


// // $checkout->getQuote() = Mage::getModel('sales/quote')->setStoreId(Mage::app()->getStore('default')->getId());

// // if ('existing') {
// // 	//For customer orders: 
// // 	$customer = Mage::getModel('customer/customer')->setWebsiteId(1)->loadByEmail('customer@email.com');
// // 	$checkout->getQuote()->assignCustomer($customer);
// // } else {
// // 	// for guest orders only:
// // 	$checkout->getQuote()->setCustomerEmail('customer@email.com');
// // }

// // //Add products
// // $product = Mage::getModel('catalog/product')->load(4);
// // $buyInfo = array(
// // 		'qty' => 1,
// // 		//Custom option id => value id
// // 		//or
// // 		//configurable attribute id => value id
// // 	);

// // $checkout->getQuote()->addProduct($product, new Varien_Object($buyInfo));
// // $addressData = array(
// // 		'firstname' => 'Test',
// // 		'lastname'  => 	'Test',
// // 		'street' 	=> 'Sample Street 10',
// // 		'city'		=> 'New York',
// // 		'postcode'	=> '10001', 
// // 		'telephone' => '12345',
// // 		'country_id' => 'US',
// // 		'region_id'  => 12,
// // 	);

// // echo "hello world";

// // ?>