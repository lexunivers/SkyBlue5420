<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sonata\AdminBundle\Form\Type\ModelType;
//use Sonata\AdminBundle\Admin\FieldDescriptionInterface;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;

final class CotisationClubAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            //->add('id')
            ->add('annee')
            ->add('statut')
			->add('Montantclub')
            ->add('LicenceFFA')
            ->add('InfoPilote')
            ->add('validation')            
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            //->add('id')
            ->add('annee')
            ->add('statut')
			->add('Montantclub')
            ->add('LicenceFFA')
            ->add('InfoPilote')
            ->add('validation', FieldDescriptionInterface::TYPE_BOOLEAN, ['label' =>'Validé ? ','editable' => true])
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
            ->add('annee')
            ->add('statut', TextType::class)
			->add('Montantclub', IntegerType::class)
            ->add('LicenceFFA', IntegerType::class)
            ->add('InfoPilote', IntegerType::class)
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            //->add('id')
            ->add('annee')
            ->add('statut' )
			->add('Montantclub')
            ->add('LicenceFFA')
            ->add('InfoPilote')
            ->add('validation', FieldDescriptionInterface::TYPE_BOOLEAN, ['label' =>'Validé ? ','editable' => true])			
            ;
    }
}
