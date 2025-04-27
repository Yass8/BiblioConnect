<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testLoginPageIsAccessible(): void
    {
       
        $client = static::createClient();

        
        $client->request('GET', '/login');

        
        $this->assertResponseIsSuccessful();

        
        $this->assertSelectorTextContains('h3', 'BiblioConnect');
        $this->assertSelectorExists('form');
    }

    public function testLoginWithValidCredentials(): void
    {
        
        $client = static::createClient();

        
        $crawler = $client->request('GET', '/login');

        
        $form = $crawler->selectButton('Sign in')->form([
            '_username' => 'yas@gmail.com',  
            '_password' => '123456',         
        ]);

        $client->submit($form);

        
        $this->assertResponseRedirects();

        
        $client->followRedirect();

        
        $this->assertSelectorTextContains('body', 'Déconnexion');
    }

    public function testLoginWithInvalidCredentials(): void
    {
        
        $client = static::createClient();

        
        $crawler = $client->request('GET', '/login');

        
        $form = $crawler->selectButton('Sign in')->form([
            '_username' => 'invalid@example.com', 
            '_password' => 'wrongpassword',       
        ]);

        
        $client->submit($form);

        
        $this->assertResponseIsSuccessful();
        
        
        $this->assertSelectorTextContains('div.alert-danger', 'Invalid credentials.');
    }
}
