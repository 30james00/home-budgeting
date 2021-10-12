<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Action\NotFoundAction;
use App\ApiPlatform\PeriodBalanceFilter;

/**
 * @ApiResource(
 *     itemOperations={
 *         "get"={
 *             "method"="GET",
 *             "controller"=NotFoundAction::class,
 *             "read"=false,
 *             "output"=false,
 *         },
 *     },
 *     collectionOperations={"get"}
 * )
 * @ApiFilter(PeriodBalanceFilter::class)
 */
class PeriodBalance
{

    /**
     * @ApiProperty(identifier=true)
     * @var string
     */
    private string $period;

    private int $value;

    public function __construct(string $period, int $value)
    {
        $this->period = $period;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getPeriod(): string
    {
        return $this->period;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}