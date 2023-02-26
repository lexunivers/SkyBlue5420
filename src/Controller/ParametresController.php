<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use App\Entity\Parametres;
 
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

//use Sonata\CoreBundle\Form\Type\DatePickerType;
//use Sonata\CoreBundle\Form\Type\DateTimePickerType;

use Sonata\Form\Type\DatePickerType;
use Sonata\Form\Type\DateTimePickerType;

use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ParametresController extends CRUDController
{
    #[Route('/parametres', name: 'app_parametres')]
    public function index(): Response
    {
        return $this->render('parametres/index.html.twig', [
            'controller_name' => 'ParametresController',
        ]);
    }


    public function preList(Request $request): ?Response
    {
    //public function listAction(Request $request): Response
    //{        
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $request =$this->container->get('request_stack')->getCurrentRequest();
        $locale = $this->container->get('request_stack')->getCurrentRequest()->getLocale();
         
        //$data = $this->getConfigData();
        
         
        $formBuilder = $this->createFormBuilder(null, [
            'constraints' => [new Callback([$this, 'formValidate'])]
        ]);
        $formBuilder->add("offre_date_debut", DatePickerType::class, [
            'required' => true,
            'dp_use_current' => false,
            'dp_min_date' => new \DateTime("2020-01-01"),
            'data' => isset($data['offre_date_debut']) ? new \DateTime('@'.$this->parseDate($data['offre_date_debut'],$locale)) : new \DateTime(),
            'mapped' => false,
        ])
        ->add("offre_date_fin", DatePickerType::class, [
            'required' => true,
            'dp_use_current' => false,
            'dp_min_date' => new \DateTime("2020-01-01"),
            'data' => isset($data['offre_date_fin']) ? new \DateTime('@'.$this->parseDate($data['offre_date_fin'],$locale)) : new \DateTime(),
            'mapped' => false,
        ])
        ->add('submit', SubmitType::class, [
            'label' => $this->get('translator')->trans('Valider')
        ]);
 
        $form = $formBuilder->getForm();
        $form->handleRequest($request);
         
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $this->getRequest()->request->get('form');
            $ParametresRepositoty = $this->container->get('doctrine.orm.entity_manager')->getRepository(Parametres::class);
            $ParametresRepositoty->updateConfig('offre_date_debut', date("Y-m-d", $this->parseDate($formData['offre_date_debut'],$locale)) );
            $ParametresRepositoty->updateConfig('offre_date_fin',date("Y-m-d",$this->parseDate($formData['offre_date_fin'],$locale)));
            $this->addFlash('success', $this->get('translator')->trans('Parametres sauvegardés.'));
        }        

        return $this->render('Admin/parametres/listAction.html.twig', [
            'controller_name' => 'ParametresController',
            'form' => $form->createView()        
        ]);
    }
    //return null;
}
