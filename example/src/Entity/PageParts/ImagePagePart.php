<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\PageParts;

use App\Form\PageParts\ImagePagePartAdminType;
use App\Model;
use Devigner\KunstmaanApiBundle\Entity\PageParts\AbstractPagePart;
use Devigner\KunstmaanApiBundle\Entity\PagePartsModelInterface;
use Devigner\KunstmaanApiBundle\Model\PagePartsEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\MediaBundle\Entity\Media;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_image_page_parts")
 */
class ImagePagePart extends AbstractPagePart implements PagePartsModelInterface
{
    /**
     * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     * @Assert\NotNull()
     */
    private $media;

    /**
     * @ORM\Column(type="string", name="caption", nullable=true)
     */
    private $caption;

    /**
     * @ORM\Column(type="string", name="alt_text", nullable=true)
     */
    private $altText;

    /**
     * @ORM\Column(name="link", type="string", nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(name="open_in_new_window", type="boolean", nullable=true)
     */
    private $openInNewWindow;

    /**
     * Get open in new window
     *
     * @return bool
     */
    public function getOpenInNewWindow(): bool
    {
        return $this->openInNewWindow;
    }

    /**
     * Set open in new window
     *
     * @param bool $openInNewWindow
     */
    public function setOpenInNewWindow(bool $openInNewWindow): void
    {
        $this->openInNewWindow = $openInNewWindow;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * Set link
     *
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * Get alt text
     *
     * @return string
     */
    public function getAltText(): string
    {
        return $this->altText;
    }

    /**
     * Set alt text
     *
     * @param string $altText
     */
    public function setAltText(string $altText): void
    {
        $this->altText = $altText;
    }

    /**
     * Get media
     *
     * @return Media
     */
    public function getMedia(): Media
    {
        return $this->media;
    }

    /**
     * Set media
     *
     * @param Media $media
     */
    public function setMedia(Media $media): void
    {
        $this->media = $media;
    }

    /**
     * Get caption
     *
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    /**
     * Set caption
     *
     * @param string $caption
     */
    public function setCaption(string $caption): void
    {
        $this->caption = $caption;
    }

    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView(): string
    {
        return 'PageParts/ImagePagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return string
     */
    public function getDefaultAdminType(): string
    {
        return ImagePagePartAdminType::class;
    }

    /**
     * @return PagePartsEntityInterface
     */
    public function getModel(): PagePartsEntityInterface
    {
        return new Model\PageParts\ImagePagePart($this);
    }
}
