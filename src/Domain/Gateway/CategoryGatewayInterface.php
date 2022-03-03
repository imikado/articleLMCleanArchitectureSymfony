<?php 

namespace Domain\Gateway;

use Domain\Entity\Category;

interface CategoryGatewayInterface{

    public function add(Category $newCategory): GatewayResponse;
    
    public function findAll(): array;

    public function findById($id): ?object;

    
}