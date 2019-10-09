<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\PageParts;

use App\Form\PageParts\CheckboxPagePartAdminType;
use App\Model;
use ArrayObject;
use Devigner\KunstmaanApiBundle\Entity\PageParts\AbstractFormPagePart;
use Devigner\KunstmaanApiBundle\Entity\PagePartsModelInterface;
use Devigner\KunstmaanApiBundle\Model\PagePartsEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\FormBundle\Entity\FormSubmissionFieldTypes\BooleanFormSubmissionField;
use Kunstmaan\FormBundle\Form\BooleanFormSubmissionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_checkbox_page_parts")
 */
class CheckboxPagePart extends AbstractFormPagePart implements PagePartsModelInterface
{
    /**
     * Returns the frontend view
     *
     * @return string
     */
    public function getDefaultView(): string
    {
        return 'PageParts/CheckboxPagePart/view.html.twig';
    }

    /**
     * Modify the form with the fields of the current page part
     *
     * @param FormBuilderInterface $formBuilder The form builder
     * @param ArrayObject $fields The fields
     * @param int $sequence The sequence of the form field
     */
    public function adaptForm(FormBuilderInterface $formBuilder, ArrayObject $fields, $sequence): void
    {
        $bfsf = new BooleanFormSubmissionField();
        $bfsf->setFieldName('field_' . $this->getUniqueId());
        $bfsf->setLabel($this->getLabel());
        $bfsf->setInternalName($this->getInternalName());
        $bfsf->setSequence($sequence);

        $data = $formBuilder->getData();
        $data['formwidget_' . $this->getUniqueId()] = $bfsf;
        $constraints = [];
        if ($this->getRequired()) {
            $options = [];
            if (!empty($this->errorMessageRequired)) {
                $options['message'] = $this->errorMessageRequired;
            }
            $constraints[] = new NotBlank($options);
        }
        $formBuilder->add(
            'formwidget_' . $this->getUniqueId(),
            BooleanFormSubmissionType::class,
            [
                'label' => $this->getLabel(),
                'value_constraints' => $constraints,
                'required' => $this->getRequired()
            ]
        );
        $formBuilder->setData($data);

        $fields->append($bfsf);
    }

    /**
     * Returns the default backend form type for this page part
     *
     * @return string
     */
    public function getDefaultAdminType(): string
    {
        return CheckboxPagePartAdminType::class;
    }

    /**
     * @return PagePartsEntityInterface
     */
    public function getModel(): PagePartsEntityInterface
    {
        return new Model\PageParts\CheckboxPagePart($this);
    }
}
