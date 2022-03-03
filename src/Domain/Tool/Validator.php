<?php 

namespace Domain\Tool;

class Validator{

    protected $assert;

    protected $object;

    protected $errorList=[];

    public function load(object $object){
        $this->object=$object;
    }

    public function getValue($field){
        if(property_exists($this->object,$field)){
            return $this->object->$field;
        }
        return null;
    }

    public function addErrorOnField($field,$error){
        if(!isset($this->errorList[$field])){
            $this->errorList[$field]=[];
        }
        $this->errorList[$field][]=$error;
    }



    public function assertIsNotEqual($field,$value,$message){
        $currentValue=$this->getValue($field);
        if($currentValue==$value){
            $this->addErrorOnField($field,$message);
        }
    }

    public function assertIsNotEmpty($field,$message){
        $currentValue=$this->getValue($field);
        if(empty($currentValue) or $currentValue===null){
            $this->addErrorOnField($field,$message);
        }
    }

    public function assertMatchExpression($field,$pattern,$message){
        $currentValue=$this->getValue($field);
        if(!preg_match($pattern,$currentValue)){
            $this->addErrorOnField($field,$message);
        }
    }

    public function assertIsInteger($field,$message){
        $currentValue=$this->getValue($field);
        if(!preg_match('/^([0-9]+)$/',$currentValue)){
            $this->addErrorOnField($field,$message);
        }
    }

    public function assertIsFloat($field,$message){
        $currentValue=$this->getValue($field);
        if(!preg_match('/^([0-9]+)(\.[0-9])?$/',$currentValue)){
            $this->addErrorOnField($field,$message);
        }
    }

    

    public function validate(){

        return new ValidatorResponse($this->errorList);

    }
 

}