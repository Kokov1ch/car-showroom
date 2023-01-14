<?php

namespace App\Repository;

use App\Entity\Request;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Request>
 *
 * @method Request|null find($id, $lockMode = null, $lockVersion = null)
 * @method Request|null findOneBy(array $criteria, array $orderBy = null)
 * @method Request[]    findAll()
 * @method Request[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Request::class);
    }

    public function add(Request $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Request $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
//    public function findRequestsByProductId(int $productId): Request{
//        return $this->createQueryBuilder('s')
//            ->where('s.product')
//    }
    public function getBuyerRequestCardsById(int $id): array
    {
        return $this->createQueryBuilder('s')
            ->select('IDENTITY(s.product)', 'b.buyerFio')
            ->join('s.buyer', 'b')
            ->where('s.buyer=:id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getArrayResult();
    }
    public function getRequestCards(): array
    {
        return $this->createQueryBuilder('s')
            ->select('p.id, p.modelName', 'b.buyerFio', 't.price','br.brandName', 't.engineVolume', 't.engineType')
            ->join('s.buyer', 'b')
            ->where('s.buyer=b.id')
            ->join('s.product', 'p')
            ->where('s.product=p.id')
            ->join('p.brand', 'br')
            ->where('p.brand=br.id')
            ->join('p.technicalData','t')
            ->where('p.technicalData=t.id')
//            ->andWhere('s.manager=:id')
//            ->setParameter('id', $id)
            ->orderBy('b.id','DESC')
            ->getQuery()
            ->getArrayResult();
    }
    public function getBestSallers(): array
    {
        return $this->createQueryBuilder('s')
            ->select('p.modelName', 't.price','br.brandName', 't.engineVolume')
            ->join('s.buyer', 'b')
            ->where('s.buyer=b.id')
            ->join('s.product', 'p')
            ->where('s.product=p.id')
            ->join('p.brand', 'br')
            ->where('p.brand=br.id')
            ->join('p.technicalData','t')
            ->where('p.technicalData=t.id')
            ->join('s.')
//           ->addSelect("SELECT model_name, brand_name, price, engine_volume FROM request
//                                JOIN brand ON product.brand_id=brand.id
//                                JOIN technical_data ON product.technical_data_id=technical_data.id
//                                JOIN product ON request.product_id=product.id
//                                JOIN request_step ON request.id=request_step.request_id")
            ->getQuery()
            ->getArrayResult();
    }
    public function getRequestCardsById(int $id): array
    {
        return $this->createQueryBuilder('s')
            ->select('p.modelName', 'b.buyerFio', 't.price','br.brandName')

            ->join('s.product', 'p')
            ->where('s.product=p.id')
            ->join('p.brand', 'br')
            ->where('p.brand=br.id')
            ->join('p.technicalData','t')
            ->where('p.technicalData=t.id')
            ->join('s.buyer', 'b')
            ->andWhere('s.buyer=:id')

            ->setParameter('id', $id)
            ->getQuery()
            ->getArrayResult();
    }
//    /**
//     * @return Request[] Returns an array of Request objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Request
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
