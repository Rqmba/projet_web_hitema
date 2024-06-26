<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Manga;
use App\Entity\Category;
use App\EventListener\ArticleTypeListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class ArticleType extends AbstractType
{
    public function __construct(readonly private ArticleTypeListener $articleTypeListener)
    {
        
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Title is required',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Title is too short',
                        'maxMessage' => 'Title is too long',
                    ]),
                ],
            ])
            ->add('picture', FileType::class, [
                'data_class' => null,
                'constraints' => $options['data']->getId() ? [] : [
                    new NotBlank([
                        'message' => 'Picture URL is required',
                    ]),
                    new Image([
                        'extensions' => ['jpeg', 'jpg', 'png', 'gif', 'webp', 'avif', 'svg'],
                        'extensionsMessage' => 'Extension of the file is not allowed',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif', 'application/svg+xml'],
                        'mimeTypesMessage' => 'Incorrect image format; Formats allowed : jpg, jpeg, png, gif, webp, avif and svg',
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Description is required',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Description is too short',
                    ]),
                ],
            ])
            ->add('price', MoneyType::class, [
                'currency' => 'EUR',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Price is required',
                    ]),
                ],
            ])
            ->add('quantityinStock', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Quantity in stock is required',
                    ]),
                ],
            ])
            ->add('releaseDate', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Release date is required',
                    ]),
                ],
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'En stock' => 1,
                    'Rupture de stock' => 0,
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Status is required',
                    ]),
                ],
            ])
            ->add('manga', EntityType::class, [
                'class' => Manga::class,
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Manga is required',
                    ]),
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Category is required',
                    ]),
                ],
            ])
        ;

        // $builder->addEventListener(FormEvents::POST_SET_DATA, [ 
        //     $this->articleTypeListener, 'postSetData'
        //  ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
