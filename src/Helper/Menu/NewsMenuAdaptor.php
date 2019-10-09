<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Devigner\KunstmaanApiBundle\Helper\Menu;

use Devigner\KunstmaanApiBundle\Entity\Pages\NewsOverviewPage;
use Devigner\KunstmaanApiBundle\Traits\EntityManagerTrait;
use Devigner\KunstmaanApiBundle\Traits\TranslatorTrait;
use Kunstmaan\AdminBundle\Helper\Menu\MenuAdaptorInterface;
use Kunstmaan\AdminBundle\Helper\Menu\MenuBuilder;
use Kunstmaan\AdminBundle\Helper\Menu\MenuItem;
use Kunstmaan\AdminBundle\Helper\Menu\TopMenuItem;
use Symfony\Component\HttpFoundation\Request;

class NewsMenuAdaptor implements MenuAdaptorInterface
{
    use TranslatorTrait;
    use EntityManagerTrait;

    /**
     * @var null|array
     */
    private $overviewpageIds = null;

    /**
     * @param MenuBuilder $menu
     * @param array $children
     * @param MenuItem|null $parent
     * @param Request|null $request
     */
    public function adaptChildren(MenuBuilder $menu, array &$children, MenuItem $parent = null, Request $request = null): void
    {
        if (!$parent instanceof MenuItem) {
            return;
        }

        if (!is_array($this->overviewpageIds)) {
            $overviewPageNodes = $this->entityManager->getRepository('KunstmaanNodeBundle:Node')->findByRefEntityName(NewsOverviewPage::class);
            $this->overviewpageIds = [];
            foreach ($overviewPageNodes as $overviewPageNode) {
                $this->overviewpageIds[] = $overviewPageNode->getId();
            }
        }

        $requestRoute = '';
        if ($request instanceof Request) {
            $requestRoute = $request->attributes->get('_route');
        }

        if ('KunstmaanAdminBundle_modules' === $parent->getRoute()) {
            // submenu

            $menuItem = $this->createMenuItem($menu, $parent, 'News');
            if (in_array($requestRoute, [
                'app_admin_blogitem',
                'app_admin_blogsubscription'
            ], true)) {
                $menuItem->setActive(true);
                $parent->setActive(true);
            }

            $children[] = $menuItem;
        }

        if ('news' === $parent->getUniqueId()) {
            $children[] = $this->createMenuItem($menu, $parent, 'news.menu.pages', $requestRoute, 'app_admin_pages_newspage');
            $children[] = $this->createMenuItem($menu, $parent, 'news.menu.author', $requestRoute, 'app_admin_newsauthor');
            $children[] = $this->createMenuItem($menu, $parent, 'news.menu.category', $requestRoute, 'app_admin_newscategory');
            $children[] = $this->createMenuItem($menu, $parent, 'news.menu.tag', $requestRoute, 'app_admin_newstag');
        }

        //don't load children
        if ('KunstmaanNodeBundle_nodes_edit' !== $parent->getRoute()) {
            return;
        }

        foreach ($children as $child) {
            if ('KunstmaanNodeBundle_nodes_edit' === $child->getRoute()) {
                $params = $child->getRouteParams();
                $id = $params['id'];
                if (in_array($id, $this->overviewpageIds, true)) {
                    $child->setChildren([]);
                }
            }
        }
    }

    /**
     * @param MenuBuilder $menu
     * @param MenuItem $parent
     * @param string $requestRoute
     * @param string $label
     * @param string $route
     * @return TopMenuItem
     */
    private function createMenuItem(MenuBuilder $menu, MenuItem $parent, string $label, ?string $requestRoute = null, ?string $route = null): TopMenuItem
    {
        $menuItem = new TopMenuItem($menu);
        if (null !== $route) {
            $menuItem->setRoute($route);
        }
        $menuItem->setLabel($this->translator->trans($label, [], 'kunstmaan'));
        $menuItem->setUniqueId(strtolower($label));
        $menuItem->setParent($parent);

        if (null === $requestRoute) {
            return $menuItem;
        }

        if (stripos($requestRoute, $menuItem->getRoute()) === 0) {
            $menuItem->setActive(true);
            $parent->setActive(true);
        }

        return $menuItem;
    }
}
