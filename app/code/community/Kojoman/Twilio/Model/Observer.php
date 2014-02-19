<?php

require_once(Mage::getBaseDir('lib').'/twilio-php/Services/Twilio.php');

//require_once('twilio-php/Services/Twilio.php');


class Kojoman_Twilio_Model_Observer extends Services_Twilio
{

	protected $AccountSid;
	protected $AuthToken;
	protected $twilioNumber;
	protected $smsNotificationNumber; 

	// Dummy variables for testing. Change to something better
	// or use data passed from Observer. 
	protected $message = "Just got a new order...";

	//Mage::log($twilio_number);

	//protected $twilio = new Services_Twilio($this->AccountSid, $this->AuthToken);

	//protected $twilio = Services_Twilio("abc", "$this->AuthToken");

	public function __construct()
	{
		$decryptor = Mage::helper('core');

		$this->AccountSid = Mage::helper('twilio')->getAccountSID();
		$this->AuthToken  = Mage::helper('twilio')->getAuthToken();
		$this->twilioNumber = Mage::helper('twilio')->getTwilioNumber();
		$this->to 			= Mage::helper('twilio')->getSMSNotificationNumber();

		parent::__construct($this->AccountSid, $this->AuthToken);
	}

	protected function _debug($object) 
	{
		return Mage::helper('twilio')->debug($object); 
	}

	public function notifyNewOrder(Varien_Event_Observer $observer)
	{
		//Mage::log($observer->getEvent());

		/* @var $order Mage_Sales_Model_Order */
		if (!Mage::helper('twilio')->isEnabled()  || !Mage::helper('twilio')->sendSmsForNewOrders()) {
			Mage::log("Magento Twilio module is not enabled or should not send SMS for new orders.");
			return; 
		}

		//New order for {order_total} from {customer_name} 

		Mage::log(Mage::helper('twilio')->getTwilioNumber());

		//$cart = Mage::getSingleton('checkout/session')->getQuote()->getAllItems();

		//Mage::log($cart);

		try {
			$sms = $this->account->messages->sendMessage(
				$this->twilioNumber,
				$this->to,
				$this->message
			); 
		
			//Mage::log($sms);

			$product = $observer->getEvent()->getData();

			//Mage::log($product);

			//$this->_debug($sms);
		} catch (Exception $e) {
			Mage::logException($e);
		}
		
		return $this; 
	}

	//Send notification when new customer signs up
	public function notifyNewCustomer(Varien_Event_Observer $observer)
	{
		/* @var $order Mage_Sales_Model_Order */
		if (!Mage::helper('twilio')->isEnabled()) {
			Mage::log("Magento Twilio module is not enabled");
			return; 
		}

		Mage::log($observer);

		try {
			$sms = $this->account->messages->sendMessage(
				$this->twilio_number,
				$this->to,
				'A new customer just signed up'
			); 
		
			Mage::log($sms);

			//$this->_debug($sms);
		} catch (Exception $e) {
			Mage::logException($e);
		}
		
		return $this; 
	}

		//Send notification when new customer signs up
	public function notifyNewShipment(Varien_Event_Observer $observer)
	{
		/* @var $order Mage_Sales_Model_Order */
		if (!Mage::helper('twilio')->isEnabled() || !Mage::helper('twilio')->sendSmsForNewShipments()) {
			Mage::log("Magento Twilio module is not enabled or should not send SMS for new shipments.");
			return; 
		} else {
			Mage::log("Magento Twilio module is enabled");
		}

		Mage::log($observer);

		try {
			$sms = $this->account->messages->sendMessage(
				$this->twilio_number,
				$this->to,
				'Your order has been just been shipped.'
			); 
		
			Mage::log($sms);

			//$this->_debug($sms);
		} catch (Exception $e) {
			Mage::logException($e);
		}
		
		return $this; 
	}
}