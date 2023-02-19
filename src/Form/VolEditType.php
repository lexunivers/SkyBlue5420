<?php
// src/Sky/GestionVolBundle/Form/VolEditType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class VolEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateOper', null, array('required' => false,
                  'disabled'=> true,
                  'label' 	=> 'Date de Saisie',
            ))
            ->add('facture')

            ->add('valider', SubmitType::class, array('label' => 'Confirmer'))
            ;
    }

    public function getParent()
    {
        return VolType::class;
    }
}
