<?php

class Kojoman_Twilio_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ENABLED = 'magento_twilio/api/enabled';
    const XML_PATH_ACCOUNT_SID = 'magento_twilio/api/key';
    const XML_PATH_AUTH_TOKEN = 'magento_twilio/api/secret';
    const XML_PATH_TWILIO_NUMBER = 'magento_twilio/api/twilio_number';
    const XML_PATH_STATUS_CALLBACK_URL = 'magento_twilio/api/status_callback_url';
    const XML_PATH_SMS_NOTIFICATIONS_NUMBER = 'magento_twilio/api/sms_notifications_number';
    const XML_PATH_SMS_NEW_ORDER = 'magento_twilio/options/sms_new_order';
    const XML_PATH_SMS_NEW_CUSTOMER = 'magento_twilio/options/sms_new_customer';
    const XML_PATH_SMS_NEW_SHIPMENT = 'magento_twilio/options/sms_new_shipment';

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
     * Check to see if user wants SMS notifications for new customers
     *
     * @return bool
     */
    public function sendSmsForNewCustomers($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_SMS_NEW_CUSTOMER, $store);
    }

    /**
     * Get Twilio Account SID
     *
     * @return string
     */
    public function getAccountSID($store = null)
    {
        return (Mage::getStoreConfig(self::XML_PATH_ACCOUNT_SID, $store));
    }

    /**
     * Get Twilio Auth Token
     *
     * @return String
     */
    public function getAuthToken($store = null)
    {
        return (Mage::getStoreConfig(self::XML_PATH_AUTH_TOKEN, $store));
    }

    /**
     * Get Twilio Number
     *
     * @return String
     */
    public function getTwilioNumber($store = null)
    {
        return (Mage::getStoreConfig(self::XML_PATH_TWILIO_NUMBER, $store));
    }

    /**
     * Get Twilio status callback url
     *
     * @return String
     */
    public function getStatusCallbackUrl($store = null)
    {
        return (Mage::getStoreConfig(self::XML_PATH_STATUS_CALLBACK_URL, $store));
    }

    /*
     * Number to send notifications to.
     *
     *
    */
    public function getSMSNotificationNumber($store = null)
    {
        return (Mage::getStoreConfig(self::XML_PATH_SMS_NOTIFICATIONS_NUMBER, $store));
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