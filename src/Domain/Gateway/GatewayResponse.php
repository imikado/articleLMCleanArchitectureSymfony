<?php

namespace Domain\Gateway;

class GatewayResponse{

    const STATUS_SUCCESS='success';
    const STATUS_FAILED='failed';

    protected $status;
    protected $errorList=[];

    public function setStatusSuccess(){
        $this->status=self::STATUS_SUCCESS;
    }
    public function setStatusFailed(){
        $this->status=self::STATUS_FAILED;
    }

    public function isStatusSuccess(){
        return ($this->status==self::STATUS_SUCCESS);
    }
    public function isStatusFailed(){
        return ($this->status==self::STATUS_FAILED);
    }

    public function setFailedMessage($failedMessage){
        $this->failedMessage=$failedMessage;
    }
    public function getFailedMessage(){
        return $this->failedMessage;
    }
}