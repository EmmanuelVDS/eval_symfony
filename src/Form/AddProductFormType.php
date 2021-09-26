<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;

class AddProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du produit',
                'constraints' => [
                    new NotBlank()
                ]
            ])

            ->add('Description', TextType::class, [
                'label' => 'Description',
                'constraints' => [
                    new NotBlank()
                ]
            ])

            ->add('price', NumberType::class, [
                'label' => 'Prix',
                'constraints' => [
                    new NotBlank(),
                    new NotNull(),
                    new Positive()
                ]
            ])

            ->add('image', TextType::class, [
                'label' => 'Fichier image',
                'constraints' => [
                    new NotBlank()
                ]
            ])

            ->add('isActive', CheckboxType::class, [
                'label' => 'Mettre en vente ce produit immédiatement',
                'required' => false
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter un produit'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}