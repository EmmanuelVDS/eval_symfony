<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\AddProductFormType;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{
    #[Route('/user/dashboard', name: 'dashboard_user')]
    public function dashboard(ProductRepository $productRepository, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($this->getUser()->getId());

        $products = $productRepository->findBy(['user' => $user]);

        return $this->render('user/dashboard.html.twig', [
            'user' => $user,
            'products' => $products
        ]);
    }

    #[Route('/user/dashboard/add-product', name: 'add_product')]
    public function addProduct(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): ?Response
    {
        $product = new Product();
        $form = $this->createForm(AddProductFormType::class, $product, [
            'action' => $this->generateUrl('add_product')
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product->setUser($this->getUser());
            $product->setDateAdded(new DateTime());
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('dashboard_user');
        }
        return $this->render('user/addProduct.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/products', name: 'app_product')]
    public function listProducts(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('product/products.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/user/dashboard/isActive/{id}', name: 'is-active')]
    public function toggleIsActive(int $id, ProductRepository $productRepository, EntityManagerInterface $entityManager): RedirectResponse
    {
        $product = $productRepository->find($id);

        if ($product != null) {
            if ($product->getIsActive() == false) {
                $product->setIsActive(true);
            } else {
                $product->setIsActive(false);
            }
            $entityManager->persist($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dashboard_user');
    }
}
