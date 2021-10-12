<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Action\NotFoundAction;
use App\ApiPlatform\FromToFilter;

/**
 * @ApiResource(
 *   itemOperations={
 *         "get"={
 *             "method"="GET",
 *             "controller"=NotFoundAction::class,
 *             "read"=false,
 *             "output"=false,
 *         },
 *     },
 *     collectionOperations={"get"}
 * )
 * @ApiFilter(FromToFilter::class)
 */
class CategorySum
{
    /**
     * @ApiProperty(identifier=true)
     * @var string
     */
    private string $name;
    
    private int $sum;
    
    private string $color;

    public function __construct(string $name, int $sum, string $color)
    {
        $this->name = $name;
        $this->sum = $sum;
        $this->color = $color;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getSum(): int
    {
        return $this->sum;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }
}