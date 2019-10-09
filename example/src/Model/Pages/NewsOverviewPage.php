<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Model\Pages;

use App\Entity\Pages;
use Devigner\KunstmaanApiBundle\Model\PageEntityInterface;
use Devigner\KunstmaanApiBundle\Model\Pages\AbstractPage;
use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
final class NewsOverviewPage extends AbstractPage implements PageEntityInterface
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
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $pageTitle;

    /**
     * @var array|NewsPage[]
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
    private $children;

    /**
     * @param Pages\NewsOverviewPage $page
     */
    public function __construct(Pages\NewsOverviewPage $page)
    {
        $this->title = $page->getTitle();
        $this->pageTitle = $page->getPageTitle();

        parent::__construct($page);
    }

    /**
     * @param string $namespace
     * @param array|NewsPage[] $children
     */
    public function setChildren(string $namespace, array $children): void
    {
        $this->children = $children;
    }
}
