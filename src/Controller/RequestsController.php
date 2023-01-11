<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\RequestStepRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RequestsController extends AbstractController
{
    /**
     * @Route("/requests", name="requests")
     */

    public function index(ProductRepository $productRepository, RequestStepRepository $requestStepRepository): Response
    {
        //var_dump($productRepository->getProductInfoById(5));
        //var_dump($requestStepRepository->getRequestCards());
        return $this->render('requests/index.html.twig', [
            'product' => $productRepository->getProductInfoById(5),
            'cards' => $requestStepRepository->getRequestCards(),
        ]);
    }
}
