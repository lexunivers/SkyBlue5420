<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use App\Entity\User;
use App\Entity\Comptepilote;

use MercurySeries\FlashyBundle\FlashyNotifier;


class MesDossiersController extends AbstractController
{

    //Attribution d'un numéro comptable au Nouveau User
    //et on affiche la page profile à compléter
    //sinon on affiche la page MesDossiers


    public function indexAction(Request $request)
    {
        // attributs de session

        $user = $this->getUser('session');
		
		//var_dump($user);
		//exit;
       // $user = $this->getUser('session')->getFirstname();		
		//$user->setUser($this->getUser());
		
        //$flashy->success('Event created!', 'http://your-awesome-link.com');  
        //$flashy->primaryDark('Bienvenue dans votre Espace !', 'http://your-awesome-link.com');

        return $this->render('MesDossiers/Mes_Dossiers.html.twig', array(
            'user' => $user,
			'firstname' => $user->getFirstname(),
			'lastname' => $user->getLastname()
           //'editMode' => $user
        ));
    }
}
