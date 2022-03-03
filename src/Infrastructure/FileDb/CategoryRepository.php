<?php 
namespace Infrastructure\FileDb;

use Domain\Entity\Category;
use Domain\Gateway\CategoryGatewayInterface;
use Domain\Gateway\GatewayResponse;

class CategoryRepository implements CategoryGatewayInterface {

    const PATH='/home/mika/tmp/dataDb/shopExple/category/';

    public function add(Category $category):GatewayResponse{

        $i=1;
        $fileList=scandir(self::PATH);
        foreach($fileList as $file){
            if(substr(basename($file),0,1)=='.') continue;
            $i++;
        }

        $newFilename=$i.'.json';
        $category->id=$i;
        file_put_contents(self::PATH.'/'.$newFilename,json_encode($category));

        $response= new GatewayResponse();
        $response->setStatusSuccess();
        return $response;
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