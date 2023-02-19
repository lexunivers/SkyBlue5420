<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use App\Entity\Reserver;

final class ReserverAdmin extends AbstractAdmin
{

   // protected function configureDashboardActions(array $actions): array
   // {
    //    $actions['Grille'] = [
    //        'label'              => 'Grille',
    //        'url'                => $this->generateUrl('list'),
            //'icon'               => 'import',
            //'translation_domain' => 'SonataAdminBundle', // optional
            //'template'           => '@SonataAdmin/CRUD/dashboard__action.html.twig', // optional
    //    ];

    //   return $actions;
   //}



    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('start')
            ->add('end')
            ->add('title')
            ->add('resourceId')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('start')
            ->add('end')
            ->add('title')
            ->add('resourceId')
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
            ->add('start')
            ->add('end')
            ->add('title')
            ->add('resourceId')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            //->add('id')
            ->add('start')
            ->add('end')
            ->add('title')
            ->add('resourceId')
            ;
    }

    public function toString($object): string
    {
        return $object instanceof Reserver
            ? $object->getTitle()
            : 'Reservation'; // shown in the breadcrumb on the create view
    }    
}
