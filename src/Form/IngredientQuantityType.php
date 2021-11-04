<?php

namespace App\Form;

use App\Entity\IngredientQuantity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Form\IngredientType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class IngredientQuantityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity')
            // ->add('ingredients', CollectionType::class, [
            //     'entry_type' => IngredientType::class,
            //     'entry_options' => [
            //         'label' => false
            //     ],
            //     'allow_add' => true,
            //     'allow_delete' => true,
            //     'by_reference' => false
            // ])
            ->add('ingredients',EntityType::class,[
                'class' => Ingredient::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => IngredientQuantity::class,
        ]);
    }
}
