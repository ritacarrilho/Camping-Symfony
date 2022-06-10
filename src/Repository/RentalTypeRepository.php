<?php

namespace App\Repository;

use App\Entity\RentalType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RentalType>
 *
 * @method RentalType|null find($id, $lockMode = null, $lockVersion = null)
 * @method RentalType|null findOneBy(array $criteria, array $orderBy = null)
 * @method RentalType[]    findAll()
 * @method RentalType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentalTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RentalType::class);
    }

    public function add(RentalType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RentalType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function orderLabel() {
        return $this->createQueryBuilder('r')
                    ->orderBy('r.label', 'ASC');
    }

    public function orderCapacity() {
        return $this->createQueryBuilder('r')
                    ->orderBy('r.capacity', 'ASC');
    }

    public function findAllInfo() 
    {
        return $this->createQueryBuilder('t')
                    ->join('t.id', 'r')
                    ->addSelect('r')
                    ->getQuery()->getResult();
    }

    public function findCategories()
    {
        return $this->select('t.label')
        ->from('t')->getQuery()->getResult();
    }

//    /**
//     * @return RentalType[] Returns an array of RentalType objects
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

//    public function findOneBySomeField($value): ?RentalType
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
