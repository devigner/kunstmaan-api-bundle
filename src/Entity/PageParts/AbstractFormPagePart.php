<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Devigner\KunstmaanApiBundle\Entity\PageParts;

use Devigner\KunstmaanApiBundle\Entity\FormModelInterface;
use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\FormBundle\Entity\PageParts\AbstractFormPagePart as KumaAbstractFormPagePart;

/**
 * Abstract version of a form page part
 */
abstract class AbstractFormPagePart extends KumaAbstractFormPagePart implements FormModelInterface
{
    /**
     * If set to true, you are obligated to fill in this page part
     *
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $required = false;

    /**
     * Internal name that can be used with form submission subscribers.
     *
     * @ORM\Column(type="string", name="internal_name", nullable=true)
     */
    protected $internalName;

    /**
     * Error message shows when the page part is required and nothing is filled in
     *
     * @ORM\Column(type="string", name="error_message_required", nullable=true)
     */
    protected $errorMessageRequired;

    /**
     * Sets the message shown when the page part is required and no value was entered
     *
     * @param string|null $errorMessageRequired
     */
    public function setErrorMessageRequired(?string $errorMessageRequired): void
    {
        $this->errorMessageRequired = $errorMessageRequired;
    }

    /**
     * Get the error message that will be shown when the page part is required and no value was entered
     *
     * @return string|null
     */
    public function getErrorMessageRequired(): ?string
    {
        return $this->errorMessageRequired;
    }

    /**
     * Sets the required valud of this page part
     *
     * @param bool $required
     */
    public function setRequired(?bool $required): void
    {
        $this->required = $required;
    }

    /**
     * Check if the page part is required
     *
     * @return bool
     */
    public function getRequired(): ?bool
    {
        return $this->required;
    }

    /**
     * @param string $internalName
     */
    public function setInternalName(?string $internalName): void
    {
        $this->internalName = $internalName;
    }

    /**
     * @return string
     */
    public function getInternalName(): ?string
    {
        return $this->internalName;
    }

    /**
     * Returns the view used in the backend
     *
     * @return string
     */
    public function getAdminView(): string
    {
        return 'PageParts/AbstractFormPagePart/admin-view.html.twig';
    }
}
