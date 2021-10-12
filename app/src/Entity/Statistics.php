<?php


namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Action\NotFoundAction;

use App\ApiPlatform\FromToFilter;

/**
 * Class Statistics
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
class Statistics
{
    public function __construct()
    {
        $this->id = 0;
    }

    private int $id;

    private int $balance;

    private int $incomeSum;

    private int $expenditureSum;

    private int $count;

    private int $incomeCount;

    private int $expenditureCount;

    private float $incomeAvg;

    private float $expenditureAvg;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getBalance(): int
    {
        return $this->balance;
    }

    /**
     * @return int
     */
    public function getIncomeSum(): int
    {
        return $this->incomeSum;
    }

    /**
     * @return int
     */
    public function getExpenditureSum(): int
    {
        return $this->expenditureSum;
    }

    /**
     * @return float
     */
    public function getIncomeAvg(): float
    {
        return $this->incomeAvg;
    }

    /**
     * @return float
     */
    public function getExpenditureAvg(): float
    {
        return $this->expenditureAvg;
    }


    /**
     * @param int $balance
     */
    public function setBalance(int $balance): void
    {
        $this->balance = $balance;
    }

    /**
     * @param int $incomeSum
     */
    public function setIncomeSum(int $incomeSum): void
    {
        $this->incomeSum = $incomeSum;
    }

    /**
     * @param int $expenditureSum
     */
    public function setExpenditureSum(int $expenditureSum): void
    {
        $this->expenditureSum = $expenditureSum;
    }

    /**
     * @param float $incomeAvg
     */
    public function setIncomeAvg(float $incomeAvg): void
    {
        $this->incomeAvg = $incomeAvg;
    }

    /**
     * @param float $expenditureAvg
     */
    public function setExpenditureAvg(float $expenditureAvg): void
    {
        $this->expenditureAvg = $expenditureAvg;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getIncomeCount(): int
    {
        return $this->incomeCount;
    }

    /**
     * @param int $incomeCount
     */
    public function setIncomeCount(int $incomeCount): void
    {
        $this->incomeCount = $incomeCount;
    }

    /**
     * @return int
     */
    public function getExpenditureCount(): int
    {
        return $this->expenditureCount;
    }

    /**
     * @param int $expenditureCount
     */
    public function setExpenditureCount(int $expenditureCount): void
    {
        $this->expenditureCount = $expenditureCount;
    }

}