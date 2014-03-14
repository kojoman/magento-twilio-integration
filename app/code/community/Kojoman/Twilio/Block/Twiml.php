<?php

class Kojoman_Twilio_Block_Twiml extends Mage_Core_Block_Template
{
    protected $phoneNumber;
    protected $callerId;
    protected $sid;
    protected $status;

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function setCallerId($callerId)
    {
        $this->callerId = $callerId;
    }

    public function getCallerIdString()
    {
        return ' callerId="' . $this->callerId . '"';
    }

    public function getRecepient()
    {
        return "<Number>" . $this->phoneNumber . "</Number>";
    }

    public function getSid($sid)
    {
        $this->sid = $sid;
    }

    public function getSmsStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}