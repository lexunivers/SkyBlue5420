<?php

namespace App\Form;

use App\Entity\OperationComptable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class OperationComptableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('CompteId', IntegerType::class, array('required' => false,
                'disabled' => true,
            ))
            ->add('user', null, array('required' => false,'disabled' => true,))
            ->add('OperDate', DateType::class, array('required' => false,
                'disabled' => true,
                'label' => 'Date de Saisie',
            ))
            ->add('OperMontant')
            //->add('OperSensMt')
            ->add('libelle')
            ->add('valider', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => OperationComptable::class,
        ));
    }
}
