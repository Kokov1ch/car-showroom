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
        $test_drives = [];
        $inspections = [];
        $deals = [];
        $rqs = [];
        $clts = [];
        if(session_id() === "") session_start();
        if ($_SESSION['manager']==NULL) $manager = NULL;
        else $manager = $_SESSION['manager'];

        foreach ($requestRepository->findAll() as $rc){
            if ($rc->getManager()->getId() == $manager){
                $rqs[] = $rc->getProduct()->getId();
            }
        }

        foreach ($requestStepRepository->findAll() as $requestStep){
            if(!in_array($requestStep->getRequestId()->getId(), $test_drives)){
                if ($requestStep->getTypeId()->getId() ==2) {
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

        $dt = date('Y-m-d');
        $entityManager = $registry->getManager();
        foreach ($requestRepository->getRequestCards() as $card){
            if (!in_array($card['buyerFio'], $names))
            $names[]=$card['buyerFio'];
        }

        if ($request->get('test_drive') || $request->get('inspection')){

            $step = new RequestStep();
            $requestProduct= $requestRepository->findOneBy(['product'=>$request->get('product')]);
            $step->setRequestId($requestProduct);
            if ($request->get('test_drive')) $type = $requestTypeRepository->find(2);
            else $type = $requestTypeRepository->find(3);
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
            if ($requestStepRepository->findOneBy(['type_id'=>$type, 'request_id'=>$requestProduct]) == NULL) {
                $entityManager->persist($step);
                $entityManager->flush();
                return $this->redirectToRoute('requests');
            }

        }

        $cards = $requestRepository->getRequestCards();

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
