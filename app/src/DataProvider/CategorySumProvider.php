<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\ApiPlatform\FromToFilter;
use App\Entity\CategorySum;
use App\Service\StatisticsService;

class CategorySumProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private StatisticsService $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }


    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $from = $context[FromToFilter::FROM_FILTER_CONTEXT] ?? null;
        $to = $context[FromToFilter::TO_FILTER_CONTEXT] ?? null;

        $sums = $this->statisticsService->getCategorySum($from, $to);

        return array_reduce($sums, static function ($carry, $sum) {
            $carry[] = new CategorySum($sum["name"], $sum["sum"], $sum["color"]);
            return $carry;
        }, []);
    }

    public
    function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return CategorySum::class === $resourceClass;
    }
}