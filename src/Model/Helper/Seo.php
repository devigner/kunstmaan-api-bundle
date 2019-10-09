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
final class Seo
{
    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $refId;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $refEntityName;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $metaTitle;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $metaDescription;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $metaAuthor;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $metaRobots;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $extraMetadata;

    /**
     * @var OpenGraph
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("Devigner\KunstmaanApiBundle\Model\Helper\OpenGraph")
     * @OA\Property(ref="#/components/schemas/OpenGraph")
     */
    private $openGraph;

    /**
     * @var Twitter
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("Devigner\KunstmaanApiBundle\Model\Helper\Twitter")
     * @OA\Property(ref="#/components/schemas/Twitter")
     */
    private $twitter;

    /**
     * @param Entity\Seo $seo
     */
    public function __construct(Entity\Seo $seo)
    {
        //$this->refId = $seo->getRefId();
        //$this->refEntityName = $seo->getRefEntityName();
        $this->metaTitle = $seo->getMetaTitle();
        $this->metaDescription = $seo->getMetaDescription();
        $this->metaAuthor = $seo->getMetaAuthor();
        $this->metaRobots = $seo->getMetaRobots();
        $this->extraMetadata = $seo->getExtraMetadata();
        $this->openGraph = new OpenGraph($seo);
        $this->twitter = new Twitter($seo);
    }
}
