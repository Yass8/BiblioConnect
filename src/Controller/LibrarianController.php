<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_LIBRARIAN', message: "Vous n'êtes pas autorisé à accéder à cette action.")]
#[Route('/librarian')]
final class LibrarianController extends AbstractController
{
    #[Route('/', name: 'app_librarian')]
    public function index(): Response
    {
        return $this->render('base_librarian.html.twig', [
            'controller_name' => 'LibrarianController',
        ]);
    }
}
