<?php
// src/App/Form/ProfileEditType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\User;

class ProfileEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->remove('password')
				->remove('imageName')
        ;
    }

    public function getParent()
    {
        return ProfileType::class;
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }
}
