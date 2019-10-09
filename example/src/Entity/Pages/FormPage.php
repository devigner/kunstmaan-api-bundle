<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\Pages;

use App\Form\Pages\FormPageAdminType;
use App\Model;
use Devigner\KunstmaanApiBundle\Entity\PageModelInterface;
use Devigner\KunstmaanApiBundle\Model\ModelSchemaInterface;
use Devigner\KunstmaanApiBundle\Model\PageEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\FormBundle\Entity\AbstractFormPage;
use Kunstmaan\NodeBundle\Entity\Node;
use Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface;

/**
 * @ORM\Table(name="app_form_pages")
 * @ORM\Entity
 */
class FormPage extends AbstractFormPage implements HasPageTemplateInterface, PageModelInterface
{
    /**
     * Returns the default backend form type for this page.
     *
     * @return string
     */
    public function getDefaultAdminType(): string
    {
        return FormPageAdminType::class;
    }

    /**
     * @return array
     */
    public function getPossibleChildTypes(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    public function getPagePartAdminConfigurations(): array
    {
        return ['formPage'];
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTemplates(): array
    {
        return ['formPageTemplate'];
    }

    /**
     * @return string
     */
    public function getDefaultView(): string
    {
        return 'Pages/FormPage/view.html.twig';
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
        return new Model\Pages\FormPage($this);
    }

    /**
     * @param PageModelInterface $entityModel
     * @param Node $node
     * @param string $locale
     * @return ModelSchemaInterface
     */
    public function getSchemaModel(PageModelInterface $entityModel, Node $node, string $locale): ModelSchemaInterface
    {
        return new Model\FormSchema($entityModel, $node, $locale);
    }
}
