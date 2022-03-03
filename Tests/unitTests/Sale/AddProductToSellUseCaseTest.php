<?php 

declare(strict_types=1);

use Domain\Entity\Category;
use Domain\Entity\Product;
use Domain\Entity\VATRate;
use Domain\Gateway\ProductGatewayInterface;
use Domain\Gateway\VATRateGatewayInterface;
use Domain\Gateway\CategoryGatewayInterface;
use Domain\Gateway\GatewayResponse;
use Domain\Request\Sale\AddProductToSellRequest;
use Domain\Response\Sale\AddProductToSellResponse;
use Domain\Tool\Validator;
use Domain\UseCase\Sale\AddProductToSellUseCase;
use PHPUnit\Framework\TestCase;

final class AddProductToSellUseCaseTest extends TestCase{

    public function test_executeShouldFinishSuccess(){

        $productGateway=$this->createMock(ProductGatewayInterface::class); 
        $vatRateGateway=$this->createMock(VATRateGatewayInterface::class);
        $categoryGateway=$this->createMock(CategoryGatewayInterface::class); 
        
        $categoryFound=new Category(['id'=>101,'name'=>'Category 1']);
        $categoryGateway->method('findById')->willReturn($categoryFound);

        $vatRateFound = new VATRate(['id'=>1001,'rate'=>0.196]);
        $vatRateGateway->method('findById')->willReturn($vatRateFound);

        $validator=new Validator();
        
        $createNewProductUseCase=new AddProductToSellUseCase($productGateway,$vatRateGateway,$categoryGateway,$validator);

        $request=new AddProductToSellRequest();
        $request->setProductToAdd(new Product([
            'title'=>'Clef usb',
            'excTaxBuyingPrice'=>4.5,
            'excTaxSellingPrice'=>8.0,
            'stock'=>20,
            'description'=>'Clef usb 8GO',
            'category_id'=>1,
            'vatRate_id'=>1
        ]));

        $productAddResponse=new GatewayResponse();
        $productAddResponse->setStatusSuccess();
        $productGateway->method('add')->willReturn($productAddResponse);

        $response=$createNewProductUseCase->execute($request);

        $expectedResponse=new AddProductToSellResponse();
        $expectedResponse->setStatusSuccess();
        $expectedResponse->setSuccessMessage('Product added with success');

        $this->assertEquals($expectedResponse,$response );
    }

    public function test_generateProductToAddShouldFinishSuccess(){

        $productGateway=$this->createMock(ProductGatewayInterface::class); 
        $vatRateGateway=$this->createMock(VATRateGatewayInterface::class);
        $categoryGateway=$this->createMock(CategoryGatewayInterface::class); 

        $validator=new Validator();
        
        $createNewProductUseCase=new AddProductToSellUseCase($productGateway,$vatRateGateway,$categoryGateway,$validator);

        $requestProduct=new Product([
            'title'=>'Clef usb',
            'excTaxBuyingPrice'=>4.5,
            'excTaxSellingPrice'=>8.0,
            'stock'=>20,
            'description'=>'Clef usb 8GO',
            'category_id'=>1,
            'vatRate_id'=>50
        ]);

        $vatRate = new VATRate(['id'=>1001,'rate'=>0.196]);

        $productToAdd=$createNewProductUseCase->generateProductToAdd($requestProduct,$vatRate);

        $incTaxSellingPriceCalculated=9.568;//0.8 x (1+0.196)

        $expectedProductToAdd=new Product([
            'title'=>'Clef usb',
            'excTaxBuyingPrice'=>4.5,
            'excTaxSellingPrice'=>8.0,
            'stock'=>20,
            'description'=>'Clef usb 8GO',
            'category_id'=>1,
            'vatRate_id'=>50,

            'incTaxSellingPrice'=>$incTaxSellingPriceCalculated,
            'visible'=>false
        ]);
         
        $this->assertEquals($expectedProductToAdd,$productToAdd );
    }

}