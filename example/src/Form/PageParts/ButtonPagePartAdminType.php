<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Form\PageParts;

use App\Entity\PageParts\ButtonPagePart;
use Kunstmaan\NodeBundle\Form\Type\URLChooserType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * ButtonPagePartAdminType
 */
class ButtonPagePartAdminType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting form the
     * top most type. Type extensions can further modify the form.
     * @param FormBuilderInterface $builder The form builder
     * @param array $options The options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder->add('linkUrl', URLChooserType::class, [
            'required' => true
        ]);
        $builder->add('linkText', TextType::class, [
            'required' => true,
        ]);
        $builder->add('linkNewWindow', CheckboxType::class, [
            'required' => false,
        ]);
        $builder->add('type', ChoiceType::class, [
            'choices' => array_combine(ButtonPagePart::$types, ButtonPagePart::$types),
            'placeholder' => false,
            'required' => true,
        ]);
        $builder->add('size', ChoiceType::class, [
            'choices' => array_combine(ButtonPagePart::$sizes, ButtonPagePart::$sizes),
            'placeholder' => false,
            'required' => true,
        ]);
        $builder->add('position', ChoiceType::class, [
            'choices' => array_combine(ButtonPagePart::$positions, ButtonPagePart::$positions),
            'placeholder' => false,
            'required' => true,
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getBlockPrefix(): string
    {
        return 'buttonpageparttype';
    }

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ButtonPagePart::class,
        ]);
    }
}
