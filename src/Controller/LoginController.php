<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser(); 
        
        if ($user) {
            $this->redirectUser();
        } 
        
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('login/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
        
        
        
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    public function redirectUser(){
        $user = $this->getUser();
        
        $roles = $user?->getRoles(); 
        $mainRole = $roles[0] ?? null;

        if ($mainRole === 'ROLE_ADMIN') {
            dd('ROLE_ADMIN');
            // return $this->redirectToRoute('admin_dashboard');
        }
        if ($mainRole === 'ROLE_LIBRARIAN') {
            dd('ROLE_LIBRARIAN');
            // return $this->redirectToRoute('admin_dashboard');
        }

        dd('ROLE_USER');
        
    }
}
