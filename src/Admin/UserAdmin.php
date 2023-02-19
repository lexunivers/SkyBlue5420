<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\UserBundle\Form\Type\RolesMatrixType;
use Sonata\UserBundle\Model\UserInterface;
use Sonata\UserBundle\Model\UserManagerInterface;
#use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Sonata\Form\Type\DatePickerType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\UserBundle\Form\Type\SecurityRolesType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
//use Sonata\Form\Type\DateTimePickerType;
//use App\form\DatePickerType;
/**
 * @phpstan-extends AbstractAdmin<UserInterface>
 */
class UserAdmin extends AbstractAdmin
{
    
    protected UserManagerInterface $userManager;
    protected $classnameLabel = 'user';

    public function __construct(UserManagerInterface $userManager)
    {
        parent::__construct();
        $this->userManager = $userManager;
    }

    protected function preUpdate(object $object): void
    {
        $this->userManager->updatePassword($object);
    }

    protected function configureFormOptions(array &$formOptions): void
    {
        $formOptions['validation_groups'] = ['Default'];

        if (!$this->hasSubject() || null === $this->getSubject()->getId()) {
            $formOptions['validation_groups'][] = 'Registration';
        } else {
            $formOptions['validation_groups'][] = 'Profile';
        }
    }

    protected function configureSideMenu(MenuItemInterface $menu, $action, Admin $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, array('CpteSolo'))) {
            return;
        }
        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');
        $menu->addChild('Cpte_Solo', array('uri' => 'CpteSolo' . $id));
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->add('CpteSolo');//, $this->getRouterIdParameter().'/CpteSolo');
            //->add('CompteId');    
        }

    protected function configureListFields(ListMapper $list): void
    {

        $list
            ->addIdentifier('username')
            ->add('id',TextType::class, array('label'=>'N° Pilote',)	)					
            ->add('comptepilote.id', TextType::class, array('label'=>'N° Comptable',
                   'class' => User::class,
                   'associated_property'=>'id'                                    
                        ))
            ->add('enabled', null, ['editable' => true])
            ->add('createdAt')
       ;

        if ($this->isGranted('ROLE_ALLOWED_TO_SWITCH')) {
            $list
                ->add('impersonating', FieldDescriptionInterface::TYPE_STRING, [
                    'virtual_field' => true,
                    'template' => '@SonataUser/Admin/Field/impersonating.html.twig',
                ]);
        }
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('username')
            ->add('email');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->tab('Fiche du Pilote', ['label'=>'Fiche du Pilote']) // the tab call is optional
                    ->with('Données Personnelles',['class' => 'col-md-3',
					'box_class'   => 'box box-solid box-primary',
					'label'=>'Données Personnelles'])

                   		
                       // ->add('username')
                        ->add('firstname')
                        ->add('lastname')
                        //->add('gender')
						->add('dateOfBirth', null, array('format'=>"d-m-Y"))
                        //->add('email')
					->end()	
                    
                    ->with('Coordonnées',['class' => 'col-md-3',
					'box_class'   => 'box box-solid box-primary',
					'label'=>'Coordonnées'])
					
						->add('residence', TextType::class, array( 'label'=>'Résidence','required' => false))
                        ->add('rue', TextType::class, array( 'label'=>'Rue', 'required' => false))
                        ->add('numero', TextType::class, array( 'label'=>'N°','required' => false))
                        ->add('ville', TextType::class, array( 'label'=>'Ville','required' => false))
                        ->add('codepostal', TextType::class, array( 'label'=>'Code Postal','required' => false))
                        ->add('pays', TextType::class, array( 'label'=>'Pays','required' => false))
                        ->add('phone', TextType::class, array( 'required' => false))
                        //->add('job', TextType::class, array( 'label'=>'Activité','required' => false))

					->end()		
            
			
                    ->with('Profile',['class' => 'col-md-3',
					'box_class'   => 'box box-solid box-primary',
					'label'=>'Profile'])
                    
					
                        ->add('locale')
                        ->add('timezone')
                        ->add('job', TextType::class, array( 'label'=>'Activité','required' => false))
                        ->add('id',TextType::class, array('label'=>'N° Pilote',)	)					
                        ->add('comptepilote.id', TextType::class, array('label'=>'N° Comptable',
                        'class' => User::class,
                        'associated_property'=>'id'                        
                        
                        ))
                       // ->add('comptepilote', EntityType::class, array('label' =>'N° Comptable',
                         //       'class' => Comptepilote::class,
                           //     'associated_property'=>'id'
                           // ))
                    ->end()					

                    ->with('Identifiants',['class' => 'col-md-3',
					'box_class'   => 'box box-solid box-primary',
					'label'=>'Identifiants'])
					
                        ->add('username')
                        ->add('email')						
                    //->with('Groups', array(
                    //    'class'       => 'col-md-2',
                    //    'box_class'   => 'box box-solid box-success',
                    //    'description' => 'Lorem ipsum',
                    //))
                     //       ->add('groups')
                
					->end()
					;

				
    }

    protected function configureFormFields(FormMapper $form): void
    {
		
        $form
            ->tab('Fiche du Pilote', ['label'=>'Fiche du Pilote']) // the tab call is optional


                ->with('Identité',['class' => 'col-md-4','box_class'   => 'box box-solid box-primary', 'label'=>'Identité'])
                    //->add('gender', ChoiceType::class, $gender)
                    ->add('firstname', null, array('required' => false))
                    ->add('lastname', null, array('required' => false))

					// or DatePickerType if you don't need the time
					->add('dateOfBirth', DatePickerType::class)
                ->end()


			->with('Adresse',['class' => 'col-md-4','box_class'   => 'box box-solid box-primary', 'label'=>'Adresse'])
			
                    ->add('residence', TextType::class, array('label'=>'Résidence','required' => false))
                    ->add('rue', TextType::class, array('label'=>'Rue','required' => false))
                    ->add('numero', TextType::class, array('label'=>'N°','required' => false))
                    ->add('ville', TextType::class, array('label'=>'Ville','required' => false))
                    ->add('codepostal', TextType::class, array('label'=>'Code Postal','required' => false))
                    ->add('pays', TextType::class, array('label'=>'Pays','required' => false)) 
        ->end()
        ->with('Content', ['class' => 'col-md-4','box_class'   => 'box box-solid box-primary', 'label'=>'Divers'])
                    ->add('hobby', TextType::class, array('label'=>'Passe Temps','required' => false))
                   // ->add('phone', TextType::class, array('required' => false))
                    ->add('job', TextType::class, array('label'=>'Activité','required' => false))
					
        ->end()
    ->end()

    ->tab('Données', ['label'=>'Données'])	
            ->with('Données', ['class' => 'col-md-4','box_class'   => 'box box-solid box-primary', 'label'=>'Identifiants'])
                ->add('username')
                ->add('email')
				->add('phone', TextType::class, array('required' => false))
                ->add('plainPassword', TextType::class, [
                    'required' => (!$this->hasSubject() || null === $this->getSubject()->getId()),
                ])
				




					
                ->add('locale', LocaleType::class, ['required' => false])
                ->add('timezone', TimezoneType::class, ['required' => false])
                ->add('plainPassword', TextType::class, [
                    'required' => (!$this->hasSubject() || null === $this->getSubject()->getId()),
                ])				
                ->add('enabled', null)
            ->end()
			

            ->with('roles', ['class' => 'col-md-4'])
                ->add('realRoles', RolesMatrixType::class, [
                    'label' => false,
                    'multiple' => true,
                    'required' => false,
                ])
            ->end();
    }

    protected function configureExportFields(): array
    {
        // Avoid sensitive properties to be exported.
        return array_filter(
            parent::configureExportFields(),
            static fn (string $v): bool => !\in_array($v, ['password', 'salt'], true)
        );
    }
	
    public function toString(object $object): string
    {
        return $object instanceof User
            ? $object->getTitle()
            : 'Membre'; // shown in the breadcrumb on the create view
    }	
}
