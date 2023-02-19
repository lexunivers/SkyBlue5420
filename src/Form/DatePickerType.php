<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DatePickerType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'widget' => 'single_text',
            'years' => range(1950,2030),
            'dp_min_date' => '1-1-1900',
            'dp_max_date' => '1-1-2029',
            'html5' => true,
        ]);
    }

    public function getParent()
    {
        return DateType::class;
    }

}