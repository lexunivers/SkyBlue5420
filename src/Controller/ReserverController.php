<?php

namespace App\Controller;

use App\Entity\Reserver;
use App\Form\ReserverType;
use App\Repository\ReserverRepository;
use App\Repository\InstructeurRepository;
use App\Entity\Avions;
use App\Entity\Vol;
use App\Entity\User;
use App\Repository\VolRepository;
use App\Repository\AvionsRepository;
use App\Entity\Resources;
use App\Entity\Instructeur;
use App\Form\InstructeurType;
use App\Form\ReserverEditType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
Use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @Route("/reserver")
 */
class ReserverController extends AbstractController
{
    /**
     * @Route("/", name="reserver_index", methods={"GET"})
     */
    public function index(ReserverRepository $reserverRepository): Response
    {
		$editMode = false;
		$reserver = new Reserver();
        $form = $this->createForm(ReserverEditType::class, $reserver);		
        	        
		return $this->render('reserver/index.html.twig', [
		    'editMode' => $editMode,
            'form' => $form->createView(),
            'reserver' => $reserverRepository->findAll(),
        ]);
    }

    /**
    * @Route("/load", name="reserver_load")
    */
    public function load()
    {
        $em = $this->getDoctrine()->getManager();       
        $liste = $em->getRepository('App\Entity\Reserver')->findAll();

        $serializer = $this->get('serializer');     
        $json = $serializer->serialize($liste, 'json');

        return new Response($json); 
    }

    /**
    * @Route("/list", name="reserver_list")
    */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();       
        $liste = $em->getRepository('App\Entity\Reserver')->findAll();

        $serializer = $this->get('serializer');     
        $json = $serializer->serialize($liste, 'json');

        return new Response($json); 
    }


    /**
    * @Route("/avion", name="reserver_avion")
    */
    public function avion()
    {
        $em = $this->getDoctrine()->getManager();       
		$avion = $em->getRepository('App\Entity\Avions')->findAll();//myfindCalendar();

        $serializer = $this->get('serializer');     
        $json = $serializer->serialize($avion, 'json');
	
        return new Response($json); 
    }

		
    /**
    * @Route("/formateur", name="reserver_formateur", requirements={"editMode" = "1"}, methods={"GET","POST"})
    */
    public function formateur(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();       
		$formateur = $em->getRepository('App\Entity\Instructeur')->findAll();

        $serializer = $this->get('serializer');     
        $json = $serializer->serialize($formateur, 'json');
	
        return new Response($json);		
	}

    /**
    * @Route("/resources", name="reserver_resources")
    */
    public function resources()
    {
        $em = $this->getDoctrine()->getManager();       
		$resources = $em->getRepository('App\Entity\Resources')->findAll();

        $serializer = $this->get('serializer');     
        $json = $serializer->serialize($resources, 'json');
	
        return new Response($json); 
    }

    /**
    * @Route("/reserver/planning", name="reserver_planning", methods={"GET","POST"})
    */
    public function Planning( Request $request)
        {
            $instructeur = 2;
            $em = $this->getDoctrine()->getManager();            
            $nom = $em->getRepository('App\Entity\Instructeur')->myfindNom($instructeur);           
            foreach ($nom as $value) {
                $value;

            }

            $reserver = new Reserver();
            $form = $this->createForm(ReserverType::class, $reserver);
            $form->handleRequest($request);

            return $this->render('reserver/planning.html.twig', [
                'reserver' => $reserver,
                'noms' => $nom,
                'form' => $form->createView(),
            ]);            
        }

    /**
     * @Route("/new", name="reserver_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
		// attributs de session
        $session = $this->get("session");
        $auteur = $this->getUser('session')->getId();
        $user = $this->getUser('session')->getUsername();
				
        if($request->isXmlHttpRequest()) {
            
            $id = $request->get('id');            
               
            // On instancie une nouvelle reservation
            $reserver = new Reserver();

            $title = $request->get('user');
            $start = $request->get('start');
            $end = $request->get('end');
            $resourceId = $request->get('resourceId');
            $formateur = $request->get('formateur');
            $instructeur = $request->get('instructeur');
            $appareil = $request->get('appareil');
			$editMode = $request->get('editMode');

            $em = $this->getDoctrine()->getManager(); 

			if ($instructeur == false ){               
			    $reserver->setTitle($user);
                $reserver->setFormateur("Néant");
                          
                $appareil = $em->getRepository('App\Entity\Resources')->myfindAvion($resourceId);           
                
                foreach ($appareil as $value) {
					$value;
				};
                $appareil = implode("--", $value);
                $reserver->setAppareil($appareil);                

            }else{

               // $em = $this->getDoctrine()->getManager();
                $formateur = $em->getRepository('App\Entity\Instructeur')->myfindNom($instructeur);		
				$initiale = $em->getRepository('App\Entity\Instructeur')->myfindInitiales($instructeur);				
                $appareil = $em->getRepository('App\Entity\Resources')->myfindAvion($resourceId);

                // - 1 - On renseigne l'attribut 'Appareil'
                foreach ($appareil as $value1) {
					$value1;
				};
                $appareil = implode("--", $value1);
                $reserver->setAppareil($appareil);

                // - 2 - On renseigne l'attribut 'formateur'
                foreach ($formateur as $value2) {
					$value2;
				};
                $nom = implode(":", $value2);                 
                $reserver->setFormateur($nom);

                // - 3 - On renseigne l'attribut 'Initiales'
                foreach ($initiale as $value3) {
					$value3;
				};
				$title	= $user." / ".$value3;              
				$reserver->setTitle($title);
			}

			$form = $this->createForm(ReserverEditType::class, $reserver);
			$form->handleRequest($request);

            $reserver->setStart(new \DateTime($start) );
            $reserver->setEnd(new \DateTime($end) );
            $reserver->setResourceId($resourceId);
            $reserver->setReservataire($auteur );
 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reserver);
            $entityManager->flush();
 
           //return $this->redirectToRoute('reserver_index');
        }

        //$response = new Response(json_encode($stop));
        //$response->headers->set('Content-Type', 'application/json');
        //return $response;
        //$form = $this->createForm(ReserverType::class, $reserver);
        //$form->handleRequest($request);				
			
        return $this->render('reserver/index.html.twig', [
            'editMode' => $editMode,
            'form' => $form->createView(),
        ]);		
	    
    }

    /**
     * @Route("/reserver/update", name="reserver_update", methods={"GET","POST"})
     */
    public function update(Request $request): Response
    {

		// attributs de session
        $user = $this->container->get('security.token_storage')->getToken()->getUser()->getId();

        if($request->isXmlHttpRequest()) {
            
            $id = $request->get('id');

            // Récupère l'objet en fonction de l'@Id
            $repository = $this->getDoctrine()->getRepository(Reserver::class);   
            $reserver = $repository->find($id);
            $reservataire = $reserver->getReservataire($id);
			$instructeur = $reserver->getInstructeur($id);
            
            if ($user !== $reservataire)   
			{
                $stop = true;
            }else{
                $stop = false;
				
                //$title = $request->get($title);
                $start = $request->get('start');
                $end = $request->get('end');
                $resourceId = $request->get('resourceId');

                $reserver->setStart(new \DateTime($start) );
                $reserver->setEnd(new \DateTime($end) );
  
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($reserver);
                $entityManager->flush();            
            }
           
        }
           
        $response = new Response(json_encode($stop));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        // return $this->render('reserver/index.html.twig', //['var' => $var, 'user' => $user, 'reservataire' => $reservataire ]
            //['var' => $var,
            //'form' => $form->createView(),
              // ]
           // );
    }
    
    /**
    * @Route("/reserver/delete", name="reserver_delete", methods={"POST"})
    */
    public function delete(Request $request): Response
    {
        // attributs de session
        $user = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
            if($request->isXmlHttpRequest()) {
                $id = $request->get('id');
                $repository = $this->getDoctrine()->getRepository(Reserver::class);
                $reserver = $repository->find($id);                 
                $reservataire = $reserver->getReservataire($id);
            
                if ($user !== $reservataire)   
                {
                    $stop = true;
                }else{
                    $stop = false; 
                  
            //if ($this->isCsrfTokenValid('delete'.$reserver->getId($id), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($reserver);
                $entityManager->flush();
                }
        }
        $response = new Response(json_encode($stop));
        $response->headers->set('Content-Type', 'application/json');
        return $response;        
        //return $this->render('reserver/index.html.twig');
        //return $this->redirectToRoute('reserver_index');
    }

    //<-- partie hors requête Ajax de index.html.twig -->
    //<-- Utilisé pour le formulaire classique de réservation -->
    
    /**
     * @Route("/add", name="reserver_add", methods={"GET","POST"})
     */
    public function add(Request $request): Response
    {
        $reserver = new Reserver();
        $form = $this->createForm(ReserverType::class, $reserver);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        $session = $this->get("session");
        $auteur = $this->getUser('session')->getId();
        $user = $this->getUser('session')->getUsername();
		$instructeur = $reserver->getInstructeur();
		$resourceId = $reserver->getResourceId();
        $em = $this->getDoctrine()->getManager(); 

			if ($instructeur == true){
				$initiale = $reserver->getInstructeur()->getInitiales();
				$title	= $user." / ".$initiale;
				$reserver->setTitle($title);
                $reserver->setFormateur($reserver->getInstructeur() );
			}else{			
			$reserver->setTitle($user);
            $reserver->setFormateur("Néant");
			}
			
		$reserver->setReservataire($auteur);
		$reserver->SetResourceId($reserver->getAvion()->getAvion()->getId());
		$reserver->setInstructeur($reserver->getInstructeur() );
            $title = $reserver->getAvion()->getAvion()->getTitle();	
            $immat = $reserver->getAvion()->getAvion()->getType();
            $identif = $immat."-".$title;        
        $reserver->SetAppareil($identif);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reserver);
        $entityManager->flush();

            return $this->redirectToRoute('reserver_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reserver/new.html.twig', [
            'reserver' => $reserver,
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/liste", name="reserver_liste", methods={"GET","POST"})
    */
    public function listeMesReservations( Request $request)
        {               
                $user = $this->getUser('session')->getUsername();

                $title= strval($user);
                $em = $this->getDoctrine()->getManager();
                $reserver = $em->getRepository('App\Entity\Reserver')->findBy(array('title' => $title),
                                                                               array('start' => 'asc') );
                //var_dump($reserver);

                $lettreId = $em->getRepository('App\Entity\Avions')->findAll();//ByExampleField(array('marque' => $marque));               
                //var_dump($lettreId);
				
                $instructeur = $em->getRepository('App\Entity\Instructeur')->findAll();//ByExampleField(array('marque' => $marque)); 

				$vol = $em->getRepository('App\Entity\Vol')->findAll();//findByExampleBetween(); //findByExampleField();//(array('heureDepart' => $heureDepart),
																	//array('user' => $user) );
																	//);//ByValidation();//findBy(array ('user'=> $user),
																			//array('vol'=>$id),
																			//);
																			
																							//findByValidation($user);//findBy(array('user' => $user),
																							//array('instructeur' => $instructeur)
																							//);	
                //var_dump($vol);
					//			$vol->getUser()->getId();


				
                return $this->render('/Reserver/show.html.twig', array(
                  'reserver' => $reserver,
                  'lettreId' => $lettreId,
				  'instructeur' => $instructeur,
				  'vol' =>$vol,
              ));
        }



    /**
     * @Route("/{id}", name="reserver_show", methods={"GET"})
     */
    public function show(Reserver $reserver): Response
    {
        return $this->render('reserver/show.html.twig', [
            'reserver' => $reserver,
        ]);
    }
	
    /**
     * @Route("/{id}/edit", name="reserver_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reserver $reserver): Response
    {
        $form = $this->createForm(ReserverType::class, $reserver);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reserver_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reserver/edit.html.twig', [
            'reserver' => $reserver,
            'form' => $form->createView(),
        ]);
    }
}
