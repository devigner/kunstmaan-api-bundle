<?php declare(strict_types=1);

namespace Devigner\KunstmaanApiBundle\Model\Pages;

use App\Model\Pages\NewsPage;
use JMS\Serializer\Annotation as JMS;
use Kunstmaan\NodeBundle\Entity\Node;
use Kunstmaan\NodeBundle\Entity\NodeTranslation;
use OpenApi\Annotations as OA;
use Devigner\KunstmaanApiBundle\Entity\PageModelInterface;

abstract class AbstractPage
{
    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $slug;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("string")
     * @OA\Property(type="string")
     */
    private $type;

    /**
     * @var array
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("array")
     * @OA\Property(
     *   type="array",
     *   @OA\Items(type="object")
     * )
     */
    private $parts;

    /**
     * @param PageModelInterface $pagePart
     */
    public function __construct(PageModelInterface $pagePart)
    {
        try {
            $this->type = (new \ReflectionClass(get_called_class()))->getShortName();
        } catch (\ReflectionException $e) {
        }
    }

    /**
     * @param array $pageParts
     * @param string $context
     */
    public function addParts(array $pageParts, string $context = 'main'): void
    {
        if (!is_array($this->parts)) {
            $this->parts = [];
        }

        if (!isset($this->parts[$context])) {
            $this->parts[$context] = [];
        }

        foreach ($pageParts as $pagePart) {
            $this->parts[$context][] = $pagePart;
        }
    }

    /**
     * @param Node $node
     * @param string $locale
     */
    public function addNode(Node $node, string $locale): void
    {
        $nodeTranslation = $node->getNodeTranslation($locale);
        if (!$nodeTranslation instanceof NodeTranslation) {
            return;
        }

        $this->slug = sprintf('/%s/%s', $locale, $nodeTranslation->getUrl());
    }

    /**
     * @param string $namespace
     * @param array|NewsPage[] $children
     */
    public function setChildren(string $namespace, array $children): void
    {
        $this->children = $children;
    }
}
