<?php

class Kojoman_Twilio_Model_Observer
{
	protected function _debug($object) 
	{
		return Mage::helper('twilio')->debug($object); 
	}

	public function notifyNewOrder(Varien_Event_Observer $observer)
	{
		/* @var $order Mage_Sales_Model_Order */
		if (!Mage::helper('twilio')->isEnabled()) {
			return; 
		}

		$order = $observer->getEvent()->getData('order');

		$this->_debug($order);

		return $this; 
	}
}