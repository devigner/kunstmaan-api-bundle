<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Devigner\KunstmaanApiBundle\Model;

use Devigner\KunstmaanApiBundle\Model\Helper;
use JMS\Serializer\Annotation as JMS;
use Kunstmaan\SeoBundle\Entity\Seo as SeoEntity;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
abstract class AbstractJsonApi implements ModelInjectionInterface
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
     *     ref="#/components/schemas/Links"
     *   )
     * )
     */
    protected $links;

    /**
     * @var array
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("array")
     * @OA\Property(
     *   type="array",
     *   @OA\Items(
     *     ref="#/components/schemas/Menu"
     *   )
     * )
     */
    protected $menu;

    /**
     * @var Helper\Seo
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("Devigner\KunstmaanApiBundle\Model\Helper\Seo")
     * @OA\Property(ref="#/components/schemas/Seo")
     */
    protected $seo;

    /**
     * @var PageEntityInterface
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("Devigner\KunstmaanApiBundle\Model\PageEntityInterface")
     */
    protected $data;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    protected $type;

    public function __construct()
    {
        try {
            $this->type = (new \ReflectionClass(get_called_class()))->getShortName();
        } catch (\ReflectionException $e) {
        }
    }

    /**
     * @param PageEntityInterface $entity
     */
    public function addData(PageEntityInterface $entity): void
    {
        $this->data = $entity;
    }

    /**
     * @param string $namespace
     * @param string $self
     * @param string $last
     * @param string|null $next
     */
    public function setLinks(string $namespace, string $self, string $last, ?string $next = null): void
    {
        $this->links[$namespace] = new Helper\Links($self, $last, $next);
    }

    /**
     * @param string $namespace
     * @param array $children
     */
    public function setChildren(string $namespace, array $children): void
    {
        $this->data->setChildren($namespace, $children);
    }

    /**
     * @param SeoEntity $seoEntity
     */
    public function setSeo(SeoEntity $seoEntity): void
    {
        $this->seo = new Helper\Seo($seoEntity);
    }

    /**
     * @param string $name
     * @param array $menu
     * @param string $locale
     */
    public function addMenu(string $name, array $menu, string $locale): void
    {
        if (0 === count($menu)) {
            return;
        }

        $this->menu[$name] = new Helper\Menu($menu, $locale);
    }

    /**
     * @param array $pageParts
     * @param string $context
     */
    public function addParts(array $pageParts, string $context = 'main'): void
    {
        $this->data->addParts($pageParts, $context);
    }
}
