<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\User;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

#[AsCommand(
    name: 'app:setup',
    description: 'Creates default user and categories if not created already',
)]
class SetupCommand extends Command
{
    public function __construct(private PasswordHasherFactoryInterface $passwordHasherFactory, private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->createDefaultUser($io);
        $this->createDefaultCategories($io);
        $io->success('App setup completed :3');

        return Command::SUCCESS;
    }

    private function createDefaultUser($io): void
    {
        $existsUser = $this->entityManager->getRepository(Category::class)->findOneBy([]);
        if ($existsUser) {
            $io->note('Default user already exists - skipping');
            return;
        }
        $passwordHasher = $this->passwordHasherFactory->getPasswordHasher(User::class);
        $user = new User()
            ->setUsername('user')
            ->setPassword($passwordHasher->hash('changeme'))
            ->setLocale('de')
            ->setCurrency('EUR')
            ->setAccountBalance(0);
        $this->entityManager->persist($user); 
        $io->note('Default user created: user/changeme');
    }

    private function createDefaultCategories($io): void
    {
        $existsCategory = $this->entityManager->getRepository(Category::class)->findOneBy([]);
        if ($existsCategory) {
            $io->note('Categories already exist - skipping');
            return;
        }
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
            $this->entityManager->persist($category);
        }

        $this->entityManager->flush();
        $io->note('Default categories created');
    }
}
