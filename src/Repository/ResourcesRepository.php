<?php

namespace App\Repository;

use App\Entity\Resources;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Resources|null find($id, $lockMode = null, $lockVersion = null)
 * @method Resources|null findOneBy(array $criteria, array $orderBy = null)
 * @method Resources[]    findAll()
 * @method Resources[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResourcesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resources::class);
    }

    public function myfindAvion($resourceId)
	{
		return $this->createQueryBuilder('r')
		->select('r.type', 'r.title')
		->where('r.id = :resourcesId')
		->setParameter('resourcesId',$resourceId)
		->getQuery()
		//->getSingleResult()
        ->getResult()
		;
	}
	public function myfindResource()
	{
	 return $this->createQueryBuilder('a')
				 ->select('a.id','a.immatriculation','a.marque','a.type')
				 //->where('a.id = :id')
				 //->setParameter('id',$id)
				 ->orderBy('a.id', 'ASC')
				 ->getQuery()
				 ->getResult()
			;
	}
	
//SELECT avions.id,ColorAvion, resources.id FROM avions,resources WHERE ColorAvion = resources.id;

	public function myfindResourceId($avion)
	{
	//	$query = "SELECT avions.id,ColorAvion, resources.id FROM avions,resources WHERE ColorAvion = resources.id";
		
	return $this->createQueryBuilder('r')
			//	->from('resources, r')
				//->select('r.id')
				->where('r.id = :id')
				->leftJoin('r.id','a')
				->andWhere('a.ColorAvion = :id')
				->setParameter('id', $avion)	
			//	->orderBy('r.id', 'ASC')
				->getQuery()
				->getResult()				
			;
	}
	
    // /**
    //  * @return Resources[] Returns an array of Resources objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Resources
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
