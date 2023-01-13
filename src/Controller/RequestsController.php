<?php

namespace App\Controller;

use App\Repository\BuyerRepository;
use App\Repository\ManagerRepository;
use App\Repository\ProductRepository;
use App\Repository\RequestRepository;
use App\Repository\RequestStepRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RequestsController extends AbstractController
{
    /**
     * @Route("/requests", name="requests")
     */

    public function index(ProductRepository $productRepository, RequestStepRepository $requestStepRepository,
                          ManagerRepository $managerRepository, RequestRepository $requestRepository,
                          BuyerRepository $buyerRepository): Response
    {
        //var_dump($productRepository->getProductInfoById(5));
        //var_dump($requestStepRepository->getRequestCards());
//        $allBuyers = $buyerRepository->findAll();
//        $buyersIds =[];
//        var_dump($requestRepository->pizda());
//        foreach ($allBuyers as $buyer){
//            $buyersIds[] = $buyer->getId();
//        }
//        //var_dump($buyersIds);
//        $productsBuyerIds = array([]);
//        $buyerNames = [];
//        //var_dump($requestRepository->getBuyerRequestCardsById(1));
//        $count = 0;
//        foreach ($buyersIds as $buyerId) {
//            //var_dump($buyerId);
//            $buyerName = $requestRepository->getBuyerRequestCardsById($buyerId)[0]['buyerFio'];
//            $buyerNames[] =$buyerName;
//            //var_dump($requestRepository->getBuyerRequestCardsById(1));
//            foreach ($requestRepository->getBuyerRequestCardsById($buyerId) as $request) {
//                //var_dump($request);
//                $productsBuyerIds[$buyerId][$count]= intval($request['1']);
//                $count++;
//            }
//        }
        //var_dump($productsBuyerIds);
        //$productsId
        //var_dump($productsId);
        //$requestRepository->getRequestCards($productRepository->getProductCards(1));
//        $cards = $requestRepository->getRequestCards();
//        $len = sizeof($cards);
//        for ($i = 0; $i < $len; $i++) {
//            $target = $cards[$i]['buyerFio'];
//            $count = 0;
//            var_dump($target);
//            foreach ($cards as $card) {
//                if ($card['buyerFio'] == $target && $count < 1 ) $count++;
//                else unset($cards[$i]);
//            }
//        }
//        var_dump(sizeof($cards));
        $names = [];
        foreach ($requestRepository->getRequestCards() as $card){
            if (!in_array($card['buyerFio'], $names))
            $names[]=$card['buyerFio'];
        }
      $len = sizeof($requestRepository->getRequestCards());
        return $this->render('requests/index.html.twig', [
            //'product' => $productRepository->getProductInfoById(5),
            'cards' => $requestRepository->getRequestCards(),
            'managers' => $managerRepository->findAll(),
            'len' => sizeof($names),
            'names' => $names,
//            'requests' => $productsBuyerIds,
//            'buyers' => $buyerNames,
        ]);
    }
}
