<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\RecurringTransaction;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecurringTransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value')
            ->add('name')
            ->add('startDate')
            ->add('frequencyInMonths')
            ->add('isIncome')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => function(Category $category): string {
                    return $category->getSymbol() . ' ' . $category->getName();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecurringTransaction::class,
        ]);
    }
}
