<?php

namespace App\Controller;

use App\Entity\Buyer;
use App\Repository\BuyerRepository;
use App\Repository\ManagerRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DealController extends AbstractController
{
    /**
     * @Route("/deal", name="deal")
     */
    public function index(BuyerRepository $buyerRepository, Request $request, ManagerRepository $managerRepository, ProductRepository $productRepository, ManagerRegistry $registry): Response
    {
//        var_dump($request->get('product'));
        $entityManager = $registry->getManager();
//        $curBuyer = $request->get('buyer');
//        if($request->get('send')==NULL) {
            $fio = NULL;
            //$managerId = NULL;
            //$productId = NULL;
            $series = NULL;
            $number = NULL;
//        }
//        else{
            $fio = $request->get('fio');
            $series = $request->get('series');
            $number = $request->get('number');
            $productId = $request->get('product');
            $curBuyer =$request->get('buyer');

        if(session_id() === "") session_start();
        if ($_SESSION['manager']==NULL) $managerId = NULL;
        else $managerId = $_SESSION['manager'];
           // var_dump($productId);
//        }
//        if ($request->get('fio')!=NULL)
//            $fio = $request->get('fio');
//
//        if ($request->get('series')!=NULL)
//            $series = $request->get('series');
//
//        if($request->get('number')!=NULL)
//            $number = $request->get('number');
//
//        if ($request->get('manager')!=NULL)
//            $managerId = $request->get('manager');
//
//        if($request->get('product')!=NULL)
//            $productId = $request->get('product');

         //var_dump($managerId);
        //if ($request->get('choose') == NULL) {
            if ($request->get('send')) {
                if (($fio != NULL) && ($series != NULL) && ($number != NULL)) {
                    $buyer = new Buyer();
                    $buyer->setBuyerFio($fio);
                    $buyer->setBuyerPassportSeries($series);
                    $buyer->setBuyerPassportNumber($number);
                    $entityManager->persist($buyer);
                    $entityManager->flush();

                    $requestProduct = new \App\Entity\Request();
                    $product = $productRepository->find($productId);
                    $manager = $managerRepository->find($managerId);
                    $requestProduct->setProduct($product);
                    $requestProduct->setBuyer($buyer);
                    $requestProduct->setManager($manager);
                    $entityManager->persist($requestProduct);

                    $entityManager->flush();
                    return $this->redirectToRoute('requests');
                } else {
                    //var_dump($curBuyer);
                    $buyer = $buyerRepository->find($curBuyer);
                    $requestProduct = new \App\Entity\Request();
                    $product = $productRepository->find($productId);
                    $manager = $managerRepository->find($managerId);
//                    var_dump($product->getId());
//                    var_dump($manager->getManagerFio());
                    $requestProduct->setBuyer($buyer);
                    $requestProduct->setProduct($product);
                    $requestProduct->setManager($manager);
//                    var_dump($requestProduct->getProduct()->getId());
//                    var_dump($requestProduct->getManager()->getId());
//                    var_dump($requestProduct->getBuyer()->getId());
                    $entityManager->persist($requestProduct);
                    $entityManager->flush();
                    return $this->redirectToRoute('requests');
                }
            }
//            }
       // }
//        else
//        {
//            var_dump($productId);
//            $buyer = $buyerRepository->find($curBuyer);
//            $requestProduct = new \App\Entity\Request();
//            $product = $productRepository->find($productId);
//            $manager = $managerRepository->find($managerId);
//            $requestProduct->setBuyer($buyer);
//            $requestProduct->setProduct($product);
//            $requestProduct->setManager($manager);
//            $entityManager->persist($requestProduct);
//            $entityManager->flush();
//            return $this->redirectToRoute('requests');
//        }
        return $this->render('deal/index.html.twig', [
            'buyers' => $buyerRepository->findAll(),
            //'curBuyer' => $curBuyer,
            'product' => $productId,
            'manager' => $managerId,
        ]);
    }
}
