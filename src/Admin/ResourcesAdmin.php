<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Form\Type\ModelListType;

final class ResourcesAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('title')
            ->add('type')
            ->add('marque')
            ->add('eventColor')
            //->add('immatriculation')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
			->add('title', TextType::class, ['label' => 'Immatriculation'])
            ->add('type')
            ->add('marque')
            ->add('eventColor')
			//->add('ResourcesId')
			//->add('avions')
            //->add('immatriculation')
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
			->add('title', TextType::class, ['label' => 'Immatriculation', 'required' => true])
            ->add('type')
            ->add('marque')
            ->add('eventColor')
			//->add('ResourcesId')
            //->add('immatriculation', EntityType::class, ['label'=>'Immatriculation',
            //                                     'class' => 'App\Entity\Avions',
            //                                     'property_path'=>'immatriculation',
			//									 'required' => true ])
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('title')
            ->add('type')
            ->add('marque')
            ->add('eventColor')
			//->add('ResourcesId')
			//->add('avions')
            //->add('immatriculation')
            ;
    }
}
