<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\PageParts;

use App\Form\PageParts\DownloadPagePartAdminType;
use App\Model;
use Devigner\KunstmaanApiBundle\Entity\PageParts\AbstractPagePart;
use Devigner\KunstmaanApiBundle\Entity\PagePartsModelInterface;
use Devigner\KunstmaanApiBundle\Model\PagePartsEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\MediaBundle\Entity\Media;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_download_page_parts")
 */
class DownloadPagePart extends AbstractPagePart implements PagePartsModelInterface
{
    /**
     * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     */
    protected $media;

    /**
     * Get media
     *
     * @return Media
     */
    public function getMedia(): ?Media
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
     * @return string
     */
    public function getDefaultView(): string
    {
        return 'PageParts/DownloadPagePart/view.html.twig';
    }

    /**
     * @return string
     */
    public function getDefaultAdminType(): string
    {
        return DownloadPagePartAdminType::class;
    }

    /**
     * @return PagePartsEntityInterface
     */
    public function getModel(): PagePartsEntityInterface
    {
        return new Model\PageParts\DownloadPagePart($this);
    }
}
