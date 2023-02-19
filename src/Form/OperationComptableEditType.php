<?php

namespace App\Form;

use App\Form\OperationComptableType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class OperationComptableEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->remove('CompteId', IntegerType::class, array('required' => false,
        'disabled' => true,
        ))
		
		->add('user', null, array('required' => false,'disabled' => false, ))

        ->remove('OperDate', DateType::class, array('required' => false,
        'disabled' => true,
        'label' => 'Date de Saisie',
    ))
    ->remove('OperMontant')
    ->remove('libelle')        
    ;
}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => OperationComptable::class,
        ));
    }
}            