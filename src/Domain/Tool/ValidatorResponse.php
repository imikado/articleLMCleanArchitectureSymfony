<?php 

namespace Domain\Tool;

class ValidatorResponse{

    protected $errorList=[];

    public function __construct($errorList=[])
    {
        $this->setErrorList($errorList);
    }

    public function setErrorList($errorList){
        $this->errorList=$errorList;
    }

    public function addError($error){
        return $this->errorList[]=$error;
    }

    public function getErrorList(){
        return $this->errorList;
    }

    public function isValid(){
        if(count($this->errorList)>0){
            return false;
        }
        return true;

    }



}