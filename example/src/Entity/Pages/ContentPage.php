<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\Pages;

use App\Form\Pages\ContentPageAdminType;
use App\Model;
use Devigner\KunstmaanApiBundle\Entity\PageModelInterface;
use Devigner\KunstmaanApiBundle\Model\ModelSchemaInterface;
use Devigner\KunstmaanApiBundle\Model\PageEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\NodeBundle\Entity\AbstractPage;
use Kunstmaan\NodeBundle\Entity\Node;
use Kunstmaan\NodeSearchBundle\Helper\SearchTypeInterface;
use Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="app_content_pages")
 */
class ContentPage extends AbstractPage implements HasPageTemplateInterface, SearchTypeInterface, PageModelInterface
{
    /**
     * Returns the default backend form type for this page
     *
     * @return string
     */
    public function getDefaultAdminType(): string
    {
        return ContentPageAdminType::class;
    }

    /**
     * @return array
     */
    public function getPossibleChildTypes(): array
    {
        return [
            [
                'name' => 'ContentPage',
                'class' => self::class
            ],
            [
                'name' => 'FormPage',
                'class' => FormPage::class
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getSearchType(): string
    {
        return 'Page';
    }

    /**
     * @return string[]
     */
    public function getPagePartAdminConfigurations(): array
    {
        return ['main'];
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTemplates(): array
    {
        return ['contentPageTemplate'];
    }

    /**
     * @return string
     */
    public function getDefaultView(): string
    {
        return 'Pages/ContentPage/view.html.twig';
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
        return new Model\Pages\ContentPage($this);
    }

    /**
     * @param PageModelInterface $entityModel
     * @param Node $node
     * @param string $locale
     * @return ModelSchemaInterface
     */
    public function getSchemaModel(PageModelInterface $entityModel, Node $node, string $locale): ModelSchemaInterface
    {
        return new Model\ContentSchema($entityModel, $node, $locale);
    }
}
