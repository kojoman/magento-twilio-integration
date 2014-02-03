<?php

include(Mage::getBaseDir('lib').'/twilio-php/Services/Twilio.php');

class Kojoman_Twilio_Model_Observer extends Services_Twilio
{

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

		//Mage::log('hello');

		$order = $observer->getEvent()->getData('order');

		$this->_debug($order);

		//return $this; 
	}
}