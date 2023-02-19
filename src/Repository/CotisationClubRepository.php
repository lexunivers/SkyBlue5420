<?php

namespace App\Repository;

use App\Entity\CotisationClub;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CotisationClub|null find($id, $lockMode = null, $lockVersion = null)
 * @method CotisationClub|null findOneBy(array $criteria, array $orderBy = null)
 * @method CotisationClub[]    findAll()
 * @method CotisationClub[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CotisationClubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CotisationClub::class);
    }



	public function myfindAnnee()
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



     /**
     * @return CotisationClub[] Returns an array of CotisationClub objects
     *
     */
    public function findByStatut($macotisation)
    {
		
        return $this->createQueryBuilder('C')
            ->andWhere('C.statut = :statut')
            ->andWhere('C.Montantclub = :Montantclub')
			//->andWhere('C.id = : val')
			->from('App\Entity\MaCotisation','M')
			->andWhere('M.statut = : statut')	
            ->setParameter('C.id', $macotisation)
            //->orderBy('c.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function myfind($annee): ?CotisationClub
    {
        return $this->createQueryBuilder('c')
			->select('c.id','c.validation', 'c.statut', 'c.annee')
			//->set('c.validation', true)
			->Where('c.validation = 1 ')
			->setParameter('annee', $annee)

			//->GROUPBY('c.annee')
			//array(
			//	':validation' => $annee,
				//':client'  => $client,
				//':annonce' => $annonce
			//))
            ->getQuery()
			//->getOneOrNullResult()
            ->getResult()
			//->getArrayResult()
        ;
    }    
	
	
    public function findOneBySomeField($value): ?CotisationClub
    {
        return $this->createQueryBuilder('c')
			->select('c.id, c.annee')
            ->andWhere('c.validation = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }
    
}
