<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Manga;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('query', SearchType::class, [
                'label' => 'Recherche',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Recherche un produit...',
                ]
            ])
            // ->add('title')
            // ->add('slug')
            // ->add('picture')
            // ->add('description')
            // ->add('price')
            // ->add('quantityinStock')
            // // ->add('releaseDate', null, [
            // //     'widget' => 'single_text',
            // // ])
            // // ->add('statut')
            // ->add('manga', EntityType::class, [
            //     'class' => Manga::class,
            //     'choice_label' => 'id',
            // ])
            // ->add('category', EntityType::class, [
            //     'class' => Category::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
