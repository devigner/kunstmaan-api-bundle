<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\PageParts;

use App\Form\PageParts\SubmitButtonPagePartAdminType;
use Devigner\KunstmaanApiBundle\Entity\PageParts\AbstractPagePart;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_submit_button_page_parts")
 */
class SubmitButtonPagePart extends AbstractPagePart
{
    /**
     * The label on the submit button
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $label;

    /**
     * Get the label used for this page part
     *
     * @return string
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Set the label used for this page part
     *
     * @param string $label
     */
    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    /**
     * Return a string representation of this page part
     *
     * @return string
     */
    public function __toString(): string
    {
        return 'SubmitButtonPagePart';
    }

    /**
     * Return the frontend view
     *
     * @return string
     */
    public function getDefaultView(): string
    {
        return 'PageParts/SubmitButtonPagePart/view.html.twig';
    }

    /**
     * Return the backend view
     *
     * @return string
     */
    public function getAdminView(): string
    {
        return 'PageParts/SubmitButtonPagePart/admin-view.html.twig';
    }

    /**
     * Returns the default form type for this FormSubmissionField
     *
     * @return string
     */
    public function getDefaultAdminType(): string
    {
        return SubmitButtonPagePartAdminType::class;
    }
}
