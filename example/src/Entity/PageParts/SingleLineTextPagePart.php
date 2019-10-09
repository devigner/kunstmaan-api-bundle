<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\PageParts;

use App\Form\PageParts\SingleLineTextPagePartAdminType;
use App\Model;
use ArrayObject;
use Devigner\KunstmaanApiBundle\Entity\PageParts\AbstractFormPagePart;
use Devigner\KunstmaanApiBundle\Model\PagePartsEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\FormBundle\Entity\FormSubmissionFieldTypes\StringFormSubmissionField;
use Kunstmaan\FormBundle\Form\StringFormSubmissionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_single_line_text_page_parts")
 */
class SingleLineTextPagePart extends AbstractFormPagePart
{
    /**
     * If set the entered value will be matched with this regular expression
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $regex;

    /**
     * If a regular expression is set and it doesn't match with the given value, this error message will be shown
     *
     * @ORM\Column(type="string", name="error_message_regex", nullable=true)
     */
    protected $errorMessageRegex;

    /**
     * Get the current error message which will be shown when the entered value doesn't match the regular expression
     *
     * @return string
     */
    public function getErrorMessageRegex(): ?string
    {
        return $this->errorMessageRegex;
    }

    /**
     * Set the error message which will be shown when the entered value doesn't match the regular expression
     *
     * @param string $errorMessageRegex
     */
    public function setErrorMessageRegex(?string $errorMessageRegex): void
    {
        $this->errorMessageRegex = $errorMessageRegex;
    }

    /**
     * Returns the frontend view
     *
     * @return string
     */
    public function getDefaultView(): string
    {
        return 'PageParts/SingleLineTextPagePart/view.html.twig';
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
        $sfsf = new StringFormSubmissionField();
        $sfsf->setFieldName('field_' . $this->getUniqueId());
        $sfsf->setLabel($this->getLabel());
        $sfsf->setInternalName($this->getInternalName());
        $sfsf->setSequence($sequence);

        $data = $formBuilder->getData();
        $data['formwidget_' . $this->getUniqueId()] = $sfsf;

        $constraints = [];
        if ($this->getRequired()) {
            $options = [];
            if (!empty($this->errorMessageRequired)) {
                $options['message'] = $this->errorMessageRequired;
            }
            $constraints[] = new NotBlank($options);
        }
        if ($this->getRegex()) {
            $options = ['pattern' => $this->getRegex()];
            if (!empty($this->errorMessageRegex)) {
                $options['message'] = $this->errorMessageRegex;
            }
            $constraints[] = new Regex($options);
        }

        $formBuilder->add(
            'formwidget_' . $this->getUniqueId(),
            StringFormSubmissionType::class,
            [
                'label' => $this->getLabel(),
                'value_constraints' => $constraints,
                'required' => $this->getRequired()
            ]
        );
        $formBuilder->setData($data);

        $fields->append($sfsf);
    }

    /**
     * Get the current regular expression
     *
     * @return string
     */
    public function getRegex(): ?string
    {
        return $this->regex;
    }

    /**
     * Set the regular expression to match the entered value against
     *
     * @param string $regex
     */
    public function setRegex(?string $regex): void
    {
        $this->regex = $regex;
    }

    /**
     * Returns the default backend form type for this page part
     *
     * @return string
     */
    public function getDefaultAdminType(): string
    {
        return SingleLineTextPagePartAdminType::class;
    }

    /**
     * @return PagePartsEntityInterface
     */
    public function getModel(): PagePartsEntityInterface
    {
        return new Model\PageParts\SingleLineTextPagePart($this);
    }
}
