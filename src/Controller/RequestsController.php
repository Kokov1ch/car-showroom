<?php

namespace App\Controller;

use App\Entity\RequestStep;
use App\Repository\BuyerRepository;
use App\Repository\ManagerRepository;
use App\Repository\ProductRepository;
use App\Repository\RequestRepository;
use App\Repository\RequestStepRepository;
use App\Repository\RequestTypeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RequestsController extends AbstractController
{
    /**
     * @Route("/requests", name="requests")
     */

    public function index(ManagerRegistry $registry, ProductRepository $productRepository, RequestStepRepository $requestStepRepository,
                          ManagerRepository $managerRepository, RequestRepository $requestRepository,
                          BuyerRepository $buyerRepository, Request $request, RequestTypeRepository $requestTypeRepository): Response
    {
        $names = [];
        $entityManager = $registry->getManager();
        foreach ($requestRepository->getRequestCards($request->get('manager')) as $card){
            if (!in_array($card['buyerFio'], $names))
            $names[]=$card['buyerFio'];
        }
        if ($request->get('test_drive') || $request->get('inspection')){
            $step = new RequestStep();
            $requestProduct= $requestRepository->findOneBy(['product'=>$request->get('product')]);
            $step->setRequestId($requestProduct);
            if ($request->get('test_drive')) $type = $requestTypeRepository->find(2);
            else $type = $requestTypeRepository->find(3);
            //var_dump($type);
            $step->setTypeId($type);
            $step->setDate(date('Y-m-d'));
            if ($requestStepRepository->findOneBy(['type_id'=>$type, 'request_id'=>$requestProduct]) == NULL) {
                $entityManager->persist($step);
                $entityManager->flush();
            }
        }
        else if ($request->get('buy')){
            $step = new RequestStep();
            $requestProduct= $requestRepository->findOneBy(['product'=>$request->get('product')]);
            $step->setRequestId($requestProduct);
            $type=$requestTypeRepository->find(1);
            $step->setTypeId($type);
            $step->setDate(date('Y-m-d'));
            $entityManager->persist($step);
            $entityManager->flush();

            $entityManager->remove($requestRepository->find($requestProduct));
            $entityManager->flush();
        }
//        $fet = ['product', 'buyer', 'type', 'date'];
//        $steps = $requestStepRepository->findAll();
//
//        foreach ($requestRepository->getRequestCards() as $card){
//
//            if ($card['id']==)
//        }
        return $this->render('requests/index.html.twig', [
            'cards' => $requestRepository->getRequestCards($request->get('manager')),
            'managers' => $managerRepository->findAll(),
            'len' => sizeof($names),
            'names' => $names,
            'types' => $requestStepRepository->findAll(),
        ]);
    }
}
