<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Books;
use App\Entity\Reservations;
use App\Repository\BooksRepository;
use App\Repository\AuthorRepository;
use App\Repository\StocksRepository;
use App\Repository\ThemesRepository;
use App\Repository\CategoryRepository;
use App\Repository\ReservationsRepository;
use App\Repository\LanguagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/usager')]
final class UsagerController extends AbstractController
{
    #[Route('/', name: 'app_usager')]
    public function index(
        Request $request,
        ThemesRepository $themesRepository,
        LanguagesRepository $languagesRepository,
        CategoryRepository $categoryRepository,
        BooksRepository $booksRepository,
        AuthorRepository $authorRepository
    ): Response
    {
        $search = $request->query->get('search');

        $authorId = $request->query->get('author');
        $categoryId = $request->query->get('category');
        $languageId = $request->query->get('language');
        $themeId = $request->query->get('theme');

        $themes = $themesRepository->findAll();
        $languages = $languagesRepository->findAll();
        $categories = $categoryRepository->findAll();
        $authors = $authorRepository->findAll();
        
        $books = $booksRepository->findBooksByFilters($authorId, $categoryId, $themeId, $search);

        return $this->render('usager/index.html.twig', [
            'books' => $books,
            'themes' => $themes,
            'languages' => $languages,
            'categories' => $categories,
            'authors' => $authors
        ]);
    }

    #[Route('/reservation/{id}', name: 'app_usager_reservation')]
    public function reservation(Books $book, EntityManagerInterface $entityManager): Response
    {
        $avis = $entityManager->getRepository(Avis::class)->findBy(['books' => $book]);
        return $this->render('usager/reservation.html.twig', [
            'book' => $book,
            'avis' => $avis
        ]);
    }

    #[Route('/reservation/{id}/store', name: 'reservation_store', methods: ['POST'])]
    public function reservationStore(
        Request $request,
        Books $book,
        StocksRepository $stocksRepository,
        ReservationsRepository $reservationsRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $stockId = $request->request->get('stock_id');
        $stock = $stocksRepository->find($stockId);

        if (!$stock || $stock->getBooks() !== $book) {
            $this->addFlash('danger', 'Stock invalide.');
            return $this->redirectToRoute('app_usager_reservation', ['id' => $book->getId()]);
        }

        $existingReservation = $reservationsRepository->findOneBy([
            'books' => $book,
            'user' => $this->getUser(),
            'status' => 'reserved'
        ]);

        if ($existingReservation) {
            $this->addFlash('danger', 'Vous avez déjà réservé ce livre.');
            return $this->redirectToRoute('app_usager_reservation', ['id' => $book->getId()]);
        }

        $reservation = new Reservations();
        $reservation->setBooks($book);
        $reservation->setUser($this->getUser());
        $reservation->setReference(uniqid('RES_'));
        $reservation->setHandedOver(false);

        if ($stock->getQuantityAvailable() > 0) {
            $reservation->setStatus('reserved');
            $stock->setQuantityReserved($stock->getQuantityReserved() + 1);
            $stock->setQuantityAvailable($stock->getQuantityAvailable() - 1);
        } else {
            $reservation->setStatus('pending');
        }

        $entityManager->persist($reservation);
        $entityManager->flush();

        $this->addFlash('success', 'Votre réservation a été enregistrée.');

        return $this->redirectToRoute('app_usager');
    }



    #[Route('/historique/reservations', name: 'historique_reservations')]
    public function historiqueReservations(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        
        $reservations = $entityManager->getRepository(Reservations::class)->findBy(['user' => $user], ['id' => 'DESC']);
        
        return $this->render('usager/historique.html.twig', [
            'reservations' => $reservations,
        ]);
    }


    #[Route('/reservation/{id}/annuler', name: 'annuler_reservation', methods: ['POST'])]
    public function annulerReservation(Reservations $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($reservation->getUser() !== $this->getUser()) {
            $this->addFlash('danger', 'Cette réservation ne vous appartient pas.');
            return $this->redirectToRoute('app_usager_historique_reservations');
        }

        if ($reservation->getStatus() !== 'pending') {
            $this->addFlash('danger', 'Cette réservation ne peut pas être annulée.');
            return $this->redirectToRoute('app_usager_historique_reservations');
        }

        $reservation->setStatus('cancelled');
        $entityManager->flush();

        $this->addFlash('success', 'Votre réservation a été annulée avec succès.');

        return $this->redirectToRoute('app_usager_historique_reservations');
    }

    #[Route('/book/{book}/avis', name: 'new_avis', methods: ['POST'])]
    public function addAvis(
        Books $book,
        Request $request,
        EntityManagerInterface $entityManager,
        ReservationsRepository $reservationsRepository
    ): Response {

        
    $user = $this->getUser();
    

    // Vérifier si l'utilisateur a réservé ce livre
    $reservation = $reservationsRepository->findOneBy([
        'user' => $user,
        'books' => $book,
        'status' => 'reserved', // On vérifie que c'est bien réservé (pas annulé ou en attente)
    ]);

    if (!$reservation) {
        $this->addFlash('danger', 'Vous devez avoir réservé ce livre pour laisser un avis.');
        return $this->redirectToRoute('app_usager_reservation', ['id' => $book->getId()]);
    }

    // Lire les données du formulaire
    $rating = $request->request->get('rating');
    $comment = $request->request->get('comment');

    if (!$rating && !$comment) {
        $this->addFlash('danger', 'Veuillez laisser au moins une note ou un commentaire.');
        return $this->redirectToRoute('app_usager_reservation', ['id' => $book->getId()]);
    }

    $avis = new Avis();
    $avis->setBooks($book);
    $avis->setUser($user);
    $avis->setRating($rating ? (int)$rating : null);
    $avis->setComment($comment ?: null);

    $entityManager->persist($avis);
    $entityManager->flush();

    $this->addFlash('success', 'Merci pour votre avis !');

    return $this->redirectToRoute('app_usager_reservation', ['id' => $book->getId()]);

    }

}
