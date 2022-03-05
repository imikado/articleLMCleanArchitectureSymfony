<?php 
namespace Infrastructure\FileDb;

use Domain\Entity\Product ;
use Domain\Gateway\GatewayResponse;
use Domain\Gateway\ProductGatewayInterface;
 
class ProductRepository //implements ProductGatewayInterface
{

    const PATH='/home/mika/tmp/dataDb/shopExple/product/';

    public function add(Product $product):GatewayResponse{

        $i=1;
        $fileList=scandir(self::PATH);
        foreach($fileList as $file){
            if(substr(basename($file),0,1)=='.') continue;
            $i++;
        }

        $newFilename=$i.'.json';
        $product->id=$i;

        file_put_contents(self::PATH.'/'.$newFilename,json_encode($product));

        $response= new GatewayResponse();
        $response->setStatusSuccess();
        return $response;
    }

    public function findAll(): array
    {
        $productList=[];

        $fileList=scandir(self::PATH);
        foreach($fileList as $file){
            if(substr(basename($file),0,1)=='.') continue;
            
            $productList[]=json_decode(file_get_contents(self::PATH.'/'.basename($file)));
        }

        return $productList;
    }

    public function findListByCategory($categoryId): array
    {
        $productList=[];

        $fileList=scandir(self::PATH);
        foreach($fileList as $file){
            if(substr(basename($file),0,1)=='.') continue;
            
            $productInFile=json_decode(file_get_contents(self::PATH.'/'.basename($file)));

            if($productInFile->category_id!=$categoryId) continue;

            $productList[]=$productInFile;
        }

        return $productList;  
    } 

}