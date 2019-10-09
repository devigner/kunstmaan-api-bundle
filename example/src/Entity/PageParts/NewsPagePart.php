<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\PageParts;

use App\Entity\Pages\NewsPage;
use App\Form\PageParts\NewsPagePartAdminType;
use App\Model;
use Devigner\KunstmaanApiBundle\Entity\PageParts\AbstractPagePart;
use Devigner\KunstmaanApiBundle\Entity\PagePartsModelInterface;
use Devigner\KunstmaanApiBundle\Model\PagePartsEntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="app_news_page_parts")
 * @ORM\Entity
 */
class NewsPagePart extends AbstractPagePart implements PagePartsModelInterface
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var Collection|NewsPage[]
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Pages\NewsPage")
     * @ORM\JoinTable(name="app_news_page_part_news_page",
     *   joinColumns={@ORM\JoinColumn(name="news_page_part_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="news_page_id", referencedColumnName="id")}
     * )
     */
    private $newsPage;

    public function __construct()
    {
        $this->newsPage = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title = null): void
    {
        $this->title = $title;
    }

    /**
     * @param NewsPage $newsPage
     */
    public function addNewsPage(NewsPage $newsPage): void
    {
        $this->newsPage[] = $newsPage;
    }

    /**
     * @param NewsPage $newsPage
     *
     * @return bool
     */
    public function removeNewsPage(NewsPage $newsPage): bool
    {
        return $this->newsPage->removeElement($newsPage);
    }

    /**
     * @return Collection|NewsPage[]
     */
    public function getNewsPage(): Collection
    {
        return $this->newsPage;
    }

    /**
     * @return string
     */
    public function getDefaultView(): string
    {
        return 'PageParts/NewsPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return string
     */
    public function getDefaultAdminType(): string
    {
        return NewsPagePartAdminType::class;
    }

    /**
     * @return PagePartsEntityInterface
     */
    public function getModel(): PagePartsEntityInterface
    {
        return new Model\PageParts\NewsPagePart($this);
    }
}
