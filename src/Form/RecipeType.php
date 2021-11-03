<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\IngredientQuantity;
use App\Entity\Recipe;
use App\Entity\Step;
use App\Entity\User;
use App\Form\IngredientQuantityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('preparationTime')
            ->add('cookingTime')
            // ->add('users', CollectionType::class, ['entry_type' => User::class])
            // ->add('comments', CollectionType::class, ['entry_type' => Comment::class])
            // ->add('steps', CollectionType::class, ['entry_type' => Step::class])
            ->add('ingredientQuantities', CollectionType::class, [
                'entry_type' => IngredientQuantityType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
