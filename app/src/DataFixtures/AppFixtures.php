<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\CategoryFactory;
use App\Factory\CurrencyFactory;
use App\Factory\TransactionFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use function Zenstruck\Foundry\faker;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        foreach (['Food', 'Entertainment', 'Travel', 'Office', 'Home'] as $name) {
            CategoryFactory::new([
                'name' => $name,
                'color' => faker()->hexColor(),
            ])->create();
        }
        CurrencyFactory::new([
            'name' => 'Polish zloty',
            'acronym' => 'PLN',
        ])->create();
        UserFactory::createMany(5);

        TransactionFactory::createMany(20, function () {
            return [
                'category' => CategoryFactory::random(),
                'currency' => CurrencyFactory::random(),
                'madeBy' => UserFactory::random()
            ];
        });

        $manager->flush();
    }
}
