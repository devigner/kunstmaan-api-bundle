<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Form\PageParts;

use App\Entity\PageParts\CheckboxPagePart;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * CheckboxPagePartAdminType
 */
class CheckboxPagePartAdminType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder The form builder
     * @param array $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'label',
                TextType::class,
                [
                    'label' => 'kuma_form.form.checkbox_page_part.label.label',
                    'required' => true,
                ]
            )
            ->add(
                'required',
                CheckboxType::class,
                [
                    'label' => 'kuma_form.form.checkbox_page_part.required.label',
                    'required' => false,
                ]
            )
            ->add(
                'errormessage_required',
                TextType::class,
                [
                    'label' => 'kuma_form.form.checkbox_page_part.errormessage_required.label',
                    'required' => false,
                ]
            )
            ->add(
                'internalName',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'kuma_form.form.form_page_part.internal_name',
                ]
            );
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'checkboxpageparttype';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => CheckboxPagePart::class,
            ]
        );
    }
}
