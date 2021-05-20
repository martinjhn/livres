<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('email')
			->add('roles', ChoiceType::class, [ #mettre case à cocher
				'choices' => [
					'Utilisateur' => "ROLE_USER",
					'Administrateur' => "ROLE_ADMIN"
				],
				'expanded' => true,
				'multiple' => true,
				'label' => "Roles"
			])
			->add('password', PasswordType::class)
			->add('confirm', PasswordType::class)
			->add('nom')
			->add('prenom')
			->add('adresse')
			->add('tel');
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Utilisateur::class,
		]);
	}
}
