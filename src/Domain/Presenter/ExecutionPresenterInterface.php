<?php 

namespace Domain\Presenter;

use Domain\Response\ExecutionResponse;

interface ExecutionPresenterInterface{

    public function present(ExecutionResponse $response)  ;

}