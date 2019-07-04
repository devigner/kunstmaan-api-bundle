<?php declare(strict_types=1);

namespace Devigner\KunstmaanApiBundle\Model\Helper;

use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
final class Menu
{
    /**
     * @var array
     *
     * @JMS\Expose()
     * @JMS\Groups({"always"})
     * @JMS\Type("array")
     */
    private $children;

    /**
     * @var string
     *
     * @JMS\Exclude()
     */
    private $locale;

    /**
     * @param array $nodeMenu
     * @param string $locale
     */
    public function __construct(array $nodeMenu, string $locale)
    {
        $this->locale = $locale;
        $this->children = $this->loopChildren($nodeMenu);
    }

    /**
     * @param array $nodeMenu
     * @return array
     */
    private function loopChildren(array $nodeMenu): array
    {
        $subMenu = [];
        $menu = [];
        foreach ($nodeMenu as $menuItem) {
            $item = [
                'slug' => sprintf('/%s/%s', $this->locale, $menuItem['nodeTranslation']['slug']),
                'title' => $menuItem['nodeTranslation']['title'],
                'id' => (int)$menuItem['id'],
            ];

            if (isset($menuItem['parent'])) {
                $item['parentId'] = (int)$menuItem['parent']['id'];
                $subMenu[] = $item;
            } else {
                $menu[] = $item;
            }
        }

        foreach ($subMenu as $subMenuItem) {
            $menu = $this->searchParent($subMenuItem, $menu);
        }

        return $menu;
    }

    /**
     * @param array $subMenuItem
     * @param array $context
     * @return array
     */
    private function searchParent(array $subMenuItem, array $context): array
    {
        foreach ($context as $key => $menuItem) {
            if ($context[$key]['id'] === $subMenuItem['parentId']) {
                unset($subMenuItem['parentId']);
                $context[$key]['children'][] = $subMenuItem;
                return $context;
            }

            if (isset($context[$key]['children'])) {
                $context[$key]['children'] = $this->searchParent($subMenuItem, $context[$key]['children']);
            }
        }

        return $context;
    }
}
