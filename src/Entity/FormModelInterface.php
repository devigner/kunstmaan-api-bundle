<?php declare(strict_types=1);

namespace Devigner\KunstmaanApiBundle\Entity;

interface FormModelInterface extends PagePartsModelInterface
{
    /**
     * @return string
     */
    public function getErrorMessageRequired(): ?string;

    /**
     * @return bool
     */
    public function getRequired(): ?bool;

    /**
     * @return string
     */
    public function getInternalName(): ?string;

    /**
     * Kunstmaan\FormBundle\Entity\PageParts\AbstractFormPagePart does not add :string to label
     *
     * @return string
     */
    public function getLabel();
}
