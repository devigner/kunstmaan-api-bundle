<?php declare(strict_types=1);

namespace Devigner\KunstmaanApiBundle\Model\Helper;

use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;
use Kunstmaan\SeoBundle\Entity;

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
