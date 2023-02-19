<?php

namespace App\Repository;

use App\Entity\Reserver;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reserver|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reserver|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reserver[]    findAll()
 * @method Reserver[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReserverRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reserver::class);
    }

//SELECT reserver.id, reservataire, username FROM fos_user__user, reserver WHERE reservataire = 5 AND username = 'Pierre' AND title = 'Pierre'; 
//SELECT fos_user__user.id, reserver.id, reservataire,title, username FROM fos_user__user, reserver WHERE reservataire = 5 AND username = 'Pierre' AND title = 'Pierre'; 
	public function myfindReservataire($reserver)
	{
		return $this->createQueryBuilder('r')
		->select('r.reservataire')
		->where('r.id = :id')
		->setParameter('id',$reserver)
		->getQuery()
		->getSingleResult()

	//	return $this->createQueryBuilder('r')

	//	->select('r.reservataire')
    //    ->where('r.id = :id')
	//	->setParameter('id', $id)
		//	->select('r.id','r.reservataire')
		//	->where('r.id = :reservataire')
		//	->setParameter('reservataire', $id)
	//		->getQuery()
			//->getSql()
	//		->getResult()
	   ;					
//	
	}

//SELECT title, resourceId, start, end, firstname FROM reserver, fos_user__user WHERE `title`= 'nicole' AND `username` = 'nicole'; 

//	public function myfindPilote($title)
//	{
		
	//return $this->createQueryBuilder();
	//		->select('u')
	//		->from(User::class, 'u')
	//		->where('u.firstname LIKE :firstname')
//			->andWhere('u.lastname = :lastname')
	//		->setParameter('firstname', 'First %')
	//		->setParameter('lastname', 'LAST 3');		
				
		


//SELECT title, resourceId, start, end, pilote_id, nom FROM reserver, comptepilote WHERE `title`= 'nicole' AND `nom` = 'nicole'; 


	public function myfindCptePilote($id)
	{
	 return $this->createQueryBuilder('r')
				 ->select('r','c')
				 ->from(reserver::class, 'r')	 

 			    ->leftJoin('r.title', 'c')
			    //->leftJoin('r.resourcesId', 'p')
			    ->where('r.id = :id')
			    ->setParameter('id', $id)
	 
				// ->innerjoin('r.title', 'c')	 
				// ->select('r.id','r.title')
				// ->addSelect('c')
				// ->where('c.nom = : title')
				 //->andWhere('r.title = :nom')
				 //->setParameter('nom',$title)
				 //->orderBy('c.id', 'ASC')
				 ->getQuery()
				 ->getResult()
			;		
		
	}

    // /**
    //  * @return Reserver[] Returns an array of Reserver objects
    //  */
    
    
	public function findByExampleField($auteur)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.reservataire = :id')
            ->setParameter('id', $auteur)
            ->orderBy('r.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Reserver
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
