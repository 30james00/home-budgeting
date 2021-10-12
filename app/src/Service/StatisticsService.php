<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\PeriodBalance;
use App\Entity\Statistics;
use App\Repository\TransactionRepository;
use DateTimeInterface;
use Doctrine\ORM\QueryBuilder;
use Exception;
use Psr\Log\LoggerInterface;

class StatisticsService
{
    /**
     * @var TransactionRepository
     */
    private TransactionRepository $transactionRepository;

    private LoggerInterface $logger;

    public function __construct(TransactionRepository $transactionRepository, LoggerInterface $logger)
    {
        $this->transactionRepository = $transactionRepository;
        $this->logger = $logger;
    }


    /**
     * Global statistics
     * @param DateTimeInterface|null $from Starting day of time period from filter
     * @param DateTimeInterface|null $to Ending day of time period from filter
     * @return Statistics
     */
    public function getStatistics(?DateTimeInterface $from = null, ?DateTimeInterface $to = null): Statistics
    {
        //initialize values
        $expenditureSum = 0;
        $incomeSum = 0;
        $incomeCount = 0;
        $expenditureCount = 0;

        $expenditureSumQuery = $this->transactionRepository->createQueryBuilder("transaction");
        $incomeSumQuery = $this->transactionRepository->createQueryBuilder("transaction");
        $expenditureCountQuery = $this->transactionRepository->createQueryBuilder('transaction');
        $incomeCountQuery = $this->transactionRepository->createQueryBuilder('transaction');

        $queries = [$expenditureSumQuery, $expenditureCountQuery, $incomeSumQuery, $incomeCountQuery];

        foreach ($queries as $query) {
            $query = $this->addFromToWhere($query, $from, $to);
        }

        //get data from repository
        try {
            $expenditureSum = $expenditureSumQuery->select('sum(transaction.value)')
                    ->andWhere('transaction.value<0')
                    ->getQuery()->getSingleScalarResult() ?? 0;
        } catch (Exception $e) {
            $this->logger->critical($e->getMessage());
        }

        try {
            $incomeSum = $incomeSumQuery->select('sum(transaction.value)')
                    ->andWhere('transaction.value>0')
                    ->getQuery()->getSingleScalarResult() ?? 0;
        } catch (Exception $e) {
            $this->logger->critical($e->getMessage());
        }
        try {
            $expenditureCount = $expenditureCountQuery->select('count(transaction.id)')
                    ->andWhere('transaction.value<0')
                    ->getQuery()->getSingleScalarResult() ?? 0;
        } catch (Exception $e) {
            $this->logger->critical($e->getMessage());
        }
        try {
            $incomeCount = $incomeCountQuery->select('count(transaction.id)')
                    ->andWhere('transaction.value>0')
                    ->getQuery()->getSingleScalarResult() ?? 0;
        } catch (Exception $e) {
            $this->logger->critical($e->getMessage());
        }

        //set data to Statistics entity
        $statistics = new Statistics();
        $statistics->setBalance($expenditureSum + $incomeSum);
        $statistics->setCount($incomeCount + $expenditureCount);
        $statistics->setExpenditureSum($expenditureSum);
        $statistics->setExpenditureAvg($expenditureCount > 0 ? ($expenditureSum / $expenditureCount) : 0);
        $statistics->setExpenditureCount($expenditureCount);
        $statistics->setIncomeSum($incomeSum);
        $statistics->setIncomeAvg($incomeCount > 0 ? $incomeSum / $incomeCount : 0);
        $statistics->setIncomeCount($incomeCount);
        return $statistics;
    }

    /**
     * Sums expenditures for each category
     * @return array category-expenditures pairs
     */
    public function getCategorySum(?DateTimeInterface $from = null, ?DateTimeInterface $to = null): array
    {
        $query = $this->transactionRepository->createQueryBuilder("transaction")
            ->select("category.name, sum(transaction.value) as sum, category.color")
            ->join("transaction.category", "category")
            ->where("transaction.value<0")
            ->groupBy("category");

        $query = $this->addFromToWhere($query, $from, $to);

        return (array)$query->getQuery()->getArrayResult();
    }

    /**
     * Balance for each chosen period
     * @param string $period year month or day
     */
    public function getPeriodBalance(string $period, ?DateTimeInterface $from = null, ?DateTimeInterface $to = null): array
    {
        $query = $this->transactionRepository->createQueryBuilder('transaction');

        switch ($period) {
            case "year":
                $query->select("DATE_FORMAT(transaction.createDate, 'YYYY') as period, sum(transaction.value) as sum")
                    ->groupBy("period");
                break;
            case "month":
                $query->select("DATE_FORMAT(transaction.createDate, 'YYYY-MM') as period, sum(transaction.value) as sum")
                    ->groupBy("period");
                break;
            case "day":
                $query->select("DATE_FORMAT(transaction.createDate, 'YYYY-MM-DD') as period, sum(transaction.value) as sum")
                    ->groupBy("period");
                break;
        }
        $query = $this->addFromToWhere($query, $from, $to);
        $result = $query->orderBy("period")->getQuery()->getArrayResult();

        return array_reduce($result, static function ($carry, $row) {
            $carry[] = new PeriodBalance($row['period'], $row['sum']);
            return $carry;
        }, []);
    }

    private function addFromToWhere(QueryBuilder $query, ?DateTimeInterface $from = null, ?DateTimeInterface $to = null): QueryBuilder
    {
        if ($from) {
            $query->andWhere("transaction.createDate > :from")->setParameter('from', date_format($from, "Y-m-d H:i:s"));
        }
        if ($to) {
            $query->andWhere("transaction.createDate <= :to")->setParameter('to', date_format($to, "Y-m-d H:i:s"));
        }
        return $query;
    }
}
