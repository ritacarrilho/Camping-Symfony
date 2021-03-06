<?php

namespace App\Repository;

use App\Entity\Rentals;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rentals>
 *
 * @method Rentals|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rentals|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rentals[]    findAll()
 * @method Rentals[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentalsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rentals::class);
    }

    public function add(Rentals $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Rentals $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllInfo() 
    {
        return $this->createQueryBuilder('r')
                    ->join('r.typeId', 't')
                    ->addSelect('t')
                    ->join('r.ownerId', 'o')
                    ->addSelect('o')
                    ->orderBy('r.description', 'desc')
                    ->getQuery()->getResult();
    }

    public function findOwner()
    {
        return $this->createQueryBuilder('r')
                    ->join('r.ownerId', 'o')
                    ->addSelect('o')
                    ->getQuery()->getResult();
    }

    private function base() 
    {
        return $this->createQueryBuilder('r')
                    ->join('r.typeId', 'rt')
                    ->addSelect('rt');
    }

    public function findByType($type, $capacity): array
    {

        return $this->createQueryBuilder('r') 
        ->join('r.typeId', 'rt')
        ->addSelect('rt')
        ->where('rt.label = :type')
        ->setParameter('type', $type)
        // ->andWhere('rt.capacity = :capacity')
        // ->setParameters(['type'=> $type,'capacity'=> $capacity])
        ->getQuery()
        ->getResult();
    }


    // public function findByType($label)
    // {
    //     $db = $this->findAllInfo();

    //     dump($db);
    //     return $db->where('t.label < :label') 
    //             ->setParameter('label', $label)
    //             ->getQuery()
    //             ->getResult();
    // }

//    /**
//     * @return Rentals[] Returns an array of Rentals objects
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

//    public function findOneBySomeField($value): ?Rentals
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
