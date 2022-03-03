<?php 
namespace Infrastructure\FileDb;

use Domain\Entity\VATRate;
use Domain\Gateway\GatewayResponse;
use Domain\Gateway\VATRateGatewayInterface;

class VATRateRepository implements VATRateGatewayInterface  {

    const PATH='/home/mika/tmp/dataDb/shopExple/vatRate/';

    public function add(VATRate $vatRate):GatewayResponse{

        $i=1;
        $fileList=scandir(self::PATH);
        foreach($fileList as $file){
            if(substr(basename($file),0,1)=='.') continue;
            $i++;
        }

        $newFilename=$i.'.json';
        $vatRate->id=$i;
        file_put_contents(self::PATH.'/'.$newFilename,json_encode($vatRate));

        $response= new GatewayResponse();
        $response->setStatusSuccess();
        return $response;
    }

    public function findAll(): array
    {
        $categoryList=[];

        $fileList=scandir(self::PATH);
        foreach($fileList as $file){
            if(substr(basename($file),0,1)=='.') continue;
            
            $categoryList[]=json_decode(file_get_contents(self::PATH.'/'.basename($file)));
        }

        return $categoryList;
    }

    public function findById($id): ?object
    {

        $fileList=scandir(self::PATH);
        foreach($fileList as $file){
            if(substr(basename($file),0,1)=='.') continue;

            $vatRateLoop=json_decode(file_get_contents(self::PATH.'/'.basename($file)));
            if($vatRateLoop->id==$id){
                return  $vatRateLoop;
            }
            
        }

        return null;
    }

    public function getDropdownList(): array
    {
        $categoryList=$this->findAll();

        $indexedList=['------please select------'=>0];

        foreach($categoryList as $category){
            $indexedList[ $category->title ]=$category->id;

        }

        return $indexedList;  
    } 

}