<?php

class Kojoman_Twilio_Helper_Data extends Mage_Core_Helper_Abstract
{
	const XML_PATH_ENABLED						= 'magento_twilio/api/enabled';
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
	 * Quick and dirty way to debug Magento objects
	 */
	public function debug($object)
	{
		echo '<pre>';
		print_r($object);
		echo '</pre>';
	}
}