<?php 

namespace Infrastructure\Symfony\Presenter\Sale;

use Domain\Presenter\Sale\ListProductToSellPresenterInterface;
use Domain\Response\Sale\ListProductToSellResponse;
use Infrastructure\Symfony\Presenter\PresenterToHtml;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class ListProductToSellPresenterToHtml  extends AbstractController implements ListProductToSellPresenterInterface {


    public function present(ListProductToSellResponse $response)
    {
        

        return $this->render('Sale/ListProductToSell.html.twig',['productList'=>$response->getProductList()]);

         
    }

}