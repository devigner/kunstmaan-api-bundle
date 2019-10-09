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
final class HeaderPagePart extends AbstractPagePart implements PagePartsEntityInterface
{
    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $title;

    /**
     * @var int
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("int")
     * @OA\Property(type="integer")
     */
    private $niv;

    /**
     * @param PageParts\HeaderPagePart $pagePart
     */
    public function __construct(PageParts\HeaderPagePart $pagePart)
    {
        $this->title = $pagePart->getTitle();
        $this->niv = $pagePart->getNiv();

        parent::__construct($pagePart);
    }
}
