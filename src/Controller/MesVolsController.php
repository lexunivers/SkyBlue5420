<?php

namespace App\Controller;


//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
//use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Avions;
use App\Repository\AvionsRepository;
use App\Entity\Vol;
use App\Form\VolType;
use App\Form\VolEditType;
use App\Entity\OperationComptable;
use App\Repository\VolRepository;
use App\Entity\User;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;
use Knp\Component\Pager\PaginatorInterface;
//use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\Validator\Constraints\DateTime;
use Dompdf\Dompdf;
use Dompdf\Options;

class MesVolsController extends AbstractController
{

    // Method 2: via constructor
    //public function __construct(FlashyNotifier $flashy)
    //{
    //    $this->flashy = $flashy;
    //}

    public function SaisirUnVolAction(Vol $vol = null, Request $request, ObjectManager $manager = null, OperationComptable $operation = null, Avions $avion = null)
    {
        $vol = new Vol();
    
        $vol->setUser($this->container->get('security.token_storage')->getToken()->getUser());
    
        $form = $this->createForm(VolType::class, $vol);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vol->setFacture($vol->getMontantFacture());
        
            $em = $this->getDoctrine()->getManager();
            $em->persist($vol);
            $em->flush();

           // $request->getSession()->getFlashBag()->add('success', 'Le Vol a bien été enregistré.');

            return $this->redirect($this->generateUrl('sky_gestion_vol_confirmer', ['id' => $vol->getId(), 'avion' => $vol->getAvion('id'), 'Heuresdevol' => $vol->DureeDuVol() ]));
        }
         
        
        return $this->render('/MesVols/new_saisir_Un_Vol.html.twig', [
            'formVol'    => $form->createView(),
            'editMode' => $vol->getId() !== null,
            ]);
    }


    public function ConfirmerUnVolAction(Vol $vol = null, Request $request, OperationComptable $operation = null, Avions $avion = null, $id)
    {
        $operation = new OperationComptable();
        $operation->setCompteId($this->container->get('security.token_storage')->getToken()->getUser()->getId());
        $operation->setUser($vol->getUser());
        $operation->setOperMontant($vol->getMontantFacture());
        $operation ->setOperSensMt(0);
        $operation->setLibelle($vol->getLibelle());

		$avion = $vol->getAvion('id');

        $em = $this->getDoctrine()->getManager();
				
		//<-- Pour les Heures de Fonction du moteur/cellule
		//------------------------------------------------------------------------
		$totalF = $vol->HeuresdeF();
		$temps = $vol->DureeDuVol();
		$totalFcellule = $vol->HeuresdeFcellule();
        
        echo 'heure cellule '.$totalFcellule;

		$heure_1=$totalF;
		$heure_1_1=$totalFcellule;
        echo 'heure_1_1 '.$heure_1_1;                
		$heure_2=$temps;
		echo 'La somme de '.$heure_1.' et de '.$heure_2.' est: '.$vol->add_heures($heure_1,$heure_2); 
						
		$vol->getAvion('id')->setHeuresdeVol($vol->add_heures($heure_1,$heure_2) );
		$vol->getAvion('id')->setHeuresCellule($vol->add_heures($heure_1_1,$heure_2) );

        $vol->setComptable($operation);

        if (null === $vol) {
            throw new NotFoundHttpException("Le Vol d'id ".$id." n'existe pas.");
        }

        $form = $this->get('form.factory')->create(VolEditType::class, $vol);

        if ($request->isMethod('POST') && $form->handleRequest($request) && $form->isSubmitted() && $form->isValid()) {
			
			$em = $this->getDoctrine()->getManager();
            $em->persist($operation);
            $em->persist($vol);
            $em->flush();

            $request->getSession()->getFlashBag()->add('Info', 'la facture est inscrite dans votre Cpte Pilote.');
            // $this->flashy->primaryDark('Vol enregistré !', 'http://your-awesome-link.com'); 
            return $this->redirectToRoute('sky_gestion_vols_detail', array('id' => $vol->getId()));
        }

        return $this->render('/MesVols/Confirmer_Un_Vol.html.twig', [
            'vol' => $vol,
            'formVol'   => $form->createView(),
            'editMode' => $vol->getId() !== null
            ]);
    }

    public function ModifierUnVolAction($id, Request $request, OperationComptable $operation = null)
    {
        $em = $this->getDoctrine()->getManager();

        $vol = $em->getRepository('App\Entity\Vol')->find($id);
        $vol->setUser($this->container->get('security.token_storage')->getToken()->getUser());

        if (null === $vol) {
            throw new NotFoundHttpException("Le Vol d'id ".$id." n'existe pas.");
        }

		// A- Pour Modifier les Heures de Fonction du moteur
		//------------------------------------------------------------------------
		    // 1 - on recupére la valeur en BDD:
			$HeureF=$vol->getAvion('id')->getHeuresdevol();
            $totalFcellule = $vol->getAvion('id')->getHeuresCellule();
		
            // 2 - on récupére la durée précedente du vol
			$totalF = $vol->HeuresdeF();
            $totalFcellule = $vol->HeuresdeFcellule();
			$temps = $vol->DureeDuVol();

		    // 3 - on affecte les valeurs $heure_1 et heure-2  
			$heure_1=$totalF;
			$heure_2=$temps;
            $heure_1_1=$totalFcellule;

		    // 4 - on retire la précedente valeur "DureeDuVol"
			//echo 'La somme de '.$heure_1.' et de '.$heure_2.' est: '.($vol->diff_heures($heure_1,$heure_2) );
			$vol->getAvion('id')->setHeuresdeVol($vol->diff_heures($heure_1,$heure_2) );
			$vol->getAvion('id')->setHeuresCellule($vol->diff_heures($heure_1_1,$heure_2) );
		
            // 5 - on persist la soustraction
            $em = $this->getDoctrine()->getManager();
            $em->persist($vol);

        $form = $this->get('form.factory')->create(VolEditType::class, $vol);
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

		//<-- Pour Enregistrer les nouvelles Heures de Fonction du moteur/cellule
		//------------------------------------------------------------------------
			// 1 - on recupére la new valeur de fonctionnement du moteur et cellule:
				$totalF = $vol->HeuresdeF();
				$totalFcellule = $vol->HeuresdeFcellule();
			// 2 - on récupére la nouvelle durée du vol				
				$temps = $vol->DureeDuVol();
				
			// 3 - on affecte les new valeur $heure_1 et heure-2 
				$heure_1=$totalF;
				$heure_2=$temps;
				$heure_1_1=$totalFcellule;				
			//	echo 'La somme de '.$heure_1.' et de '.$heure_2.' est: '.$vol->add_heures($heure_1,$heure_2); //
		
			// 4 - on enregistre les modifications	
				$vol->getAvion('id')->setHeuresdeVol($vol->add_heures($heure_1,$heure_2));			
				$vol->getAvion('id')->setHeuresCellule($vol->add_heures($heure_1_1,$heure_2));

            //<-- Pour modifier HeureDepart/HeureArrivee/libelle/facture
            //----------------------------------------------------------
            $vol->setFacture($vol->getMontantFacture());

            $operation = $vol->getComptable('id');
            $operation->setUser($vol->getUser());
            $operation->setOperMontant($vol->getMontantFacture());
            $operation ->setOperSensMt(0);
            $operation->setLibelle($vol->getLibelle());

            $em->persist($operation);		
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Le Vol a bien été modifié.');
            //$this->flashy->success('Vol modifié', 'http://your-awesome-link.com');
			//$this->flashy->primaryDark('Vol Modifié !', 'http://your-awesome-link.com');        
            
			return $this->redirectToRoute('sky_gestion_vols_detail', array('id' => $vol->getId()));
        }

        return $this->render('/MesVols/Modifier_Un_Vol.html.twig', array(
            'vol' => $vol,
            'operation'=>$operation,
            'formVol'   => $form->createView(),
            'editMode' => $vol->getId() !== null,
          
        ));
    }

    public function SupprimerUnVolAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $vol = $em->getRepository('App\Entity\Vol')->find(array('id'=>$id));

        $operation = $em->getRepository('App\Entity\OperationComptable')->find($id);
                    
        if (null === $vol) {
            throw new NotFoundHttpException("Le Vol d'id ".$id." n'existe pas.");
        }

        // On modifie le Total d'heures de fonctionnement moteur en BDD		
		$totalFcellule = $vol->HeuresdeFcellule();		
		$totalF = $vol->HeuresdeF();
	    $temps = $vol->DureeDuVol();

		$heure_1=$totalF;
		$heure_2=$temps;
 
		$vol->getAvion('id')->setHeuresdeVol($vol->diff_heures($heure_1,$heure_2) );
		$vol->getAvion('id')->setHeuresCellule($vol->diff_heures($heure_1,$heure_2) );
        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

			$em->remove($vol);
            $em->flush();
                        
            $request->getSession()->getFlashBag()->add('notice', "Le Vol a bien été supprimé.");
			//$this->flashy->success('Vol supprimé', 'http://your-awesome-link.com');
            
			return $this->redirectToRoute('sky_gestion_vols_detail', array('id' => $vol->getId() ));
        }
                
        return $this->render('/MesVols/Supprimer_Un_Vol.html.twig', array(
            'vol' => $vol,
            'formVol'   => $form->createView(),
            //'editMode' => $editMode,
        ));
    }

    public function listdesvolsAction(VolRepository $volsRepo, Request $request , PaginatorInterface $paginator)
    {
        // attributs de session
        $user = $this->getUser('session')->getId();
                
        $em = $this->getDoctrine()->getManager();

        $Vols = $volsRepo->findBy(
            array('user' => $user ),
            array('datevol' => 'desc')
        );
		
        $vols  = $paginator->paginate(
            $Vols, 
            $request->query->getInt('page', 1),
            4 /* límite por página */
        );


        //$vols  = $this->get('knp_paginator')->paginate(
        //    $Vols,
        //    $request->query->getInt('page', 1),
        //    4
        //);

        return $this->render('/MesVols/ListeVols.html.twig', array(
            'vols' => $vols,

        ));
    }

    public function detailsdesvolsAction(VolRepository $volsRepo, Request $request, PaginatorInterface $paginator)
    {

        // attributs de session
        $user = $this->getUser('session')->getId();

        $em=$this->getDoctrine()->getManager();

        $Vols = $volsRepo->findBy(
            array('user'=> $user),
            array('datevol' => 'desc')
        );

        $vols  = $paginator->paginate(
            $Vols, 
            $request->query->getInt('page', 1), 
            4 
        );        
        //$vols  = $this->get('knp_paginator')->paginate(
        //    $Vols,
        //    $request->query->get('page', 1),
        //    4
        //);
            
        return $this->render(
            '/MesVols/Details_des_Vols.html.twig',
            array('vols' => $vols,
            //'editMode' => "editMode",
        )
        );
    }

    public function PDFlistVolsAction( Request $request)
    {
   
       // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        
        $pdfOptions->set('defaultFont', 'Courier');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser('session')->getId();        
        $vols = $em->getRepository('App\Entity\Vol')->findBy(
            array('user' => $user ),
            array('datevol' => 'desc')
        );
      
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('MesVols/listV.html.twig', ['vols'=>$vols, 'user'=> $user ] ); 
     
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("ListVols.pdf", [
            "Attachment" => true
        ]);        

    }

    public function PDFlistDetailVolsAction( Request $request)
    {
        
       // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser('session')->getId();        
        $vols = $em->getRepository('App\Entity\Vol')->findBy(
            array('user' => $user ),
            array('datevol' => 'desc')
        );
      
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('MesVols/listDetailVols.html.twig', ['vols'=>$vols, 'user'=>$user ] ); 
     
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("ListDetailVols.pdf", [
            "Attachment" => true
        ]);        

    //sortie
        // Store PDF Binary Data
        //$output = $dompdf->output();
        
        // In this case, we want to write the file in the public directory
        //$publicDirectory = $this->get('kernel')->getProjectDir() . '/public';
        
        // e.g /var/www/project/public/mypdf.pdf
        //$pdfFilepath =  $publicDirectory . '/mypdf.pdf';
        
        // Write file to the desired path
        //file_put_contents($pdfFilepath, $output);
        
        // Send some text response
        return new Response("The PDF file has been succesfully generated !");
    //
    }



 

}
