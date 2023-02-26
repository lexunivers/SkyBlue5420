<?php

namespace App\Repository;

use App\Entity\CpteIndividuel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CpteIndividuel>
 *
 * @method CpteIndividuel|null find($id, $lockMode = null, $lockVersion = null)
 * @method CpteIndividuel|null findOneBy(array $criteria, array $orderBy = null)
 * @method CpteIndividuel[]    findAll()
 * @method CpteIndividuel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CpteIndividuelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CpteIndividuel::class);
    }

    public function save(CpteIndividuel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CpteIndividuel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CpteIndividuel[] Returns an array of CpteIndividuel objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CpteIndividuel
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
