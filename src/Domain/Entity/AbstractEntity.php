<?php 

namespace Domain\Entity;

abstract class AbstractEntity{

    public function __get($field){
        throw new \Exception('Field '.$field.' unknown');
    
    }
    public function __set($field,$value){
        throw new \Exception('You try to add value '.$value.' on unknown Field '.$field);
    }

    public function __construct($valueList=null)
    {
        if(is_array($valueList)){
            foreach($valueList as $field => $value){
                if(property_exists($this,$field)){
                    $this->$field=$value;
                }
            }
        }
    }
}