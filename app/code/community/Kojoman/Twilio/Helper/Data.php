<?php

class Kojoman_Twilio_Helper_Data extends Mage_Core_Helper_Abstract
{
	const XML_PATH_ENABLED						= 'magento_twilio/api/enabled';
	const XML_PATH_SMS_NEW_ORDER				= 'magento_twilio/api/sms_new_order';
	const XML_PATH_SMS_NEW_SHIPMENT				= 'magento_twilio/api/sms_new_shipment';
	const XML_PATH_ACCOUNT_SID					= 'magento_twilio/api/key';
	const XML_PATH_AUTH_TOKEN					= 'magento_twilio/api/secret';

	/** 
	 * Check to see if extension is enabled
	 * 
	 * @return bool 
	 */
	public function isEnabled($store = null) 
	{
		return Mage::getStoreConfig(self::XML_PATH_ENABLED, $store); 
	}

	/** 
	 * Check to see if extension is enabled
	 * 
	 * @return bool 
	 */
	public function sendSmsForNewOrders($store = null) 
	{
		return Mage::getStoreConfig(self::XML_PATH_SMS_NEW_ORDER, $store); 
	}

	/** 
	 * Check to see if extension is enabled
	 * 
	 * @return bool 
	 */
	public function sendSmsForNewShipments($store = null) 
	{
		return Mage::getStoreConfig(self::XML_PATH_SMS_NEW_SHIPMENT, $store); 
	}

	/**
	 * Get Twilio Account SID
	 *
	 * @return string
	 */ 
	public function getAccountSID($store = null)
	{
		return(Mage::getStoreConfig(self::XML_PATH_ACCOUNT_SID, $store));
	}

	/**
	 * Get Twilio Auth Token
	 *
	 * @return String
	 */
	public function getAuthToken($store = null) 
	{
		return(Mage::getStoreConfig(self::XML_PATH_AUTH_TOKEN, $store)); 
	}

	/**
	 * Get Twilio Number
	 *
	 * @return String
	 */
	public function getTwilioNumber($store = null) 
	{
		return(Mage::getStoreConfig(self::XML_PATH_AUTH_TOKEN, $store)); 
	}

	/**
	 * Quick and dirty way to debug Magento objects
	 */
	public function debug($object)
	{
		echo '<pre>';
		print_r($object);
		echo '</pre>';
	}
}