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
final class ImagePagePart extends AbstractPagePart implements PagePartsEntityInterface
{
    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $media;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $altText;

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
    private $link;

    /**
     * @var bool
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("bool")
     * @OA\Property(type="bool")
     */
    private $openInNewWindow;

    /**
     * @param PageParts\ImagePagePart $pagePart
     */
    public function __construct(PageParts\ImagePagePart $pagePart)
    {
        $this->media = MediaResolver::createPublicUrl($pagePart->getMedia());
        $this->altText = $pagePart->getAltText();
        $this->caption = $pagePart->getCaption();
        $this->link = $pagePart->getLink();
        $this->openInNewWindow = $pagePart->getOpenInNewWindow();

        parent::__construct($pagePart);
    }
}
