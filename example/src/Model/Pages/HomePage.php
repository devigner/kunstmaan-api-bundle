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
final class HomePage extends AbstractPage implements PageEntityInterface
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
     * @param Pages\HomePage $page
     */
    public function __construct(Pages\HomePage $page)
    {
        $this->title = $page->getTitle();
        $this->pageTitle = $page->getPageTitle();

        parent::__construct($page);
    }
}
