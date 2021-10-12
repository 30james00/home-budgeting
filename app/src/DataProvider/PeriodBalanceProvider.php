<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\ApiPlatform\PeriodBalanceFilter;
use App\Entity\PeriodBalance;
use App\Service\StatisticsService;

class PeriodBalanceProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /**
     * @var StatisticsService
     */
    private $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $period = $context[PeriodBalanceFilter::PERIOD_FILTER_CONTEXT];
        $from = $context[PeriodBalanceFilter::FROM_FILTER_CONTEXT] ?? null;
        $to = $context[PeriodBalanceFilter::TO_FILTER_CONTEXT] ?? null;


        if ($period === 'year' || $period === 'month' || $period === 'day') {
            return $this->statisticsService->getPeriodBalance($period, $from, $to);
        }

        return [];
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return PeriodBalance::class === $resourceClass;
    }
}