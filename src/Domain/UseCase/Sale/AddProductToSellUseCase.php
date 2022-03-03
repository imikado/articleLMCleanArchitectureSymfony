<?php 

namespace Domain\UseCase\Sale;

use Domain\Entity\Product;
use Domain\Entity\VATRate;
use Domain\Gateway\CategoryGatewayInterface;
use Domain\Gateway\ProductGatewayInterface;
use Domain\Gateway\VATRateGatewayInterface;
use Domain\Request\Sale\AddProductToSellRequest;
use Domain\Response\Sale\AddProductToSellResponse;
use Domain\Tool\Validator;
use Domain\Tool\ValidatorResponse;

use Symfony\Component\HttpFoundation\Request;

class AddProductToSellUseCase{

    protected ProductGatewayInterface $productGateway;
    protected VATRateGatewayInterface $vatRateGateway;
    protected CategoryGatewayInterface $categoryGateway;

    protected Validator $validator;

    public function __construct(
                ProductGatewayInterface $productGateway,
                VATRateGatewayInterface $vatRateGateway, 
                CategoryGatewayInterface $categoryGateway,
                Validator $validator
    ){
        $this->productGateway=$productGateway;
        $this->vatRateGateway=$vatRateGateway;
        $this->categoryGateway=$categoryGateway;

        $this->validator=$validator;

    }

    public function execute(AddProductToSellRequest $request) : AddProductToSellResponse{

        try{
            $response=new AddProductToSellResponse();

            $productRequestValidation=$this->getProductRequestValidation($this->validator,$request);
            if(!$productRequestValidation->isValid()){
                
                $response->setStatusNotValid();
        
                foreach($productRequestValidation->getErrorList() as $field => $fieldErrorList){
                    $response->addFieldErrorMessage($field,join(',',$fieldErrorList));
                }
                return $response;

            }

            if($this->dontFindCategoryWithThisId($request->getProductToAdd()->category_id) ){
                $response->addFieldErrorMessage('category_id','Unable to find Category with id '.$request->getProductToAdd()->category_id);

                $response->setStatusNotValid();

                return $response;
            }

            $vatRate=$this->findVatRateById($request->getProductToAdd()->vatRate_id);
            if($vatRate===null){
                $response->addFieldErrorMessage('vatRate_id','Unable to find VAT Rate with id '.$request->getProductToAdd()->vatRate_id);

                $response->setStatusNotValid();

                return $response;
            }

            $productToAdd=$this->generateProductToAdd($request->getProductToAdd(),$vatRate);

            $productAddResponse=$this->productGateway->add($productToAdd);
            if(!$productAddResponse->isStatusSuccess()){

                $response->setStatusFailed();
                $response->setFailedMessage('Error when ask to add product with Gateway');
                
                return $response;
            }

            $response->setStatusSuccess();
            $response->setSuccessMessage('Product added with success');

            return $response;
            

        }catch(\Exception $e){

            $response=new AddProductToSellResponse();
            $response->setStatusException();
            $response->setException($e);

            return $response;
        }
    }

    public function generateProductToAdd(Product $productToAdd,$vatRate){

        $productToAdd->calculateIncTaxSellingPrice($vatRate->rate);
        $productToAdd->hide();

        return $productToAdd;
    }

    public function dontFindCategoryWithThisId($categoryId){

        $rawCategory=$this->categoryGateway->findById($categoryId);
        if($rawCategory===null){
            return true;
        }
        return false;
    }

    public function findVatRateById($vatRageId){
        $rawVatRate=$this->vatRateGateway->findById($vatRageId);
        if($rawVatRate===null){
            return null;
        }
        return new VatRate((array)$rawVatRate);
    }


    public function getProductRequestValidation(Validator $validator,AddProductToSellRequest $request): ValidatorResponse{
      
        $productToAdd=$request->getProductToAdd();

        if($productToAdd==null){
            $validator->addErrorOnField('global','You must provide a product');
            return $validator->validate();
        }
        
        $validator->load($productToAdd);

        $validator->assertIsNotEqual('category_id',0,'should_select_one');
        $validator->assertIsNotEqual('vatRate_id',0,'should_select_one');

        $validator->assertIsNotEmpty('title','should_fill_it');

        $validator->assertIsNotEmpty('excTaxBuyingPrice','should_fill_it');
        $validator->assertIsFloat('excTaxBuyingPrice','foat needed');

        $validator->assertIsNotEmpty('excTaxSellingPrice','should_fill_it');
        $validator->assertIsFloat('excTaxSellingPrice','foat needed');

        $validator->assertIsNotEmpty('description','should_fill_it');
        $validator->assertIsNotEmpty('stock','should_fill_it');
        $validator->assertIsInteger('stock','should_be_integer');


        return $validator->validate();
    }

}