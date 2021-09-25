<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeAction extends AbstractController
{
    #[Route('/welcome', name: 'welcome')]
    public function dashboard(ProductRepository $productRepository, UserRepository $userRepository): Response

    {
        return $this->render('user/welcome.html.twig');
    }
}