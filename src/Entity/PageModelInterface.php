<?php declare(strict_types=1);

namespace Devigner\KunstmaanApiBundle\Entity;

use Devigner\KunstmaanApiBundle\Model;
use Kunstmaan\NodeBundle\Entity\Node;

interface PageModelInterface
{
    /**
     * @return array
     */
    public function getSerializeGroups(): ?array;

    /**
     * @return Model\PageEntityInterface
     */
    public function getModel(): Model\PageEntityInterface;

    /**
     * @param PageModelInterface $entityModel
     * @param Node $node
     * @param string $locale
     * @return Model\ModelSchemaInterface
     */
    public function getSchemaModel(PageModelInterface $entityModel, Node $node, string $locale): Model\ModelSchemaInterface;
}
