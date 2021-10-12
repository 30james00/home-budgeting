<?php

namespace App\Factory;

use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Transaction|Proxy createOne(array $attributes = [])
 * @method static Transaction[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Transaction|Proxy find($criteria)
 * @method static Transaction|Proxy findOrCreate(array $attributes)
 * @method static Transaction|Proxy first(string $sortedField = 'id')
 * @method static Transaction|Proxy last(string $sortedField = 'id')
 * @method static Transaction|Proxy random(array $attributes = [])
 * @method static Transaction|Proxy randomOrCreate(array $attributes = [])
 * @method static Transaction[]|Proxy[] all()
 * @method static Transaction[]|Proxy[] findBy(array $attributes)
 * @method static Transaction[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Transaction[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static TransactionRepository|RepositoryProxy repository()
 * @method Transaction|Proxy create($attributes = [])
 */
final class TransactionFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->text(255),
            'value' => self::faker()->numberBetween(-100000, 100000),
            'createDate' => self::faker()->dateTimeBetween('-5 years'),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this// ->afterInstantiate(function(Transaction $transaction) {})
            ;
    }

    protected static function getClass(): string
    {
        return Transaction::class;
    }
}
