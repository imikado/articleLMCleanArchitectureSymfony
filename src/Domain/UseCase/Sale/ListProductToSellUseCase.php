<?php 

namespace Domain\UseCase\Sale;

use Domain\Gateway\CategoryGatewayInterface;
use Domain\Gateway\ProductGatewayInterface;
use Domain\Gateway\VATRateGatewayInterface;
use Domain\Presenter\Sale\ListProductToSellPresenterInterface;
use Domain\Request\Sale\ListProductToSellRequest;
use Domain\Response\Sale\ListProductToSellResponse;

class ListProductToSellUseCase{


    protected ProductGatewayInterface $productGateway;
    protected VATRateGatewayInterface $vatRateGateway;
    protected CategoryGatewayInterface $categoryGateway;


    public function __construct(
                ProductGatewayInterface $productGateway,
                VATRateGatewayInterface $vatRateGateway, 
                CategoryGatewayInterface $categoryGateway
    ){
        $this->productGateway=$productGateway;
        $this->vatRateGateway=$vatRateGateway;
        $this->categoryGateway=$categoryGateway;

    }

    public function execute(ListProductToSellRequest $request, ListProductToSellPresenterInterface $presenter) {

        $rawProductList=$this->productGateway->findAll();
        
        $productList=[];
        foreach($rawProductList as $productLoop){
            $productList[]=(object)[
                'id'=>$productLoop->id,
                'title'=>$productLoop->title,
                'excTaxBuyingPrice'=> $this->formatPrice($productLoop->excTaxBuyingPrice),
                'excTaxSellingPrice'=> $this->formatPrice($productLoop->excTaxSellingPrice),
                'incTaxSellingPrice'=> $this->formatPrice($productLoop->incTaxSellingPrice),
                'stock'=>  $productLoop->stock,

            ];

        }
        
        $response=new ListProductToSellResponse();
        $response->setStatusSuccess();
        $response->setProductList($productList);

        return $presenter->present($response);
    }

    public function formatPrice($price){
        return number_format($price,2);

    }

}