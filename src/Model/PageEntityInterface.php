<?php declare(strict_types=1);

namespace Devigner\KunstmaanApiBundle\Model;

use Kunstmaan\NodeBundle\Entity\Node;

interface PageEntityInterface
{
    /**
     * @param array $pageParts
     * @param string $context
     */
    public function addParts(array $pageParts, string $context = 'main'): void;

    /**
     * @param Node $node
     * @param string $locale
     */
    public function addNode(Node $node, string $locale): void;

    /**
     * @param string $namespace
     * @param array $children
     */
    public function setChildren(string $namespace, array $children): void;
}
