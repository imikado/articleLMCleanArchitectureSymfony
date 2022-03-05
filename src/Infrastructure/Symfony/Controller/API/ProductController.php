<?php 

namespace Infrastructure\Symfony\Controller\API;

use Domain\Entity\Product;
use Domain\Gateway\CategoryGatewayInterface;
use Domain\Gateway\ProductGatewayInterface;
use Domain\Gateway\VATRateGatewayInterface;
use Domain\Request\Sale\AddProductToSellRequest;
use Domain\Request\Sale\ListProductToSellRequest;
use Domain\Tool\Validator;
use Domain\UseCase\Sale\AddProductToSellUseCase;
use Domain\UseCase\Sale\ListProductToSellUseCase;
use Infrastructure\Symfony\Presenter\Sale\AddProductToSellPresenterToJson;
use Infrastructure\Symfony\Presenter\Sale\ListProductToSellPresenterToJson;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController{


    /**
     * @Route("/API/product/add",methods={"POST"})
     */
    public function addAction(
        Request $request,
        ProductGatewayInterface $productGateway,
        VATRateGatewayInterface $vatGateway,
        CategoryGatewayInterface $categoryGateway,
        AddProductToSellPresenterToJson $AddProductToSellPresenterToJson
        
        ){

        $jsonRequest=json_decode($request->getContent());

        $useCaseRequest=new AddProductToSellRequest();
        $useCaseRequest->setProductToAdd(new Product((array)$jsonRequest->product));
         
        $useCase=new AddProductToSellUseCase($productGateway,$vatGateway,$categoryGateway,new Validator());
        $response=$useCase->execute($useCaseRequest);

        
        return $AddProductToSellPresenterToJson->present($response);
    
    }

    /**
     * @Route("/API/product/list",methods={"GET"})
     */
    public function listAction(
        Request $request,
        ProductGatewayInterface $productGateway,
        VATRateGatewayInterface $vatGateway,
        CategoryGatewayInterface $categoryGateway,

        ListProductToSellPresenterToJson $presenter
    ){  
        $useCaseRequest=new ListProductToSellRequest();

        $useCase=new ListProductToSellUseCase($productGateway,$vatGateway,$categoryGateway );
        return $useCase->execute($useCaseRequest, $presenter);

    }



}