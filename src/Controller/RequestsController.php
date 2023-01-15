<?php

namespace App\Controller;

use App\Entity\Manager;
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
        //$tmp = [];
        $test_drives = [];
        $inspections = [];
        $deals = [];
        $rqs = [];
        $clts = [];
        if(session_id() === "") session_start();
        if ($_SESSION['manager']==NULL) $manager = NULL;
        else $manager = $_SESSION['manager'];
       // $manager = NULL;
//        var_dump($requestRepository->getRequestCards());
        foreach ($requestRepository->findAll() as $rc){
            if ($rc->getManager()->getId() == $manager){
                $rqs[] = $rc->getProduct()->getId();
            }
        }
//        foreach ($rqs as $rq){
//            foreach ($requestRepository->getRequestCards() as $card){
//                if ($requestRepository->)
//            }
//            }
        foreach ($requestStepRepository->findAll() as $requestStep){
            if(!in_array($requestStep->getRequestId()->getId(), $test_drives)){
                if ($requestStep->getTypeId()->getId() ==2) {
                    //$tmp[]=[$requestStep->getRequestId()->getProduct()->getId(),$requestStep->getDate()];
                    $test_drives[] = $requestStep->getRequestId()->getProduct()->getId();
                }
                else if ($requestStep->getTypeId()->getId() ==3) $inspections[] =$requestStep->getRequestId()->getProduct()->getId();
                else if ($requestStep->getTypeId()->getId() ==1) $deals[] = $requestStep->getRequestId()->getProduct()->getId();
            }
        }
        if($requestRepository->findBy(['manager' => (int)$manager])  != NULL) {
            foreach ($requestRepository->findBy(['manager' => (int)$manager]) as $item)
            $clts[] = $item->getBuyer()->getBuyerFio();
        }
//        foreach ($tmp as $fet){
//            foreach (fet)
//            var_dump($tmp);
//        }
        //var_dump($clts);
        //var_dump($tmp);
        //var_dump($rqs);
        $dt = date('Y-m-d');
        $entityManager = $registry->getManager();
        foreach ($requestRepository->getRequestCards() as $card){
            if (!in_array($card['buyerFio'], $names))
            $names[]=$card['buyerFio'];
        }
//        $tmp =[];
//        foreach ($requestStepRepository->getAllDistinct() as $reqSpet){
//             //var_dump($reqSpet->getRequestId()->getId());
//            foreach ($requestRepository->getRequestCards() as $card){
//                if ($card['id'] == $reqSpet->getRequestId()->getId())  $tmp[]=$card['id'];
//            }
//        }
//        var_dump($tmp);
        if ($request->get('test_drive') || $request->get('inspection')){
//            var_dump($request->get('test_drive'));
//            var_dump($request->get('product'));
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
                return $this->redirectToRoute('requests');
            }
        }
        else if ($request->get('buy')){
            $flag = true;
            $step = new RequestStep();
            $requestProduct= $requestRepository->findOneBy(['product'=>$request->get('product')]);
            $step->setRequestId($requestProduct);
            $type=$requestTypeRepository->find(1);
            $step->setTypeId($type);
            $step->setDate(date('Y-m-d'));
//            var_dump($step->getRequestId()->getId());
            if ($requestStepRepository->findOneBy(['type_id'=>$type, 'request_id'=>$requestProduct]) == NULL) {
                $entityManager->persist($step);
                $entityManager->flush();
                return $this->redirectToRoute('requests');
            }
//            $curRequest = $requestRepository->find($requestProduct);
//            $curRequest->setManager(null);
//            $curRequest->setBuyer(null);
//            $curProduct = $curRequest->getProduct()->getModelName();
//            $curRequest->setProduct(null);
//            var_dump($curProduct);
//            $entityManager->remove($curRequest);
//            $entityManager->flush();
        }
//        $fet = ['product', 'buyer', 'type', 'date'];
//        $steps = $requestStepRepository->findAll();
//
//        foreach ($requestRepository->getRequestCards() as $card){
//
//            if ($card['id']==)
//        }
        //var_dump($deals);
//        $managerCopy = $managerRepository->find((int)$manager);
//        $mg = new Manager();
//        $mg->setBaseRate($managerCopy->getBaseRate());
//        $mg->setManagerFio($managerCopy->getManagerFio());
//        $mg->setId($managerCopy->getId());

        $cards = $requestRepository->getRequestCards();
//        var_dump($cards);
//        var_dump((int)$manager);
        return $this->render('requests/index.html.twig', [
            'cards' => $cards,
            'managers' => $managerRepository->findAll(),
            'len' => sizeof($names),
            'names' => $names,
            'types' => $requestStepRepository->findAll(),
            'curManager' => $manager,
            'test_drives' =>$test_drives,
            'inspections' => $inspections,
            'deals' => $deals,
            'dt' => $dt,
            'curManagerId' => (int)$manager,
            'rqs' => $rqs,
            'bs' => $clts,
        ]);
    }
}
