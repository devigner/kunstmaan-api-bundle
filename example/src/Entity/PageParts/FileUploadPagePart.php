<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\PageParts;

use App\Form\PageParts\FileUploadPagePartAdminType;
use App\Model;
use ArrayObject;
use Devigner\KunstmaanApiBundle\Entity\PageParts\AbstractFormPagePart;
use Devigner\KunstmaanApiBundle\Model\PagePartsEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\FormBundle\Entity\FormSubmissionFieldTypes\FileFormSubmissionField;
use Kunstmaan\FormBundle\Form\FileFormSubmissionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_file_upload_page_parts")
 */
class FileUploadPagePart extends AbstractFormPagePart
{
    /**
     * Modify the form with the fields of the current page part
     *
     * @param FormBuilderInterface $formBuilder The form builder
     * @param ArrayObject $fields The fields
     * @param int $sequence The sequence of the form field
     */
    public function adaptForm(FormBuilderInterface $formBuilder, ArrayObject $fields, $sequence): void
    {
        $ffsf = new FileFormSubmissionField();
        $ffsf->setFieldName('field_' . $this->getUniqueId());
        $ffsf->setLabel($this->getLabel());
        $ffsf->setSequence($sequence);
        $ffsf->setInternalName($this->getInternalName());

        $data = $formBuilder->getData();
        $data['formwidget_' . $this->getUniqueId()] = $ffsf;

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
            FileFormSubmissionType::class,
            [
                'label' => $this->getLabel(),
                'value_constraints' => $constraints,
                'required' => $this->getRequired()
            ]
        );
        $formBuilder->setData($data);

        $fields->append($ffsf);
    }

    /**
     * Returns the view used in the frontend
     *
     * @return mixed
     */
    public function getDefaultView(): string
    {
        return 'PageParts/FileUploadPagePart/view.html.twig';
    }

    /**
     * Returns the default backend form type for this page part
     *
     * @return string
     */
    public function getDefaultAdminType(): string
    {
        return FileUploadPagePartAdminType::class;
    }

    /**
     * @return PagePartsEntityInterface
     */
    public function getModel(): PagePartsEntityInterface
    {
        return new Model\PageParts\FileUploadPagePart($this);
    }
}
