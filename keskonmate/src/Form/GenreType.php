<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Series;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('series', EntityType::class, [
                'class' => Series::class,
                'label' => false,
                'multiple' => true,
                'expanded' => false,
            ])
            ->add('createdAt', DateTimeType::class, [
                'label' => 'Cree le:',
                'input'  => 'datetime_immutable',
                'disabled' => 'disabled'
            ])
            ->add('updatedAt', DateTimeType::class, [
                'label' => 'Mis a jour le:',
                'input'  => 'datetime_immutable',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Genre::class,
        ]);
    }
}
