<?php 

namespace Domain\Gateway;

use Domain\Entity\Product;

interface ProductGatewayInterface{

    public function add(Product $newProduct): GatewayResponse;
    
    public function findAll(): array;

    public function findListByCategory($categoryId): array;

    
    
}