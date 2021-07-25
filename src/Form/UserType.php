<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                "label" => "Choisissez un pseudo unique",
                "empty_data" => "",
                "attr" => [
                    "placeholder" => "Entrez votre pseudo ici"
                ]
            ])
            ->add('mail', EmailType::class, [
                "label" => "Entrez votre mail",
                "empty_data" => "",
                "attr" => [
                    "placeholder" => "Entrez votre mail ici"
                ]
            ])
            ->add('mdp', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Choisissez un mot de passe'],
                'second_options' => ['label' => 'Repetez votre mot de passe']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
