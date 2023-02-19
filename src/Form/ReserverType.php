<?php

namespace App\Form;

use App\Entity\Reserver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class ReserverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start', DateTimeType::class, ['date_widget' => 'single_text'])
            ->add('end', DateTimeType::class, ['date_widget' => 'single_text'])
            //->add('title')
            //->add('resourceId')
            //->add('reservataire')
            ->add('instructeur')
            ->add('avion')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reserver::class,
        ]);
    }
}
