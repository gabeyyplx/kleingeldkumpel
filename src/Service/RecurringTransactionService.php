<?php

namespace App\Service;

use App\Entity\RecurringTransaction;
use App\Entity\User;
use App\Form\RecurringTransactionType;
use App\Repository\RecurringTransactionRepository;
use Doctrine\ORM\EntityManagerInterface;

class RecurringTransactionService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private RecurringTransactionRepository $repository,
    ) {}

    public function applyDue(User $user): void
    {
        $recurringTransactions = $this->repository->findByUser($user);

        foreach ($recurringTransactions as $recurring) {
           foreach ($recurring->getDueDates() as $date) {
                $transaction = $recurring->createTransaction();
                $transaction->setDate($date);
                $recurring->setLastApplied($date);
                $this->entityManager->persist($transaction);
                $user->addTransaction($transaction);
            }
        }
        $this->entityManager->flush();
    }
}