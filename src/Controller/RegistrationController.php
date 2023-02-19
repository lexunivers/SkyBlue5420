<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Comptepilote;
use App\Repository\UserRepository;
use App\Service\SendMailService;
use App\Service\JWTService;
use Symfony\Component\Form\FormEvent;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register( Request $request,
     UserPasswordHasherInterface $userPasswordHasher, 
     UserAuthenticatorInterface $userAuthenticator, 
     UserAuthenticator $authenticator, 
     EntityManagerInterface $entityManager,
     SendMailService $mail,
     JWTService $jwt): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
				
            );
			
           // $entityManager->persist($user);
           // $entityManager->flush();

            // do anything else you need here, like send an email
			
			$Comptepilote = new Comptepilote();
            $Comptepilote->setNom($user);			
			$user->setComptepilote($Comptepilote);

            $entityManager->persist($user);			
            $entityManager->persist($Comptepilote);
            $entityManager->flush();

            // On génère le JWT de l'utilisateur
            // On crée le Header
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];

            // On crée le Payload
            $payload = [
                'user_id' => $user->getId()
            ];

            // On génère le token
            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

            // On envoie un mail
            $mail->send(
                'no-reply@monsite.net',
                $user->getEmail(),
                'Activation de votre compte sur le site Skyblue',
                'register',
                compact('user', 'token')
            );




           $request->getSession()->getFlashBag()->add('notice', 'Merci de compléter votre Fiche');



			//return $this->redirectToRoute('register_confirmer', array('user' => $user->getId(),
																	  //'Username'=>$user->getUsername()
																		//			));
																					
            //return $this->redirect($this->generateUrl('register_confirmer', array('id' => $user->getId(),
																				//  'Username'=>$user->getUsername(),
																				//	)) );




            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
				

            );

        }

        return $this->render('registration/inscription.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }



    #[Route('/verif/{token}', name: 'verify_user')]
    public function verifyUser($token, JWTService $jwt, UserRepository $userRepository, EntityManagerInterface $em): Response
    {
        //On vérifie si le token est valide, n'a pas expiré et n'a pas été modifié
        if($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret'))){
            // On récupère le payload
            $payload = $jwt->getPayload($token);

            // On récupère le user du token
            $user = $userRepository->find($payload['user_id']);
            //dd($token);
            //On vérifie que l'utilisateur existe et n'a pas encore activé son compte
            if($user && !$user->getIsVerified()){
                $user->setIsVerified(true);
                $user->setEnabled(true);        
                $em->flush($user);
                $this->addFlash('success', 'Utilisateur activé');
                return $this->redirectToRoute('sky_user_mesdossiers');
            }
        }
        // Ici un problème se pose dans le token
        $this->addFlash('danger', 'Le token est invalide ou a expiré');
        return $this->redirectToRoute('app_login');
    }

    #[Route('/renvoiverif', name: 'resend_verif')]
    public function resendVerif(JWTService $jwt, SendMailService $mail, UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        if(!$user){
            $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page');
            return $this->redirectToRoute('app_login');    
        }

        if($user->getIsVerified()){
            $this->addFlash('warning', 'Cet utilisateur est déjà activé');
            return $this->redirectToRoute('profile_index');    
        }

        // On génère le JWT de l'utilisateur
        // On crée le Header
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        // On crée le Payload
        $payload = [
            'user_id' => $user->getId()
        ];

        // On génère le token
        $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

        // On envoie un mail
        $mail->send(
            'no-reply@monsite.net',
            $user->getEmail(),
            'Activation de votre compte sur le site SKYBLUE',
            'register',
            compact('user', 'token')
        );
        $this->addFlash('success', 'Email de vérification envoyé');
        return $this->redirectToRoute('user_profile_voir');
    }

    /**
     * @Route("/register/confirmer", name="register_confirmer")
     */	
	public function Confirmation( Request $request)
	{
        $user = $this->getUser('id');		
		
		var_dump($user);
		exit;
		
        return $this->render('registration/confirmed.html.twig', [
            'controller_name' => 'RegistrationController',
			'user'=> $user
        ]);		
	}	
}
