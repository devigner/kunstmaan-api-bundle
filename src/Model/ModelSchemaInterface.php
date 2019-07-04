<?php declare(strict_types=1);

namespace Devigner\KunstmaanApiBundle\Model;

use Kunstmaan\PagePartBundle\Helper\PagePartInterface;
use Kunstmaan\SeoBundle\Entity\Seo as SeoEntity;

interface ModelSchemaInterface
{
    /**
     * @param SeoEntity $seoEntity
     */
    public function setSeo(SeoEntity $seoEntity): void;

    /**
     * @param string $name
     * @param array $menu
     * @param string $locale
     */
    public function addMenu(string $name, array $menu, string $locale): void;

    /**
     * @param array|PagePartInterface[] $pageParts
     * @param string $context
     */
    public function addParts(array $pageParts, string $context = 'main'): void;
}
