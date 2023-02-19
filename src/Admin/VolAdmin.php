<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\AdminBundle\Admin\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Form\Type\ModelListType;

final class VolAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('datevol')
            ->add('heureDepart')
            ->add('heureArrivee')
            ->add('facture')
            ->add('validation')
            ->add('dateOper')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
		
            ->add('datevol', null, ['label'=>'Date','format'=>'d M y'])
            ->add('user.lastname', null, ['label' => 'Nom'])
            ->add('user.firstname', null, ['label' => 'Prénom'])
            ->add('avion', null, ['label' => 'Avion',
                  'label_icon' => 'fa fa-plane',
                  'header_class' =>'color:red;font:bold'])
            ->add('typevol', null, ['label'=>'Type Vol','property' => 'AffichageVol'])
            ->add('affichageInstructeur', null, ['label'=>'Instruct', 'header_class' =>'color:green'])
            ->add('naturevol', null, ['label' => 'Nature',
                'label_icon' => 'fa fa-thumbs-o-up',
                'header_class' =>'color:red;font:bold'])
            ->add('lieuDepart')
            ->add('lieuArrivee')
            ->add('heureDepart', null, ['label'=>'Heure Départ',
                'label_icon' => 'fa fa-clock-o',
                'header_class' =>'color:red;font:bold'])
            ->add('heureArrivee',null, ['label'=>'Heure Arrivée',
                'label_icon' => 'fa fa-flag-checkered',
                'header_class' =>'color:red;font:bold'])
            ->add('dureeduvol', null, ['label'=>'Durée du Vol'])						
            ->add('avion.tarifHoraire', null, ['label' => 'Tarif Solo'])
            ->add('affichageEcole', null, ['label'=>'Tarif Ecole'])
            ->add('tarifapplicable', FieldDescriptionInterface::TYPE_CURRENCY, ['label' => 'Tarif Appliqué', 'currency' => 'EUR'])
            ->add('montantfacture', FieldDescriptionInterface::TYPE_CURRENCY, ['label' => 'Facture','currency' => 'EUR',
                'label_icon' => 'fa fa-credit-card',
                'header_class' =>'color:red;font:bold',])
                                                      
            ->add('validation', FieldDescriptionInterface::TYPE_BOOLEAN, ['label' =>'Validé ? ','editable' => true])
            ->add('user.comptepilote.id', null, array('label'=>'N° cptable'))
			->add(ListMapper::NAME_ACTIONS, null, [
				'actions' => [
					'show' => [],
					'edit' => [],
					'delete' => [],
				],
			]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
		
                        ->with('Pilote', ['class' => 'col-md-3','box_class'=> 'box box-solid box-primary'])

							->add('user', ModelListType::class, [
								  'btn_add'       => 'AJouter un Membre',       //Specify a custom label
								  'btn_list'      => 'liste des Pilotes',      //which will be translated
								  'btn_delete'    => false,              //or hide the button.
								  'btn_edit'      => 'Edit',             //Hide add and show edit button when value is set
								  'btn_catalogue' => 'SonataUserUser', //Custom translation domain for buttons
								  ], 
								  ['placeholder' => 'Pas de Pilote selectionné',])
               
                        ->end()		

                        ->with('Données du Vol', ['class' => 'col-md-4','box_class'=> 'box box-solid box-success'])
							->add('datevol', null, ['label'=>'Date du Vol' ])
                            ->add('avion',null, ['label'=>'Avion',
                                                 'class' => 'App\Entity\Avions',
                                                 'required' => true ])
												 
                            ->add('TypeVol', EntityType::class,['class' => 'App\Entity\TypeVol',
                                                                'label'=>'Type de Vol',
																'required' => true])
																
                            ->add('instructeur', EntityType::class,['class' => 'App\Entity\instructeur',
																	'placeholder' => 'Si Vol Ecole',
																	'required' => false])
																	
                            ->add('NatureVol', EntityType::class, ['class' => 'App\Entity\naturevol',
																   'label'=>'Nature Vol',
																   'required' => true])
                         ->end()

                        ->with('Départ/Arrivée', ['class' => 'col-md-4','box_class'=> 'box box-solid box-warning'])			
			
                            ->add('LieuDepart', EntityType::class, ['class' => 'App\Entity\Terrain',
                                    'label'=>'Départ de :',
                                    'required' => false ])
                            ->add('heureDepart', TimeType::class, ['label'=>'Heure/Dép:',
                                    'required' => true])
                            ->add('lieuArrivee', EntityType::class, ['class' => 'App\Entity\Terrain',
                                    'label'=>'Arrivée à :',
                                    'required' => false])
                            ->add('heureArrivee', TimeType::class, ['label'=>'Heure/Arr:',
                                    'required' => true])
                         ->end()			
			
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
						->with('Pilote', ['class' => 'col-md-3', 'box_class'   => 'box box-solid box-primary'])
                            ->add('user.lastname', null,['label'=>'Nom','property'=>'lastname'])
                            ->add('user.firstname', null,['label'=>'Prénom','property'=>'firstname'])
                            ->add('user.comptepilote.id',null,['label'=>'N° cptable'])
                        ->end()
                            
                        ->with('Données du Vol', ['class' => 'col-md-4', 'box_class'   => 'box box-solid box-success'])
                            ->add('datevol', null, ['label' => 'Date Vol',
													'format' => 'd M y'])
                            ->add('avion', null, ['label'=>'Avion'])
                            ->add('typevol',null,['label'=>'Type de Vol','property'=>'type'])
                            ->add('affichageInstructeur', null,['label'=>'Instructeur'])
                            ->add('naturevol', null,['label'=>'Nature du Vol'])
                            ->add('lieuDepart',null,['label'=>'Départ de:'])
                            ->add('lieuArrivee', null,['label'=>'Arrivée à:'])
                            ->add('heureDepart', null,['label'=>'Heure de Départ','format' =>'H:i'])
                            ->add('heureArrivee', null,['label'=>'Heure d\'Arrivée','format' =>'H:i'])
                            ->add('dureeduvol', null,[ 'label'=>'Durée du Vol','format' =>'H:i'])
						->end()	
							
						->with('Tarification/Facturation',['class' => 'col-md-4', 'box_class'   => 'box box-solid box-danger'])	
                            ->add('avion.TarifHoraire',FieldDescriptionInterface::TYPE_CURRENCY,['label'=>'Tarif Solo','currency' => 'EUR'])
                            ->add('affichageEcole',FieldDescriptionInterface::TYPE_CURRENCY,['label'=>'Tarif Instruction','currency' => 'EUR'])
                            ->add('tarifapplicable',FieldDescriptionInterface::TYPE_CURRENCY,['label' => 'Tarif Retenu','currency' => 'EUR'])
                            ->add('montantfacture', FieldDescriptionInterface::TYPE_CURRENCY,['label'=>'Montant Facturé','currency' => 'EUR'])
                            ->add('validation', FieldDescriptionInterface::TYPE_BOOLEAN, [
								  'editable' => true,'label'=>'Validé ?'])
						->end()


             // The boolean option is actually very cool
             // true   shows a check mark and the 'yes' label
             // false  shows a check mark and the 'no' label
            ->add('dateCafe', FieldDescriptionInterface::TYPE_BOOLEAN)
            ->add('datePub', FieldDescriptionInterface::TYPE_BOOLEAN)
            ->add('dateClub', FieldDescriptionInterface::TYPE_BOOLEAN)						
            ;
    }

//    public function toString($object)
//    {
//        return $object instanceof Vol
//            ? $object->getTitle()
    
//            : 'Vol Enregistré'; // shown in the breadcrumb on the create view
//    }

}
