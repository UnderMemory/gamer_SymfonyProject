<?php

namespace App\Form;

use App\Entity\Jeux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JeuxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                "label" => "Entrez le nom du jeu",
                'label_attr'=> ['class'=> 'label'],
                "empty_data" => "",
                "attr" => [
                    "placeholder" => "Nom",
                    "class" => "text-field"
                ]
            ])
            ->add('description', TextareaType::class, [
                "label" => "Entrez la description du jeu",
                'label_attr'=> ['class'=> 'label'],
                "empty_data" => "",
                "attr" => [
                    "placeholder" => "Description",
                    "class" => "text-field"
                ]
            ])
            ->add('imageFile', FileType::class, [
                "label" => "Photo",
                "required" => false,
                'label_attr'=> ['class'=> 'label'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Jeux::class,
        ]);
    }
}
