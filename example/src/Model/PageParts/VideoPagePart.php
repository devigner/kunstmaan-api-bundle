<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Model\PageParts;

use App\Entity\PageParts;
use Devigner\KunstmaanApiBundle\Model\PageParts\AbstractPagePart;
use Devigner\KunstmaanApiBundle\Model\PagePartsEntityInterface;
use Devigner\KunstmaanApiBundle\Resolver\MediaResolver;
use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
final class VideoPagePart extends AbstractPagePart implements PagePartsEntityInterface
{
    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $caption;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $thumbnail;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $video;

    /**
     * @param PageParts\VideoPagePart $pagePart
     */
    public function __construct(PageParts\VideoPagePart $pagePart)
    {
        $this->caption = $pagePart->getCaption();
        $this->thumbnail = MediaResolver::createPublicUrl($pagePart->getThumbnail());
        $this->video = MediaResolver::createPublicUrl($pagePart->getVideo());

        parent::__construct($pagePart);
    }
}
