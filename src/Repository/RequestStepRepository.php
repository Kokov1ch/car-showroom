<?php

namespace App\Repository;

use App\Entity\RequestStep;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RequestStep>
 *
 * @method RequestStep|null find($id, $lockMode = null, $lockVersion = null)
 * @method RequestStep|null findOneBy(array $criteria, array $orderBy = null)
 * @method RequestStep[]    findAll()
 * @method RequestStep[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequestStepRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RequestStep::class);
    }

    public function add(RequestStep $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RequestStep $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function getRequestCards(): array
    {
        return $this->createQueryBuilder('s')
            ->select('s.date', 't.request_name')
            ->join('s.type_id', 't')
            ->where('s.type_id=t.id')
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return RequestStep[] Returns an array of RequestStep objects
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

//    public function findOneBySomeField($value): ?RequestStep
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
