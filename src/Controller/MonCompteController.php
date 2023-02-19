<?php

namespace App\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\OperationComptable;
use App\Form\OperationComptableType;
use App\Form\OperationComptableEditType;
//use MercurySeries\FlashyBundle\FlashyNotifier;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Dompdf\Dompdf;
use Dompdf\Options;

class MonCompteController extends AbstractController
{

    /**
     * @Route("/moncompte", name="moncompte_home")
     */    
    public function indexAction(Request $request, PaginatorInterface $paginator): Response
    {
        // attributs de session
        $user = $this->getUser('session')->getId();
                
        $em = $this->getDoctrine()->getManager();
                
        $listEcritures = $em->getRepository('App\Entity\OperationComptable')->findBy(
            array('CompteId' => $user),
            array('OperDate' => 'ASC')
        );


        $sommeTotale =$em->getRepository('App\Entity\OperationComptable')->myfindSommeTotale($user);
        $montantdebit = $em->getRepository('App\Entity\OperationComptable')->myFindDebit($user);
        $montantcredit = $em->getRepository('App\Entity\OperationComptable')->myFindCredit($user);


        return $this->render('/MonCompte/Situation_Compte.html.twig', array(
            'pagination' => $paginator->paginate(
                $listEcritures,
                $request->query->getInt('page', 1), // page number
                5 // limit per page
            ),

            'montantdebit'=>$montantdebit,
            'montantcredit'=>$montantcredit,
            'Ecritures' => $listEcritures,
            'sommeTotale' => $sommeTotale,
            
        ));
    }

    /**
     * @Route("/moncompte/user/{Id}", name="moncompte_user")
     */
    public function moncompteAction(string $Id, Request $request,): Response
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
				
				$user = 1; 
				//$prenom = $this->getUser('1')->getFirstname();
				//$nom = $this->getUser('1')->getlastname();
				//$comptable = $this->getUser('1')->getComptepilote();
				//$pilote = $this->getUser('1')->getId();
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
			//'prenom' => $prenom,
            //'nom' => $nom,
			//'comptable' => $comptable,
			//'pilote' => $pilote,
        ));

	}

    public function PDFMonCompteAction()
    {
        
       // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser('session')->getId();
        
        $listEcritures = $em->getRepository('App\Entity\OperationComptable')->findBy(
            array('CompteId' => $user),
            array('OperDate' => 'ASC')
        );

        $sommeTotale =$em->getRepository('App\Entity\OperationComptable')->myfindSommeTotale($user);
        $montantdebit = $em->getRepository('App\Entity\OperationComptable')->myFindDebit($user);
        $montantcredit = $em->getRepository('App\Entity\OperationComptable')->myFindCredit($user);
      
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('MonCompte/EtatCompte.html.twig', ['listEcritures'=>$listEcritures,
                                                                     'montantdebit'=>$montantdebit,
                                                                     'montantcredit'=>$montantcredit,
                                                                     'sommeTotale' => $sommeTotale,   
                                                                    ] ); 
     
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("EtatCompte.pdf", [
            "Attachment" => true
        ]);        

    }

        // Method 2: via constructor
		// public function __construct(FlashyNotifier $flashy)
        //{
        //    $this->flashy = $flashy;
		// }


		/**
		* @Route("/paiement", name="sky_compte_paiement", methods={"GET","POST"})
		*/
        public function PaiementAction(Request $request, OperationComptable $operation = null)
        {

        $operation = new OperationComptable();
        
        $operation->setUser($this->container->get('security.token_storage')->getToken()->getUser());
        $operation->setCompteId($this->container->get('security.token_storage')->getToken()->getUser()->getId());
        $operation ->setOperSensMt(1);
  
        $form    = $this->createForm(OperationComptableType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($operation);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Votre Paiement a bien été enregistré.');
           // $this->flashy->primaryDark('Paiement Enregistré !', 'http://your-awesome-link.com');
            return $this->redirect($this->generateUrl('sky_compte', array('id' => $operation->getId())));
        }
        return $this->render('/MonCompte/paiement.html.twig', array(
            'formMonCompte'    => $form->createView(),
           // 'editMode' => $operation->getId() !== null
                
        ));
    }
}
