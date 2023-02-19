<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\FormView;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Common\Persistence\ObjectManager;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
//use MercurySeries\FlashyBundle\FlashyNotifier;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Bundle\PaginatorBundle\Definition;

//use App\Entity\Comptepilote;
use App\Entity\SonataUserUser;
use App\Entity\OperationComptable;
use App\Form\OperationComptableType;
use App\Form\OperationComptableEditType;
use App\Repository\OperationComptableRepository;
use Sonata\AdminBundle\Route\RouteCollection;
//use Symfony\Component\Security\Core\User\UserInterface;


class OperationComptableController extends Controller
{

    /**
     * @Route("/operation_comptable", name="operationcomptable")
     */
    public function index()
    {
        return $this->render('operation_comptable/index.html.twig', [
            'controller_name' => 'OperationComptableController',
        ]);
    }

    /**
     * @Route("/operationcomptable/cptesolo", name="cptesolo", methods={"GET","POST"})
     */
    public function cptesoloAction(Request $request): Response
    {
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
				
				$user = 0;
                
				$prenom = $this->getUser()->getFirstname();
				$nom = $this->getUser()->getlastname();
				$comptable = $this->getUser()->getComptepilote();
				$pilote = $this->getUser()->getId();
			}	

		$form->getData();

			if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()){
			
				$user  = $form->getData()->getUser()->getId();
				$prenom = $form->getData()->getUser()->getFirstname();
				$nom = $form->getData()->getUser()->getLastname();
				$comptable = $form->getData()->getUser()->getComptepilote();
				$pilote = $form->getData()->getUser()->getId();
				
			}

			$listEcritures = $em->getRepository('App\Entity\OperationComptable')->findBy(
				array('CompteId' => $user),
				array('OperDate' => 'ASC')
			);		
	
		$sommeTotale =$em->getRepository('App\Entity\OperationComptable')->myfindSommeTotale($user);
        $montantdebit = $em->getRepository('App\Entity\OperationComptable')->myFindDebit($user);
        $montantcredit = $em->getRepository('App\Entity\OperationComptable')->myFindCredit($user);

        
		return $this->render('/operation_comptable/cpte_solo.html.twig',  array(
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

	}


    public function AjouterEcritureAction(OperationComptable $Operation = null, Request $request, ObjectManager $manager = null)
    {
        $Operation = new OperationComptable();
                
        $form    = $this->createForm(OperationComptableType::class, $Operation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Operation);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Votre Compte a bien été mis à jour.');

            // $this->addFlash('info', 'Profile updated');
            // $this->addFlash('warning', 'Profile issued');

            return $this->redirect($this->generateUrl('sky_compte_ajouter', array('id' => $Operation->getId())));
        }
                    
        return $this->render('/MonCompte/AjoutEcritures.html.twig', array(
            'formMonCompte'    => $form->createView(),
            'editMode' => $Operation->getId() !== null
                
        ));
    }



}
