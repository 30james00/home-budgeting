<?php

namespace App\ApiPlatform;

use ApiPlatform\Core\Serializer\Filter\FilterInterface;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;

class PeriodBalanceFilter implements FilterInterface
{
    public const PERIOD_FILTER_CONTEXT = 'period_balance_period';
    public const FROM_FILTER_CONTEXT = 'period_balance_from';
    public const TO_FILTER_CONTEXT = 'period_balance_to';

    public function apply(Request $request, bool $normalization, array $attributes, array &$context): void
    {
        $period = $request->query->get('period');
        $from = $request->query->get('from');
        $to = $request->query->get('to');

        $context[self::PERIOD_FILTER_CONTEXT] = $period;

        $fromDate = DateTimeImmutable::createFromFormat('Y-m-d', (string)$from);
        if ($fromDate) {
            $fromDate = $fromDate->setTime(0, 0);
            $context[self::FROM_FILTER_CONTEXT] = $fromDate;
        }

        $toDate = DateTimeImmutable::createFromFormat('Y-m-d', (string)$to);
        if ($toDate) {
            $toDate = $toDate->setTime(23, 59, 59);
            $context[self::TO_FILTER_CONTEXT] = $toDate;
        }
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'period' =>
                [
                    'property' => null,
                    'type' => 'string',
                    'required' => true,
                    'openapi' => [
                        'description' => 'Group balance by "year", "month" or "day"'
                    ]
                ],
            'from' =>
                [
                    'property' => null,
                    'type' => 'string',
                    'required' => false,
                    'openapi' => [
                        'description' => 'Show balances from this day (YYYY-MM-DD)'
                    ]
                ],
            'to' =>
                [
                    'property' => null,
                    'type' => 'string',
                    'required' => false,
                    'openapi' => [
                        'description' => 'Show balances before this day (YYYY-MM-DD)'
                    ]
                ],
        ];
    }
}