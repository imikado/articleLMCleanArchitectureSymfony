<?php 

namespace Infrastructure\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Entity\Product;
use Domain\Gateway\GatewayResponse;
use Domain\Gateway\ProductGatewayInterface;
use Infrastructure\Doctrine\Entity\Products;

class ProductRepository extends ServiceEntityRepository implements ProductGatewayInterface
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    public function add(Product $newProduct): GatewayResponse
    {
        try{
        
            $products=new Products((array)$newProduct );
        
            $entityManager = $this->getEntityManager();
            $entityManager->persist($products);
            $entityManager->flush();



            $response=new GatewayResponse();
            $response->setStatusSuccess();
            return $response;

        }catch(\Exception $e){
            $response=new GatewayResponse();
            $response->setStatusFailed();
            $response->setFailedMessage($e->getMessage());
            return $response;
        }
    }
    public function findAll(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT 
            `PR_PKEY` as id,
            `PR_Title` as title,
            `PR_Desc` as description,
            `PR_excTaxBuyingPrice` as excTaxBuyingPrice,
            `PR_excTaxSellingPrice` as _excTaxSellingPrice,
            `PR_incTaxSellingPrice` as incTaxSellingPrice,
            `PR_stock` as stock,
            `PR_visible` as visible,
            `PR_category_id` as category_id,
            `PR_vatRate_id` as vatRate_id
            
            FROM products p
            
            ORDER BY id ASC
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        $rowList = $resultSet->fetchAllAssociative();
        
        return $this->convertToProductList($rowList);
    }

    private function convertToProductList($rowList){
        $productList=[];
        foreach($rowList as $row){
            $productList[]=new Product($row);

        }

        return $productList; 
    }

    public function findListByCategory($categoryId): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT 
            `PR_PKEY` as id,
            `PR_Title` as title,
            `PR_Desc` as description,
            `PR_excTaxBuyingPrice` as excTaxBuyingPrice,
            `PR_excTaxSellingPrice` as _excTaxSellingPrice,
            `PR_incTaxSellingPrice` as incTaxSellingPrice,
            `PR_stock` as stock,
            `PR_visible` as visible,
            `PR_category_id` as category_id,
            `PR_vatRate_id` as vatRate_id
            
            FROM products p

            WHERE PR_category_id=:category_id
            
            ORDER BY id ASC
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['category_id' => $categoryId]);

        $rowList = $resultSet->fetchAllAssociative();
        
        return $this->convertToProductList($rowList);

    }

    
}