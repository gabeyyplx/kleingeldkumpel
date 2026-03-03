<?php

namespace App\Controller;

use App\Entity\RecurringTransaction;
use App\Entity\User;
use App\Form\RecurringTransactionType;
use App\Repository\RecurringTransactionRepository;
use App\Service\RecurringTransactionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/settings/recurring-transaction')]
final class RecurringTransactionController extends AbstractController
{
    #[Route(name: 'app_recurring_transaction_index', methods: ['GET'])]
    public function index(#[CurrentUser] User $user, RecurringTransactionRepository $recurringTransactionRepository): Response
    {
        return $this->render('recurring_transaction/index.html.twig', [
            'recurring_transactions' => $recurringTransactionRepository->findByUser($user),
        ]);
    }

    #[Route('/new', name: 'app_recurring_transaction_new', methods: ['GET', 'POST'])]
    public function new(#[CurrentUser] User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $recurringTransaction = new RecurringTransaction();
        $form = $this->createForm(RecurringTransactionType::class, $recurringTransaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recurringTransaction->setUser($user);
            $entityManager->persist($recurringTransaction);
            $entityManager->flush();

            return $this->redirectToRoute('app_recurring_transaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recurring_transaction/new.html.twig', [
            'recurring_transaction' => $recurringTransaction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_recurring_transaction_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RecurringTransaction $recurringTransaction, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('TRANSACTION_EDIT', $recurringTransaction);
        $form = $this->createForm(RecurringTransactionType::class, $recurringTransaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_recurring_transaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recurring_transaction/edit.html.twig', [
            'recurring_transaction' => $recurringTransaction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recurring_transaction_delete', methods: ['POST'])]
    public function delete(Request $request, RecurringTransaction $recurringTransaction, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('TRANSACTION_DELETE', $recurringTransaction);
        if ($this->isCsrfTokenValid('delete'.$recurringTransaction->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($recurringTransaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_recurring_transaction_index', [], Response::HTTP_SEE_OTHER);
    }
}
