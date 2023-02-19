<?php

namespace App\Repository;

use App\Entity\Avions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Avions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Avions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Avions[]    findAll()
 * @method Avions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avions::class);
    }

    public function myfindAvion($avion)
	{
		return $this->createQueryBuilder('a')
		->select('a.id','a.type', 'a.immatriculation')
		->where('a.id = :ResourcesId')
		->setParameter('ResourcesId',$avion)
		->getQuery()
		//->getSingleResult()
        ->getResult()
		;
	}


	public function myfindCalendar()
	{
	 return $this->createQueryBuilder('a')
				 ->select('a.id','a.immatriculation','a.marque','a.type')
				 //->where('a.coloravion','r')
				 //->andWhere('r.id = : id')
				 //->setParameter('id',$avion)
				 //->orderBy('a.id', 'ASC')
				 ->getQuery()
				 ->getResult()
			;
	}

//SELECT immatriculation, marque, type , coloravion FROM `avions` where id = 3; 
	public function myfindColorAvion()
	{
	 return $this->createQueryBuilder('a')
				 ->select('a.id','a.immatriculation','a.marque','a.type')
				 
				 //->where('a.id = :id')
				 //->andWhere('r.id = : id')
				 //->setParameter('id',$avion)
				 //->orderBy('a.id', 'ASC')
				 ->getQuery()
				 ->getResult()
			;
	}


 /**
  * Find a meeting with all decisions.
  *
  * @param string $type
  * @param int $number
  *
  * @return MeetingModel
  */
// public function find($type, $number)
// {
	//qb = $this->em->createQueryBuilder();
//     return $this->createQueryBuilder()
//				 ->select('m, d, db')
//				 ->from('Decision\\Model\\Meeting', 'm')
//				 ->where('m.type = :type')
//				 ->andWhere('m.number = :number')
//				 ->leftJoin('m.decisions', 'd')
//				 ->leftJoin('d.destroyedby', 'db')
//				 ->orderBy('d.point')
//				 ->addOrderBy('d.number');
//				 ->setParameter(':type', $type);
//				 ->setParameter(':number', $number);
//				->getQuery()
//				->getSingleResult();
// }



	public function myfindResourceId($coloravion)	
	{
	//	$query = "SELECT avions.id,ColorAvion, resources.id FROM avions,resources WHERE ColorAvion = resources.id";
		
	return $this->createQueryBuilder('a')
			//	->from('resources, r')
				->select('a.ColorAvion')
				//->where('a.id = :id')
				//->leftJoin('a.ColorAvion','r')
				->where('a.ColorAvion','r')
				//->andWhere('r.id = :id')
				
				->setParameter('id', $coloravion)	
				//->orderBy('r.id', 'ASC')
				->getQuery()
				->getResult()				
			;
	}	

	public function myfindHeuresmoteur($avion){
	 return $this->createQueryBuilder('a')
				 ->select('a.heuresdevol', 'a.id')
				 ->where('a.id = :id')
				 ->setParameter('id',$avion)
				 //->orderBy('a.id', 'ASC')
				 ->getQuery()
				 ->getSingleResult()
			;
	}

	public function myfindtempsmoteur($avion){
	 return $this->createQueryBuilder('a')
				 ->select('a.heuresdevol')
				 ->where('a.id = :id')
				 ->setParameter('id',$avion)
				 ->getQuery()
				 ->getSingleResult()
			;
	}


    // /**
    //  * @return Avions[] Returns an array of Avions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findOneBySomeField($avion): ?Avions
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.heuresdevol = :id')
            ->setParameter('id', $avion)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
