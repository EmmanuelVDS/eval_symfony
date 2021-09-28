<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeActionController extends AbstractController
{
    #[Route('/security/welcome', name: 'app_welcome')]
    public function dashboard(): Response

    {
        return $this->render('user/welcome.html.twig');
    }
}