<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;

final class AvionsAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('immatriculation')
            ->add('marque')
            ->add('type')
            ->add('eventColor')
            ->add('puissance')
            ->add('anneemodele')
            ->add('anneeachat')
            ->add('anneerevente')
            ->add('essence')
            ->add('place')
            ->add('valeur')
            ->add('heuresdevol')
            ->add('heuresdevolmachine')
            ->add('enparc')
            ->add('datefiche')
            ->add('tarifHoraire')
            ->add('instruction')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
			->addIdentifier('id')
            //->add('id')
            ->add('immatriculation', null, ['label' => 'Plaque'])
            ->add('marque')
            ->add('type')
            ->add('eventColor')
            ->add('puissance')
			->add('place')
            ->add('anneemodele', null, ['label' => 'Modèle de'])
            ->add('anneeachat', null, ['label' => 'Achat en'])
            ->add('anneerevente', null, ['label' => 'Revendu en'])
            ->add('essence')

            ->add('valeur')
            ->add('heuresdevol', null, ['label' => 'Nbre H/Vol'])//, 'int', array('total'=>'H/','format'=>'h:i:s '))
            ->add('heuresdevolmachine', null, ['label' => 'Nbre H/Vol/Machine'])
			//->add('CouleurGrille')
            #->add('enparc')
            #->add('datefiche')
            ->add('tarifHoraire')
            ->add('instruction')
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
        // define group zoning
        $form
            ->tab('Appareil')
                ->with('Avion', array('class' => 'col-md-3','box_class'=> 'box box-solid box-primary'))
					->add('immatriculation')
					->add('marque')
					->add('type')
					->add('eventColor', ColorType::class)
					->add('puissance', null, ['required' => false])								
				->end()
								
                ->with('Caractéristiques', array('class' => 'col-md-3','box_class'   => 'box box-solid box-primary'))
					->add('anneemodele', TextType::class, array('label' => 'Modèle de:', 'required' => false))
					->add('anneeachat', TextType::class, array('label' => 'Achat En', 'required' => false))
					->add('anneerevente',TextType::class, array('label' => 'Année Revente', 'required' => false))
					->add('essence',TextType::class, array('label' => 'Carburant', 'required' => false))
					->add('place', null, ['required' => false])
					->add('valeur', null, ['required' => false])					
					->add('heuresdevol', TextType::class, array('label' => 'H de Vol','required' => false))
					->add('heuresdevolmachine', IntegerType::class, array('label' => 'H/Vol Machine','required' => false))				
				->end()
                
				->with('Tarification', array('class' => 'col-md-3', 'box_class'   => 'box box-solid box-primary'))
					->add('tarifHoraire', IntegerType::class, array('label' => 'Tarif','required' => false))
					->add('instruction', IntegerType::class, array('label' => 'Instruction','required' => false))
				->end()
				
                ->with('Situation', array('class' => 'col-md-2','box_class'   => 'box box-solid box-danger'))
					->add('enparc', null, ['required' => false])
					->add('datefiche', null, ['required' => false])				
				->end()
            ->end()
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
			->with('Appareil', ['class' => 'col-md-3', 'box_class'   => 'box box-solid box-primary'])
				->add('immatriculation')
				->add('marque')
				->add('type')
				->add('eventColor')
				//->add('CouleurGrille')
				->add('puissance')
		    ->end()	
            
            ->with('Données Administratives', ['class' => 'col-md-4', 'box_class'   => 'box box-solid box-success'])			
				->add('anneemodele', null,['label' => 'Modèle de:'])
				->add('anneeachat', null,['label' => 'Acheté en:'])
				->add('anneerevente', null,['label' => 'Année de revente:'])
				->add('essence')
				->add('place')
				->add('valeur')
			->end()
			
			->with('Données Techniques',['class' => 'col-md-4', 'box_class'   => 'box box-solid box-danger'])				
				->add('heuresdevol', null,['label' => 'H de Vol Moteur',
											'format' => 'H:i',])
				->add('heuresdevolmachine', null,['label' => 'H de Vol cellule'])
				->add('tarifHoraire',null,['label' => 'Tarif Horaire'])
				->add('instruction')
				->add('enparc', null,['label' => 'En Parc'])
				->add('datefiche', null,['label' => 'Date Enregistrement'])
            ->end()
			;
    }
}
