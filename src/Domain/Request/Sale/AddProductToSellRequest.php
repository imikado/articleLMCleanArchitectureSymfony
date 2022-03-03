<?php 

namespace Domain\Request\Sale;

use Domain\Entity\Product;

class AddProductToSellRequest{

    protected ?Product $product=null;

    public function setProductToAdd(Product $product){
        $this->product=$product;
    }
    public function getProductToAdd():?Product{
        return $this->product;
    }

    
}

/*

    
    public ?string $title=null;
    public ?string $description=null;

    public ?float $excTaxBuyingPrice=null;
    public ?float $excTaxSellingPrice=null;

    public ?int $stock=null;
    
    public ?bool $active=null;

    public ?int $category_id=null;
    public ?int $vatRate_id=null;
    
    public function getProductRequestAsArray(): array{

        $fieldToSendList=[
            'title',
            'description',
            'excTaxBuyingPrice',
            'excTaxSellingPrice',
            'stock',
            'active',
            'category_id',
            'vatRate_id'
        ];

        $requestAsProductArray=[];
        foreach($fieldToSendList as $field){
            $requestAsProductArray[$field]=$this->$field;
        }

        return $requestAsProductArray;

    }
    */