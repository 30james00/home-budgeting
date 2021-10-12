<?php


namespace App\DataProvider;


use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\ApiPlatform\FromToFilter;
use App\Entity\Statistics;
use App\Service\StatisticsService;

class StatisticsProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{

    /**
     * @var StatisticsService
     */
    private $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {

        $this->statisticsService = $statisticsService;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): array
    {
        $from = $context[FromToFilter::FROM_FILTER_CONTEXT] ?? null;
        $to = $context[FromToFilter::TO_FILTER_CONTEXT] ?? null;

        $statistics = $this->statisticsService->getStatistics($from, $to);

        return [$statistics];
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Statistics::class === $resourceClass;
    }
}