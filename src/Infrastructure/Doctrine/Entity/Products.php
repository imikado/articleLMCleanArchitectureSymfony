<?php

namespace Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 *
 * @ORM\Table(name="products")
 * @ORM\Entity
 */
class Products
{

    public function __construct(array $dataList=[])
    {
        if(count($dataList)>0){
           foreach($dataList as $field => $value){
                if(property_exists($this,$field)){
                    $this->$field = $value;
                }
            }
        }
    }

    /**
     * @var int
     *
     * @ORM\Column(name="PR_PKEY", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="PR_Title", type="string", length=100, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="PR_Desc", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="PR_excTaxBuyingPrice", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $excTaxBuyingPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="PR_excTaxSellingPrice", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $excTaxSellingPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="PR_incTaxSellingPrice", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $incTaxSellingPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="PR_stock", type="integer", nullable=false)
     */
    private $stock;

    /**
     * @var int
     *
     * @ORM\Column(name="PR_visible", type="integer", nullable=false)
     */
    private $visible;

    /**
     * @var int
     *
     * @ORM\Column(name="PR_category_id", type="integer", nullable=false)
     */
    private $category_id;

    /**
     * @var int
     *
     * @ORM\Column(name="PR_vatRate_id", type="integer", nullable=false)
     */
    private $vatRate_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getExctaxbuyingprice(): ?string
    {
        return $this->exctaxbuyingprice;
    }

    public function setExctaxbuyingprice(string $exctaxbuyingprice): self
    {
        $this->exctaxbuyingprice = $exctaxbuyingprice;

        return $this;
    }

    public function getExctaxsellingprice(): ?string
    {
        return $this->exctaxsellingprice;
    }

    public function setExctaxsellingprice(string $exctaxsellingprice): self
    {
        $this->exctaxsellingprice = $exctaxsellingprice;

        return $this;
    }

    public function getInctaxsellingprice(): ?string
    {
        return $this->inctaxsellingprice;
    }

    public function setInctaxsellingprice(string $inctaxsellingprice): self
    {
        $this->inctaxsellingprice = $inctaxsellingprice;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getVisible(): ?int
    {
        return $this->visible;
    }

    public function setVisible(int $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    public function getVatrateId(): ?int
    {
        return $this->vatrateId;
    }

    public function setVatrateId(int $vatrateId): self
    {
        $this->vatrateId = $vatrateId;

        return $this;
    }

    

}
