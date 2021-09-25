<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/user/dashboard', name: 'dashboard_user')]
    public function dashboard(ProductRepository $productRepository, UserRepository $userRepository): Response

    {
        $user = $userRepository->find($this->getUser()->getId());


        return $this->render('user/dashboard.html.twig', [
            'user' => $user,
        ]);
    }
}
