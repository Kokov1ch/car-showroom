<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function getProductCards(): array
    {
       return $this->createQueryBuilder('s')
           ->select('b.brandName', 's.modelName', 't.engineVolume', 't.price')
           ->join('s.technicalData', 't')
           ->where('s.technicalData=t.id')
           ->join('s.brand', 'b')
           ->where('s.brand=b.id')
           ->join('s.manufactor', 'm')
           ->where('s.manufactor=m.id')
           ->getQuery()
           ->getResult();
    }
    public function getProductInfoById(int $id): array
    {
        return $this->createQueryBuilder('s')
            ->select('b.brandName', 's.modelName', 't.engineVolume', 't.price', 't.numberOfDoors', 't.numberOfSeats', 't.engineType', 't.engineLocation', 'm.manufactorCountry')
            ->join('s.technicalData', 't')
            ->where('s.technicalData=t.id')
            ->join('s.brand', 'b')
            ->where('s.brand=b.id')
            ->join('s.manufactor', 'm')
            ->where('s.manufactor=m.id')
            ->andWhere('s.id=:id')

            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
