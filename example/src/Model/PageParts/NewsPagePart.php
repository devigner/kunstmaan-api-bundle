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
final class NewsPagePart extends AbstractPagePart implements PagePartsEntityInterface
{
    /**
     * @var array
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("array")
     * @OA\Property(
     *   type="array",
     *   @OA\Items(
     *     ref="#/components/schemas/NewsPage"
     *   )
     * )
     */
    private $news;

    /**
     * @param PageParts\NewsPagePart $pagePart
     */
    public function __construct(PageParts\NewsPagePart $pagePart)
    {
        $this->news = [];
        foreach ($pagePart->getNewsPage() as $page) {
            $this->news[] = $page->getModel();
        }

        parent::__construct($pagePart);
    }
}
