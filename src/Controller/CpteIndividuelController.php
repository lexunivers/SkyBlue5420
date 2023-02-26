<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use App\Entity\CpteIndividuel;
use App\Entity\Comptepilote;
use App\Entity\SonataUserUser;
use App\Entity\OperationComptable;
use App\Form\OperationComptableType;
use App\Form\OperationComptableEditType;
use App\Repository\OperationComptableRepository;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Bundle\PaginatorBundle\Definition;

class CpteIndividuelController extends CRUDController
{
    #[Route('/cpte/individuel', name: 'app_cpte_individuel')]
    public function index(): Response
    {
        return $this->render('cpte_individuel/index.html.twig', [
            'controller_name' => 'CpteIndividuelController',
        ]);
    }

    public function preList(Request $request): ?Response
    {
         
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        // do your import logic

        $em = $this->getDoctrine()->getManager();

		$form = $this->createForm(OperationComptableType::class);
        $form->add('user');
        $form->remove('OperDate');
        $form->remove('OperMontant');
        $form->remove('OperSensMt');
        $form->remove('libelle');
        //$form = $this->get('form.factory')->create(OperationComptableType::class);        
		$form->handleRequest($request);
		
			if ($request->isMethod('GET')) {		
				
				$user = 1; 
				$prenom = $this->getUser('1')->getFirstname();
				$nom = $this->getUser('1')->getlastname();
				$comptable = $this->getUser('1')->getComptepilote();
				$pilote = $this->getUser('1')->getId();
			}	

		$form->getData();

			if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()){
			
				$user  = $form->getData()->getUser()->getId();
				$prenom = $form->getData()->getUser()->getFirstname();
				$nom = $form->getData()->getUser()->getLastname();
				$comptable = $form->getData()->getUser()->getComptepilote();
				$pilote = $form->getData()->getUser()->getId();

			}
           // var_dump($user);
           // var_dump($prenom);
           // var_dump($comptable);
           // var_dump($pilote);
           // exit;
			$listEcritures = $em->getRepository('App\Entity\OperationComptable')->findBy(
				array('CompteId' => $user),
				array('OperDate' => 'ASC')
			);		
	
		$sommeTotale =$em->getRepository('App\Entity\OperationComptable')->myfindSommeTotale($user);
        $montantdebit = $em->getRepository('App\Entity\OperationComptable')->myFindDebit($user);
        $montantcredit = $em->getRepository('App\Entity\OperationComptable')->myFindCredit($user);

        
		return $this->render('/Admin/CpteIndividuel/cpte_solo.html.twig',  array(
            //'pagination' => $paginator->paginate(
                $listEcritures,
            //    $request->query->getInt('page', 1), // page number
            //    5 // limit per page
            //),
			
			'formComptable' => $form->createView(),
            'montantdebit'=>$montantdebit,
            'montantcredit'=>$montantcredit,
            'Ecritures' => $listEcritures,
            'sommeTotale' => $sommeTotale,
			'user' => $user,
			'prenom' => $prenom,
            'nom' => $nom,
			'comptable' => $comptable,
			'pilote' => $pilote,
        ));



      //  return $this->render('Admin/CpteIndividuel/cpte_solo.html.twig', [
        //    'controller_name' => 'CpteIndividuelController',
        //]);
    }    
}
