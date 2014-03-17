<?php

class Kojoman_Twilio_Block_Client extends Mage_Core_Block_Template
{
    protected function _toHtml()
    {
        if (Mage::helper('twilio')->isEnabled()) {
            return parent::_toHtml();
        }
    }

    // Two methods below completely need to be modified. 
    public function getCapability()
    {
    	return Mage::getSingleton('twilio/twilio')->getCapability; 
    }

    public function getInboundToken()
    {
    	$capability = $this->getCapability();

    	$capability->allowClientIncoming($this->clientId);
    	return $capability->generateToken();
    }

} 