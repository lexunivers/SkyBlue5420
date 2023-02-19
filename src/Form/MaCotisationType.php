<?php

namespace App\Form;

use App\Entity\MaCotisation;
use App\Entity\CotisationClub;
//use App\Form\CotisationClub;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



use Doctrine\ORM\EntityRepository;

class MaCotisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		
		$validation = $options['validation'];
		
        $builder
            //->add('cotisation')
            //->add('LicenceFFA')
            //->add('annee')
            ->add('user', null, array('required' => false,'disabled' => true, 'label' =>'Adhérent'))
			
			->add('statut', EntityType::class, [
							'class' => CotisationClub::class,
							'query_builder' => function (EntityRepository $er) {
								return $er->createQueryBuilder('c')
									->where('c.validation = 1')
									->orderBy('c.id', 'ASC')
									;
							},
							'choice_label' => 'statut',
						]
				)
						
			->add('InfoPilote', ChoiceType::class,[
				'choices' => [
					'Oui' => true,
					'Non' => false,
					],
				])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MaCotisation::class,
			'validation' => null,
        ]);
    }
}
