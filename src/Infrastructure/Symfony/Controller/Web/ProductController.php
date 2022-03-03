<?php 

namespace Infrastructure\Symfony\Controller\Web;

use Domain\Entity\Product;
use Domain\Gateway\CategoryGatewayInterface;
use Domain\Gateway\ProductGatewayInterface;
use Domain\Gateway\VATRateGatewayInterface;
use Domain\Request\Sale\AddProductToSellRequest;
use Domain\Tool\Validator;
use Domain\UseCase\Sale\AddProductToSellUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;


class ProductController extends AbstractController{

    /**
     * @Route("/Web/product/add" )
     */
    public function addFormAction(
                    Request $httpRequest,
                    ProductGatewayInterface $productGateway,
                    VATRateGatewayInterface $vatRateGateway,
                    CategoryGatewayInterface $categoryGateway){

        $dropdownCategoryList=$categoryGateway->getDropdownList();
        $dropdownVatRateList=$vatRateGateway->getDropdownList();

        $form= $this->createFormBuilder(new Product())
        ->add('title', TextType::class)

        ->add('category_id', ChoiceType::class,['choices'=>$dropdownCategoryList])
        ->add('vatRate_id', ChoiceType::class,['choices'=>$dropdownVatRateList])
        
        ->add('excTaxBuyingPrice', TextType::class)
        ->add('excTaxSellingPrice', TextType::class)
        ->add('description', TextType::class)
        ->add('stock', TextType::class)

        
        ->add('save', SubmitType::class, ['label' => 'Create Product'])
        ->getForm(); 

        $form->handleRequest($httpRequest);

        if ($form->isSubmitted() && $form->isValid()) {

            $useCaseRequest=new AddProductToSellRequest();
            $useCaseRequest->setProductToAdd(new Product( (array)$form->getData()));
 
            $useCase=new AddProductToSellUseCase($productGateway,$vatRateGateway,$categoryGateway,new Validator());
            $response=$useCase->execute($useCaseRequest);

            if($response->isStatusSuccess()){
                return $this->redirect('/Web/product/list');
            }

            $errorList=$response->getFieldErrorMessageList();

            if($response->isStatusException()){
                $form->addError(new FormError( $response->getException()->getMessage() ));
            }else{
                foreach($errorList as $field => $errorMessage){
                    $form->get($field)->addError(new FormError( join(',',$errorMessage) ));
                }
            }
        }
    

        return $this->render('Sale/AddProductToSell.html.twig',['form'=>$form->createView()]);


    }

}