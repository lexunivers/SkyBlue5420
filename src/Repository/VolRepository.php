<?php

namespace App\Repository;

use App\Entity\Vol;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Vol|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vol|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vol[]    findAll()
 * @method Vol[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vol::class);
    }





//SELECT `datevol`, `heureDepart`, `heureArrivee`, `validation`, `start`, `end` FROM `vol`, `reserver` WHERE `validation` = 1 GROUP BY `datevol`
    /**
     * @return Avion[] Returns an array of Avion objects
    */
    public function findByExampleField()
    {
        return $this->createQueryBuilder('v')
            ->select('v.datevol, v.id, v.heureDepart, v.heureArrivee, r.start, r.end')
            ->innerJoin( 'App\Entity\Reserver', 'r' )
            ->andWhere( 'r.start = v.heureDepart' )            
            ->andWhere('r.end = v.heureArrivee')
			->between('v.heureDepart', 'start', 'end')
            //->setParameter('lettreId', 'resourceId')
            ->groupBy('v.datevol')
            ->orderBy('v.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
//		SELECT *
//		FROM utilisateur
//		WHERE date_inscription BETWEEN ‘2012-04-01’ AND ‘2012-04-20’
// SELECT v.datevol, v.heureDepart, v.heureArrivee, r.start, r.end FROM vol v, reserver r WHERE v.heureDepart BETWEEN r.start AND r.end 

    public function findByExampleBetween()
    {
        return $this->createQueryBuilder('v')
            ->select('v.datevol, v.id, v.heureDepart, v.heureArrivee, r.title, r.start, r.end')
            ->innerJoin( 'App\Entity\Reserver', 'r' )		
			->andWhere(['v.heureDepart', 'BETWEEN', 'r.start','r.end'] )
			//->BetweenColumnsCondition('v.heureDepart', 'BETWEEN', 'r.start', 'r.end')
			//->andWhere('between', 'id', 1, 10 )
			//->setParameter('r.start', start->format('Y-m-d'))
			//->setParameter('r.end', end->format('Y-m-d'))			
            ->orderBy('v.datevol', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
	}	


    // /**
    //  * @return Vol[] Returns an array of Vol objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

	//SELECT `datevol`, `heureDepart`, `heureArrivee`, `validation`, `start`, `end` FROM `vol`, `reserver` WHERE `validation` = 1 GROUP BY `datevol`

    public function findByValidation(): ?Vol
	{
        return $this->createQueryBuilder('v')            
			->select('v.datevol, v.heureDepart, v.heureArrivee, v.validation')
            ->innerJoin( 'App\Entity\Reserver', 'r' )
            ->andWhere( 'r.start = v.heureDepart' )            
            ->andWhere('r.end = v.heureArrivee')
			->andwhere('v.validation = 1')
            //->setParameter('lettreId', 'resourceId')
            ->groupBy('v.datevol')
            //->orderBy('v.datevol', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
		;
	}

    /*
    public function findOneBySomeField($value): ?Vol
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
