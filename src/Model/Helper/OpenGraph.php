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
final class OpenGraph
{
    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $ogType;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $ogTitle;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $ogDescription;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $ogImage;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $ogUrl;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $ogArticleAuthor;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $ogArticlePublisher;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $ogArticleSection;

    /**
     * @param Entity\Seo $seo
     */
    public function __construct(Entity\Seo $seo)
    {
        $this->ogType = $seo->getOgType();
        $this->ogTitle = $seo->getOgTitle();
        $this->ogDescription = $seo->getOgDescription();
        $this->ogImage = $seo->getOgImage();
        $this->ogUrl = $seo->getOgUrl();
        $this->ogArticleAuthor = $seo->getOgArticleAuthor();
        $this->ogArticlePublisher = $seo->getOgArticlePublisher();
        $this->ogArticleSection = $seo->getOgArticleSection();
    }
}
