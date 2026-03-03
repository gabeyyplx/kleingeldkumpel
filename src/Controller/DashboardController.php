<?php

namespace App\Controller;

use App\Repository\TransactionRepository;
use App\Entity\User;
use App\Service\RecurringTransactionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

final class DashboardController extends AbstractController
{
    public function __construct(
        private RecurringTransactionService $recurringService,
    ) {}

    #[Route('/', name: 'app_dashboard')]
    public function index(#[CurrentUser] User $user, Request $request, TransactionRepository $transactionRepository): Response
    {
        $this->recurringService->applyDue($user);
        $to = $request->query->get('to');
        $from = $request->query->get('from');

        $toDate = $to ? new \DateTimeImmutable($to) : new \DateTimeImmutable();
        $fromDate = $from
            ? new \DateTimeImmutable($from)
            : $toDate->modify('-31 days');

        $data = $transactionRepository->fetchDashboardData(
            $fromDate,
            $toDate,
            $user
        );

        return $this->render('dashboard/index.html.twig', [
            'total' => $user->getAccountBalance(),
            'expenseCategories' => array_keys($data['expenses']),
            'expenseValues' => array_values($data['expenses']),
            'from' => $fromDate,
            'to' => $toDate,
        ]);
    }
}
