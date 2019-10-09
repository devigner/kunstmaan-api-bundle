<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\PageParts;

use App\Form\PageParts\EmailPagePartAdminType;
use App\Model;
use ArrayObject;
use Devigner\KunstmaanApiBundle\Entity\PageParts\AbstractFormPagePart;
use Devigner\KunstmaanApiBundle\Model\PagePartsEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\FormBundle\Entity\FormSubmissionFieldTypes\EmailFormSubmissionField;
use Kunstmaan\FormBundle\Form\EmailFormSubmissionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_email_page_parts")
 */
class EmailPagePart extends AbstractFormPagePart
{
    /**
     * Error message shows when the value is invalid
     *
     * @ORM\Column(type="string", name="error_message_invalid", nullable=true)
     */
    protected $errorMessageInvalid;

    /**
     * Returns the frontend view
     *
     * @return string
     */
    public function getDefaultView(): string
    {
        return 'PageParts/EmailPagePart/view.html.twig';
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
        $efsf = new EmailFormSubmissionField();
        $efsf->setFieldName("field_" . $this->getUniqueId());
        $efsf->setLabel($this->getLabel());
        $efsf->setSequence($sequence);
        $efsf->setInternalName($this->getInternalName());

        $data = $formBuilder->getData();
        $data['formwidget_' . $this->getUniqueId()] = $efsf;

        $constraints = [];
        if ($this->getRequired()) {
            $options = [];
            if (!empty($this->errorMessageRequired)) {
                $options['message'] = $this->errorMessageRequired;
            }
            $constraints[] = new NotBlank($options);
        }
        $options = [];
        if (!empty($this->errorMessageInvalid)) {
            $options['message'] = $this->getErrorMessageInvalid();
        }
        $constraints[] = new Email($options);

        $formBuilder->add(
            'formwidget_' . $this->getUniqueId(),
            EmailFormSubmissionType::class,
            [
                'label' => $this->getLabel(),
                'value_constraints' => $constraints,
                'required' => $this->getRequired()
            ]
        );
        $formBuilder->setData($data);

        $fields->append($efsf);
    }

    /**
     * Get the error message that will be shown when the value is invalid
     *
     * @return string
     */
    public function getErrorMessageInvalid(): string
    {
        return $this->errorMessageInvalid;
    }

    /**
     * Sets the message shown when the value is invalid
     *
     * @param string $errorMessageInvalid
     */
    public function setErrorMessageInvalid(string $errorMessageInvalid): void
    {
        $this->errorMessageInvalid = $errorMessageInvalid;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultAdminType(): string
    {
        return EmailPagePartAdminType::class;
    }

    /**
     * @return PagePartsEntityInterface
     */
    public function getModel(): PagePartsEntityInterface
    {
        return new Model\PageParts\EmailPagePart($this);
    }
}
