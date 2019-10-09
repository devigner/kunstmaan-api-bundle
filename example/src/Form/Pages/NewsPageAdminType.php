<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Form\Pages;

use App\Entity\Pages\NewsPage;
use App\Entity\Tag;
use App\Entity\Theme;
use Doctrine\ORM\EntityRepository;
use Kunstmaan\ArticleBundle\Form\AbstractArticlePageAdminType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * The admin type for News pages
 */
class NewsPageAdminType extends AbstractArticlePageAdminType
{
    /**
     * Builds the form.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder->add('author');
        $builder->add('themes', EntityType::class, [
            'class' => Theme::class,
            'choice_label' => 'name',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('t')
                    ->orderBy('t.name', 'ASC');
            },
            'multiple' => true,
            'expanded' => false,
            'attr' => [
                'class' => 'js-advanced-select',
                'data-placeholder' => 'Choose the related categories'
            ],
            'required' => false
        ]);
        $builder->add('tags', EntityType::class, [
            'class' => Tag::class,
            'choice_label' => 'name',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('t')
                    ->orderBy('t.name', 'ASC');
            },
            'multiple' => true,
            'expanded' => false,
            'attr' => [
                'class' => 'js-advanced-select',
                'data-placeholder' => 'Choose the related tags'
            ],
            'required' => false
        ]);
    }

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NewsPage::class
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'news_page_type';
    }
}
