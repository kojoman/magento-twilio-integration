<?php

require_once(Mage::getBaseDir('lib').'/twilio-php/Services/Twilio.php');

//require_once('twilio-php/Services/Twilio.php');


class Kojoman_Twilio_Model_Observer extends Services_Twilio
{

	protected $AccountSid;
	protected $AuthToken;

	// Dummy variables for testing. Change to something better
	// or use data passed from Observer. 
	protected $name = "Kojoman";
	protected $twilio_number = "1-646-XXX-XXXX"; 	//Remember to change this
	protected $to = "XXX-XXX-XXXX"; 
	protected $message = "Kojoman just added an item to his cart";


	//protected $twilio = new Services_Twilio($this->AccountSid, $this->AuthToken);

	//protected $twilio = Services_Twilio("abc", "$this->AuthToken");

	public function __construct()
	{
		$decryptor = Mage::helper('core');

		$this->AccountSid = Mage::helper('twilio')->getAccountSID();
		$this->AuthToken  = Mage::helper('twilio')->getAuthToken();

		parent::__construct($this->AccountSid, $this->AuthToken);
	}

	protected function _debug($object) 
	{
		return Mage::helper('twilio')->debug($object); 
	}

	public function notifyNewOrder(Varien_Event_Observer $observer)
	{
		/* @var $order Mage_Sales_Model_Order */
		if (!Mage::helper('twilio')->isEnabled()) {
			Mage::log("Magento Twilio module is not enabled");
			return; 
		}

		try {
			$sms = $this->account->messages->sendMessage(
				$this->twilio_number,
				$this->to,
				$this->message
			); 
		
			Mage::log($sms);

			$product = $observer->getEvent()->getData();

			Mage::log($product);

			//$this->_debug($sms);
		} catch (Exception $e) {
			Mage::logException($e);
		}
		
		return $this; 
	}
}