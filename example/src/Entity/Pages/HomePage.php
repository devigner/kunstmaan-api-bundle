<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\Pages;

use App\Form\Pages\HomePageAdminType;
use App\Model;
use Devigner\KunstmaanApiBundle\Entity\PageModelInterface;
use Devigner\KunstmaanApiBundle\Model\ModelSchemaInterface;
use Devigner\KunstmaanApiBundle\Model\PageEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\NodeBundle\Entity\AbstractPage;
use Kunstmaan\NodeBundle\Entity\HomePageInterface;
use Kunstmaan\NodeBundle\Entity\Node;
use Kunstmaan\NodeSearchBundle\Helper\SearchTypeInterface;
use Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="app_home_pages")
 */
class HomePage extends AbstractPage implements HasPageTemplateInterface, SearchTypeInterface, HomePageInterface, PageModelInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDefaultAdminType(): string
    {
        return HomePageAdminType::class;
    }

    /**
     * @return array
     */
    public function getPossibleChildTypes(): array
    {
        return [
            [
                'name' => 'Pagina',
                'class' => ContentPage::class
            ],
            [
                'name' => 'Formulier',
                'class' => FormPage::class
            ],
            [
                'name' => 'Nieuws overzicht',
                'class' => NewsOverviewPage::class
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function getPagePartAdminConfigurations(): array
    {
        return ['homePage', 'main'];
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTemplates(): array
    {
        return ['homePageTemplate'];
    }

    /**
     * @return string
     */
    public function getDefaultView(): string
    {
        return 'Pages/HomePage/view.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function getSearchType(): string
    {
        return 'Home';
    }

    /**
     * @return array|null
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
        return new Model\Pages\HomePage($this);
    }

    /**
     * @param PageModelInterface $entityModel
     * @param Node $node
     * @param string $locale
     * @return ModelSchemaInterface
     */
    public function getSchemaModel(PageModelInterface $entityModel, Node $node, string $locale): ModelSchemaInterface
    {
        return new Model\HomeSchema($entityModel, $node, $locale);
    }
}
