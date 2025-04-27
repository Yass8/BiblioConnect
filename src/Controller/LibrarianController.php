<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\BooksRepository;
use App\Repository\ReservationsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_LIBRARIAN', message: "Vous n'êtes pas autorisé à accéder à cette action.")]
#[Route('/librarian')]
final class LibrarianController extends AbstractController
{
    #[Route('/', name: 'app_librarian')]
    public function index(UserRepository $userRepository,
    BooksRepository $booksRepository,
    ReservationsRepository $reservationsRepository
): Response
{


    $reservations = $reservationsRepository->findAll();
    $books = $booksRepository->findAll();
    $users = $userRepository->findAll();
        return $this->render('base_librarian.html.twig', [
            'reservations' => $reservations,
            'users'=> $users,
        ]);
    }
}
