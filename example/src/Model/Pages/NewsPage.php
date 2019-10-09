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
use DateTime;
use Devigner\KunstmaanApiBundle\Model\PageEntityInterface;
use Devigner\KunstmaanApiBundle\Model\Pages\AbstractPage;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
final class NewsPage extends AbstractPage implements PageEntityInterface
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
     * @var DateTime
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("DateTime")
     * @OA\Property(type="DateTime")
     */
    private $date;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $author;

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
     * @var array
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("array")
     * @OA\Property(type="array")
     */
    private $tags;

    /**
     * @var array
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("array")
     * @OA\Property(
     *   type="array",
     *   @OA\Items(
     *     ref="#/components/schemas/Theme"
     *   )
     * )
     */
    protected $themes;

    /**
     * @var array
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("array")
     * @OA\Property(
     *   type="array",
     *   @OA\Items(
     *     ref="#/components/schemas/NewsComment"
     *   )
     * )
     */
    protected $comments;

    /**
     * @param Pages\NewsPage $page
     */
    public function __construct(Pages\NewsPage $page)
    {
        $this->title = $page->getTitle();
        $this->pageTitle = $page->getPageTitle();
        $this->author = $page->getAuthor();
        $this->date = $page->getDate();

        foreach ($page->getThemes() as $theme) {
            $this->themes[] = $theme->getModel();
        }

        foreach ($page->getTags() as $tag) {
            $this->tags[] = $tag->getName();
        }

        if ($page->getComments() instanceof Collection) {
            foreach ($page->getComments() as $comment) {
                $this->comments[] = $comment->getModel();
            }
        }

        parent::__construct($page);
    }
}
