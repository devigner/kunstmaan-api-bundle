<?php

declare(strict_types=1);

/*
 * (c) Martijn van Beek <martijn.vanbeek@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\Pages;

use App\Entity\NewsAuthor;
use App\Entity\NewsComment;
use App\Entity\Tag;
use App\Entity\Theme;
use App\Entity\User\User;
use App\Form\Pages\NewsPageAdminType;
use App\Model;
use Devigner\KunstmaanApiBundle\Entity\PageModelInterface;
use Devigner\KunstmaanApiBundle\Model\ModelSchemaInterface;
use Devigner\KunstmaanApiBundle\Model\PageEntityInterface;
use Devigner\KunstmaanApiBundle\Model\UserContextInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\UserInterface;
use Kunstmaan\ArticleBundle\Entity\AbstractArticlePage;
use Kunstmaan\NodeBundle\Entity\Node;
use Kunstmaan\NodeSearchBundle\Helper\SearchTypeInterface;
use Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsPageRepository")
 * @ORM\Table(name="app_news_pages")
 * @ORM\HasLifecycleCallbacks
 */
class NewsPage extends AbstractArticlePage implements HasPageTemplateInterface, SearchTypeInterface, PageModelInterface, UserContextInterface
{
    /**
     * @var NewsAuthor
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\NewsAuthor")
     * @ORM\JoinColumn(name="news_author_id", referencedColumnName="id")
     */
    protected $author;

    /**
     * @var NewsComment[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\NewsComment", mappedBy="newsPage")
     */
    protected $comments;

    /**
     * @var Theme[]|Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Theme")
     * @ORM\JoinTable(name="app_news_page_theme",
     *   joinColumns={@ORM\JoinColumn(name="news_page_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="theme_id", referencedColumnName="id")}
     * )
     */
    protected $themes;

    /**
     * @var Tag[]|Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag")
     * @ORM\JoinTable(name="app_news_page_tags",
     *   joinColumns={@ORM\JoinColumn(name="news_page_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     * )
     */
    protected $tags;

    /**
     * @var User
     */
    private $user;

    public function __construct()
    {
        $this->themes = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    /**
     * @param NewsAuthor $author
     */
    public function setAuthor(?NewsAuthor $author): void
    {
        $this->author = $author;
    }

    /**
     * @return NewsAuthor $author
     */
    public function getAuthor(): ?NewsAuthor
    {
        return $this->author;
    }

    /**
     * @param Theme[]|Collection $category
     */
    public function setThemes(Collection $category): void
    {
        $this->themes = $category;
    }

    /**
     * @return Theme[]|Collection
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    /**
     * @param Tag[]|Collection $tag
     */
    public function setTags(Collection $tag): void
    {
        $this->tags = $tag;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * @return NewsComment[]|Collection
     */
    public function getComments(): ?Collection
    {
        if (!$this->user instanceof UserInterface) {
            return null;
        }

        return $this->comments;
    }

    /**
     * @param NewsComment[]|Collection $comments
     */
    public function setComments(Collection $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }

    /**
     * Returns the default backend form type for this page
     *
     * @return string
     */
    public function getDefaultAdminType(): string
    {
        return NewsPageAdminType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getSearchType(): string
    {
        return 'News';
    }

    /**
     * @return array
     */
    public function getPagePartAdminConfigurations(): array
    {
        return ['newsPage'];
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTemplates(): array
    {
        return ['newsTemplate'];
    }

    /**
     * Before persisting this entity, check the date.
     * When no date is present, fill in current date and time.
     *
     * @ORM\PrePersist
     */
    public function _prePersist(): void
    {
        // Set date to now when none is set
        if ($this->date == null) {
            $this->setDate(new \DateTime());
        }
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
        return new Model\Pages\NewsPage($this);
    }

    /**
     * @param PageModelInterface $entityModel
     * @param Node $node
     * @param string $locale
     * @return ModelSchemaInterface
     */
    public function getSchemaModel(PageModelInterface $entityModel, Node $node, string $locale): ModelSchemaInterface
    {
        return new Model\NewsSchema($entityModel, $node, $locale);
    }
}
