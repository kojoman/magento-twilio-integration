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
	protected $newOrderMessage = "Just got a new order...";

	//Mage::log($twilio_number);

	//protected $twilio = new Services_Twilio($this->AccountSid, $this->AuthToken);

	//protected $twilio = Services_Twilio("abc", "$this->AuthToken");

	/**
	 * Constructor
	 *
	 * Set up the twilio object and assign the numbers to use.
	 */
	public function __construct()
	{
		$decryptor = Mage::helper('core');

		$this->AccountSid 				= Mage::helper('twilio')->getAccountSID();
		$this->AuthToken  				= Mage::helper('twilio')->getAuthToken();
		$this->twilioNumber 			= Mage::helper('twilio')->getTwilioNumber();
		$this->smsNotificationNumber 	= Mage::helper('twilio')->getSMSNotificationNumber();

		parent::__construct($this->AccountSid, $this->AuthToken);
	}

	/**
	 * Send Notification when there's a new order.
	 *
	 */
	public function notifyNewOrder(Varien_Event_Observer $observer)
	{
		//Mage::log($observer->getEvent());

		//Check to see if module is enabled 
		if (!Mage::helper('twilio')->isEnabled()  || !Mage::helper('twilio')->sendSmsForNewOrders()) {
			Mage::log("Magento Twilio module is not enabled or should not send SMS for new orders.");
			return; 
		}

		//Send SMS via twilio 
		// try {
		// 	$sms = $this->account->messages->sendMessage(
		// 		$this->twilioNumber,
		// 		$this->smsNotificationNumber,
		// 		$this->message
		// 	); 
		// } catch (Exception $e) {
		// 	Mage::logException($e);
		// }

		//Send SMS via twilio 
		try {
			$sms = $this->account->messages->create(array(
				'To' 	=> $this->twilioNumber,
				'From' 	=> $this->smsNotificationNumber,
				'Body'	=> $this->message,
			));
		} catch (Exception $e) {
			
		}
		
		return $this; 
	}

	//Send notification when new customer signs up
	public function notifyNewCustomer(Varien_Event_Observer $observer)
	{
		/* @var $order Mage_Sales_Model_Order */
		if (!Mage::helper('twilio')->isEnabled() || !Mage::helper('twilio')->sendSmsForNewCustomers()) {
			Mage::log("Magento Twilio module is not enabled or should not send SMS for new customers");
			return; 
		}

		try {
			$sms = 	$this->account->messages->sendMessage(
					$this->twilioNumber,
					$this->smsNotificationNumber,
					'A new customer just signed up'
			); 
			Mage::log($sms);

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

		try {
			$sms = $this->account->messages->sendMessage(
				$this->twilio_number,
				$this->smsNotificationNumber,
				'Your order has been just been shipped.'
			); 
		} catch (Exception $e) {
			Mage::logException($e);
		}
		
		return $this; 
	}
}