<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ReserverEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->remove('start', null, ['label' => 'Début'])
            ->remove('end', null, ['label' => 'Fin'])
            //->add('title')
            //->add('resourceId')
            ->add('formateur')
            ->add('instructeur', null, array('placeholder' => 'Vol Solo',
											'empty_data' => 'Default value'))
            ->remove('avion')
			
        ;
    }

    public function getParent()
    {
        return ReserverType::class;
    }
}
