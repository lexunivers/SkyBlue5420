<?php

namespace App\Repository;

use App\Entity\MaCotisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MaCotisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaCotisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaCotisation[]    findAll()
 * @method MaCotisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaCotisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaCotisation::class);
    }

    // /**
    //  * @return MaCotisation[] Returns an array of MaCotisation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


	public function myfindAnnuelle()
	{
        return $this->createQueryBuilder('c')
			->select('c.annee')		
			//->set('c.validation', true)
			//->from(CotisationClub::class, 'c')
			->where('c.validation = 1')
			//->andWhere('c.id = :id')
			//->setParameter('id', $annee)
			//->setParameter('id', $id->getAnnee() )
			->getQuery()
			->getResult()
			;
	}
    
    public function findOneBySomeField($user): ?MaCotisation
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.user = :val')
            ->setParameter('val', $user)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
