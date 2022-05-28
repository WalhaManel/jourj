<?php

namespace App\Repository;

use App\Entity\SalleEvenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SalleEvenement>
 *
 * @method SalleEvenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalleEvenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalleEvenement[]    findAll()
 * @method SalleEvenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalleEvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalleEvenement::class);
    }

    public function add(SalleEvenement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SalleEvenement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SalleEvenement[] Returns an array of SalleEvenement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SalleEvenement
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


public function getSalleByPrice($id,int $minp, int $maxp){
    return $this->_em->createQuery("SELECT s FROM App\Entity\SalleEvenement s WHERE s.event = $id and s.prix >= $minp and s.prix <= $maxp ")
                         ->getResult();
}

public function getSalleByPriceAloc($id,int $minp,int $maxp,$loc){
    return $this->_em->createQuery("SELECT s FROM App\Entity\SalleEvenement s WHERE s.event = $id and s.prix >= $minp and s.prix <= $maxp and s.location = '". $loc ."' ")->getResult();
}
}
