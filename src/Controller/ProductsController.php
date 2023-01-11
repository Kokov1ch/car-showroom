<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Repository\ManagerRepository;
use App\Repository\ManufactorRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */

    public function index(ProductRepository $productRepository, BrandRepository $brandRepository, ManagerRepository $managerRepository): Response
    {
        $brands= $brandRepository->findAll();
        $brandNames = [];
        foreach ($brands as $brand){
            $brandNames[] = $brand->getBrandName();
        }
        //var_dump($products->getProductCards());
        return $this->render('products/index.html.twig', [
            'brands' =>  $brandNames,
            'cards' => $productRepository->getProductCards(),
            'managers' => $managerRepository->findAll(),
        ]);
    }
}
