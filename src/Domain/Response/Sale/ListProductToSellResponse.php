<?php 

namespace Domain\Response\Sale;

class ListProductToSellResponse{

    protected $status;

    const STATUS_SUCCESS='SUCCESS';
    const STATUS_NOTVALID='NOTVALID';
    const STATUS_FAILED='FAILED';
    const STATUS_EXCEPTION='EXCEPTION';

    protected array $errorList=[];
    protected \Exception $exception;

    protected String $failedMessage;
    protected String $successMessage;

    protected $productList=[];

    public function setStatusNotValid(){
        $this->status=self::STATUS_NOTVALID;
    }
    public function setStatusSuccess(){
        $this->status=self::STATUS_SUCCESS;
    }
    public function setStatusException(){
        $this->status=self::STATUS_EXCEPTION;
    }
    public function setStatusFailed(){
        $this->status=self::STATUS_FAILED;
    }
    

    public function setSuccessMessage($message){
        $this->successMessage=$message;
    }
    public function getSuccessMessage(){
        return $this->successMessage;
    }

    public function setFailedMessage($message){
        $this->failedMessage=$message;
    }
    public function getFailedMessage(){
        return $this->failedMessage;
    }

    public function isStatusNotValid(){
        return ($this->status===self::STATUS_NOTVALID);
    }
    public function isStatusSuccess(){
        return ($this->status===self::STATUS_SUCCESS);
    }
    public function isStatusException(){
        return ($this->status===self::STATUS_EXCEPTION);
    }
    public function isStatusFailed(){
        return ($this->status===self::STATUS_FAILED);
    }

    public function addFieldErrorMessage($field,$message){
        $this->errorList[$field][]=$message;
    }

    public function getFieldErrorMessageList(){

        return $this->errorList;
    }

    public function setException($e){
        $this->exception=$e;
    }
    public function getException(){
        return $this->exception;
    }

    public function addProduct($product){
        $this->productList[]=$product;
    }
    public function setProductList($productList){
        $this->productList=$productList;
    }

    public function getProductList(){
        return $this->productList;
    }
    
}