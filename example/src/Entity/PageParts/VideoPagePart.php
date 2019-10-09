<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\PageParts;

use App\Form\PageParts\VideoPagePartAdminType;
use App\Model;
use Devigner\KunstmaanApiBundle\Entity\PageParts\AbstractPagePart;
use Devigner\KunstmaanApiBundle\Entity\PagePartsModelInterface;
use Devigner\KunstmaanApiBundle\Model\PagePartsEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\MediaBundle\Entity\Media;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_video_page_parts")
 */
class VideoPagePart extends AbstractPagePart implements PagePartsModelInterface
{
    /**
     * @var Media
     *
     * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="video_media_id", referencedColumnName="id")
     * @Assert\NotNull()
     */
    protected $video;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="caption", nullable=true)
     */
    protected $caption;

    /**
     * @var Media
     *
     * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="thumbnail_media_id", referencedColumnName="id")
     * })
     */
    protected $thumbnail;

    /**
     * @return string
     */
    public function getCaption(): ?string
    {
        return $this->caption;
    }

    /**
     * @param string $caption
     */
    public function setCaption(string $caption): void
    {
        $this->caption = $caption;
    }

    /**
     * @return Media
     */
    public function getThumbnail(): ?Media
    {
        return $this->thumbnail;
    }

    /**
     * @param Media $thumbnail
     */
    public function setThumbnail(Media $thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return Media
     */
    public function getVideo(): ?Media
    {
        return $this->video;
    }

    /**
     * @param Media $video
     */
    public function setVideo(Media $video): void
    {
        $this->video = $video;
    }

    /**
     * @return string
     */
    public function getDefaultView(): string
    {
        return 'PageParts/VideoPagePart/view.html.twig';
    }

    /**
     * @return string
     */
    public function getDefaultAdminType(): string
    {
        return VideoPagePartAdminType::class;
    }

    /**
     * @return PagePartsEntityInterface
     */
    public function getModel(): PagePartsEntityInterface
    {
        return new Model\PageParts\VideoPagePart($this);
    }
}
