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
use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
final class LinkPagePart extends AbstractPagePart implements PagePartsEntityInterface
{
    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $url;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $text;

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
     * @param PageParts\LinkPagePart $pagePart
     */
    public function __construct(PageParts\LinkPagePart $pagePart)
    {
        $this->url = $pagePart->getUrl();
        $this->text = $pagePart->getText();
        $this->openInNewWindow = $pagePart->getOpenInNewWindow();

        parent::__construct($pagePart);
    }
}
