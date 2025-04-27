<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Form\ReservationsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_LIBRARIAN', message: "Vous n'êtes pas autorisé à accéder à cette action.")]
#[Route('/reservations')]
final class ReservationsController extends AbstractController
{
    #[Route(name: 'app_reservations_index', methods: ['GET'])]
    public function index(ReservationsRepository $reservationsRepository): Response
    {
        return $this->render('reservations/index.html.twig', [
            'reservations' => $reservationsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reservations_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservations();
        $form = $this->createForm(ReservationsType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setReference(uniqid('RES_'));
            $reservation->setStatus('pending');
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservations/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservations_show', methods: ['GET'])]
    public function show(Reservations $reservation): Response
    {
        return $this->render('reservations/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservations_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservations $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationsType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservations/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservations_delete', methods: ['POST'])]
    public function delete(Request $request, Reservations $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservations_index', [], Response::HTTP_SEE_OTHER);
    }
}
