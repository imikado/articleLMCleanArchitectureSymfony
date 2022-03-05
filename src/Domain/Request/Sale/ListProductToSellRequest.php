<?php 

namespace Domain\Request\Sale;


class ListProductToSellRequest{

    protected int $limitByPage=0;
    protected int $page=1;

    public function setLimitByPage(int $limit){
        $this->limit=$limit;
    }
    public function setPage(int $page){
        return $this->page=$page;
    }

    public function getLimitByPage(){
        return $this->limitByPage;
    }
    public function getPage(){
        return $this->page;
    }

    
}