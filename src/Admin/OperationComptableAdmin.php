<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

final class OperationComptableAdmin extends AbstractAdmin
{

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->add('CpteSolo');//, $this->getRouterIdParameter().'/CpteSolo');
            //->add('CompteId');    
        }


    protected function configureDashboardActions(array $actions): array
    {
        $actions[''] = [
            'label'              => 'Cptes Individuels',
            'url'                => $this->generateUrl('CpteSolo'),
            'icon'               => '',
            //'translation_domain' => 'SonataAdminBundle', // optional
            //'template'           => '@SonataAdmin/CRUD/dashboard__action.html.twig', // optional
        ];

        return $actions;
    }



    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('CompteId')
            ->add('OperDate')
            ->add('OperMontant')
            ->add('OperSensMt')
            ->add('Libelle')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('CompteId')
            ->add('OperDate')
            ->add('OperMontant')
            ->add('OperSensMt')
            ->add('Libelle')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],

            ]]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('id')
            ->add('CompteId')
            ->add('OperDate')
            ->add('OperMontant')
            ->add('OperSensMt')
            ->add('Libelle')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('CompteId')
            ->add('OperDate')
            ->add('OperMontant')
            ->add('OperSensMt')
            ->add('Libelle')
            ;
    }
}
