<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Repository\ManagerRepository;
use App\Repository\ManufactorRepository;
use App\Repository\ProductRepository;
use App\Repository\RequestRepository;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */

    public function index(ProductRepository $productRepository, BrandRepository $brandRepository,
                          ManagerRepository $managerRepository, RequestRepository $requestRepository, \Symfony\Component\HttpFoundation\Request $request): Response
    {
        $maxPrice = 10000000000;
        $minPrice = 0;
        $maxVolume = 12;
        $minVolume = 0;
        $brands = [];
        $allBrands = [];
        $hideFlag = true;

        foreach ($brandRepository->findAll() as $brand){
            $allBrands[] = $brand->getBrandName();
        }
            if(session_id() === "")
            {
                session_start();
                $manager = $request->get('manager');
                $_SESSION['manager'] = $manager;
                $manager = $_SESSION['manager'];
            }
        if ($_SESSION['manager']==NULL)$manager = NULL;
        else $manager = $_SESSION['manager'];

        if ($request->get('minV')!=NULL) $minVolume = $request->get('minV');

        if ($request->get('maxV')!=NULL) $maxVolume = $request->get('maxV');

        if ($request->get('maxP')!=NULL) $maxPrice = $request->get('maxP');

        if ($request->get('minP')!=NULL) $maxVolume = $request->get('minP');

        if ($request->get('refresh')) return $this->redirectToRoute('index');

        foreach ($brandRepository->findAll() as $brand){
            if ($request->get($brand->getBrandName())!=NULL) $brands[]=$brand->getBrandName();
        }

        if ($request->get('minV')!=NULL || $request->get('maxV')!=NULL || $request->get('maxP')!=NULL ||
            $request->get('minP')!=NULL || $brands!=[]){
            $hideFlag = false;
        }

        if ($brands!=[]) $cards = $productRepository->getProductCardsWithAll($minPrice, $maxPrice, $minVolume, $maxVolume, $brands);
        else $cards = $productRepository->getProductCardsWithAll($minPrice, $maxPrice, $minVolume, $maxVolume, $allBrands);
        return $this->render('products/index.html.twig', [
            'brands' =>  $brandRepository->findAll(),
            'cards' => $cards,
            'managers' => $managerRepository->findAll(),
            'premium' => $productRepository->getPremium(),
            'selBrands' => $brands,
            'flag' => $hideFlag,
            'curManager' => $manager,
        ]);
    }
}
