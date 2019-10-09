<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\PageParts;

use App\Form\PageParts\LinkPagePartAdminType;
use App\Model;
use Devigner\KunstmaanApiBundle\Entity\PageParts\AbstractPagePart;
use Devigner\KunstmaanApiBundle\Entity\PagePartsModelInterface;
use Devigner\KunstmaanApiBundle\Model\PagePartsEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="app_link_page_parts")
 * @ORM\Entity
 */
class LinkPagePart extends AbstractPagePart implements PagePartsModelInterface
{
    /**
     * @ORM\Column(name="url", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    private $url;

    /**
     * @ORM\Column(name="text", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    private $text;

    /**
     * @ORM\Column(name="open_in_new_window", type="boolean", nullable=true)
     */
    private $openInNewWindow;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return boolean
     */
    public function getOpenInNewWindow(): bool
    {
        return $this->openInNewWindow;
    }

    /**
     * @param boolean $openInNewWindow
     */
    public function setOpenInNewWindow(bool $openInNewWindow): void
    {
        $this->openInNewWindow = $openInNewWindow;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView(): string
    {
        return 'PageParts/LinkPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return string
     */
    public function getDefaultAdminType(): string
    {
        return LinkPagePartAdminType::class;
    }

    /**
     * @return PagePartsEntityInterface
     */
    public function getModel(): PagePartsEntityInterface
    {
        return new Model\PageParts\LinkPagePart($this);
    }
}
