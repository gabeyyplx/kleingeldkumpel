<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Entity\User;
use App\Form\TransactionType;
use App\Repository\TransactionRepository;
use App\Service\RecurringTransactionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/transaction')]
final class TransactionController extends AbstractController
{
    public function __construct(
        private RecurringTransactionService $recurringService,
    ) {}

    #[Route(name: 'app_transaction_index', methods: ['GET'])]
    public function index(#[CurrentUser] User $user, TransactionRepository $transactionRepository): Response
    {
        $this->recurringService->applyDue($user);
        return $this->render('transaction/index.html.twig', [
            'transactions' => $transactionRepository->findBy(['user' => $user], ['date' => 'DESC'])
        ]);
    }

    #[Route('/new', name: 'app_transaction_new', methods: ['GET', 'POST'])]
    public function new(#[CurrentUser] User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->addTransaction($transaction);
            $entityManager->persist($transaction);
            $entityManager->flush();
            return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transaction/new.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_transaction_edit', methods: ['GET', 'POST'])]
    public function edit(#[CurrentUser] User $user, Request $request, Transaction $transaction, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('TRANSACTION_EDIT', $transaction);
        $oldValue = $transaction->calcSignedValue();

        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newValue = $transaction->calcSignedValue();
            $user->applyTransactionDelta($oldValue, $newValue);
            $entityManager->flush();
            return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transaction/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_transaction_delete', methods: ['POST'])]
    public function delete(#[CurrentUser] User $user, Request $request, Transaction $transaction, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('TRANSACTION_DELETE', $transaction);

        if ($this->isCsrfTokenValid('delete'.$transaction->getId(), $request->getPayload()->getString('_token'))) {
            $user->removeTransaction($transaction);
            $entityManager->remove($transaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
    }
}
