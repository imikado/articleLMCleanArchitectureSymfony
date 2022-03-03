<?php 

namespace Domain\Presenter\Sale;

use Domain\Response\Sale\AddProductToSellResponse;

interface AddProductToSellPresenterInterface{

    public function present(AddProductToSellResponse $response)  ;

}