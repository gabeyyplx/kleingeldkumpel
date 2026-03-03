<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class AppFixtures extends Fixture
{

    public function __construct(private PasswordHasherFactoryInterface $passwordHasherFactory) 
    {
    }

    public function load(ObjectManager $manager): void
    {
        $passwordHasher = $this->passwordHasherFactory->getPasswordHasher(User::class);
        $user = new User()
            ->setUsername('user')
            ->setPassword($passwordHasher->hash('changeme'))
            ->setLocale('de')
            ->setCurrency('EUR')
            ->setAccountBalance(0);
            
        $manager->persist($user); 

        $categories = [
            '👷' => 'Work',
            '🏠' => 'Living',
            '🛒' => 'Groceries',
            '🍕' => 'Takeout',
            '👕' => 'Clothing',
            '💅' => 'Self care & Beauty',
            '🚗' => 'Transportation',
            '☎️' => 'Telecommunication',
            '📅' => 'Subscriptions',
            '❤️‍🩹' => 'Insurance',
            '✈️' => 'Travel',
            '🎉' => 'Leisure',
            '🎁' => 'Gifts',
            '😇' => 'Charity & Donations',
            '🐖' => 'Saving',
            '📦' => 'Other'
        ];

        foreach($categories as $symbol => $name) {
            $category = new Category()
                ->setName($name)
                ->setSymbol($symbol)
                ->setActive(true);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
