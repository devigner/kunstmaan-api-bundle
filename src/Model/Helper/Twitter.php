<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Devigner\KunstmaanApiBundle\Model\Helper;

use JMS\Serializer\Annotation as JMS;
use Kunstmaan\SeoBundle\Entity;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
final class Twitter
{
    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $twitterTitle;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $twitterDescription;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $twitterSite;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $twitterCreator;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $twitterImage;

    /**
     * @param Entity\Seo $seo
     */
    public function __construct(Entity\Seo $seo)
    {
        $this->twitterTitle = $seo->getTwitterTitle();
        $this->twitterDescription = $seo->getTwitterDescription();
        $this->twitterSite = $seo->getTwitterSite();
        $this->twitterCreator = $seo->getTwitterCreator();
        $this->twitterImage = $seo->getTwitterImage();
    }
}
