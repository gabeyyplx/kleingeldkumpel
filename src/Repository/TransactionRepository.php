<?php

namespace App\Repository;

use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTimeInterface;

/**
 * @extends ServiceEntityRepository<Transaction>
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function fetchDashboardData(
        DateTimeInterface $from,
        DateTimeInterface $to,
        User $user
    ): array {
        $total = $this->createQueryBuilder('t')
            ->select('
                SUM(
                    CASE 
                        WHEN t.isIncome = true THEN t.value
                        ELSE -t.value
                    END
                ) as total
            ')
            ->andWhere('t.date BETWEEN :from AND :to')
            ->andWhere('t.user = :user')
            ->setParameter('from', $from)
            ->setParameter('to', $to)
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();

        $expenses = $this->createQueryBuilder('t')
            ->select('c.name as category, SUM(t.value) as value')
            ->join('t.category', 'c')
            ->andWhere('t.isIncome = false')
            ->andWhere('t.date BETWEEN :from AND :to')
            ->groupBy('c.id')
            ->setParameter('from', $from)
            ->setParameter('to', $to)
            ->getQuery()
            ->getResult();

        $expensePerCategory = [];
        foreach ($expenses as $row) {
            $expensePerCategory[$row['category']] = (float) $row['value'];
        }

        return [
            'total' => (float) $total,
            'expenses' => $expensePerCategory,
        ];
    }
}
