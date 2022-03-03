<?php 

namespace Infrastructure\Symfony\Presenter;

use Domain\Presenter\ExecutionPresenterInterface;
use Domain\Response\ExecutionResponse;

use Symfony\Component\HttpFoundation\JsonResponse;

class ExecutionPresenterToJson implements ExecutionPresenterInterface{

    public function present(ExecutionResponse $response)
    {

        $statusCode=500;
        $content=(object)[];

        if($response->isStatusSuccess()){
            $statusCode=200;
            $content->message = $response->getSuccessMessage();

        }else if($response->isStatusFailed() or $response->isStatusException()){
            $statusCode=500;

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