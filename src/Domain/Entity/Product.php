<?php 

namespace Domain\Entity;

class Product extends AbstractEntity{

    public $id=null;
    public $title=null;
    public $description=null;

    public $excTaxBuyingPrice=null;
    public $excTaxSellingPrice=null;

    public $incTaxSellingPrice=null;

    public $stock=null;
    
    public $visible=null;

    public $category_id=null;
    public $vatRate_id=null;

    public function calculateIncTaxSellingPrice($vatRate){
        $this->incTaxSellingPrice=($this->excTaxSellingPrice*(1+$vatRate));
    }
    public function hide(){
        $this->visible=false;
    }
    public function display(){
        $this->visible=true;
    }
    
}