<?php 

namespace Domain\Presenter\Sale;

use Domain\Response\Sale\ListProductToSellResponse;

interface ListProductToSellPresenterInterface{

    public function present(ListProductToSellResponse $response)  ;

}