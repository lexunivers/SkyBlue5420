<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use App\Entity\Statistiques;
 
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

//use Sonata\Form\Type\DatePickerType;
//use Sonata\Form\Type\DateTimePickerType;

use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class StatistiquesController extends CRUDController
{


    public function preList(Request $request): ?Response
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

//    /**
//     * @Route("/stats", name="stats")
//     */
//   public function statistiques(CategoriesRepository $categRepo, AnnoncesRepository $annRepo){
        // On va chercher toutes les catégories
        $em = $this->getDoctrine()->getManager();
        $User = $em->getRepository('App\Entity\User')->findAll();         
        //$Users = $UserRepository->findAll();

        $categNom = [];
        $categColor = [];
        $categCount = [];

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach($User as $User){
            $categNom[] = $User->getUsername();
           // $categColor[] = $User->getColor();
            //$categCount[] = count($User->getFirstname());
        }

        // On va chercher le nombre d'annonces publiées par date
        //$annonces = $annRepo->countByDate();

       // $dates = [];
        //$annoncesCount = [];

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        //foreach($annonces as $annonce){
        //    $dates[] = $annonce['dateAnnonces'];
        //    $annoncesCount[] = $annonce['count'];
        //}

        return $this->render('Statistiques/index.html.twig', [
            'categNom' => json_encode($categNom),
            'categColor' => json_encode($categColor),
            'categCount' => json_encode($categCount),
           // 'dates' => json_encode($dates),
           // 'annoncesCount' => json_encode($annoncesCount),
        ])
        ;

        //return $this->render('/Admin/CpteIndividuel/cpte_solo.html.twig',     
       // return $this->render('statistiques/index.html.twig');
    }


}
