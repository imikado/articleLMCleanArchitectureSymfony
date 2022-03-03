<?php 

namespace Infrastructure\Symfony\Presenter\Sale;

use Domain\Presenter\Sale\AddProductToSellPresenterInterface;
use Domain\Response\Sale\AddProductToSellResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class AddProductToSellPresenterToJson implements AddProductToSellPresenterInterface{

    public function present(AddProductToSellResponse $response)
    {

        $statusCode=500;
        $content=(object)[];

        if($response->isStatusSuccess()){
            $statusCode=200;
            $content->message = $response->getSuccessMessage();

        }else if($response->isStatusFailed() ){
            $statusCode=500;
            $content->error=$response->getFailedMessage();
        }else if($response->isStatusException()){
            $statusCode=500;
            $content->error=$response->getException()->getMessage();

            //execute needed action with exception or failed message (log, mail to support..)
        }else if($response->isStatusNotValid()){
            $statusCode=400;
            
            $content->message= 'You have some errors in your request';
            $content->errors=$response->getFieldErrorMessageList();    
        }else{

            $statusCode=500;
            $content->message='unknown status';
        }

        $jsonResponse=new JsonResponse();
        $jsonResponse->setStatusCode($statusCode);
        $jsonResponse->setContent( json_encode($content));

        return $jsonResponse;
    }

}