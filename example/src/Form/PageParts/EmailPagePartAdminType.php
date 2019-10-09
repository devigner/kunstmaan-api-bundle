<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Form\PageParts;

use App\Entity\PageParts\EmailPagePart;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * EmailPagePartAdminType
 */
class EmailPagePartAdminType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'label',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'kuma_form.form.email_page_part.label.label',
                ]
            )
            ->add(
                'required',
                CheckboxType::class,
                [
                    'required' => false,
                    'label' => 'kuma_form.form.email_page_part.required.label',
                ]
            )
            ->add(
                'errorMessageRequired',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'kuma_form.form.email_page_part.errorMessageRequired.label',
                ]
            )
            ->add(
                'errorMessageInvalid',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'kuma_form.form.email_page_part.errorMessageInvalid.label',
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
        return 'emailpageparttype';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => EmailPagePart::class,
            ]
        );
    }
}
