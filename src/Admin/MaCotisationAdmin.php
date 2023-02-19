<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class MaCotisationAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('user', null, array('label' => 'Adhérent'))
            ->add('statut')             
            ->add('cotisation')
            ->add('LicenceFFA')
            ->add('InfoPilote')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            //->add('id')
            ->add('annee',null, array('format'=>'Y', 
                                      'header_style' => 'width: 10%; text-align: center',
                                      'row_align' => 'center' 
                                        
            )) //, DateTimeType::class, array('label'=>'Annee','format'=>'d M y'))            
            
            ->add('user', null, array('label' => 'Adhérent'))  
            ->add('statut')                         
            ->add('cotisation',null, [
                'header_style' => 'width: 8%; text-align: center',
                'row_align' => 'center; color:#000061;font:bold; font-size: 13pt'
            ])

            ->add('LicenceFFA', null, [
                'header_style' => 'width: 8%; text-align: center',
                'row_align' => 'center; color:#008000; font: bold; font-size: 13pt'
            ])

            //->add('InfoPilote')
            ->add('TarifInfoPilote', null, [
                'header_style' => 'width:8%; text-align: center',
                'row_align' => 'center; color:#240000;font:bold; font-size: 13pt'
            ]
            )
            ->add('getTotalCotisation', null, array('label' => 'Montant Total',
                                                    'header_style' => 'width: 8%; text-align: center; color:red;font:bold',
                                                    'row_align' => 'center; color:#610000;font:bold; font-size: 13pt'            
                                                    ))
                                                                
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
            //->add('id')
            //->add('annee', null, array('format'=>'d M y'))
            ->add('user', null, array('label' => 'Adhérent'))
            ->add('statut')
            ->add('InfoPilote', ChoiceType::class,[
				'choices' => [
					'Oui' => true,
					'Non' => false,
					],
				])
            //->add('cotisation')
            //->add('LicenceFFA')
            //->add('InfoPilote')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            //->add('id')
            ->add('annee',null, array('format'=>'Y')) //, DateTimeType::class, array('label'=>'Annee','format'=>'d M y'))                         
            ->add('user', null, array('label' => 'Adhérent'))
            ->add('statut')                         
            ->add('cotisation')
            ->add('LicenceFFA')
            //->add('InfoPilote')
            ->add('TarifInfoPilote')
            ->add('getTotalCotisation', null, array('label' => 'Montant Total')) 
            ;
    }

//    public function toString($object)
//    {
//        return $object instanceof MaCotisation
//            ? $object->getTitle()
//    
//            : 'Cotisation Par Adhérent'; // shown in the breadcrumb on the create view
//    }    
}
