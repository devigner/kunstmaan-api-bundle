<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\Pages;

use App\Entity\MaxResultsTrait;
use App\Form\Pages\NewsOverviewPageAdminType;
use App\Model;
use App\Provider\NewsEntityInjectionProvider;
use Devigner\KunstmaanApiBundle\Entity\EntityInjectionInterface;
use Devigner\KunstmaanApiBundle\Entity\PageModelInterface;
use Devigner\KunstmaanApiBundle\Model\ModelSchemaInterface;
use Devigner\KunstmaanApiBundle\Model\PageEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\NodeBundle\Entity\AbstractPage;
use Kunstmaan\NodeBundle\Entity\Node;
use Kunstmaan\NodeSearchBundle\Helper\SearchTypeInterface;
use Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface;
use Kunstmaan\PagePartBundle\PagePartAdmin\AbstractPagePartAdminConfigurator;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsOverviewPageRepository")
 * @ORM\Table(name="app_news_overview_pages")
 */
class NewsOverviewPage extends AbstractPage implements HasPageTemplateInterface, SearchTypeInterface, PageModelInterface, EntityInjectionInterface
{
    use MaxResultsTrait;

    /**
     * @return array
     */
    public function getPossibleChildTypes(): array
    {
        return [];
    }

    /**
     * @return AbstractPagePartAdminConfigurator[]
     */
    public function getPagePartAdminConfigurations(): array
    {
        return ['newsoverview'];
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTemplates(): array
    {
        return ['newsoverviewTemplate'];
    }

    /**
     * {@inheritdoc}
     */
    public function getSearchType(): string
    {
        return 'News';
    }

    /**
     * Returns the default backend form type for this page
     *
     * @return string
     */
    public function getDefaultAdminType(): string
    {
        return NewsOverviewPageAdminType::class;
    }

    /**
     * @return array
     */
    public function getSerializeGroups(): ?array
    {
        return ['always'];
    }

    /**
     * @return PageEntityInterface
     */
    public function getModel(): PageEntityInterface
    {
        return new Model\Pages\NewsOverviewPage($this);
    }

    /**
     * @param PageModelInterface $entityModel
     * @param Node $node
     * @param string $locale
     * @return ModelSchemaInterface
     */
    public function getSchemaModel(PageModelInterface $entityModel, Node $node, string $locale): ModelSchemaInterface
    {
        return new Model\NewsOverviewSchema($entityModel, $node, $locale);
    }

    /**
     * @return string[]|array
     */
    public function getProvider(): array
    {
        return [NewsEntityInjectionProvider::class];
    }
}
