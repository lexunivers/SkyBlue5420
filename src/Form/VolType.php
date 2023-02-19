<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class VolType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('datevol', DateType::class, [
                    'attr' => array(
                    'placeholder' => 'Cliquez  pour le Calendrier',
                    ),

                    'years' => range(2020, 2023),
                    'widget' => 'single_text',
                    'html5' => false,
                    'format' => 'dd/MM/yyyy',
                      
                    ])
            
                ->add('user', null, array('required' => false,'disabled' => true,))
                ->add('avion', null, array('placeholder' => 'Quel Appareil ?'))
                ->add('typevol', null, array('placeholder' => 'Choisissez !'))
                ->add('instructeur', null, array('placeholder' => 'Si Vol Ecole'))
                ->add('naturevol', null, array('placeholder' => 'Pour les Stats !'))
                ->add('lieuDepart', null, array('placeholder' => 'Décollage de'))
                ->add('heureDepart')
																
                ->add('lieuArrivee', null, array('placeholder' => 'Atterissage à'))
                ->add('heureArrivee')
                ->add('valider', SubmitType::class, array('label' => 'Valider'))
                
                ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Vol'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_entity_vol';
    }
}
