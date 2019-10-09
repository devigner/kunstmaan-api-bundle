<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\PageParts;

use App\Form\PageParts\ChoicePagePartAdminType;
use App\Model;
use ArrayObject;
use Devigner\KunstmaanApiBundle\Entity\PageParts\AbstractFormPagePart;
use Devigner\KunstmaanApiBundle\Model\PagePartsEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\FormBundle\Entity\FormSubmissionFieldTypes\ChoiceFormSubmissionField;
use Kunstmaan\FormBundle\Form\ChoiceFormSubmissionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_choice_page_parts")
 */
class ChoicePagePart extends AbstractFormPagePart
{
    /**
     * If set to true, radio buttons or checkboxes will be rendered (depending on the multiple value). If false,
     * a select element will be rendered.
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $expanded = false;

    /**
     * If true, the user will be able to select multiple options (as opposed to choosing just one option).
     * Depending on the value of the expanded option, this will render either a select tag or checkboxes
     * if true and a select tag or radio buttons if false. The returned value will be an array.
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $multiple = false;

    /**
     * The choices that should be used by this field. The choices can be entered separated by a new line.
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $choices;

    /**
     * This option determines whether or not a special "empty" option (e.g. "Choose an option")
     * will appear at the top of a select widget. This option only applies if both the expanded and
     * multiple options are set to false.
     *
     * @ORM\Column(type="string", name="empty_value", nullable=true)
     */
    protected $emptyValue;

    /**
     * Returns the view used in the frontend
     *
     * @return string
     */
    public function getDefaultView(): string
    {
        return 'PageParts/ChoicePagePart/view.html.twig';
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
        $choices = explode("\n", $this->getChoices());
        $choices = array_map('trim', $choices);

        $cfsf = new ChoiceFormSubmissionField();
        $cfsf->setFieldName("field_" . $this->getUniqueId());
        $cfsf->setLabel($this->getLabel());
        $cfsf->setChoices($choices);
        $cfsf->setRequired($this->required);
        $cfsf->setSequence($sequence);
        $cfsf->setInternalName($this->getInternalName());

        $data = $formBuilder->getData();
        $data['formwidget_' . $this->getUniqueId()] = $cfsf;
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
            ChoiceFormSubmissionType::class,
            [
                'label' => $this->getLabel(),
                'required' => $this->getRequired(),
                'expanded' => $this->getExpanded(),
                'multiple' => $this->getMultiple(),
                'choices' => $choices,
                'placeholder' => $this->getEmptyValue(),
                'value_constraints' => $constraints,
            ]
        );
        $formBuilder->setData($data);

        $fields->append($cfsf);
    }

    /**
     * Get the current choices
     *
     * @return string Seperated by '\n'
     */
    public function getChoices(): ?string
    {
        return $this->choices;
    }

    /**
     * Set the choices for this pagepart
     *
     * @param string $choices Seperated by '\n'
     */
    public function setChoices(?string $choices): void
    {
        $this->choices = $choices;
    }

    /**
     * Get the expanded value
     *
     * @return bool
     */
    public function getExpanded(): ?bool
    {
        return $this->expanded;
    }

    /**
     * Set the expanded value, default this is false
     *
     * @param bool $expanded
     */
    public function setExpanded(?bool $expanded): void
    {
        $this->expanded = $expanded;
    }

    /**
     * Get the current multiple value
     *
     * @return boolean
     */
    public function getMultiple(): ?bool
    {
        return $this->multiple;
    }

    /**
     * Set the multple value, default this is false
     *
     * @param bool $multiple
     */
    public function setMultiple(?bool $multiple): void
    {
        $this->multiple = $multiple;
    }

    /**
     * Get emptyValue
     *
     * @return string
     */
    public function getEmptyValue(): ?string
    {
        return $this->emptyValue;
    }

    /**
     * Set emptyValue
     *
     * @param string $emptyValue
     */
    public function setEmptyValue(?string $emptyValue): void
    {
        $this->emptyValue = $emptyValue;
    }

    /**
     * Returns the default backend form type for this FormSubmissionField
     *
     * @return string
     */
    public function getDefaultAdminType(): string
    {
        return ChoicePagePartAdminType::class;
    }

    /**
     * @return PagePartsEntityInterface
     */
    public function getModel(): PagePartsEntityInterface
    {
        return new Model\PageParts\ChoicePagePart($this);
    }
}
