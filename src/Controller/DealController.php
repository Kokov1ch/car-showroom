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
        $entityManager = $registry->getManager();
            $fio = NULL;
            $series = NULL;
            $number = NULL;
            $fio = $request->get('fio');
            $series = $request->get('series');
            $number = $request->get('number');
            $productId = $request->get('product');
            $curBuyer =$request->get('buyer');

        if(session_id() === "") session_start();
        if ($_SESSION['manager']==NULL) $managerId = NULL;
        else $managerId = $_SESSION['manager'];

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
                    $buyer = $buyerRepository->find($curBuyer);
                    $requestProduct = new \App\Entity\Request();
                    $product = $productRepository->find($productId);
                    $manager = $managerRepository->find($managerId);

                    $requestProduct->setBuyer($buyer);
                    $requestProduct->setProduct($product);
                    $requestProduct->setManager($manager);

                    $entityManager->persist($requestProduct);
                    $entityManager->flush();
                    return $this->redirectToRoute('requests');
                }
            }

        return $this->render('deal/index.html.twig', [
            'buyers' => $buyerRepository->findAll(),
            'product' => $productId,
            'manager' => $managerId,
        ]);
    }
}
