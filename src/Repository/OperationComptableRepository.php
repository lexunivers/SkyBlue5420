<?php

namespace App\Repository;

use App\Entity\OperationComptable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OperationComptable|null find($id, $lockMode = null, $lockVersion = null)
 * @method OperationComptable|null findOneBy(array $criteria, array $orderBy = null)
 * @method OperationComptable[]    findAll()
 * @method OperationComptable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationComptableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationComptable::class);
    }

    //SELECT hictr, hitype, SUM(hiqte)
    //FROM Operationcomptable
    //WHERE hicam='C000'
    //GROUP BY hictr, hitype
    //ORDER BY hictr ASC;
    // SELECT o.compte_id AS compte_id, o.oper_sens_mt AS oper_sens_mt, SUM(o.oper_montant) AS sclr_2 FROM operationcomptable o WHERE o.compte_id = 9 GROUP BY o.oper_sens_mt
    //SELECT `compte_id`,oper_sens_mt,SUM(oper_montant) FROM operationcomptable WHERE `compte_id`=9 GROUP BY oper_sens_mt


   // public function myFindmontantTotal($user)
    //{
   //     select('SUM(O.OperMontant) ') Where('O.OperSensMt = 0 ') AND ('O.CompteId = :CompteId')
 
        //('O.CompteId,O.OperSensMt,SUM(O.OperMontant') WHERE 'O.CompteId = :CompteId' AND 'oper_sens_mt' = 0) 
    //    ->getQuery()
   //     ->getResult()
    //;
    //}

    public function myFindCpta($vol)
    {
        return $this->createQueryBuilder('o')
                 ->select('o.VolId')
                 ->leftJoin('o.VolId', 'v')
                 ->addselect('v.id')
                 ->andWhere('v.id = :VolId')
                 ->setParameter('VolId', $vol)
                 ->getQuery()
                 ->getOneOrNullResult();
    }


    public function myFindSommeTotale($user)
    {
        return $this->createQueryBuilder('O')
            ->select('O.CompteId,O.OperSensMt,SUM(O.OperMontant)')
            ->Where('O.CompteId = :CompteId')
            ->setParameter('CompteId', $user)
            ->GROUPBY('O.OperSensMt')
            ->getQuery()
            ->getResult()
        ;
    }

    public function myFindTotale($CompteId)
    {
        return $this->createQueryBuilder('O')
            ->select('O.CompteId,O.OperSensMt,SUM(O.OperMontant)')
            ->Where('O.CompteId = :CompteId')
            ->setParameter('CompteId', $CompteId)
            ->GROUPBY('O.OperSensMt')
            ->getQuery()
            ->getResult()
        ;
    }


    public function myFindTotaleSomme($user)
    {
        return $this->createQueryBuilder('O')
            ->select('O.CompteId,O.OperSensMt,SUM(O.OperMontant)')
            ->Where('O.OperSensMt = 0 ')
            ->andWhere('O.OperSensMt = 1 ')
            ->andWhere('O.CompteId = :CompteId')
            ->setParameter('CompteId', $user)
            
            ->GROUPBY('O.OperSensMt')
            ->getQuery()
            ->getResult()
        ;
    }

    public function myFindTotaleSom($CompteId)
    {
        return $this->createQueryBuilder('O')
            ->select('O.CompteId,O.OperSensMt,SUM(O.OperMontant)')
            ->Where('O.OperSensMt = 0 ')
            ->andWhere('O.OperSensMt = 1 ')
            ->andWhere('O.CompteId = :CompteId')
            ->setParameter('CompteId', $CompteId)
            
            ->GROUPBY('O.OperSensMt')
            ->getQuery()
            ->getResult()
        ;
    }

    public function myFindVolDQL($vol)
    {
        $query = $this->_em->createQuery('SELECT O.id, O.VolId, O.CompteId, O.OperMontant, v FROM App\Entity\OperationComptable O, App\Entity\Vol v WHERE O.VolId = v.id AND O.CompteId = v.user ');
        $results = $query->getResult();

        return $results;
    }


    public function myFindVolId($vol)
    {
        return $this->createQueryBuilder('O')
            ->select('O.OperMontant, O.VolId, O.CompteId')
             
            ->from('App\Entity\Vol', 'V')
            ->addSelect('V.facture')
            ->addSelect('V.id')
      
            ->Where('O.OperMontant=V.facture ')
            ->andWhere('O.VolId = :V.id')
            ->andWhere('O.CompteId = :V.id')
            ->setParameter('V.id', $vol)
            ->getQuery()
            ->getResult()
        
;
    }

    public function myFindDebit($user)
    {
        return $this->createQueryBuilder('O')
            ->select('SUM(O.OperMontant) ')
            ->Where('O.OperSensMt = 0 ')
            ->andWhere('O.CompteId = :CompteId')
            ->setParameter('CompteId', $user)
            ->getQuery()
            ->getResult()
        ;
    }

    public function myFindDeb($CompteId)
    {
        return $this->createQueryBuilder('O')
            ->select('SUM(O.OperMontant) ')
            ->Where('O.OperSensMt = 0 ')
            ->andWhere('O.CompteId = :CompteId')
            ->setParameter('CompteId', $CompteId)
            ->getQuery()
            ->getResult()
        ;
    }

    public function myFindCredit($user)
    {
        return $this->createQueryBuilder('O')
            ->select('SUM(O.OperMontant) ')
            ->Where('O.OperSensMt = 1 ')
            ->andWhere('O.CompteId = :CompteId')
            ->setParameter('CompteId', $user)
            ->getQuery()
            ->getResult()
        ;
    }

    public function myFindCred($CompteId)
    {
        return $this->createQueryBuilder('O')
            ->select('SUM(O.OperMontant) ')
            ->Where('O.OperSensMt = 1 ')
            ->andWhere('O.CompteId = :CompteId')
            ->setParameter('CompteId', $CompteId)
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return OPERATIONCOMPTABLE[] Returns an array of OPERATIONCOMPTABLE objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OPERATIONCOMPTABLE
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
