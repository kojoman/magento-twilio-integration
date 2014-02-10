<?php 

$mageFileName = '/var/www/vhosts/magento/app/Mage.php';

if(!file_exists($mageFileName)) {
	echo $mageFileName. " was not found. Exiting now";
	exit;
}

require_once $mageFileName;

// Error Reporting & Debuging 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
Mage::setIsDeveloperMode(true);
Varien_Profiler::enable();
umask(0);

// Initialize default store 
Mage::app('default');

/*
 1. Check if customer exists
 2. Create customer if does not exist
 3. Start session for customer
 4. Add products to customers cart
 5. Create order
 */

$customer = Mage::getModel('customer/customer');

// Customer Variables
$email = 'kojo+test@adepapa.com';
$password 		= 'password';

$customer->setWebsiteId(Mage::app()->getWebsite()->getId());
$customer->loadByEmail($email);

//Delete customer
// if($customer->getId()) {
// 	$customerId = $customer->getId();
// 	//$customer = Mage::getModel('customer/customer')->loadById($customerId);

// 	Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
// 	try {
// 		$customer->delete();
// 	} catch (Exception $e) {
// 		Zend_Debug::dump($e->getMessage());
// 	}
// }

Zend_Debug::dump($customer->debug()); 

//Check to see if customer exists 
if(!$customer->getId()) {
	echo "Customer does not exist.\n";
	$customer->setEmail($email);
	$customer->setFirstName('FirstName');
	$customer->setLastName('LastName');
	$customer->setPassword($password);

	// Save new customer
	try {
		$customer->save();
		$customer->setConfirmation(null);
		$customer->save();
	} catch (Exception $e) {
		Zend_Debug::dump($e->getMessage());
	}
}

// Login customer
$x = Mage::getSingleton('customer/session')->loginById($customer->getId());
Zend_Debug::dump($x);


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

echo "Customer Address object created.\n";
Zend_Debug::dump($customerAddress);

$customerAddress->setData($address)
				->setCustomerId($customer->getId())
				->setIsDefaultBilling('1')
				->setIsDefaultShipping('1')
				->setSaveInAddressBook('1');

try {
	$customerAddress->save();
} catch (Exception $e) {
	Zend_Debug::dump($e->getMessage());
}

echo "Customer Address object updated.\n";
Zend_Debug::dump($customerAddress);

Mage::getSingleton('checkout/session')->getQuote()->setBillingAddress(Mage::getSingleton('sales/quote_address')->importCustomerAddress($customerAddress));

// We now have a logged in customer
// Next step is to add products to his/her cart
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
// Clear cart before adding products
$cart->truncate();
$cart->save();
$cart->getItems()->clear()->save();

try {
	$cart->addProduct($product);
	$cart->save();
} catch (Exception $e) {
	Zend_Debug::dump($e->getMessage());
}
unset($product);

// Now let's make the purchase 
$storeId = Mage::app()->getStore()->getId();
$checkout = Mage::getSingleton('checkout/type_onepage');
echo "Checkout Object created.\n";
//Zend_Debug::dump($checkout);
$checkout->initCheckout();
$checkout->saveCheckoutMethod('register');
$checkout->saveShippingMethod('flatrate_flatrate');
$checkout->savePayment(array('method' => 'checkmo'));
try {
	$checkout->saveOrder();
} catch (Exception $e) {
	Zend_Debug::dump($e->getMessage());
}

//Zend_Debug::dump($checkout);

//Clear the cart
$cart->truncate();
$cart->save();
$cart->getItems()->clear()->save();


// Mage::getSingleton('core/session', array('name' => 'frontend')); 
// $_customer = Mage::getSingleton('customer/session')->getCustomer();


// $quote = Mage::getModel('sales/quote')->setStoreId(Mage::app()->getStore('default')->getId());

// if ('existing') {
// 	//For customer orders: 
// 	$customer = Mage::getModel('customer/customer')->setWebsiteId(1)->loadByEmail('customer@email.com');
// 	$quote->assignCustomer($customer);
// } else {
// 	// for guest orders only:
// 	$quote->setCustomerEmail('customer@email.com');
// }

// //Add products
// $product = Mage::getModel('catalog/product')->load(4);
// $buyInfo = array(
// 		'qty' => 1,
// 		//Custom option id => value id
// 		//or
// 		//configurable attribute id => value id
// 	);

// $quote->addProduct($product, new Varien_Object($buyInfo));
// $addressData = array(
// 		'firstname' => 'Test',
// 		'lastname'  => 	'Test',
// 		'street' 	=> 'Sample Street 10',
// 		'city'		=> 'New York',
// 		'postcode'	=> '10001', 
// 		'telephone' => '12345',
// 		'country_id' => 'US',
// 		'region_id'  => 12,
// 	);

// echo "hello world";

// ?>