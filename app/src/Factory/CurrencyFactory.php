<?php

namespace App\Factory;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Currency|Proxy createOne(array $attributes = [])
 * @method static Currency[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Currency|Proxy find($criteria)
 * @method static Currency|Proxy findOrCreate(array $attributes)
 * @method static Currency|Proxy first(string $sortedField = 'id')
 * @method static Currency|Proxy last(string $sortedField = 'id')
 * @method static Currency|Proxy random(array $attributes = [])
 * @method static Currency|Proxy randomOrCreate(array $attributes = [])
 * @method static Currency[]|Proxy[] all()
 * @method static Currency[]|Proxy[] findBy(array $attributes)
 * @method static Currency[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Currency[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CurrencyRepository|RepositoryProxy repository()
 * @method Currency|Proxy create($attributes = [])
 */
final class CurrencyFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

    }

    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->word(),
            'acronym' => self::faker()->currencyCode(),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Currency $currency) {})
        ;
    }

    protected static function getClass(): string
    {
        return Currency::class;
    }
}
