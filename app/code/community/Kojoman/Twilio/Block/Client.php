<?php

class Kojoman_Twilio_Block_Client extends Mage_Core_Block_Template
{
    protected function _toHtml()
    {
        if (Mage::helper('twilio')->isEnabled()) {
            return parent::_toHtml();
        }
    }

} 