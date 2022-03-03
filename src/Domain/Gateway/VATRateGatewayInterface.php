<?php 

namespace Domain\Gateway;

use Domain\Entity\VATRate;

interface VATRateGatewayInterface{

    public function add(VATRate $newVatRate): GatewayResponse;
 
    public function findAll(): array;

    public function findById($id): ?object;

    
    
}