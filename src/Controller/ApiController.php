<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    #[Route('/api/onsaleproducts', name: 'api_on_sale_products')]
    public function onSaleProducts(Request $request, ProductRepository $productRepository, SerializerInterface $serializer, PaginatorInterface $paginator): JsonResponse
    {
        $productsOnSale = $productRepository->findAllWhereIsActive();

        $productsOnSalePage = $paginator->paginate(
            $productsOnSale,
            $request->query->getInt('page', 1),
            20);

        $data = $serializer->serialize($productsOnSalePage, 'json');

        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/api/onsaleproducts/{idUser}', name: 'api_on_sale_products_by_id')]
    public function onSaleProductsById(ProductRepository $productRepository, SerializerInterface $serializer, int $idUser): JsonResponse
    {
        $productsOnSale = $productRepository->findAllWhereIsActiveByIdUser($idUser);

        $data = $serializer->serialize($productsOnSale, 'json');

        return new JsonResponse($data, 200, [], true);
    }
}
